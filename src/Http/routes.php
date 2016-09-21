<?php
//max level nested function 100 hatasını düzeltiyor
ini_set('xdebug.max_nesting_level', 300);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
/*==========  Contact Module  ==========*/
Route::group([
    'prefix'        => config('laravel-contact-module.url.admin_url_prefix'),
    'middleware'    => config('laravel-contact-module.url.middleware'),
    'namespace'     => config('laravel-contact-module.controller.contact_admin_namespace')
], function()
{
    // admin publish contact
    if (config('laravel-contact-module.routes.admin.contact_publish')) {
        Route::get('contact/{' . config('laravel-contact-module.url.contact') . '}/publish', [
            'as'                => 'admin.contact.publish',
            'uses'              => config('laravel-contact-module.controller.contact').'@publish'
        ]);
    }
    // admin not publish contact
    if (config('laravel-contact-module.routes.admin.contact_notPublish')) {
        Route::get('contact/{' . config('laravel-contact-module.url.contact') . '}/not-publish', [
            'as'                => 'admin.contact.notPublish',
            'uses'              => config('laravel-contact-module.controller.contact').'@notPublish'
        ]);
    }
    if (config('laravel-contact-module.routes.admin.contact')) {
        Route::resource(config('laravel-contact-module.url.contact'), config('laravel-contact-module.controller.contact'), [
            'names' => [
                'index'         => 'admin.contact.index',
                'create'        => 'admin.contact.create',
                'store'         => 'admin.contact.store',
                'show'          => 'admin.contact.show',
                'edit'          => 'admin.contact.edit',
                'update'        => 'admin.contact.update',
                'destroy'       => 'admin.contact.destroy',
            ]
        ]);
    }
});



/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
*/
/*==========  Contact Module  ==========*/
Route::group([
    'prefix'        => 'api',
    'middleware'    => config('laravel-contact-module.url.middleware'),
    'namespace'     => config('laravel-contact-module.controller.contact_api_namespace')
], function()
{
    // api group action
    if (config('laravel-contact-module.routes.api.contact_group')) {
        Route::post('contact/group-action', [
            'as'                => 'api.contact.group',
            'uses'              => config('laravel-contact-module.controller.contact_api').'@group'
        ]);
    }
    // data table detail row
    if (config('laravel-contact-module.routes.api.contact_detail')) {
        Route::get('contact/{id}/detail', [
            'as'                => 'api.contact.detail',
            'uses'              => config('laravel-contact-module.controller.contact_api').'@detail'
        ]);
    }
    // get contact category edit data for modal edit
    if (config('laravel-contact-module.routes.api.contact_fastEdit')) {
        Route::post('contact/{id}/fast-edit', [
            'as'                => 'api.contact.fastEdit',
            'uses'              => config('laravel-contact-module.controller.contact_api').'@fastEdit'
        ]);
    }
    // api publish contact
    if (config('laravel-contact-module.routes.api.contact_publish')) {
        Route::post('contact/{' . config('laravel-contact-module.url.contact') . '}/publish', [
            'as'                => 'api.contact.publish',
            'uses'              => config('laravel-contact-module.controller.contact_api').'@publish'
        ]);
    }
    // api not publish contact
    if (config('laravel-contact-module.routes.api.contact_notPublish')) {
        Route::post('contact/{' . config('laravel-contact-module.url.contact') . '}/not-publish', [
            'as'                => 'api.contact.notPublish',
            'uses'              => config('laravel-contact-module.controller.contact_api').'@notPublish'
        ]);
    }
    if (config('laravel-contact-module.routes.api.contact')) {
        Route::resource(config('laravel-contact-module.url.contact'), config('laravel-contact-module.controller.contact_api'), [
            'names' => [
                'index'         => 'api.contact.index',
                'store'         => 'api.contact.store',
                'update'        => 'api.contact.update',
                'destroy'       => 'api.contact.destroy',
            ]
        ]);
    }
});
