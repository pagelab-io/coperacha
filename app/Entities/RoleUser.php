<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    //region attributes
    /**
     * The database table used by the model
     * @var string
     */
    protected $table = 'role_users';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = ['user_id', 'role_id'];
    //endregion

    //region Static Methods
    //endregion

    //region Methods
    //endregion

    //region Private Methods
    //endregion
}
