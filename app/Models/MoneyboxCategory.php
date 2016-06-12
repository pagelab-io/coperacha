<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoneyboxCategory extends Model
{
    //region attributes
    /**
     * The database table used by the model
     * @var string
     */
    protected $table = 'moneyboxCategories';

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
     * Define the relation between MoneyboxCategory and Moneybox
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function moneybox()
    {
        return $this->hasMany('App\Models\Moneybox');
    }
    //endregion

    //region Private Methods
    //endregion
}
