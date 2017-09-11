<?php

namespace Zein\Zacl\Models;

use Illuminate\Database\Eloquent\Model;
use Zein\Zacl\Traits\CacheModelTrait;

class Roleuser extends Model {
    use CacheModelTrait;
    
    protected $table = 'role_user';
    protected $fillable = [
        'user_id', 'role_id'
    ];
    public $timestamps = false;
}
