<html> 
<title>Twitter ID's</title>
<body>
<h1>Twitter ID's</h1>
<?php
ini_set("memory_limit","128M");
include "inc.php";
error_reporting(E_ALL);

mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");
$ch = curl_init();
curl_setopt_array($ch, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => 'https://twitter.com/intent/user?user_id=635000061'));
$res = curl_exec($ch);
$username = substr($res, stripos($res, '<span class="nickname"')+6);																				
$username = substr($username, stripos($username, '>')+1);
$username = substr($username, 0, stripos($username, '</span>'));
echo $username."\n";

curl_setopt_array($ch, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => 'https://twitter.com/'.$username));
$res = curl_exec($ch);
echo "<h5>";
echo "ID: ".$id."\n";
echo "</h5>";
$output = parse_twitter($res);

	//if($output['profile_doesnt_exist']===0)
{
	$nickname = $output['nickname'];
	$first_name = $output['first_name'];
	$middle_name = $output['middle_name'];
	$last_name = $output['last_name'];
	$name = $first_name.' '.$middle_name .' '.$last_name; 
	$photos = $output['photos'];
	$location = $output['location'];
	$following = $output['twitter_following_count'];
	$follower = $output['twitter_follower_count'];
	$twitter_id = $output['twitter_id'];
	$bio = $output['bio'];
	echo "<ul>"; 
	echo "<li>";
	echo "Name: ".$first_name.' '.$middle_name.' '.$last_name;
	echo "</li>";
    echo "<li>";
	echo "Nickname: ".$nickname;
	echo "</li>";
	echo "<li>";
	echo "Photo: ";
	$photo = $photos[0];
	print_r($photos[0]);
	echo "</li>";
	echo "<li>";
	echo "Location: ".$location;
	echo "</li>";
	echo "<li>";
	echo "Biography: ".$bio;
	echo "</li>";
	echo "<li>";
	echo "Twitter ID: ".$twitter_id;
	$twitter_id = trim($twitter_id);
	echo "</li>";
	echo "</ul>";
}	
	
curl_close($ch);
?>
</body>
</html>