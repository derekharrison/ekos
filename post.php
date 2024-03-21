<style>
    .box{
        word-break: break-all;
    }

    #what{
        overflow-wrap: anywhere;
    }

</style>
<div id="post" style="padding: 20px; background-color: white; border-radius: 10px;">
    <div>
        <img src="<?php echo $row_user['profile_image'] ?>" style="width: 75px; margin-right: 4px;">
    </div>
    <div id="what" >
        <div style="font-weight: bold; color: #405d9b;">
            <?php echo $row_user['first_name'] . " " . $row_user['last_name']; ?>
        </div>
        <br>
        <?php
            echo $row['post'];
        ?>
        <br><br>
        <div class="grid-container" style="text-align:center;text-decoration:none;background-color: white">
            <?php 
                $post = new Post();
                $memid = $_SESSION['funmem'];
                $postid = $row['postid'];
                $res2 = $post->get_post_images($postid);
                $j = 0;
                while(isset($res2[$j])) {
                    $ext = pathinfo($res2[$j]['media'], PATHINFO_EXTENSION);
                    $pidl = $res2[$j]['fileid'];
                    if($ext == "jpg" || $ext== "jpeg" || $ext == "png") {
                        echo "<div  >";
                        echo "<img style='width:75%;border-radius:16px' src=" . "uploads/" . $res2[$j]['media'] . " >";
                        echo "<br><br><br> ";                            
                        echo "</div>";
                    }
                    else if($ext == "mp4") {  
                        echo "<div style='text-decoration:none' >";
                        echo "<video controls style='width:80%;border-radius:16px' src=" . "uploads/" . $res2[$j]['media'] . ">" . "Play video" . "</video>";  
                        echo "<br><br><br> ";                            
                        echo "</div>";                            
                    }      
                    $j++;
                }

                echo "<br><br><br>";

            ?>                        
        </div> 
        <div>
            <?php
               $pidl = $row['postid'];
               echo "
               <a href='comment.php?postid=$pidl'>       
                   <div style='float: left; padding: 10px;'>
                       reply
                   </div>   
               </a>  ";
            ?>
            <?php
                if($row['userid']== $id) {
                    $pidl = $row['postid'];
                    echo "
                    <a href='delete_post.php?myvariable=$pidl'>       
                        <div style='float: left; padding: 10px;'>
                            delete
                        </div>   
                    </a>  ";
                }
            ?>                    
            <?php 
    
                if($row['userid'] == $id) {
                    
                    $pidl = $row['postid'];
                    echo "
                    <a href='edit_post.php?myvariable=$pidl'>       
                        <div style='float: left; padding: 10px;'>
                            edit
                        </div>   
                    </a>  ";
                }
            ?>   
        </div>
    </div>
</div>