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
     * @var MoneyboxRepository
     */
    private $_moneyboxRepository;

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
        MoneyboxRepository $moneyboxRepository,
        SettingRepository $settingRepository,
        SettingOptionRepository $optionRepository){
        parent::__construct($app);
        $this->_memberSetting = $memberSetting;
        $this->_settingRepository = $settingRepository;
        $this->_moneyboxRepository = $moneyboxRepository;
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
     * @param Moneybox $moneybox
     * @throws \Exception
     */
    public function setSettings(PLRequest $request, Moneybox $moneybox)
    {
        \Log::info("=== Creating settings for moneybox ===");
        $settings = json_decode($request->get('settings'),true);
        $moneyboxSettings = [];

        \Log::info("=== Build MoneyboxSettingsArray ===");
        foreach($settings as $setting){
            try {
                if ($this->_settingRepository->byId($setting['setting_id']) instanceof Setting) {
                    if ($this->_optionRepository->byId($setting['option_id']) instanceof SettingOption) {
                        $ms = new MemberSetting();
                        $ms->setting_id = $setting['setting_id'];
                        $ms->option_id = $setting['option_id'];
                        $ms->owner_id = ($request->get('owner') == 'moneybox') ? $moneybox->id : 1;
                        $ms->owner = $request->get('owner');
                        $ms->value = $setting['value'];
                        array_push($moneyboxSettings, $ms);
                    }
                }
            }
            catch(\Exception $ex){
                throw new \Exception("Setting or Option does not exist", -1, $ex);
            }
        }

        \Log::info("=== Iterating in MoneyboxSettingsArray for insert ===");
        foreach ($moneyboxSettings as $moneyboxSetting) {
            if (!$moneyboxSetting->save()) throw new \Exception("Unable to create MemberSetting", -1);
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

    //endregion

    //region Private Methods
    //endregion
}