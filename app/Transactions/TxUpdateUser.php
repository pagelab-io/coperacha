<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 17/07/2016
 * Time: 02:52 PM
 */

namespace App\Transactions;

use App\Http\Requests\PLRequest;

class TxUpdateUser extends PLTransaction{

    //region Attributes
    //endregion

    //region Static
    //endregion

    //region Private methods
    //endregion

    //region Methods

    /**
     * Execute the User update transaction
     *
     * @param PLRequest $request
     * @param array $params
     * @throws \Exception
     * @return array
     */
    public function executeTx(PLRequest $request, $params = array())
    {

        $user = $params['user'];
        $person = $params['person'];
        $response = null;

        try {
            \DB::beginTransaction();

            \Log::info("=== Updating user ===");
            if ($request->exists('email')) $user->email = $request->get('email');
            if ($request->exists('username')) $user->username = $request->get('username');
            if (!$user->save()) throw new \Exception("Unable to update User", -1);
            \Log::info("=== User updated successfully : ".$user." ===");

            \Log::info("=== Updating person ===");
            if ($request->exists('name')) $person->name = $request->get('name');
            if ($request->exists('lastname')) $person->lastname = $request->get('lastname');
            if ($request->exists('birthday')) $person->birthday = $request->get('birthday');
            if ($request->exists('gender')) $person->gender = $request->get('gender');
            if ($request->exists('city')) $person->city = $request->get('city');
            if ($request->exists('country')) $person->country = $request->get('country');
            if (!$person->save()) throw new \Exception("Unable to update Person", -1);
            \Log::info("=== Person updated successfully : ".$person." ===");

            \DB::commit();
        }catch(\Exception $ex){
            \Log::info("=== Executing rollback ... ===");
            \DB::rollback();
            throw $ex;
        }

        return $response = ['person' => $person, 'user' => $user];
    }

    //endregion
}