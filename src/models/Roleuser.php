<?php

namespace Zein\Zacl\Models;

use Illuminate\Database\Eloquent\Model;

class Roleuser extends Model {

    protected $table = 'role_user';
    protected $fillable = [
        'user_id', 'role_id'
    ];
    public $timestamps = false;
}
