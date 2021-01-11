-- Users for the db
USE mysql;
DROP PROCEDURE IF EXISTS exec_stmt;
DROP PROCEDURE IF EXISTS drop_user;

DELIMITER !
CREATE PROCEDURE exec_stmt(stmt_str TEXT)
    BEGIN
        SET @_stmt_str = stmt_str;
        PREPARE stmt FROM @_stmt_str;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
    END!

CREATE PROCEDURE drop_user(user TEXT, host TEXT)
    BEGIN
        DECLARE account TEXT;
        DECLARE CONTINUE HANDLER FOR 1396
        SELECT CONCAT('Unknown user: ', account) AS Message;
        SET account = CONCAT(QUOTE(user), '@', QUOTE(host));
        CALL exec_stmt(CONCAT('DROP USER ', account));
    END!

DELIMITER ;
-- Drop users
CALL drop_user('dbmigrate', '%');
CALL drop_user('dbuser', '%');

CREATE USER 'dbmigrate'@'%' IDENTIFIED BY 'dbmigrate_pw';
GRANT USAGE ON ladrillera.* TO 'dbmigrate'@'%';
GRANT SELECT, EXECUTE, SHOW VIEW, ALTER, CREATE, CREATE TEMPORARY TABLES, CREATE VIEW, DELETE, DROP, EVENT, INDEX, INSERT, REFERENCES, TRIGGER, UPDATE, LOCK TABLES ON ladrillera.* TO 'dbmigrate'@'%' WITH GRANT OPTION;

CREATE USER 'dbuser'@'%' IDENTIFIED BY 'dbuser_pw';
GRANT USAGE ON ladrillera.* TO 'dbuser'@'%';
GRANT SELECT, EXECUTE, DELETE, INSERT, UPDATE ON ladrillera.* TO 'dbuser'@'%';
FLUSH PRIVILEGES;
DROP PROCEDURE IF EXISTS exec_stmt;
DROP PROCEDURE IF EXISTS drop_user;


SHOW GRANTS FOR 'dbuser'@'%';   
SHOW GRANTS FOR 'dbmigrate'@'%';   