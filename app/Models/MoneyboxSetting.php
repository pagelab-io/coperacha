<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoneyboxSetting extends Model
{
    //region attributes
    /**
     * The database table used by the model
     * @var string
     */
    protected $table = 'moneybox_settings';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = ['setting_id', 'moneybox_id', 'value'];
    //endregion

    //region Static Methods
    //endregion

    //region Methods

    /**
     * Define the relation between MoneyboxSetting and Moneybox
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function moneybox()
    {
        return $this->belongsTo('App\Models\Moneybox');
    }

    /**
     * Define the relation between MoneyboxSetting and Setting
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
