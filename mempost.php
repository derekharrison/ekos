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
               <?php
                    echo $row['title'];
                ?>
            </div>
            <br>
            <div>
                <?php
                    echo $row['text'];
                ?>
            </div>
    
            <br><br>
            <div class="grid-container2" style="text-align:center;background-color: white">
                <?php 
                    $memory = new Memory();
                    $res2 = $memory->get_memory_images2($memoryid);
                    $j = 0;
                    while(isset($res2[$j]) && $j < 4) {
                        $ext = pathinfo($res2[$j]['media'], PATHINFO_EXTENSION);
                        if(($ext == "jpg" || $ext== "jpeg" || $ext == "png") && $j < 3) {
                            echo "<img style='width:100%;border-radius:16px' src=" . "uploads/" . $res2[$j]['media'] . " >";
                        }
                        else if($ext == "mp4" && $j < 3) {  
                            echo "<video controls style='width:100%;border-radius:16px' src=" . "uploads/" . $res2[$j]['media'] . ">" . "Play video" . "</video>";          
                        }      
                        $j++;
                    }
                    if($j >= 4) {
                        echo "<img style='width:100%;border-radius:16px' src=" . "uploads/plus2-bitmap.png" . " >";                       
                    }

                ?>                        
            </div> <br><br><br>  
        <div>
            <?php
                $query2 =  "select id from posts where memoryid = '$memoryid'";
                $DB2 = new Database();
                $j = 0;
                $result2 = $DB2->read($query2); 
                while(isset($result2[$j])) { 
                    $j++;
                }               
                if($j > 0) {
                    echo "comments " . $j;
                }
            ?>
        </div>               
        </div> 
        
    </div>  
</a>
