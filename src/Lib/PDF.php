<?php

namespace Lib;

use Exception;
use TCPDF;
use TCPDF_FONTS;
use Services\productsService;

class PDF
{
    private $tcpdf;
    private productsService $productService;

    /**
     * Constructor de la clase PDF
     */

    public function __construct()
    {

        $this->tcpdf = new TCPDF();
        $this->tcpdf->setPrintFooter(false);
        $this->tcpdf->setPrintHeader(false);
        $this->tcpdf->setPrintFooter(false);
        $this->tcpdf->SetMargins(15, 15, 15);
        $this->tcpdf->SetAutoPageBreak(true, 20);
        $this->productService = new productsService();
    }


    /**
     * Función para generar el PDF del pedido
     * 
     * @return string con el PDF
     */
    public function generarPDF(): string
    {
        // Validar que las variables de sesión necesarias existen
        if (!isset($_SESSION['user']['nombre'], $_SESSION['carrito'], $_SESSION['coste'])) {
            throw new Exception("No se puede generar el pedido, debido a que faltan datos.");
        }
        $usuarioNombre = $_SESSION['user']['nombre'];
        $carrito = $_SESSION['carrito'];
        $precio = $_SESSION['coste'];
        $hora = $_SESSION['hora'];
        $fecha = $_SESSION['fecha'];
        
        $this->tcpdf->AddPage();
        
        // Título principal
        $muestra = "<h1>Pedido realizado a nombre de $usuarioNombre</h1>";
        
        // Tabla de productos
        $muestra .= "<table border='1' cellpadding='5'>";
        $muestra .= "<tr><th>Producto</th><th>Cantidad</th><th>Precio</th></tr>";
        
        foreach ($carrito as $key=>$cantidad) {
          
            $product = $this->productService->findById(intval($key));
          if(isset($product)){
           $totalProducto= $product->getPrecio()*$cantidad;
             $muestra .= "<tr>
            <td>{$product->getNombre()}</td>
            <td>{$cantidad}</td>
            <td>{$totalProducto}</td>

            </tr>";
            }
        }

        $muestra .= "</table>";

        //Hora de pedido
        $muestra .= "<p><strong> Hora de pedido: {$hora}</strong></p>";

     

        // Estado y total
        $muestra .= "<p><strong>Total: {$precio}</strong></p>";

        // Escribir contenido en PDF
        $this->tcpdf->writeHTML($muestra, true, false, true, false, '');

        // Ruta para guardar el PDF
        $filePath = __DIR__ . "/../../public/pdf/pedido_{$_SESSION['pedido_id']}.pdf";

        // Guardar el PDF en el servidor
        $this->tcpdf->Output($filePath, 'F');

        return $filePath;
    }
}