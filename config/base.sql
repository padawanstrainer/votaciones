DROP DATABASE IF EXISTS castawards;
CREATE DATABASE castawards CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
USE castawards;

CREATE TABLE ceremonias(
    ID SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NOMBRE VARCHAR(100),
    FECHA_NOMINACIONES_INICIO DATETIME,
    FECHA_NOMINACIONES_FIN DATETIME,
    FECHA_VOTACIONES_INICIO DATETIME,
    FECHA_VOTACIONES_FIN DATETIME,
    FECHA_RESULTADOS_VISIBLES DATETIME,
    FECHA_ALTA DATETIME,
    CEREMONIA_ACTUAL TINYINT(1) NOT NULL DEFAULT 0
)ENGINE=innoDB;


CREATE TABLE categorias(
    ID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    CATEGORIA VARCHAR(100) NOT NULL,
    ORDEN SMALLINT UNSIGNED,
    FKCEREMONIA SMALLINT UNSIGNED,
    CONSTRAINT CATEGORIA_CEREMONIA FOREIGN KEY(FKCEREMONIA) REFERENCES ceremonias(ID) ON DELETE RESTRICT ON UPDATE CASCADE
)ENGINE=innoDB;


CREATE TABLE usuarios(
    ID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    EMAIL VARCHAR(200) NOT NULL UNIQUE,
    CLAVE VARCHAR(40) NOT NULL,
    -- SI QUIERE USTED MAS DATOS DE SU USUARIO, SIENTASE LIBRE DE AGREGARLOS A ESTE CREATE MAGICO QUE LE DEJO EN ESTE ES CU ELE.
    ACTIVO TINYINT(1) NOT NULL DEFAULT 1,
    ES_ADMIN TINYINT(1) NOT NULL DEFAULT 0,
    FECHA_ALTA DATETIME
)ENGINE=innoDB;


CREATE TABLE recuperar_claves(
    FKUSUARIO INT UNSIGNED NOT NULL PRIMARY KEY,
    TOKEN VARCHAR(100) NOT NULL,
    FECHA_ALTA DATETIME,
    NUEVA_CLAVE VARCHAR(40),
    CONSTRAINT RECUPERAR_USUARIO FOREIGN KEY(FKUSUARIO) REFERENCES usuarios(ID) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=innoDB;


CREATE TABLE nominaciones(
    ID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NOMINADO VARCHAR(200) NOT NULL,
    IMAGEN VARCHAR(100),
    ACTIVO TINYINT(1) DEFAULT NULL, -- NULL=PENDIENTE, 0=RECHAZADO, 1=NOMINACIÓN ACEPTADA PARA VOTAR...
    FECHA_ALTA DATETIME,
    FKUSUARIO INT UNSIGNED NOT NULL,
    FKCATEGORIA INT UNSIGNED NOT NULL,
    UUID VARCHAR(100) NOT NULL, -- ESTO ES SOLO A LOS EFECTOS DE LOS FORMULARIO VIA WEB, PARA QUE NO SEAN UNA SECUENCIA PREDECIBLE 1,2,3,4....
    CONSTRAINT NOMINACION_USUARIO FOREIGN KEY(FKUSUARIO) REFERENCES usuarios(ID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT NOMINACION_CATEGORIA FOREIGN KEY(FKCATEGORIA) REFERENCES categorias(ID) ON DELETE CASCADE ON UPDATE CASCADE
 )ENGINE=innoDB;

 CREATE TABLE votos(
    FKUSUARIO INT UNSIGNED NOT NULL,
    FKNOMINACION INT UNSIGNED NOT NULL,
    CONSTRAINT VOTO_USUARIO FOREIGN KEY(FKUSUARIO) REFERENCES usuarios(ID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT VOTO_NOMINACION FOREIGN KEY(FKNOMINACION) REFERENCES nominaciones(ID) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(FKUSUARIO,FKNOMINACION)
 )ENGINE=innoDB;