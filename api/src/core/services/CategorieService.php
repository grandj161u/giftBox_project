<?php

namespace gift\appli\api\core\services;

use gift\appli\api\core\domain\Categorie;

class CategorieService implements CategorieServiceInterface
{

    public function getAll(): array
    {
        return Categorie::all()->toArray();
    }
}