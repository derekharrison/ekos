<?php

class Comment {

    private $error = "";

    public function create_comment($userid, $postid, $data, $memid) {

        if(!empty($data['comment'])) {

            $comment = htmlspecialchars(addslashes($data['comment']));
            $commentid = $this->create_postid();

            $query = "insert into comments (postid,userid,comment,memoryid,commentid) 
            values 
            ('$postid','$userid','$comment','$memid','$commentid')";

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

    public function get_commentsbyid($id) {

        $query = "select * from comments where postid = '$id' order by id desc";

        $DB = new Database();
        $result = $DB->read($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    }   

    public function delete_comment($id) {
        $query = "delete from comments where commentid = '$id'";

        $DB = new Database();
        $result = $DB->save($query);

        if($result) {
            return $result;
        }
        else{
            return false;
        }
    }
}