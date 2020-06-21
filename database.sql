DROP DATABASE IF EXISTS ladrillera;

CREATE DATABASE IF NOT EXISTS ladrillera;

USE ladrillera;

-- Creacion tabla EMPLEADOS
CREATE TABLE EMPLEADOS (
    id_empleado INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250),
    apellido VARCHAR(250),
    cedula_ciudadania INT(11),
    genero VARCHAR(20),
    fecha_nacimiento DATE,
    rol VARCHAR(250),
    PRIMARY KEY (id_empleado)
);

INSERT INTO
    EMPLEADOS (id_empleado, nombre)
values
    (NULL, "Robinson"),
    (NULL, "Ana");

-- Creacion tabla USUARIOS
CREATE TABLE USUARIOS (
    id_usuario INT(11) NOT NULL AUTO_INCREMENT,
    id_empleado INT(11) NOT NULL,
    usuario VARCHAR(250),
    contraseña VARCHAR(250),
    PRIMARY KEY (id_usuario),
    FOREIGN KEY (id_empleado) REFERENCES EMPLEADOS(id_empleado) ON DELETE CASCADE
);

-- Creacion tabla PEDIDOS
CREATE TABLE PEDIDOS (
    id_pedido INT(11) NOT NULL AUTO_INCREMENT,
    PEDIDO VARCHAR(500),
    cantidad INT(15),
    descripcion TEXT,
    PRIMARY KEY (id_pedido)
);
--Creacion tabla MODULO
CREATE TABLE MODULO (
    id_modulo INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(200),
    
    PRIMARY KEY (id_modulo)
);
-- Creacion tabla EMPLEADO_MODULO
CREATE TABLE EMPLEADO_MODULO (
    id_modulo INT(11) NOT NULL,
    id_empleado INT(11) NOT NULL,

    FOREIGN KEY (id_modulo) REFERENCES MODULO(id_modulo) ON DELETE CASCADE,
    FOREIGN KEY (id_empleado) REFERENCES EMPLEADOS(id_empleado) ON DELETE CASCADE
);

-- Creacion tabla VALIDACIONES
CREATE TABLE VALIDACIONES (
    id_validacion INT(11) NOT NULL AUTO_INCREMENT,
    id_empleado INT(11) NOT NULL,
    id_pedido INT(11) NOT NULL,
    anexo VARCHAR(400),
    descripcion TEXT,
    PRIMARY KEY (id_validacion),
    FOREIGN KEY (id_empleado) REFERENCES EMPLEADOS(id_empleado) ON DELETE CASCADE,
    FOREIGN KEY (id_pedido) REFERENCES PEDIDOS(id_pedido) ON DELETE CASCADE
);

-- Creacion tabla CLIENTES
CREATE TABLE CLIENTES (
    id_cliente INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250),
    apellido VARCHAR(250),
    cedula_ciudadania INT(15),
    PRIMARY KEY (id_cliente)
);
--Creacion tabla EMPLEADOS_CLIENTES
CREATE TABLE EMPLEADOS_CLIENTES (
    id_cliente INT(11) NOT NULL AUTO_INCREMENT,
    id_empleado INT(11) NOT NULL,

    FOREIGN KEY (id_cliente) REFERENCES CLIENTES(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_empleado) REFERENCES EMPLEADOS(id_empleado) ON DELETE CASCADE
);

-- Creacion tabla DOCUMENTOS
CREATE TABLE DOCUMENTOS(
    id_documento INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250),
    descripcion TEXT,
    tipoArchivo VARCHAR(250),
    PRIMARY key (id_documento)
);

-- Creacion tabla CLIENTE_DOCUMENTO
CREATE TABLE CLIENTE_DOCUMENTO(
    id_documento INT(11) NOT NULL,
    id_cliente INT(11) NOT NULL,
    PRIMARY key(id_documento),
    FOREIGN KEY (id_cliente) REFERENCES CLIENTES(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_documento) REFERENCES DOCUMENTOS(id_documento) ON DELETE CASCADE
);

-- Creacion tabla cliente_pedido
CREATE TABLE CLIENTE_PEDIDO(
    id_pedido INT(11) NOT NULL,
    id_cliente INT(11) NOT NULL,
    estacion VARCHAR(300),
    PRIMARY KEY (id_pedido),
    FOREIGN KEY (id_pedido) REFERENCES PEDIDOS(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_cliente) REFERENCES CLIENTES(id_cliente) ON DELETE CASCADE
);
