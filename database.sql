DROP DATABASE IF EXISTS ladrillera;

CREATE DATABASE IF NOT EXISTS ladrillera;

USE ladrillera;

-- Creacion tabla EMPLEADOS
CREATE TABLE EMPLEADOS (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250),
    apellido VARCHAR(250),
    cedula_ciudadania INT(11),
    correo VARCHAR(200),
    genero VARCHAR(20),
    fecha_nacimiento DATE,
    rol VARCHAR(250),
    foto VARCHAR(200),

    PRIMARY KEY (id)
);

INSERT INTO
    EMPLEADOS (id_empleado, nombre)
values
    (NULL, "Robinson"),
    (NULL, "Ana");

-- Creacion tabla USUARIOS
CREATE TABLE USUARIOS (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_E INT(11) NOT NULL,
    usuario VARCHAR(250),
    contraseña VARCHAR(250),
    activo boolean,

    PRIMARY KEY (id),
    FOREIGN KEY (id_E) REFERENCES EMPLEADOS(id) ON DELETE CASCADE
);
-- Creacion tabla CLIENTES
CREATE TABLE CLIENTES (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_E INT(11) NOT NULL,
    nombre VARCHAR(250),
    apellido VARCHAR(250),
    cc_nit INT(15),
    tipo_cliente VARCHAR(100),
    ciudad VARCHAR(150),
    correo VARCHAR(150),
    telefono VARCHAR(100),

    PRIMARY KEY (id),

    FOREIGN KEY (id_E) REFERENCES EMPLEADOS(id)
);
-- Creacion tabla PEDIDOS
CREATE TABLE PEDIDOS (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_C INT(11) NOT NULL,
    id_E INT(11) NOT NULL,
    fecha_cargue date,
    comentario TEXT,
    PRIMARY KEY (id),
    FOREIGN KEY (id_C) REFERENCES CLIENTES(id) ON DELETE CASCADE,
    FOREIGN KEY (id_E) REFERENCES EMPLEADOS(id) 
);
--Creacion Productos
CREATE TABLE PRODUCTOS (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(200),
    descripcion TEXT,

    PRIMARY KEY (id)
);
--Creacion Productos_Pedidos
CREATE TABLE PRODUCTOS_PEDIDOS (
    id_P INT(11) NOT NULL,
    id_Pr INT(11) NOT NULL,
    cantidad INT(15),
    unid_medicion INT(15),

    FOREIGN KEY (id_P) REFERENCES PEDIDOS(id) ON DELETE CASCADE,
    FOREIGN KEY (id_Pr) REFERENCES PRODUCTOS(id) ON DELETE CASCADE
);
--Creacion tabla MODULO
CREATE TABLE MODULO (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(200),
    
    PRIMARY KEY (id)
);


-- Creacion tabla EMPLEADO_MODULO
CREATE TABLE EMPLEADO_MODULO (
    id INT(11) NOT NULL,
    id_E INT(11) NOT NULL,

    FOREIGN KEY (id) REFERENCES MODULO(id) ON DELETE CASCADE,
    FOREIGN KEY (id_E) REFERENCES EMPLEADOS(id) ON DELETE CASCADE
);

-- Creacion tabla VALIDACIONES
CREATE TABLE VALIDACIONES (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_E INT(11) NOT NULL,
    id_P INT(11) NOT NULL,
    fase INT(3) NOT NULL,
    registro_fotografico VARCHAR(200),
    comentarios TEXT,
    PRIMARY KEY (id),
    FOREIGN KEY (id_E) REFERENCES EMPLEADOS(id) ON DELETE CASCADE,
    FOREIGN KEY (id_P) REFERENCES PEDIDOS(id) ON DELETE CASCADE
);
-- Creacion tabla DOCUMENTOS
CREATE TABLE DOCUMENTOS(
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_C INT(11) NOT NULL,
    nombre VARCHAR(250),
    tipoArchivo VARCHAR(250),
    
    PRIMARY key (id),
    FOREIGN KEY (id_C) REFERENCES CLIENTES(id) ON DELETE CASCADE
);

