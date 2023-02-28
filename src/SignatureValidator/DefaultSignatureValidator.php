<?php

namespace Providus\Providus\SignatureValidator;

use Illuminate\Http\Request;

class DefaultSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request): bool
    {
        $signature = $request->header(config('providus-sdk.webhook.signature_header_name'));

        if (! $signature) {
            return false;
        }

        if (config('providus-sdk.demo_mode')) {
            return strtolower($signature) === strtolower(config('providus-sdk.demo_signature'));
        }

        $id = config('providus-sdk.id');

        $secret = config('providus-sdk.secret');

        $computedSignature = hash('sha512', "$id:$secret");

        return hash_equals($computedSignature, $signature);
    }
}
