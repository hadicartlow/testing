<?php

namespace App\Models;
use App\Models\Regions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    use HasFactory;
    
    public function regions()
    {
        return $this->belongsToMany(Regions::class, 'regions_stores', 'stores_id', 'regions_id');
    }
}
