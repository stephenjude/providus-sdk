<?php

namespace Providus\Providus\SignatureValidator;

use App\Exceptions\InvalidProvidusWebhookSignatureException;
use Illuminate\Http\Request;

class DefaultSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request): bool
    {
        $signature = $request->header(config('providus-sdk.webhook.signature_header_name'));

        if (! $signature) {
            return false;
        }

        if ($signature === config('providus-sdk.webhook.test_signature')) {
            return true;
        }

        $signingSecret = config('providus-sdk.webhook.signing_secret');

        $computedSignature = hash_hmac('sha512', $request->getContent(), $signingSecret);

        return hash_equals($signature, $computedSignature);
    }
}
