create database socialnetwork;
use socialnetwork;

create table users (
    id int auto_increment primary key,
    firstname varchar(100) not null,
    lastname varchar(100) not null,
    username varchar(50) not null,
    email varchar(100) not null,
    date_of_birth date not null,    
    sex varchar(100) not null,
    profile_image varchar(255),
    password varchar(255) not null,
    created_at timestamp default current_timestamp
);

create table password_resets (
    token varchar(64) not null primary key,
    email varchar(255) not null,
    expires int not null
);

create table publications (
    id int auto_increment primary key,
    title varchar(200) not null,
    content text,
    image varchar(255),
    publication_date timestamp default current_timestamp,
    user_id int,
    foreign key(user_id) references users(id)
);

create table comments (
    id int auto_increment primary key,
    content text,
    comment_date timestamp default current_timestamp,
    publication_id int,
    user_id int,
    foreign key(publication_id) references publications(id),
    foreign key(user_id) references users(id)
);

create table reactionspublications (
    id int auto_increment primary key, 
    reaction varchar(50),
    reaction_date timestamp default current_timestamp,
    publication_id int not null,
    user_id int,
    foreign key(publication_id) references publications(id),
    foreign key(user_id) references users(id)
);

create table reactionscomments (
    id int auto_increment primary key,
    reaction varchar(50),
    reaction_date timestamp default current_timestamp,
    publication_id int not null,
    comment_id int not null,
    user_id int,
    foreign key(publication_id) references publications(id),
    foreign key(comment_id) references comments(id),
    foreign key(user_id) references users(id)
);
