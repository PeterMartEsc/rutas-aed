<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $image
 * @property string $type_image
 * @property User[] $users
 */
class Image extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['image', 'type_image'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User', 'id_image');
    }
}
