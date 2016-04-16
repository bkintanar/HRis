<?php

namespace Tests\PIM\Configuration;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CustomFieldSectionsControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $custom_field_section = [
        'name'      => 'custom_field_section_name_',
        'screen_id' => 3,
    ];

    /**
     * @test
     *
     * +-------------------------------------------------------------------+
     * | POSITIVE TEST | POST /api/pim/configuration/custom-field-sections |
     * +-------------------------------------------------------------------+
     */
    public function it_should_return_an_custom_field_section_object_if_post_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('custom_field_section', $content_array);

        $custom_field_section = $content_array['custom_field_section'];

        $this->assertArrayHasKey('name', $custom_field_section);
        $this->assertArrayHasKey('id', $custom_field_section);

        $this->assertEquals(201, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }

    /**
     * @test
     *
     * +-------------------------------------------------------------------+
     * | NEGATIVE TEST | POST /api/pim/configuration/custom-field-sections |
     * +-------------------------------------------------------------------+
     */
    public function it_should_return_an_error_if_post_is_unsuccessful()
    {
        $this->login();

        $response = $this->post('/api/pim/configuration/custom-field-sections', [], ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +--------------------------------------------------------------------+
     * | NEGATIVE TEST | PATCH /api/pim/configuration/custom-field-sections |
     * +--------------------------------------------------------------------+
     */
    public function it_should_return_an_error_if_custom_field_section_doesnt_exist()
    {
        $this->login();

        $data = $this->custom_field_section;

        $response = $this->patch('/api/pim/configuration/custom-field-sections', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +--------------------------------------------------------------------+
     * | POSITIVE TEST | PATCH /api/pim/configuration/custom-field-sections |
     * +--------------------------------------------------------------------+
     */
    public function it_should_return_a_success_message_if_patch_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['custom_field_section']['id'];

        $data = $this->custom_field_section;
        $data['name'] = 'custom_field_section_name_'.$this->str_rand();
        $data['custom_field_section_id'] = $id;

        $response = $this->patch('/api/pim/configuration/custom-field-sections', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * @depends it_should_return_an_custom_field_section_object_if_post_is_successful
     *
     * +---------------------------------------------------------------------+
     * | POSITIVE TEST | DELETE /api/pim/configuration/custom-field-sections |
     * +---------------------------------------------------------------------+
     */
    public function it_should_return_a_success_message_if_delete_is_successful()
    {
        $response = $this->_insert_record();

        $content = $response->getContent();

        $content_array = json_decode($content, true);

        $id = $content_array['custom_field_section']['id'];

        $response = $this->delete('/api/pim/configuration/custom-field-sections/'.$id, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +------------------------------------------------------------------+
     * | POSITIVE TEST | GET /api/pim/configuration/custom-field-sections |
     * +------------------------------------------------------------------+
     */
    public function it_should_return_a_response_if_fetching_of_data_is_successful()
    {
        $this->login();

        $response = $this->get('/api/pim/configuration/custom-field-sections', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +---------------------------------------------------------------------+
     * | NEGATIVE TEST | DELETE /api/pim/configuration/custom-field-sections |
     * +---------------------------------------------------------------------+
     */
    public function it_should_return_an_error_if_delete_fails()
    {
        $this->login();

        $response = $this->delete('/api/pim/configuration/custom-field-sections/100', ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

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
     * +--------------------------------------------------------------------+
     * | NEGATIVE TEST | PATCH /api/pim/configuration/custom-field-sections |
     * +--------------------------------------------------------------------+
     */
    public function it_should_return_an_error_if_update_fails()
    {
        $this->login();

        $this->renameTable('custom_field_sections', 'custom_field_sections_test');

        $response = $this->patch('/api/pim/configuration/custom-field-sections', $this->custom_field_section, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(422, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);

        $this->renameTable('custom_field_sections_test', 'custom_field_sections');
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    protected function _insert_record()
    {
        $this->login();

        $data = $this->custom_field_section;
        $data['name'] .= $this->str_rand();
        $data['screen_id'] = 3;

        return $this->post('/api/pim/configuration/custom-field-sections', $data, ['HTTP_Authorization' => 'Bearer '.$this->token])->response;
    }
}
