<?php

namespace gift\appli\api\core\services\categorie;

use gift\appli\api\core\domain\Categorie;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategorieService implements CategorieServiceInterface
{

    public function getAll(): array
    {
        try {
            return Categorie::all()->toArray();
        } catch (ModelNotFoundException $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function getPrestations(int $id): array
    {
        try {
            return Categorie::with('prestation')->findOrFail($id)->prestation->toArray();
        } catch (ModelNotFoundException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}