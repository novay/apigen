<?php 

use App\Providers\RouteServiceProvider;
use Novay\Nue\Features;

return [

    'name' => 'API Generator',
    'version' => '1.0.0',

    'https' => env('API_HTTPS', true),
    'route' => [
        'prefix' => env('API_PREFIX', ''),
    ],
];