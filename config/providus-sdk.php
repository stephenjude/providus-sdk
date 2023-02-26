<?php

return [

    'id' => env('PROVIDUS_ID'),

    'secret' => env('PROVIDUS_SECRET'),

    'base_url' => env('PROVIDUS_BASE_URL', 'http://154.113.16.142:8088/AppDevAPI/api/'),

    /**
     * Set SDK to demo mode. This mode makes use of the demo signature provided by Providus bank.
     */
    'demo_mode' => env('PROVIDUS_DEMO', false),

    /**
     * Auth signature used for demo requests
     */
    'demo_signature' => 'BE09BEE831CF262226B426E39BD1092AF84DC63076D4174FAC78A2261F9A3D6E59744983B8326B69CDF2963FE314DFC89635CFA37A40596508DD6EAAB09402C7',

    'webhook' => [
        /**
         * The name of the header containing the signature.
         */
        'signature_header_name' => 'X-Auth-Signature',

        /**
         * This class will verify that the content of the signature header is valid.
         * It should implement \Providus\Providus\SignatureValidator\SignatureValidator
         */
        'signature_validator' => \Providus\Providus\SignatureValidator\DefaultSignatureValidator::class,

        /**
         * The classname of the controller to be used to process the webhook.
         * This should be set to a class that extends \Providus\Providus\Http\Controllers\WebhookController::class
         */
        'controller' => \Providus\Providus\Http\Controllers\WebhookController::class,

        /**
         * The route path that maps the webhook request to the webhook controller.
         */
        'path' => '/internals/webhook/providus/events',
    ],
];
