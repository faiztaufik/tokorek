<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $guarded = ['id',];

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function laptop()
    {
        return $this->belongsTo(Laptop::class);
    }

    public function repairDetails()
    {
        return $this->hasMany(RepairDetail::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'repair_details');
    }
}
