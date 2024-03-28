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
$memid = $_SESSION['funmem'];
$postid = $_SESSION['funpost'];
$id = $_SESSION['ekos_userid'];
$fileid = $_GET['fileid'];

$res = false;

$query = "delete from postfiles_buffer where fileid = '$fileid'";

$DB = new Database();
$result = $DB->save($query);

header("Location: share_memory.php");
// die;

?>