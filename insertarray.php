<?php
session_start();
include 'connect.php';

$userID= $_POST['userID'];
$postLink=$_POST['postLink'];
$postID=$_POST['postID'];
$userLink=$_POST['userLink'];
if(!$userID)
{
	die("Error");
} 
try
{
	$stmt = $db->prepare("INSERT INTO [**DB**] (userID, postLink, postID, userLink) VALUES (:userID, :postLink, :postID, :userLink)");
	$stmt->bindParam(':userID', $userID);
	$stmt->bindParam(':postLink', $postLink);
	$stmt->bindParam(':postID', $postID);
	$stmt->bindParam(':userLink', $userLink);
	$stmt->execute();	
	return true;	
}
catch(PDOException $e)
{
	echo "Error:" . $e->getMessage();
}
?>
