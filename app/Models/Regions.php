<?php

namespace App\Models;
use App\Models\Stores;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    use HasFactory;
    public function stores()
    {
        return $this->belongsToMany(Stores::class, 'regions_stores', 'regions_id','stores_id');
    }
}
