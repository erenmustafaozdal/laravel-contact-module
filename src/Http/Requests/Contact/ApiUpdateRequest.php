<?php

namespace ErenMustafaOzdal\LaravelContactModule\Http\Requests\Contact;

use App\Http\Requests\Request;
use Sentinel;

class ApiUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return hasPermission('api.contact.update');
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
            'postal_code_id'    => 'integer|exists:postal_codes,id'
        ];
    }
}
