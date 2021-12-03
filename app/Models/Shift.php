<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;
    protected $table = 'shifts';
    protected $fillable = [
      'user_id',
      'index',
      'shift_start',
      'shift_end',
      'start_cash',
      'start_coin',
      'end_cash',
      'end_coin',
      'remark',
      'created_by',
      'updated_by',
      'deleted_by',
      'deleted_remark'
    ];
}
