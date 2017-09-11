<?php

namespace Zein\Zacl\Models;

use Illuminate\Database\Eloquent\Model;
use Zein\Zacl\Traits\ZaclPermissionTrait;
use Zein\Zacl\Traits\CacheModelTrait;

class Permission extends Model {

    use ZaclPermissionTrait,CacheModelTrait;
    
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'name', 'display_name', 'description'
    ];

}
