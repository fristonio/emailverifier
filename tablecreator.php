<?php 
	require_once './config.php';
	$conn=new mysqli($host,$user,$pass);
	$query="CREATE DATABASE emailverify;";
		$result=$conn->query($query);
		if ($result==TRUE) {
			echo "DATABASE created successfully  <br> ";
		}
		else{
			echo "Database creation Unsuccessfull  <br> ".$conn->error;
		}

	$conn->select_db('emailverify');
	if ($conn->connect_error) {
			die ("<div class='phperror'>Sorry the connection to database failed  :  ".$conn->connect_error."</div>");
		}
	else{
		$query="CREATE TABLE USERS(
									id int not null auto_increment,
									email varchar(50) not null,
									password varchar(40) not null,
									uname varchar(50) not null,
									state int not null default '0',
									hash varchar(80) not null,
									CONSTRAINT UID UNIQUE(hash, password, email),
									Primary key (id));";
		$result=$conn->query($query);
		if($result==true)
			echo "Table Created <br><br>";
		else
			echo "Table not created ".$conn->error;
	}
 ?>