<?php
ini_set('session.save_path', 'path_to_session');
session_start();

include("classes/connect.php");
include("classes/login.php");
include("classes/user.php");
include("classes/comment.php");
include("classes/memory.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['ekos_userid']);
$memid = $_SESSION['memid'];
$id = $_SESSION['ekos_userid'];
$commentid = $_GET['commentid'];
$postid = $_GET['postid'];
$comment = new Comment();
$result = $comment->delete_comment($commentid);

header("Location: comment.php?postid=$postid");
die;

?>