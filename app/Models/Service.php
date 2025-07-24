<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = ['id',];

    public function repairDetails()
    {
        return $this->hasMany(RepairDetail::class);
    }

    public function repairs()
    {
        return $this->belongsToMany(Repair::class, 'repair_details');
    }
}
