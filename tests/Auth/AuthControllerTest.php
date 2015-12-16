<?php

namespace Test\Auth;

use Test\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * @test
     * @return void
     *
     * +---------------------------------+
     * | POSITIVE TEST | POST /api/login |
     * +---------------------------------+
     */
    public function login_registered_user()
    {
        $response = $this->post('/api/login', ['email' => 'bertrand.kintanar@gmail.com', 'password' => 'retardko'])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('token', $content_array);
        $this->assertEquals(200, $status_code);
    }

    /**
     * @test
     * @return void
     *
     * +---------------------------------+
     * | NEGATIVE TEST | POST /api/login |
     * +---------------------------------+
     */
    public function login_with_invalid_email()
    {
        $response = $this->post('/api/login', ['email' => 'bertrand.kintanar', 'password' => 'retardko'])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('error', $content_array);
        $this->assertEquals(401, $status_code);
    }

    /**
     * @test
     * @return void
     *
     * +---------------------------------+
     * | NEGATIVE TEST | POST /api/login |
     * +---------------------------------+
     */
    public function login_with_invalid_password()
    {
        $response = $this->post('/api/login', ['email' => 'bertrand.kintanar@gmail.com', 'password' => 'retardk'])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('error', $content_array);
        $this->assertEquals(401, $status_code);
    }
}
