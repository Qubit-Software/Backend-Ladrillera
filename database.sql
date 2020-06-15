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
    cargo VARCHAR(250),
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

-- Creacion tabla pedido_empleado
CREATE TABLE PEDIDO_EMPLEADO (
    id_pedido INT(11) NOT NULL,
    id_empleado INT(11) NOT NULL,
    PRIMARY KEY (id_empleado),
    FOREIGN KEY (id_pedido) REFERENCES PEDIDOS(id_pedido) ON DELETE CASCADE,
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

-- Creacion tabla IMPRESIONES
CREATE TABLE IMPRESIONES (
    id_impresion INT(11) NOT NULL AUTO_INCREMENT,
    id_pedido INT(11) NOT NULL,
    impreso VARCHAR(300),
    PRIMARY KEY (id_impresion),
    FOREIGN KEY (id_pedido) REFERENCES pedido_empleado(id_pedido) ON DELETE CASCADE
);

-- Creacion tabla CLIENTES
CREATE TABLE CLIENTES (
    id_cliente INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250),
    apellido VARCHAR(250),
    cedula_ciudadania INT(15),
    PRIMARY KEY (id_cliente)
);

-- Creacion tabla DOCUMENTOS
CREATE TABLE DOCUMENTOS(
    id_documento INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250),
    descripcion TEXT,
    tipoArchivo VARCHAR(250),
    PRIMARY key (id_documento)
);

-- Creacion tabla cliente_documento
CREATE TABLE CLIENTE_DOCUMENTO(
    id_documento INT(11) NOT NULL,
    id_cliente INT(11) NOT NULL,
    PRIMARY key(id_documento),
    FOREIGN KEY (id_cliente) REFERENCES CLIENTES(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_documento) REFERENCES DOCUMENTOS(id_documento) ON DELETE CASCADE
);

-- Creacion tabla RECLAMOS
CREATE TABLE RECLAMOS(
    id_reclamo INT(11) NOT NULL AUTO_INCREMENT,
    tipo VARCHAR(200),
    descripcion TEXT,
    PRIMARY KEY(id_reclamo)
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

-- Creacion tabla cliente_pedido
CREATE TABLE PEDIDO_RECLAMO(
    id_pedido INT(11) NOT NULL,
    id_reclamo INT(11) NOT NULL,
    PRIMARY KEY (id_pedido),
    FOREIGN KEY (id_pedido) REFERENCES PEDIDOS(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_reclamo) REFERENCES RECLAMOS(id_reclamo) ON DELETE CASCADE
);