<?php
    include("connection.inc.php");

    session_start();
    if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == "yes"){
        header("location:dashboard.php");
        die();
    }

    $nameerr = "";
    $emailerr = "";
    $pherr = "";
    $rpwderr = "";
    $pwderr = "";
    if(isset($_POST["regsubmit"])){
        $name = mysqli_real_escape_string($con, $_POST["name"]);
        $email = mysqli_real_escape_string($con, $_POST["email"]);
        $phone = mysqli_real_escape_string($con, $_POST["phone"]);
        $pwd = mysqli_real_escape_string($con, $_POST["pwd"]);
        $rpwd = mysqli_real_escape_string($con, $_POST["rpwd"]);

        if($name == "" || (!preg_match ("/^[a-zA-Z\s]+$/",$name))){
            $nameerr = "Please enter a valid name.";
        }else if($email == ""){
            $emailerr = "Please enter a valid email.";
        }else if($phone == "" && strlen($phone) > 10 || strlen($phone) < 10){
            $pherr = "Please enter a valid phone number.";
        }else if($pwd == "" && strlen($pwd) < 6){
            $pwderr = "Please enter valid password.";
        }else if(!($pwd === $rpwd)){
            $rpwderr = "Please re-enter valid password.";
        }else{

            //Checking whether the email id is present in database or not
            $emailsql = "SELECT * FROM `users` WHERE email='$email'";
            $res = mysqli_query($con, $emailsql);

            if(mysqli_num_rows($res) > 0){
                $emailerr = "This email id is already registered.";
            }else{
                $added_on = date("Y-m-d h:i:s");
                $encpwd = md5(sha1($pwd));

                $regsql = "INSERT INTO users(name, email, phone, password, image, added_on) values('$name', '$email', '$phone', '$encpwd', 'DefaultPic.png', '$added_on')";

                $regres = mysqli_query($con, $regsql);

                header("location:login.php?registered");
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
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="totbg">
        <div class="wrapper">
            <a title="Login" style="float: right;" href="login.php"><i class="fa fa-sign-in topicon" aria-hidden="true"></i></a>
            <h1>Registration</h1>
            <div class="formwrap">
                <form action="registration.php" method="POST">
                    <div class="field">
                        <input type="text" name="name" placeholder="Enter Your Name">
                        <span class="errcls"><?php echo $nameerr; ?></span>
                    </div>
                    <div class="field">
                        <input type="email" name="email" placeholder="Enter Your Email Address">
                        <span class="errcls"><?php echo $emailerr; ?></span>
                    </div>
                    <div class="field">
                        <input type="tel" name="phone" placeholder="Enter Your Phone Number">
                        <span class="errcls"><?php echo $pherr; ?></span>
                    </div>
                    <div class="field">
                        <input type="password" name="pwd" placeholder="Enter Your Password">
                        <span class="errcls"><?php echo $pwderr; ?></span>
                    </div>
                    <div class="field">
                        <input type="password" name="rpwd" placeholder="Re-enter Your Password">
                        <span class="errcls"><?php echo $rpwderr; ?></span>
                    </div>
                    <div class="field btnr">
                        <input type="submit" class="btn" name="regsubmit" value="Register">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>