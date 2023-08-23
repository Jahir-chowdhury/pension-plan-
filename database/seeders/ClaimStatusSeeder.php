<?php

namespace Database\Seeders;

use App\Models\ClaimStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class ClaimStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            ['name'=>'Underprocessing','Description'=>'Underprocessing'],
            ['name'=>'Under Investigation','Description'=>'Under investigation'],
            ['name'=>'Documents Required','Description'=>'Documents Required'],
            ['name'=>'With Discussion','Description'=>'With Discussion'],
            ['name'=>'Regreted','Description'=>'Regreted'],
            ['name'=>'Settled','Description'=>'Settled'],
        ];

        ClaimStatus::insert($array);
    }
}
