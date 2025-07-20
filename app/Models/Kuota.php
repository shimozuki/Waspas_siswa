<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuota extends Model
{
    protected $table = 'kuotas';

    protected $fillable = [
        'tahun_ajaran',
        'jumlah',
    ];
}
