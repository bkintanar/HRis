<?php

namespace Tests\Admin\Job;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PayGradesControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $class_name = 'HRis\Api\Eloquent\PayGrade';

    protected $pay_grade = [
        'name'         => 'pay_grade_name_',
        'min_salary'   => 10000,
        'max_salary'   => 20000,
    ];

    /**
     * @test
     *
     * +------------------------------------------------+
     * | POSITIVE TEST | POST /api/admin/job/pay-grades |
     * +------------------------------------------------+
     */
    public function it_should_return_an_pay_grade_object_if_post_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('pay_grade', $content_array);

        $pay_grade = $content_array['pay_grade'];

        $this->assertArrayHasKey('name', $pay_grade);
        $this->assertArrayHasKey('min_salary', $pay_grade);
        $this->assertArrayHasKey('max_salary', $pay_grade);
        $this->assertArrayHasKey('id', $pay_grade);

        $this->assertEquals(201, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals(SUCCESS_ADD_MESSAGE, $content_array['message']);
    }

    /**
     * @test
     *
     * +------------------------------------------------+
     * | NEGATIVE TEST | POST /api/admin/job/pay-grades |
     * +------------------------------------------------+
     */
    public function it_should_return_an_error_if_post_is_unsuccessful()
    {
        $this->login();

        $response = $this->post('/api/admin/job/pay-grades', [], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +-------------------------------------------------+
     * | NEGATIVE TEST | PATCH /api/admin/job/pay-grades |
     * +-------------------------------------------------+
     */
    public function it_should_return_an_error_if_pay_grade_doesnt_exist()
    {
        $this->login();

        $data = $this->pay_grade;

        $response = $this->patch('/api/admin/job/pay-grades', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +-------------------------------------------------+
     * | POSITIVE TEST | PATCH /api/admin/job/pay-grades |
     * +-------------------------------------------------+
     */
    public function it_should_return_a_success_message_if_patch_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['pay_grade']['id'];

        $data = $this->pay_grade;
        $data['name'] = 'pay_grade_name_'.$this->str_rand();
        $data['id'] = $id;

        $response = $this->patch('/api/admin/job/pay-grades', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * @depends it_should_return_an_pay_grade_object_if_post_is_successful
     *
     * +--------------------------------------------------+
     * | POSITIVE TEST | DELETE /api/admin/job/pay-grades |
     * +--------------------------------------------------+
     */
    public function it_should_return_a_success_message_if_delete_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['pay_grade']['id'];

        $response = $this->delete('/api/admin/job/pay-grades/'.$id, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +-----------------------------------------------+
     * | POSITIVE TEST | GET /api/admin/job/pay-grades |
     * +-----------------------------------------------+
     */
    public function it_should_return_a_response_if_fetching_of_data_is_successful()
    {
        $this->login();

        $response = $this->get('/api/admin/job/pay-grades', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +-------------------------------------------------+
     * | POSITIVE TEST | GET /api/admin/job/pay-grades/1 |
     * +-------------------------------------------------+
     */
    public function it_should_return_a_single_instance_if_fetching_of_data_is_successful()
    {
        $this->login();

        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $pay_grade = $content_array['pay_grade'];

        $response = $this->get('/api/admin/job/pay-grades/'.$pay_grade['id'], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('pay_grade', $content_array);

        $this->assertEquals(200, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals(SUCCESS_RETRIEVE_MESSAGE, $content_array['message']);
    }

    /**
     * @test
     *
     * +---------------------------------------------------+
     * | NEGATIVE TEST | GET /api/admin/job/pay-grades/100 |
     * +---------------------------------------------------+
     */
    public function it_should_return_an_error_if_fetching_of_data_is_unsuccessful()
    {
        $this->login();

        $response = $this->get('/api/admin/job/pay-grades/100', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +--------------------------------------------------+
     * | NEGATIVE TEST | DELETE /api/admin/job/pay-grades |
     * +--------------------------------------------------+
     */
    public function it_should_return_an_error_if_delete_fails()
    {
        $this->login();

        $response = $this->delete('/api/admin/job/pay-grades/100', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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

        $data = $this->pay_grade;
        $data['name'] .= $this->str_rand();

        return $this->post('/api/admin/job/pay-grades', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;
    }
}
