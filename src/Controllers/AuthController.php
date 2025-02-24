<?php
namespace Controllers;
use Lib\Pages;
use Models\User;
use Services\userService;
use PDOException;


  class AuthController{
    private Pages $pages;
    private userService $userService;
    public function __construct (){
        $this->pages=new Pages();
        $this->userService=new userService();
    }


    //Funcion para iniciar sesion
    public function login(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
        
            if($_POST['email'] && $_POST['password']){
                $email=$_POST['email'];
                $password=$_POST['password'];
                $user=$this->userService->getIdentity($email);
                if($user){
                    if(password_verify($password,$user['password'])){
                        $_SESSION['user']=$user;
                        $_SESSION['success']='Sesión iniciada';
                        if($user['rol']==='admin'){
                            $_SESSION['admin']=true;
                        }

                        header('Location: '.BASE_URL);
                        return;
                    }else{
                        $this->pages->render('Auth/loginForm');
                        return;
                    }
                }else{
                    $this->pages->render('Auth/loginForm');
                    return;
                }
            }
        }else{
               $this->pages->render('Auth/loginForm');
        }
    }

    //Funcion para cerrar sesion
    public function logout(){
        if(isset($_SESSION['admin'])){
            unset($_SESSION['admin']);
        }
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
            header('Location: '.BASE_URL);
        }
    }
    // Funcion para registrar un usuario
    public function register(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = 'Token CSRF inválido';
                header('Location: ' . BASE_URL . 'register');
                return;
            }
            
            if (isset($_POST['data'])) {
                $data = $_POST['data'];
                $user = User::fromArray($data);
                
                // Validar los datos, el modelo es quien lo valida
                $newPassword = password_hash($user->getPassword(), PASSWORD_BCRYPT, ['cost' => 4]);
                $user->setPassword($newPassword);
                
                try {
                    $this->userService->register($user);
                    $_SESSION['success'] = 'Registro exitoso';
                    header('Location: ' . BASE_URL . 'login');
                    return;
                } catch (PDOException $e) {
                    $_SESSION['error'] = 'Ha surgido un error';
                    $this->pages->render('Auth/registerForm');
                    return;
                }
            } else {
                $_SESSION['error'] = 'Ha surgido un error';
            }
        }
        
        // Generar un nuevo token CSRF para la sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        
        $this->pages->render('Auth/registerForm', ['csrf_token' => $_SESSION['csrf_token']]);
    }
    
    

    public function resetPassword()
    {
        require_once __DIR__ . "/../../Views/Auth/resetPassword.php";
    }
    

public function forgotPassword()
{
    // Mostrar formulario para ingresar el email
    require_once 'views/Auth/forgotPassword.php';
}

  }
  ?>