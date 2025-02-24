<?php
namespace Services;
use Repositories\categoryRepository;


class categoryService{
    protected categoryRepository $categoryRepository;
    function __construct()
    {
        $this->categoryRepository = new categoryRepository();
    }

    /**
     * Función para obtener todos los productos
     * 
     */
    public function allCategories()
    {
        return $this->categoryRepository->findAll();
    }   

    /**
     * Función para almacenar un producto   
     * @param Product $product
     * @return string
     * 
     */
    public function store($category)
    {
        return $this->categoryRepository->store($category);
    }

    /**
     * Función para actualizar un producto  
     * @param Product $product
     * @return string
     */
    public function update($category)
    {
        return $this->categoryRepository->update($category);
    }

    /**
     * Función para borrar un producto  
     * @param Product $product
     * @return string
     */
        public function delete($category)
    {
        return $this->categoryRepository->delete($category);
    }

    /**
     * Funcion para obtener todos los productos activos 
     *  
     */
    public function findActive()
    {
        return $this->categoryRepository->findActive();
    }

    /**
     * Funcion para reactivar un producto
     * 
     */
    public function reactive($category){
        return $this->categoryRepository->reactive($category);
    }
}   