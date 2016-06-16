<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
 */

namespace Tests\Auth;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthControllerTest extends TestCase
{
    /**
     * @test
     *
     * +---------------------------------+
     * | POSITIVE TEST | POST /api/login |
     * +---------------------------------+
     */
    public function it_should_return_a_token_if_login_is_successful()
    {
        $response = $this->post('/api/login', ['email' => 'bertrand.kintanar@gmail.com', 'password' => 'retardko'])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('token', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(201, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }

    /**
     * @test
     *
     * +---------------------------------+
     * | NEGATIVE TEST | POST /api/login |
     * +---------------------------------+
     */
    public function it_should_return_an_error_if_email_is_invalid()
    {
        $response = $this->post('/api/login', ['email' => 'bertrand.kintanar', 'password' => 'retardko'])->response;

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
     * +---------------------------------+
     * | NEGATIVE TEST | POST /api/login |
     * +---------------------------------+
     */
    public function it_should_return_an_error_if_password_invalid()
    {
        $response = $this->post('/api/login', ['email' => 'bertrand.kintanar@gmail.com', 'password' => 'retardk'])->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('status_code', $content_array);

        $this->assertEquals(401, $status_code);
        $this->assertEquals($status_code, $content_array['status_code']);
    }

    /**
     * @test
     *
     * +---------------------------------+
     * | NEGATIVE TEST | POST /api/login |
     * +---------------------------------+
     */
    public function it_should_throw_an_exception_if_no_parameters_being_passed()
    {
        $response = $this->post('/api/login')->response;

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
     * +---------------------------------+
     * | POSITIVE TEST | GET /api/logout |
     * +---------------------------------+
     */
    public function it_should_return_success_in_logout_when_token_has_been_invalidated()
    {
        $this->login();

        $response = $this->call('GET', '/api/logout');

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
     * +---------------------------------+
     * | NEGATIVE TEST | GET /api/logout |
     * +---------------------------------+
     */
    public function it_should_return_error_in_logout_when_no_token_is_passed()
    {
        $response = $this->get('/api/logout')->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertEquals(401, $status_code);
    }

    /**
     * @test
     *
     * +-----------------------------------+
     * | NEGATIVE TEST | GET /api/users/me |
     * +-----------------------------------+
     */
    public function it_should_return_error_if_no_token_is_passed()
    {
        $response = $this->get('/api/users/me')->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertEquals(401, $status_code);
    }

    /**
     * @test
     *
     * +-----------------------------------+
     * | NEGATIVE TEST | GET /api/users/me |
     * +-----------------------------------+
     */
    public function it_should_return_error_if_token_is_invalid()
    {
        $content_array = $this->login();
        $token = $content_array['token'];

        $response = $this->call('GET', '/api/users/me', [], [], [], ['HTTP_Authorization' => 'Bearer '.$token.'invalid_token'], []);

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertEquals(401, $status_code);
    }

    /**
     * @test
     *
     * +---------------------------------------+
     * | NEGATIVE TEST | GET /api/auth/refresh |
     * +---------------------------------------+
     */
    public function it_should_throw_an_exception_when_providing_a_malformed_token()
    {
        $this->login();

        JWTAuth::setToken('foo.bar.baz');

        $response = $this->get('/api/auth/refresh')->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertEquals(403, $status_code);
    }

    /**
     * @test
     *
     * +---------------------------------------+
     * | NEGATIVE TEST | GET /api/auth/refresh |
     * +---------------------------------------+
     */
    public function it_should_throw_an_exception_when_not_providing_a_token()
    {
        $response = $this->get('/api/auth/refresh')->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertEquals(400, $status_code);
    }

    /**
     * @test
     *
     * +---------------------------------------+
     * | POSITIVE TEST | GET /api/auth/refresh |
     * +---------------------------------------+
     */
    public function it_should_respond_a_token()
    {
        $this->login();

        $response = $this->get('/api/auth/refresh')->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertEquals(201, $status_code);
    }

    /**
     * @test
     *
     * +-----------------------------------+
     * | POSITIVE TEST | POST /api/sidebar |
     * +-----------------------------------+
     */
    public function it_should_respond_a_sidebar()
    {
        $this->login();

        $response = $this->post('/api/sidebar')->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('message', $content_array);
        $this->assertArrayHasKey('sidebar', $content_array);
        $this->assertEquals(200, $status_code);
    }

    /**
     * @test
     *
     * +-----------------------------------+
     * | POSITIVE TEST | GET /api/users/me |
     * +-----------------------------------+
     */
    public function it_should_respond_a_user()
    {
        $this->login();

        $response = $this->get('/api/users/me')->response;

        $content = $response->getContent();
        $status_code = $response->getStatusCode();

        $content_array = json_decode($content, true);

        $this->assertArrayHasKey('data', $content_array);
        $this->assertEquals(200, $status_code);
    }
}
