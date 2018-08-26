<html>
<head>
<title>
print_table.php
</title>
</head>
<body background="book.png">

<?php

//It will get value of table which is passed in the textbox 
$table = $_POST["table"];

print("<h2><b><u><font color='#c42170'>$table TABLE CONTENT</font></u></b></h2>");

//Rest is same!!

function prtable($table) {
	print "<table border=1>\n";
	while ($a_row = mysqli_fetch_row($table)) {
		print "<tr>";
		foreach ($a_row as $field) print "<td>$field</td>";
		print "</tr>";
	}
	print "</table>";
}

require("/home/course/cda540/u05/public_html/project/dbguest.php");

$link = mysqli_connect($host, $user, $pass);
if (!$link) die("Couldn't connect to MySQL");


mysqli_select_db($link, $db)
	or die("Couldn't open $db: ".mysqli_error($link));


$result = mysqli_query($link, "select * from $table");

if (!$result) print("<font color='#FF0000'>Sorry !!! The specified table doesn't present in database</font>");

else {
    $num_rows = mysqli_num_rows($result);
    print "There are $num_rows rows in the table<p>";
    prtable($result);
}

mysqli_close($link);

?>
<br><br><br><br>
<p><p><p><p><p>
<a href="showTables.php"> BACK TO THE TABLE LIST </a><br<br><br><br>
<a href="main.php"> HOME</a>

</body>
</html>


