<?php
ini_set('session.save_path', 'session');
session_start();

$memoryid = $_GET['memid'];
$_SESSION['memid'] = $memoryid;
$_SESSION['funmem'] = $memoryid;

header("Location: memory.php");
die;
?>
