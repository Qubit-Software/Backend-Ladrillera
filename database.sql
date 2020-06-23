DROP DATABASE IF EXISTS ladrillera;

CREATE DATABASE IF NOT EXISTS ladrillera;

USE ladrillera;

-- Creacion tabla EMPLEADOS
CREATE TABLE EMPLEADOS (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250),
    apellido VARCHAR(250),
    cedula_ciudadania INT(11),
    genero VARCHAR(20),
    fecha_nacimiento DATE,
    rol VARCHAR(250),
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
    PRIMARY KEY (id),
    FOREIGN KEY (id_E) REFERENCES EMPLEADOS(id) ON DELETE CASCADE
);

-- Creacion tabla PEDIDOS
CREATE TABLE PEDIDOS (
    id INT(11) NOT NULL AUTO_INCREMENT,
    PEDIDO VARCHAR(500),
    cantidad INT(15),
    descripcion TEXT,
    PRIMARY KEY (id)
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
    anexo VARCHAR(400),
    descripcion TEXT,
    PRIMARY KEY (id),
    FOREIGN KEY (id_E) REFERENCES EMPLEADOS(id) ON DELETE CASCADE,
    FOREIGN KEY (id_P) REFERENCES PEDIDOS(id) ON DELETE CASCADE
);

-- Creacion tabla CLIENTES
CREATE TABLE CLIENTES (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250),
    apellido VARCHAR(250),
    cedula_ciudadania INT(15),
    PRIMARY KEY (id)
);
--Creacion tabla EMPLEADOS_CLIENTES
CREATE TABLE EMPLEADOS_CLIENTES (
    id_C INT(11) NOT NULL,
    id_E INT(11) NOT NULL,

    FOREIGN KEY (id_C) REFERENCES CLIENTES(id) ON DELETE CASCADE,
    FOREIGN KEY (id_E) REFERENCES EMPLEADOS(id) ON DELETE CASCADE
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
