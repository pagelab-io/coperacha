<?php

namespace App\Utilities;

use Carbon\Carbon;

class PLUtils {

    /**
     * Return a formatted string for male or female gender
     *
     * @param $gender - [H,M]
     * @return string - [Hombre, Mujer]
     */
    public static function getStringGender($gender){
        switch ($gender) {
            case 'H' : return PLConstants::PERSON_GENDER_H;
            case 'M' : return PLConstants::PERSON_GENDER_M;
            default: return PLConstants::PERSON_GENDER_H;
        }
    }

    /**
     * @param $date - 2016-09-12 21:48:02
     * @param string $format
     * @return string
     */
    public static function getStringDate($date, $format = '')
    {
        $date = explode('-', $date);
        switch($format){
            case 'mm-YY' : return self::getMonthToString($date[1])." ".$date[0];
            default: return explode(' ',$date[2])[0]." de ".self::getMonthToString($date[1])." de ".$date[0];
        }

    }

    /**
     * Gets a date in YYYY-mm-dd format and return the age
     * @param $date
     * @return int|string
     */
    public static function getAge($date)
    {
        if ($date == '0000-00-00')
            return '--';

        $dates = explode('-', $date);
        return Carbon::createFromDate($dates[0],$dates[1],$dates[2])->age." años";
    }

    /**
     * Gets a payment method letter and return the string for that method
     *
     * @param $method - P
     * @return string - PayPal
     */
    public static function getPaymentMethodString($method)
    {
        switch($method){
            case PLConstants::PAYMENT_PAYPAL : return PLConstants::PAYMENT_PAYPAL_STRING; break;
            case PLConstants::PAYMENT_SPEI : return PLConstants::PAYMENT_SPEI_STRING; break;
            case PLConstants::PAYMENT_OXXO : return PLConstants::PAYMENT_OXXO_STRING; break;
            default : return "";
        }
    }

    /**
     * Gets a number and return the selected status for each moneybox.
     * @param $status - 1
     * @return string - Activo
     */
    public static function getMoneyboxStatusString($status)
    {
        return $status == 1 ? PLConstants::MONEYBOX_STATUS_ACTIVE : PLConstants::MONEYBOX_STATUS_INACTIVE;
    }

    //region private methods

    /**
     * Gets a number and return the string name for month
     * @param $month - 01
     * @return string - Enero
     */
    private static function getMonthToString($month)
    {
        switch($month){
            case '01' : return 'Enero';  break;
            case '02' : return 'Febrero';  break;
            case '03' : return 'Marzo';  break;
            case '04' : return 'Abril';  break;
            case '05' : return 'Mayo';  break;
            case '06' : return 'Junio';  break;
            case '07' : return 'Julio';  break;
            case '08' : return 'Agosto';  break;
            case '09' : return 'Septiembre';  break;
            case '10' : return 'Octubre';  break;
            case '11' : return 'Noviembre';  break;
            case '12' : return 'Diciembre';  break;
            default   : return 'Enero';  break;
        }
    }
    //endregion

}