drop DATABASE IF EXISTS p1;

CREATE DATABASE p1;

USE p1;

CREATE TABLE Asignatura (
    cod_asig varchar(3) primary key,
    nombre varchar(30)
);

CREATE TABLE Titulacion (
    cod_tit varchar(4) primary key,
    nombre varchar(50)
);

CREATE TABLE Profesor (
    cod_prof varchar(4) primary key,
    nombre varchar(50),
    telefono varchar(9)
);

CREATE TABLE Grupo (
    cod_grup varchar(2) primary key
);

CREATE TABLE Docencia (
    id_doc integer auto_increment primary key,
    cod_tit integer,
    cod_asig integer,
    cod_prof integer,
    cod_grup integer,
    foreign key(cod_tit) references Titulacion(cod_tit),
    foreign key(cod_asig) references Asignatura(cod_asig),
    foreign key(cod_prof) references Profesor(cod_prof),
    foreign key(cod_grup) references Grupo(cod_grup)
);

CREATE TABLE Pregunta (
    cod_preg integer auto_increment primary key,
    enunciado varchar(200)
);

CREATE TABLE Encuesta (
    id_en integer auto_increment primary key,
    id_doc integer,
    edad integer,
    sexo integer,
    curso_sup integer,
    curso_inf integer,
    n_matri integer,
    n_exam integer,
    interes integer,
    tutorias integer,
    dificultad integer,
    calif integer,
    asist integer,
    foreign key(id_doc) references Docencia(id_doc)
);

CREATE TABLE Respuesta (
    id_en integer,
    cod_preg integer,
    resp integer,
    foreign key(id_en) references Encuesta(id_en),
    foreign key(cod_preg) references Pregunta(cod_preg),
    primary key(id_en,cod_preg)
);

insert into pregunta values(NULL,'Pregunta 1');
insert into pregunta values(NULL,'Pregunta 2');
insert into pregunta values(NULL,'Pregunta 3');

insert into Titulacion values ('0001','Titulacion 1');
insert into Asignatura values ('001','Asignatura 1');
insert into Grupo values ('01');
insert into Grupo values ('02');

insert into Profesor values('0001','profesor 1',1);
insert into Profesor values('0002','profesor 2',2);
insert into Profesor values('0003','profesor 3',3);