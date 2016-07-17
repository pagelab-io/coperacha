<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //region attributes
    /**
     * The database table used by the model
     * @var string
     */
    protected $table = 'roles';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = ['name'];
    //endregion

    //region Static Methods
    //endregion

    //region Methods
    //endregion

    //region Private Methods
    //endregion
}
