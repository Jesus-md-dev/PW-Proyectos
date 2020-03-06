drop DATABASE IF EXISTS p1;

CREATE DATABASE p1;

USE p1;

DROP TABLE IF EXISTS Asignatura;
DROP TABLE IF EXISTS Inf_Per;
DROP TABLE IF EXISTS Preg_Resp;
DROP TABLE IF EXISTS Pregunta;
DROP TABLE IF EXISTS Profesor;
DROP TABLE IF EXISTS Prof_Asig;

CREATE TABLE Asig_Nom (
    id_asig smallint auto_increment primary key,
    nombre varchar(30)
)

CREATE TABLE Tit_Nom (
    cod_tit smallint primary key,
    nombre varchar(50)
)

CREATE TABLE Asignatura (
	id_asig smallint primary key,
    cod_tit smallint,
    cod_asig smallint,
    cod_grup tinyint,
    foreign key(id_asig) references Asig_Nom(id_asig),
    foreign key(cod_tit) references Tit_Nom(cod_tit)
);

CREATE TABLE Pregunta (
    cod_preg tinyint auto_increment primary key,
    enunciado varchar(200)
)

CREATE TABLE Profesor (
    cod_prof smallint primary key,
    nombre varchar(50),
    telefono varchar(9)
)

CREATE TABLE Prof_Asig (
    cod_prof smallint,
    id_asig smallint,
    foreign key(cod_prof) references Profesor(cod_prof),
    foreign key(id_asig) references Asignatura(id_asig),
    primary key(cod_prof, id_asig)
)

CREATE TABLE Inf_Per (
    id_ip integer auto_increment primary key,
    id_asig integer,
    edad tinyint,
    sexo enum('H', 'M'),
    curso_sup tinyint,
    curso_inf tinyint,
    n_matri tinyint,
    n_exam tinyint,
    interes enum('nada', 'algo', 'bastante', 'mucho'),
    tutorias enum('nada', 'algo', 'bastante', 'mucho'),
    dificultad enum('baja', 'media', 'alta', 'muy alta'),
    calif enum('np', 'suspenso', 'aprobado', 'notable', 'sobre', 'mh'),
    asist enum('baja', 'normal', 'alta'),
    foreign key(id_asig) references Asignatura(id_asig)
);

CREATE TABLE Preg_Resp (
    id_ip integer,
    cod_prof smallint,
    resp_1 tinyint,
    resp_2 tinyint,
    -- ... ,
    resp_n tinyint
    foreign key(id_ip) references Inf_Per(id_ip),
    foreign key(cod_prof) references Profesor(cod_prof),
    primary key(id_ip, cod_prof)
)

insert into preguntas values(NULL,'¿Eres maricon?');
insert into preguntas values(NULL,'¿Hola?');
insert into preguntas values(NULL,'¿Estas viendo porno solo?');