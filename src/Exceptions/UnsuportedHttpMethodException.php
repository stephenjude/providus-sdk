<?php

declare(strict_types=1);

namespace Providus\Providus\Exceptions;

use Exception;

class UnsuportedHttpMethodException extends Exception
{
    protected $message = "Http method not supported";
}
