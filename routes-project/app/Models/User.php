<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */

/**
 * @property integer $id
 * @property integer $id_image
 * @property integer $id_role
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property Route[] $routes
 * @property Role $role
 * @property Image $image
 */
class User extends Authenticatable
{
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['id_image', 'id_role', 'name', 'surname', 'email', 'phone', 'password'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function routes()
    {
        return $this->hasMany(Route::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class, 'id_image');
    }
}
