drop DATABASE IF EXISTS p1;

CREATE DATABASE p1;

USE p1;

DROP TABLE IF EXISTS Asignatura;
DROP TABLE IF EXISTS Inf_Per;
DROP TABLE IF EXISTS Preg_Resp;
DROP TABLE IF EXISTS Pregunta;
DROP TABLE IF EXISTS Profesor;
DROP TABLE IF EXISTS Prof_Asig;

CREATE TABLE preguntas (
	pre_id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta VARCHAR(100)
);

insert into preguntas values(NULL,'¿Eres maricon?');
insert into preguntas values(NULL,'¿Hola?');
insert into preguntas values(NULL,'¿Estas viendo porno solo?');