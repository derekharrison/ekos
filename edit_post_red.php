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

$batch_nr = $_GET['batch_nr'];
$postid = $_GET['postid'];

$post = new Post();
$res = $post->delete_batch($batch_nr);

$id = $_SESSION['ekos_userid'];

$query = "delete from posts_buffer where userid='$id'";

$DB = new Database();
$result = $DB->save($query);   

$query = "delete from postfiles_buffer where userid='$id'";

$result = $DB->save($query); 

header("Location: comment.php?postid=$postid");
die;

?>