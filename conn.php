<?php
$username="root";
$pass="";
$host="localhost";
$db="ExamProjectPostMess";

$conn=mysqli_connect($host,$username,$pass,$db);

if ($conn) {
	//echo "Connected";
}else{
	echo "Sorry Connection failed";
}


?>