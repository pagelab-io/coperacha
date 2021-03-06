<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    /**
     * The database table used by the model
     * 
     * @var string
     */
    protected $table = 'invitations';

    /**
     * These are the mass-assignable keys
     *
     * @var string[]
     */
    protected $fillable = ['email', 'status', 'moneybox_id'];

    /**
     * Gets the moneybox that belong the invitation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function moneybox() {
        return $this->belongsTo(Moneybox::class);
    }
}
