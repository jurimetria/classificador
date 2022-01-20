<?php


	
	#$hostname="database-2.cjtvzbllncaj.us-east-1.rds.amazonaws.com";
	#$username="admin";
	#$password="Lp1406@";
	

	$hostname="ec2-54-157-224-251.compute-1.amazonaws.com:3306";
	$username="admin";
	$password="Lp1406@";

	$dbname="lp_db";

    $conexao = new mysqli($hostname,$username,$password,$dbname);

    
?>

