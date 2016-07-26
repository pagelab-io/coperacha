<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 25/07/2016
 * Time: 11:13 PM
 */

namespace App\Utilities;

use Carbon\Carbon;

class PLDateTime {

    /**
     * convert a string in format Y-m-d in a Carbon Object
     *
     * @param $date
     * @return Carbon
     */
    public static function toCarbon($date)
    {
        $array_date = explode('-', $date);
        $year   = $array_date[0];
        $month  = $array_date[1];
        $day    = $array_date[2];
        return Carbon::createFromDate($year, $month, $day);
    }

}