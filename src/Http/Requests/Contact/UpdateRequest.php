<?php

namespace ErenMustafaOzdal\LaravelContactModule\Http\Requests\Contact;

use App\Http\Requests\Request;
use Sentinel;

class UpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return hasPermission('admin.contact.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->segment(3);
        $rules = [
            'address'           => 'max:255',
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

        if( $this->form === 'general' ) {
            $rules['name']          = 'required|max:255';
            $rules['province_id']   = 'required|integer|exists:provinces,id';
            $rules['county_id']     = 'required|integer|exists:counties,id';
        }

        // group number rules extend
        if ($this->has('group-number') && is_array($this->get('group-number'))) {
            for ($i = 0; $i < count($this->get('group-number')); $i++) {
                $rules['group-number.' . $i . '.number'] = 'max:16|unique:contact_numbers,number,' . $id . ',contact_id';
                $rules['group-number.' . $i . '.number_title'] = 'max:255';
            }
        }

        // group email rules extend
        if ($this->has('group-email') && is_array($this->get('group-email'))) {
            for ($i = 0; $i < count($this->get('group-email')); $i++) {
                $rules['group-email.' . $i . '.email'] = 'max:255|unique:contact_emails,email,' . $id . ',contact_id';
                $rules['group-email.' . $i . '.email_title'] = 'max:255';
            }
        }

        return $rules;
    }
}
