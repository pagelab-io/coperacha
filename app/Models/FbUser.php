<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FbUser extends Model
{
    //region attributes
    /**
     * The database table used by the model
     * @var string
     */
    protected $table = 'fbusers';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = ['user_id','fb_uid'];

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
        return $this->belongsTo('App\Models\User');
    }
    //endregion

    //region Private Methods
    //endregion
}
