<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */

/**
 * @property integer $id
 * @property string $name
 * @property User[] $users
 */
class Role extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['name'];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User', 'id_role');
    }
}
