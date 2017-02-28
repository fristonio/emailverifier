<?php 
if (isset($_GET["hash"])) {
	function sanitize($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
		}
	$hash=sanitize($_GET["hash"]);
	echo $hash;
	require_once './config.php';
	$conn=new mysqli($host,$user,$pass,"emailverify");
	if ($conn->connect_error) {
			die ("<div class='phperror'>Sorry the connection to database failed  :  ".$conn->connect_error."</div>");
		}
		else{
			$query="SELECT state from USERS where hash='$hash';";
			$result=$conn->query($query);
			if(!$result){
					echo "<div class='phperror'>Sorry .... no user found ".$conn->error."</div>";
				}
				else{
					while ($row=$result->fetch_assoc()) {
					if($row["state"]==0){
						$update="UPDATE USERS SET state=1 where hash='$hash';";
						$conn->query($update);
						echo "Your email has been verified ..... login ";
					}
					else{
						echo "<br><br>the email has already been verified";
					}
				}
				}
		}
}
?>
