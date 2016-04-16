<?php

namespace Tests\PIM\Configuration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TerminationReasonsControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $class_name = 'HRis\Api\Eloquent\TerminationReason';

    protected $termination_reason = [
        'name' => 'termination_reason_name_',
    ];

    /**
     * @test
     *
     * +-----------------------------------------------------------------+
     * | POSITIVE TEST | POST /api/pim/configuration/termination-reasons |
     * +-----------------------------------------------------------------+
     */
    public function it_should_return_an_termination_reason_object_if_post_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('termination_reason', $content_array);

        $termination_reason = $content_array['termination_reason'];

        $this->assertArrayHasKey('name', $termination_reason);
        $this->assertArrayHasKey('id', $termination_reason);

        $this->assertEquals(201, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }

    /**
     * @test
     *
     * +-----------------------------------------------------------------+
     * | NEGATIVE TEST | POST /api/pim/configuration/termination-reasons |
     * +-----------------------------------------------------------------+
     */
    public function it_should_return_an_error_if_post_is_unsuccessful()
    {
        $this->login();

        $response = $this->post('/api/pim/configuration/termination-reasons', [], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +------------------------------------------------------------------+
     * | NEGATIVE TEST | PATCH /api/pim/configuration/termination-reasons |
     * +------------------------------------------------------------------+
     */
    public function it_should_return_an_error_if_termination_reason_doesnt_exist()
    {
        $this->login();

        $data = $this->termination_reason;

        $response = $this->patch('/api/pim/configuration/termination-reasons', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +------------------------------------------------------------------+
     * | POSITIVE TEST | PATCH /api/pim/configuration/termination-reasons |
     * +------------------------------------------------------------------+
     */
    public function it_should_return_a_success_message_if_patch_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['termination_reason']['id'];

        $data = $this->termination_reason;
        $data['name'] = 'termination_reason_name_'.$this->str_rand();
        $data['id'] = $id;

        $response = $this->patch('/api/pim/configuration/termination-reasons', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * @depends it_should_return_an_termination_reason_object_if_post_is_successful
     *
     * +-------------------------------------------------------------------+
     * | POSITIVE TEST | DELETE /api/pim/configuration/termination-reasons |
     * +-------------------------------------------------------------------+
     */
    public function it_should_return_a_success_message_if_delete_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['termination_reason']['id'];

        $response = $this->delete('/api/pim/configuration/termination-reasons/'.$id, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +----------------------------------------------------------------+
     * | POSITIVE TEST | GET /api/pim/configuration/termination-reasons |
     * +----------------------------------------------------------------+
     */
    public function it_should_return_a_response_if_fetching_of_data_is_successful()
    {
        $this->login();

        $response = $this->get('/api/pim/configuration/termination-reasons', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +-------------------------------------------------------------------+
     * | NEGATIVE TEST | DELETE /api/pim/configuration/termination-reasons |
     * +-------------------------------------------------------------------+
     */
    public function it_should_return_an_error_if_delete_fails()
    {
        $this->login();

        $response = $this->delete('/api/pim/configuration/termination-reasons/100', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(500, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals("No query results for model [{$this->class_name}].", $content_array['message']);
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    protected function _insert_record()
    {
        $this->login();

        $data = $this->termination_reason;
        $data['name'] .= $this->str_rand();

        return $this->post('/api/pim/configuration/termination-reasons', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;
    }
}
