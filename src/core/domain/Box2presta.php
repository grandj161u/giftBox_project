<?php

namespace gift\appli\core\domain;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Box2presta extends Eloquent
{
    protected $table = 'box2presta';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = ['box_id', 'presta_id'];

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('box_id', $this->getAttribute('box_id'))
            ->where('presta_id', $this->getAttribute('presta_id'));
    }
}
