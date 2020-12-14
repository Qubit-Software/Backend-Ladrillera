DELETE FROM `empleados`;

DELETE FROM `usuarios`;

DELETE FROM `users`;

DELETE FROM `modulos`;

USE `ladrillera`;

SELECT * FROM `documentos`;

SELECT * FROM `documentos` where id_cliente=2;


SELECT * FROM `clientes`;

SELECT * FROM `clientes` WHERE `CC_NIT` = '1251235654';


SELECT * FROM `users`;

SELECT * FROM `usuarios`;

SELECT * FROM `notificaciones`;

SELECT * FROM `notificaciones_empleados`;

SELECT * FROM `empleados`;

SELECT * FROM `modulos`;

DROP DATABASE `ladrillera`;

SELECT * FROM `empleados_modulos`;

USE `ladrillera`;

SELECT * FROM `pedidos`;

SELECT * FROM `users`;

SELECT * FROM `usuarios`;

SELECT * FROM `empleados`;

DELETE  FROM `users` where `id` <> 0; 

SELECT * FROM `productos_pedidos`;

SELECT * FROM `pedidos`;

# Testing data

INSERT INTO `ladrillera`.`clientes` (`nombre`, `apellido`, `cc_nit`, `tipo_cliente`, `ciudad`, `correo`, `telefono`) VALUES ('Ana', 'Hernandez', '101', 'Normal', 'Isnos-Huila', 'ana@gmail.com', '3115370810');
INSERT INTO `ladrillera`.`clientes` (`nombre`, `apellido`, `cc_nit`, `tipo_cliente`, `ciudad`, `correo`, `telefono`) VALUES ('Robin', 'Muñoz', '1084', 'Normal', 'Bogta', 'robinsonmu@gmail.com', '31153708');
INSERT INTO `ladrillera`.`clientes` (`nombre`, `apellido`, `cc_nit`, `tipo_cliente`, `ciudad`, `correo`, `telefono`) VALUES ('Natalia', 'Rodriguez', '2231', 'Empresa', 'Isnos-Huila', 'nata@gmail.com', '31153548');



SELECT * FROM `solicitud_clientes`;

ALTER TABLE `users` AUTO_INCREMENT = 0;
ALTER TABLE `usuarios` AUTO_INCREMENT = 0;
ALTER TABLE `empleados` AUTO_INCREMENT = 0;

SELECT * FROM `documentos`;

SELECT * FROM `actualizaciones`;

SELECT * FROM `pedidos`;

SELECT * FROM `despachos_fotografias`;

# Cuando se elimina un empleado se deben eliminar sus relaciones con las demas tablas
