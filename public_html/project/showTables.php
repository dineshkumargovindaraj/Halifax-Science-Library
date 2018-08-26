<head>
<title>
showTables.php
</title>
</head>
<body background="book.png">
<h2><b><u><font color='#c42170'>List of tables available in the database</font></u></b></h2>

<?php

function prtable($table) {
	print "<table border=1>\n";
	while ($a_row = mysqli_fetch_row($table)) {
		print "<tr>";
		foreach ($a_row as $field) print "<td>$field</td>";
		print "</tr>";
	}
	print "</table>";
}

//Import Everything that is in dbguest.php
require("/home/course/cda540/u05/public_html/project/dbguest.php");

//It will import all variables such as $host , $user, $pass and $db

//mysqli_connect() is to connect the database 
$link = mysqli_connect($host, $user, $pass, $db);

//Check the connection. Give error message if any error 
if (!$link) die("Couldn't connect to MySQL");


//mysqli_select_db() is used to select the database 
mysqli_select_db($link, $db)
	or die("Couldn't open $db: ".mysqli_error($link));

//mysqli_query will execute the query and stores into $result

$result = mysqli_query($link, "show tables from $db");



//It will print the result in the form of table 
prtable($result);

//Close the connection
mysqli_close($link);


?>

<form action="print_table.php" method="POST">
<p>
<b>Enter the table name from above list to view records:</b>

<input type="text" name="table">&emsp;(table names are case-sensitive)
<p>
<input type="submit" value="View Table">
</form>


<br><br><br><br>
<p><p><p><p><p><p>
<a href="main.php"> HOME</a>
</body>
</html>

