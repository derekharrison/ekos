<?php
ini_set('session.save_path', '/session');
session_start();

$memoryid = $_GET['memid'];
$_SESSION['memid'] = $memoryid;

header("Location: memory.php");
die;
?>
