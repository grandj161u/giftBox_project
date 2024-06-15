<?php

namespace gift\appli\api\core\services\boxes;

interface BoxesServiceInterface
{

    public function get(string $id): array;
}