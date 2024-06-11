<?php 

namespace gift\appli\core\services\authentification;

use gift\appli\core\domain\Utilisateur;

interface AuthServiceInterface 
{
    public function isAdmin($id):bool;
    public function saveUser(Utilisateur $user);
    public function checkPasswordStrength(string $pass): bool;
    public function checkUsernameDB(string $username): bool;
    public function createUser(array $args): utilisateur;
    public function checkPasswordValid(string $pass, string $username):bool;
    public function connectUser(array $args);
}