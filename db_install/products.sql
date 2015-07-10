create table products(
            id int(10) primary key auto_increment,
            name varchar(256) not null,
            type_id int(1),
            price float(10,4) not null,
            file varchar(256),
            foreign key (type_id) REFERENCES Types(id)
            );

insert into products(name,type_id,price,file) values ('Hard',1,12,'f1.doc'),('soft',2,18,'f2.doc'),('Hsad',3,12,'f6.doc'),('mov',4,1,'f1.doc')