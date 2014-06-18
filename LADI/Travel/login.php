<?php session_start();

//This is typically called in shared.php
include($_SERVER['DOCUMENT_ROOT'] . "/Travel/Utility/shared.php");

//Get the user's creds
$user = $_POST["loginID"];
$pass = $_POST["pword"];
$pass2 = crypt($pass, $SALT);



//Connect to the db.
if(!$TESTING)
{
	$con = mysql_connect("localhost","user_ro","V3GPa5AE") or die('Could not connect: ' . mysql_error());
}else{
	$con = mysql_connect("localhost","user_ro","sLGpusmB") or die('Could not connect: ' . mysql_error());
}

mysql_select_db("webdb",$con);

//Get the login query.
$query = "SELECT * FROM travel_user WHERE username = '$user';" ;
$results = mysql_query("$query") or die(mysql_error());

$row = mysql_fetch_assoc($results);

if($row['pass'] == $pass2)
{
	$_SESSION[$SV_USERNAME] = $user;
	$_SESSION[$SV_USERID] = $row['id'];
	$_SESSION[$SV_RANK] = $row['permissions'];
	echo $SV_USERNAME;
	
	//Redirect the user if they were tyring to get somewhere specific.
	if(isset($_SESSION[$SV_TARGETURL]))
	{
		header("Location: " . $_SESSION[$SV_TARGETURL]);
		unset($_SESSION[$SV_TARGETURL]);
		unset($_SESSION[$SV_ERROR]);
	}else{
		header("Location: /Travel/Request/viewAllRequestsForm.php");
	}
}else{
	$_SESSION[$SV_ERROR] = "Invalid Login";
	header("Location: index.php");
}	
?>
