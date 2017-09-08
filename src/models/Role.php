<?php

namespace Zein\Zacl\Models;

use Illuminate\Database\Eloquent\Model;
use Zein\Zacl\Traits\ZaclRoleTrait;

class Role extends Model {

    use ZaclRoleTrait;
    
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'name', 'display_name', 'descriptions'
    ];

}
