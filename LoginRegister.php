<?php 
include('conn.php');
session_start();

if (isset($_POST['register'])) {
	$f_name="";
	$l_name="";
	$email="";
	$number="";
	$password="";

	if ($_POST['first_name']!="") {
		$f_name=$_POST['first_name'];
		$_SESSION['f_name']=$f_name;
	}
	if ($_POST['last_name']!="") {
		$l_name=$_POST['last_name'];
	}
	if ($_POST['email']!="") {
		$email=$_POST['email'];
		$_SESSION['email'];
	}
	if ($_POST['number']!="") {
		$number=$_POST['number'];
	}
	if ($_POST['password']!="") {
		$password=$_POST['password'];
	}
	if ($conn) {
		$checkEmail="select email from user_register where email='$email'";
		$resultEmail=mysqli_query($conn,$checkEmail);
	if($row = mysqli_fetch_assoc($resultEmail))
	{
		if ($row['email']==$email) {
			//echo '<script>alert("User Allready Registered With this email")</script>';
			header("Location:Allreadyregistered.html");
		}
		
	}
		else{
			$query="insert into user_register(f_name,l_name,email,number,password) values('$f_name','$l_name','$email','$number','$password')";
			if (mysqli_query($conn, $query)) {
				//echo "You are Registered.";
				header("Location:r_successfull.html");
			}else{
				echo "User Does not register";
			}
		}
	}
}

if (isset($_POST['login'])) {
	$email="";
	$password="";

	if ($_POST['email']!="") {
		$email=$_POST['email'];
		$_SESSION['email']=$email;
	}
	if ($_POST['password']!="") {
		$password=$_POST['password'];
		$_SESSION['password']=$password;
	}

	if ($conn) {
		$sql="select password,user_role from user_register where email='$email'";
		
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		    $row = mysqli_fetch_assoc($result);
		    if ($password==$row['password']) {
		    	if($row['user_role']=="admin"){
		    		header("Location:AdminPage.php");
		    	}else{
					header("Location:AttendenceLogin.php");
				}
		    }else{
		    	//echo '<script>alert("Login Credentials are in correct.")</script>';
		    	header("Location:LoginCredential.html");
		    }
		}else{
			//echo '<script>alert("Email is not registered.")</script>';
			header("Location:Login.html");
		}
	}

}

 ?>