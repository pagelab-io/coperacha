<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    //region attributes
    /**
     * The database table used by the model
     * @var string
     */
    protected $table = 'persons';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = ['name', 'lastname', 'birthday', 'gender'];

    //endregion

    //region Static Methods
    //endregion

    //region Methods

    /**
     * Define the relation between Person and MoneyBoxPayment
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Models\MoneyboxPayment');
    }

    /**
     * Define the relation between Person and PersonRelationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personMoneyboxes()
    {
        return $this->hasMany('App\Models\PersonMoneybox');
    }

    //endregion

    //region Private Methods
    //endregion
}
