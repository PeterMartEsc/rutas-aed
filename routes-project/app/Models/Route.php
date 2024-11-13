<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */

/**
 * @property integer $id
 * @property integer $group_id
 * @property string $title
 * @property string $location
 * @property integer $distance
 * @property string $date_route
 * @property string $description
 * @property Group $group
 */
class Route extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['group_id', 'title', 'location', 'distance', 'date_route', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }
}
