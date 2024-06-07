<?php

namespace gift\appli\core\services;

interface ServiceBoxInterface
{
    public function getAllBox(): array;
    public function getBoxById(int $id): array;
    public function createBox(array $tabBox): string;
    public function modifyBox(int $id, array $data): void;
    public function deleteBox(int $id): void;
}
