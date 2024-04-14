CREATE DATABASE agrocacao COLLATE = utf8_unicode_ci;


CREATE TABLE
    tipo_usuario(
        id_tipo_us INT(255) AUTO_INCREMENT NOT NULL,
        nombre_tipo_us VARCHAR(100) NOT NULL,
        CONSTRAINT pk_tipo_usuario PRIMARY KEY(id_tipo_us)
    ) ENGINE = InnoDB;

INSERT INTO
    tipo_usuario (id_tipo_us, nombre_tipo_us)
VALUES  (1, 'Administrador'), (2, 'cliente');



CREATE TABLE
    estado_usuario(
        id_estado_us INT AUTO_INCREMENT NOT NULL,
        nombre_estado_us VARCHAR(70) NOT NULL,
        CONSTRAINT pk_id_estado_us PRIMARY KEY(id_estado_us)
    ) ENGINE = InnoDb;

INSERT INTO
    estado_usuario(nombre_estado_us)
VALUES ("Habilitado"), ("Deshabilitado");


CREATE TABLE
    usuario(
        id_us INT(255) AUTO_INCREMENT NOT NULL,
        nombre_us VARCHAR(50) NOT NULL,
        apellido_us VARCHAR(50) NOT NULL,
        edad_us DATE NOT NULL,
        ci_us VARCHAR(10) NOT NULL,
        telefono VARCHAR(12),
        email_us VARCHAR(100) NOT NULL,
        contrasena_us VARCHAR(100) NOT NULL,
        tipo_us_id INT(255) NOT NULL,
        estado_us_id INT(255) NOT NULL,
        avatar VARCHAR(255),
        creado_en DATETIME,
        actualizado_en DATETIME, 
        CONSTRAINT pk_usuario PRIMARY KEY(id_us),
        CONSTRAINT uq_email_us UNIQUE(email_us),
        CONSTRAINT fk_usuario_tipo_usuario FOREIGN KEY(tipo_us_id) REFERENCES tipo_usuario(id_tipo_us),
        CONSTRAINT fk_usuario_estado_usuario FOREIGN KEY(estado_us_id) REFERENCES estado_usuario(id_estado_us)
    ) ENGINE = InnoDb;


