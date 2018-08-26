1. Open CSVModelFinal.py
2. Update the path in the lines 14,17,18,19,20,21,128 with appropriate path(current path in the linux server) before running data2mongo.sh
3. Note: Articles.json contians NON-ASCII characters. The python script checks all the non-ascii characters during parsing and the approx time to complete the data2mongo.sh is 12-15 mins.


Input Files:
Given:
1. existing_tables.sql
2. articles.json

Created & Shared:
3. new_tables.sql
4.data2mongo.sh
5.mongo2sql.sh
6.CSVModelFinal.py


Order of Execution:
1. data2mongo.sh #bash data2mongo.sh <dbname> <userid> <pwd>
2. mongo2sql.sh  #bash mongo2sql.sh <dbname> <userid> <pwd>

Note: During the execution of the above bash script, 5 tsv files will be generated which will be consumed in the second bash script to update corresponding tables in the database. 