<?php

return [
    /*
    |--------------------------------------------------------------------------
    | General config
    |--------------------------------------------------------------------------
    */
    'date_format'           => 'd.m.Y H:i:s',
    'icons' => [
        'contact'           => 'icon-call-end'
    ],
    'map_marker_color'      => '#76BE1E', // google marker colors (green,blue) or hex decimal (#76BE1E)
    'google_api_key'        => 'AIzaSyDt_BTC7JZ0TPkjSi0gRNmeTOdkbcqgRdo', // for map

    /*
    |--------------------------------------------------------------------------
    | URL config
    |--------------------------------------------------------------------------
    */
    'url' => [
        'contact'                   => 'contacts',              // contacts url
        'admin_url_prefix'          => 'admin',                 // admin dashboard url prefix
        'middleware'                => ['auth', 'permission']   // contact module middleware
    ],

    /*
    |--------------------------------------------------------------------------
    | Controller config
    | if you make some changes on controller, you create your controller
    | and then extend the Laravel Contact Module Controller. If you don't need
    | change controller, don't touch this config
    |--------------------------------------------------------------------------
    */
    'controller' => [
        'contact_admin_namespace'             => 'ErenMustafaOzdal\LaravelContactModule\Http\Controllers',
        'contact_api_namespace'               => 'ErenMustafaOzdal\LaravelContactModule\Http\Controllers',
        'contact'                             => 'ContactController',
        'contact_api'                         => 'ContactApiController'
    ],

    /*
    |--------------------------------------------------------------------------
    | View config
    |--------------------------------------------------------------------------
    | dot notation of blade view path, its position on the /resources/views directory
    */
    'views' => [
        // contact view
        'contact' => [
            'layout'    => 'laravel-modules-core::layouts.admin',               // contact layout
            'index'     => 'laravel-modules-core::contact.index',                 // get contact index view blade
            'create'    => 'laravel-modules-core::contact.operation',             // get contact create view blade
            'show'      => 'laravel-modules-core::contact.show',                  // get contact show view blade
            'edit'      => 'laravel-modules-core::contact.operation',             // get contact edit view blade
        ]
    ],
];
