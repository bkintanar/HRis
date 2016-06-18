<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
 */

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class LookupTableControllerTest extends TestCase
{
    use DatabaseTransactions;

    public $end_points = [
        'cities?province_id=1&',
        'countries?',
        'departments?',
        'education-levels?',
        'employment-statuses?',
        'job-titles?',
        'locations?',
        'marital-statuses?',
        'nationalities?',
        'provinces?',
        'relationships?',
        'skills?',
        'screens?',
        'types?',
    ];

    /**
     * @test
     *
     * +----------------------------+
     * | POSITIVE TEST | GET /api/* |
     * +----------------------------+
     */
    public function it_should_return_a_chosen_list_if_get_is_successful()
    {
        foreach ($this->end_points as $end_point) {
            $this->login();

            $response = $this->get('/api/'.$end_point, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

            $content = $response->getContent();
            $status_code = $response->getStatusCode();

            $content_array = json_decode($content, true);

            $this->assertArrayHasKey('chosen', $content_array);
            $this->assertArrayHasKey('message', $content_array);
            $this->assertArrayHasKey('status_code', $content_array);

            $this->assertEquals(200, $status_code);
            $this->assertEquals($status_code, $content_array['status_code']);
        }
    }

    /**
     * @test
     *
     * +----------------------------+
     * | POSITIVE TEST | GET /api/* |
     * +----------------------------+
     */
    public function it_should_return_a_table_view_if_get_is_successful()
    {
        foreach ($this->end_points as $end_point) {
            $this->login();

            $response = $this->get('/api/'.$end_point.'table_view=true', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

            $content = $response->getContent();
            $status_code = $response->getStatusCode();

            $content_array = json_decode($content, true);

            $this->assertArrayHasKey('data', $content_array);
            $this->assertArrayHasKey('message', $content_array);
            $this->assertArrayHasKey('status_code', $content_array);

            $this->assertEquals(200, $status_code);
            $this->assertEquals($status_code, $content_array['status_code']);
        }
    }

    /**
     * @test
     *
     * +---------------------------------+
     * | NEGATIVE TEST | GET /api/cities |
     * +---------------------------------+
     */
    public function it_should_return_an_error_if_get_is_unsuccessful()
    {
        $end_points = [
            'cities',
            'cities?table_view=true',
        ];

        foreach ($end_points as $end_point) {
            $this->login();

            $response = $this->get('/api/'.$end_point, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

            $content = $response->getContent();
            $status_code = $response->getStatusCode();

            $content_array = json_decode($content, true);

            $this->assertArrayHasKey('message', $content_array);
            $this->assertArrayHasKey('status_code', $content_array);

            $this->assertEquals(404, $status_code);
            $this->assertEquals($status_code, $content_array['status_code']);
        }
    }
}
