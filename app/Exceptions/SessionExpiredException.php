<?php

namespace App\Exceptions;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Auth\AuthenticationException;

use Exception;

class SessionExpiredException extends Exception
{
    public function render($request, Exception $exception)
{
    if ($exception instanceof TokenMismatchException) {
        // La sesión ha expirado, redirigir al formulario de inicio de sesión
        return redirect()->route('login');
    }

    if ($exception instanceof AuthenticationException) {
        // El usuario no está autenticado, redirigir al formulario de inicio de sesión
        return redirect()->route('login');
    }

    return parent::render($request, $exception);
}
}
