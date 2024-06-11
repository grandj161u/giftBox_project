<?php

namespace gift\appli\api\core\services;

use gift\appli\api\core\domain\Box;

class BoxesService implements BoxesServiceInterface
{

    public function get(string $id): array
    {
        return Box::find($id)->toArray();
    }
}