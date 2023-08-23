<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $table = 'gpp_payment_methods';
    protected $fillable = ['method_name','bank_name','active_status','transaction_id_required','created_by','account_no','branch','branch_routing_no'];
}
