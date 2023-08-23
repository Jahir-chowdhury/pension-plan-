<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organization;
use App\Models\PaymentMethod;

class Collection extends Model
{
    use HasFactory;
    protected $table = 'gpp_org_collections';

    protected $guarded = [];

    public function organization ()
    {
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
}
