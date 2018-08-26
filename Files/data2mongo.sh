#!/bin/bash
#
db="$1"
user="$2"
##read -s pass
pass="$3"

#

###COMMAND TO CREATE THE EXISTING TABLE ####

mysql -u "$user" --password="$pass" "$db" -e"source existing_tables.sql"
echo 
echo  "--> CREATED THE EXISTING TABLES IN MYSQL DATABASE"
echo
mysql -u "$user" --password="$pass" "$db" -e "select * from AUTHOR;" > AUTHORS.tsv



###COMMAND TO CREATE THE NEW TABLES ###

mysql -u "$user" --password="$pass" "$db" -e"source new_tables.sql"
echo 
echo "--> CREATED THE NEW TABLES IN MYSQL DATABASE"
echo 

###COMMAND TO DROP THE COLLECTIONS IF EXISTS

echo  "db.articles.drop()" | mongo "$db" -u"$user" -p"$pass" 
echo  "db.authors.drop()"  | mongo "$db" -u"$user" -p"$pass"

###COMMAND TO EXECUTE THE PYTHON SCRIPT TO GET THE CLEAN DATA

#!/path/to/interpreter
#!/usr/bin/env python

chmod +x CSVModelFinal.py
python CSVModelFinal.py


#### COMMAND TO CREATE THE COLLECTIONS 
mongo "$db" -u"$user" -p"$pass" --eval 'db.createCollection("articles")'

mongo "$db" -u"$user" -p"$pass" --eval 'db.createCollection("authors")'


####COMMAND TO INSERT THE DATA INTO COLLECTION FROM JSON FILE

mongoimport -d "$db" -u"$user" -p"$pass" -c "articles"  --jsonArray --file articles_mongo.json

mongoimport -d "$db" -u"$user" -p"$pass" -c "authors" --type tsv --headerline --file AUTHORS.tsv
