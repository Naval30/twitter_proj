<?php

function valid_username($username, $minlength = 3, $maxlength = 30)
{
   /* include_once 'config.php';
    mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
    mysql_select_db("$db_name")or die("cannot select DB");
*/
 
    $username = trim($username);
 
    if (empty($username))
    {
        echo"<h3>Username empty</h3>";
        return false; // it was empty
    }
    if (strlen($username) > $maxlength)
    {
        echo"<h3>Username too long</h3>";
        return false; // too long
    }
    if (strlen($username) < $minlength)
    {
        echo"<h3>Username too short</h3>";
        return false; //too short
    }
    $sql=sprintf("SELECT * FROM members WHERE username='%s'", $username);
    $result1=mysql_query($sql);
    $count=mysql_num_rows($result1);
    if($count==1)
    {
        echo"<h3>Username already exists</h3>";
        return false;
         
    } 
    $result = ereg("^[A-Za-z0-9_\-]+$", $username); //only A-Z, a-z and 0-9 are allowed
 
    if ($result)
    {
        return true; // ok no invalid chars
    } else
    {
        echo"<h3>Invalid characters</h3>";
        return false; //invalid chars found
    }
 
    return false;
 
}
 
function valid_password($pass, $minlength = 6, $maxlength = 15)
{
    $pass = trim($pass);
 
    if (empty($pass))
    {
        echo"<h3>Password empty</h3>";
        return false;
        
    }
 
    if (strlen($pass) < $minlength)
    {
        echo"<h3>Password too short</h3>";
        return false;     
    }
 
    if (strlen($pass) > $maxlength)
    {
        echo"<h3>Password too long</h3>";
        return false;
    }
 
    $result = ereg("^[A-Za-z0-9_\-]+$", $pass);
 
    if ($result)
    {
        return true;
    } else
    {
        echo"<h3>Invalid characters</h3>";
        return false;
    }

    return false;
 
}
 
?>

