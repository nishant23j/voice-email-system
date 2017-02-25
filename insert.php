
<html>
<head>
  <meta charset="UTF-8">
  <title>Sign-Up/Login Form</title>
  <link href="css/font.css" rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/normalise.min.css">
  <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
<?php
if(isset($_POST['submit'])){

	$servername="localhost";
	$username="root";
	$pass="";
	$dbname="db";
	
	$conn= new mysqli($servername,$username,$pass,$dbname);
	if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);}

	   $fname=$_POST['ufname'];
	   $lname=$_POST['ulname'];
	   $email=$_POST['uemail'];
	   $pass=$_POST['upass'];
	   $cpass=$_POST['ucpass'];
	   $mob=$_POST['phonenum'];


	 if($pass !=$cpass){
	echo 'Your passwords do not match. Please type carefully.';
	return false;}

	$sql1 = "insert into user_sign_up(Fname,Lname,Email,Pass,Mobno)values('$fname','$lname','$email','$pass','$mob')";
	$sql2 = "insert into user_login(Email,Pass)values('$email','$pass')";

	 if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
	 	header('Location: loginpage.html');
	 	//echo "<script type='text/javascript'>alert('account created successfully!')</script>";
	 	//header( "refresh:10;url=loginpage.html");
	 	//echo"<h1> Thanku for registration click below to Login</h1>";
	 } 
        else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        	        echo "<script type='text/javascript'>alert('failed to signup!')</script>";
        	        return false;
        }

    //echo $_POST['ufname'];
	//echo $_POST['ulname'];
	//echo $_POST['uemail'];
	//echo $_POST['upass'];
	//echo $_POST['ucpass'];
	//echo $_POST['phonenum'];
	//echo"hello world";

$conn->close();
//header('Location: index.html');
}

?>


<script src='js/jquery.min.js'></script>
<script src="js/index.js"></script>
</body>
</html>

