<?php
//This page is included on ever page where the user logs in.

//https://rollbar.com/
//Requre rollbar for handling php.

/*require_once $_SERVER['DOCUMENT_ROOT'] . '/Docs/Rollbar/rollbar.php';

$config = array(
    // required
    'access_token' => '8a58c81121ab434c8440c61666dc97d0',
    // optional - environment name. any string will do.
    'environment' => 'Travel',
    // optional - dir your code is in. used for linking stack traces.
    'root' => '/Users/td227/devel.distance/',
    // optional - max error number to report. defaults to -1 (report all errors)
    'max_errno' => E_USER_NOTICE  // ignore E_STRICT and above
);

Rollbar::init($config);
*/
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$directory = "/Travel";

include $_SERVER['DOCUMENT_ROOT'] . $directory . "/Utility/source/sessionVars.php";
include $_SERVER['DOCUMENT_ROOT'] . $directory . "/Utility/source/functions.php";

include $_SERVER['DOCUMENT_ROOT'] . "/common/shared.php";

//Include everything in the source/classes directory.
foreach (glob($_SERVER['DOCUMENT_ROOT'] . $directory . "/Utility/source/classes/*.php") as $filename)
{
	include $filename;
}

//Include the other files which need the classes
include $_SERVER['DOCUMENT_ROOT'] . $directory . "/Utility/source/access.php";
include $_SERVER['DOCUMENT_ROOT'] . $directory . "/Utility/source/emails.php";

?>
