<html>
<head>
<title>
addArticle.php
</title>
</head>

<body background="book.png">

<h2><b><u><font color='#c42170'>Form to add a new Article...</font></u></b></h2>

<form method="POST">
Title of Article
<input type="text" name="ArticleTitle"><p>
Magazine ID
<input type="text" name="MagazineID"><p>
Journal Name
<input type="text" name="JournalName"><p>
Volume Number
<input type="text" name="VolumeNumber"><p>
Pages
<input type="text" name="Pages"><p>
Publication Year
<input type="text" name="PublicationYear"><p>
List of Authors<p>
<textarea name="Authors" cols="30" rows=3"></textarea><br>
&nbsp;(Seperate multiple author names by "," ex:(Dan Brown,Mark Twain))<br><p><p>

<input type="submit" name="addFunc" value="AddArticle" method="post"><p>

</form>

<?php
if(isset($_POST['addFunc']))
{
 addArticle();
 }


function addArticle() {

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

$result_name = $_POST['JournalName'];
$result_volno = $_POST['VolumeNumber'];
$result_title = $_POST['ArticleTitle'];
$result_pages = $_POST['Pages'];
$result_year = $_POST['PublicationYear'];
$string_authors=$_POST['Authors'];
$result_magazineID=$_POST['MagazineID'];

$result_authors = explode(",",$string_authors);


$result_magID = mysqli_query($link, "SELECT * from MAGAZINE where _id=$result_magazineID");


if (mysqli_num_rows($result_magID)>0)
{
//$result_magazine = mysqli_query($link, "INSERT INTO MAGAZINE (name) VALUES('$result_name') WHERE _id=$result_magazineID");
$result_magazinevolume = mysqli_query($link, "INSERT INTO MAGAZINEVOLUME (_id,volumeNumber,year) VALUES('$result_magazineID','$result_volno','$result_year')");
$result_article = mysqli_query($link, "INSERT INTO ARTICLE (volumeNumber,title,pages) VALUES('$result_volno','$result_title','$result_pages')");

foreach($result_authors as $authors)
{
 // echo $authors;
//  $fnamelname = explode(" " , $authors);
   $fnamelname = preg_split("/[\s,]+/",$authors);
   $email =  "$fnamelname[0]".'.'."$fnamelname[1]"."@smu.ca";
  $result_fnamelname = mysqli_query($link, "INSERT INTO AUTHOR (lname,fname,email) VALUES('$fnamelname[1]','$fnamelname[0]','$email')");
}

//$result_magazine = mysqli_query($link, "INSERT INTO MAGAZINE (name) VALUES('$result_name')");
echo '<span style="color:#008000;text-align:center;">Success!!! Magazine ID Found and added a new Article and Author...</span>';

}

else
{


echo '<span style="color:#FF0000;text-align:center;">Sorry!!! Unable to find the Magazine ID(Check Magazine ID)...</span>';
die;
}

//Close the connection
mysqli_close($link);


}


?>
<br><br><br><br>
<p><p><p><p><p>

<a href="main.php">HOME</a>

</body>
</html>
