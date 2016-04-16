<?php

namespace Tests\Profile;

use HRis\Api\Eloquent\Relationship;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DependentsControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $class_name = 'HRis\Api\Eloquent\Dependent';

    protected $dependent = [
        'first_name'   => 'First Name Test',
        'middle_name'  => 'Middle Name Test',
        'last_name'    => 'Last Name Test',
        'mobile_phone' => '2015-01-01',
    ];

    /**
     * @test
     *
     * +----------------------------------------------+
     * | POSITIVE TEST | POST /api/profile/dependents |
     * +----------------------------------------------+
     */
    public function it_should_return_an_dependent_object_if_post_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('dependent', $content_array);

        $dependent = $content_array['dependent'];

        $this->assertArrayHasKey('employee_id', $dependent);
        $this->assertArrayHasKey('first_name', $dependent);
        $this->assertArrayHasKey('middle_name', $dependent);
        $this->assertArrayHasKey('last_name', $dependent);
        $this->assertArrayHasKey('relationship_id', $dependent);
        $this->assertArrayHasKey('birth_date', $dependent);
        $this->assertArrayHasKey('id', $dependent);

        $this->assertEquals(201, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals(SUCCESS_ADD_MESSAGE, $content_array['message']);
    }

    /**
     * @test
     *
     * +----------------------------------------------+
     * | NEGATIVE TEST | POST /api/profile/dependents |
     * +----------------------------------------------+
     */
    public function it_should_return_an_error_if_post_is_unsuccessful()
    {
        $this->login();

        $data = $this->dependent;
        $data['relationship_id'] = Relationship::whereName('Other')->value('id');

        $response = $this->post('/api/profile/dependents', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +-----------------------------------------------+
     * | NEGATIVE TEST | PATCH /api/profile/dependents |
     * +-----------------------------------------------+
     */
    public function it_should_return_an_error_if_dependent_doesnt_exist()
    {
        $this->login();

        $data = $this->dependent;
        $data['relationship_id'] = Relationship::whereName('Other')->value('id');

        $response = $this->patch('/api/profile/dependents', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * @depends it_should_return_an_dependent_object_if_post_is_successful
     *
     * +----------------------------------------------+
     * | POSITIVE TEST | PATCH /api/profile/dependents |
     * +----------------------------------------------+
     */
    public function it_should_return_a_success_message_if_patch_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['dependent']['id'];

        $data = $this->dependent;
        $data['first_name'] = 'First Name Test 2';
        $data['employee_id'] = $this->user->employee->id;
        $data['relationship_id'] = Relationship::whereName('Other')->value('id');
        $data['id'] = $id;

        $response = $this->patch('/api/profile/dependents', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * @depends it_should_return_an_dependent_object_if_post_is_successful
     *
     * +------------------------------------------------+
     * | POSITIVE TEST | DELETE /api/profile/dependents |
     * +------------------------------------------------+
     */
    public function it_should_return_a_success_message_if_delete_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['dependent']['id'];

        $response = $this->delete('/api/profile/dependents/'.$id, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * | NEGATIVE TEST | DELETE /api/profile/dependents |
     * +------------------------------------------------+
     */
    public function it_should_return_an_error_if_delete_fails()
    {
        $this->login();

        $response = $this->delete('/api/profile/dependents/100', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(500, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->assertEquals("No query results for model [{$this->class_name}].", $content_array['message']);
    }

    protected function _insert_record()
    {
        $this->login();

        $data = $this->dependent;

        $data['employee_id'] = $this->user->employee->id;
        $data['relationship_id'] = Relationship::whereName('Other')->value('id');
        $data['birth_date'] = '2015-01-01';

        return $this->post('/api/profile/dependents', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;
    }
}
