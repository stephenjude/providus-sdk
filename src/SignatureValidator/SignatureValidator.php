<?php

namespace Providus\Providus\SignatureValidator;

use App\Exceptions\InvalidProvidusWebhookSignatureException;
use Illuminate\Http\Request;

interface SignatureValidator
{
    public function isValid(Request $request): bool;
}
