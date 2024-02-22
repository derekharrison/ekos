<style>
    .box{
        word-break: break-all;
    }

    #what{
        overflow-wrap: anywhere;
    }

</style>
<div id="post_sub" style="background-color: white;">
    <div>
        <img src="<?php echo $row_user['profile_image'] ?>" style="width: 75px; margin-right: 4px;">
    </div>
    <div id="what" >
        <div style="font-weight: bold; color: #405d9b;">
            <?php echo $row_user['first_name'] . " " . $row_user['last_name']; ?>
        </div>
        <?php
            echo $row['comment'];
        ?>
        <br><br>
        <div>
            <?php
                if($row['userid']== $id) {
                    $cidl = $row['commentid'];
                    $pidl = $row['postid'];
                    echo "
                    <a href='delete_comment.php?commentid=$cidl&postid=$pidl'>       
                        <div style='float: left; padding: 10px;'>
                            delete
                        </div>   
                    </a>  ";
                }
            ?>                    
            <?php 
    
                if($row['userid'] == $id) {
                    $pidl = $row['postid'];
                    $cidl = $row['commentid'];
                    echo "
                    <a href='edit_comment.php?commentid=$cidl&postid=$pidl'>       
                        <div style='float: left; padding: 10px;'>
                            edit
                        </div>   
                    </a>  ";
                }
            ?>   
        </div>
    </div>
</div>