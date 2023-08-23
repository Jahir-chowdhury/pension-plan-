<?php

namespace App\Services;
use App\Models\OrganizationContact;

class OrganizationService {
    
    public function getOrganizationContacts()
    {
        return OrganizationContact::where('status', 1)
                    ->whereNull('organization_id')
                    ->get();
    }

    

}
