<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
      'merk_id',
      'kategori_id',
      'nama_produk',
      'detail',
      'ppn',
      'harga_modal',
      'harga_jual',
      'no_rak',
      'img_path',
      'is_active',
      'created_by',
      'updated_by',
      'deleted_by',
      'deleted_remark'
    ];
}
