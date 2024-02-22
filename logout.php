<?php
    ini_set('session.save_path', 'path_to_session');
    session_start();

    if(isset($_SESSION['ekos_userid'])) {
        unset($_SESSION['ekos_userid']);
    }
    

    header("Location: index.php");
    die;
