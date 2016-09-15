<?php

namespace App\Utilities;

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

} 