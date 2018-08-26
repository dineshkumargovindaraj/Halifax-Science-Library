<html>
<head>
<title>
cancelTransaction.php
</title>
</head>

<body background="book.png">
<h2><b><u><font color='#c42170'>Form to cancel an existing transaction...</font></u></b></h2>

<form method="POST">
&emsp;&emsp;&emsp;Enter the transaction number &emsp;&emsp;
<input type="text" name="transactionNumber">&emsp;(Removes all the transaction information from database)<p>

&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input type="submit" value="Cancel Transaction" name="addFunc" method="post"><p><p>
</form>

<?php


if(isset($_POST['addFunc']))
{
 cancelTransaction();
}


function cancelTransaction() {

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

$result_transactionNumber=(int)$_POST['transactionNumber'];
//mysqli_query will execute the query and stores into $result

$result_transactionDate=mysqli_query($link,"SELECT transactiondate FROM TRANSACTION where transactionNumber=$result_transactionNumber");
$obj = mysqli_fetch_object($result_transactionDate);
$transdate= $obj->transactiondate;

$transactionDate= date_create($transdate);
$todayDate = date_create(date("Y-m-d")); 

$dtdiff = date_diff($transactionDate,$todayDate);
$datediff = (int)$dtdiff->format("%R%a days");


if ($datediff < 30)
{
echo '<span style="color:#008000;text-align:center;">Success!!! Cancelled the transaction...</span>';
$result_removetransactiondetails=mysqli_query($link,"DELETE FROM TRANSACTIONDETAILS where transactionNo=$result_transactionNumber");
$result_removetransaction=mysqli_query($link,"DELETE FROM TRANSACTION where transactionNumber=$result_transactionNumber");
}
else
{
echo '<span style="color:#FF0000;text-align:center;">Sorry!!! Cannot cancel the transaction older than 30 days...</span>';
}

mysqli_close($link);

}


?>
<br><br>
<p><p><p><a href="main.php">HOME</a>

</body>
</html>
