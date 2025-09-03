drop database if exists blog;
create database if not exists blog;

use blog;

create table usuario(
	id int not null auto_increment,
    nome varchar(50) not null,
    email varchar(255) not null,
    senha varchar(60) not null,
    data_criacao datetime not null default CURRENT_TIMESTAMP,
    ativo bool not null default false,
    adm bool not null default false,
    primary key (id)
);

create table post(
	id int not null auto_increment,
    titulo varchar(255) not null,
    texto text not null,
    usuario_id int not null,
    data_criacao datetime not null default CURRENT_TIMESTAMP,
    data_postagem datetime not null,
    primary key (id),
    key fk_post_usuario_idx (usuario_id),
    constraint fk_post_usuario foreign key (usuario_id) references usuario(id)
);
