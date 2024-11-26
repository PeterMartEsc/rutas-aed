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

    public $timestamps = false;
    
    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_role');
    }
}
