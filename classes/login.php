<?php

class Login {

    private $error = "";

    public function evaluate($data) {


        $email = htmlspecialchars(addslashes($data['email']));
        $password = hash("sha256",htmlspecialchars(addslashes($data['password'])));

        $query = "select * from users where email = '$email' limit 1";

        $DP = new Database();
        $result = $DP->read($query);
        
        if($result) {
            $row = $result[0];
            
            if($password == $row['password']) {
                
                $_SESSION['ekos_userid'] = $row['userid'];
            }
            else {
                $this->error .= "wrong password <br>";
            }
        }
        else {
            $this->error .= "No such email was found <br>";
        }
        
        return $this->error;
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

    public function check_login($id) {
        if(is_numeric($id)) {

            $query = "select * from users where userid = '$id' limit 1";
            $DB = new Database();
            $result = $DB->read($query);
            if($result) {
                $user_data = $result[0];
                return $user_data;
            }
            else {
                header("Location: index.php");
                die;
            }
        }
        else {
            header("Location: index.php");
            die;  
        }
    }
}
