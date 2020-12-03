DROP DATABASE IF EXISTS ladrillera;

CREATE DATABASE IF NOT EXISTS ladrillera;

USE ladrillera;

CREATE TABLE usuarios (
    id INT(11) NOT NULL AUTO_INCREMENT,
    correo VARCHAR(250),
    contraseña VARCHAR(250),
    activo boolean DEFAULT 1,
    PRIMARY KEY (id)
);

CREATE TABLE empleados (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250),
    apellido VARCHAR(250),
    cedula_ciudadania VARCHAR(11) UNIQUE,
    correo VARCHAR(200),
    genero VARCHAR(20),
    fecha_nacimiento DATE,
    rol VARCHAR(250),
    foto VARCHAR(200),
    id_usuario INT(11) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_usuario) REFERENCES USUARIOS(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE clientes (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_empleado_asociado INT(11) NULL,
    nombre VARCHAR(250),
    apellido VARCHAR(250),
    cc_nit INT(15) UNIQUE,
    tipo_cliente VARCHAR(100),
    ciudad VARCHAR(150),
    correo VARCHAR(150),
    telefono VARCHAR(100) UNIQUE,
    PRIMARY KEY (id),
    FOREIGN KEY (id_empleado_asociado) REFERENCES EMPLEADOS(id) ON DELETE SET NULL
);

CREATE TABLE solicitud_clientes (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250) NOT NULL,
    telefono VARCHAR(150) NOT NULL,
    creado boolean NOT NULL DEFAULT FALSE,
    
    PRIMARY KEY (id)
);

CREATE TABLE pedidos (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_cliente INT(11) NOT NULL,
    fecha_cargue date,
    total BIGINT NOT null,
    estatus VARCHAR(100) NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (id_cliente) REFERENCES CLIENTES(id) ON DELETE CASCADE
);


CREATE TABLE productos_pedidos (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    id_pedido INT(11) NOT NULL,
    cantidad INT(15),
    codigo_producto TEXT NOT NULL,
    valor_total BIGINT NOT NULL,
    unidad_medicion TEXT NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (id_pedido) REFERENCES PEDIDOS(id) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE despachos_fotografia(
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    id_pedido INT(11) NOT NULL,
    foto VARCHAR(350),

    PRIMARY KEY (id),
    FOREIGN KEY (id_pedido) REFERENCES PEDIDOS(id) ON DELETE CASCADE
);

CREATE TABLE modulos (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(200),
    PRIMARY KEY (id)
);

CREATE TABLE empleados_modulos (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_modulo INT(11) NOT NULL,
    id_empleado INT(11) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_modulo) REFERENCES MODULOS(id) ON DELETE CASCADE,
    FOREIGN KEY (id_empleado) REFERENCES EMPLEADOS(id) ON DELETE CASCADE
);

CREATE TABLE validaciones (
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

CREATE TABLE documentos(
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_cliente INT(11) NOT NULL,
    file_path VARCHAR(500),
    nombre VARCHAR(250),
    tipo_documento VARCHAR(250),
    PRIMARY KEY (id),
    FOREIGN KEY (id_cliente) REFERENCES CLIENTES(id) ON DELETE CASCADE
);

CREATE TABLE notificaciones(
    id INT(11) NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(250) NOT NULL,
    body VARCHAR(500),
    router VARCHAR(500),
    alcance VARCHAR(500),
    prioridad INT(2),
    PRIMARY key (id)
);

CREATE TABLE notificaciones_empleados(
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_empleado INT(11) NOT NULL,
    id_notificacion INT(11) NOT NULL,
    lectura boolean NOT null,
    PRIMARY key (id),
    FOREIGN KEY (id_empleado) REFERENCES EMPLEADOS(id),
    FOREIGN KEY (id_notificacion) REFERENCES NOTIFICACIONES(id)
);

CREATE TABLE actualizaciones(
    id INT(11) NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(250) NOT NULL,
    descripcion text,
    fecha date,

    PRIMARY key (id)
);

CREATE TABLE actualizaciones_empleado(
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_actualizacion INT(11) NOT NULL,
    id_empleado INT(11) NOT NULL,
    lectura boolean NOT null,

    PRIMARY key (id),
    FOREIGN KEY (id_empleado) REFERENCES EMPLEADOS(id),
    FOREIGN KEY (id_actualizacion) REFERENCES ACTUALIZACIONES(id)
);
