<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class MembersBulkUpload implements ToModel, WithHeadingRow {
    
    public function model(array $row)
    {
        
        return new Member();
    }

    
}