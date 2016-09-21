<?php

namespace ErenMustafaOzdal\LaravelContactModule\Http\Controllers;

use Illuminate\Http\Request;

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
use ErenMustafaOzdal\LaravelContactModule\Http\Requests\Contact\ApiStoreRequest;
use ErenMustafaOzdal\LaravelContactModule\Http\Requests\Contact\ApiUpdateRequest;


class ContactApiController extends BaseController
{
    /**
     * default urls of the model
     *
     * @var array
     */
    private $urls = [
        'publish'       => ['route' => 'api.contact.publish', 'id' => true],
        'not_publish'   => ['route' => 'api.contact.notPublish', 'id' => true],
        'edit_page'     => ['route' => 'admin.contact.edit', 'id' => true]
    ];

    /**
     * Display a listing of the resource.
     *
     * @param Request  $request
     * @return Datatables
     */
    public function index(Request $request)
    {
        $contacts = Contact::with('category');
        $contacts->select(['id', 'name', 'is_publish', 'created_at']);

        // if is filter action
        if ($request->has('action') && $request->input('action') === 'filter') {
            $contacts->filter($request);
        }

        // urls
        $addUrls = $this->urls;
        $addColumns = [
            'addUrls'           => $addUrls,
            'status'            => function($model) { return $model->is_publish; }
        ];
        $editColumns = [
            'name'              => function($model) { return $model->name_uc_first; },
            'created_at'        => function($model) { return $model->created_at_table; }
        ];
        $removeColumns = ['is_publish'];
        return $this->getDatatables($contacts, $addColumns, $editColumns, $removeColumns);
    }

    /**
     * get detail
     *
     * @param integer $id
     * @param Request $request
     * @return Datatables
     */
    public function detail($id, Request $request)
    {
        $contact = Contact::with(['province', 'county', 'district', 'neighborhood', 'postalCode'])
            ->where('id',$id)
            ->select(['id','name','province_id','county_id','district_id','neighborhood_id','postal_code_id','address','land_phone','mobile_phone','url','created_at','updated_at']);

        $editColumns = [
            'name'          => function($model) { return $model->name_uc_first; },
            'created_at'    => function($model) { return $model->created_at_table; },
            'updated_at'    => function($model) { return $model->updated_at_table; },
            'address'       => function($model) { return $model->full_address; },
        ];
        $removeColumns = ['province_id','province','county_id','county','district_id','district','neighborhood_id','neighborhood','postal_code_id','postal_code'];
        return $this->getDatatables($contact, [], $editColumns, $removeColumns);
    }

    /**
     * get model data for edit
     *
     * @param integer $id
     * @param Request $request
     * @return Contact
     */
    public function fastEdit($id, Request $request)
    {
        return Contact::with(['province','county','district','neighborhood','postalCode'])
            ->where('id',$id)
            ->first(['id','name','province_id','county_id','district_id','neighborhood_id','postal_code_id']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ApiStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApiStoreRequest $request)
    {
        $this->setEvents([
            'success'   => StoreSuccess::class,
            'fail'      => StoreFail::class
        ]);
        return $this->storeModel(Contact::class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Contact $contact
     * @param  ApiUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(ApiUpdateRequest $request, Contact $contact)
    {
        $this->setEvents([
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ]);
        return $this->updateModel($contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $this->setEvents([
            'success'   => DestroySuccess::class,
            'fail'      => DestroyFail::class
        ]);
        return $this->destroyModel($contact);
    }

    /**
     * publish model
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function publish(Contact $contact)
    {
        $this->setOperationRelation([
            [ 'relation_type'     => 'not', 'datas' => [ 'is_publish'    => true ] ]
        ]);
        return $this->updateAlias($contact, [
            'success'   => PublishSuccess::class,
            'fail'      => PublishFail::class
        ]);
    }

    /**
     * not publish model
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function notPublish(Contact $contact)
    {
        $this->setOperationRelation([
            [ 'relation_type'     => 'not', 'datas' => [ 'is_publish'    => false ] ]
        ]);
        return $this->updateAlias($contact, [
            'success'   => NotPublishSuccess::class,
            'fail'      => NotPublishFail::class
        ]);
    }

    /**
     * group action method
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function group(Request $request)
    {
        if ( $this->groupAlias(Contact::class) ) {
            return response()->json(['result' => 'success']);
        }
        return response()->json(['result' => 'error']);
    }
}
