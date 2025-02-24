<?php

namespace Models;
// use Lib\Validar;

class User
{
    protected static array $errores = [];

    //CONSTRUCTOR DE LA CLASE USUARIO
    public function __construct(
        private string|null $id = null,
        private string $nombre,
        private string $apellidos,
        private string $email,
        private string $password,
        private string $rol,
        private string $token = '',
        private string $token_exp = '',
    ) {
    }

    //GETTER DE LA CONTRASEÑA DEL USUARIO
public function getPassword(): string
{
    return $this->password;
}

//SETTER DE LA CONTRASEÑA DEL USUARIO
public function setPassword(string $password): void
{
    $this->password = $password;
}

    //GETTER DEL ID DEL USUARIO
    public function getId(): ?string
    {
        return $this->id;
    }

    //SETTER DEL ID DEL USUARIO
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    //GETTER DEL NOMBRE DEL USUARIO
    public function getNombre(): string
    {
        return $this->nombre;
    }

    //SETTER DEL NOMBRE DEL USUARIO
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    //GETTER DE LOS APELLIDOS DEL USUARIO
    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    //SETTER DE LOS APELLIDOS DEL USUARIO
    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    //GETTER DEL GMAIL DEL USUARIO
    public function getEmail(): string
    {
        return $this->email;
    }

    //SETTER DEL EMAIL DEL USUARIO
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    //SETTER DEL ROL DEL USUARIO
    public function getRol(): string
    {
        return $this->rol;
    }

    //GETTER DEL ROL DEL USUARIO
    public function setRol(string $rol): self
    {
        $this->rol = $rol;

        return $this;
    }

    public static function getErroes():array{
        return self::$errores;
    }
    public static function setErrores(array $errores):void{
        self::$errores=$errores;
    }


    public function getToken(): string
    {
        return $this->token;
    }
    public function getTokenExpiration(): int
    {
        return $this->token_exp;
    }    public function setToken(string $token): void
    {
        $this->token = $token;
    }
    public function setTokenExpiration(string $token_exp): void
    {
        $this->token_exp = $token_exp;
    }


    //funcion sanitizar

    public function validar(): bool
        {
            self::$errores = []; 
            //Validacion campo nombre
            if(empty($this->name))
            {
                self::$errores[] = 'El nombre es obligatorio';
            }
            else
            {
                $patron = '/^[a-zA-Z, ]$/';
                if(preg_match($patron,$this->nombre))
                {
                    return true;
                }
                else{
                    self::$errores[] = 'El nombre no es valido';
                }
            }

            //Validacion campo apellido
            if(empty($this->apellidos))
            {
                self::$errores[] = 'El apellido es obligatorio';
            }
            else
            {
                $patron = '/^[a-zA-Z, ]$/';
                if(preg_match($patron,$this->nombre))
                {
                    return true;
                }
                else{
                    self::$errores[] = 'El nombre no es valido';
                }
            }

            //Validacion campo email
            if(empty($this->email))
            {
                self::$errores[] = 'El email es obligatorio';
            }
            else
            {
                $patron = '/^[a-zA-Z0-9.-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,6}$/';
                if(preg_match($patron,$this->email))
                {
                    return true;
                }
                else{
                    self::$errores[] = 'El email no es valido';
                }
            }
//Validacion campo password(minimo 8 caracteres, una mayuscula, una minuscula y un numero)
            if(empty($this->password))
            {
                self::$errores[] = 'La contraseña es obligatoria';
            }
            else
            {
                $patron = '/^(?=.[a-z])(?=.[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/';
                if(preg_match($patron,$this->password))
                {
                    return true;
                }
                else{
                    self::$errores[] = 'La contraseña no es valida';
                }
            }

            //Validacion campo rol
            if(empty($this->role))
            {
                self::$errores[] = 'El rol es obligatorio';
            }
            else
            {
                $patron = '/^(admin|user)$/';
                if(preg_match($patron,$this->rol))
                {
                    return true;
                }
                else{
                    self::$errores[] = 'El rol no es valido';
                }
            }
            return empty(self::$errores);
        }
        
        public function sanear(): void
        {
            $this->nombre = filter_var($this->nombre, FILTER_SANITIZE_STRING);
            $this->apellidos = filter_var($this->apellidos, FILTER_SANITIZE_STRING);
            $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
            $this->password = filter_var($this->password, FILTER_SANITIZE_STRING);
            $this->rol = filter_var($this->rol, FILTER_SANITIZE_STRING);
        }
    
    public static function fromArray(array $data): User{
        return new User(
            id: $data['id']??null,
            nombre: $data['nombre']??'',
           apellidos: $data['apellidos']??'',
           email: $data['email']??'',
          password:  $data['password']??'',
           rol: $data['rol']??''
        );
    }
}