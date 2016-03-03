<?php

namespace Tests\Profile;

use HRis\Api\Eloquent\Relationship;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EmergencyContactsControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $emergency_contact = [
        'first_name'   => 'First Name Test',
        'middle_name'  => 'Middle Name Test',
        'last_name'    => 'Last Name Test',
        'home_phone'   => '032 234 2345',
        'mobile_phone' => '0999 999 9999',
    ];

    /**
     * @test
     *
     * +------------------------------------------------------+
     * | POSITIVE TEST | POST /api/profile/emergency-contacts |
     * +------------------------------------------------------+
     */
    public function it_should_return_an_emergency_contact_object_if_post_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('emergency_contact', $content_array);

        $emergency_contact = $content_array['emergency_contact'];

        $this->assertArrayHasKey('employee_id', $emergency_contact);
        $this->assertArrayHasKey('first_name', $emergency_contact);
        $this->assertArrayHasKey('middle_name', $emergency_contact);
        $this->assertArrayHasKey('last_name', $emergency_contact);
        $this->assertArrayHasKey('relationship_id', $emergency_contact);
        $this->assertArrayHasKey('home_phone', $emergency_contact);
        $this->assertArrayHasKey('mobile_phone', $emergency_contact);
        $this->assertArrayHasKey('id', $emergency_contact);

        $this->assertEquals(201, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals(SUCCESS_ADD_MESSAGE, $content_array['message']);
    }

    /**
     * @test
     *
     * +------------------------------------------------------+
     * | NEGATIVE TEST | POST /api/profile/emergency-contacts |
     * +------------------------------------------------------+
     */
    public function it_should_return_an_error_if_post_is_unsuccessful()
    {
        $this->login();

        $data = $this->emergency_contact;
        $data['relationship_id'] = Relationship::whereName('Other')->value('id');

        $response = $this->post('/api/profile/emergency-contacts', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(422, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals(UNABLE_ADD_MESSAGE, $content_array['message']);
    }

    /**
     * @test
     *
     * +-------------------------------------------------------+
     * | NEGATIVE TEST | PATCH /api/profile/emergency-contacts |
     * +-------------------------------------------------------+
     */
    public function it_should_return_an_error_if_emergency_contact_doesnt_exist()
    {
        $this->login();

        $data = $this->emergency_contact;
        $data['relationship_id'] = Relationship::whereName('Other')->value('id');

        $response = $this->patch('/api/profile/emergency-contacts', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * @depends it_should_return_an_emergency_contact_object_if_post_is_successful
     *
     * +------------------------------------------------------+
     * | POSITIVE TEST | PATCH /api/profile/emergency-contacts |
     * +------------------------------------------------------+
     */
    public function it_should_return_a_success_message_if_patch_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['emergency_contact']['id'];

        $data = $this->emergency_contact;
        $data['first_name'] = 'First Name Test 2';
        $data['employee_id'] = $this->user->employee->id;
        $data['relationship_id'] = Relationship::whereName('Other')->value('id');
        $data['id'] = $id;

        $response = $this->patch('/api/profile/emergency-contacts', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * @depends it_should_return_an_emergency_contact_object_if_post_is_successful
     *
     * +--------------------------------------------------------+
     * | POSITIVE TEST | DELETE /api/profile/emergency-contacts |
     * +--------------------------------------------------------+
     */
    public function it_should_return_a_success_message_if_delete_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['emergency_contact']['id'];

        $response = $this->delete('/api/profile/emergency-contacts', ['id' => $id], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +----------------------------------------------+
     * | NEGATIVE TEST | DELETE /api/admin/job/titles |
     * +----------------------------------------------+
     */
    public function it_should_return_an_error_if_delete_fails()
    {
        $this->login();

        $response = $this->delete('/api/profile/emergency-contacts', ['id' => 100], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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

        $data = $this->emergency_contact;

        $data['employee_id'] = $this->user->employee->id;
        $data['relationship_id'] = Relationship::whereName('Other')->value('id');

        return $this->post('/api/profile/emergency-contacts', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;
    }
}
