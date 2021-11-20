<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';
    protected $fillable = [
      'merk_id',
      'kategori_id',
      'nama_item',
      'detail',
      'qty',
      'ppn',
      'harga_modal',
      'harga_jual',
      'no_rak',
      'path_file',
      'status_item'
    ];
}
