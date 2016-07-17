<?php

namespace App\Entities;

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
     * Default values for person
     * @var array
     */
    protected $defaults = [
        'birthday' => '0000-00-00',
        'gender' => 'H',
        'city' => '',
        'country' => ''
    ];

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = ['name', 'lastname', 'birthday', 'gender', 'city', 'country'];

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
     * Define the relation between Person and Payments
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    /**
     * Define the relation between Person and Member
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personMoneyboxes()
    {
        return $this->hasMany('App\Models\Participant');
    }

    //endregion

    //region Private Methods
    //endregion
}
