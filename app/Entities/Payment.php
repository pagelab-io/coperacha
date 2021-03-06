<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //region attributes
    /**
     * The database table used by the model
     * @var string
     */
    protected $table = 'payments';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = ['person_id', 'moneybox_id', 'amount', 'commission', 'method'];
    //endregion

    //region Static Methods
    //endregion

    //region Methods

    /**
     * Define the relation between MoneyboxPayment and Person
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('App\Entities\Person');
    }

    /**
     * Define the relation between MoneyboxPayment and Person
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function moneybox()
    {
        return $this->belongsTo('App\Entities\Moneybox');
    }

    //endregion

    //region Private Methods
    //endregion
}
