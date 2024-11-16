<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */

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
    protected $fillable = [Image::class, 'type_image'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_image');
    }
}
