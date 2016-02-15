<?php

namespace Tests\Profile;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PersonalDetailsControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     *
     * +-----------------------------------------------------+
     * | POSITIVE TEST | PATCH /api/profile/personal-details |
     * +-----------------------------------------------------+
     */
    public function it_should_return_a_success_message_if_patch_is_successful_employee()
    {
        $this->login();

        $response = $this->post('/api/employee/get-by-employee-id?include=user', ['employee_id' => 'HRis-0001'], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $data = $content_array['data'];
        $data['first_name'] = 'Test';
        $data['last_name'] = 'Cases';
        $data['birth_date'] = $data['birth_date']['date'];

        $response = $this->patch('/api/profile/personal-details', ['employee' => $data], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +-----------------------------------------------------+
     * | NEGATIVE TEST | PATCH /api/profile/personal-details |
     * +-----------------------------------------------------+
     */
    public function it_should_return_an_error_message_if_patch_is_unsuccessful()
    {
        $this->login();

        $response = $this->patch('/api/profile/personal-details', ['employee' => []], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +-----------------------------------------------------+
     * | NEGATIVE TEST | PATCH /api/profile/personal-details |
     * +-----------------------------------------------------+
     */
    public function it_should_return_an_error_message_if_employee_id_is_not_found()
    {
        $this->login();

        $response = $this->post('/api/employee/get-by-employee-id?include=user', ['employee_id' => 'HRis-0001'], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $data = $content_array['data'];
        $data['employee_id'] = 0;
        $data['birth_date'] = $data['birth_date']['date'];

        $response = $this->patch('/api/profile/personal-details', ['employee' => $data], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(405, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }

    /**
     * @test
     *
     * +-----------------------------------------------------+
     * | NEGATIVE TEST | PATCH /api/profile/personal-details |
     * +-----------------------------------------------------+
     */
    public function it_should_return_an_error_message_if_employee_id_is_in_use()
    {
        $this->login();

        $response = $this->post('/api/employee/get-by-employee-id?include=user', ['employee_id' => 'HRis-0001'], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $data = $content_array['data'];
        $data['employee_id'] = 'HRis-0002';
        $data['birth_date'] = $data['birth_date']['date'];

        $response = $this->patch('/api/profile/personal-details', ['employee' => $data], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(405, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }
}
