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
$id = $_SESSION['ekos_userid'];
$fileid = $_GET['fileid'];
$postid = $_GET['postid'];
$_SESSION['funpostid'] = $postid;

$res = false;
// echo "fileid: " . $fileid . "<br>";

$query = "delete from postfiles where fileid = '$fileid'";

$DB = new Database();
$result = $DB->save($query);

header("Location: edit_post.php");
// die;

?>