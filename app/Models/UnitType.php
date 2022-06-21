<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitType extends Model
{
    use HasFactory;

    public function modes(){
        return $this->belongsTo(UnitMode::class,'unit_mode_id');
    }
}
