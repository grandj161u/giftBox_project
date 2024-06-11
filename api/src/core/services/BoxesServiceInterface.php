<?php

namespace gift\appli\api\core\services;

interface BoxesServiceInterface
{

    public function get(string $id): array;
}