<?php

namespace App\Entities;

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
    protected $fillable = ['category_id', 'name', 'goal_amount', 'collected_amount', 'owner_id', 'end_date', 'description'];

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
        return $this->hasMany('App\Models\Payment');
    }

    /**
     * Define the relation between Moneybox and PersonMoneybox
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function persons()
    {
        return $this->hasMany('App\Models\Member');
    }

    /**
     * Define the relation between Moneybox and MoneyboxCategory
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    //endregion

    //region Private Methods
    //endregion
}