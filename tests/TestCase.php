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

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;
use Tymon\JWTAuth\Facades\JWTAuth;

class TestCase extends BaseTestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $token;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * @return mixed
     */
    public function login()
    {
        $response = $this->post('/api/login', ['email' => 'bertrand.kintanar@gmail.com', 'password' => 'retardko'])->response;

        $content = $response->getContent();

        $content_array = json_decode($content, true);
        $this->token = $content_array['token'];

        JWTAuth::setToken($this->token);
        $this->user = JWTAuth::toUser();

        return $content_array;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $parameters
     * @param array  $cookies
     * @param array  $file
     * @param array  $server
     * @param null   $content
     *
     * @return \Illuminate\Http\Response
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $file = [], $server = [], $content = null)
    {
        if (empty($server)) {
            $server = ['HTTP_Authorization' => 'Bearer '.$this->token];
        }

        return parent::call($method, $uri, $parameters, $cookies, $file, $server, $content);
    }

    public function str_rand()
    {
        return substr(md5(rand()), 0, 7);
    }

    public function renameTable($from, $to)
    {
        Schema::rename($from, $to);
    }
}
