<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    //region attributes
    /**
     * The database table used by the model
     * @var string
     */
    protected $table = 'participants';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = ['person_id', 'moneybox_id'];
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
        return $this->belongsTo('App\Models\Person');
    }

    /**
     * Define the relation between MoneyboxPayment and Person
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function moneybox()
    {
        return $this->belongsTo('App\Models\Moneybox');
    }
    //endregion

    //region Private Methods
    //endregion
}
