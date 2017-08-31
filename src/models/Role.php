<?php

namespace Zein\Zacl\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'name', 'display_name', 'descriptions'
    ];

}
