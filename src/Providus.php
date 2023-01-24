<?php

namespace Providus\Providus;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Providus\Providus\Actions\MakesHttpRequests;
use Providus\Providus\Actions\ManagesAccount;
use Providus\Providus\Actions\ManagesTransaction;

class Providus
{
    use MakesHttpRequests;
    use ManagesAccount;
    use ManagesTransaction;

    public PendingRequest $request;

    public function __construct()
    {
        $this->request = Http::acceptJson()
            ->baseUrl(config('providus-sdk.base_url'))
            ->contentType('application/json')
            ->withHeaders([
                'Client-Id' => config('providus-sdk.id'),
                'X-Auth-Signature' => $this->createAuthSignature(config('providus-sdk.secret')),
            ]);
    }
}
