<style>
    .box{
        word-break: break-all;
    }

    #what{
        overflow-wrap: anywhere;
    }

</style>
<a href="comment.php?postid= <?php echo  $row['postid'] ?>" style="text-decoration: none">
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
                $res2 = $post->get_post_images2($postid);
                $j = 0;
                while(isset($res2[$j]) && $j < 6) {
                    $ext = pathinfo($res2[$j]['media'], PATHINFO_EXTENSION);
                    $pidl = $res2[$j]['fileid'];
                    if(($ext == "jpg" || $ext== "jpeg" || $ext == "png") && $j < 5) {
                        echo "<div  >";
                        echo "<img style='width:75%;border-radius:16px' src=" . "uploads/" . $res2[$j]['media'] . " >";
                        echo "<br><br><br> ";                            
                        echo "</div>";
                    }
                    else if($ext == "mp4" && $j < 5) {  
                        echo "<div style='text-decoration:none' >";
                        echo "<video controls style='width:80%;border-radius:16px' src=" . "uploads/" . $res2[$j]['media'] . ">" . "Play video" . "</video>";  
                        echo "<br><br><br> ";                            
                        echo "</div>";                            
                    }      
                    $j++;
                }
                if($j >= 6) {
                    echo "<img style='width:100%;border-radius:16px' src=" . "uploads/plus2-bitmap.png" . " >";                       
                }
                echo "<br><br><br>";

            ?>                        
        </div> 
        <div>
     
           <div style='float: left; padding: 10px;'>
               reply
           </div>   
         
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
</a>