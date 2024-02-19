<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingToko extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'sequence',
        'description',
        'kode_toko',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
