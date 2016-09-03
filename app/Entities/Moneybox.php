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
    protected $fillable = ['category_id', 'person_id', 'name'];

    /**
     * Default values for Moneybox
     * @var array
     */
    protected $defaults = [
        'goal_amount' => 1000,
        'collected_amount' => 0,
        'description' => '',
        'active' => 1
    ];

    //endregion

    //region Static Methods
    //endregion

    public function __construct(array $attributes = array())
    {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

    //region Methods

    /**
     * Define the relation between Moneybox and MoneyboxPayment
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Entities\Payment');
    }

    /**
     * Define the relation between Moneybox and PersonMoneybox
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function persons()
    {
        return $this->hasMany('App\Entities\Member');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany('App\Entities\Participant');
    }

    /**
     * Define the relation between Moneybox and MoneyboxCategory
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Entities\Category');
    }

    /**
     * Define the relation between Moneybox and Person
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person(){
        return $this->belongsTo(Person::class);
    }

    /**
     * Define the relation between Moneybox and Order
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order() {
        return $this->hasOne(Order::class);
    }

    /**
     * Scope a query to only include moneybox of a given uid
     *
     * @param $query
     * @param $uid
     */
    public function scopeByUrl($query, $uid) {
        return $query->where('url', $uid);
    }

    //endregion

    //region Private Methods
    //endregion
}