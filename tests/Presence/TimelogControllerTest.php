<?php

namespace Tests\Presence;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TimelogControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * +-------------------------------------------+
     * | POSITIVE TEST | GET /api/presence/time-in |
     * +-------------------------------------------+
     */
    public function it_should_return_success_when_creating_time_in()
    {
        $this->login();

        $response = $this->post('/api/presence/time-in', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);
        $this->assertArrayHasKey('title', $content_array);
        $this->assertArrayHasKey('text', $content_array);
        $this->assertArrayHasKey('timelog_id', $content_array);

        $this->assertEquals(201, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }

    /**
     * @test
     *
     * +-------------------------------------------+
     * | POSITIVE TEST | GET /api/presence/time-in |
     * +-------------------------------------------+
     */
    public function it_should_return_error_if_token_cant_be_created()
    {
        $response = $this->post('/api/presence/time-in', ['HTTP_Authorization' => 'Bearer'])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(401, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }

    /**
     * @test
     *
     * +-------------------------------------------------+
     * | POSITIVE TEST | GET /api/presence/alert/time-in |
     * +-------------------------------------------------+
     */
    public function it_should_return_success_message_if_no_timein_found_in_database()
    {

        $this->login();

        $response = $this->get('/api/presence/alert/time-in', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);
        $this->assertArrayHasKey('title', $content_array);
        $this->assertArrayHasKey('html', $content_array);
        $this->assertArrayHasKey('showCancelButton', $content_array);
        $this->assertArrayHasKey('confirmButtonColor', $content_array);
        $this->assertArrayHasKey('closeOnConfirm', $content_array);

        $this->assertEquals(200, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }
}
