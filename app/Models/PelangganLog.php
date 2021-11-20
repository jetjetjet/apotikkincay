<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelangganLog extends Model
{
    use HasFactory;
    protected $table = 'pelanggan_log';
    protected $fillable = [
      'user_id',
      'reference_id',
      'action',
      'ip_address',
      'value',
      'old_value'
    ];
}
