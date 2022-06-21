<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'agent_id',
        'property_id',
        'lease_id',
        'period',
        'unit_id',
        'currency',
        'invoice_number',
        'status',
        'invoice_date',
        'due_date',
        'paid_on',
        'late_fee_charged_on',
        'terms',
        'notes',
        'total_items',
        'sub_total',
        'total_tax',
        'total_discount',
        'invoice_amount',
        'created_by',
        'updated_by',
    ];
}
