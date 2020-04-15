<!DOCTYPE html>
<?php 
include 'connect.php';
include 'functions.php';
$userID = $_GET['id']; 
if (!$userID) {
  $error = 3;
  include "linkpage.php";
  return;
} else {
?>
<head>
  <title>LinkPage - <?php echo ($userID); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png?v=47MOxMmn7N">
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png?v=47MOxMmn7N">
    <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png?v=47MOxMmn7N">
    <link rel="manifest" href="favicons/manifest.json?v=47MOxMmn7N">
    <link rel="mask-icon" href="favicons/safari-pinned-tab.svg?v=47MOxMmn7N" color="#00a300">
    <link rel="shortcut icon" href="favicons/favicon.ico?v=47MOxMmn7N">
    <meta name="apple-mobile-web-app-title" content="LinkPage">
    <meta name="application-name" content="LinkPage">
    <meta name="msapplication-config" content="favicons/browserconfig.xml?v=47MOxMmn7N">
    <meta name="theme-color" content="#ffffff">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="linkpage.css">
</head>
<?php
echo ("<div class='jumbotron center nobottom''>
    <a href='p**URL**]/linkpage.php'><h1>LinkPage</h1></a>
    <p>Create an Instagram feed with personalized links for each post.</p> 
</div><br>
");
$connection = mysql_connect([**DB INFO**]);
mysql_select_db([**DB**]);
$query = "SELECT * FROM [**TABLE**] WHERE userID = $userID ORDER BY postID DESC"; 
$result = mysql_query($query);

while($row = mysql_fetch_array($result)){
  $content = 1;
  echo ("<div align='center' class='container'>
      <div class='well'>");
  echo (getMediaEmbed($row['postLink']));
  echo ("<h3 class='breakword'><a href=".$row['userLink'].">".$row['userLink']."</a></h3>
          </div>
          </div>
          ");
}
if ($content !== 1) {
	echo ("<div align='center' class='center'><small>It's quiet here...</small></div><br>");
}
if ($content == 1) {
echo ("<div class='container center'>
         <div class='alert alert-warning'>
            <strong>Click URLs at own risk!</strong> LinkPage is not responsible for any links posted or clicked beyond our page.
          </div>
        </div>");
}
?>
<body>
<div class="container center">
   <p><a href="[**URL**]/privacypolicy.html">Privacy Policy</a> | <a href="[**URL**]/guide.html">Guide</a></p>
</div>
<div class="footer">
  <p><a href="https://lucasbastos.com"><small>By Lucas B. &#926;</small><a></p>
</div>
</body>
<script async="" defer="defer" src="http//platform.instagram.com/en_US/embeds.js"></script>
</html>
<?php } ?>
