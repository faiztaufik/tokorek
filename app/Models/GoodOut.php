<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodOut extends Model
{
    use HasFactory;

    protected $guarded = ['id',];

    public function good()
    {
        return $this->belongsTo(Good::class);
    }
}
