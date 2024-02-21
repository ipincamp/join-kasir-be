<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'name',
        'site_name',
        'site_address',
        'site_motd',
        'site_header',
        'site_footer',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
