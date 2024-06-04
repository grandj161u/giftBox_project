<?php

namespace gift\appli\core\domain;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Prestation extends Eloquent
{
    protected $table = 'prestation';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    public function categorie()
    {
        return $this->belongsTo('gift\appli\models\Categorie', 'cat_id');
    }

    public function box()
    {
        return $this->belongsToMany(
            'gift\appli\models\Box',
            'box2presta',
            'presta_id',
            'box_id'
        )
            ->withPivot(['quantite']);
    }
}
