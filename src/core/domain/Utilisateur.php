<?php

namespace gift\appli\core\domain;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Utilisateur extends Eloquent
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    public $timestamps = false;


    protected $fillable = ['user_id', 'password', 'role'];

    public function box()
    {
        return $this->hasMany(
            Box::class,
            'createur_id',
            'id'
        );
    }
}
