<?php
namespace Controllers;

use Lib\Pages;
use Services\categoryService;
use Services\userService;
use Services\MedicoService;  // Correcto, ya estamos trabajando con médicos
use Services\pedidosService;

class AdminController {
    private Pages $pages;
    private userService $userService;
    private categoryService $categoryService;
    private MedicoService $medicoService;  // Este es el servicio para manejar los médicos
    private pedidosService $pedidosService;

    public function __construct() {
        $this->pages = new Pages();
        $this->userService = new userService();
        $this->categoryService = new categoryService();
        $this->medicoService = new MedicoService();  // Inicializamos el servicio de médicos
        $this->pedidosService = new pedidosService();
    }

    // Función para cargar la página de administración
    public function index() {
        // Definir el menú de gestión
        $gestion = [
            0 => ['title' => 'Gestión de categorías', 'id' => 0],
            1 => ['title' => 'Gestión de médicos', 'id' => 1],
            2 => ['title' => 'Gestión de pedidos', 'id' => 2]
        ];
    
        // Obtener todas las categorías
        $categories = $this->categoryService->allCategories();
        $categories = array_map(function ($category) {
            return $category->toArray();
        }, $categories);
    
        // Obtener todos los médicos
        $medicos = $this->medicoService->getAllMedicos();
        // Asegurarse de que $medicos sea un array antes de usar array_map
        if ($medicos !== null) {
            $medicos = array_map(function ($medico) {
                return $medico->toArray();
            }, $medicos);
        } else {
            $medicos = [];  // Si $medicos es null, pasamos un array vacío
        }
    
        // Obtener todos los pedidos
        $pedidos = $this->pedidosService->findAll();
        $pedidos = array_map(function ($pedido) {
            return $pedido->toArray();
        }, $pedidos);
    
        // Renderizar la vista de administración
        $this->pages->render('admin/index', [
            'menu' => $gestion,
            'categorias' => $categories,
            'medicos' => $medicos,  // Los médicos ahora siempre son un array
            'pedidos' => $pedidos
        ]);
    }
}    