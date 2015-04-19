<?php
  session_start();
  if(!isset($_SESSION['myusername']))
  {  
    header("location:main_login.php");
  }
  include_once 'config.php';
  mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
  mysql_select_db("$db_name")or die("cannot select DB");

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <meta charset="utf-8">
    <title>View/Add/Delete Users</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="css/main.css" rel="stylesheet" media="screen">
  </head>
  <body>
      <div class="container">
        <div class="form-signin">
          <a href="logout.php" class="btn btn-default btn-lg btn-block">Logout</a>
        </div>
      </div>
   <h3> &nbsp; Add Users</h3>
<form class="form-inline" role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      &nbsp;
  <div class="form-group">
    <label class="sr-only" for="newuser">Username</label>
    <input name="newuser" type="text" autocomplete="off" class="form-control" id="newuser" placeholder="Enter username" maxlength="15">
  </div>
  <div class="form-group">
    <label class="sr-only" for="password">Password</label>
    <input name="password" type="password" autocomplete="off" class="form-control" id="password" placeholder="Enter password" maxlength="15">
  </div>
<br>
<br>
      &nbsp;
  <input class="btn btn-default" type="reset" name="reset" value="Reset">
  <input class="btn btn-default" type="submit" name="submit" value="Submit" >
</form>
<br>
<br>
<?php
include_once 'validation.functions.inc.php';

function registerNewUser($username, $password)
{
  if (!valid_username($username) /*|| !user_exists($username) */)
  {
      return false;
  }
  if (!valid_password($password))
  {
    return false;
  }

  $sql = sprintf("Insert into members(status, username,password) values ('active', '%s','%s')", $username, $password);
  $result=mysql_query($sql);
    if (!$result)
    {
        return false;
    }
    else
    {
      return true;
    }
}

if (isset($_POST['submit']))
{
  if (registerNewUser($_POST['newuser'], $_POST['password']))
  {
    echo "   <strong><h2>&nbsp; &nbsp; &nbsp;Registered!</h2></strong>";
    echo "<br>";
  }
  else 
  {
    echo "<strong><h2>&nbsp; &nbsp; &nbsp;Registration failed! Please try again.</h2></strong>";
    echo "<br>";
  }
} 
?>

<table class="table table-bordered" action="">
<form action ="" method="POST">
        &nbsp;
  <thead>
          &nbsp;
    <tr>
   <!--     <th>#</th> -->
        <th>Username</th>
        <th>Password</th>
        <th>Delete User</th>
    </tr>
</thead>
<tbody>
<?php

  $sql = sprintf("SELECT * FROM members WHERE status <> 'inactive' AND username <> 'admin'");
  $results=mysql_query($sql);
  while($row = mysql_fetch_array($results)):
?>  
<tr>

    <td name="username" id="username"  value="<?php echo $row['username']; ?>" />
      <?php echo $row['username']; ?>
    </td>
    <td name="password" id="password" value="<?php echo $row['password']; ?>" />
      <?php echo $row['password']; ?>
    </td>
    <td>     
      <input type="checkbox" name="delete[]" value="<?php echo $row["member_id"]; ?>"  >
    </input>
  </td>
</tr>
<?php
endwhile;
?>
</table>

&nbsp; &nbsp;
<input class="btn btn-danger" type="submit" name="del" value="Delete" onClick="history.go(0)" id="hide"/>


<?php
if(isset($_POST['del']))
{
  $rowCount = count($_POST["delete"]);
  for($i=0;$i<$rowCount;$i++) 
  {
    $var2 = mysql_query("UPDATE members SET status ='inactive' WHERE member_id='" . $_POST["delete"][$i] . "'");
  }

  echo "<meta http-equiv=refresh content=\"0; URL=users.php\">";
}

?>


</form>
</body>
</html>




