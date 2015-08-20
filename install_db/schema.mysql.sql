
create table if not exists users (
            id int(10) primary key auto_increment,
            email varchar(32) not null unique,
            password varchar(32) not null,
            hash varchar(32) not null,
            verified boolean default false not null
            );

create table if not exists admins (
    id int(10) primary key auto_increment,
    user_id int(10) unique not null,
    foreign key (user_id) references users(id)
    on delete cascade
    on update cascade
);

create table if not exists categories(
            id int(10) primary key auto_increment,
             name varchar(256)
            );

create table if not exists products(
                id int(10) primary key auto_increment,
                name varchar(256) not null,
                category_id int(1),
                price float(10,4) not null,
                file varchar(256),
                image varchar(256),
                description text,
                foreign key (category_id) REFERENCES categories(id)
            );

create table if not exists mailsettings (
            id int(10) primary key auto_increment,
            smtp_config mediumtext
            );

create table if not exists shoppingcarts (
          id int(10) primary key auto_increment,
          user_id int(10),
          product_id int(10),
          foreign key (user_id) references users(id) on delete cascade on update cascade,
          foreign key (product_id) references products(id) on delete cascade on update cascade,
          quantity int(10) DEFAULT 0,
          constraint unique_entry unique (user_id, product_id)
          );

insert into users values (1, 'admin@products-pilot.loc', '21232f297a57a5a743894a0e4a801fc3', 'superuser', 1);
insert into admins(user_id) values (1);

insert into categories(name) values ('Hardware'),('Software'),('Book'),('Movie');