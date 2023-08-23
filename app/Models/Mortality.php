<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mortality extends Model
{
    use HasFactory;
    protected $table = 'gpp_mortalities';
    protected $guarded = [];
}
