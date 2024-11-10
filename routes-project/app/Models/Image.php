<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
