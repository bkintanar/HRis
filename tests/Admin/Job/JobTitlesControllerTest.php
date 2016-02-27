<?php

namespace Tests\Admin\Job;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class JobTitlesControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $job_title = [
        'name'         => 'job_title_name_',
        'description'  => 'desc',
    ];

    protected $class_name = 'HRis\Api\Eloquent\JobTitle';

    /**
     * @test
     *
     * +--------------------------------------------+
     * | POSITIVE TEST | POST /api/admin/job/titles |
     * +--------------------------------------------+
     */
    public function it_should_return_an_job_title_object_if_post_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('job_title', $content_array);

        $job_title = $content_array['job_title'];

        $this->assertArrayHasKey('name', $job_title);
        $this->assertArrayHasKey('description', $job_title);
        $this->assertArrayHasKey('id', $job_title);

        $this->assertEquals(201, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals(SUCCESS_ADD_MESSAGE, $content_array['message']);
    }

    /**
     * @test
     *
     * +--------------------------------------------+
     * | NEGATIVE TEST | POST /api/admin/job/titles |
     * +--------------------------------------------+
     */
    public function it_should_return_an_error_if_post_is_unsuccessful()
    {
        $this->login();

        $response = $this->post('/api/admin/job/titles', [], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +---------------------------------------------+
     * | NEGATIVE TEST | PATCH /api/admin/job/titles |
     * +---------------------------------------------+
     */
    public function it_should_return_an_error_if_job_title_doesnt_exist()
    {
        $this->login();

        $data = $this->job_title;

        $response = $this->patch('/api/admin/job/titles', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(404, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals(UNABLE_RETRIEVE_MESSAGE, $content_array['message']);
    }

    /**
     * @test
     *
     * +---------------------------------------------+
     * | POSITIVE TEST | PATCH /api/admin/job/titles |
     * +---------------------------------------------+
     */
    public function it_should_return_a_success_message_if_patch_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['job_title']['id'];

        $data = $this->job_title;
        $data['name'] = 'job_title_name_'.$this->str_rand();
        $data['id'] = $id;

        $response = $this->patch('/api/admin/job/titles', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(200, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals(SUCCESS_UPDATE_MESSAGE, $content_array['message']);
    }

    /**
     * @test
     * @depends it_should_return_an_job_title_object_if_post_is_successful
     *
     * +----------------------------------------------+
     * | POSITIVE TEST | DELETE /api/admin/job/titles |
     * +----------------------------------------------+
     */
    public function it_should_return_a_success_message_if_delete_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['job_title']['id'];

        $response = $this->delete('/api/admin/job/titles', ['id' => $id], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(200, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals(SUCCESS_DELETE_MESSAGE, $content_array['message']);
    }

    /**
     * @test
     *
     * +-------------------------------------------+
     * | POSITIVE TEST | GET /api/admin/job/titles |
     * +-------------------------------------------+
     */
    public function it_should_return_a_response_if_fetching_of_data_is_successful()
    {
        $this->login();

        $response = $this->get('/api/admin/job/titles', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +---------------------------------------------+
     * | POSITIVE TEST | GET /api/admin/job/titles/1 |
     * +---------------------------------------------+
     */
    public function it_should_return_a_single_instance_if_fetching_of_data_is_successful()
    {
        $this->login();

        $response = $this->get('/api/admin/job/titles/1', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('job_title', $content_array);

        $this->assertEquals(200, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals(SUCCESS_RETRIEVE_MESSAGE, $content_array['message']);
    }

    /**
     * @test
     *
     * +-----------------------------------------------+
     * | NEGATIVE TEST | GET /api/admin/job/titles/100 |
     * +-----------------------------------------------+
     */
    public function it_should_return_an_error_if_fetching_of_data_is_unsuccessful()
    {
        $this->login();

        $response = $this->get('/api/admin/job/titles/100', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertEquals(500, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals("No query results for model [{$this->class_name}].", $content_array['message']);
    }

    /**
     * @test
     *
     * +----------------------------------------------+
     * | NEGATIVE TEST | DELETE /api/admin/job/titles |
     * +----------------------------------------------+
     */
    public function it_should_return_an_error_if_delete_fails()
    {
        $this->login();

        $response = $this->delete('/api/admin/job/titles', ['id' => 100], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(422, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals(UNABLE_DELETE_MESSAGE, $content_array['message']);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    protected function _insert_record()
    {
        $this->login();

        $data = $this->job_title;
        $data['name'] .= $this->str_rand();

        return $this->post('/api/admin/job/titles', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;
    }
}
