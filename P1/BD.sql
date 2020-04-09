drop DATABASE IF EXISTS p1;

CREATE DATABASE p1;

USE p1;

DROP TABLE IF EXISTS Asignatura;
DROP TABLE IF EXISTS Inf_Per;
DROP TABLE IF EXISTS Preg_Resp;
DROP TABLE IF EXISTS Pregunta;
DROP TABLE IF EXISTS Profesor;
DROP TABLE IF EXISTS Prof_Asig;

CREATE TABLE Tit_Nom (
    cod_tit smallint primary key,
    nombre varchar(50) not null
);

CREATE TABLE Asig_Nom (
    id_asig integer auto_increment not null,
    cod_asig smallint,
    cod_tit smallint,
    nombre varchar(30) not null,
    primary key(cod_asig, cod_tit),
    foreign key(cod_tit) references Tit_Nom(cod_tit)
);

CREATE TABLE Grupo (
	id_grupo integer auto_increment not null,
    id_asig integer not null,
    cod_grup tinyint,
    primary key(id_asig, cod_grup),
    foreign key(cod_asig) references Asig_Nom(cod_asig),
    foreign key(cod_tit) references Tit_Nom(cod_tit)
);

CREATE TABLE Pregunta (
    cod_preg tinyint auto_increment primary key,
    enunciado varchar(200)
);

CREATE TABLE Profesor (
    cod_prof smallint primary key,
    nombre varchar(50),
    telefono varchar(9)
);

CREATE TABLE Prof_Grup (
    cod_prof smallint,
    id_grup smallint,
    foreign key(cod_prof) references Profesor(cod_prof),
    foreign key(id_grup) references Asignatura(id_grup),
    primary key(cod_prof, id_grup)
);

CREATE TABLE Inf_Per (
    id_ip integer auto_increment primary key,
    id_grup integer,
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
    foreign key(id_grup) references Asignatura(id_grup)
);

CREATE TABLE Respuesta (
    cod_prof smallint,
    id_ip integer,
    cod_preg tinyint,
    contestacion tinyint,
    foreign key(id_ip) references Inf_Per(id_ip),
    foreign key(cod_prof) references Profesor(cod_prof),
    foreign key(cod_preg) references Pregunta(cod_preg),
    primary key(cod_prof, id_ip, cod_preg)
);

insert into preguntas values(NULL,'¿Eres maricon?');
insert into preguntas values(NULL,'¿Hola?');
insert into preguntas values(NULL,'¿Estas viendo porno solo?');