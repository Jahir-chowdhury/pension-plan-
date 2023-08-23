<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'gpp_members';
    //
    public function claims()
    {
        return $this->hasMany(\App\Models\Member::class, 'member_id', 'member_id');
    }
}
