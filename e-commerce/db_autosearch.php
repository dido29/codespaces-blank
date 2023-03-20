<?php
	$servername = "localhost";
    $username = "dido29";
    $password = "";
    $database = "my_dido29";
    $conn=mysqli_connect($servername,$username,$password,$database);
    	if(!$conn){
        	die('Could not Connect MySql Server:' .mysql_error());
        }  
?>
