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
        <div>
            <?php 
                $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
                if($ext == "jpg" || $ext== "jpeg") {
                    echo "<img style='width:60%' src=" . "uploads/" . $row['image'] . ">";
                }
                else if($ext == "mp4") {  
                    echo "<video controls style='width:60%' src=" . "uploads/" . $row['image'] . " >" . "Play video" . "</video>";          
                }
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