<?php

namespace Tests\Admin\Job;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EmploymentStatusControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $employment_status = [
        'name'   => 'employment_status_name_',
        'class'  => 'desc',
    ];

    /**
     * @test
     *
     * +-------------------------------------------------------+
     * | POSITIVE TEST | POST /api/admin/job/employment-status |
     * +-------------------------------------------------------+
     */
    public function it_should_return_an_employment_status_object_if_post_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('employment_status', $content_array);

        $employment_status = $content_array['employment_status'];

        $this->assertArrayHasKey('name', $employment_status);
        $this->assertArrayHasKey('class', $employment_status);
        $this->assertArrayHasKey('id', $employment_status);

        $this->assertEquals(201, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }

    /**
     * @test
     *
     * +-------------------------------------------------------+
     * | NEGATIVE TEST | POST /api/admin/job/employment-status |
     * +-------------------------------------------------------+
     */
    public function it_should_return_an_error_if_post_is_unsuccessful()
    {
        $this->login();

        $response = $this->post('/api/admin/job/employment-status', [], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +--------------------------------------------------------+
     * | NEGATIVE TEST | PATCH /api/admin/job/employment-status |
     * +--------------------------------------------------------+
     */
    public function it_should_return_an_error_if_employment_status_doesnt_exist()
    {
        $this->login();

        $data = $this->employment_status;

        $response = $this->patch('/api/admin/job/employment-status', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +--------------------------------------------------------+
     * | POSITIVE TEST | PATCH /api/admin/job/employment-status |
     * +--------------------------------------------------------+
     */
    public function it_should_return_a_success_message_if_patch_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['employment_status']['id'];

        $data = $this->employment_status;
        $data['name'] = 'employment_status_name_'.$this->str_rand();
        $data['id'] = $id;

        $response = $this->patch('/api/admin/job/employment-status', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * @depends it_should_return_an_employment_status_object_if_post_is_successful
     *
     * +---------------------------------------------------------+
     * | POSITIVE TEST | DELETE /api/admin/job/employment-status |
     * +---------------------------------------------------------+
     */
    public function it_should_return_a_success_message_if_delete_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['employment_status']['id'];

        $response = $this->delete('/api/admin/job/employment-status', ['id' => $id], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +------------------------------------------------------+
     * | POSITIVE TEST | GET /api/admin/job/employment-status |
     * +------------------------------------------------------+
     */
    public function it_should_return_a_response_if_fetching_of_data_is_successful()
    {
        $this->login();

        $response = $this->get('/api/admin/job/employment-status', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +---------------------------------------------------------+
     * | NEGATIVE TEST | DELETE /api/admin/job/employment-status |
     * +---------------------------------------------------------+
     */
    public function it_should_return_an_error_if_delete_fails()
    {
        $this->login();

        $response = $this->delete('/api/admin/job/employment-status', ['id' => 100], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(422, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    protected function _insert_record()
    {
        $this->login();

        $data = $this->employment_status;
        $data['name'] .= $this->str_rand();
        $data['class'] .= $this->str_rand();

        return $this->post('/api/admin/job/employment-status', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;
    }
}
