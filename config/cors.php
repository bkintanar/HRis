<?php

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
