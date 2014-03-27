<?php 

include_once("config.php");

if(!$currency) {
	die('Could not connect: ' . mysql_error());
}

?>