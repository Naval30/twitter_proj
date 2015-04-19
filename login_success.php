<?php
session_start();
if(!isset($_SESSION['myusername']))
{  
  header("location:main_login.php");
}
include_once 'config.php';
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB"); 

$sql = sprintf("SELECT username FROM members WHERE member_id = '%d';",$_SESSION['m_id']); 
$name=mysql_query($sql);
$name=mysql_result($name, 0);
$sql1 = sprintf("SELECT COUNT(*) FROM polls WHERE member = %d;",$_SESSION['m_id']); 
$results1=mysql_query($sql1);
$results1=mysql_result($results1, 0);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Successful Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="css/main.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"> </script> 
 </head>
  <body>
    <div class="container">
      <div class="form-signin">
        <div class="alert alert-success">You have been successfully logged in,<strong> <?php echo $name;?></strong>.</div>  
        <div class="alert alert-success">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <strong><?php echo $results1.' votes'?></strong>.</div>  
        <a href="logout.php" class="btn btn-default btn-lg btn-block">Logout</a>
      </div>
    </div>

<?php    
echo '
<table class = "table table-bordered" action = "">
<form action = "" method="POST">
   &nbsp;
<thead>        
   &nbsp;
    <tr>
        <th>Name</th>
        <th>Photo</th>
        <th>Biography</th>
        <th>Options</th>
    </tr>
</thead>
<tbody>';
/*  
$sql = sprintf("SELECT * FROM spidered_twitter_profiles WHERE twitterid NOT IN(SELECT distinct(twitterid) from polls where member = %d);", $_SESSION['m_id']);
$results = mysql_query($sql);
$sql = sprintf("SELECT * FROM spidered_twitter_profiles WHERE twitterid IN(SELECT twitterid from polls GROUP BY twitterid HAVING COUNT(*) < 2) ORDER BY RAND() LIMIT 10;", $_SESSION['m_id']); 
$results = mysql_query($sql); 
*/

{
    //$sql = sprintf("SELECT * FROM spidered_twitter_profiles WHERE twitterid NOT IN(SELECT distinct(twitterid) from polls where member = %d) AND twitterid NOT IN (SELECT twitterid from polls GROUP BY twitterid HAVING COUNT(*) > 1) ORDER BY RAND() LIMIT 10;", $_SESSION['m_id']);
  //  $sql = sprintf("SELECT * FROM spidered_twitter_profiles WHERE twitterid NOT IN(SELECT distinct(twitterid) from polls where member = %d) AND twitterid NOT IN (SELECT twitterid from polls GROUP BY twitterid HAVING COUNT(*) > 1) ORDER BY RAND() LIMIT 10;", $_SESSION['m_id']);
    $sql = sprintf("SELECT * FROM spidered_twitter_profiles WHERE twitterid NOT IN(SELECT distinct(twitterid) from polls where member = ".$_SESSION['m_id'].") AND twitterid NOT IN (SELECT twitterid from polls GROUP BY twitterid HAVING COUNT(*) > 1) AND last_shown < ".(time() - 100)." LIMIT 10;");
    $results = mysql_query($sql);

}

while($row = mysql_fetch_array($results))
{
  $photo = "'".$row['photo']."'";
  $id = "'".$row['twitterid']."'";
  $nickname = $row['nickname']."'";
  echo "<tr>";
  echo "<td name = 'name' width = '15%' />";
  echo $row['name']; 
  /*
  echo "&nbsp; <p> </p> &nbsp <p> </p> &nbsp; <p> </p> &nbsp &nbsp <p> </p> &nbsp <p>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  echo '<input class="btn btn-primary" name="submit1" type="submit" value="Submit"></button>';
  echo "</p>";
  */
  echo "</td>";
  echo "<td name = 'photo' width = '30%'/>";
  echo "<a href='https://twitter.com/$nickname><img src= $photo class='img-rounded'/></a>";
  echo "</td>";
  echo "<td name = 'biography' width = '25%'/>";
  //mysql_query("UPDATE spidered_twitter_profiles SET last_shown = UNIX_TIMESTAMP(now()) WHERE twitterid = ".$row['twitterid'].";");
  echo $row['bio'];
 // echo "SELECT * FROM spidered_twitter_profiles WHERE twitterid NOT IN(SELECT distinct(twitterid) from polls where member = ".$_SESSION['m_id'].") AND twitterid NOT IN (SELECT twitterid from polls GROUP BY twitterid HAVING COUNT(*) > 1) AND last_shown < ".(time() - 100)." LIMIT 10;";
 // echo $row['twitterid'];

   // $sql = sprintf("UPDATE twitter_ids SET spidered = 1 WHERE twitterid = '%d';", $id);
  echo "</td>";
  mysql_query("UPDATE spidered_twitter_profiles SET last_shown = UNIX_TIMESTAMP(now()) WHERE twitterid = %d;", $row['twitterid']);
  echo "<td width = '30%'>";
  echo "<label>";
  echo '<input class = "radio" type = "radio" name = "radio['.$row['twitterid'].']" value = "1" />';
  echo "Teen";
  echo "</label>";
  echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
  echo "<label>";   
  echo '<input class = "radio" type = "radio" name = "radio['.$row['twitterid'].']" value = "2" />';
  echo "Not teen";
  echo "</label>";
  echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
  echo "<label>";
  echo '<input class = "radio" type = "radio" name = "radio['.$row['twitterid'].']" value = "3" />';
  echo "Not a person";
  echo "&nbsp;&nbsp;&nbsp;";
  echo "</label>";    
  echo "&nbsp;";
  echo "<label>";
  echo '<input class = "radio" type = "radio" name = "radio['.$row['twitterid'].']" value = "4" />';
  echo "Not sure";
  echo "</label>";    
  echo "&nbsp; <p> </p> &nbsp &nbsp <p>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  echo '<input class="btn btn-primary" name="submit1" type="submit" value="Submit"></button>';
  echo "</p>";
  echo "</td>";
  echo "</tr>"; 
}  

echo "</table>";
echo "<div class='container'>";
echo "<div class='form-signin'>";
echo "<input class='btn btn-default btn-lg btn-block' type='submit' name='submit' value='Submit' >";
echo "</div>";
echo "</div>";
echo "</form>";  

if(isset($_POST['submit']) || isset($_POST['submit1']))
{
  foreach ($_POST['radio'] as $key => $value)
  {
    $sql = sprintf("INSERT INTO polls(twitterid, poll, member, timest) VALUES (%d, %d, %d, UNIX_TIMESTAMP(now()))", $key, $value, $_SESSION['m_id']);
    $result= mysql_query($sql);
      
  }
  echo "<meta http-equiv=refresh content=\"0; URL=login_success.php\">";
} 
 
?>

  </body>
</html>
