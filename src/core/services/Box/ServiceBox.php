<?php

namespace gift\appli\core\services\Box;

use gift\appli\core\domain\Box;
use gift\appli\core\services\Catalogue\CatalogueNotFoundException;
use gift\appli\core\domain\Box2presta;

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

    public function getPrestationsByIdBox($id): array
    {
        try {
            $AssocBoxPresta = Box2presta::where('box_id', $id)->get();

            $serviceCatalogue = new ServiceCatalogue();

            $tabPresta = [];

            foreach ($AssocBoxPresta as $assoc) {
                $presta = $serviceCatalogue->getPrestationById($assoc['presta_id']);
                $tabPresta[] = $presta;
                $tabPresta[count($tabPresta) - 1]['quantite'] = $assoc['quantite'];
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("Les prestations de la box n'ont pas été trouvées !" . $e);
        }

        return $tabPresta;
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

    public function addPrestationToBox($boxId, $prestaId): void
    {
        try {
            $association = Box2presta::where('box_id', $boxId)->where('presta_id', $prestaId)->first();

            if ($association) {
                $association->quantite++;
            } else {
                $association = new Box2presta();
                $association->box_id = $boxId;
                $association->presta_id = $prestaId;
                $association->quantite = 1;
            }

            var_dump($association);

            $association->save();

            $this->actualiserMontantBox($boxId);
        } catch (\Illuminate\Database\QueryException $e) {
            throw new CatalogueNotFoundException("La prestation n'a pas été ajoutée à la box !" . $e);
        }
    }

    public function actualiserMontantBox($id): void
    {
        try {
            $box = Box::findOrFail($id);
            $montant = 0;

            $AssocBoxPresta = Box2presta::where('box_id', $id)->get();

            $serviceCatalogue = new ServiceCatalogue();

            foreach ($AssocBoxPresta as $assoc) {
                $presta = $serviceCatalogue->getPrestationById($assoc['presta_id']);
                $montant += $presta['tarif'] * $assoc['quantite'];
            }

            $box->montant = $montant;
            $box->save();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("Le montant de la box n'a pas été actualisé !" . $e);
        }
    }
}
