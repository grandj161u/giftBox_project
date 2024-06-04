<?php

namespace gift\appli\core\services;

interface ServiceCatalogueInterface
{
    public function getCategories(): array;
    public function getCategorieById(int $id): array;
    public function getPrestationById(string $id): array;
    public function getPrestationsbyCategorie(int $categ_id): array;
}
