<?php

class Memory {

    private $error = "";
    private $filename = "";

    public function add_files($userid, $data, $memoryid, $files, $batch_nr) {
        
        $total = count($files['upload']['name']);
        $post = htmlspecialchars(addslashes($data['post']));
        $title = htmlspecialchars(addslashes($data['title']));
        
        // Loop through each file
        for( $i = 0 ; $i < $total ; $i++ ) {
            $filename = $files['upload']['name'][$i];
            if($filename != "") {
                $filename = strtolower($filename);
                $filename = str_replace(" ", "_", $filename);                
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if($ext == "jpg" || $ext== "jpeg" || $ext == "png" || $ext == "mp4") {                

                    $fileid = $this->create_postid(); 
                    
                    $query = "insert into memoryfiles_buffer (userid,memoryid,media,fileid,batch_nr) 
                    values 
                    ('$userid','$memoryid','$filename','$fileid','$batch_nr')";
        
                    $DB = new Database();
                    $res = $DB->save($query);                         
                }
                else {
                    $this->error .= "Only the file types jpg, jpeg, png and mp4 are supported";                    
                }
            }

        }   

        if($filename == "") {
            $filenames = $this->get_memory_image($memoryid);
            $filename = $filenames[0]['image'];
        }

        $vall = $this->get_memory_row_buffer($memoryid);
        
        if(empty($vall)) {
            $query = "insert into memories_buffer (userid,memoryid,text,title) 
            values 
            ('$userid','$memoryid','$post','$title')";
    
            $DB = new Database();
            $res = $DB->save($query);  
        }
        else {
            $query = "update memories_buffer set title='$title', text='$post' where memoryid = '$memoryid'";
            $DB = new Database();
            $res = $DB->save($query);             
        }

        return $this->error;
    } 

    public function update_memory($userid, $data, $memoryid, $files, $batch_nr) {
        
        $total = count($files['upload']['name']);
        
        // Loop through each file
        for( $i = 0 ; $i < $total ; $i++ ) {
            $filename = $files['upload']['name'][$i];
            if($filename != "") {
                $filename = strtolower($filename);
                $filename = str_replace(" ", "_", $filename);                  
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if($ext == "jpg" || $ext== "jpeg" || $ext == "png" || $ext == "mp4") {                  
              
                    $fileid = $this->create_postid();
                    $query = "insert into memoryfiles (userid,memoryid,media,fileid,batch_nr) 
                    values 
                    ('$userid','$memoryid','$filename','$fileid', '$batch_nr')";
        
                    $DB = new Database();
                    $res = $DB->save($query);
                }
                else {
                    $this->error .= "Only the file types jpg, jpeg, png and mp4 are supported";                    
                }                
            }
        }   
        
        if($filename == "") {
            $filenames = $this->get_memory_images($memoryid);
            $filename = $filenames[0]['image'];
        }
        
        $post = htmlspecialchars(addslashes($data['post']));
        $title = htmlspecialchars(addslashes($data['title']));

        $rowdata = $this->get_memory_row_buffer($memoryid);
        $memorytitle = $rowdata[0]['title'];
        $posttext = $rowdata[0]['text'];
        
        $query_lc = "select * from memoryfiles_buffer where memoryid = '$memoryid'";
        $DBL = new Database();
        $res1 = $DBL->read($query_lc);
        $query_lc = "delete from memoryfiles_buffer where memoryid = '$memoryid'";
        $res2 = $DBL->save($query_lc);
        
        $j = 0;
        
        while(isset($res1[$j])){
            $userid = $res1[$j]['userid'];
            $memoryid = $res1[$j]['memoryid'];
            $media = $res1[$j]['media'];
            $fileid = $res1[$j]['fileid'];
            $batch_nr = $res1[$j]['batch_nr'];
            $query = "insert into memoryfiles (userid,memoryid,media,fileid,batch_nr) 
            values 
            ('$userid','$memoryid','$media','$fileid','$batch_nr')";

            $DB = new Database();
            $res = $DB->save($query); 
            $j++;
        }
        
        $query_lc = "select * from memories_buffer where memoryid = '$memoryid'";
        $DBL = new Database();
        $res1 = $DBL->read($query_lc);
        $query_lc = "delete from memories_buffer where memoryid = '$memoryid'";
        $res2 = $DBL->save($query_lc);
  
        if(empty($post)) {
            $post = $posttext;
        }
        if(empty($title)) {
            $title = $memorytitle;
        }        
        $filename = $res1[0]['image'];  
        
        $query = "update memories set title='$title', text='$post', image='$filename' where memoryid = '$memoryid'";
    
        $DB = new Database();
        $result = $DB->save($query);

        return $this->error;
    } 
    
    public function create_memory($userid, $data, $memoryid, $files, $batch_nr) {
        
        $total = count($files['upload']['name']);
        
        // Loop through each file
        for( $i = 0 ; $i < $total ; $i++ ) {
            $filename = $files['upload']['name'][$i];
            if($filename != "") {
                $filename = strtolower($filename);
                $filename = str_replace(" ", "_", $filename);                  
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if($ext == "jpg" || $ext== "jpeg" || $ext == "png" || $ext == "mp4") {
              
                    $fileid = $this->create_postid();
                    $query = "insert into memoryfiles (userid,memoryid,media,fileid,batch_nr) 
                    values 
                    ('$userid','$memoryid','$filename','$fileid','$batch_nr')";
        
                    $DB = new Database();
                    $res = $DB->save($query);                    
                } 
                else {
                    $this->error .= "Only the file types jpg, jpeg, png and mp4 are supported";
                }
            }
        }   
        
        if($filename == "") {
            $filenames = $this->get_memory_images($memoryid);
            $filename = $filenames[0]['image'];
        }
        
        $post = htmlspecialchars(addslashes($data['post']));
        $title = htmlspecialchars(addslashes($data['title']));
        
        $rowdata = $this->get_memory_row_buffer($memoryid);
        $memorytitle = $rowdata[0]['title'];
        $posttext = $rowdata[0]['text'];
        
        $query_lc = "select * from memoryfiles_buffer where memoryid = '$memoryid'";
        $DBL = new Database();
        $res1 = $DBL->read($query_lc);
        $query_lc = "delete from memoryfiles_buffer where memoryid = '$memoryid'";
        $res2 = $DBL->save($query_lc);
        
        $j = 0;
        
        while(isset($res1[$j])){
            $media = $res1[$j]['media'];
            $fileid = $res1[$j]['fileid'];
            $batch_nr = $res1[$j]['batch_nr'];
            $query = "insert into memoryfiles (userid,memoryid,media,fileid,batch_nr) 
            values 
            ('$userid','$memoryid','$media','$fileid','$batch_nr')";

            $DB = new Database();
            $res = $DB->save($query); 
            $j++;
        }
        
        $query_lc = "select * from memories_buffer where memoryid = '$memoryid'";
        $DBL = new Database();
        $res1 = $DBL->read($query_lc);
        $query_lc = "delete from memories_buffer where memoryid = '$memoryid'";
        $res2 = $DBL->save($query_lc);
        
        if(empty($post)) {
            $post = $res1[0]['text'];
        }
        if(empty($title)) {
            $title = $res1[0]['title'];
        }        
        $filename = $res1[0]['image'];  
        
        
        $query = "insert into memories (userid,memoryid,text,title,image) 
        values 
        ('$userid','$memoryid','$post','$title','$filename')";

        $DB = new Database();
        $res = $DB->save($query);  
        
        return $this->error;
    } 

    public function create_memory2($userid, $data, $memoryid, $files) {
        
        $total = count($files['uploadfiles']['name']);
        
        // Loop through each file
        for( $i = 0 ; $i < $total ; $i++ ) {
            $filename = $files['uploadfiles']['name'][$i];
            if($filename != "") {
                $fileid = $this->create_postid();
                $query = "insert into memoryfiles (userid,memoryid,media,fileid) 
                values 
                ('$userid','$memoryid','$filename','$fileid')";
    
                $DB = new Database();
                $res = $DB->save($query);
            }
        }   
                
        if($filename == "") {
            $filenames = $this->get_memory_images($memoryid);
            $filename = $filenames[0]['image'];
        }
        
        $post = htmlspecialchars(addslashes($data['post']));
        $title = htmlspecialchars(addslashes($data['title']));
        
        $query = "insert into memories (userid,memoryid,text,title,image) 
        values 
        ('$userid','$memoryid','$post','$title','$filename')";

        $DB = new Database();
        $res = $DB->save($query);

        return $this->error;
    } 
    
    public function create_postid() {

        $length = rand(4, 19);
        $number = "";
        for($i = 0; $i < $length; $i++) {
            $new_rand = rand(0,9);
            $number = $number . $new_rand;
        }

        return $number;
    }

    public function get_memories() {

        $query = "select * from memories order by date asc";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    }  
    
    public function get_memory($id) {

        $query = "select text from memories where memoryid = '$id' limit 1";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    } 
    
    public function get_memory_image($id) {

        $query = "select image from memories where memoryid = '$id' limit 1";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    }    
    
    public function get_memory_images($id) {

        $query = "select * from memoryfiles where memoryid = '$id'";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    } 
    
    public function get_memory_images2($id) {

        $query = "select * from memoryfiles where memoryid = '$id' limit 4";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    } 
    
    public function get_memory_files_buffer($id) {

        $query = "select * from memoryfiles_buffer where memoryid = '$id'";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    }     
    
    public function get_memory_row($id) {

        $query = "select * from memories where memoryid = '$id'";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    }  

    public function get_memory_row_buffer($id) {

        $query = "select * from memories_buffer where memoryid = '$id'";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    } 
    
    public function delete_batch($batch_nr) {

        $query = "delete from memoryfiles where batch_nr = '$batch_nr'";

        $DB = new Database();
        $result = $DB->save($query);
      

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    }  
    
    public function delete_memory_row($id) {

        $query = "delete from memories where memoryid = '$id'";

        $DB = new Database();
        $result = $DB->save($query);

        $query = "delete from posts where memoryid = '$id'";

        $result = $DB->save($query);

        $query = "delete from comments where memoryid = '$id'";

        $result = $DB->save($query);
        
        $query = "delete from memoryfiles where memoryid = '$id'";

        $result = $DB->save($query);        

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    }      
}