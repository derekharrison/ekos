<?php

class Signup {

    private $error = "";

    public function evaluate($data) {
        foreach($data as $key => $value) {
            if(empty($value)) {
                $this->error = $this->error . "." . $key . " is empty. <br>";
            }
        }

        if($this->error == "") {
            return $this->create_user($data);
        }
        else {
            return $this->error;
        }        
    }


    public function create_user($data) {

        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $email = $data['email'];
        $password = $data['password'];
        $url_address = strtolower($first_name . "." . $last_name);
        $userid = $this->create_userid();
        $profile_image = "uploads/gn_avatar.png";
        $query = "insert into users (profile_image,userid,first_name,last_name,email,password,url_address) 
        values 
        ('$profile_image','$userid','$first_name','$last_name','$email','$password','$url_address')";
        $DP = new Database();
        $DP->save($query);
    }

    private function create_userid() {

        $length = rand(4, 19);
        $number = "";
        for($i = 0; $i < $length; $i++) {
            $new_rand = rand(0,9);
            $number = $number . $new_rand;
        }

        return $number;
    }
}
