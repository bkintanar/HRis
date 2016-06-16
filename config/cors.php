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

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel CORS
     |--------------------------------------------------------------------------
     |

     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
     | to accept any value, the allowed methods however have to be explicitly listed.
     |
     */
    'supportsCredentials' => true,
    'allowedOrigins'      => ['*'],
    'allowedHeaders'      => ['Content-Type', 'Accept', 'Authorization', 'X-Requested-With', 'Origin'],
    'allowedMethods'      => ['GET', 'POST', 'PATCH', 'DELETE', 'OPTIONS'],
    'exposedHeaders'      => ['Authorization'],
    'maxAge'              => 0,
    'hosts'               => [],
];
