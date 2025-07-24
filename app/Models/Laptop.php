<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    use HasFactory;

    protected $guarded = ['id',];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }
}
