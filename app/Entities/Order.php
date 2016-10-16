<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes are the mass-assignable keys.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'clabe', 'account', 'bank_name', 'bank_address', 'comments', 'moneybox_id', 'email', 'areacode', 'cellphone', 'accountType'];

    /**
     * Gets the moneybox that owns of the order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function moneybox() {
        return $this->belongsTo(Moneybox::class);
    }

}
