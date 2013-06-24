drop database newsvis;
create database newsvis;

grant usage on newsvis.* to newsvisuser identified by 'password123%%%';

grant all privileges on newsvis.* to newsvisuser;

use newsvis;

create table sources(
sourceid int not null auto_increment primary key,
name varchar(255) not null,
url text not null
);

create index sources_name on sources(name);


create table articles(
articleid int not null auto_increment primary key,
sourceid int not null,
foreign key (sourceid) references sources(sourceid),
title varchar(255) not null,
articledate date not null
);

create index articles_articledate on articles(articleid);
create index articles_sourceid on articles(sourceid);


create table words(
wordid int not null auto_increment primary key,
word varchar(255) not null,
frequency int not null,
articleid int not null,
foreign key (articleid) references articles(articleid),
sourceid int not null,
foreign key (sourceid) references sources(sourceid),
worddate date not null
);

create index words_articleid on words(articleid);
create index words_sourceid on words(sourceid);
create index words_worddate on words(worddate);


