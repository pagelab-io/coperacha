<?php

namespace App\Transactions;

use App\Entities\Category;
use App\Entities\MemberSetting;
use App\Entities\Setting;
use App\Entities\SettingOption;
use App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Repositories\MemberSettingRepository;
use App\Repositories\SettingOptionRepository;
use App\Repositories\SettingRepository;

class TxUpdateMoneybox extends PLTransaction{

    //region attributes

    /**
     * @var SettingRepository
     */
    private $_settingRepository;

    /**
     * @var SettingOptionRepository
     */
    private $_optionRepository;

    /**
     * @var MemberSettingRepository
     */
    private $_memberSetingRepository;

    //endregion

    //region Static
    //endregion

    public function __construct(SettingRepository$settingRepository, SettingOptionRepository $settingOptionRepository, MemberSettingRepository $memberSettingRepository)
    {
        $this->_settingRepository       = $settingRepository;
        $this->_optionRepository        = $settingOptionRepository;
        $this->_memberSetingRepository  = $memberSettingRepository;
    }

    //region Private Methods
    //endregion

    //region Methods

    /**
     * @param PLRequest $request
     * @param array $params
     * @return PLResponse|null
     * @throws \Exception
     */
    public function executeTx(PLRequest $request, $params = array())
    {
        $moneybox = $params['moneybox'];
        $category = $params['category'];
        $response = null;

        try {

            \DB::beginTransaction();

            \Log::info("=== Updating moneybox ... ===");
            if ($request->exists('name')) $moneybox->name = $request->get('name');
            if ($request->exists('goal_amount')) $moneybox->goal_amount = $request->get('goal_amount');
            if ($request->exists('end_date')) $moneybox->end_date = $request->get('end_date');
            if ($request->exists('description')) $moneybox->description = $request->get('description');
            if ($category instanceof Category)
                if ($request->exists('category_id'))
                    $moneybox->category_id = $category->id;

            if (!$moneybox->save()) throw new \Exception("Unable to update Moneybox", -1);
            \Log::info("=== Moneybox updated successfully : " . $moneybox . " ===");

            if ($request->exists('settings')) {

                \Log::info("=== Creating settings for moneybox ===");
                $settings = json_decode($request->get('settings'),true);
                $memberSettings = [];

                \Log::info("=== Build MemberSettingsArray ===");
                foreach($settings as $setting){
                    if ($this->_memberSetingRepository->byId($setting['member_setting_id']) instanceof MemberSetting) {
                        if ($this->_settingRepository->byId($setting['setting_id']) instanceof Setting) {
                            if ($this->_optionRepository->byId($setting['option_id']) instanceof SettingOption) {

                                $memberSetting = $this->_memberSetingRepository->byId($setting['member_setting_id']);
                                $memberSetting->setting_id = $setting['setting_id'];
                                $memberSetting->option_id = $setting['option_id'];
                                $memberSetting->value = $setting['value'];
                                array_push($memberSettings, $memberSetting);

                            } else throw new \Exception("Option does not exist", -1);
                        } else throw new \Exception("Setting does not exist", -1);
                    } else throw new \Exception("MemberSetting does not exist", -1);
                }

                \Log::info("=== Iterating in MemberSettingsArray for update ===");
                foreach ($memberSettings as $memberSetting) {
                    if (!$memberSetting->save()) throw new \Exception("Unable to update MemberSetting", -1);
                }
            }

            \DB::commit();

        } catch(\Exception $ex) {
            \Log::info("=== Executing rollback ... ===");
            \DB::rollback();
            throw $ex;
        }

        $response = new PLResponse();
        $response->data = $moneybox;
        return $response;
    }

    public function a(){}

    //endregion
}