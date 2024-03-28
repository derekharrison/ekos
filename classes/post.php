<?php

include("image.php");

class Post {

    private $error = "";
    
    public function update_post($userid, $data, $memoryid, $files, $postid, $batch_nr) {
        
        
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
                    $query = "insert into postfiles (userid,memoryid,media,fileid,postid,batch_nr) 
                    values 
                    ('$userid','$memoryid','$filename','$fileid','$postid','$batch_nr')";
        
                    $DB = new Database();
                    $res = $DB->save($query);
                }
                else {
                    $this->error = "Only the file types jpg, jpeg, png and mp4 are supported";                    
                }  
            }
        }   
        
        if($filename == "") {
            $filenames = $this->get_post_images($postid);
            $filename = $filenames[0]['media'];
        }     
        
        $post = htmlspecialchars(addslashes($data['post']));
        
        $rowdata = $this->get_post_row($postid);
        
        $query_lc = "select * from postfiles_buffer where postid = '$postid'";
        $DBL = new Database();
        $res1 = $DBL->read($query_lc);
        $query_lc = "delete from postfiles_buffer where postid = '$postid'";
        $res2 = $DBL->save($query_lc);
        
        $j = 0;
        
        while(isset($res1[$j])){
            $media = $res1[$j]['media'];
            $fileid = $res1[$j]['fileid'];
            $batch_nr = $res1[$j]['batch_nr'];
            $query = "insert into postfiles (userid,memoryid,media,fileid,batch_nr,postid) 
            values 
            ('$userid','$memoryid','$media','$fileid','$batch_nr','$postid')";

            $DB = new Database();
            $res = $DB->save($query); 
            $j++;
        }
        
        $query_lc = "select * from posts_buffer where postid = '$postid'";
        $DBL = new Database();
        $res1 = $DBL->read($query_lc);
        $query_lc = "delete from posts_buffer where postid = '$postid'";
        $res2 = $DBL->save($query_lc);
        
        if(empty($post)) {
            $post = $res1[0]['post'];
        }
       
        $filename = $res1[0]['image'];  
        
                
        $query = "update posts set post='$post' where postid = '$postid'";
    
        $DB = new Database();
        $result = $DB->save($query);

        return $this->error;
    } 
    
    public function add_files($userid, $data, $memoryid, $files, $postid, $batch_nr) {
        
        $total = count($files['upload']['name']);
        $post = htmlspecialchars(addslashes($data['post']));
        
        // Loop through each file
        for( $i = 0 ; $i < $total ; $i++ ) {
            $filename = $files['upload']['name'][$i];
            if($filename != "") {
                $filename = strtolower($filename);
                $filename = str_replace(" ", "_", $filename);                  
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if($ext == "jpg" || $ext== "jpeg" || $ext == "png" || $ext == "mp4") {                 
              
                    $fileid = $this->create_postid();
                    $query = "insert into postfiles_buffer (userid,memoryid,media,fileid,postid,batch_nr) 
                    values 
                    ('$userid','$memoryid','$filename','$fileid','$postid', '$batch_nr')";
        
                    $DB = new Database();
                    $res = $DB->save($query);
                }
                else {
                    $this->error = "Only the file types jpg, jpeg, png and mp4 are supported";                    
                }                  
            }
        }   
        
        $vall = $this->get_post_row_buffer($postid);
        
        if(empty($vall)) {
            $query = "insert into posts_buffer (userid,memoryid,post,postid) 
            values 
            ('$userid','$memoryid','$post','$postid')";
    
            $DB = new Database();
            $res = $DB->save($query);  
        }
        else {
            $query = "update posts_buffer set post='$post' where postid = '$postid'";
            $DB = new Database();
            $res = $DB->save($query);             
        }
        
        return $this->error;
    } 
    
    public function create_post2($userid, $data, $memid, $files, $postid, $batch_nr) {
        
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
                    $query = "insert into postfiles (userid,memoryid,media,fileid,postid,batch_nr) 
                    values 
                    ('$userid','$memid','$filename','$fileid','$postid','$batch_nr')";
        
                    $DB = new Database();
                    $res = $DB->save($query);
                }
                else {
                    $this->error = "Only the file types jpg, jpeg, png and mp4 are supported";                    
                }                 
            }
        }   
        
        if($filename == "") {
            $filenames = $this->get_post_images($postid);
            $filename = $filenames[0]['media'];
        }        
        
        $post = htmlspecialchars(addslashes($data['post']));
        
        $rowdata = $this->get_post_row($postid);
        
        $query_lc = "select * from postfiles_buffer where postid = '$postid'";
        $DBL = new Database();
        $res1 = $DBL->read($query_lc);
        $query_lc = "delete from postfiles_buffer where postid = '$postid'";
        $res2 = $DBL->save($query_lc);
        
        $j = 0;
        
        while(isset($res1[$j])){
            $media = $res1[$j]['media'];
            $fileid = $res1[$j]['fileid'];
            $batch_nr = $res1[$j]['batch_nr'];
            $query = "insert into postfiles (userid,memoryid,media,fileid,batch_nr,postid) 
            values 
            ('$userid','$memid','$media','$fileid','$batch_nr','$postid')";

            $DB = new Database();
            $res = $DB->save($query); 
            $j++;
        }
        
        $query_lc = "select * from posts_buffer where postid = '$postid'";
        $DBL = new Database();
        $res1 = $DBL->read($query_lc);
        $query_lc = "delete from posts_buffer where postid = '$postid'";
        $res2 = $DBL->save($query_lc);
        
        if(empty($post)) {
            $post = $res1[0]['post'];
        }
       
        $filename = $res1[0]['image'];  
        
        
        $query = "insert into posts (userid,memoryid,post,image,postid) 
        values 
        ('$userid','$memid','$post','$filename','$postid')";

        $DB = new Database();
        $res = $DB->save($query); 
        

        return $this->error;
    }     
    
    public function create_post($userid, $data, $memid, $files, $postid) {

        if(!empty($data['post']) || !empty($files['file']['name'])) {

            $myimage = "";
            $has_image = 0;

            $allowed[] = "jpg";
            $allowed[] = "jpeg";
            $allowed[] = "mp4";

            $ext = pathinfo($files['file']['name'], PATHINFO_EXTENSION);
           
            if(!empty($files['file']['name']) && in_array($ext, $allowed)) {
                $image_class = new Image();
                $myimage = $files['file']['name'];
                $has_image = 1;
            }
       
            $post = htmlspecialchars(addslashes($data['post']));

            $query = "insert into posts (postid,userid,post,memoryid,image,has_image) 
            values 
            ('$postid','$userid','$post','$memid','$myimage','$has_image')";

            $DB = new Database();
            $res = $DB->save($query);
        }


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

    public function get_posts() {

        $query = "select * from posts order by date desc";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    }

    public function get_postsbyid($id) {

        $query = "select * from posts where memoryid = '$id' order by id desc limit 10";

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

        $query = "delete from postfiles where batch_nr = '$batch_nr'";

        $DB = new Database();
        $result = $DB->save($query);
      

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    } 
    
    public function delete_posts($id) {

        $res = false;

        $query = "delete from posts where postid = '$id'";

        $DB = new Database();
        $result = $DB->save($query);

        if($result) {
            $result = true;
        }

        $query = "delete from comments where postid = '$id'";

        $DB = new Database();
        $result = $DB->save($query);
        
        $query = "delete from postfiles where postid = '$id'";

        $DB = new Database();
        $result = $DB->save($query);        
        
        if($result) {
            $result = true;
        }

        return $res;
    }

    public function get_post($id) {

        $query = "select post from posts where postid = '$id'";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    }   
    
    public function get_post_row($id) {

        $query = "select * from posts where postid = '$id'";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    }   
    
    public function get_post_row_buffer($id) {

        $query = "select * from posts_buffer where postid = '$id'";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    } 
    
    public function get_post_image($id) {

        $query = "select image from posts where postid = '$id'";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    }    
    
    public function get_post_text($id) {

        $query = "select post from posts where postid = '$id'";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    } 
    
    public function get_post_images($id) {

        $query = "select * from postfiles where postid = '$id'";
        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    }     
    
    public function get_post_images2($id) {

        $query = "select * from postfiles where postid = '$id' limit 6";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    }      
        
    public function get_post_files_buffer($id) {

        $query = "select * from postfiles_buffer where postid = '$id'";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    }           
}