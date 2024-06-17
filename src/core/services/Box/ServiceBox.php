<?php

namespace gift\appli\core\services\Box;

use gift\appli\core\domain\Box;
use gift\appli\core\services\Catalogue\ServiceCatalogue;
use gift\appli\core\services\Catalogue\CatalogueNotFoundException;
use gift\appli\core\domain\Box2presta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ServiceBox implements ServiceBoxInterface
{
    public function getAllBox(): array
    {
        try {
            $tabBox = Box::all();
        } catch (ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("Toutes les box ne sont pas trouvés : " . $e);
        }

        return $tabBox->toArray();
    }

    public function getBoxById($id): array
    {
        try {
            $tabBox = Box::findOrFail($id);
        } catch (ModelNotFoundException $e) {
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
        } catch (ModelNotFoundException $e) {
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
            $box->createur_id = $data['createur_id'];
            $box->save();
        } catch (\Illuminate\Database\QueryException $e) {
            throw new CatalogueNotFoundException("La box n'a pas été créée !" . $e);
        }

        //Si dans le formulaire de création de box, l'utilisateur a sélectionné une box prédefinie, on ajoute les prestations de cette box à la box créée
        if ($data['boxPredefinie'] != null) {
            try {
                $prestations = $this->getPrestationsByIdBox($data['boxPredefinie']);
            } catch (CatalogueNotFoundException $e) {
                throw new CatalogueNotFoundException("Les prestations de la box prédefinie n'ont pas été trouvées !" . $e);
            }

            foreach ($prestations as $presta) {
                try {
                    $this->addPrestationToBox($box->id, $presta['id'], $presta['quantite']);
                } catch (CatalogueNotFoundException $e) {
                    throw new CatalogueNotFoundException("Les prestations de la box prédefinie n'ont pas été ajoutées à la box !" . $e);
                }
            }
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
        } catch (ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("La box n'a pas été modifiée !" . $e);
        }
    }

    public function deleteBox($id): void
    {
        try {
            $box = Box::findOrFail($id);
            $box->delete();
        } catch (ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("La box n'a pas été supprimée !" . $e);
        }
    }

    public function addPrestationToBox($boxId, $prestaId, int $quantite): void
    {
        //On vérifie que la box est bien en statut CREATED
        $box = Box::findOrFail($boxId);
        if ($box->statut != Box::CREATED) {
            throw new CatalogueNotFoundException("La box n'est pas dans le bon statut !");
        }
        try {
            $association = Box2presta::where('box_id', $boxId)->where('presta_id', $prestaId)->first();

            if ($association) {
                $association->quantite += $quantite;
            } else {
                $association = new Box2presta();
                $association->box_id = $boxId;
                $association->presta_id = $prestaId;
                $association->quantite = $quantite;
            }

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
        } catch (ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("Le montant de la box n'a pas été actualisé !" . $e);
        }
    }

    public function updateQtPrestaInBox($idBox, $idPresta, $quantite): void
    {
        //On vérifie que la box est bien en statut CREATED
        $box = Box::findOrFail($idBox);
        if ($box->statut != Box::CREATED) {
            throw new CatalogueNotFoundException("La box n'est pas dans le bon statut !");
        }

        try {
            $association = Box2presta::where('box_id', $idBox)->where('presta_id', $idPresta)->first();

            if ($association) {
                $association->quantite = $quantite;
                $association->save();
            }

            $this->actualiserMontantBox($idBox);
        } catch (\Illuminate\Database\QueryException $e) {
            throw new CatalogueNotFoundException("La quantité de la prestation n'a pas été modifiée dans la box !" . $e);
        }
    }

    public function validerBox($idBox, $idConnecte): void
    {
        //On vérifie que le créateur de la box est bien celui qui la valide
        $box = Box::with('prestation')->findOrFail($idBox);
        if ($box->createur_id != $idConnecte) {
            throw new CatalogueNotFoundException("Vous n'êtes pas le créateur de cette box !");
        }

        //la box doit contenir au moins 2 prestations, de 2 catégories
        //différentes
        if (count($box->prestation) < 2) {
            throw new CatalogueNotFoundException("La box doit contenir au moins 2 prestations !");
        }

        $nbCategories = 0;
        $categories = [];
        foreach ($box->prestation as $presta) {
            if (!in_array($presta->categorie, $categories)) {
                $categories[] = $presta->categorie;
                $nbCategories++;
            }
        }

        if ($nbCategories < 2) {
            throw new CatalogueNotFoundException("La box doit contenir des prestations de 2 catégories différentes !");
        }

        //On vérifie que la box est bien en statut CREATED
        if ($box->statut != Box::CREATED) {
            throw new CatalogueNotFoundException("La box n'est pas dans le bon statut !");
        }

        //On passe la box en statut VALIDATED
        $box->statut = Box::VALIDATED;
        $box->save();
    }

    public function payerBox($idBox, $idConnecte): void
    {
        //On vérifie que le créateur de la box est bien celui qui la paye
        $box = Box::findOrFail($idBox);
        if ($box->createur_id != $idConnecte) {
            throw new CatalogueNotFoundException("Vous n'êtes pas le créateur de cette box !");
        }

        //On vérifie que la box est bien en statut VALIDATED
        if ($box->statut != Box::VALIDATED) {
            throw new CatalogueNotFoundException("La box n'est pas dans le bon statut !");
        }

        //On passe la box en statut PAYED
        $box->statut = Box::PAYED;
        $box->save();
    }

    public function supprimerPrestationDeBox(mixed $idBox, mixed $idPresta): void
    {
        //On vérifie que la box est bien en statut CREATED
        $box = Box::findOrFail($idBox);
        if ($box->statut != Box::CREATED) {
            throw new CatalogueNotFoundException("La box n'est pas dans le bon statut !");
        }

        //On vérifie que l'utilisateur est bien le créateur de la box
        if ($box->createur_id != $_SESSION['id']) {
            throw new CatalogueNotFoundException("Vous n'êtes pas le créateur de cette box !");
        }

        try {
            $association = Box2presta::where('box_id', $idBox)->where('presta_id', $idPresta)->first();

            if ($association) {
                $association->delete();
            }

            $this->actualiserMontantBox($idBox);
        } catch (\Illuminate\Database\QueryException $e) {
            throw new CatalogueNotFoundException("La prestation n'a pas été supprimée de la box !" . $e);
        }
    }

    public function getBoxDeUser(string $id)
    {
        try {
            $tabBox = Box::where('createur_id', $id)->get();
        } catch (ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("Les box de l'utilisateur n'ont pas été trouvées !" . $e);
        }

        return $tabBox->toArray();
    }

    public function getAllBoxPredefinies()
    {
        try {
            $tabBox = Box::where('createur_id', null)->get();
        } catch (ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("Les box prédefinies n'ont pas été trouvées !" . $e);
        }

        return $tabBox->toArray();
    }

    public function generateAccesURL($box_id)
    {
        try {
            $box = Box::findOrFail($box_id);
            //Verifier si la box est validée et payée 
            if($box->statut != Box::PAYED){
                throw new CatalogueNotFoundException("La box non valiée ou non payée !" );
            }
            //Recupération du token associé à la box
            $token = $box->token;

            //Générer l'URL d'accès
            return $accesURL = "/access/{$token}";
        } catch (ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("Les box pour générer l'URL n'ont pas été trouvées !" . $e);

        }
    }

    public function getBoxAccessDetails($boxId, $token): array
    {
        try {
            $box = Box::where('id', $boxId)->where('token', $token)->firstOrFail();
            $prestations = $this->getPrestationsByIdBox($boxId);
            $details = [
                'prestations' => $prestations,
                'montant' => $box->montant,
                'isKdo' => $box->kdo,
                'message' => $box->message_kdo,
            ];
            return $details;
        } catch (ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("Accès au coffret non autorisé !" . $e);
        }
    }


    public function getBoxValidePourUser(string $userID) : array
    {
        try {
            $boxes = Box::where('createur_id', $userID)
                ->where('statut', box::VALIDATED)
                ->get();
                
                return $boxes->toArray();
        } catch (ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("Aucune box validée trouvée" . $e);
        }
    }
    
    public function getBoxPayeePourUser(string $userID) : array
    {
        try {
            $boxes = Box::where('createur_id', $userID)
                ->where('statut', box::PAYED)
                ->get();
                
                return $boxes->toArray();
        } catch (ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("Aucune box payée trouvée" . $e);
        }
    }

    public function getBoxByToken($token)
    {
        try {
            $box = Box::where('token', $token)->firstOrFail();
            return $box;
        } catch (ModelNotFoundException $e) {
            throw new CatalogueNotFoundException("La box avec le token spécifié n'a pas été trouvée !" . $e);
        }
    }
    
}