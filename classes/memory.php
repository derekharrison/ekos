<?php

class Memory {

    private $error = "";
    private $filename = "";

    public function add_files($userid, $data, $memoryid, $files) {
        
        $total = count($files['upload']['name']);
        $post = htmlspecialchars(addslashes($data['post']));
        $title = htmlspecialchars(addslashes($data['title']));
        
        // Loop through each file
        for( $i = 0 ; $i < $total ; $i++ ) {
            $filename = $files['upload']['name'][$i];
            if($filename != "") {
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if($ext == "jpg" || $ext== "jpeg" || $ext == "png" || $ext == "mp4") {                
                    $filename = strtolower($filename);
                    $filename = str_replace(" ", "_", $filename);
                    $fileid = $this->create_postid();
                    $query = "insert into memoryfiles (userid,memoryid,media,fileid) 
                    values 
                    ('$userid','$memoryid','$filename','$fileid')";
        
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
        
        $rowdata = $this->get_memory_row($memoryid);
        $memorytitle = $rowdata[0]['title'];
        $posttext = $rowdata[0]['text'];
        
        if(empty($rowdata)) {
            $query = "insert into memories (userid,memoryid,text,title,image) 
            values 
            ('$userid','$memoryid','$post','$title','$filename')";
    
            $DB = new Database();
            $res = $DB->save($query);            
        }
        else {
            $query = "update memories set title='$title', text='$post', image='$filename' where memoryid = '$memoryid'";
        
            $DB = new Database();
            $result = $DB->save($query);            
        }

        
        return $this->error;
    } 

    public function update_memory($userid, $data, $memoryid, $files) {
        
        $total = count($files['upload']['name']);
        
        // Loop through each file
        for( $i = 0 ; $i < $total ; $i++ ) {
            $filename = $files['upload']['name'][$i];
            if($filename != "") {
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if($ext == "jpg" || $ext== "jpeg" || $ext == "png" || $ext == "mp4") {                  
                    $filename = strtolower($filename);
                    $filename = str_replace(" ", "_", $filename);                
                    $fileid = $this->create_postid();
                    $query = "insert into memoryfiles (userid,memoryid,media,fileid) 
                    values 
                    ('$userid','$memoryid','$filename','$fileid')";
        
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
        
        $query = "update memories set title='$title', text='$post', image='$filename' where memoryid = '$memoryid'";
    
        $DB = new Database();
        $result = $DB->save($query);

        return $this->error;
    } 
    
    public function create_memory($userid, $data, $memoryid, $files) {
        
        $total = count($files['upload']['name']);
        
        // Loop through each file
        for( $i = 0 ; $i < $total ; $i++ ) {
            $filename = $files['upload']['name'][$i];
            if($filename != "") {
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if($ext == "jpg" || $ext== "jpeg" || $ext == "png" || $ext == "mp4") {
                    $filename = strtolower($filename);
                    $filename = str_replace(" ", "_", $filename);                
                    $fileid = $this->create_postid();
                    $query = "insert into memoryfiles (userid,memoryid,media,fileid) 
                    values 
                    ('$userid','$memoryid','$filename','$fileid')";
        
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
        
        $rowdata = $this->get_memory_row($memoryid);
        $memorytitle = $rowdata[0]['title'];
        $posttext = $rowdata[0]['text'];
        
        if(empty($rowdata)) {
            $query = "insert into memories (userid,memoryid,text,title,image) 
            values 
            ('$userid','$memoryid','$post','$title','$filename')";
    
            $DB = new Database();
            $res = $DB->save($query);            
        }
        else {
            $query = "update memories set title='$title', text='$post', image='$filename' where memoryid = '$memoryid'";
        
            $DB = new Database();
            $result = $DB->save($query);            
        }

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