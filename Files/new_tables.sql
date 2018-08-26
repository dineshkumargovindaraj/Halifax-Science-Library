DROP TABLE if exists MAGAZINEVOLUME;
#
create table if not exists MAGAZINEVOLUME (
  _id INT not null auto_increment,
  volumeNumber int,
  year varchar(4),
  primary key(_id,volumeNumber),
  foreign key(_id) references MAGAZINE(_id)
) engine = innodb;


DROP TABLE if exists ARTICLE;
#
create table if not exists ARTICLE (
  _id INT not null auto_increment,
  title varchar(50) not null,
  pages varchar(50) null,
  volumeNumber int,
  primary key(_id),
  constraint foreign key(volumeNumber) references MAGAZINEVOLUME(volumeNumber)
) engine = innodb;


DROP TABLE if exists ARTICLE_AUTHOR;
#
create table if not exists ARTICLE_AUTHOR (
  author_id INT not null,
  article_id INT not null ,
  primary key(author_id, article_id),
  unique key (article_id,author_id),
  foreign key (author_id) references AUTHOR(_id),
  foreign key (article_id) references ARTICLE(_id)
) engine = innodb;


DROP TABLE if exists CUSTOMER;
#
create table if not exists CUSTOMER(
  _id INT not null auto_increment,
  lname varchar(30),
  fname varchar(30),
  address varchar(50),
  phoneNumber varchar(50),
  primary key(_id)
) engine = innodb;

DROP TABLE if exists TRANSACTION;
#
create table if not exists TRANSACTION(
  transactionNumber INT auto_increment,
  discouncode int,
  transactiondate date,
  totalpurchaseprice float,
  customerId int,
  primary key(transactionNumber ),
  foreign key(customerId) references CUSTOMER(_id)
) engine = innodb;


DROP TABLE if exists TRANSACTIONDETAILS;
#
create table if not exists TRANSACTIONDETAILS (
  transactionNo INT not null,
  itemId INT not null ,
  primary key (transactionNo , itemId),
  unique key (transactionNo , itemId),
  foreign key (transactionNo) references TRANSACTION(_id),
  foreign key (itemId) references ITEM(_id)
) engine = innodb;


DROP TABLE if exists YEARLYRENT;
#
create table if not exists YEARLYRENT(
year INT not null ,
heat double,
primary key (year)
)engine = innodb;

DROP TABLE if exists EMPLOYEE;
#
create table if not exists EMPLOYEE(
sinNo bigint not null,
primary key (sinNo) 
)engine = innodb;

DROP TABLE if exists MONTHLYHOURS;
#
create table if not exists MONTHLYHOURS(
_id INT not null ,
month int not null,
year varchar(4) not null,
totalHours double,
primary key (_id, month, year),
foreign key (month) references WORKHOURS(month),
foreign key (year) references WORKHOURS(year)
)engine = innodb;


DROP TABLE if exists WORKHOURS;
#
create table if not exists WORKHOURS(
day varchar(50) not null ,
month int not null,
year varchar(4) not null,
sinNo int not null,
hours double,
primary key (day, month, year, sinNo),
foreign key (sinNo) references EMPLOYEE(sinNo)
)engine = innodb;


DROP TABLE if exists EXPENSES;
#
create table if not exists EXPENSES (
  month INT not null,
  year INT not null,
  monthlyHoursId INT not null,
  electricity double,
  heat double,
  water double,
  primary key (month, year, monthlyHoursId),
  foreign key(year) references YEARLYRENT(year),
  foreign key (monthlyHoursId) references MONTHLYHOURS(_id)
) engine = innodb;


CREATE INDEX index_Article on ARTICLE(_id);
CREATE INDEX index_Author on AUTHOR(_id,fname,lname);