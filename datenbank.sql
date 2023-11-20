create table mitarbeiter (
    id int(11) not null auto_increment primary key,
    name varchar(255) not null,
    vorname varchar(255) not null, 
    email varchar(255) not null,
    tel varchar(255) not null,
    position varchar(255) not null,
    abteilung varchar(255) not null
);