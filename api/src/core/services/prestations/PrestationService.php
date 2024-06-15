<?php

namespace gift\appli\api\core\services\prestations;

use gift\appli\api\core\domain\Prestation;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PrestationService implements PrestationServiceInterface
{

    public function getAll(): array
    {
        try {
            return Prestation::all()->toArray();
        } catch (ModelNotFoundException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}