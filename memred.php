<?php
ini_set('session.save_path', 'path_to_session');
session_start();

$memoryid = $_GET['memid'];
$_SESSION['memid'] = $memoryid;

header("Location: memory.php");
die;
?>
