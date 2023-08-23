<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;
    protected $table = 'gpp_claims';
    protected $guarded = [];
    public function documents ()
    {
        return $this->hasMany(\App\Models\Document::class, 'claim_id', 'id');
    }
    public function claimsStatus() {
        return $this->belongsTo(\App\Models\ClaimStatus::class,'claim_status','id');
    }
    public function claimPayment() {
        return $this->belongsTo(\App\Models\ClaimPayment::class,'claim_id','id');
    }
    public function member() {
        return $this->belongsTo(\App\Models\Member::class,'member_id','member_id');
    }
    public function organization() {
        return $this->belongsTo(\App\Models\Organization::class,'organization_id','id');
    }

}
