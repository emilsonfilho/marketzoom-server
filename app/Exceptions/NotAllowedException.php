<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class NotAllowedException extends Exception
{
    public static function notAllowed(): self
    {
        return new self('Você não é autorizado a realizar essa ação', Response::HTTP_UNAUTHORIZED);
    }
}
