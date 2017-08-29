<?php

namespace Jalinmodule\Barang\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'kategori_id', 'name',
    ];

}
