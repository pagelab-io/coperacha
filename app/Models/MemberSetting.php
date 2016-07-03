<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberSetting extends Model
{
    //region attributes
    /**
     * The database table used by the model
     * @var string
     */
    protected $table = 'member_settings';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = ['setting_id', 'option_id', 'owner_id', 'owner', 'value'];
    //endregion

    //region Static Methods
    //endregion

    //region Methods
    //endregion

    //region Private Methods
    //endregion
}
