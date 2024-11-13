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
 */
class Role extends Model
{
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['id', 'name'];
}
