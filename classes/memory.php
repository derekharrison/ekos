<?php

class Memory {

    private $error = "";

    public function create_memory($userid, $data, $memoryid, $image) {
        
        if(!empty($data['post'])) {
            $post = addslashes($data['post']);
            $title = addslashes($data['title']);
            
            $query = "insert into memories (userid,memoryid,text,image,title) 
            values 
            ('$userid','$memoryid','$post','$image','$title')";

            $DB = new Database();
            $res = $DB->save($query);

        }
        else {
            $this->error .= "Please type something to post. <br>";
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

    public function get_memories() {

        $query = "select * from memories order by date desc";

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

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    }      
}