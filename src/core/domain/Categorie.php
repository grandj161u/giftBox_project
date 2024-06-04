<?php

namespace gift\appli\core\domain;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Categorie extends Eloquent
{
    protected $table = 'categorie';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public function prestation()
    {
        return $this->hasMany('gift\appli\core\domain\Prestation', 'cat_id');
    }
}
