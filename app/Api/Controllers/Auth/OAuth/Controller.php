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

namespace HRis\Api\Controllers\Auth\OAuth;

use Exception;
use Irradiate\Api\Controllers\BaseController;
use LucaDegasperi\OAuth2Server\Authorizer;

class Controller extends BaseController
{
    /**
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * OAuthController constructor.
     *
     * @param Authorizer $authorizer
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(Authorizer $authorizer)
    {
        $this->authorizer = $authorizer;
    }

    /**
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function accessToken()
    {
        try {
            return $this->authorizer->issueAccessToken();
        } catch (Exception $e) {
            return $this->responseAPI(401, 'Forbidden');
        }
    }
}
