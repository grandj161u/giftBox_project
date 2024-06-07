<?php

namespace gift\appli\core\services;

use gift\appli\core\domain\Utilisateur;


class AuthorService
{
    public function isAdmin($id) : bool
    {
        $user = Utilisateur::find($id);
        if ($user->user_status == '3') {
            return true;
        } else {
            return false;
        }
    }

    public function saveUser(Utilisateur $user)
    {
        $user->save();
    }
}