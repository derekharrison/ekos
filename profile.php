<?php
    ini_set('session.save_path', '/session');
    session_start();

    include("classes/connect.php");
    include("classes/login.php");
    include("classes/user.php");
    include("classes/post.php");
    
    $login = new Login();
    $user_data = $login->check_login($_SESSION['ekos_userid']);
    $id = $_SESSION['ekos_userid'];
    $image_name = "";
    
    // posting starts here
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        
        if(isset($_FILES['file']) && $_FILES['file']['type'] == "image/jpeg") {

            $allowed_size = 1024 * 1024 * 3;
            if($_FILES['file']['size'] < $allowed_size) {
                if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
                    $filename = "uploads/" . $_FILES['file']['name'];
                    move_uploaded_file($_FILES['file']['tmp_name'], $filename);  
                
                    if(file_exists($filename)) {


                        $userid = $user_data['userid'];
                        $query = "update users set profile_image = '$filename' where userid = '$userid' limit 1";
        
                        $DB = new Database();
                        $DB->save($query);
        
                        header("Location: profile.php");
                        die;
                    }
                }
            }
            else {
                echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
                echo "The following errors occured: <br><br>";
                echo "Only images of size 3Mb or less are allowed";
                echo "</div>";                
            }
        }
    }

    if(isset($_POST['first_name'])) {
        $userid = $user_data['userid'];
        $first_name = htmlspecialchars(addslashes($_POST['first_name']));
        $query = "update users set first_name = '$first_name' where userid = '$userid' limit 1";

        $DB = new Database();
        $DB->save($query);

        header("Location: profile.php");
        die;       
    }
    if(isset($_POST['last_name'])) {
        $userid = $user_data['userid'];
        $last_name = htmlspecialchars(addslashes($_POST['last_name']));
        $query = "update users set last_name = '$last_name' where userid = '$userid' limit 1";

        $DB = new Database();
        $DB->save($query);

        header("Location: profile.php");
        die;       
    }
    if(isset($_POST['email'])) {
        $userid = $user_data['userid'];
        $email = htmlspecialchars(addslashes($_POST['email']));
        $query = "update users set email = '$email' where userid = '$userid' limit 1";

        $DB = new Database();
        $DB->save($query);

        header("Location: profile.php");
        die;       
    }
    if(isset($_POST['password'])) {
        $userid = $user_data['userid'];
        $password = hash("sha256", htmlspecialchars(addslashes($_POST['password'])));
        $query = "update users set password = '$password' where userid = '$userid' limit 1";

        $DB = new Database();
        $DB->save($query);

        header("Location: profile.php");
        die;       
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <title> Profile | Ekos </title>
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
            min-height: 400px;
            margin-top: 20px;
            color: #405d9b;
            padding: 8px;
            text-align: center;
            font-size: 20px;
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

        #post{
            padding: 4px;
            font-size: 13px;
            display: flex;
            margin-bottom: 20px;
        }
        label {
           cursor: pointer;
           /* Style as you please, it will become the visible UI component. */
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
                    <span>Ekos</span>
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
        <div style="width: 800px; margin:auto;"> 
            <!-- below cover area -->
            <div> 
                <!-- friends area -->
                <div > 
                    <div id="friends_bar"> 
                        <?php 
                            $image = "";
                            if(file_exists($user_data['profile_image'])) {
                                $image = $user_data['profile_image'];
                            }
                        ?>
                        <img src="<?php echo $image ?>" id="profile_pic"> <br> 
                        <?php 
                            $row_user = $user->get_user($id);
                            echo $row_user['first_name'] . " " . $row_user['last_name'] . "<br>"; 
                        ?>    
                        <?php 
                            $row_user = $user->get_user($id);
                            echo $row_user['email']; 
                        ?>   
                        <br><br>
                        <!-- posts area -->
                        <div style="text-align:left; width:500px"> 
                    
                            <form method="post" enctype="multipart/form-data" action="" style="padding-top:10px" >
                                <div style="padding: 10px; background-color: #79c9f7;border-radius:4px; font-size:15px;">
                                    <label for="upload-photo" style="border:solid thin #aaa; padding: 4px;background-color: grey; color:white; border-radius: 8px">Select profile picture</label>
                                    <input type="file" name="file" id="upload-photo" />
                                    <input id="post_button" type="submit" value="Update">
                                    <span id="file-chosen"></span>
                                    <script>
                                        const actualBtn = document.getElementById('upload-photo');
                                        
                                        const fileChosen = document.getElementById('file-chosen');
                                        
                                        actualBtn.addEventListener('change', function(){
                                          fileChosen.textContent = this.files[0].name
                                          
                                        })                                    
                                    </script>                                    
                                    <br>
                                </div>
                            </form>
                            <form method="post" action="">
                                <div style="padding: 10px; background-color: #79c9f7;border-radius:8px">
    
                                    <input name="first_name" type="text"; id="text"; placeholder="First Name">                            
                                    <input id="post_button" type="submit" value="Update">
                               
                                </div>
                            </form> 
                            <form method="post" action="">
                                <div style="padding: 10px; background-color: #79c9f7;border-radius:8px">
        
                                    <input name="last_name" type="text"; id="text"; placeholder="Last Name">                            
                                    <input id="post_button" type="submit" value="Update">
                                  
                                </div>
                            </form> 
                            <form method="post" action="">
                                <div style="padding: 10px; background-color: #79c9f7;border-radius:8px">
                                   
                                    <input name="email" type="text"; id="text"; placeholder="Email">                            
                                    <input id="post_button" type="submit" value="Update">
                                    <br>
                                </div>
                            </form> 
                            <form method="post" action="">
                                <div style="padding: 10px; background-color: #79c9f7;border-radius:8px">
                                 
                                    <input name="password" type="password"; id="text"; placeholder="Password">                            
                                    <input id="post_button" type="submit" value="Update">
                                    <br>
                                </div>
                            </form> 
                            
                            <br>
                        </div>                                                               
                    </div>

                </div>
            </div>
        </div>
    </body>

</html>