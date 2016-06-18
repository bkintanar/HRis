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

namespace Tests\PIM\Configuration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CustomFieldsControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $custom_field = [
        'name'                 => 'custom_field_name_',
        'type_id'              => 2,
        'required'             => true,
        'custom_field_options' => 'option1, option2',
    ];

    protected $custom_field_section = [
        'name'      => 'custom_field_section_name_',
        'screen_id' => 3,
    ];

    /**
     * @test
     *
     * +-----------------------------------------------------------+
     * | POSITIVE TEST | POST /api/pim/configuration/custom-fields |
     * +-----------------------------------------------------------+
     */
    public function it_should_return_an_custom_field_object_if_post_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('custom_field', $content_array);

        $custom_field = $content_array['custom_field'];

        $this->assertArrayHasKey('name', $custom_field);
        $this->assertArrayHasKey('id', $custom_field);

        $this->assertEquals(201, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }

    /**
     * @test
     *
     * +-----------------------------------------------------------+
     * | NEGATIVE TEST | POST /api/pim/configuration/custom-fields |
     * +-----------------------------------------------------------+
     */
    public function it_should_return_an_error_if_post_is_unsuccessful()
    {
        $this->login();

        $response = $this->post('/api/pim/configuration/custom-fields', [], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(422, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }

    /**
     * @test
     *
     * +------------------------------------------------------------+
     * | NEGATIVE TEST | PATCH /api/pim/configuration/custom-fields |
     * +------------------------------------------------------------+
     */
    public function it_should_return_an_error_if_custom_field_doesnt_exist()
    {
        $this->login();

        $data = $this->custom_field;

        $response = $this->patch('/api/pim/configuration/custom-fields', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(404, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }

    /**
     * @test
     *
     * +------------------------------------------------------------+
     * | POSITIVE TEST | PATCH /api/pim/configuration/custom-fields |
     * +------------------------------------------------------------+
     */
    public function it_should_return_a_success_message_if_patch_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['custom_field']['id'];

        $data = $this->custom_field;
        $data['name'] = 'custom_field_name_'.$this->str_rand();
        $data['custom_field_id'] = $id;
        $data['custom_field_options'] = 'a, b, c, d, e';

        $response = $this->patch('/api/pim/configuration/custom-fields', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(200, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }

    /**
     * @test
     * @depends it_should_return_an_custom_field_object_if_post_is_successful
     *
     * +-------------------------------------------------------------+
     * | POSITIVE TEST | DELETE /api/pim/configuration/custom-fields |
     * +-------------------------------------------------------------+
     */
    public function it_should_return_a_success_message_if_delete_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['custom_field']['id'];

        $response = $this->delete('/api/pim/configuration/custom-fields/'.$id, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(200, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }

    /**
     * @test
     *
     * +----------------------------------------------------------+
     * | POSITIVE TEST | GET /api/pim/configuration/custom-fields |
     * +----------------------------------------------------------+
     */
    public function it_should_return_a_response_if_fetching_of_data_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $response = $this->get('/api/pim/configuration/custom-fields?custom_field_section_id='.$content_array['custom_field']['custom_field_section_id'], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('data', $content_array);
        $this->assertArrayHasKey('table', $content_array);

        $data = $content_array['data'];
        $table = $content_array['table'];

        $this->assertArrayHasKey('total', $data);
        $this->assertArrayHasKey('per_page', $data);
        $this->assertArrayHasKey('current_page', $data);
        $this->assertArrayHasKey('last_page', $data);
        $this->assertArrayHasKey('next_page_url', $data);
        $this->assertArrayHasKey('prev_page_url', $data);
        $this->assertArrayHasKey('from', $data);
        $this->assertArrayHasKey('to', $data);
        $this->assertArrayHasKey('data', $data);

        $this->assertArrayHasKey('title', $table);
        $this->assertArrayHasKey('permission', $table);
        $this->assertArrayHasKey('headers', $table);
        $this->assertArrayHasKey('model', $table);
        $this->assertArrayHasKey('items', $table);

        $this->assertEquals($table['items'], $data);

        $this->assertEquals(200, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals(SUCCESS_RETRIEVE_MESSAGE, $content_array['message']);
    }

    /**
     * @test
     *
     * +-------------------------------------------------------------+
     * | NEGATIVE TEST | DELETE /api/pim/configuration/custom-fields |
     * +-------------------------------------------------------------+
     */
    public function it_should_return_an_error_if_delete_fails()
    {
        $this->login();

        $response = $this->delete('/api/pim/configuration/custom-fields/100', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(422, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals(UNPROCESSABLE_ENTITY, $content_array['message']);
    }

    /**
     * @test
     *
     * +--------------------------------------------------------------------------------------+
     * | NEGATIVE TEST | GET /api/pim/configuration/custom-fields?custom_field_section_id=100 |
     * +--------------------------------------------------------------------------------------+
     */
    public function it_should_return_an_error_if_get_fails()
    {
        $this->login();

        $response = $this->get('/api/pim/configuration/custom-fields?custom_field_section_id=100', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(404, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }

    /**
     * @test
     *
     * +------------------------------------------------------------+
     * | NEGATIVE TEST | PATCH /api/pim/configuration/custom-fields |
     * +------------------------------------------------------------+
     */
    public function it_should_return_an_error_if_update_fails()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['custom_field']['id'];

        $data = $this->custom_field;
        $data['name'] = 'custom_field_name_'.$this->str_rand();
        $data['custom_field_id'] = $id;

        $this->renameTable('custom_fields', 'custom_fields_test');

        $response = $this->patch('/api/pim/configuration/custom-fields', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(422, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->renameTable('custom_fields_test', 'custom_fields');
    }

    /**
     * @test
     *
     * +-----------------------------------------------------------+
     * | POSITIVE TEST | POST /api/pim/configuration/custom-fields |
     * +-----------------------------------------------------------+
     */
    public function it_should_return_a_response_if_fetching_by_screen_id_is_successful()
    {
        $this->login();

        $this->_insert_record();
        $this->_insert_record();

        $response = $this->post('/api/pim/configuration/custom-field-sections-by-screen-id', ['screen_name' => 'Personal Details'], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertEquals(200, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals(SUCCESS_RETRIEVE_MESSAGE, $content_array['message']);
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    protected function _insert_record()
    {
        $this->login();

        $response = $this->_insert_custom_field_section();

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('custom_field_section', $content_array);

        $this->assertEquals(201, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $data = $this->custom_field;
        $data['name'] .= $this->str_rand();
        $data['custom_field_section_id'] = $content_array['custom_field_section']['id'];

        return $this->post('/api/pim/configuration/custom-fields', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;
    }

    protected function _insert_custom_field_section()
    {
        $this->login();

        $data = $this->custom_field_section;
        $data['name'] .= $this->str_rand();
        $data['screen_id'] = 3;

        return $this->post('/api/pim/configuration/custom-field-sections', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;
    }
}
