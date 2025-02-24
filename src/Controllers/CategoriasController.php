<?php
namespace Controllers;
use Lib\Pages;
use Services\categoryService;
use Models\Category;
use PDOException;

/**
 * Class CategoriasController
 * @package Controllers
 */
class CategoriasController{
    private Pages $pages;
    private categoryService $categoryService;
    public function __construct (){
        $this->pages=new Pages();
        $this->categoryService=new categoryService();
    }


    //Funcion para iniciar sesion
    public function index(){
        $categorias= $this->categoryService->findActive();
        $categorias=array_map(function($categoria){
            return $categoria->toArray();
        },$categorias);

        $this->pages->render('categorias/principales',['categorias'=>$categorias]);
    }


    /**
     * Función para almacenar una categoria
     * @return void
     * 
     */
    public function store(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if($_POST['nombre'] && $_POST['id']){
                $id=$_POST['id'];
                $nombre=$_POST['nombre'];
                $categoria= Category::fromArray(['id'=>$id,'nombre'=>$nombre]);
                try{
                    $this->categoryService->update($categoria);
                    $_SESSION['success']='Categoria actualizada';
                    header('Location: '.BASE_URL.'categorias');
                    return;
                }
                catch( PDOException $e){
                    $_SESSION['error']='Ha surgido un error';
                    $this->pages->render('categorias/principales');
                    return;
                }
            }else if($_POST['nombre']){
                $nombre=$_POST['nombre'];
                $categoria= Category::fromArray(['nombre'=>$nombre]);
                try{
                    $this->categoryService->store($categoria);
                    $_SESSION['success']='Categoria creada';
                    header('Location: '.BASE_URL.'categorias');
                    return;
                }catch( PDOException $e){
                    $_SESSION['error']='Ha surgido un error';
                    $this->pages->render('categorias/principales');
                    return;
                }
            }else{
                $_SESSION['error']='Ha surgido un error';
            }
        }else{
            $_SESSION['error']='Ha surgido un error';
        }
        $this->pages->render('categorias/principales');
        return;

    }   


    /**
     * Función para borrar una categoria
     */
    public function delete(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if($_POST['id']){
                $id=$_POST['id'];
                $categoria= Category::fromArray(['id'=>$id]);
                try{
                    $this->categoryService->delete($categoria);
                    $_SESSION['success']='Categoria eliminada';
                    header('Location: '.BASE_URL.'categorias');
                    return;
                }catch( PDOException $e){
                    $_SESSION['error']='Ha surgido un error';
                    $this->pages->render('categorias/principales');
                    return;
                }
            }else{
                $_SESSION['error']='Ha surgido un error';
            }
        }else{
            $_SESSION['error']='Ha surgido un error';
        }
        
        return;
    }


    /**
     * Funcion para reactivar una categoria
     * 
     */
    public function reactive(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if($_POST['id']){
                $id=$_POST['id'];
                $categoria= Category::fromArray(['id'=>$id,'borrado'=>false]);
                try{
                    $this->categoryService->reactive($categoria);
                    $_SESSION['success']='Categoria reactivada';
                    header('Location: '.BASE_URL.'categorias');
                    return;
                }catch( PDOException $e){
                    $_SESSION['error']='Ha surgido un error';
                    $this->pages->render('categorias/principales');
                    return;
                }
            }else{
                $_SESSION['error']='Ha surgido un error';
            }
        }
    }
}
