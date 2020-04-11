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
    id_doc integer auto_increment,
    cod_tit varchar(4),
    cod_asig varchar(3),
    cod_grup varchar(2),
    foreign key(cod_tit) references Titulacion(cod_tit),
    foreign key(cod_asig) references Asignatura(cod_asig),
    foreign key(cod_grup) references Grupo(cod_grup),
    primary key(id_doc,cod_tit,cod_asig,cod_grup)
);

CREATE TABLE ProfesorDocencia (
    id_doc integer,
    cod_prof varchar(4),
    foreign key(id_doc) references Docencia(id_doc),
    foreign key(cod_prof) references Profesor(cod_prof),
    primary key(id_doc, cod_prof)
);

CREATE TABLE Pregunta (
    cod_preg integer auto_increment primary key,
    enunciado varchar(200),
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
    cod_prof varchar(4),
    resp integer,
    foreign key(id_en) references Encuesta(id_en),
    foreign key(cod_preg) references Pregunta(cod_preg),
    foreign key(cod_prof) references ProfesorDocencia(cod_prof),
    primary key(id_en,cod_preg,cod_prof)
);

insert into pregunta values(NULL,'Pregunta 1',0,0);
insert into pregunta values(NULL,'Pregunta 2',0,0);
insert into pregunta values(NULL,'Pregunta 3',0,0);

insert into Titulacion values ('0001','Titulacion 1');
insert into Titulacion values ('0002','Titulacion 2');
insert into Asignatura values ('001','Asignatura 1');
insert into Asignatura values ('002','Asignatura 2');
insert into Grupo values ('01');
insert into Grupo values ('02');

insert into Profesor values('0001','profesor 1',1);
insert into Profesor values('0002','profesor 2',2);
insert into Profesor values('0003','profesor 3',3);

insert into docencia values(NULL,'0001','001','01');
insert into docencia values(NULL,'0002','002','02');
insert into docencia values(NULL,'0001','001','02');
insert into docencia values(NULL,'0001','002','02');

insert into ProfesorDocencia values(1,'0001');
insert into ProfesorDocencia values(2,'0001');
insert into ProfesorDocencia values(2,'0002');
insert into ProfesorDocencia values(3,'0003');
insert into ProfesorDocencia values(4,'0001');