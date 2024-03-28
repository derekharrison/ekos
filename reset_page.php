<?php
    ini_set('session.save_path', 'session');
    session_start();

    $email = $_GET['email'];

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
            text-align: center;
            text-decoration: none;
            padding: 10px;
        }

    </style>
    <body style="font-family: tahoma; 
                background-color: #79c9f7;">  
        <div id="bar"> 
            <div style="font-size: 40px;"> ekos </div>
            
            <a href="index.php" style="text-decoration: none; background-color: #3c5a99; color: white;cursor: pointer;font-family: tahoma">
                <div id="signup_button"> 
                Log in 
                </div>
            </a>
            
        </div>
        <div id="login_bar"> 
            <div style="font-size:20px; font-weight: bold;font-family: tahoma; color: blue">
                An email with your new password has succesfully been sent to <?php echo $email ?>. Note that the email may have landed in the spam or junk folder.
            </div>   
            <br><br><br>
            <a href="index.php" id="button">
                Go to login page
            </a>            
        </div>
    </body>

</html>