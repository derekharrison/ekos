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
    $memid = $_SESSION['memid'];
    $id = $_SESSION['ekos_userid'];

    // posting starts here
    if($_SERVER['REQUEST_METHOD'] == "POST") {

        $post = new Post();
        $id = $_SESSION['ekos_userid'];
        
        $filename = "";
        $result = "";
        if(isset($_FILES['file']['name'])) {
            $filename = $_FILES['file']['name'];
            $result = $post->create_post($id, $_POST, $memid, $_FILES);

            move_uploaded_file($_FILES['file']['tmp_name'], "uploads/" . $filename);
        }
        else {
            $result = $post->create_post($id, $_POST, $memid, $_FILES);
        }

        if($result == "") {
            header("Location: memory.php");
            die;
        }
        else {
            echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
            echo "The following errors occured: <br><br>";
            echo $result;
            echo "</div>";
        }
    }
    $post = new Post();
    $posts = $post->get_postsbyid($memid);
?>

<!DOCTYPE html>
<html>
    <head>
        <title> memory | ekos </title>
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
            width: 50px;
            cursor: pointer;
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
            background-color: #79c9f7;
            padding: 10px;
            grid-gap: 20px;
        }
        #file-chosen{
          margin-left: 0.3rem;
          font-family: sans-serif;
        }        
        #upload-photo {
           opacity: 0;
           position: absolute;
           z-index: -1;
           font-size: 13px;
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
                <div style="min-height: 400px;padding-top: 20px;">  
                    <!-- // Main memory post -->
                    <div style="text-align:center;">
                        <?php
                            $memory = new Memory();
                            $row = $memory->get_memory_row($memid);
                            echo $row[0]['title'];
                        ?>
                    </div> <br><br><br>                    
                    <div class="grid-container" style="text-align:center;">
                        <?php 
                            $memory = new Memory();
                            $val = $memory->get_memory($memid);
                            $res = $memory->get_memory_image($memid);
                            $res2 = $memory->get_memory_images($memid);
                            $j = 0;
                            while(isset($res2[$j])) {
                                $ext = pathinfo($res2[$j]['media'], PATHINFO_EXTENSION);
                                if($ext == "jpg" || $ext== "jpeg") {
                                    echo "<img style='width:75%;border-radius:16px' src=" . "uploads/" . $res2[$j]['media'] . " >";
                                }
                                else if($ext == "mp4") {  
                                    echo "<video controls style='width:80%;border-radius:16px' src=" . "uploads/" . $res2[$j]['media'] . ">" . "Play video" . "</video>";          
                                }      
                                $j++;
                            }
    
                        ?>                        
                    </div> <br><br><br>
                    <div style="text-align:center;">
                        <?php
                            $memory = new Memory();
                            $row = $memory->get_memory_row($memid);
                            echo $row[0]['text'];
                        ?>
                    </div> <br><br><br> 
                    <div style="text-align: center">
                        <?php 
                            $memory = new Memory();
                            $val = $memory->get_memory($memid);
                            $arr = $memory->get_memory_row($memid);
                            if($arr[0]['userid'] == $id) {
                                echo "
                                <a href='delete_memory.php'>       
                                    <div style='float: right; padding: 10px;'>
                                        delete
                                    </div>   
                                </a>  ";
                            }
                        ?>                         
                    </div>
                   
        
                    <?php 
                        $memory = new Memory();
                        $arr = $memory->get_memory_row($memid);
                        if($arr[0]['userid'] == $id) {
                            echo "
                            <a href='edit_memory.php?memid=$memid'>       
                                <div style='float: right; padding: 10px;'>
                                    edit
                                </div>   
                            </a>  ";
                        }
                    ?>
          
                    <br><br>
                    <div style="padding: 10px; background-color: #79c9f7;">
                        <form method="post" enctype="multipart/form-data" >
                            <textarea name="post" placeholder="What would you like to share?" style="border:solid thin #aaa; border-radius: 5px"></textarea>
                            <br><br>
                            <label for="upload-photo" style="border:solid thin #aaa; padding: 4px;background-color: grey; color:white; border-radius: 8px;cursor: pointer;">Select file
                            </label>                             
                            <input type="file" name="file" enctype="multipart/form-data" id="upload-photo">
                            <input id="post_button" type="submit" value="Share">
                            <span id="file-chosen"></span>
                            <script>
                                const actualBtn = document.getElementById('upload-photo');
                                
                                const fileChosen = document.getElementById('file-chosen');
                                
                                actualBtn.addEventListener('change', function(){
                                  fileChosen.textContent = this.files[0].name
                                  
                                })                                    
                            </script>                              
                            <br>
                        </form>
                    </div>
                    <!-- posts -->
                    <div id="post_bar" style="background-color: #79c9f7">

                        <?php                    
                            if($posts) {
                                foreach($posts as $row) {
                                    
                                    $user = new User();
                                    $row_user = $user->get_user($row['userid']);
                                    include("post.php");
                                }
                            }
                        ?>
                    </div>                      
                </div>                             
            </div>                
        </div>
    </body>
</html>