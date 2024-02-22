<?php
ini_set('session.save_path', 'path_to_session');
session_start();

include("classes/connect.php");
include("classes/login.php");
include("classes/user.php");
include("classes/post.php");
include("classes/memory.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['ekos_userid']);

$memid = $_SESSION['memid'];
$memory = new Memory();
$arr = $memory->delete_memory_row($memid);
header("Location: memories.php");
die;

?>