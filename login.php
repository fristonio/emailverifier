<?php 
if (isset($_POST["submit"])) {
	require_once './config.php';
	function sanitize($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
		}
	$conn=new mysqli($host,$user,$pass,"emailverify");
		if ($conn->connect_error) {
			die ("<div class='phperror'>Sorry the connection to database failed  :  ".$conn->connect_error."</div>");
		}
		else{
			$email=$_POST["email"];
			$pass=sanitize($_POST["pass"]);
			if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$sql="Select * from users where email=$email and password=$pass and state=1";
				$result=$conn->query($sql);
				if(!$result){
					echo "<div class='phperror'>Data cannot be entered into the database .... An error occured ".$conn->error."</div>";
				}
				else{
					echo "<div class='phpsuccess'>Link has been saved .... Aish kar :P</div>";
				}
			} else {
			  echo("$email is not a valid email address");
			}
			
		}
		$conn->close();
}
 ?>
<html>
	<head>
		<link rel="stylesheet" href="style.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="formdiv">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
				<label for="">E-Mail :</label><input type="text" placeholder="email" name="email"><br>
				<label for="">Password :</label><input type="password" placeholder="password" name="pass"><br>
				<input type="submit" value="login" name="submit">
			</form>
		</div>
		<script src="script.js"></script>
	</body>
</html>