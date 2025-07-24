<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use HasFactory;

    protected $guarded = ['id',];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function goodIns()
    {
        return $this->hasMany(GoodIn::class);
    }
    public function goodOuts()
    {
        return $this->hasMany(GoodOut::class);
    }
}
