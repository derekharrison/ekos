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

// posting starts here
if($_SERVER['REQUEST_METHOD'] == "POST") {

    $post = new Post();
    $id = $_SESSION['ekos_userid'];

    $filename = $_FILES['file']['name'];
    $post = $_POST['post'];

    $query = "update memories set image='$filename', text='$post' where memoryid = '$memid'";

    $DB = new Database();
    $result = $DB->save($query);
    header("Location: memory.php");
    die;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title> Edit Memory | Ekos </title>
    </head>

    <style type="text/css">

        #blue_bar{
            height: 50px;
            background-color: #405d9b;
            color: #d9dfeb;
        }

        #search_box{
            width: 400px;
            height: 20px;
            border-radius: 5px;
            border:none;
            padding: 4px;
            font-size: 14px;
            background-image: url();
        }

        #profile_pic{
            width: 150px;
            margin-top: -200px;
            border-radius: 50%;
            border: solid 2px white;
        }

        #menu_buttons{
            width: 100px;
            display: inline-block;
            margin: 2px;
        }

        #friends_img{
            width: 75px;
            float: left;
            margin: 8px;
        }

        #friends_bar{
            background-color: white;
            min-height: 400px;
            margin-top: 20px;
            color: #aaa;
            padding: 8px;
        }

        #friends{
            clear: both;
            font-size: 12px;
            font-weight: bold;
            color: #405d9b;
        }

        textarea{
            width: 100%;
            border: none;
            font-family: tahoma;
            font-size: 14px;
            height: 60px;
        }

        #post_button{
            float: right;
            background-color: #405d9b;
            border: none;
            color: white;
            padding: 4px;
            font-size: 14px;
            border-radius: 2px;
            width: 50px;
        }

        #post_bar{
            margin-top: 20px;
            background-color: white;
            padding: 10px;
        }

        #post{
            padding: 4px;
            font-size: 13px;
            display: flex;
            margin-bottom: 20px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto;
            background-color: #d0d8e4;
            padding: 10px;
            grid-gap: 20px;
        }

    </style>

    <body style="font-family: tahoma; background-color: #d0d8e4">
        <br>
        <!-- top bar -->
        <div id="blue_bar">
            <div style="width: 800px; margin: auto; font-size: 30px;">
                <a href="memories.php" style="float: left; margin: 10px; color: white; text-decoration: none">
                    <span>Ekos</span>
                </a>
                <a href="profile.php">
                    <img src="
                        <?php
                            $user = new User();
                            $row_user = $user->get_user($id);  
                            echo $row_user['profile_image'];            
                        ?>"; style="width: 50px; float: right">
                 </a>  
                <a href="logout.php">
                    <span style="font-size:11px; float: right; margin: 10px;color: white"> Logout </span>
                </a>             
                <a href="memories.php">
                    <span style="font-size:11px; float: right; margin: 10px;color: white"> Memories </span>
                </a>                
            </div>
        </div>
        
        <!-- cover area -->
        <div style="width: 800px; margin:auto; min-height: 400px;"> 
            <div> 
                <!-- posts area -->
                <div style="min-height: 400px;padding-top: 20px;">  
                    <!-- // Main memory post -->
                    <div style="text-align:center;">
                        <?php 
                            $memory = new Memory();
                            $val = $memory->get_memory($memid);
                            $res = $memory->get_memory_image($memid);

                            $ext = pathinfo($res[0]['image'], PATHINFO_EXTENSION);
                            if($ext == "jpg" || $ext== "jpeg") {
                                echo "<img src=" . $res[0]['image'] . " style='width:75%;'>";
                            }
                            else if($ext == "mp4") {  
                                echo "<video controls src=" . $res[0]['image'] . " style='width:100%;'>" . "Play video" . "</video>";          
                            }
                            echo "<br><br><br>";
                            echo $val[0]['text'];
                            echo "<br><br><br>";
                        ?>                        
                    </div>    
                    <br><br>
                    <div style="border:solid thin #aaa; padding: 10px; background-color: white;">
                        <form method="post" enctype="multipart/form-data" >
                            <textarea name="post" placeholder="What would you like to share?"></textarea>
                            <input type="file" name="file" enctype="multipart/form-data">
                            <input id="post_button" type="submit" value="Update">
                            <br>
                        </form>
                    </div>                     
                </div>                             
            </div>                
        </div>
    </body>
</html>