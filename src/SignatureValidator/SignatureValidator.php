<?php

namespace Providus\Providus\SignatureValidator;

use Illuminate\Http\Request;

interface SignatureValidator
{
    public function isValid(Request $request): bool;
}
