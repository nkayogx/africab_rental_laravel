<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'agent_id',
        'payment_method_id',
        'currency',
        'paid_for',
        'tenant_id',
        'lease_id',
        'property_id',
        'payment_date',
        'unit_id',
        'amount',
        'notes',
        'attachment',
        'receipt_number',
        'paid_by',
        'reference_number',
        'lease_number',
        'payment_status',
        'cancel_notes',
        'cancelled_by',
        'approved_by',
        'approved_on',
        'canceled_on',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
