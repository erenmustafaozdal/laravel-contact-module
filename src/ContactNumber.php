<?php

namespace ErenMustafaOzdal\LaravelContactModule;

use Illuminate\Database\Eloquent\Model;
use ErenMustafaOzdal\LaravelModulesBase\Traits\ModelDataTrait;

class ContactNumber extends Model
{
    use ModelDataTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contact_numbers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'number', 'title' ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['contact'];
    public $timestamps = false;





    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Get the number of the contact.
     */
    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }





    /*
    |--------------------------------------------------------------------------
    | Model Set and Get Attributes
    |--------------------------------------------------------------------------
    */
}
