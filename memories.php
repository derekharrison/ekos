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
    
    // collect posts
    $memory = new Memory();
    $id = $_SESSION['ekos_userid'];
    $_SESSION['memid'] = "";
    $_SESSION['funmem'] = "";
    $_SESSION['funpostid'] = "";
    $memories = $memory->get_memories();
    
    $query = "delete from memories_buffer where userid='$id'";
    
    $DB = new Database();
    $result = $DB->save($query);   
    
    $query = "delete from memoryfiles_buffer where userid='$id'";
    
    $result = $DB->save($query);   
    
    $query = "delete from posts_buffer where userid='$id'";
    
    $result = $DB->save($query); 
    
    $query = "delete from postfiles_buffer where userid='$id'";
    
    $result = $DB->save($query);     
?>

<!DOCTYPE html>
<html>
    
    
    <head>
        <title> memories | ekos </title>
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

        .grid-container2 {
            display: grid;
            grid-template-columns: auto auto;
            background-color: #d0d8e4;
            padding: 2px;
            grid-gap: 5px;
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
                        ?>"; style="height: 50px; float: right">
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
        <div style="margin:auto; min-height: 400px;"> 
            <!--<div style="background-color: #79c9f7; text-align: center; color: #405d9b;height:200px"> -->
            <!--    <img src="uploads/mountain.jpg" style="width: 100%">-->
            <!--</div>-->
            
            <!-- below cover area -->
            <div style="margin:auto; width: 800px; text-align: center"> 
                <!-- posts area -->
                <div style="min-height: 400px;padding-top: 20px;">  
                    <div style="display: flex; justify-content: center;">
                        <a href="create_memory.php">
                            <input id="post_button" type="submit" value="Create memory" style="cursor: pointer;">
                            <br>
                        </a>
                    </div>

                    <!-- posts -->
                    <div id="post_bar" class="grid-container" style="background-color: #79c9f7; border-radius: 50px;">

                        <?php 
                            if($memories) {
                                foreach($memories as $row) {
                                    
                                    $user = new User();
                                    $row_user = $user->get_user($row['userid']);
                                    $memoryid = $row['memoryid'];
                                    $userid = $row['userid'];
                                    $media2 = $memory->get_memory_images($memoryid);
                                    $media = $memory->get_memory_image($memoryid);
                                    $image_loc = $media2[0]['media'];
                            
                          
                                    include("mempost.php");
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>           
        </div>
    </body>
</html>