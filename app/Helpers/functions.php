<?php

use App\Models\User;

function HasPermissions($obj, $permissions)
{
    $hasPermission = true;
    foreach ($permissions as $permission) {
        if (!$obj->hasPermissionTo($permission->name)) {
            $hasPermission = false;
            return $hasPermission;
        }
    }
    return $hasPermission;
}


function taka_format($amount)
{
    if (!is_numeric($amount)) {
        return false;
    }
    $formattedAmount = "";
    $amountArray = explode(".", $amount);
    $amount = $amountArray[0];
    $amountAfterDot = isset($amountArray[1]) ? $amountArray[1] : "";
    if (strlen($amount) < 4) {
        if ($amountAfterDot) {
            return $amount . "." . $amountAfterDot;
        }
        return $amount;
    }

    $formattedAmount .= substr($amount, -3, 3);
    $amount = substr($amount, 0, -3);
    while (strlen($amount) > 0) {
        $formattedAmount = substr($amount, -2, 2) . "," . $formattedAmount;
        $amount = substr($amount, 0, -2);
    }

    if ($amountAfterDot) {
        $formattedAmount .= "." . $amountAfterDot;
    }

    return $formattedAmount;
}
function words(float $number)
{
    $number = abs($number);
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    );
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            // $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . ' ' . $hundred;
        } else $str[] = null;
    }
    $Taka = implode('', array_reverse($str));
    $poisa = ($decimal) ? ' and ' . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Poisa' : '';
    return ($Taka ? $Taka . 'Taka ' : '') . $poisa . " only";
}
function getMonth($month)
{
    $months = array('Jan', 'Feb', 'March', 'April', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
    return $months[$month];
}

function months()
{
    $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    return $months;
}

function getMonth2($month)
{
    $months = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
    return $months[$month];
}

function is_leap_year($year)
{
    return ((($year % 4) == 0) && ((($year % 100) != 0) || (($year % 400) == 0)));
}

function getCurrentDay($date)
{
    $now = time();
    $given_date = strtotime($date);
    $datediff = $now - $given_date;
    $current_date = floor($datediff / (60 * 60 * 24));
    return $current_date;
}

function getFutureDate($date)
{
    $given_date = $date;
    $day_before = date('Y-m-d', strtotime($given_date));
    return $day_before;
}

function getTotalDay($month, $year)
{

    return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}

function getDayNUmber($date1, $date2)
{
    $datetime1 = date_create($date1);
    $datetime2 = date_create($date2);
    $interval = date_diff($datetime1, $datetime2);
    return $interval->days;
}

function formatedDate($date1, $date2)
{
    $from = date("d", strtotime($date1)) . " ";
    $from .= getMonth(+date("m", strtotime($date1)) - 1) . " ";
    $from .= date("y", strtotime($date1));
    $to = date("d", strtotime($date2)) . " ";
    $to .= getMonth(+date("m", strtotime($date2)) - 1) . " ";
    $to .= date("y", strtotime($date2));
    return $from . " To " . $to;
}

function get_months_between_dates(string $start_date, string $end_date): ?int
{
    $startDate = $start_date instanceof Datetime ? $start_date : new DateTime($start_date);
    $endDate = $end_date instanceof Datetime ? $end_date : new DateTime($end_date);
    $interval = $startDate->diff($endDate);
    $months = ($interval->y * 12) + $interval->m;

    return $startDate > $endDate ? -$months : $months;
}
function duration($date1, $date2)
{
    $datetime1 = new DateTime($date1);

    $datetime2 = new DateTime($date2);

    $difference = $datetime1->diff($datetime2);

    return $difference->y . ' years, '
        . $difference->m . ' months, '
        . $difference->d . ' days';
}
function policy_age($date1, $date2)
{
    $datetime1 = new DateTime($date1);

    $datetime2 = new DateTime($date2);

    $difference = $datetime1->diff($datetime2);

    return $difference->y . ' years, '
        . $difference->m . ' months, '
        . $difference->d . ' days';
}

function user()
{
    return User::with('roles')->where('id', auth()->user()->id)->first();
}





function policy_permissions()
{
    return [
        'policy.create',
        'policy.show',
        'policy.edit',
        'policy.delete',
        'policy.import',
    ];
}
