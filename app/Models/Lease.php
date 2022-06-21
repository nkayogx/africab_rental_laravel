<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    use HasFactory;
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    protected $fillable = [
        'agent_id',
        'company_id',
        'property_id',
        'lease_type_id',
        'lease_mode_id',
        'lease_number',
        'start_date',
        'end_date',
        'due_date', // used for penalty calculations?
        'rent_amount',
        'rent_paid_amount',
        'rent_paid_currency',
     //   'billing_frequency', /// I decided to have the system have monthly as default and only billing frequency
        'billed_on',
        'terminated_on',
        'terminated_by',
        'next_billing_date',
        'due_on',
        'waive_penalty',
        'init_payment_method_id',
        'invoice_number_prefix',
        'invoice_footer',
        'invoice_terms',
        'show_payment_method_on_invoice',
        'invoice_no',
        'agreement_doc',

        'skip_starting_period', // should we bill the same month as starting date, or make invoice for next period
        'generate_invoice_on', // day of month when invoices are generated
        'next_period_billing'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function units()
    {
        return $this->belongsToMany(Unit::class, 'lease_units',
            'lease_id', 'unit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tenants()
    {
        return $this->belongsToMany(Tenant::class, 'lease_tenants',
            'lease_id', 'tenant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lease_type()
    {
        return $this->belongsTo(LeaseType::class, 'lease_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lease_mode()
    {
        return $this->belongsTo(LeaseMode::class, 'lease_mode_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function utility_deposits()
    {
        return $this->belongsToMany(Utility::class, 'lease_utility_deposits',
            'lease_id', 'utility_id')
            ->withPivot('deposit_amount');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function utility_charges()
    {
        return $this->belongsToMany(Utility::class, 'lease_utility_charges',
            'lease_id', 'utility_id')
            ->withPivot('utility_unit_cost', 'utility_base_fee');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function extra_charges()
    {
        return $this->belongsToMany(ExtraCharge::class, 'lease_extra_charges',
            'lease_id', 'extra_charge_id')
            ->withPivot('extra_charge_value', 'extra_charge_type', 'extra_charge_frequency');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function late_fees()
    {
        return $this->belongsToMany(LateFee::class, 'lease_late_fees',
            'lease_id', 'late_fee_id')
            ->withPivot('late_fee_value', 'late_fee_type', 'late_fee_frequency', 'grace_period');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account()
    {
        return $this->hasOne(Account::class, 'account_name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'lease_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function payment_methods()
    {
        return $this->belongsToMany(PaymentMethod::class, 'payment_method_leases',
            'lease_id', 'payment_method_id')
            ->withPivot('payment_method_description');
    }

	  /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function terminate_user()
    {
        return $this->belongsTo(User::class, 'terminated_by');
    }


    static function boot()
    {
        try {
            parent::boot();
            static::creating(function ($model) {
                $latest = $model->latest()->first();
                $leaseSettings = LeaseSetting::first();
               
                $leasePrefix = 'LS';
                if (isset($leaseSettings))
                    $leasePrefix = $leaseSettings->lease_number_prefix;
                if ($latest) {
                    $string = preg_replace("/[^0-9\.]/", '', $latest->lease_number);
                    $model->lease_number =  $leasePrefix . sprintf('%04d', $string+1);
                }else{
                    $model->lease_number = $leasePrefix.'0001';
                }

              
            });
        } catch (\Exception $e) {
            return false;
        }
    }
}
