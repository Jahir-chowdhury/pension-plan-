<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $table = 'gpp_documents';
    public function claims() {
        return $this->belongsTo(\App\Models\Claim::class,'claim_id','id');
    }
}
