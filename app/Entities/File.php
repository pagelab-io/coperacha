<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'files';

    /**
     * The attributes are the mass-assignable keys.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'path', 'size', 'extension', 'order', 'storable_type', 'storable_id', 'user_id'];

    /**
     * Get all of the owning storable models
     */
    public function storable()
    {
        return $this->morphTo();
    }
}
