<!DOCTYPE html>
<head>
    <title>LinkPage - Log In</title>
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
<body onload="urllocate()">
<div class="jumbotron center nobottom">
    <a href='[**URL**]/linkpage.php'><h1>LinkPage</h1></a>
    <p>Create an Instagram feed with personalized links for each post.</p> 
</div><br>
<div class="container center">
  <div class="alert alert-danger" id="error" style="display:none;">
    <strong>Denied!</strong> It seems you've denied permission to log in. Try again below.</div>
<a class="btn btn-primary" href="https://www.instagram.com/oauth/authorize/?client_id=[**CLIENT ID**]&redirect_uri=[**URL**]/userpanel.php&response_type=code">
  <i class="fa fa-instagram fa-lg" aria-hidden="true"></i> Log In</a>
</div>
<hr />
</div>
<div class="container center">
   <p><a href="[**URL**]/privacypolicy.html">Privacy Policy</a> | <a href="[**URL**]/guide.html">Guide</a></p>
</div>
<div class="footer">
  <p><a href="https://lucasbastos.com"><small>By Lucas B. &#926;</small><a></p>
</div>
<script>
function urllocate() {
  var accesserror = <?php echo ($error); ?>;
  if (accesserror == 1){
    document.getElementById("error").style = "display:block";
    document.getElementById("error").innerHTML = "<strong>Code required!</strong> It seems there's no code in the address bar. Try again below."
    return;
  } else if (accesserror == 2){
    document.getElementById("error").style = "display:block";
    document.getElementById("error").innerHTML = "<strong>No session!</strong> It seems there's no session, possibly due to incorrect code or a page refresh. Try again below."
    return;
  } else if (accesserror == 3){
    document.getElementById("error").style = "display:block";
    document.getElementById("error").innerHTML = "<strong>No user!</strong> It seems there's no user with this ID. Try again below."
    return;
  } else if (accesserror == 4){
    document.getElementById("error").style = "display:block";
    document.getElementById("error").innerHTML = "<strong>Denied!</strong> It seems you've denied LinkPage access to your Instagram account. Try again below."
    return;
  }
}
</script>
</body>
</html>
