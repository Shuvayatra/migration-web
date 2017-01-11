<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;

class Onboarding extends Model
{
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['metadata', 'device_type'];

    protected $casts = ['metadata' => 'object'];

    static public $rules = [
        'name'        => 'required',
        'gender'      => 'required',
        'dob'         => 'required',
        'location'    => 'required',
        'country'     => 'required',
        'work_status' => 'required',
    ];
}
