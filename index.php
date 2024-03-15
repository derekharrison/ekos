<?php
    ini_set('session.save_path', '/home3/daufzimy/public_html/session');
    session_start();
    
    include("classes/connect.php");
    include("classes/login.php");

    $email = "";
    $password = "";    
    $_SESSION['memid'] = "";
    
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

        $email = htmlspecialchars(addslashes($_POST['email']));
        $password = htmlspecialchars(addslashes($_POST['password']));
    }
?>

<html> 
    <head>  
        <title> ekos | log in</title>
        <link rel="icon" type="image/x-icon" href="uploads/charlie-brown-pp.jpg">
    </head>
    <style>
        #bar{
            height:100px;
            background-color:#4b5320;
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
            font-family: tahoma;
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
            cursor: pointer;
            font-family: tahoma;
        }

    </style>
    <body style="font-family: tahoma; 
                background-color: #79c9f7;">  
        <div id="bar"> 
            <div style="font-size: 40px;"> ekos </div>
            
            <a href="signup.php" style="text-decoration: none; background-color: #3c5a99; color: white;cursor: pointer;">
                <div id="signup_button"> 
                Sign up 
                </div>
            </a>
            
        </div>
        <div id="login_bar">
            <form method="post" action="">               
                <div style="font-family: tahoma; font-size:20px; font-weight: bold;">
                    Log in
                </div>
                <br><br>

                <input name="email" <?php echo $email ?> type="text" id="text" placeholder="Email"><br><br>
                <input name="password" value="<?php echo $password ?>" type="password" id="text" placeholder="Password"><br><br>
                <input type="submit" id="button" value="Log in"><br><br>
                 <a href="reset_password.php" style="text-decoration: none; color: green"> 
                    <div >Reset Password</div>
                </a> 
            </form> 
        </div>
    </body>
</html>
