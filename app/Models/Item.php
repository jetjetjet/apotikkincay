<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'barang';
    protected $fillable = [
        'nama_item',
        'detail',
        'qty',
        'harga'
    ];
}
