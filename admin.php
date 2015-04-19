<?php
session_start();
if(!isset($_SESSION['myusername']))
{  
  header("location:main_login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Admin Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="css/main.css" rel="stylesheet" media="screen">
  </head>
  <body>
    <div class="container">
      <div class="form-signin">
        <div class="alert alert-success">You have been <strong>successfully logged in</strong>.</div>
         <a href="users.php" class="btn btn-default btn-lg btn-block">View/Add/Delete Users</a>
         <a href="logout.php" class="btn btn-default btn-lg btn-block">Logout</a>
      </div>
    </div>    
  </body>
</html>
