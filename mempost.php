<style>
    .box{
        word-break: break-all;
    }

    #what{
        overflow-wrap: anywhere;
    }

</style>
<a href="memred.php?memid= <?php echo $memoryid ?>" style="text-decoration: none">
    <div id="post" style="padding: 20px; background-color: white; border-radius: 10%;">
        <div id="what" >
            <div style="font-weight: bold; color: #405d9b;">
                Title
            </div>
            <div>
                <?php
                    echo $row['text'];
                ?>
            </div>
    
            <br><br>
            <div>
                <?php 
                    $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
                    if($ext == "jpg" || $ext== "jpeg") {
                        echo "<img style='width:100%' src=" . "uploads/" . $row['image'] . " >";
                    }
                    else if($ext == "mp4") {  
                        echo "<video controls style='width:80%' src=" . "uploads/" . $row['image'] . " ></video>";          
                    }
                ?>
            </div>             
        </div> 
    </div>  
</a>
