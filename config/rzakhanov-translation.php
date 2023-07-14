<?php

use Laravel\Nova\Actions\ActionResource;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Http\Middleware\Authorize;
use Laravel\Nova\Http\Middleware\BootTools;
use Laravel\Nova\Http\Middleware\DispatchServingNovaEvent;
use Laravel\Nova\Http\Middleware\HandleInertiaRequests;

# Do not touch here :)
return [

    'default_locale' => config('app.locale','en'),

    'lang_path' => env('SITE_LANG_PATH',lang_path().'/'),

    'disabled_groups' => [
        'validation','auth','pagination','passwords'
    ],


    'languages' => [
        'az' => 'Azərbaycanca',
        'en' => 'English',
        'ru' => 'Russian',
        'es' => 'Espanyol',
    ]

];
