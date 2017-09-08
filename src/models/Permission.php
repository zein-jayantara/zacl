<?php

namespace Zein\Zacl\Models;

use Illuminate\Database\Eloquent\Model;
use Zein\Zacl\Traits\ZaclRoleTrait;

class Permission extends Model {

    use ZaclPermissionTrait;
    
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'name', 'display_name', 'description'
    ];

}
