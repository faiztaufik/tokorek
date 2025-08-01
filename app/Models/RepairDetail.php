<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id',];

    public function repair()
    {
        return $this->belongsTo(Repair::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
