<?php
ini_set('session.save_path', 'session');
session_start();

include("classes/connect.php");
include("classes/login.php");
include("classes/user.php");
include("classes/post.php");
include("classes/memory.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['ekos_userid']);

$memid = $_GET['memid'];

$memory = new Memory();
$arr = $memory->delete_memory_row($memid);

header("Location: memories.php");
die;

?>