<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class User extends Model
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
    protected $fillable = ['person_id', 'email', 'password', 'username', 'first_access'];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = ['password'];

    //endregion

    //region Static Methods
    //endregion

    //region Methods

    /**
     * Define the relation between User and Person
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('App\Models\Person');
    }

    //endregion

    //region Private Methods
    //endregion
}
