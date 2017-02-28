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
				$sql="Select * from USERS where email='$email' and password='$pass'";
				$result=$conn->query($sql);
				if(!$result){
					echo "<div class='phperror'>Cannot Login .... no user found ".$conn->error."</div>";
				}
				else{
					echo "<div class='phpsuccess'>User Found .... Aish kar :P</div>";
					while ($row=$result->fetch_assoc()) {
						if ($row["state"]==1) {
							echo "<br><br>LOGGED IN";
						}
						else
							if ($row["state"]==0) {
								echo "<br><br>A conformation mail has been sent to you .... verify it to log in";
							}
							else
								echo "<br><br>Sorry no info found ";
					}
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
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<label for="">E-Mail :</label><input type="text" placeholder="email" name="email"><br>
				<label for="">Password :</label><input type="password" placeholder="password" name="pass"><br>
				<input type="submit" value="login" name="submit">
			</form>
		</div>
		<script src="script.js"></script>
	</body>
</html>