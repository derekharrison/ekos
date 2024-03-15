<?php

ini_set('session.save_path', 'session');
session_start();

$files_length = $_POST['files_length'];


for($i = 0; $i < $files_length; $i++) {

    $file = $_FILES['file'.$i];
    
    print_r($file); echo ", flag <br>";
    
    $filename = basename($file['name']);

    $targetPath = 'uploads/'.$filename;
    move_uploaded_file($file['tmp_name'], $targetPath);
}
