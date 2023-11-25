create database cedup;
use cedup;
create table usuarios (id int not null auto_increment primary key, nome varchar(50) not null, login varchar(50) not null, senha varchar(50) not null);
select * from usuarios;
drop table usuarios;
show databases;
drop database cedup;