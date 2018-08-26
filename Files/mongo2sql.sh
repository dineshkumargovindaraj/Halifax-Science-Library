#!/bin/bash

#
db="$1"
user="$2"
pass="$3"
##read -s pass


 ###COMMAND TO INSERT INTO MAGAZINE, ARTICLE, AUTHOR AND MAGAZINEVOLUME TABLE 

##echo "SET FOREIGN_KEY_CHECKS=0;" | mysql "$db" -u "$user" -p"$pass"
##echo "set sql_mode='STRICT_ALL_TABLES';"| mysql "$db" -u "$user" -p"$pass"

echo "load data local infile 'Magazine.tsv' into table MAGAZINE IGNORE 1 ROWS;" | mysql "$db" -u "$user" -p"$pass"

echo "load data local infile 'Author.tsv' into table AUTHOR  IGNORE 1 ROWS SET _id=NULL;" | mysql "$db" -u "$user" -p"$pass"

echo "load data local infile 'MagazineVolume.tsv' into table MAGAZINEVOLUME IGNORE 1 ROWS;" | mysql "$db" -u "$user" -p"$pass"



echo "load data local infile 'Article.tsv' into table ARTICLE  IGNORE 1 ROWS;" | mysql "$db" -u "$user" -p"$pass"

echo "load data local infile 'ArticleAuthor.tsv' into table ARTICLE_AUTHOR  IGNORE 1 ROWS;" | mysql "$db" -u "$user" -p"$pass"

