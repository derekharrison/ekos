<?php
    ini_set('session.save_path', 'path_to_session');
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

        $password = "314";
        $val = $_POST['email'];
        $query = "update users set password = '$password' where email = '$val' limit 1";

        $DB = new Database();
        $DB->save($query);

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
            $mail->addAddress($val, 'john smith');     //Add a recipient
            $mail->addReplyTo($val, 'Information');
            // $mail->addCC('john@gmail.com');
            // $mail->addBCC('john@gmail.com');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Hello from Ekos!';
            $mail->Body    = "The new password is: " . $password;
            $mail->AltBody = 'Coming in from erikmemories.com dude, can you verify?';

            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    header("Location: index.php");
    die; 
    }
?>

<html> 
    <head>  
        <title> Ekos | Sign up</title>
    </head>
    <style>
        #bar{
            height:100px;
            background-color:#3c5a99;
            color:#d9dfeb;
            padding: 4px;
        }

        #signup_button{
            background-color: #42b72a;
            width: 70px;
            text-align: center;
            padding: 4px;
            border-radius: 4px;
            float:right;
        }

        #login_bar{
            background-color: white; 
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
        }

    </style>
    <body style="font-family: tahoma; 
                background-color: #e9ebee;">  
        <div id="bar"> 
            <div style="font-size: 40px;"> Ekos </div>
            <div id="signup_button"> 
                <a href="index.php" style="text-decoration: none; color: white;">
                    Log in 
                </a>
            </div>
        </div>
        <div id="login_bar"> 
            Reset password <br><br>
            <form method="post" action="">
                <input name="email" type="text"; id="text"; placeholder="Email"> <br><br>
                <input type="submit"; id="button"; value="Reset Password";> <br><br>
            </form>
        </div>
    </body>

</html>
