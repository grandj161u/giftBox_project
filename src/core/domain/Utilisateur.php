<?php

namespace gift\appli\core\domain;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Utilisateur extends Eloquent
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $keyType = 'string';



    protected $fillable = ['user_id', 'password', 'role'];
}
