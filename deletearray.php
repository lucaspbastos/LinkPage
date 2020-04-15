<?php
session_start();
include 'connect.php';

$postID=$_POST['postID'];
if(!$postID)
{
	die("Error");
} 
try
{
	$stmt = $db->prepare("DELETE FROM [**DB**] WHERE postID = :postID");
	$stmt->bindParam(':postID', $postID);
	$stmt->execute();	
	return true;	
}
catch(PDOException $e)
{
	echo "Error:" . $e->getMessage();
}
?>
