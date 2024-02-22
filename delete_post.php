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
$id = $_SESSION['ekos_userid'];
$postid = $_GET['myvariable'];

$post = new Post();
$res = $post->delete_posts($postid);

header("Location: memory.php");
die;

?>