<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturTransaksi extends Model
{
    use HasFactory;
    protected $table = 'retur_transaksi';
    protected $fillable = [
      'transaksi_id',
      'product_id',
      'qty_retur',
      'satuan',
      'tgl_retur'
    ];
}
