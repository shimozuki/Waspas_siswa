<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hasil extends Model
{
    use HasFactory;

    protected $guarded = [];

    function mahasiswa():BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function jurusan():BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }
}
