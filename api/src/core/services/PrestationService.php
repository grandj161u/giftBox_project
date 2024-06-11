<?php

namespace gift\appli\api\core\services;

use gift\appli\api\core\domain\Prestation;

class PrestationService implements PrestationServiceInterface
{

    public function getAll(): array
    {
        return Prestation::all()->toArray();
    }
}