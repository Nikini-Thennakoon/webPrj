<?php 
include 'config.php';

session_start();
if (isset($_SESSION['user_data'])) {
	header("location:http://localhost/project/admin/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="login.css">

	<title></title>
</head>
<body>
	<form action="login.php" method="post">

        <center><h1>ADMIN LOGIN</h1><br>
    <div class="input-control">
                  <input type="Email" placeholder="Email" name="email" required><br>
                </div>
                <div class="input-control">
                  <input type="password" placeholder="Password" name="password" required><br>
                </div>
                <button type="submit" name="login">Log In</button><br><br>
                <?php 
                if (isset($_SESSION['error'])) {
                	$error=$_SESSION['error'];
                	echo $error;
                	unset($_SESSION['error']);
                } 
                ?>
                <br><br>
<span>Forgot</span>
<a class="txt2" href="#">Password?</a><br><br><br><br>
<a class="ctn2" href="index.php">Back</a>
            </form>

<?php
if (isset($_POST['login'])) {
	$email=mysqli_real_escape_string($config,$_POST['email']);
	$password=mysqli_real_escape_string($config,sha1($_POST['password']));

	$sql = "SELECT * FROM admin WHERE email='{$email}' AND password='{$password}'";

	$query =mysqli_query($config,$sql);
	$data =mysqli_num_rows($query);

	if ($data) {
		$result=mysqli_fetch_assoc($query);
		$user_data=array($result ['user_id'],$result ['username'],$result ['admin_role']);
		$_SESSION['user_data'] = $user_data;
		header("location:admin/index.php");
	}else{

		$_SESSION['error'] = "Invalid Email/Password";
		header("location:login.php");
	}

}
?>
</body>
</html>
