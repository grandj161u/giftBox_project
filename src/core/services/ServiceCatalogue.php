<?php

namespace gift\appli\core\services;

use gift\appli\core\domain\Categorie;
use gift\appli\core\domain\Prestation;

class ServiceCatalogue implements ServiceCatalogueInterface
{
    public function getCategories(): array
    {
        try {
            $tabCateg = Categorie::all();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("Toutes les catégories ne sont pas trouvés : " . $e);
        }

        return $tabCateg->toArray();
    }

    public function getCategorieById($id): array
    {
        try {
            $tabCateg = Categorie::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("La catégorie n'éxiste pas : " . $e);
        }

        return $tabCateg->toArray();
    }

    public function getPrestations(): array
    {
        try {
            $tabPresta = Prestation::all();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("Toutes les Prestations ne sont pas trouvés : " . $e);
        }

        return $tabPresta->toArray();
    }

    public function getPrestationById($id): array
    {
        try {
            $tabPresta = Prestation::findOrFail($id)->toArray();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("La préstation n'éxiste pas : " . $e);
        }

        return $tabPresta;
    }

    public function getPrestationsbyCategorie($categorieId): array
    {
        try {
            $tabPresta = Prestation::where('cat_id', '=', $categorieId)->get()->toArray();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("La préstation n'éxiste pas : " . $e);
        }

        return $tabPresta;
    }

    public function createCategorie($tabCateg): int
    {
        try {
            $newCateg = new Categorie();
            $newCateg->libelle = $tabCateg['libelle'];
            $newCateg->description = $tabCateg['description'];
            $newCateg->save();
        } catch (\Illuminate\Database\QueryException $e) {
            throw new CatalogueNotFoundException("La catégorie n'a pas pu être créée : " . $e);
        }

        return $newCateg->id;
    }

    public function modifyPrestation($tabPresta): void
    {
        try {
            $presta = Prestation::findOrFail($tabPresta['id']);
            if (isset($tabPresta['libelle'])) {
                $presta->libelle = $tabPresta['libelle'];
            }

            if (isset($tabPresta['description'])) {
                $presta->description = $tabPresta['description'];
            }

            if (isset($tabPresta['prix'])) {
                $presta->prix = $tabPresta['prix'];
            }

            $presta->save();
        } catch (\Illuminate\Database\QueryException $e) {
            throw new CatalogueNotFoundException("La préstation n'a pas pu être modifiée : " . $e);
        }
    }

    public function defineOrModifyPrestationCategorie($idPresta, $idCateg): void
    {
        try {
            $presta = Prestation::findOrFail($idPresta);
            $presta->cat_id = $idCateg;
            $presta->save();
        } catch (\Illuminate\Database\QueryException $e) {
            throw new CatalogueNotFoundException("La catégorie de la préstation n'a pas pu être modifiée : " . $e);
        }
    }
}
