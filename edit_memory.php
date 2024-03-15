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
$memid = $_SESSION['funmem'];
$id = $_SESSION['ekos_userid'];
$memorytitle = "";
$posttext = "";
$memory = new Memory();
$rowdata = $memory->get_memory_row($memid);

if($memorytitle == "") {
    $memorytitle = $rowdata[0]['title'];
}
if($posttext == "") {
    $posttext = $rowdata[0]['text'];
}
    
// posting starts here
if($_SERVER['REQUEST_METHOD'] == "POST") {

    
    $id = $_SESSION['ekos_userid'];
    $filename = "";
    $result = "";

    if(isset($_POST['post_button'])) {
        
        $total = count($_FILES['upload']['name']);
        
        // Loop through each file
        for( $i=0 ; $i < $total ; $i++ ) {
        
            //Get the temp file path
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
            
            //Make sure we have a file path
            if ($tmpFilePath != ""){
                //Setup our new file path
                $newFilePath = "./uploads/" . $_FILES['upload']['name'][$i];
                move_uploaded_file($tmpFilePath, $newFilePath);                
            }
        }        

        $result = $memory->update_memory($id, $_POST, $_SESSION['funmem'], $_FILES); 
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

    if(isset($_POST['add_button'])) {
        $total = count($_FILES['upload']['name']);
        $post = htmlspecialchars(addslashes($_POST['post']));
        $title = htmlspecialchars(addslashes($_POST['title']));
        $memorytitle = $title;
        $posttext = $post;
        // Loop through each file
        for( $i=0 ; $i < $total ; $i++ ) {
        
            //Get the temp file path
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
            
            //Make sure we have a file path
            if ($tmpFilePath != ""){
                //Setup our new file path
                $newFilePath = "./uploads/" . $_FILES['upload']['name'][$i];
                move_uploaded_file($tmpFilePath, $newFilePath);                
            }
        }        

        $result = $memory->add_files($id, $_POST, $_SESSION['funmem'], $_FILES); 

        if($result == "") {
            // header("Location: create_memory.php");
            // die;                
        }
        else {
            echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
            echo "The following errors occured: <br><br>";
            echo $result;
            echo "</div>";
        }            
    }
    
    // header("Location: memory.php");
    // die;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title> edit memory | ekos </title>
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
            margin-left: 20px;
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
        #text{
            border-radius: 4px;
            border:solid 1px #888;
            padding: 4px;
            font-size: 14px;
            width: 100%;
        }
        #text2{
            border-radius: 4px;
            border:solid 1px #888;
            padding: 4px;
            font-size: 14px;
            width: 100%;
            height: 20px;
        }        
        #dummy{
           opacity: 0;
           position: absolute;
           z-index: -1;  
           font-size: 13px;
           float: left;
           padding-right: 20px;
        }
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
            background-color: green;
            transition-duration: .2s;
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
        </div><br><br><br>
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
                $memid = $_SESSION['funmem'];
                $val = $memory->get_memory($memid);
                $res = $memory->get_memory_image($memid);
                $res2 = $memory->get_memory_images($memid);
                $j = 0;
                while(isset($res2[$j])) {
                    $ext = pathinfo($res2[$j]['media'], PATHINFO_EXTENSION);
                    $pidl = $res2[$j]['fileid'];
                    if($ext == "jpg" || $ext== "jpeg") {
                        echo "<div  >";
                        echo "<img style='width:75%;border-radius:16px' src=" . "uploads/" . $res2[$j]['media'] . " >";
                        echo "<br><br><br>
                            <a href='delete_file_edit.php?fileid=$pidl' style='text-align:center; text-decoration:none; padding: 10px;'>       
                                <div>
                                    delete
                                </div>   
                            </a>  ";                            
                        echo "</div>";
                    }
                    else if($ext == "mp4") {  
                        echo "<div style='text-decoration:none' >";
                        echo "<video controls style='width:80%;border-radius:16px' src=" . "uploads/" . $res2[$j]['media'] . ">" . "Play video" . "</video>";  
                        echo "<br><br><br>
                            <a href='delete_file_edit.php?fileid=$pidl' style='text-align:center; text-decoration:none; padding: 10px;'>       
                                <div>
                                    delete
                                </div>   
                            </a>  ";                            
                        echo "</div>";                            
                    }      
                    $j++;
                }


                echo "<br><br><br>";

            ?>                        
        </div> 
        <div style="text-align:center;">
            <?php
                $memory = new Memory();
                $row = $memory->get_memory_row($memid);
                echo $row[0]['text'];
            ?>
        </div> <br><br><br>         
        <!-- cover area -->
        <div style="width: 800px; margin:auto; min-height: 400px;"> 
            <div> 
                <!-- posts area -->
                <div style="min-height: 400px;padding-top: 20px;">  
                    <br><br>
                    <div style="padding: 10px; background-color: #79c9f7;">
                        <div style="padding: 10px; background-color: #79c9f7;">
                             <form method="post" enctype="multipart/form-data">
                                <textarea name="title" placeholder="Memory Title" id="text2"><?php echo $memorytitle ?></textarea><br><br>                            
                                <textarea name="post" placeholder="Memory Text" id="text"><?php echo $posttext ?></textarea><br><br>                
                                <input name="upload[]" id="dummy" type="file" multiple="multiple" enctype="multipart/form-data"/> 
                                <label for="dummy" style="border:solid thin #aaa; padding: 4px;background-color: grey; color:white; border-radius: 8px;cursor: pointer;float:left">Select files
                                </label>
                                <input id="post_button" type="submit" value="Update" name="post_button">
                                <button id="post_button" type="submit" value="Add files" style="background-color: green" name="add_button" >Add Files</button>
                         
                                <span id="file-chosen"></span>
                                <script>
                                    const actualBtn = document.getElementById('dummy');
                                    
                                    const fileChosen = document.getElementById('file-chosen');
                                    
                                    actualBtn.addEventListener('change', function(){
                                      fileChosen.textContent = this.files[0].name
                                      
                                    })                                    
                                </script>                 
                                <div class="percent">0%</div><br>
                                <div class="progress-bar">
                                    <span></span>
                                </div> 
                            </form>
                            <script src="script2.js"></script>                        
                        </div>
                        
                    </div>        
                </div>                             
            </div>                
        </div>
    </body>
</html>