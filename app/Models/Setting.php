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
    protected $table = 'settings';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = ['name', 'path', 'type'];
    //endregion

    //region Static Methods
    //endregion

    //region Methods

    /**
     * Define the relation between Setting and SettingOptions
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany('App\Models\SettingOption');
    }

    //endregion

    //region Private Methods
    //endregion
}
