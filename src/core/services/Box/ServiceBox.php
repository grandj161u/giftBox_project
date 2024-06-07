<?php

namespace gift\appli\core\services;

use gift\appli\core\domain\Box;

class ServiceBox implements ServiceBoxInterface
{
    public function getAllBox(): array
    {
        try {
            $tabBox = Box::all();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("Toutes les box ne sont pas trouvés : " . $e);
        }

        return $tabBox->toArray();
    }

    public function getBoxById($id): array
    {
        try {
            $tabBox = Box::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("La box n'a pas été trouvée !" . $e);
        }

        return $tabBox->toArray();
    }

    public function createBox($data): string
    {
        try {
            $box = new Box();
            $box->token = $data['token'];
            $box->libelle = $data['libelle'];
            $box->description = $data['description'];
            $box->kdo = $data['isKdo'] == 'true' ? 1 : 0;
            $box->message_kdo = $data['message_kdo'] == '' ? '' : $data['message_kdo'];
            $box->montant = 0;
            $box->statut = Box::CREATED;
            $box->save();
        } catch (\Illuminate\Database\QueryException $e) {
            throw new CatalogueNotFoundException("La box n'a pas été créée !" . $e);
        }

        return $box->id;
    }

    public function modifyBox($id, $data): void
    {
        try {
            $box = Box::findOrFail($id);
            if (isset($data['id'])) {
                $box->id = $data['id'];
            }

            if (isset($data['token'])) {
                $box->token = $data['token'];
            }

            if (isset($data['libelle'])) {
                $box->libelle = $data['libelle'];
            }

            if (isset($data['description'])) {
                $box->description = $data['description'];
            }

            if (isset($data['kdo'])) {
                $box->kdo = $data['kdo'];
            }

            if (isset($data['message_kdo'])) {
                $box->message_kdo = $data['message_kdo'];
            }

            $box->save();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("La box n'a pas été modifiée !" . $e);
        }
    }

    public function deleteBox($id): void
    {
        try {
            $box = Box::findOrFail($id);
            $box->delete();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("La box n'a pas été supprimée !" . $e);
        }
    }
} {
}
