<?php

namespace App\Entities;

//use Illuminate\Contracts\Auth\Authenticatable;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // region traits
    use \Illuminate\Auth\Authenticatable;
    // endregion

    //region attributes
    /**
     * The database table used by the model
     * @var string
     */
    protected $table = 'users';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = ['person_id', 'email', 'password', 'username', 'tracking'];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * @var array
     */
    protected $defaults = [
        'tracking' => 0
    ];

    /**
     * The accessors to append to the model´s array from.
     *
     * @var array
     */
    protected $appends = ['has_password'];

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
     * Scope a query to only include users of a given person id
     *
     * @param any $query
     * @param int $person_id
     * @return mixed
     */
    public function scopeByPerson($query, $person_id) {
        return $query->where('person_id', $person_id);
    }

    /**
     * Define the relation between User and Person
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('App\Entities\Person');
    }

    /**
     * Get the fbuser record associate with the user
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fbuser(){
        return $this->hasOne(FbUser::class);
    }

    /**
     * Check if has a password
     */
    public function getHasPasswordAttribute(){
        return strlen($this->password) > 0;
    }

    //endregion

    //region Private Methods
    //endregion
}
