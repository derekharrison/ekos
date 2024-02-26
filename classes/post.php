<?php

include("image.php");

class Post {

    private $error = "";

    public function create_post($userid, $data, $memid, $files) {

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
            $postid = $this->create_postid();

            $query = "insert into posts (postid,userid,post,memoryid,image,has_image) 
            values 
            ('$postid','$userid','$post','$memid','$myimage','$has_image')";

            $DB = new Database();
            $res = $DB->save($query);
        }
        else {
            $this->error .= "Please type something to post. <br>";
        }

        return $this->error;
    } 

    private function create_postid() {

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
        
}