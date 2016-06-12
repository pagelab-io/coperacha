<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moneybox extends Model
{
    //region attributes
    /**
     * The database table used by the model
     * @var string
     */
    protected $table = 'moneyboxes';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = ['moneyboxcategory_id', 'name', 'goal_amount', 'collected_amount', 'owner', 'end_date', 'description', 'description'];

    //endregion

    //region Static Methods
    //endregion

    //region Methods

    /**
     * Define the relation between Moneybox and MoneyboxPayment
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Models\MoneyboxPayment');
    }

    /**
     * Define the relation between Moneybox and PersonMoneybox
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function persons()
    {
        return $this->hasMany('App\Models\PersonMoneybox');
    }

    /**
     * Define the relation between Moneybox and MoneyboxCategory
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\MoneyboxCategories');
    }

    /**
     * Define the relation between Moneybox and MoneyboxSetting
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function settings()
    {
        return $this->hasMany('App\Models\MoneyboxSetting');
    }

    //endregion

    //region Private Methods
    //endregion
}