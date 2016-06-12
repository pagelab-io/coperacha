<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonRelationship extends Model
{
    //region attributes
    /**
     * The database table used by the model
     * @var string
     */
    protected $table = 'personrelationships';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = ['person_id', 'friend_id'];
    //endregion

    //region Static Methods
    //endregion

    //region Methods
    //endregion

    //region Private Methods
    //endregion
}
