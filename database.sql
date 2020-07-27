DROP DATABASE IF EXISTS ladrillera;

CREATE DATABASE IF NOT EXISTS ladrillera;

USE ladrillera;

CREATE TABLE EMPLEADOS (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250),
    apellido VARCHAR(250),
    cedula_ciudadania INT(11) UNIQUE,
    correo VARCHAR(200),
    genero VARCHAR(20),
    fecha_nacimiento DATE,
    rol VARCHAR(250),
    foto VARCHAR(200),
    PRIMARY KEY (id)
);

CREATE TABLE USUARIOS (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_empleado INT(11) NULL,
    correo VARCHAR(250),
    contraseña VARCHAR(250),
    activo boolean DEFAULT 1,
    PRIMARY KEY (id),
    FOREIGN KEY (id_empleado) REFERENCES EMPLEADOS(id) ON DELETE CASCADE
);

CREATE TABLE CLIENTES (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_empleado INT(11) NULL,
    nombre VARCHAR(250),
    apellido VARCHAR(250),
    cc_nit INT(15),
    tipo_cliente VARCHAR(100),
    ciudad VARCHAR(150),
    correo VARCHAR(150),
    telefono VARCHAR(100),
    PRIMARY KEY (id),
    FOREIGN KEY (id_empleado) REFERENCES EMPLEADOS(id) ON DELETE
    SET
        NULL
);

CREATE TABLE PEDIDOS (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_cliente INT(11) NOT NULL,
    id_empleado INT(11) NOT NULL,
    fecha_cargue date,
    comentario TEXT,
    PRIMARY KEY (id),
    FOREIGN KEY (id_cliente) REFERENCES CLIENTES(id) ON DELETE CASCADE,
    FOREIGN KEY (id_empleado) REFERENCES EMPLEADOS(id)
);

CREATE TABLE PRODUCTOS (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(200),
    descripcion TEXT,
    PRIMARY KEY (id)
);

CREATE TABLE PRODUCTOS_PEDIDOS (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    id_pedido INT(11) NOT NULL,
    id_producto INT(11) NOT NULL,
    cantidad INT(15),
    unid_medicion INT(15),
    PRIMARY KEY (id),
    FOREIGN KEY (id_pedido) REFERENCES PEDIDOS(id) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES PRODUCTOS(id) ON DELETE CASCADE
);

CREATE TABLE MODULOS (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(200),
    PRIMARY KEY (id)
);

CREATE TABLE EMPLEADOS_MODULOS (
    id_modulo INT(11) NOT NULL,
    id_empleado INT(11) NOT NULL,
    PRIMARY KEY (id_modulo,id_empleado),
    FOREIGN KEY (id_modulo) REFERENCES MODULOS(id) ON DELETE CASCADE,
    FOREIGN KEY (id_empleado) REFERENCES EMPLEADOS(id) ON DELETE CASCADE
);

CREATE TABLE VALIDACIONES (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_empleado INT(11) NOT NULL,
    id_pedido INT(11) NOT NULL,
    fase INT(3) NOT NULL,
    registro_fotografico VARCHAR(200),
    comentarios TEXT,
    PRIMARY KEY (id),
    FOREIGN KEY (id_empleado) REFERENCES EMPLEADOS(id) ON DELETE CASCADE,
    FOREIGN KEY (id_pedido) REFERENCES PEDIDOS(id) ON DELETE CASCADE
);

CREATE TABLE DOCUMENTOS(
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_cliente INT(11) NOT NULL,
    nombre VARCHAR(250),
    tipoArchivo VARCHAR(250),
    PRIMARY key (id),
    FOREIGN KEY (id_cliente) REFERENCES CLIENTES(id) ON DELETE CASCADE
);

CREATE TABLE NOTIFICACIONES(
    id INT(11) NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(250) NOT NULL,
    body VARCHAR(500),
    router VARCHAR(500),
    alcance VARCHAR(500),
    prioridad INT(2),
    PRIMARY key (id)
);

CREATE TABLE NOTIFICACIONES_EMPLEADOS(
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_empleado INT(11) NOT NULL,
    id_notificacion INT(11) NOT NULL,
    PRIMARY key (id),
    FOREIGN KEY (id_empleado) REFERENCES EMPLEADOS(id),
    FOREIGN KEY (id_notificacion) REFERENCES NOTIFICACIONES(id)
);

DELETE FROM
    `empleados`;

DELETE FROM
    `usuarios`;

DELETE FROM
    `users`;

DELETE FROM
    `modulos`;