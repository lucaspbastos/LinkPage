<?php
function connectIG($url) {
	$ch =  curl_init();
	curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_SSL_VERIFYHOST => 2
	));
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

function getUserImages($access_token){
	$url = "https://api.instagram.com/v1/users/self/media/recent/?access_token=".$access_token;
	$imageinfo = connectIG($url);
	$imageresults = json_decode($imageinfo, true);
	foreach($imageresults['data'] as $items) {
       	$image_url = $items['images']['standard_resolution']['url'];
       	$image_id = $items['id'];
       	$image_link = $items['link'];
       	if (ifUploaded($image_id, 0) == $image_id) {
       		ifUploaded($image_id, 1);
       	} else {
       		if (getMediaEmbed($image_link)){
	       	echo ("<div align='center' class='container' id='".$image_id."' name='".$image_link."'>
	       			<div class='well'>");
	       	echo (getMediaEmbed($image_link));
	        echo ("<div class='center' id='warning".$image_link."' style='display:none'><br>
					<div class='alert alert-danger' id='warningbox".$image_link."'>
	 				 </div>
					</div>

	        		<div class='input-group'>
	      			<span class='input-group-addon'><i class='glyphicon glyphicon-link'></i></span>
	      			<input id='userlink".$image_link."' type='text' class='form-control' placeholder='Link'>
	      			</div><br>
	        		<button id='button".$image_link."' type='button' class='btn btn-primary' onclick='embedEnable(\"".$image_id."\", \"".$image_link."\");'>Submit</button>  <button style='display:none;' id='deletebutton".$image_link."' type='button' class='btn btn-danger' onclick='embedDelete(\"".$image_id."\", \"".$image_link."\");'>Delete</button>
	        		</div>
	        		</div>
	        		<br>");
	    	} else {
	    		echo ("<br><div class='container center'>
  						<div class='alert alert-danger' id='nopost'>
    					<strong>No data!</strong> We can't retrieve any posts, this may be due to a <strong>private account</strong> or you haven't uploaded anything to Instagram!
    					</div></div>");
	    		break;
	    	}
        }
    } 		
}
function getMediaEmbed($image_link){
				$url = "https://api.instagram.com/oembed/?url=".$image_link;
				$mediainfo = connectIG($url);
				$mediaresults = json_decode($mediainfo, true);
				$htmlembed = $mediaresults['html'];
				return $htmlembed;
}
function checkPrivate($userID, $access_token){
				$url = "https://api.instagram.com/v1/users/".$userID."/relationship?access_token=".$access_token;
				$accountinfo = connectIG($url);
				$accountresults = json_decode($accountinfo, true);
				$private = $accountresults['data']['target_user_is_private'];
				return $private;
}
function ifUploaded($image_id, $x) {
	$connection = mysql_connect([**DB INFO**]);
	mysql_select_db([**DB**]);
	$query = "SELECT * FROM [**DB**] WHERE postID = '$image_id' ORDER BY ID"; 
	$result = mysql_query($query);
	
	while($row = mysql_fetch_array($result)){
		if ($x == 0){
			return ($image_id);
		} else if ($x == 1) {
			echo ("<div align='center' class='container' id='".$row['postID']."' name='".$row['postLink']."'>
       			<div class='well'>");
       	echo (getMediaEmbed($row['postLink']));
        echo ("<div class='center' id='warning".$row['postLink']."' style='display:none'><br>
				<div class='alert alert-danger' id='warningbox".$row['postLink']."'>
 				 </div>
				</div>

        		<div class='input-group'>
      			<span class='input-group-addon'><i class='glyphicon glyphicon-link'></i></span>
      			<input id='userlink".$row['postLink']."' type='text' class='form-control' placeholder='".$row['userLink']."' disabled>
      			</div><br>
        		<button id='button".$row['postLink']."' type='button' class='btn btn-success' onclick='embedSwitch(\"".$row['postID']."\", \"".$row['postLink']."\");'>Edit</button>  <button style='inline-block' id='deletebutton".$row['postLink']."' type='button' class='btn btn-danger' onclick='embedDelete(\"".$row['postID']."\", \"".$row['postLink']."\");'>Delete</button>
        		</div>
        		</div>
        		<br>");
		}
	}
}



?>
