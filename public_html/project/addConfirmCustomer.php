<html>
<head>
<title>
addConfirmCustomer.php
</title>
</head>

<body background="book.png">
<h2><b><u><font color='#c42170'>Form to confirm a Customer...</font></u></b></h2>

<form method="POST">
A customer with same firstname and lastname already exists!!! Please type below 'yes'/'no' to add or ignore the customer.<p>

<input type="text" name="yesNo"><p>
<input type="submit" name="addFunc" value="Confirm new customer"><p>

</form>


<?php

$table = $_POST["firstName"];

session_start();

$_SESSION['fname'] = $table;
 echo $_SESSION['fname'];

print("<h2><b><u><font color='#c42170'>$table TABLE CONTENT</font></u></b></h2>");

if(isset($_POST['addFunc']))
{
 confirmCustomer();
}


function confirmCustomer() {

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

//SESSION_START();

//$result_fname=$_SESSION['fname'];
//echo "$result_fname";
//$result_lname=$_SESSION['lname'];
//$result_phoneNumber=$_SESSION['pno'];
//$result_address =$_POST['addr'];
//$check = $_POST['yesNo'];

if ($check=="no")
{
echo '<span style="color:#FF0000;text-align:center;">Sure!!! Customer has been ignored...</span>';
}

else
{
//$table = $_POST["firstName"];

print("<h2><b><u><font color='#c42170'>$table TABLE CONTENT</font></u></b></h2>");

SESSION_START();

echo $_SESSION['fname'];
//$result_customer = mysqli_query($link, "INSERT INTO CUSTOMER (lname,fname,address,phoneNumber) VALUES($result_lname,$result_fname,$result_address,$result_phoneNumber)");
echo '<span style="color:#008000;text-align:center;">Success!!! Added a new customer...</span>';
}

//Close the connection
mysqli_close($link);

}

?>
<br><br><br>
<p><p><p><p><a href="main.php">HOME</a>

</body>
</html>

