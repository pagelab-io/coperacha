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
use Illuminate\Container\Container as App;
use App\Models\MoneyboxSetting;

class MoneyboxSettingRepository extends BaseRepository{

    //region attributes

    /**
     * @var MoneyboxSetting
     */
    private $_moneyboxSetting;

    /**
     * @var SettingRepository
     */
    private $_settingRepository;

    /**
     * @var MoneyboxRepository
     */
    private $_moneyboxRepository;

    //endregion

    //region Static
    //endregion

    public function __construct(MoneyboxSetting $moneyboxSetting, App $app, MoneyboxRepository $moneyboxRepository, SettingRepository $settingRepository){
        parent::__construct($app);
        $this->_moneyboxSetting = $moneyboxSetting;
        $this->_settingRepository = $settingRepository;
        $this->_moneyboxRepository = $moneyboxRepository;
    }

    //region Methods

    /**
     * return namespace for MoneyboxSetting model
     * @return mixed
     */
    function model()
    {
        return 'App\Models\MoneyboxSetting';
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
                if($this->_settingRepository->byId($setting['setting_id']) instanceof Setting){
                    $ms = new MoneyboxSetting();
                    $ms->setting_id = $setting['setting_id'];
                    $ms->moneybox_id = $moneybox->id;
                    $ms->value = $setting['value'];
                    array_push($moneyboxSettings, $ms);
                }
            }
            catch(\Exception $ex){
                throw new \Exception("Setting ".$setting['setting_id']." does not exist",-1,$ex);
            }
        }

        \Log::info("=== Iterating in MoneyboxSettingsArray for insert ===");
        foreach($moneyboxSettings as $moneyboxSetting){
            if (!$moneyboxSetting->save()) throw new \Exception("Unable to create MoneyboxSetting", -1);
        }
    }

    /**
     * Delete the MoneyboxSettings associated with a Moneybox if exist
     *
     * @param Moneybox $moneybox
     * @throws \Exception
     */
    public function deleteSettings(Moneybox $moneybox)
    {

        \Log::info("deleting MoneyboxSettings");
        try {
            if ($this->_moneyboxRepository->byId($moneybox->id) instanceof Moneybox) {
                $moneyboxSettings = $moneybox->settings();
                if (count($moneyboxSettings) > 0) {
                    foreach ($moneyboxSettings as $moneyboxSetting) {
                        $moneyboxSetting->delete();
                    }
                }
            }
        } catch(\Exception $ex) {
            throw new \Exception("Moneybox does not exist",-1,$ex);
        }
        \Log::info("MoneyboxSettings deleted");
    }

    //endregion

    //region Private Methods
    //endregion
}