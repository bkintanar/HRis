<?php

namespace HRis\Exceptions;

use Dingo\Api\Exception\Handler;
use Exception;

class ApiHandler extends Handler
{
    public function handle(Exception $exception)
    {
        return parent::handle($exception);
    }
}
