create table users (
            id int(10) primary key auto_increment,
            email varchar(32) not null unique,
            password varchar(32) not null,
            hash varchar(32) not null,
            verified boolean default false not null
            );