<?php


mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

$i=0;
$id = 635000002;

while($i !== 50000)
{
	$sql = sprintf("INSERT INTO db(twitterid) values ('%d')", $id);
  	$result=mysql_query($sql);
  	$i++;
  	$id++;
}



?>