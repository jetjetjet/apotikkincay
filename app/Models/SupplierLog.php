<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierLog extends Model
{
    use HasFactory;
    protected $table = 'supplier_log';
    protected $fillable = [
      'user_id',
      'reference_id',
      'action',
      'ip_address',
      'value',
      'old_value'
    ];
}
