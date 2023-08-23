<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimPayment extends Model
{
    use HasFactory;
    protected $table = 'gpp_claim_payments';
    public function member() {
        return $this->belongsTo(\App\Models\Member::class,'member_id','member_id');
    }
    public function organization() {
        return $this->belongsTo(\App\Models\Organization::class,'org_id','id');
    }
    public function claim() {
        return $this->belongsTo(\App\Models\Claim::class,'claim_id','id');
    }
    public function paymentMethod() {
        return $this->belongsTo(\App\Models\PaymentMethod::class,'payment_method','id');
    }
}
