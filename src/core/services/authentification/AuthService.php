<?php 

namespace gift\appli\core\services\authentification;

use gift\appli\core\domain\Utilisateur;
use gift\appli\core\services\exception\InvalidArgumentException;
use gift\appli\core\services\authentification\AuthServiceInterface;
use Ramsey\Uuid\Uuid;

class AuthService implements AuthServiceInterface
{
    public function isAdmin($id): bool
    {
        $user = Utilisateur::find($id);
        return $user->role == '100';
    }

    public function saveUser(Utilisateur $user)
    {
        $user->save();
    }

    public function checkPasswordStrength(string $pass): bool 
    {
        $digit = preg_match("#[\d]#", $pass);
        $special = preg_match("#[\W]#", $pass);
        $lower = preg_match("#[a-z]#", $pass);
        $upper = preg_match("#[A-Z]#", $pass);

        return $digit && $special && $lower && $upper;
    }

    public function checkUsernameDB(string $user_id): bool 
    {
        $user = Utilisateur::where('user_id', $user_id)->first();
        return $user === null;
    }


    /**
     * @throws InvalidArgumentException
     */
    public function createUser(array $args): Utilisateur
    {
        if (strlen($args['password']) < 10) {
            throw new InvalidArgumentException('Le mot de passe doit contenir au moins 10 caractères');
        }

        if (!$this->checkPasswordStrength($args['password'])) {
            throw new InvalidArgumentException('Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial');
        }

        if (!$this->checkUsernameDB($args['user_id'])) {
            throw new InvalidArgumentException("L'email est déjà utilisé.");
        }

        $args['activation_token'] = bin2hex(random_bytes(64));

        $hash = password_hash($args['password'], PASSWORD_DEFAULT);

        $user = new Utilisateur();
        $user->id = Uuid::uuid4()->toString();
        $user->user_id = $args['user_id'];
        $user->password = $hash;
        $user->activation_token = $args['activation_token'];
        $user->role = 1;

        $this->saveUser($user);
        return $user;
    }

    public function checkPasswordValid(string $pass, string $user_id): bool
    {
        $user = Utilisateur::where('user_id', $user_id)->first();

        if ($user === null) {
            error_log("Utilisateur non trouvé: $user_id");
            return false;
        }

        $passwordValid = password_verify($pass, $user->password);

        if (!$passwordValid) {
            error_log("Mot de passe invalide pour : $user_id");
        }

        return $passwordValid;
    }

    public function connectUser(array $args): ?Utilisateur
    {
        $user = Utilisateur::where('user_id', $args['id'])->first();
        if ($user) 
        {
            $_SESSION['id'] = $user->getId();
            return $user;
        }

        error_log("Utilisateur non trouvé: {$args['id']}");
        return null;
    }

}
