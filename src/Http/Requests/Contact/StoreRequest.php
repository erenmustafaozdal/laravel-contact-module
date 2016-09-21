<?php

namespace ErenMustafaOzdal\LaravelContactModule\Http\Requests\Contact;

use App\Http\Requests\Request;
use Sentinel;

class StoreRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Sentinel::getUser()->is_super_admin || Sentinel::hasAccess('admin.contact.store')) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required|max:255',
            'address'           => 'max:255',
            'province_id'       => 'required|integer|exists:provinces,id',
            'county_id'         => 'required|integer|exists:counties,id',
            'district_id'       => 'integer|exists:districts,id',
            'neighborhood_id'   => 'integer|exists:neighborhoods,id',
            'postal_code_id'    => 'integer|exists:postal_codes,id',
            'map_title'         => 'max:255',
            'latitude'          => 'numeric',
            'longitude'         => 'numeric',
            'zoom'              => 'numeric|between:1,20',
            'number'            => 'max:16|unique:contact_numbers,number',
            'email'             => 'max:16|unique:contact_email,email'
        ];
    }
}
