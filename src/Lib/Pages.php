<?php
// Espacio de nombres para evitar errores
namespace Lib;

/**
 * Clase pages para cargar todas las paginas
 */
class Pages
{

    /**
     * Función para renderizar una página
     * 
     * @param string $pageName nombre de la página a renderizar
     */
    public function render(string $pageName, array $params = null): void
    {
        if ($params != null) {
            foreach ($params as $name => $value) {
                $$name = $value;
            }
        }

        $arriba = dirname(__DIR__,1);

        require_once $arriba . "/Views/layout/header.php";
        require_once $arriba . "/Views/$pageName.php";
        require_once $arriba . "/Views/layout/footer.php";
    }
}