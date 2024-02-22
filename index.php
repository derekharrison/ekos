<?php
    ini_set('session.save_path', 'path_to_session);
    session_start();
    
    include("classes/connect.php");
    include("classes/login.php");

    $email = "";
    $password = "";    
    
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $login = new Login();
        $result = $login->evaluate($_POST);

        if($result != "") {

            echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
            echo "The following errors occured: <br><br>";
            echo $result;
            echo "</div>";
        }
        else {
            header("Location: memories.php");
            die;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
    }
?>

<html> 
    <head>  
        <title> Ekos | Log in</title>
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
                <a href="signup.php" style="text-decoration: none; color: white;">
                    Sign up 
                </a>
            </div>
        </div>
        <div id="login_bar">
            <form method="post" action="">               
            
                Log in to Ekos<br><br>

                <input name="email" <?php echo $email ?> type="text" id="text" placeholder="Email"><br><br>
                <input name="password" value="<?php echo $password ?>" type="password" id="text" placeholder="Password"><br><br>
                <input type="submit" id="button" value="Log in" style="cursor: pointer"><br><br>
                <!-- Uncomment below code when reset password is supported -->
                 <a href="reset_password.php" style="text-decoration: none; color: green"> 
                    <div >Reset Password</div>
                </a> 
            </form> 
        </div>
    </body>
</html>
