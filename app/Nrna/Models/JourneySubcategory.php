<?php

namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JourneySubcategory extends Model
{
    use SoftDeletes;
    use \Rutorika\Sortable\SortableTrait;
    protected $fillable = ['title'];
    //
}
