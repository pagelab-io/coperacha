<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * number_between:min,max
         * Return true if an attribute is numeric and is between min and max parameters
         */
        Validator::extend('number_between', function($attribute, $value, $parameters, $validator) {
            $min = intval($parameters[0]);
            $max = intval($parameters[1]);
            $val = intval($value);
            if(!is_numeric($min) || !is_numeric($max) || !is_numeric($val)) return false;
            return ($val >= $min && $val <= $max) ? true : false;
        });
        Validator::replacer('number_between', function($message, $attribute, $rule, $parameters)
        {
            return str_replace(array(':min', ':max'), $parameters, $message);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
