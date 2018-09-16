<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php

	$username = $_SESSION['myusername'];
	$date = $_POST['date'];
	$stime = $_POST['stime'];
	$seat = $_POST['seat'];
	$movie = $_POST['movie'];
		
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

$con = mysql_connect('localhost', 'root', '');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("movie_booking", $con);
?>
<title>Book Ur Show</title>
<style type="text/css">
a:link {
	color:#ffffff;
	text-decoration: underline;
}
a:visited {
	color: #ffffff;
	text-decoration: underline;
}
html, body {height:100%; margin:0; padding:0;}

#page-background {position:fixed; top:0; left:0; width:100%; height:100%;}
#content {position:relative; z-index:1; padding:10px;}
</style>

</head>

<body>
<div id="page-background"><img src="images/main%20baclground.jpg" width="100%" height="100%" alt="Smile"></div>
<center>
<div class="container" style="width:800px" id="content">
  <div class="header"><img src="images/logo.png" width="177" height="61" longdesc="main.php" />                              	<!-- end .header --></div>
<center>
  <div class="content" style="background-image:url(); height:427px; color: #FFF;vertical-align:middle">
  <p align="right"><?php  $username = $_SESSION['myusername'];
  $sql= "select * from users_tbl where username='$username' and userlevel='9'"; 
  $result = mysql_query($sql);
  if($row = mysql_fetch_array($result))
  {
	  echo "[<a href=\"admin.php\">Admin Center</a>]";
  }
  ?> [<a href="first.php">Main Page</a>] [<a href="logout.php">Logout</a>]</p><p align="left">
<?php
echo "Welcome $username $seat $movie $date $stime";
?></p>
<p>
	<?php
		
	$sql = "select * from movie where movie_name='$movie' and date='$date' and showtiming='$stime' and status='Now Showing'";
	$result =mysql_query($sql);
	$row = mysql_fetch_array($result);
	$movieid = $row['movie_id'];
	$tid = $row['theatre_id'];
	$price = $row['price'];
	
	$sql = "Insert into booked (username,seat,movie_id,theatre_id,date,time,price) values ('$username','$seat','$movieid','$tid','$date','$stime','$price')";
	$result = mysql_query($sql);
	if($result)
	{
		echo "Ticket booked succesfully";
	}

	$sql = "Update seats set status='booked' where seat='$seat' and movie_id='$movieid' and theatre_id='$tid' and date='$date' and time='$stime'";
	$result = mysql_query($sql);
?>
</p>
</body>
</head>
</html>