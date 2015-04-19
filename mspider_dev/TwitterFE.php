#!/usr/bin/env php
<?php
ini_set("memory_limit","128M");
include "inc.php";
error_reporting(E_ALL);

mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");
echo "<html> <title>Twitter ID's</title><body><h1>Twitter ID's</h1>";
$ch = curl_init();
$y = 1000;
$var = mysql_query("SELECT Count(*) FROM twitter_ids WHERE spidered = 0;");
$var = mysql_result($var, 0);
if($var == 0)
{
	echo "Finished";
	echo "</body></html>";
	exit;
}
$result = mysql_query("SELECT Count(*) FROM spidered_twitter_profiles;");
$result = mysql_result($result, 0);


if($result == 0)
{}

else
{
	$cnt1 = mysql_query("SELECT COUNT(DISTINCT twitterid) FROM polls;");
	$cnt1 = mysql_result($cnt1, 0);
	$cnt2 = mysql_query("SELECT COUNT(*) FROM spidered_twitter_profiles;");
	$cnt2 = mysql_result($cnt2, 0);
	$result = $cnt2 - $cnt1;
	if($result < 1500)
	{
		if ($y > $result)
		{
			$y = $y - $result;
		}
		else
		{
			$y = 1500 - $result;
		}
	}
	else
	{
		echo "Not need to spider";
		echo "</body></html>";
		exit;
	}
}

$l = 0;
while($l < $y)
{
	$sql = sprintf("SELECT twitterid FROM twitter_ids WHERE spidered = 0 LIMIT 1;");
  	$id = mysql_query($sql);
  	$id = mysql_result($id, 0);
  	$id = trim($id);
	$output="";
	curl_setopt_array($ch, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => 'https://twitter.com/intent/user?user_id='.$id));
	$l++;
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
		/*
		echo "<li>";
		echo "Followers: ".$follower;
		echo "</li>";
		echo "<li>";
		echo "Following: ".$following;
		echo "</li>";
		echo "<li>";
		*/
		echo "<li>";
		echo "Twitter ID: ".$twitter_id;
		$twitter_id = trim($twitter_id);
		echo "</li>";
		echo "</ul>";

		if($photo === '' || $twitter_id === '')
		{
			$sql = sprintf("UPDATE twitter_ids SET spidered = 1 WHERE twitterid = '%d';", $id);
			$sql = mysql_query($sql);			
		}

		else if($twitter_id === $id )
		{
			//$link = 'https://twitter.com/'.$nickname;
			$sql = sprintf("INSERT INTO spidered_twitter_profiles(twitterid, nickname, name, spidered, photo, bio, location) VALUES (%d, '%s', '%s', %d, '%s', '%s', '%s');", $id, $nickname, $name, 1, $photo, $bio, $location);
			$sql = mysql_query($sql);
			$sql = sprintf("UPDATE twitter_ids SET spidered = 1 WHERE twitterid = '%d';", $id);
			$sql = mysql_query($sql);
		}		
	}	
}	
echo "</body></html>";
curl_close($ch);

?>
