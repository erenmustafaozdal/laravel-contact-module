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
        $rules = [
            'name'              => 'required|max:255',
            'address'           => 'max:255',
            'province_id'       => 'required|integer|exists:provinces,id',
            'county_id'         => 'required|integer|exists:counties,id',
            'district_id'       => 'integer|exists:districts,id',
            'neighborhood_id'   => 'integer|exists:neighborhoods,id',
            'postal_code_id'    => 'integer|exists:postal_codes,id',
            'group-number'      => 'array',
            'group-email'       => 'array',
            'map_title'         => 'max:255',
            'latitude'          => 'numeric',
            'longitude'         => 'numeric',
            'zoom'              => 'numeric|between:1,20',
        ];

        // group number rules extend
        if ($this->has('group-number') && is_array($this->get('group-number'))) {
            for ($i = 0; $i < count($this->get('group-number')); $i++) {
                $rules['number.' . $i] = 'max:16|unique:contact_numbers,number';
                $rules['number_title.' . $i] = 'max:255';
            }
        }

        // group email rules extend
        if ($this->has('group-email') && is_array($this->get('group-email'))) {
            for ($i = 0; $i < count($this->get('group-email')); $i++) {
                $rules['email.' . $i] = 'max:255|unique:contact_emails,email';
                $rules['email_title.' . $i] = 'max:255';
            }
        }

        return $rules;
    }
}
