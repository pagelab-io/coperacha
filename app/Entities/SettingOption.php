<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class SettingOption extends Model
{
    //region attributes
    /**
     * The database table used by the model
     * @var string
     */
    protected $table = 'setting_options';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = ['setting_id', 'name', 'subtype'];
    //endregion

    //region Static Methods
    //endregion

    //region Methods

    /**
     * Define the relation between SettingOption and Setting
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function setting()
    {
        return $this->belongsTo('App\Entities\Setting');
    }

    //endregion

    //region Private Methods
    //endregion
}
