<?php 
	if (isset($_POST["submit"])) {
	require_once './config.php';
	include './vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
	$mail->Username = $mailemail;
	$mail->Password = $mailpass;	
	$mail->setFrom('xm0rtis09@gmail.com', 'Sys_admin');
	$mail->addAddress($_POST["email"]);
	$mail->Subject = "EMAIL VERIFY";
	$mail->isHTML(true);
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
			$name=sanitize($_POST["uname"]);
			$hash=hash("sha256",time()+rand(100,500));
			$verify="http://localhost/myserver/emailverify/verify.php?hash=".$hash;
			if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$sql="INSERT into USERS(email,password,uname,hash) VALUES('$email','$pass','$name','$hash');";
				$result=$conn->query($sql);
				if(!$result){
					echo "<div class='phperror'>Data cannot be entered into the database .... An error occured ".$conn->error."</div>";
				}
				else{
					echo "<div class='phpsuccess'>User credentials have been saved in the databases.... Aish kar :P</div>";
				}
				$msg="To verify you account for the emailverifier please click on the link below  :<br>";
				$msg.="<a href='$verify'>$verify</a>";
				$mail->msgHTML($msg);
			    if(!$mail->send()) {
				    echo "<div class='phperror'>Mail could not be sent.".$mail->ErrorInfo."</div>";
				} else {
				    echo "<div class='phpsuccess'>Mail sent Successfully </div>";
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
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
				<label for="">E-Mail :</label><input type="text" placeholder="email" name="email"><br>
				<label for="">Password :</label><input type="password" placeholder="password" name="pass"><br>
				<label for="">Username :</label><input type="text" name="uname">
				<input type="submit" value="login" name="submit">
			</form>
		</div>
		<script src="script.js"></script>
	</body>
</html>