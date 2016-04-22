<?php namespace App\Nrna\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    protected $table = 'api_logger';

    protected $fillable = [
        'request_url',
        'request_data',
        'response',
        'status',
        'method',
        'host',
        'header'
    ];
}
