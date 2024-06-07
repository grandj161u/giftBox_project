<?php

namespace gift\appli\app\utils;

class CsrfService
{
    public static function generate(): string
    {
        $token = base64_encode(random_bytes(32));
        $_SESSION['csrf'] = $token;
        return $token;
    }

    public static function check($token): bool
    {
        if (!isset($_SESSION['csrf']) || $_SESSION['csrf'] !== $token) {
            unset($_SESSION['csrf']);
            return false;
        }
        unset($_SESSION['csrf']);
        return true;
    }
}
