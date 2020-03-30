DROP DATABASE IF EXISTS ladrillera;

CREATE DATABASE IF NOT EXISTS ladrillera;

USE ladrillera;

-- Creacion tabla empleados
CREATE TABLE empleados (
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
    empleados (id_empleado, nombre)
values
    (NULL, "Robinson"),
    (NULL, "Ana"),
;

-- Creacion tabla usuarios
CREATE TABLE usuarios (
    id_usuario INT(11) NOT NULL AUTO_INCREMENT,
    id_empleado INT(11) NOT NULL,
    usuarios VARCHAR(250),
    contraseña VARCHAR(250),
    PRIMARY KEY (id_usuario),
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado) ON DELETE CASCADE
);

-- Creacion tabla pedidos
CREATE TABLE pedidos (
    id_pedido INT(11) NOT NULL AUTO_INCREMENT,
    pedidos VARCHAR(500),
    cantidad INT(15),
    descripcion TEXT,
    PRIMARY KEY (id_pedido)
);

-- Creacion tabla pedido_empleado
CREATE TABLE pedido_empleado (
    id_pedido INT(11) NOT NULL,
    id_empleado INT(11) NOT NULL,
    PRIMARY KEY (id_empleado),
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado) ON DELETE CASCADE
);

-- Creacion tabla validacion
CREATE TABLE validacion (
    id_validacion INT(11) NOT NULL AUTO_INCREMENT,
    id_empleado INT(11) NOT NULL,
    id_pedido INT(11) NOT NULL,
    anexo VARCHAR(400),
    descripcion TEXT,
    PRIMARY KEY (id_validacion),
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado) ON DELETE CASCADE,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido) ON DELETE CASCADE
);

-- Creacion tabla impresiones
CREATE TABLE impresiones (
    id_impresion INT(11) NOT NULL AUTO_INCREMENT,
    id_pedido INT(11) NOT NULL,
    impreso VARCHAR(300),
    PRIMARY KEY (id_impresion),
    FOREIGN KEY (id_pedido) REFERENCES pedido_empleado(id_pedido) ON DELETE CASCADE
);

-- Creacion tabla clientes
CREATE TABLE clientes (
    id_cliente INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250),
    apellido VARCHAR(250),
    cedula_ciudadania INT(15),
    PRIMARY KEY (id_cliente)
);

-- Creacion tabla documentos
CREATE TABLE documentos(
    id_documento INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250),
    descripcion TEXT,
    tipoArchivo VARCHAR(250),
    PRIMARY key (id_documento)
);

-- Creacion tabla cliente_documento
CREATE TABLE cliente_documento(
    id_documento INT(11) NOT NULL,
    id_cliente INT(11) NOT NULL,
    PRIMARY key(id_documento),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_documento) REFERENCES documentos(id_documento) ON DELETE CASCADE
);

-- Creacion tabla reclamos
CREATE TABLE reclamos(
    id_reclamo INT(11) NOT NULL AUTO_INCREMENT,
    tipo VARCHAR(200),
    descripcion TEXT,
    PRIMARY KEY(id_reclamo)
);

-- Creacion tabla cliente_pedido
CREATE TABLE cliente_pedido(
    id_pedido INT(11) NOT NULL,
    id_cliente INT(11) NOT NULL,
    estacion VARCHAR(300),
    PRIMARY KEY (id_pedido),
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE
);

-- Creacion tabla cliente_pedido
CREATE TABLE pedido_reclamo(
    id_pedido INT(11) NOT NULL,
    id_reclamo INT(11) NOT NULL,
    PRIMARY KEY (id_pedido),
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_reclamo) REFERENCES reclamos(id_reclamo) ON DELETE CASCADE
);