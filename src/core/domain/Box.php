<?php

namespace gift\appli\core\domain;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Box extends Eloquent
{
    protected $table = 'box';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    public function prestation()
    {
        return $this->belongsToMany(
            'gift\appli\models\Prestation',
            'box2presta',
            'box_id',
            'presta_id'
        );
    }
}
