<?php

use Illuminate\Support\Facades\Route;

Route::post(config('providus-sdk.webhook.path'), [config('providus-sdk.webhook.controller'), 'handle']);

