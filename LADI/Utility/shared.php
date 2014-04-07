<?php
//This page is included on ever page where the user logs in.

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$directory = "/Budget";

include $_SERVER['DOCUMENT_ROOT'] . $directory . "/Utility/source/sessionVars.php";
include $_SERVER['DOCUMENT_ROOT'] . $directory . "/Utility/source/functions.php";

//Include everything in the source/classes directory.
foreach (glob($_SERVER['DOCUMENT_ROOT'] . $directory . "/Utility/source/classes/*.php") as $filename)
{
	include $filename;
}
?>
