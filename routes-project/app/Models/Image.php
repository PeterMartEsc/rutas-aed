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
 */
class Image extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['image', 'type_image'];
}
