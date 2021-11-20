<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $table = 'pelanggan';
    protected $fillable = [
      'kode_pelanggan',
      'nama_pelanggan',
      'alamat',
      'kontak',
      'jen_kel',
      'tgl_lahir',
      'created_by',
      'updated_by'
    ];
}
