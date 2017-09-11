<?php

namespace Zein\Zacl\Models;

use Illuminate\Database\Eloquent\Model;
use Zein\Zacl\Traits\ZaclRoleTrait;
use Zein\Zacl\Traits\CacheModelTrait;

class Role extends Model {

    use ZaclRoleTrait,CacheModelTrait;
    
    public $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'name', 'display_name', 'descriptions'
    ];

}
