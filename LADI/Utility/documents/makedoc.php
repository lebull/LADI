<?php 
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
	
	/*never ever ever ever let the user input something here*/
	
	$source = "../source/classes";
	$target = "./docs/api";
	echo(exec("php phpDocumentor.phar -d $source -t $target"));
	echo("<a href='$target'>Docs?</a>");
?>


