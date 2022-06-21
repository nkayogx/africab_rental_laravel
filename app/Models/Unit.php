<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'property_id',
        'unit_name',
        'rent_amount',
        'rent_currency',
        'unit_floor',
        'unit_status',
        'description',
        'unit_mode_id',
        'unit_type_id',
        'bath_rooms',
        'bed_rooms',
        'total_rooms',
        'square_foot',
        'maintenance_fee',
        'maintenance_currency'
    ];

    public function unitType(){
        return $this->belongsTo(UnitType::class,'unit_type_id');
    }
    public function unitMode(){
        return $this->belongsTo(UnitMode::class,'unit_mode_id');
    }

    public function property(){
        return $this->belongsTo(Property::class);       
    }

    public function leases()
    {
        $date = date('Y-m-d');
        return $this->belongsToMany(Lease::class, 'lease_units',
            'unit_id', 'lease_id')->where(function($query) use($date){
                $query->where('terminated_on', null)->orwhere("end_date",">",$date);
            })->limit(1);
    }

    /**
     * @return int
     */
    public function getLeasesTotalAttribute()
    {
        return $this->leases()->count();
    }
}
