<?php

declare(strict_types=1);

namespace Providus\Providus\Exceptions;

use Exception;

class AuthSignatureException extends Exception
{
    protected $message = "Failed to generate valid auth signature";
}
