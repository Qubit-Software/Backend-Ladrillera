DELETE FROM `empleados`;

DELETE FROM `usuarios`;

DELETE FROM `users`;

DELETE FROM `modulos`;

USE `ladrillera`;

SELECT * FROM `documentos`;

SELECT * FROM `clientes`;


# Testing data

INSERT INTO `ladrillera`.`clientes` (`nombre`, `apellido`, `cc_nit`, `tipo_cliente`, `ciudad`, `correo`, `telefono`) VALUES ('Ana', 'Hernandez', '101', 'Normal', 'Isnos-Huila', 'ana@gmail.com', '3115370810');
INSERT INTO `ladrillera`.`clientes` (`nombre`, `apellido`, `cc_nit`, `tipo_cliente`, `ciudad`, `correo`, `telefono`) VALUES ('Robin', 'Muñoz', '1084', 'Normal', 'Bogta', 'robinsonmu@gmail.com', '31153708');
INSERT INTO `ladrillera`.`clientes` (`nombre`, `apellido`, `cc_nit`, `tipo_cliente`, `ciudad`, `correo`, `telefono`) VALUES ('Natalia', 'Rodriguez', '2231', 'Empresa', 'Isnos-Huila', 'nata@gmail.com', '31153548');



