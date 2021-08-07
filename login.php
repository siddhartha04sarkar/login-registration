<?php
    include("connection.inc.php");
    session_start();

    if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == "yes"){
        header("location:dashboard.php");
        die();
    }

    $regsucc = "";
    $errorsmsg = "";
    $emailerr = "";
    $pwderr = "";
    if(isset($_GET["registered"])){
        $regsucc = "You have Registered Successfully.";
    }

    if(isset($_POST["lgsubmit"])){
        $email = mysqli_real_escape_string($con, $_POST["email"]);
        $pwd = mysqli_real_escape_string($con, $_POST["pwd"]);

        if($email == ""){
            $emailerr = "Enter youe email id.";
        }else if($pwd == ""){
            $pwderr = "Enter your password.";
        }else{
            $encpwd = md5(sha1($pwd));
            $lgsql = "SELECT * FROM users WHERE email='$email' AND password='$encpwd'";
            $lgres = mysqli_query($con, $lgsql);

            if(mysqli_num_rows($lgres) > 0){

                $row = mysqli_fetch_assoc($lgres);
                $_SESSION["USER_LOGIN"] = "yes";
                $_SESSION["USERID"] = $row['id'];
                $_SESSION["USERNAME"] = $row['name'];
                $_SESSION["USEREMAIL"] = $row['email'];
                
                header("location:dashboard.php");

            }else{
                $errorsmsg = "Innvalid email id or password.";
            }

        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="totbg">
        <div class="wrapper loginW">
            <a title="Register yourself" style="float: right;" href="registration.php"><i class="fa fa-user-plus topicon" aria-hidden="true"></i></a>
            <h1>Login</h1>
            <div class="formwrap">
                <form action="login.php" method="POST">
                    <div class="field">
                        <input type="email" name="email" placeholder="Enter Your Email">
                        <span class="errcls"><?php echo $emailerr; ?></span>
                    </div>
                    <div class="field">
                        <input type="password" name="pwd" placeholder="Enter Your Password">
                        <span class="errcls"><?php echo $pwderr; ?></span>
                    </div>
                    <div class="field btnr">
                        <input type="submit" class="btn" name="lgsubmit" value="Login">
                    </div>
                    <div class="field btnr">
                        <span class="succls"><?php echo $regsucc; ?></span>
                        <span class="errcls" style="font-size: 20px; font-weight: bold;"><?php echo $errorsmsg; ?></span>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>