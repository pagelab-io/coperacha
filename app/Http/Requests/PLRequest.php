<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 19/06/2016
 * Time: 01:28 AM
 */

namespace App\Http\Requests;

use Illuminate\Http\Request;

class PLRequest extends Request{

    //region Attributes
    //endregion

    //region Static Methods
    //endregion

    //region Private Methods
    private function register()
    {
        return [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'password' => 'required',
        ];
    }

    private function register_messages()
    {
        return [
            'name.required' => 'El campo name es requerido',
            'lastname.required' => 'El campo lastname es requerido',
            'email.required' => 'El campo email es requerido',
            'password.required' => 'EL campo password es requeridoa'
        ];
    }
    //endregion

    //region Methods

    /**
     * Get the rules for every method that need validations
     * @return array
     */
    public function rules()
    {
        if (!$this->get('method')){
            return ['method'=>'required'];
        } else {
            switch($this->get('method')){
                case "register": return $this->register();
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
        if (!$this->get('method')){
            return ['method.required'=>'El campo method es requerido'];
        } else {
            switch($this->get('method')){
                case "register": return $this->register_messages();
                default: return [];;
            }
        }

    }
    //endregion

}