<?php
    ini_set('session.save_path', 'session');
    session_start();

    include("classes/connect.php");
    include("classes/login.php");
    include("classes/user.php");
    include("classes/post.php");
    include("classes/memory.php");
    
    $id = $_SESSION['ekos_userid'];

    if(isset($_SESSION['ekos_userid'])) {
        unset($_SESSION['ekos_userid']);
    }
    
    $_SESSION['funpostid'] = "";
    
    $query = "delete from memories_buffer where userid='$id'";
    
    $DB = new Database();
    $result = $DB->save($query);   
    
    $query = "delete from memoryfiles_buffer where userid='$id'";
    
    $result = $DB->save($query);   
    
    $query = "delete from posts_buffer where userid='$id'";
    
    $result = $DB->save($query); 
    
    $query = "delete from postfiles_buffer where userid='$id'";
    
    $result = $DB->save($query);      
    
    header("Location: index.php");
    die;
