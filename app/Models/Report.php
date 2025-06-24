<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'nama', 'opd', 'masalah', 'deskripsi', 'kontak',
    ];
}
