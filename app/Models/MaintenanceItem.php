<?php
/**
 * Created by PhpStorm.
 * User: Kevin G. Mungai
 * Email: robisignals@gmail.com
 * WhatsApp: +254724475357
 * Date: 12/28/2020
 * Time: 8:47 AM
 */

namespace App\Models;

use App\Traits\SearchableTrait;

class MaintenanceItem extends BaseModel
{
    use SearchableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'maintenance_due_items';

    /**
     * Main table primary key
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'service_cost',
        'unit_id',
        'property_id',
        'period_code',
        'year', // rent, rent_deposit, utility_deposit etc
        'created_by',
        'updated_by',
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        
        
        'columns' => [
            'maintenance_due_items.unit_id' => 1,
            'maintenance_due_items.property_id' => 1
        ]
    ];

  
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

     
}
