<?php
require_once('config.php');

$mysqli = new mysqli($databaseHost, $databaseUsername, $databasePassword, $databaseName);
if ($mysqli->connect_error) {
	error_log($mysqli->connect_error);
	exit;
}
