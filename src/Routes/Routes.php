<?php

namespace Routes;

use Controllers\AdminController;
use Lib\Router;
use Controllers\AuthController;
use Controllers\CarritoController;
use Controllers\ErrorController;
use Controllers\ProductoController;
use Controllers\CategoriasController;
use Controllers\MedicoController;
use Controllers\PedidoController;
use Models\Product;
use Models\Categoria;
use Models\Medico;

class Routes
{
    public static function index()
    {
        // Rutas públicas
        Router::add('GET', '/', function () {
            (new MedicoController())->index();
        });

        Router::add('GET', '/Medico/destacados/{id}', function ($id) {
            (new MedicoController())->index($id);
        });

        // Rutas de registro
        Router::add('GET', '/register', function () {
            (new AuthController())->register();
        });
        Router::add('POST', '/register', function () {
            (new AuthController())->register();
        });

        // Rutas de login
        Router::add('GET', '/login', function () {
            (new AuthController())->login();
        });
        Router::add('POST', '/login', function () {
            (new AuthController())->login();
        });
        Router::add('GET', '/logout', function () {
            (new AuthController())->logout();
        });

        // Rutas de admin (requiere sesión de admin)
        if (isset($_SESSION['admin'])) {
            Router::add('GET', '/admin', function () {
                (new AdminController())->index();
            });

            Router::add('POST', '/categorias', function () {
                (new CategoriasController())->store();
            });

            Router::add('POST', '/categorias/delete', function () {
                (new CategoriasController())->delete();
            });
            Router::add('POST', '/categorias/reactive', function () {
                (new CategoriasController())->reactive();
            });

            Router::add('POST', '/Medico/delete', function () {
                (new MedicoController())->delete();
            });
            Router::add('POST', '/Medico/reactive', function () {
                (new MedicoController())->reactive();
            });
            Router::add('POST', '/Medico', function () {
                (new MedicoController())->store();
            });
        }

        // Rutas de categorías
        Router::add('GET', '/categorias', function () {
            (new CategoriasController())->index();
        });

        // Rutas del carrito
        Router::add('GET', '/carrito', function () {
            (new CarritoController())->index();
        });


        // Rutas de pedidos
        Router::add('GET', '/pedidos', function () {
            (new PedidoController())->index();
        });
        Router::add('POST', '/pedidos/mispedidos', function () {
            (new PedidoController())->store();
        });
        Router::add('POST', '/pedidos/delete', function () {
            (new PedidoController())->delete();
        });
        Router::add('POST', '/pedidos/reactive', function () {
            (new PedidoController())->reactive();
        });

        // Rutas de autenticación (recuperación de contraseña)
        Router::add('GET', '/Auth/forgotPassword', function () {
            (new AuthController())->forgotPassword();
        });
        Router::add('POST', '/Auth/forgotPassword', function () {
            (new AuthController())->resetPassword();
        });
        Router::add('GET', '/Auth/resetpassword', function () {
            (new AuthController())->resetPassword();
        });
        Router::add('POST', '/Auth/resetpassword', function () {
            (new AuthController())->resetPassword();
        });

        // Ejecutar el despachador de rutas
        Router::dispatch();
    }
}
