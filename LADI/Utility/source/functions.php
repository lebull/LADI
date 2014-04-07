<?php
//This script will verify that the user has the privilages of the inputted rank ($rank) and redirrects them to the login page if that is not the case.

function checkRank($rank){
	global $SV_USERNAME;
	global $SV_ERROR;
	global $_SESSION;
	
	
	if(!isset($_SESSION[$SV_USERNAME])) 
	{
		$_SESSION[$SV_ERROR] = "Invalid Permissions or Session Timeout";
		header("Location:http://devel.distance.msstate.edu/Coskrey");
		$_SESSION[$SV_ERROR] = "Invalid Permissions";
		die("No Permissions Set");
	}
}


//http://www.lateralcode.com/creating-a-random-string-with-php/
function rand_string( $length ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

	$str = "";

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}

	return $str;
}


//http://stackoverflow.com/questions/777597/sorting-an-associative-array-in-php
function orderArray($tableList, $tableKeys){

		$resultArray = array();
		foreach($tableKeys as $key){
			//need to validate this
			//if(!isset($tableList[$key])){die("Invalid Table Key: " . $key);}
			$resultArray[$key] = $tableList[$key];
		}
		$resultArray;
		
	

	return $resultArray;
}

function connect_rw()
{
	$connection=mysqli_connect("localhost","user_rw","dgvW1FJB","webdb") or die("Error connecting to database");
	return $connection;
}
?>