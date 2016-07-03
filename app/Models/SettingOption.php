<?php

namespace App\Models;

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
        return $this->belongsTo('App\Models\Setting');
    }

    //endregion

    //region Private Methods
    //endregion
}
