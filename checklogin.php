<?php
	ini_set('session.bug_compat_warn', 0);
	ini_set('session.bug_compat_42', 0);
	session_start();
	ob_start();

	include_once 'config.php';

	// Connect to server and select databse.
	mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");

	// Define $myusername and $mypassword 
	$myusername = $_POST['myusername']; 
	$mypassword = $_POST['mypassword']; 

	// To protect MySQL injection
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
	$myusername = mysql_real_escape_string($myusername);
	$mypassword = mysql_real_escape_string($mypassword);
	$sql="SELECT * FROM members WHERE username='$myusername' and password='$mypassword' and status = 'active'";
	$result=mysql_query($sql);

	// Mysql_num_row is counting table row
	$count=mysql_num_rows($result);

	// If result matched $myusername and $mypassword, table row must be 1 row
	if($count==1)
	{
		$sql="SELECT member_id FROM members WHERE username='$myusername' and password='$mypassword'";
        $result=mysql_query($sql);
        $id = mysql_result($result,0);
        $_SESSION['m_id'] = $id;
		echo "true";
		$_SESSION['myusername'] = $myusername;
		$_SESSION['mypassword'] = $mypassword; 	

	}

	else 
	{
		//return the error message
		echo "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Wrong Username or Password</div>";
	}

	ob_end_flush();
?>
