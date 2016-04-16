<?php

namespace Tests\Profile;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReportsToControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $employee_supervisor = [
        'employee_id'   => 2,
        'supervisor_id' => 1,
    ];

    /**
     * @test
     *
     * +----------------------------------------------+
     * | POSITIVE TEST | POST /api/profile/reports-to |
     * +----------------------------------------------+
     */
    public function it_should_return_an_employee_supervisor_object_if_post_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('supervisor', $content_array);

        $employee_supervisor = $content_array['supervisor'];

        $this->assertArrayHasKey('employee_id', $employee_supervisor);
        $this->assertArrayHasKey('supervisor_id', $employee_supervisor);
        $this->assertArrayHasKey('id', $employee_supervisor);

        $this->assertEquals(201, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals(SUCCESS_ADD_MESSAGE, $content_array['message']);
    }

    /**
     * @test
     *
     * +----------------------------------------------+
     * | NEGATIVE TEST | POST /api/profile/reports-to |
     * +----------------------------------------------+
     */
    public function it_should_return_an_error_if_post_is_unsuccessful()
    {
        $this->login();

        $data = $this->employee_supervisor;

        $data['employee_id'] = 1;

        $response = $this->post('/api/profile/reports-to', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +-----------------------------------------------+
     * | NEGATIVE TEST | PATCH /api/profile/reports-to |
     * +-----------------------------------------------+
     */
    public function it_should_return_an_error_if_employee_supervisor_doesnt_exist()
    {
        $this->login();

        $data = $this->employee_supervisor;

        $response = $this->patch('/api/profile/reports-to', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * @depends it_should_return_an_employee_supervisor_object_if_post_is_successful
     *
     * +-----------------------------------------------+
     * | POSITIVE TEST | PATCH /api/profile/reports-to |
     * +-----------------------------------------------+
     */
    public function it_should_return_a_success_message_if_patch_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['supervisor']['id'];

        $data = $this->employee_supervisor;
        $data['employee_id'] = 3;
        $data['supervisor_id'] = $this->user->employee->id;
        $data['id'] = $id;

        $response = $this->patch('/api/profile/reports-to', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * @depends it_should_return_an_employee_supervisor_object_if_post_is_successful
     *
     * +------------------------------------------------+
     * | POSITIVE TEST | DELETE /api/profile/reports-to |
     * +------------------------------------------------+
     */
    public function it_should_return_a_success_message_if_delete_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['supervisor']['id'];

        $response = $this->delete('/api/profile/reports-to/'.$id, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +------------------------------------------------+
     * | NEGATIVE TEST | DELETE /api/profile/reports-to |
     * +------------------------------------------------+
     */
    public function it_should_return_an_error_if_delete_fails()
    {
        $this->login();

        $response = $this->delete('/api/profile/reports-to/100', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(422, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals(UNPROCESSABLE_ENTITY, $content_array['message']);
    }

    protected function _insert_record()
    {
        $this->login();

        $data = $this->employee_supervisor;

        return $this->post('/api/profile/reports-to', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;
    }
}
