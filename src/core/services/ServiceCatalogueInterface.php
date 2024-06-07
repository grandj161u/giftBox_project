<?php

namespace gift\appli\core\services;

use Illuminate\Database\Eloquent\Collection;

interface ServiceCatalogueInterface
{
    public function getCategories(): array;
    public function getCategorieById(int $id): array;
    public function getPrestations(): Collection;
    public function getPrestationById(string $id): array;
    public function getPrestationsbyCategorie(int $categ_id): array;
    public function createCategorie(array $tabCateg): int;
    public function modifyPrestation(array $tabPresta): void;
    public function defineOrModifyPrestationCategorie(int $idPresta, int $idCateg): void;
}
