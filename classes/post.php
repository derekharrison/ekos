<?php

include("image.php");

class Post {

    private $error = "";
    
    public function update_post($userid, $data, $memoryid, $files, $postid) {
        
        // $total = count($files['upload']['name']);
        
        // // Loop through each file
        // for( $i = 0 ; $i < $total ; $i++ ) {
        //     $filename = $files['upload']['name'][$i];
        //     $fileid = $this->create_postid();
        //     $query = "insert into postfiles (userid,memoryid,media,fileid,postid) 
        //     values 
        //     ('$userid','$memoryid','$filename','$fileid','$postid')";

        //     $DB = new Database();
        //     $res = $DB->save($query);
        // }   
        
        // $filename = "";
        // if(isset($files['upload']['name'][0])) {
        //     $filename = $files['upload']['name'][0];
        // }
        // else {
        //     $filenames = $this->get_memory_images($memoryid);
        //     $filename = $filenames[0];
        
        // }
        
        $post = htmlspecialchars(addslashes($data['post']));
        
        $query = "update posts set post='$post' where postid = '$postid'";
    
        $DB = new Database();
        $result = $DB->save($query);

        return $this->error;
    } 
    
    public function add_files($userid, $data, $memoryid, $files, $postid) {
        
        $total = count($files['upload']['name']);
        $post = htmlspecialchars(addslashes($data['post']));
        echo $total . "<br>";
        // Loop through each file
        for( $i = 0 ; $i < $total ; $i++ ) {
            $filename = $files['upload']['name'][$i];
            if($filename != "") {
                $fileid = $this->create_postid();
                $query = "insert into postfiles (userid,memoryid,media,fileid,postid) 
                values 
                ('$userid','$memoryid','$filename','$fileid','$postid')";
    
                $DB = new Database();
                $res = $DB->save($query);
            }
        }   

        $query = "update posts set post='$post' where postid = '$postid'";
    
        $DB = new Database();
        $result = $DB->save($query);
        
        return $this->error;
    } 
    
    public function create_post2($userid, $data, $memid, $files, $postid) {
        
        // $total = count($files['upload']['name']);
        
        // // Loop through each file
        // for( $i = 0 ; $i < $total ; $i++ ) {
        //     $filename = $files['upload']['name'][$i];
        //     $fileid = $this->create_postid();
        //     $query = "insert into postfiles (userid,memoryid,media,fileid,postid) 
        //     values 
        //     ('$userid','$memid','$filename','$fileid','$postid')";

        //     $DB = new Database();
        //     $res = $DB->save($query);
        // }   
        
        // $filename = "";
        // if(isset($files['upload']['name'][0])) {
        //     $filename = $files['upload']['name'][0];
        // }
        // else {
        //     $filenames = $this->get_post_images($postid);
        //     $filename = $filenames[0];
        
        // }
        
        $post = htmlspecialchars(addslashes($data['post']));
        
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
            // $postid = $this->create_postid();

            $query = "insert into posts (postid,userid,post,memoryid,image,has_image) 
            values 
            ('$postid','$userid','$post','$memid','$myimage','$has_image')";

            $DB = new Database();
            $res = $DB->save($query);
        }
        // else {
        //     $this->error .= "Please type something to post. <br>";
        // }

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
        
}