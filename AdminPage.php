<!doctype html>
<html lang="en">
<body>
<form action="AdminPage.php" method="POST">
Date: <input type="text" name="date" placeholder="1299-12-31" style="float: left">
<input type="submit" name="search" value="search" style="float: left;">
</form>
 
</body>
</html>

<?php  
include('conn.php');
session_start();
$email=$_SESSION['email'];
$password=$_SESSION['password'];
if ($email=="") {header("Location:Login.html");}

$dt=date('Y-m-d');
if (isset($_POST['search'])) {
	if ($_POST['date']!="") {
		$dt=$_POST['date'];
		//echo "$dt";
	}
}	
		
			

	if ($conn) {
		$sql="select password from user_register where email='$email'";
		
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		    $row = mysqli_fetch_assoc($result);
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
					  
					</head>
					<body style="margin: 20px">
					<div class="container">';

		    if ($password==$row['password']) {
					echo '<h2>My Attendence</h2>          
					  <table class="table table-bordered">
					    <thead>
					      <tr>
					      <th>User Emails</th>
					        <th>Date</th>
					        <th>In Time</th>
					        <th>Out Time</th>
					        <th>Duration</th>
					      </tr>
					    </thead>
					    <tbody>';

					$readAttendeceQuery="select user_email,date,in_time,out_time,duration from attendence_table where date='$dt'";
					$result = mysqli_query($conn, $readAttendeceQuery);

					if (mysqli_num_rows($result) > 0) {
					    // output data of each row
					    while($row = mysqli_fetch_assoc($result)) {
					    		echo "<tr>
					    				<td>".$row['user_email']."</td>
								        <td>".$row['date']."</td>
								        <td>".$row['in_time']."</td>
								        <td>".$row['out_time']."</td>
								        <td>".$row['duration']."</td>
								      </tr>";
					    }
					}

					echo '      
					    </tbody>
					  </table>
					</div>

					</body>
					</html>';
					mysqli_close($conn);
		    }else{
		    	//echo '<script>alert("Login Credentials are in correct.")</script>';
		    	header("Location:adminLoginPage.html");
		    }
		}else{
			//echo '<script>alert("Email is not registered.")</script>';
			header("Location:adminLoginPage.html");
		}
	}

?>
