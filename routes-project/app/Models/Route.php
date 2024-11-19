<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $location
 * @property integer $distance
 * @property string $date_route
 * @property integer $difficulty
 * @property boolean $pets_allowed
 * @property boolean $vehicle_needed
 * @property string $description
 * @property User $user
 */
class Route extends Model
{

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'location', 'distance', 'date_route', 'difficulty', 'pets_allowed', 'vehicle_needed', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'users_routes', 'route_id', 'user_id');
    }
}
