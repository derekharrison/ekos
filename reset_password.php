<?php
    ini_set('session.save_path', 'session');
    session_start();

    include("classes/connect.php");
    include("classes/login.php");
    include("classes/user.php");
    include("classes/post.php");
    include("mailer/SMTP.php");
    include("mailer/PHPMailer.php");


    $first_name = "";
    $last_name = "";
    $email = "";
    $val = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $length = 4;
        $number = "";
        for($i = 0; $i < $length; $i++) {
            $new_rand = rand(0,9);
            $number = $number . $new_rand;
        }
        
        $password = $number;
        $val = htmlspecialchars(addslashes($_POST['email']));
        $passcl = hash("sha256", $password);
        $query = "update users set password = '$passcl' where email = '$val' limit 1";

        $DB = new Database();
        $DB->save($query);
        
        $query = "select * from users where email = '$val' limit 1";

        $read = $DB->read($query);
        $first_name = $read['first_name'];
        $last_name = $read['last_name'];
        
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'erikmemories.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'ekos@erikmemories.com';                     //SMTP username
            $mail->Password   = '';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('ekos@erikmemories.com', 'erikmemories');
            
            $name = $first_name . " " . $last_name;
            
            $mail->addAddress($val, $name);     //Add a recipient
            $mail->addReplyTo($val, 'Information');
            // $mail->addCC('john@gmail.com');
            // $mail->addBCC('john@gmail.com');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Hello from Ekos!';
            $mail->Body    = "The new password is: " . $password;
            $mail->AltBody = "The new password is: " . $password;

            $mail->send();
            
            header("Location: index.php");
            die;     
            
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }
?>

<html> 
    <head>  
        <title> Ekos | Sign up</title>
    </head>
    <style>
        #bar{
            height:100px;
            background-color: #4b5320;
            color:#d9dfeb;
            padding: 4px;
        }

        #signup_button{
            background-color: #3c5a99;
            width: 70px;
            text-align: center;
            padding: 4px;
            border-radius: 4px;
            float:right;
            font-weight: bold;
        }

        #login_bar{
            background-color: #79c9f7; 
            width:800px; 
            margin: auto;
            margin-top:50px;
            padding: 10px;
            padding-top: 50px;
            text-align: center;
            font-weight: bold;
        }

        #text{
            height: 40px;
            width: 300px;
            border-radius: 4px;
            border:solid 1px #888;
            padding: 4px;
            font-size: 14px;
        }

        #button{
            width: 300px;
            height: 40px;
            border-radius: 4px;
            border: none;
            background-color: #3c5a99;
            color: white;
            font-weight: bold;
            font-size: 16px;
            font-family: tahoma;
            cursor: pointer;
        }

    </style>
    <body style="font-family: tahoma; 
                background-color: #79c9f7;">  
        <div id="bar"> 
            <div style="font-size: 40px;"> Ekos </div>
            
            <a href="index.php" style="text-decoration: none; background-color: #3c5a99; color: white;cursor: pointer;font-family: tahoma">
                <div id="signup_button"> 
                Log in 
                </div>
            </a>
            
        </div>
        <div id="login_bar"> 
            <div style="font-size:20px; font-weight: bold;font-family: tahoma">
                Reset password
            </div>   
            <br><br>
            <form method="post" action="">
                <input name="email" type="text"; id="text"; placeholder="Email"> <br><br>
                <input type="submit"; id="button"; value="Reset Password";> <br><br>
            </form>
        </div>
    </body>

</html>
