<?php
$db_conx=mysqli_connect("localhost","avinash","12345","social");
// Evaluate the connection
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();
	} 
?>