<?php

namespace Zein\Zacl\Models;

use Illuminate\Database\Eloquent\Model;
use Zein\Zacl\Traits\CacheModelTrait;

class PermissionRole extends Model {
    use CacheModelTrait;
    
    protected $table = 'permission_role';
    protected $fillable = [
        'permission_id', 'role_id'
    ];
    public $timestamps = false;
}
