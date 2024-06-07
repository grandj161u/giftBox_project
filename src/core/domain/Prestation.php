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
        return $this->belongsTo(Categorie::class, 'cat_id');
    }

    public function box()
    {
        return $this->belongsToMany(
            Box::class,
            'box2presta',
            'presta_id',
            'box_id'
        )
            ->withPivot(['quantite']);
    }
}
