<?php

namespace ErenMustafaOzdal\LaravelContactModule\Http\Controllers;

use App\Http\Requests;
use App\Contact;

use ErenMustafaOzdal\LaravelModulesBase\Controllers\BaseController;
// events
use ErenMustafaOzdal\LaravelContactModule\Events\Contact\StoreSuccess;
use ErenMustafaOzdal\LaravelContactModule\Events\Contact\StoreFail;
use ErenMustafaOzdal\LaravelContactModule\Events\Contact\UpdateSuccess;
use ErenMustafaOzdal\LaravelContactModule\Events\Contact\UpdateFail;
use ErenMustafaOzdal\LaravelContactModule\Events\Contact\DestroySuccess;
use ErenMustafaOzdal\LaravelContactModule\Events\Contact\DestroyFail;
use ErenMustafaOzdal\LaravelContactModule\Events\Contact\PublishSuccess;
use ErenMustafaOzdal\LaravelContactModule\Events\Contact\PublishFail;
use ErenMustafaOzdal\LaravelContactModule\Events\Contact\NotPublishSuccess;
use ErenMustafaOzdal\LaravelContactModule\Events\Contact\NotPublishFail;
// requests
use ErenMustafaOzdal\LaravelContactModule\Http\Requests\Contact\StoreRequest;
use ErenMustafaOzdal\LaravelContactModule\Http\Requests\Contact\UpdateRequest;

class ContactController extends BaseController
{
    /**
     * default relation datas
     *
     * @var array
     */
    private $relations = [
        'numbers' => [
            'relation_type'     => 'hasMany',
            'relation'          => 'numbers',
            'relation_model'    => '\App\ContactNumber',
            'is_reset'          => true,
            'datas'             => null
        ],
        'emails' => [
            'relation_type'     => 'hasMany',
            'relation'          => 'emails',
            'relation_model'    => '\App\ContactEmail',
            'is_reset'          => true,
            'datas'             => null
        ]
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(config('laravel-contact-module.views.contact.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $operation = 'create';
        return view(config('laravel-contact-module.views.contact.create'), compact('operation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->setEvents([
            'success'   => StoreSuccess::class,
            'fail'      => StoreFail::class
        ]);
        $relation = [];
        if ($request->has('group-number') && is_array($request->get('group-number'))) {
            $this->relations['numbers']['datas'] = collect($request->get('group-number'))->map(function($item)
            {
                $item['title'] = $item['number_title'];
                unsetReturn($item,'number_title');
                return $item;
            });
            $relation[] = $this->relations['numbers'];
        }
        if ($request->has('group-email') && is_array($request->get('group-email'))) {
            $this->relations['emails']['datas'] = collect($request->get('group-email'))->map(function($item)
            {
                $item['title'] = $item['email_title'];
                unsetReturn($item,'email_title');
                return $item;
            });
            $relation[] = $this->relations['emails'];
        }
        $this->setOperationRelation($relation);
        return $this->storeModel(Contact::class,'index');
    }

    /**
     * Display the specified resource.
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function show($contact)
    {
        return view(config('laravel-contact-module.views.contact.show'), compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function edit($contact)
    {
        $operation = 'edit';
        return view(config('laravel-contact-module.views.contact.edit'), compact('contact','operation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $contact)
    {
        $this->setEvents([
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ]);
        $relation = [];
        if ($request->has('group-number') && is_array($request->get('group-number'))) {
            $this->relations['numbers']['datas'] = collect($request->get('group-number'))->map(function($item)
            {
                $item['title'] = $item['number_title'];
                unsetReturn($item,'number_title');
                return $item;
            });
            $relation[] = $this->relations['numbers'];
        }
        if ($request->has('group-email') && is_array($request->get('group-email'))) {
            $this->relations['emails']['datas'] = collect($request->get('group-email'))->map(function($item)
            {
                $item['title'] = $item['email_title'];
                unsetReturn($item,'email_title');
                return $item;
            });
            $relation[] = $this->relations['emails'];
        }
        $this->setOperationRelation($relation);
        return $this->updateModel($contact,'show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($contact)
    {
        $this->setEvents([
            'success'   => DestroySuccess::class,
            'fail'      => DestroyFail::class
        ]);
        return $this->destroyModel($contact,'index');
    }

    /**
     * publish model
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function publish($contact)
    {
        $this->setOperationRelation([
            [ 'relation_type'     => 'not', 'datas' => [ 'is_publish'    => true ] ]
        ]);
        return $this->updateAlias($contact, [
            'success'   => PublishSuccess::class,
            'fail'      => PublishFail::class
        ],'show');
    }

    /**
     * not publish model
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function notPublish($contact)
    {
        $this->setOperationRelation([
            [ 'relation_type'     => 'not', 'datas' => [ 'is_publish'    => false ] ]
        ]);
        return $this->updateAlias($contact, [
            'success'   => NotPublishSuccess::class,
            'fail'      => NotPublishFail::class
        ],'show');
    }
}
