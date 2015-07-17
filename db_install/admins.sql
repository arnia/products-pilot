create table if not exists admins (
    id int(10) primary key auto_increment,
    user_id int(10) unique not null,
    foreign key (user_id) references users(id)
    on delete cascade
	  on update cascade
)

insert into admins(user_id) values (1);