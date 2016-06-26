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
use App\Validations\MoneyboxValidation;
use App\Validations\RegisterValidation;
use App\Validations\SettingValidation;
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
                case "createCategory": return CategoryValidation::rules();     // TODO : change to createCategory
                case "createSetting": return SettingValidation::rules();
                case "createMoneybox": return MoneyboxValidation::rules();
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
            case "createCategory": return CategoryValidation::messages();
            case "createSetting": return SettingValidation::messages();
            case "createMoneybox": return MoneyboxValidation::messages();
            default: return [];
        }

    }
    //endregion

}
