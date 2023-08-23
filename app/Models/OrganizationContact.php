<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationContact extends Model
{
    use HasFactory;
    protected $table = 'gpp_organization_contacts';
    protected $guarded = [];
}
