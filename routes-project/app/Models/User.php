<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property integer $id_image
 * @property GroupsUser[] $groupsUsers
 */
class User extends Model{
    /**
     * @var array
     */
    protected $fillable = ['name', 'surname', 'email', 'phone', 'password', 'id_image' => null];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groupsUsers()
    {
        return $this->hasMany('App\Models\GroupsUser', 'id_user');
    }

}
