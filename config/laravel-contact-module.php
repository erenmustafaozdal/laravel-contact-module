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
    'google_api_key'        => 'AIzaSyCjEWf270WVlOolKfwRe71Iq_G5UWmBnok', // for map

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






    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */
    'permissions' => [
        'contact' => [
            'title'                 => 'İletişim',
            'routes' => [
                'admin.contact.index' => [
                    'title'         => 'Veri Tablosu',
                    'description'   => 'Bu izne sahip olanlar şubeleri veri tablosunda listeleyebilir.',
                ],
                'admin.contact.create' => [
                    'title'         => 'Ekleme',
                    'description'   => 'Bu izne sahip olanlar şube ekleyebilir',
                ],
                'admin.contact.show' => [
                    'title'         => 'Gösterme',
                    'description'   => 'Bu izne sahip olanlar şube bilgilerini görüntüleyebilir',
                ],
                'admin.contact.edit' => [
                    'title'         => 'Düzenleme',
                    'description'   => 'Bu izne sahip olanlar şubeyi düzenleyebilir',
                ],
                'admin.contact.destroy' => [
                    'title'         => 'Silme',
                    'description'   => 'Bu izne sahip olanlar şubeyi silebilir',
                ],
                'api.contact.group' => [
                    'title'         => 'Toplu İşlem',
                    'description'   => 'Bu izne sahip olanlar şubeler veri tablosunda toplu işlem yapabilir',
                ],
                'api.contact.detail' => [
                    'title'         => 'Detaylar',
                    'description'   => 'Bu izne sahip olanlar şubeler tablosunda detayını görebilir.',
                ],
            ],
        ],
    ],
];
