<?php

namespace gift\appli\api\core\services\boxes;

use gift\appli\api\core\domain\Box;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BoxesService implements BoxesServiceInterface
{

    public function get(string $id): array
    {
        try {
            return Box::findOrFail($id)->toArray();
        } catch (ModelNotFoundException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}