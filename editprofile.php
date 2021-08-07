<?php
    include("connection.inc.php");
    session_start();
    $nameerr = "";
    $emailerr = "";
    $pherr = "";
    $pwderr = "";
    $successmsgch = "";

    if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == "yes"){
            $id = $_SESSION["USERID"];
            $usrname = $_SESSION['USERNAME'];
            $usremail = $_SESSION["USEREMAIL"];
            $sql = "SELECT * FROM users WHERE id='$id'";
            $result = mysqli_query($con, $sql);
    }else{
        header("location:login.php");
    }


    if(isset($_POST["editsubmit"])){

        $name = mysqli_real_escape_string($con, $_POST["name"]);
        $email = mysqli_real_escape_string($con, $_POST["email"]);
        $hemail = mysqli_real_escape_string($con, $_POST["hemail"]);
        $phone = mysqli_real_escape_string($con, $_POST["phone"]);
        $image = $_FILES["mypic"];
        
       
        if($name == "" || (!preg_match ("/^[a-zA-Z\s]+$/",$name))){
            $nameerr = "Please enter a valid name.";
        }else if($email == ""){
            $emailerr = "Please enter a valid email.";
        }else if($phone == "" && strlen($phone) > 10 || strlen($phone) < 10){
            $pherr = "Please enter a valid phone number.";
        }else{
            $emailsql = "SELECT * FROM users WHERE email='$email'";
            $resquery = mysqli_query($con, $emailsql);

            if(mysqli_num_rows($resquery) > 0){ 
                if($email != $hemail){
                    $emailerr = "This email id is already registered.";
                }else{
                    if($image["name"] == ""){
                        //If user is not uploading an image during edit
                        $updsql = "UPDATE users SET name='$name', email='$email', phone='$phone' WHERE id='$id'";
                        $updres = mysqli_query($con, $updsql);
                        if($updres){
                            $successmsgch = "Successfully Updated Data.";
                        }
                    }else{
                        //If user is uploading an image during edit
                        $imgname = $image['name'];
                        move_uploaded_file($image["tmp_name"], "photos/".$imgname);
                        $updsql = "UPDATE users SET name='$name', email='$email', phone='$phone', image='$imgname' WHERE id='$id'";
                        $updres = mysqli_query($con, $updsql);
                        if($updres){
                            $successmsgch = "Successfully Updated Data.";
                        }
                    }
                }
            }else{
                if($image["name"] == ""){
                    //If user is not uploading an image during edit
                    $updsql = "UPDATE users SET name='$name', email='$email', phone='$phone' WHERE id='$id'";
                    $updres = mysqli_query($con, $updsql);
                    if($updres){
                        $successmsgch = "Successfully Updated Data.";
                    }
                }else{
                    //If user is uploading an image during edit
                    $imgname = $image['name'];
                    move_uploaded_file($image["tmp_name"], "photos/".$imgname);
                    $updsql = "UPDATE users SET name='$name', email='$email', phone='$phone', image='$imgname' WHERE id='$id'";
                    $updres = mysqli_query($con, $updsql);
                    if($updres){
                        $successmsgch = "Successfully Updated Data.";
                    }
                }
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
    <title>Edit Profile Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="totbg">
        <div class="wrapper">
            <a style="float: right;" href="dashboard.php"><i class="fa fa-times topicon" aria-hidden="true"></i></a>
            <h1>Edit Profile</h1>
            <div class="formwrap">
                <?php
                    if(mysqli_num_rows($result) > 0){
                        while($row=mysqli_fetch_assoc($result)){
                ?>
                <form action="editprofile.php" method="POST" enctype="multipart/form-data">
                    <div class="field">
                        <label for="">Name : </label>
                        <input type="text" name="name" value="<?php echo $row["name"]; ?>">
                        <span class="errcls"><?php echo $nameerr; ?></span>
                    </div>
                    <div class="field">
                        <label for="">Email : </label>
                        <input type="email" name="email" value="<?php echo $row["email"]; ?>">
                        <input type="hidden" name="hemail" value="<?php echo $row["email"]; ?>">
                        <span class="errcls"><?php echo $emailerr; ?></span>
                    </div>
                    <div class="field">
                        <label for="">Phone : </label>
                        <input type="tel" name="phone" value="<?php echo $row["phone"]; ?>">
                        <span class="errcls"><?php echo $pherr; ?></span>
                    </div>
                    <div class="field">
                    <label for="">Profile Picture : </label>
                        <input type="file" name="mypic">
                        <span class="errcls"></span>
                    </div>
                    <div class="field btnr">
                        <input type="submit" class="btn" name="editsubmit" value="Save">
                    </div>
                    <div class="field">
                        <span class="succls"><?php echo $successmsgch; ?></span>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>