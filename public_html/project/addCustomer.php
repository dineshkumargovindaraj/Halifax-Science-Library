<html>
<head>
<title>
addCustomer.php
</title>
</head>

<body background="book.png">
<h2><b><u><font color='#c42170'>Form to add a new Customer...</font></u></b></h2>



<form method="POST">

First Name
<input type="text" name="firstName"><p>
Last Name
<input type="text" name="lastName"><p>
Phone Number
<input type="text" name="phoneNumber"><p>
Mailing Address<p>
<textarea name="address" cols="40" rows="5"></textarea><br>
<input type="checkbox" name="yes" value="yes">If customer exists with same name, Are you okay to add customer ?<br><p><p><p>

<input type="submit"  name="addFunc" value="Add new customer"><p>

</form>




<?php

if(isset($_POST['addFunc']))
{
 addCustomer();
}


function addCustomer() {

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

$result_fname=$_POST['firstName'];
$result_lname=$_POST['lastName'];
$result_phoneNumber=$_POST['phoneNumber'];
$result_address =$_POST['address'];
$check = $_POST['yesNo'];

$result_check = mysqli_query($link,  "select * from CUSTOMER where fname='$_POST[firstName]' and lname='$_POST[lastName]' ");

if ($result_check->num_rows> 0)
{
	if ($_POST['yes']=='yes')
	{
	echo '<span style="color:#008000;text-align:center;"> With Consent : Customer has been added....</span>';
	$result_customer = mysqli_query($link, "INSERT INTO CUSTOMER (lname,fname,address,phoneNumber) VALUES('$result_lname','$result_fname','$result_address','$result_phoneNumber')");
	}
	else
	{
	echo '<span style="color:#FF0000;text-align:center;">Without Consent : Please provide different firstname/lastname.... </span>';
	}
}

else
{
$result_customer = mysqli_query($link, "INSERT INTO CUSTOMER (lname,fname,address,phoneNumber) VALUES('$result_lname','$result_fname','$result_address','$result_phoneNumber')");
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
