<?php 	
	session_start();
	include 'connect.php';
	include 'functions.php';
	$code = $_GET["code"];
		$userdenied = htmlspecialchars($_GET["error_reason"]);
		$accessdenied = htmlspecialchars($_GET["error"]);
		$descriptiondenied = htmlspecialchars($_GET["error_description"]);
		define("clientID", '[**CLIENT ID**]');
		define("clientSecret", '[**CLIENT SECRET**]');
		define("redirectURI", '[**URL**]/userpanel.php');
		if($userdenied == "user_denied" || $accessdenied == "access_denied" || $descriptiondenied == "The+user+denied+your+request.") {
			$error = 4;
			include "linkpage.php";
			return;
		} else if (!$code) {
			$error = 1;
			include "linkpage.php";
			return;
		} else {
			$url = "https://api.instagram.com/oauth/access_token";
			$access_token_settings = array(
				'client_id' => clientID,
				'client_secret' => clientSecret,
				'grant_type' => 'authorization_code',
				'redirect_uri' => redirectURI,
				'code' => $code
			);
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $access_token_settings);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($curl);
			curl_close($curl);
			$results = json_decode($result, true);
			$username = $results['user']['username'];
			$userID = $results['user']['id'];
			$access_token = $results['access_token'];
			$userpic = $results['user']['profile_picture'];
			if (!$userID) {
				$error = 2;
				include "linkpage.php";
				return;
			}
?>
<!DOCTYPE html>
<head>
	<title>LinkPage - User Panel</title>
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
  	<link rel="stylesheet" href="linkpage.css">
</head>
<?php
			$error = 0;
			echo ("<div class='jumbotron center''>
    				<a href='[**URL**]/linkpage.php'><h1>LinkPage</h1></a>
    				<p>Create an Instagram feed with personalized links for each post.</p> 
				</div>");
			echo ("<div class='container'>
					<div class='row' id='usertop'>
						<div class='col-sm-2'>
							<img src='".$userpic."'>
						</div>
						<div class='col-sm-10'>
							<h1>User Panel</h1><br>
							<p>Choose your recent posts and add your own link to them.</p>
							<p>Your public profile link: <a class='bg-info' target='_blank' href='[**URL**]/profile.php?id=".$userID."'>https://web.njit.edu/~lpb6/iglink/profile.php?id=".$userID."</a>
						</div>
					</div>
					<div class='row'>
						<div class='col-sm-4'>
							<p>Welcome <strong>".$username."</strong>.</p>
							<a href='[**URL**]/logout.php' class='btn btn-primary btn-xs'>
         					 <span class='glyphicon glyphicon-log-out'></span> Log out</a>
						</div>
					</div>
				   </div>");
			
			getUserImages($access_token);
				
?>
<body>
<div class="container center">
   <p><a href="[**URL**]/privacypolicy">Privacy Policy</a> | <a href="[**URL**]/guide">Guide</a></p>
</div>
<div class="footer">
  <p><a href="https://lucasbastos.com"><small>By Lucas B. &#926;</small><a></p>
</div>
<script type="text/javascript"> 
var httpsarray = ["http://", "https://"];
function isURL(str) {
  var pattern = new RegExp('^(https?:\\/\\/)?'+
  '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+
  '((\\d{1,3}\\.){3}\\d{1,3}))'+
  '(\\:\\d+)?'+
  '(\\/[-a-z\\d%@_.~+&:]*)*'+
  '(\\?[;&a-z\\d%@_.,~+&:=-]*)?'+
  '(\\#[-a-z\\d_]*)?$','i');
  return pattern.test(str);
}
function embedEnable(image_id, image_link) {
	var postID = image_id;
	postID = postID.replace(/['"]+/g, '');
	var userID = <?php echo ($userID); ?>;
	var postLink = image_link;
	postLinkFinal = postLink.replace(/['"]+/g, '');
	var userLink =	document.getElementById("userlink"+postLink).value;
	userLink = userLink.toLowerCase();
	if (isURL(userLink) == false) {
		document.getElementById("warning"+postLink).style = "display:block";
		document.getElementById("warningbox"+postLink).innerHTML = "<strong>Not a valid link.</strong> Make sure your link is a valid link.";
	}
	if (isURL(userLink) == true){
		 if (!userLink.includes(httpsarray[0]) && !userLink.includes(httpsarray[1])) {
	      	userLink = "http://"+userLink;
    	}
    	document.getElementById("warning"+postLink).style = "display:none";	
    	document.getElementById("warningbox"+postLink).innerHTML = "";	
		var xmlhttp;
	    if (window.XMLHttpRequest) {
	      xmlhttp=new XMLHttpRequest();
	    } else {
	      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
	    }
	    xmlhttp.onreadystatechange=function() {
	      if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		      document.getElementById("userlink"+postLink).setAttribute("disabled","");
		      document.getElementById("userlink"+postLink).placeholder = userLink;
		      document.getElementById("userlink"+postLink).value = "";
		      document.getElementById("button"+postLink).className = "btn btn-success";
		      document.getElementById("button"+postLink).innerHTML = "Edit";
		      document.getElementById("button"+postLink).setAttribute("onclick","embedSwitch('"+postID+"', '"+postLink+"');");
		      document.getElementById("deletebutton"+postLink).style = "display:inline-block;";
	      }
	    }
	    xmlhttp.open("POST","insertarray.php",true);
	    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	    xmlhttp.send("postID="+postID+"&userID="+userID+"&postLink="+postLinkFinal+"&userLink="+userLink);
	} 
}
function embedSwitch(image_id, image_link){
	var postID = image_id;
	postID = postID.replace(/['"]+/g, '');
	var userID = <?php echo ($userID); ?>;
	var postLink = image_link;
	postLinkFinal = postLink.replace(/['"]+/g, '');
	var userLink =	document.getElementById("userlink"+postLink).value;
	userLink = userLink.toLowerCase();
	document.getElementById("userlink"+postLink).removeAttribute("disabled");
	document.getElementById("button"+postLink).className = "btn btn-primary";
	document.getElementById("button"+postLink).innerHTML = "Submit";
	document.getElementById("button"+postLink).setAttribute("onclick","embedUpdate('"+postID+"', '"+postLink+"');");
	document.getElementById("deletebutton"+postLink).style = "display:none;";
}
function embedUpdate(image_id, image_link){
	var postID = image_id;
	postID = postID.replace(/['"]+/g, '');
	var postLink = image_link;
	postLinkFinal = postLink.replace(/['"]+/g, '');
	var userLink =	document.getElementById("userlink"+postLink).value;
	userLink = userLink.toLowerCase();

if (!isURL(userLink)) {
		document.getElementById("warning"+postLink).style = "display:block";
		document.getElementById("warningbox"+postLink).innerHTML = "<strong>Not a valid link.</strong> Make sure your link is a valid link.";
	}
else {
		 if (!userLink.includes(httpsarray[0]) && !userLink.includes(httpsarray[1])) {
	      	userLink = "http://"+userLink;
    	}
    	document.getElementById("warning"+postLink).style = "display:none";	
    	document.getElementById("warningbox"+postLink).innerHTML = "";	
    	console.log("userLink");
		var xmlhttp;
	    if (window.XMLHttpRequest) {
	      xmlhttp=new XMLHttpRequest();
	    } else {
	      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
	    }
	    xmlhttp.onreadystatechange=function() {
	      if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	      	  document.getElementById("userlink"+postLink).placeholder = userLink;
	      	  document.getElementById("userlink"+postLink).value = "";
		      document.getElementById("userlink"+postLink).setAttribute("disabled","");
		      document.getElementById("button"+postLink).className = "btn btn-success";
		      document.getElementById("button"+postLink).innerHTML = "Edit";
		      document.getElementById("button"+postLink).setAttribute("onclick","embedSwitch('"+postID+"', '"+postLink+"');");
		      document.getElementById("deletebutton"+postLink).style = "display:inline-block;";
	      }
	    }
	    xmlhttp.open("POST","updatearray.php",true);
	    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	    xmlhttp.send("postID="+postID+"&userLink="+userLink);
	} 
}
function embedDelete(image_id, image_link){
	var postID = image_id;
	postID = postID.replace(/['"]+/g, '');
	var postLink = image_link;
	var xmlhttp;
	    if (window.XMLHttpRequest) {
	      xmlhttp=new XMLHttpRequest();
	    } else {
	      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
	    }
	    xmlhttp.onreadystatechange=function() {
	      if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		      embedSwitch(postID, postLink);
		      document.getElementById("button"+postLink).setAttribute("onclick","embedEnable('"+postID+"', '"+postLink+"');");
		      document.getElementById("userlink"+postLink).placeholder = "Link";
	      }
	    }
	    xmlhttp.open("POST","deletearray.php",true);
	    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	    xmlhttp.send("postID="+postID);

}
</script>
<script async="" defer="defer" src="http//platform.instagram.com/en_US/embeds.js"></script>
</body>
</html>
<?php } ?>
