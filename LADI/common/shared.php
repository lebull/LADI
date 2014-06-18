<?php


include $_SERVER['DOCUMENT_ROOT'] . "/common/medoo/medoo.min.php";

include $_SERVER['DOCUMENT_ROOT'] . "/common/php/databaseObject.php";
include $_SERVER['DOCUMENT_ROOT'] . "/common/php/databaseObjectManager.php";
include $_SERVER['DOCUMENT_ROOT'] . "/common/php/searchParameter.php";



if(strpos($_SERVER['DOCUMENT_ROOT'], "test.distance.msstate.edu") !== false)
{
	$TESTING = true;
}else{
	$TESTING = false;
}



if(!$TESTING)
{
	$DATABASE = new medoo();
}else{

	$DATABASE = new medoo(array(
		// required
		'database_type' => 'mysql',
		'database_name' => 'webdb',
		'server' => 'localhost',
		'username' => 'user_rw',
		'password' => 'Q57ASxj1'
		
	));
}
?>
