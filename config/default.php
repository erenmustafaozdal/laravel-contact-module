<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Routes on / off
    | if you don't use any route; set false
    |--------------------------------------------------------------------------
    */
    'routes' => [
        'admin' => [
            'contact'               => true,        // admin contact resource route
            'contact_publish'       => true,        // admin contact publish get route
            'contact_notPublish'    => true,        // admin contact not publish get route
        ],
        'api' => [
            'contact'               => true,        // api contact resource route
            'contact_group'         => true,        // api contact group post route
            'contact_detail'        => true,        // api contact detail get route
            'contact_fastEdit'      => true,        // api contact fast edit post route
            'contact_publish'       => true,        // api contact publish post route
            'contact_notPublish'    => true,        // api contact not publish post route
        ]
    ]
];
