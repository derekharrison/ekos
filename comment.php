<?php
    ini_set('session.save_path', 'session');
    session_start();

    include("classes/connect.php");
    include("classes/login.php");
    include("classes/user.php");
    include("classes/comment.php");
    include("classes/post.php");
    include("classes/memory.php");

    $login = new Login();
    $user_data = $login->check_login($_SESSION['ekos_userid']);
    $memid = $_SESSION['funmem'];
    $id = $_SESSION['ekos_userid'];
    $postid = $_GET['postid'];

    // posting starts here
    if($_SERVER['REQUEST_METHOD'] == "POST") {

        $comment = new Comment();
        $result = $comment->create_comment($id, $postid, $_POST, $memid);
       
        if($result == "") {
        }
        else {
            echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
            echo "The following errors occured: <br><br>";
            echo $result;
            echo "</div>";
        }
    }
    $comment = new Comment();
    $comments = $comment->get_commentsbyid($postid);
?>

<!DOCTYPE html>
<html>
    <head>
        <title> comment | ekos </title>
    </head>

    <style type="text/css">

        #blue_bar{
            height: 50px;
            background-color: #4b5320;
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
            cursor: pointer;
        }

        #post_bar{
            margin-top: 20px;
            background-color: white;
            padding: 10px;
        }

        #post_bar_sub{
            background-color: white;
        }

        #post{
            padding: 4px;
            font-size: 13px;
            display: flex;
            margin-bottom: 20px;
        }

        #post_sub{
            font-size: 13px;
            display: flex;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto;
            background-color: #d0d8e4;
            padding: 10px;
            grid-gap: 20px;
        }

    </style>

    <body style="font-family: tahoma; background-color: #79c9f7">
        <br>
        <!-- top bar -->
        <div id="blue_bar">
            <div style="width: 800px; margin: auto; font-size: 30px;">
                <a href="memories.php" style="float: left; margin: 10px; color: white; text-decoration: none">
                    <span>ekos</span>
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
                <div style="min-height: 400px;padding-top: 20px; border-radius: 25px">  
                    <!-- // post area -->
                    <div class="grid-container" style="text-align:center;text-decoration:none; background-color:#79c9f7;">
                        <?php 
                            $post = new Post();
                            $memid = $_SESSION['funmem'];
                            $res2 = $post->get_post_images($postid);
              
                            $j = 0;
                            while(isset($res2[$j])) {
                                $ext = pathinfo($res2[$j]['media'], PATHINFO_EXTENSION);
                                $pidl = $res2[$j]['fileid'];
                                $useridl = $res2[$j]['userid'];
                                if($ext == "jpg" || $ext== "jpeg") {
                                    echo "<div  >";
                                    echo "<img style='width:75%;border-radius:16px' src=" . "uploads/" . $res2[$j]['media'] . " >";
                                    if($useridl == $id) {
                                        echo "<br><br><br>
                                        <a href='delete_file_edit_post.php?fileid=$pidl&postid=$postid' style='text-align:center; text-decoration:none; padding: 10px;'>       
                                            <div>
                                                delete
                                            </div>   
                                        </a>  ";       
                                    }
                                    echo "</div>";
                                }
                                else if($ext == "mp4") {  
                                    echo "<div style='text-decoration:none' >";
                                    echo "<video controls style='width:80%;border-radius:16px' src=" . "uploads/" . $res2[$j]['media'] . ">" . "Play video" . "</video>";  
                                    if($useridl == $id) {
                                        echo "<br><br><br>
                                        <a href='delete_file_edit_post.php?fileid=$pidl&postid=$postid' style='text-align:center; text-decoration:none; padding: 10px;'>       
                                            <div>
                                                delete
                                            </div>   
                                        </a>  ";                             
                                    }
                                               
                                    echo "</div>";                            
                                }      
                                $j++;
                            }
            
                            echo "<br><br><br>";
            
                        ?>                        
                    </div> 
                    <!-- make comment -->
                    <br><br>
                    <div style="padding: 10px; background-color: #79c9f7;">
                        <form method="post" enctype="multipart/form-data" >
                            <textarea name="comment" placeholder="Comment" style="border:solid thin #aaa; border-radius:8px;"></textarea>
                            <input id="post_button" type="submit" value="Comment">
                            <br>
                        </form>
                    </div>
                    <!-- comment -->
                    <div id="post_bar" style="background-color: #79c9f7; border-radius: 25px">

                        <?php                    
                            if($comments) {
                                foreach($comments as $row) {
                                    
                                    $user = new User();
                                    $row_user = $user->get_user($row['userid']);
                                    include("comment_post.php");
                                }
                            }
                        ?>
                    </div>                      
                </div>                             
            </div>                
        </div>
    </body>
</html>