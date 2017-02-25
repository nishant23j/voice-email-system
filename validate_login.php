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

    $id =$_POST['lemail'];
    $pass=$_POST['lpass'];
    $query="SELECT * from user_login where Email ='$id' and Pass='$pass' ";
    if ($result=mysqli_query($conn,$query))
  {
   if(mysqli_num_rows($result) > 0)
    {
      echo "<script type='text/javascript'>alert('You have successfully logged in')</script>";
      header('Location: homepage1.html');
      
     
      
    }
  else
           
           header('Location: loginpage.html');
           echo "<script type='text/javascript'>alert('Sorry Please enter correct information to login')</script>";
  }
else
    echo "Query Failed.";

$conn->close();
}
?>

<script src='js/jquery.min.js'></script>
<script src="js/index.js"></script>
</body>
</html>
