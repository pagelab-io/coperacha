<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 01:11 PM
 */

namespace App\Repositories;

use App\Http\Requests\PLRequest;
use App\Models\Moneybox;
use App\Models\Participant;
use App\Models\Setting;
use App\Models\SettingOption;
use Illuminate\Container\Container as App;
use App\Models\MemberSetting;

class MemberSettingRepository extends BaseRepository{

    //region attributes

    /**
     * @var MemberSetting
     */
    private $_memberSetting;

    /**
     * @var SettingRepository
     */
    private $_settingRepository;

    /**
     * @var SettingOptionRepository
     */
    private $_optionRepository;

    //endregion

    //region Static
    //endregion

    public function __construct(
        App $app,
        MemberSetting $memberSetting,
        SettingRepository $settingRepository,
        SettingOptionRepository $optionRepository){

        parent::__construct($app);
        $this->_memberSetting = $memberSetting;
        $this->_settingRepository = $settingRepository;
        $this->_optionRepository = $optionRepository;
    }

    //region Methods

    /**
     * return namespace for MoneyboxSetting model
     * @return mixed
     */
    function model()
    {
        return 'App\Models\MemberSetting';
    }

    /**
     * Create the relations between moneybox and settings
     *
     * @param PLRequest $request
     * @param Moneybox|Participant $member
     * @throws \Exception
     */
    public function setSettings(PLRequest $request, $member)
    {
        \Log::info("=== Creating settings for moneybox ===");
        $settings = json_decode($request->get('settings'),true);
        $memberSettings = [];

        \Log::info("=== Build MemberSettingsArray ===");
        foreach($settings as $setting){
            try {
                if ($this->_settingRepository->byId($setting['setting_id']) instanceof Setting) {
                    if ($this->_optionRepository->byId($setting['option_id']) instanceof SettingOption) {
                        $ms = new MemberSetting();
                        $ms->setting_id = $setting['setting_id'];
                        $ms->option_id = $setting['option_id'];
                        $ms->owner_id = $member->id;
                        $ms->owner = $request->get('owner');
                        $ms->value = $setting['value'];
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
    }

    /**
     * Update the member settings
     *
     * @param PLRequest $request
     * @param $member
     * @throws \Exception
     */
    public function updateSettings(PLRequest $request, $member)
    {
        \Log::info("=== Creating settings for moneybox ===");
        $settings = json_decode($request->get('settings'),true);
        $memberSettings = [];

        \Log::info("=== Build MemberSettingsArray ===");
        foreach($settings as $setting){
            try {
                if ($this->byId($setting['member_setting_id']) instanceof MemberSetting) {
                    if ($this->_settingRepository->byId($setting['setting_id']) instanceof Setting) {
                        if ($this->_optionRepository->byId($setting['option_id']) instanceof SettingOption) {
                            $memberSetting = $this->byId($setting['member_setting_id']);
                            $memberSetting->setting_id = $setting['setting_id'];
                            $memberSetting->option_id = $setting['option_id'];
                            $memberSetting->value = $setting['value'];
                            array_push($memberSettings, $memberSetting);
                        }
                    }

                }
            }
            catch(\Exception $ex){
                throw new \Exception("MemberSetting does not exist", -1, $ex);
            }
        }

        \Log::info("=== Iterating in MemberSettingsArray for update ===");
        foreach ($memberSettings as $memberSetting) {
            if (!$memberSetting->save()) throw new \Exception("Unable to update MemberSetting", -1);
        }
    }

    /**
     * Delete the MoneyboxSettings associated with a Moneybox if exist
     *
     * @param $owner
     * @param $idowner
     * @throws \Exception
     */
    public function deleteSettings($owner, $idowner)
    {
        \Log::info("=== Deleting MemberSettings ===");

        try {
            $settings = MemberSetting::where(['owner_id' => $idowner, 'owner' => $owner])->get();
            \Log::info($settings);
            if (count($settings) > 0) {
                foreach ($settings as $setting){
                    $setting->delete();
                }
            }
        } catch(\Exception $ex) {
            throw new \Exception("Error deleting membersettings",-1, $ex);
        }

        \Log::info("MemberSettings deleted");
    }

    public function getSettings($owner, $idowner)
    {
        return MemberSetting::where(['owner_id' => $idowner, 'owner' => $owner])->get();
    }

    //endregion

    //region Private Methods
    //endregion
}