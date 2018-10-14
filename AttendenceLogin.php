<?php
session_start();
include('conn.php');

$email=$_SESSION['email'];
if ($email=="") {
	header("Location:Login.html");
}
//$email="sndchauhan898@gmail.com";
?>
<?php 
echo '
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Attendence Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>
  $(document).ready(function(){
	    $("#in").click(function(){
	        $("#in").val("Entry Done.");
	        $("#in").fadeIn(5000);
	        $("#in").hide();
	    });
	});
	$(document).ready(function(){
	    $("#out").click(function(){
	        $("#out").val("Closing");
	    });
	});
	</script>
</head>
<body style="margin: 20px">
	<form method="POST" action="AttendenceLogin.php">
	<div style="background-color:#e6e6ff;padding:5px;">
	<input type="submit" class="btn btn-default" name="in_time" id="in" value="In Time">
	<input type="submit" class="btn btn-default" name="out_time" id="out" value="Out Time">
	<input type="submit" class="btn btn-default" name="logout" id="logout" value="Logout The System" style="float:right;">
	</div>
	</form>';
	date_default_timezone_set('Asia/Kolkata');
$dt = date('Y-m-d');
	$tm=date('H:i:s');
//echo $dt." ".$tm;
if (isset($_POST['in_time'])) {
	//echo $dt." ".$tm;
	
		$insertAttendence="insert into attendence_table(user_email,date,in_time) values('$email','$dt','$tm')";
		$result = mysqli_query($conn, $insertAttendence);
	
}

if (isset($_POST['out_time'])) {

		$outAttendence="update attendence_table set out_time='$tm' where date='$dt' and user_email='$email' and out_time IS NULL";
		$resultOutAttendence = mysqli_query($conn, $outAttendence);

		$selectId="select max(id) from attendence_table";
		$resultId = mysqli_query($conn, $selectId);

		$row = mysqli_fetch_assoc($resultId);
		$id=$row['max(id)'];

		//echo "$id";
		$durationQuery="select TIMEDIFF(in_time, out_time) from attendence_table where id='$id'";

		$resultDuration = mysqli_query($conn, $durationQuery);

		$row = mysqli_fetch_assoc($resultDuration);
		$dur=$row['TIMEDIFF(in_time, out_time)'];

		//echo "$dur";
		$updateDur="update attendence_table set duration='$dur' where user_email='$email' and id='$id'";
		$resultDur = mysqli_query($conn, $updateDur);

	/*mysqli_close($conn);
	session_destroy();
	header("Location:Login.html");*/
}

if (isset($_POST['logout'])) {
	mysqli_close($conn);
	session_destroy();
	header("Location:Login.html");
}
		

echo '<h2>My Attendence</h2>          
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Date</th>
        <th>In Time</th>
        <th>Out Time</th>
        <th>Duration</th>
      </tr>
    </thead>
    <tbody>';

    if (!isset($_POST['logout'])) {
	    $readAttendeceQuery="select date,in_time,out_time,duration from attendence_table where user_email='$email'";
		$result = mysqli_query($conn, $readAttendeceQuery);

		if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		    while($row = mysqli_fetch_assoc($result)) {
		    		echo "<tr>
					        <td>".$row['date']."</td>
					        <td>".$row['in_time']."</td>
					        <td>".$row['out_time']."</td>
					        <td>".$row['duration']."</td>
					      </tr>";
		    }
		}
	}	
echo '      
    </tbody>
  </table>
</div>

</body>
</html>';
?>


