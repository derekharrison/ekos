<?php

ini_set('session.save_path', 'session');
session_start();

 
    // posting starts here
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        
        echo "in post<br>";
        $files_length = $_POST['files_length'];

        for($i = 0; $i < $files_length; $i++) {
        
            $file = $_FILES['file'.$i];
            
            print_r($file); echo ", flag <br>";
            
            $filename = basename($file['name']);
        
            $targetPath = 'uploads/'.$filename;
            move_uploaded_file($file['tmp_name'], $targetPath);
            
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Multiple Files Upload in JS and PHP with Progress</title>
        <style>
            .container{
                width: 400px;
                margin: auto;
                padding: 30px;
                transform: scale(1.4);
                margin-top: 50px;
            }
            .percent{
                float: right;
                margin-top: 2px;
            }
            .progress-bar{
                width: 100%;
                height: 6px;
                margin-top: 30px;
                background-color: rgb(231,231,231);
            }
            .progress-bar span{
                height: 100%;
                width: 0%;
                display: block;
                background-color: red;
                transition-duration: .2s;
            }
        </style>
    
    </head>

    <body>
        <div>
            <form method="post" enctype="multipart/form-data">
                <input name="uploadfiles[]" type="file" multiple="multiple" enctype="multipart/form-data"/> 
                <button>Upload</button>
                <div class="percent">0%</div>
                <div class="progress-bar">
                    <span></span>
                </div> 
                <input type="submit" value="Post" name="post_butt">
                
            </form>
            <script src="script.js"></script>
        </div>
    </body>
</html>