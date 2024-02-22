<?php
    ini_set('session.save_path', 'path_to_session');
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

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
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
            <div style="font-size: 40px;"> Mybook </div>
            <div id="signup_button"> 
                <a href="index.php" style="text-decoration: none; color: white;">
                    Log in 
                </a>
            </div>
        </div>
        <div id="login_bar"> 
            Sign up <br><br>
            <form method="post" action="">

                <input value="<?php echo $first_name ?>" name="first_name" type="text"; id="text"; placeholder="First Name"> <br><br>
                <input value="<?php echo $last_name ?>" name="last_name" type="text"; id="text"; placeholder="Last Name"> <br><br>
                <input value="<?php echo $email ?>" name="email" type="text"; id="text"; placeholder="Email"> <br><br>
                <input name="password" type="password"; id="text"; placeholder="Password"> <br><br>
                <input name="password2" type="password"; id="text"; placeholder="Retype password"> <br><br>
                <input type="submit"; id="button"; value="Sign up";> <br><br>
            </form>
        </div>
    </body>

</html>
