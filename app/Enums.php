<?php 

namespace App;

abstract class Enums {

    // Human Genders 
    const HUMAN_GENDERS = [
        'MALE' => 'Male',
        'FEMALE' => 'Female',
        'OTHERS' => 'Others',
    ];
    
    // Human Maritial Status
    const HUMAN_MARITIAL_STATUSES = [
        'MARRIED' => 'Married',
        'SINGLE' => 'Single',
        'WIDOW' => 'Widow'
    ];
    
    // Contract Active Status
    const ORGANIZATION_STATUSES = [
        'ACTIVE' => 1,
        'INACTIVE' => 0
    ];
    const MEMBER_STATUSES = [
        'ACTIVE' => 1,
        'INACTIVE' => 0
    ];
    // Contract Active Status
    const CONTRACT_STATUSES = [
        'ACTIVE' => 1,
        'INACTIVE' => 0
    ];

    // Payment method Status
    const PAYMENT_METHOD_STATUSES = [
        'ACTIVE' => 1,
        'INACTIVE' => 0,
    ];
    const PAYMENT_TRANSACTION_ID_REQUIRED = [
        'YES' => 1,
        'NO' => 0,
    ];
    const CLAIM_APPROVE = [
        'APPROVE' => 1,
        'REVIEW' => 0,
    ];

    const CLAIM_TYPES = [
        '0' => 'Death',
        '1' => 'Withdrawal with plan A',
        '2' => 'Withdrawal with plan B',
        '3' => 'Withdrawal with plan C',
    ];
    const CLAIM_STATUS = [
        'UNDER PTOCESS' => 'Under Process',
        'WITHDRAWAL WITH PLAN A' => 'Documents Required',
        'WITHDRAWAL WITH PLAN B' => 'With Held',
        'WITHDRAWAL WITH PLAN C' => 'Withdrawal with plan C',
    ];

    const CLAIM_PAYABLE_TOS = [
        'CLIENT', 'ORGANIZATION', 'NOMINEE'
    ];

}