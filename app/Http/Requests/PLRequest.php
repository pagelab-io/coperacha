<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 19/06/2016
 * Time: 01:28 AM
 */

namespace App\Http\Requests;

use App\Validations\AuthValidation;
use App\Validations\CategoryValidation;
use App\Validations\LoginValidation;
use App\Validations\MoneyboxValidation;
use App\Validations\ParticipantValidation;
use App\Validations\PaymentValidation;
use App\Validations\RegisterValidation;
use App\Validations\SettingOptionValidation;
use App\Validations\SettingValidation;
use App\Validations\UserValidation;
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
                case "createCategory": return CategoryValidation::rules();
                case "createSetting": return SettingValidation::rules();
                case "createOption": return SettingOptionValidation::rules();
                case "createMoneybox": return MoneyboxValidation::rules();
                case "listMoneybox": return MoneyboxValidation::list_rules();
                case "listSetting": return SettingValidation::list_rules();
                case "getProfile": return UserValidation::profile_rules();
                case "updateProfile": return UserValidation::update_rules();
                case "changePassword": return UserValidation::change_password_rules();
                case "recoveryPassword": return AuthValidation::password_recovery_rules();
                case "updateMoneybox": return MoneyboxValidation::update_moneybox();
                case "createParticipant": return ParticipantValidation::rules();
                case "createPayment": return PaymentValidation::rules();
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
            case "createOption": return SettingOptionValidation::messages();
            case "createMoneybox": return MoneyboxValidation::messages();
            case "listMoneybox": return MoneyboxValidation::messages();
            case "listSetting": return SettingValidation::messages();
            case "getProfile": return UserValidation::messages();
            case "updateProfile": return UserValidation::messages();
            case "changePassword": return UserValidation::messages();
            case "recoveryPassword": return AuthValidation::messages();
            case "updateMoneybox": return MoneyboxValidation::messages();
            case "createParticipant": return ParticipantValidation::messages();
            case "createPayment": return PaymentValidation::messages();
            default: return [];
        }

    }
    //endregion

}
