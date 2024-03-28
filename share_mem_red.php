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

$postid = $_GET['postid'];

$post = new Post();
$arr = $post->delete_posts($postid);

header("Location: memory.php");
die;

?>