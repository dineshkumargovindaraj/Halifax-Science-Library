<html>
<head>
<title>
addTransaction.php
</title>
</head>

<body background="book.png">
<h2><b><u><font color='#c42170'>Form to add a new Transaction...</font></u></b></h2>

<form method="POST">
&emsp;&emsp;&emsp;Customer ID&emsp;
<input type="text" name="customerID"><p>
&emsp;Purchased Items ID &emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp; Purchased Items Price <p>
<textarea name="items" cols="20" rows="5"></textarea>&emsp;&emsp;&emsp;&emsp;
<textarea name="itemsPrice" cols="20" rows="5"></textarea><br>&emsp;&emsp;&emsp;
(One itemID/Price per line in the above boxes.)
<p><p>

<input type="submit" value="Add new transaction" name="addFunc" method="post" ><p><p>

</form>

<?php



if(isset($_POST['addFunc']))
{
 addTransaction();
}


function addTransaction() {


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

$result_cusID=(int)$_POST['customerID'];

$string_itemID=$_POST['items'];

$string_itemsPrice = $_POST['itemsPrice'];

$result_itemID = explode("\n",$string_itemID);

$result_itemPrice = explode("\n",$string_itemsPrice);

$itemIDs = implode ("," , $result_itemID);

$result_customer=mysqli_query($link,"SELECT *  FROM CUSTOMER where _id=$result_cusID");

$result_itemIDs = mysqli_query($link,"SELECT *  FROM ITEM where _id IN ('$itemIDs')");

$totalpurchaseprice = 0;

foreach($result_itemPrice as $itemprice)
{
  $totalpurchaseprice = $totalpurchaseprice+$itemprice;
}


if ((mysqli_num_rows($result_customer)>0)&& (mysqli_num_rows($result_itemIDs)>0))
{
    
    $result_trans=mysqli_query($link, "INSERT INTO TRANSACTION (discouncode,transactiondate,totalpurchaseprice,customerId) VALUES(70,now(),'$totalpurchaseprice','$result_cusID')");
    
    $result_no=mysqli_query($link,"SELECT transactionNumber FROM TRANSACTION ORDER BY customerId DESC LIMIT 1");
    $obj = mysqli_fetch_object($result_no);
    $transno= $obj-> transactionNumber;
    
    foreach ($result_itemID as $itemID)
    {
       $result_transdetails=mysqli_query($link, "INSERT INTO TRANSACTIONDETAILS (transactionNo,itemId) VALUES('$transno','$itemID')");   
    }

echo '<span style="color:#008000;text-align:center;">Success!!! Customer ID Found and added a new transaction...</span>';


}

else
{
echo '<span style="color:#FF0000;text-align:center;">Sorry!!! Unable to add a new transaction (Check Customers and Items)...</span>';
}

//$string_itemID=$_POST['items'];

//$result_itemID = explode("\n",$string_itemID);

//$j=1;

//foreach ($result_itemID as $item_val)
//{
//echo "$item_val <br>";
//$item_intval=int("$item_val");

//Working
//$result_trans=mysqli_query($link, "INSERT INTO TRANSACTION (discouncode,transactiondate,totalpurchaseprice,customerId) VALUES(70,'2019jun21',13.14,1)");
//$result_no=mysqli_query($link,"SELECT transactionNumber FROM TRANSACTION ORDER BY customerId DESC LIMIT 1");

//$value = mysql_fetch_object($result_no);
//$transno = $value->transactionNumber;
//echo "$transno";
//$result_transdetails=mysqli_query($link, "INSERT INTO TRANSACTIONDETAILS (transactionNo,itemId) VALUES(5,1)");
//$j=$j+1;
//}


//mysqli_query will execute the query and stores into $result

//mysqli_query($link, "INSERT INTO TRANSACTIONDETAILS (transactionNo,itemId) VALUES('$result')");
//Close the connection
mysqli_close($link);

}

?>
<br><br><br>
<p><p><p><p><p><p><p><a href="main.php">HOME</a>

</body>
</html>
