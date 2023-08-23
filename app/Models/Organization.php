<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;
use App\Models\Contract;
use App\Models\Claim;

class Organization extends Model
{
    use HasFactory;
    protected $table = 'gpp_organizations';
    protected $guarded = [];

    public function activeMembers()
    {
        return $this->members()->where('is_active', 1);
    }

    public function members ()
    {
        return $this->hasMany(\App\Models\Member::class, 'org_id', 'id');
    }
    public function contract ()
    {
        return $this->hasMany(\App\Models\Contract::class, 'organization_id', 'id');
    }
    public function claims ()
    {
        return $this->hasMany(\App\Models\Claim::class, 'organization_id', 'id');
    }

}
