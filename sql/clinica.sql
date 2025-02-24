CREATE DATABASE clinica;
SET NAMES UTF8;
CREATE DATABASE IF NOT EXISTS clinica;
USE clinica;

DROP TABLE IF EXISTS pacientes;
CREATE TABLE IF NOT EXISTS pacientes( 
id              int auto_increment not null,
nombre          varchar(64) not null,
apellidos       varchar(64) not null,
correo          varchar(255) not null,
telefono 		numeric,
compañia 		boolean,
password        varchar(255) not null,
CONSTRAINT pk_pacientes PRIMARY KEY(id),
CONSTRAINT uq_correo UNIQUE(correo)  
)ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS medicos;
CREATE TABLE IF NOT EXISTS medicos( 
id              int auto_increment not null,
nombre          varchar(64) not null,
apellidos       varchar(64) not null,
telefono        varchar(9) not null,
especialidad        varchar(255) not null,
CONSTRAINT pk_medicos PRIMARY KEY(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS citas;
CREATE TABLE citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medico_id INT NOT NULL,
    paciente_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada') DEFAULT 'pendiente',
    FOREIGN KEY (medico_id) REFERENCES medicos(id),
    FOREIGN KEY (paciente_id) REFERENCES usuarios(id)
);


DROP TABLE IF EXISTS categorias;
CREATE TABLE IF NOT EXISTS categorias(
id              int(255) auto_increment not null,
nombre          varchar(100) not null,
CONSTRAINT pk_categorias PRIMARY KEY(id) 
)ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;