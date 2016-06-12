<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //region attributes
    /**
     * The database table used by the model
     * @var string
     */
    protected $table = 'users';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = ['name'];
    //endregion

    //region Static Methods
    //endregion

    //region Methods

    /**
     * Define the relation between Setting and MoneyboxSetting
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function moneyboxSettings()
    {
        return $this->hasMany('App\Models\MoneyboxSettings');
    }

    //endregion

    //region Private Methods
    //endregion
}
