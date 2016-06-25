<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 19/06/2016
 * Time: 01:28 AM
 */

namespace App\Http\Requests;

use App\Validations\CategoryValidation;
use App\Validations\LoginValidation;
use App\Validations\RegisterValidation;
use Illuminate\Http\Request;

class PLRequest extends Request{

    //region Attributes
    //endregion

    //region Static Methods
    //endregion

    //region Private Methods
    //endregion

    //region Methods

    /**
     * Get the rules for every method that need validations
     * @return array
     */
    public function rules()
    {
        if (!$this->get('method')){
            return ['method'=>'required']; // method field required in any request
        } else {
            switch($this->get('method')){
                case "register": return RegisterValidation::rules();
                case "login": return LoginValidation::rules();
                case "addCategory": return CategoryValidation::rules();
                default: return [];
            }
        }

    }

    /**
     * Get the messages for every method that need validations
     * @return array
     */
    public function messages()
    {
        switch($this->get('method')){
            case "register": return RegisterValidation::messages();
            case "login": return LoginValidation::messages();
            case "addCategory": return CategoryValidation::messages();
            default: return [];
        }

    }
    //endregion

}