<?php

namespace Zein\Zacl\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'name', 'display_name', 'descriptions'
    ];

}
