<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberCollectionHistory extends Model
{
    use HasFactory;
    protected $table = 'gpp_member_collection_histories';
    protected $guarded = [];
    public function organizationCollection() {
        return $this->belongsTo(\App\Models\Collection::class,'org_collection_id','id');
    }

}
