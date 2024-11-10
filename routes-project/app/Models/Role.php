<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 */
class Role extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id', 'name'];
}
