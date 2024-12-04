<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAttribute extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function nilai()
    {
        return $this->belongsTo(Nilai::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
