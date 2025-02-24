<?php

namespace Controllers;

/**
 * Clase de controlador para manejar errores
 * @package Controllers
 */
class ErrorController
{
    public static function show_err404()
    {
        return 'ERROR 404!';
    }
    public static function show_err504()
    {
        return 'ERROR 504!';
    }
}