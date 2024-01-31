<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class AuthException extends Exception
{
    public static function invalidCredentials(): self
    {
        return new self('E-mail ou senha incorreto(s)!', Response::HTTP_UNAUTHORIZED);
    }
}
