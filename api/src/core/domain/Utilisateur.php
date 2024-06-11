<?php

namespace gift\appli\api\core\domain;


use Illuminate\Database\Eloquent\Model as Eloquent;

class Utilisateur extends Eloquent
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'id';
    public $timestamp = false;
}
