<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 17/07/2016
 * Time: 12:34 AM
 */

namespace App\Transactions;


use App\Entities\MemberSetting;
use App\Entities\Moneybox;
use App\Entities\Setting;
use App\Entities\SettingOption;
use App\Http\Requests\PLRequest;
use App\Repositories\SettingOptionRepository;
use App\Repositories\SettingRepository;

class TxCreateMoneybox extends PLTransaction{

    //region attributes

    /**
     * @var SettingRepository;
     */
    private $_settingRepository;

    private $_optionRepository;

    //endregion

    //region Static
    //endregion

    public function __construct(SettingRepository $settingRepository, SettingOptionRepository $optionRepository){
        $this->_settingRepository = $settingRepository;
        $this->_optionRepository = $optionRepository;
    }

    //region Private methods

    /**
     * Generate the public access URL
     * @param $name
     * @return string
     */
    private function generateURL($name)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return md5($name.substr(str_shuffle($characters), 0, 10));
    }

    //endregion

    //region methods

    /**
     * Execute the transaction to create a moneybox
     *
     * @param PLRequest $request
     * @param array $params
     * @throws \Exception
     * @return Moneybox
     */
    function executeTx(PLRequest $request, $params = array())
    {

        $moneybox = null;

        try {

            \DB::beginTransaction();

            \Log::info("=== Creating moneybox ===");
            $moneybox               = new Moneybox();
            $moneybox->category_id  = $request->get('category_id');
            $moneybox->name         = $request->get('name');
            $moneybox->goal_amount  = $request->get('goal_amount');
            $moneybox->owner        = $request->get('owner_id');
            $moneybox->end_date     = $request->get('end_date');
            $moneybox->description  = ($request->exists('description')) ? $request->get('description') : '';
            $moneybox->url          = $this->generateURL($request->get('name'));
            if (!$moneybox->save()) throw new \Exception("Unable to create Moneybox", -1);
            \Log::info("=== Moneybox created successfully : === \n".$moneybox);


            \Log::info("=== Creating settings ===");
            $settings = json_decode($request->get('settings'),true);
            $memberSettings = [];

            \Log::info("=== Build MemberSettingsArray ===");
            foreach($settings as $setting){
                try {
                    if ($this->_settingRepository->byId($setting['setting_id']) instanceof Setting) {
                        if ($this->_optionRepository->byId($setting['option_id']) instanceof SettingOption) {
                            $ms             = new MemberSetting();
                            $ms->setting_id = $setting['setting_id'];
                            $ms->option_id  = $setting['option_id'];
                            $ms->owner_id   = $moneybox->id;
                            $ms->owner      = $request->get('owner');
                            $ms->value      = $setting['value'];
                            array_push($memberSettings, $ms);
                        }
                    }
                }
                catch(\Exception $ex){
                    throw new \Exception("Setting or Option does not exist", -1, $ex);
                }
            }

            \Log::info("=== Iterating in MemberSettingsArray for insert ===");
            foreach ($memberSettings as $memberSetting) {
                if (!$memberSetting->save()) throw new \Exception("Unable to create MemberSetting", -1);
            }

            \DB::commit();
        } catch (\Exception $ex) {
            \Log::info("=== Executing rollback ... ===");
            \DB::rollback();
            throw $ex;
        }

        return  $moneybox;
    }

    //endregion
}