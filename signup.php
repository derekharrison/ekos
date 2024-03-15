<?php
    ini_set('session.save_path', '/home3/daufzimy/public_html/session');
    session_start();
    include("classes/connect.php");
    include("classes/signup.php");

    $first_name = "";
    $last_name = "";
    $email = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $signup = new Signup();
        $result = $signup->evaluate($_POST);

        if($result != "") {

            echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
            echo "The following errors occured: <br><br>";
            echo $result;
            echo "</div>";
        }
        else {
            header("Location: index.php");
            die;
        }

        $first_name = htmlspecialchars(addslashes($_POST['first_name']));
        $last_name = htmlspecialchars(addslashes($_POST['last_name']));
        $email = htmlspecialchars(addslashes($_POST['email']));
    }
?>

<html> 
    <head>  
        <title> ekos | sign up</title>
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
        }

    </style>
    <body style="font-family: tahoma; 
                background-color: #79c9f7;">  
        <div id="bar"> 
            <div style="font-size: 40px;"> ekos </div>
            
            <a href="index.php" style="text-decoration: none; background-color: #3c5a99; color: white;cursor: pointer;font-family: tahoma;">
                <div id="signup_button"> 
                Log in 
                </div>
            </a>
            
        </div>
        <div id="login_bar"> 
            <div style="font-size:20px; font-weight: bold;">
                Sign up
            </div>   
            <br><br>
            <form method="post" action="">

                <input value="<?php echo $first_name ?>" name="first_name" type="text"; id="text"; placeholder="First Name"> <br><br>
                <input value="<?php echo $last_name ?>" name="last_name" type="text"; id="text"; placeholder="Last Name"> <br><br>
                <input value="<?php echo $email ?>" name="email" type="text"; id="text"; placeholder="Email"> <br><br>
                <input name="password" type="password"; id="text"; placeholder="Password"> <br><br>
                <input style="cursor: pointer;" type="submit"; id="button"; value="Sign up";> <br><br>
            </form>
        </div>
    </body>

</html>
