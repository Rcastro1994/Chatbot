
CREATE DATABASE SDTEEULMHCLN;

USE SDTEEULMHCLN;

CREATE TABLE usuarios (
id          int(255) auto_increment not null,
nombre      varchar(100) not null,
apellidos   varchar(255),
email       varchar(255) not null,
password    varchar(255) not null,
fnacimiento date not null,
rol         varchar(10),
imagen      varchar(255),
CONSTRAINT pk_usuarios PRIMARY KEY(id),
CONSTRAINT uq_email UNIQUE(email)
)ENGINE=InnoDb;

CREATE TABLE tests_psicologicos(
id          int(255) auto_increment not null,
nombre      varchar(100) not null,
pregunta1   varchar(255) not null,
pregunta2   varchar(255),
pregunta3   varchar(255),
pregunta4   varchar(255),
pregunta5   varchar(255),
pregunta6   varchar(255),
pregunta7   varchar(255),
pregunta8   varchar(255),
pregunta9   varchar(255),
pregunta10  varchar(255),
CONSTRAINT pk_tests_psicologicos PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE conversaciones(
id                  int(255) auto_increment not null,
usuario_id          int(255) not null,
psiquiatra_id       int(255),
CONSTRAINT pk_conversaciones PRIMARY KEY(id),
CONSTRAINT fk_usuario_conversacion FOREIGN KEY(usuario_id) REFERENCES usuarios(id),
CONSTRAINT fk_psicologo_conversacion FOREIGN KEY(psiquiatra_id) REFERENCES usuarios(id)
)ENGINE=InnoDb;

CREATE TABLE actas_reunion(
id              int(255) auto_increment not null,
conversacion_id int(255) not null,
fecha           date not null,
hora            time not null,
estado          varchar(50) not null,
CONSTRAINT pk_actas_reunion PRIMARY KEY(id),
CONSTRAINT fk_conversacion_acta FOREIGN KEY(conversacion_id) REFERENCES conversaciones(id)
)ENGINE=InnoDb;

CREATE TABLE respuestas_tests(
id          int(255) auto_increment not null,
usuario_id  int(255) not null,
test_id     int(255) not null,
respuesta1  varchar(255),
respuesta2  varchar(255),
respuesta3  varchar(255),
respuesta4  varchar(255),
respuesta5  varchar(255),
respuesta6  varchar(255),
respuesta7  varchar(255),
respuesta8  varchar(255),
respuesta9  varchar(255),
respuesta10  varchar(255),
CONSTRAINT pk_respuestas_test PRIMARY KEY(id),
CONSTRAINT fk_usuario_respuesta_test FOREIGN KEY(usuario_id) REFERENCES usuarios(id),
CONSTRAINT fk_test_respuesta_test FOREIGN KEY(test_id) REFERENCES tests_psicologicos(id)
)ENGINE=InnoDb;

