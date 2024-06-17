<?php

namespace gift\appli\core\domain;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Box extends Eloquent
{
    use HasUuids;

    protected $table = 'box';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';
    public $timestamps = false;

    public const CREATED = 1;
    public const VALIDATED = 2;
    public const PAYED = 3;
    public const SENT = 4;
    public const RECEIVED = 5;

    public function prestation()
    {
        return $this->belongsToMany(
            Prestation::class,
            'box2presta',
            'box_id',
            'presta_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            Utilisateur::class,
            'createur_id',
            'id'
        );
    }
}
