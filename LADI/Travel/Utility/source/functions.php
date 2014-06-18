<?php

/**
 *This file contains generic functions that don't have a place elsewhere.
 */
 
/**
 *verify that the user has the privilages of the inputted rank ($rank) and redirects them to the login page if that is not the case.
 *
 *@param $rank Integer representing the minimal access.
 */
function checkRank($rank){
	global $SV_USERNAME;
	global $SV_ERROR;
	//global $_SESSION;
	global $SV_RANK;
	global $SV_TARGETURL;
	
	
	if(!isset($_SESSION[$SV_USERNAME]) or $_SESSION[$SV_RANK] < $rank) 
	{
		$_SESSION[$SV_TARGETURL] = $_SERVER['REQUEST_URI'];
		
		$_SESSION[$SV_ERROR] = "Invalid Permissions";
		
		header( 'Location: /Travel/index.php');
		die("Invalid Permissions");
	}
}

/**
 *Generate a string of random characters.  Used for password generation.
 *@param $length The length of the string desired
 *
 *@return string A string of random characters
 */
function rand_string( $length ) {
	//http://www.lateralcode.com/creating-a-random-string-with-php/
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

	$str = "";

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}

	return $str;
}



/**
 *Reorders an associative array
 *
 *@param $tableList The array to be ordered
 *@param $tableKeys The desired order
 *
 *@return array A reordered associative array
 *
 *@todo Move this to the DatabaseObjectManager class.
 */
function orderArray($tableList, $tableKeys){
//http://stackoverflow.com/questions/777597/sorting-an-associative-array-in-php
		$resultArray = array();
		foreach($tableKeys as $key){
			//need to validate this
			//if(!isset($tableList[$key])){die("Invalid Table Key: " . $key);}
			$resultArray[$key] = $tableList[$key];
		}
		$resultArray;
	return $resultArray;
}
?>