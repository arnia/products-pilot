create table if not exists users (
            id int(10) primary key auto_increment,
            email varchar(32) not null unique,
            password varchar(32) not null,
            hash varchar(32) not null,
            verified boolean default false not null
            );

insert into users values (1,'ciocoiu.ionut@yahoo.com','523163bde2ac1c8ba844b9122a4a73c8','superuser',1);