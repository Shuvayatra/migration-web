<?php
namespace App\Nrna\Traits;

trait UserInfoTrait
{
    public static function bootUserInfoTrait()
    {
        static::creating(
            function ($object) {
                $object->setAttribute('created_by', \Auth::User()->id);
                $object->setAttribute('updated_by', \Auth::User()->id);
            }
        );
        static::updating(
            function ($object) {
                $object->updated_by = \Auth::User()->id;
            }
        );
    }

}