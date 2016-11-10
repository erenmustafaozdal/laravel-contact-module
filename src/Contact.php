<?php

namespace ErenMustafaOzdal\LaravelContactModule;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use ErenMustafaOzdal\LaravelModulesBase\Traits\ModelDataTrait;

class Contact extends Model
{
    use ModelDataTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'province_id',
        'county_id',
        'district_id',
        'neighborhood_id',
        'postal_code_id',
        'map_title',
        'latitude',
        'longitude',
        'zoom',
        'is_publish'
    ];





    /*
    |--------------------------------------------------------------------------
    | Model Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * query filter with id scope
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $request)
    {
        // filter id
        if ($request->has('id')) {
            $query->where('id',$request->get('id'));
        }
        // filter name
        if ($request->has('name')) {
            $query->where('name', 'like', "%{$request->get('name')}%");
        }
        // filter status
        if ($request->has('status')) {
            $query->where('is_publish',$request->get('status'));
        }
        // filter created_at
        if ($request->has('created_at_from')) {
            $query->where('created_at', '>=', Carbon::parse($request->get('created_at_from')));
        }
        if ($request->has('created_at_to')) {
            $query->where('created_at', '<=', Carbon::parse($request->get('created_at_to')));
        }
        return $query;
    }





    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Get the province of the contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo('App\Province');
    }

    /**
     * Get the county of the contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function county()
    {
        return $this->belongsTo('App\County');
    }

    /**
     * Get the district of the contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo('App\District');
    }

    /**
     * Get the neighborhood of the contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function neighborhood()
    {
        return $this->belongsTo('App\Neighborhood');
    }

    /**
     * Get the postal code of the contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function postalCode()
    {
        return $this->belongsTo('App\PostalCode');
    }

    /**
     * Get the contact numbers.
     */
    public function numbers()
    {
        return $this->hasMany('App\ContactNumber','contact_id');
    }

    /**
     * Get the contact emails.
     */
    public function emails()
    {
        return $this->hasMany('App\ContactEmail','contact_id');
    }





    /*
    |--------------------------------------------------------------------------
    | Model Set and Get Attributes
    |--------------------------------------------------------------------------
    */

    /**
     * Set district id
     *
     * @param $district_id
     */
    public function setDistrictIdAttribute($district_id)
    {
        $this->attributes['district_id'] =  $district_id == '' || $district_id == 0 ? null : $district_id;
    }

    /**
     * Set neighborhood id
     *
     * @param $neighborhood_id
     */
    public function setNeighborhoodIdAttribute($neighborhood_id)
    {
        $this->attributes['neighborhood_id'] =  $neighborhood_id == '' || $neighborhood_id == 0 ? null : $neighborhood_id;
    }

    /**
     * Set postal code id
     *
     * @param $postal_code_id
     */
    public function setPostalCodeIdAttribute($postal_code_id)
    {
        $this->attributes['postal_code_id'] =  $postal_code_id == '' || $postal_code_id == 0 ? null : $postal_code_id;
    }

    /**
     * get full address
     *
     * @return string
     */
    public function getFullAddressAttribute()
    {
        $address = '';
        // mahalle
        if ($this->neighborhood) {
            $address .= ' ' . $this->neighborhood->neighborhood;
        }
        // adres
        if ($this->address) {
            $address .= ' ' . $this->address;
        }
        // semt
        if ($this->district) {
            $address .= $this->county && $this->county->county === $this->district->district
                ? ''
                : ' ' . $this->district->district;
        }
        // il ve ilçe
        if ($this->province && $this->county) {
            $address .= " {$this->county->county}/{$this->province->province}";
        } else if($this->province) {
            $address .= ' ' . $this->province->province;
        } else if($this->county) {
            $address .= ' ' . $this->county->county;
        }
        // posta kodu
        if ($this->postalCode) {
            $address .= ' ' . $this->postalCode->postal_code;
        }
        return $address;
    }

    /**
     * get map title or name attribute
     *
     * @return string
     */
    public function getMapTitleOrNameAttribute()
    {
        return $this->map_title != '' ? $this->map_title : $this->name_uc_first;
    }
}
