<?php
	$host=[**DB INFO**];
	$user="[**DB INFO**];
	$dbname=[**DB INFO**];
	$pass=[**DB INFO**];
	try 
	{
		$db = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
	catch(PDOException $e)
    {
		echo "Connection failed";
    }
?>
