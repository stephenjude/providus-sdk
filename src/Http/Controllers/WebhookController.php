<?php

namespace Providus\Providus\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Providus\Providus\SignatureValidator\SignatureValidator;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $signatureValidator = app(SignatureValidator::class);

        if (! $signatureValidator->isValid($request)) {
            return $this->rejectedResponse($request);
        }
    }

    protected function rejectedResponse(Request $request): Response
    {
        return response()->json([
            'requestSuccessful' => true,
            'sessionId' => $request->input('sessionId'),
            'responseMessage' => 'rejected transaction',
            'responseCode' => '02',
        ]);
    }

    protected function duplicateResponse(Request $request): Response
    {
        return response()->json([
            'requestSuccessful' => true,
            'sessionId' => $request->input('sessionId'),
            'responseMessage' => 'duplicate transaction',
            'responseCode' => '01',
        ]);
    }

    protected function successfulResponse(Request $request): Response
    {
        return response()->json([
            'requestSuccessful' => true,
            'sessionId' => $request->input('sessionId'),
            'responseMessage' => 'success',
            'responseCode' => '00',
        ]);
    }
}
