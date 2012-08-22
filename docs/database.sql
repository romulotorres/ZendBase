/*

create table core.users(
	id serial primary key,
	name character varying not null,
	login character varying not null,
	password character varying not null,
	active boolean default 't' 
);

insert into core.users (name, login, password) values ('Administrador', 'admin', md5('1234'));

create table core.departments(
	id serial primary key,
	name character varying not null
	
);

insert into core.departments (name) values ('GERAL');

create table core.department_departaments(
	id serial primary key,
	department_id integer references core.departments(id),
	parent_department_id integer references core.departments(id)
);

*/

--parent_department