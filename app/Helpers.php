<?php
namespace App;
use Illuminate\Support\Facades\Schema;

class Helpers {
    const GENDERS = [
        'M' => 'Male',
        'F' => 'Female',
        'O' => 'Others'
    ];

}

if ( !function_exists('getColumnsArray') ) {
    function getColumnsArray($tableName)
    {
        $arr = array_flip( Schema::getColumnListing($tableName) );
        foreach ($arr as $column=>$value) {
            $arr[$column] = '';
        }
        return $arr;
    }
}

if ( !function_exists('getHumanGenders') ) {
    function getHumanGenders() 
    {
        return [
            'M' => 'Male',
            'F' => 'Female',
            'O' => 'Others'
        ];
    }
}

if ( !function_exists('getMaritialStatuses') ) {
    function getMaritialStatuses()
    {
        return [
            'M' => 'Married',
            'S' => 'Single',
            'D' => 'Dovorced',
            'W' => 'Widow'
        ];
    }
}

