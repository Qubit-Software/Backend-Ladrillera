create database ladrillera;
use ladrillera;

--Creacion tabla empleado

CREATE TABLE empleado
(
    idEmpleado int(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250),
    apellido VARCHAR(250),
    cedulaDeCiudadania int(11),
    genero VARCHAR(20),
    fechaNacimiento DATE,
    cargo VARCHAR(250),
    PRIMARY KEY (idEmpleado)
);

--Creacion tabla usuario

CREATE TABLE usuario
(
    idUsuario int(11) NOT NULL AUTO_INCREMENT,
    idEmpleado int(11) NOT NULL,
    usuario VARCHAR(250),
    contraseña VARCHAR(250),
    FOREIGN KEY (idEmpleado) REFERENCES empleado(idEmpleado) ON DELETE CASCADE
);
--Creacion tabla pedido
CREATE TABLE pedido
(
    idPedido int(11) NOT NULL AUTO_INCREMENT,
    pedido VARCHAR(500),
    cantidad INT(15),
    descripcion TEXT,
    PRIMARY KEY (idPedido)
);

--Creacion tabla pedidoEmpleado
CREATE TABLE pedidoEmpleado
(
    idPedido int(11) NOT NULL,
    idEmpleado int(11) NOT NULL,
    PRIMARY KEY (idEmpleado),
    FOREIGN KEY (idPedido) REFERENCES pedido(idPedido) ON DELETE CASCADE,
    FOREIGN KEY (idEmpleado) REFERENCES empleado(idEmpleado) ON DELETE CASCADE
);

--Creacion tabla validacion
CREATE TABLE validacion
(
    idValidacion int(11) NOT NULL AUTO_INCREMENT,
    idEmpleado int(11) NOT NULL,
    idPedido int(11) NOT NULL,
    anexo VARCHAR(400),
    descripcion TEXT,
    PRIMARY KEY (idValidacion),
    FOREIGN KEY (idEmpleado) REFERENCES empleado(idEmpleado) ON DELETE CASCADE,
    FOREIGN KEY (idPedido) REFERENCES pedido(idPedido) ON DELETE CASCADE
);

--Creacion tabla impresion
CREATE TABLE impresion
(
    idImpresion int(11) NOT NULL AUTO_INCREMENT,
    idPedido int(11) NOT NULL,
    impreso VARCHAR(300),
    PRIMARY KEY (idImpresion),
    FOREIGN KEY (idPedido) REFERENCES pedidoEmpleado(idPedido) ON DELETE CASCADE
);

--Creacion tabla cliente
CREATE TABLE cliente
(
    idCliente int(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250),
    apellido VARCHAR(250),
    cedulaDeCiudadania int(15),
    PRIMARY KEY (idCliente)
);

--Creacion tabla documento
CREATE TABLE documento(
    idDocumento int(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(250),
    descripcion TEXT,
    tipoArchivo VARCHAR(250),
    PRIMARY key (idDocumento)
);

--Creacion tabla clienteDocumento
CREATE TABLE clienteDocumento(
    idDocumento int(11) NOT NULL,
    idCliente int(11) NOT NULL,
    PRIMARY key(idDocumento),
    FOREIGN KEY (idCliente) REFERENCES cliente(idCliente) ON DELETE CASCADE,
    FOREIGN KEY (idDocumento) REFERENCES documento(idDocumento) ON DELETE CASCADE
);

--Creacion tabla reclamo
CREATE TABLE reclamo(
    idReclamo int(11) NOT NULL AUTO_INCREMENT,
    tipo VARCHAR(200),
    descripcion TEXT,
    PRIMARY KEY(idReclamo)
);

--Creacion tabla clientePedido
CREATE TABLE clientePedido(
    idPedido int(11) NOT NULL,
    idCliente int(11) NOT NULL,
    estacion VARCHAR(300),
    PRIMARY KEY (idPedido),
    FOREIGN KEY (idPedido) REFERENCES pedido(idPedido) ON DELETE CASCADE,
    FOREIGN KEY (idCliente) REFERENCES cliente(idCliente) ON DELETE CASCADE
);

--Creacion tabla clientePedido
CREATE TABLE pedidoReclamo(
    idPedido int(11) NOT NULL,
    idReclamo int(11) NOT NULL,
    PRIMARY KEY (idPedido),
    FOREIGN KEY (idPedido) REFERENCES pedido(idPedido) ON DELETE CASCADE,
    FOREIGN KEY (idReclamo) REFERENCES reclamo(idReclamo) ON DELETE CASCADE
);