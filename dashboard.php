<?php
    include("connection.inc.php");

    session_start();
    if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == "yes"){
            $id = $_SESSION["USERID"];
            $name = $_SESSION['USERNAME'];
            $email = $_SESSION["USEREMAIL"];
            $sql = "SELECT * FROM users WHERE id='$id'";
            $res = mysqli_query($con, $sql);
    }else{
        header("location:login.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dasbg">
        <div class="wrapperdsb">
        <h3>Personal Information</h3>
        <?php
            if(mysqli_num_rows($res) > 0){
                $row = mysqli_fetch_assoc($res);
        ?>
        <div class="profilepic">
            <img title="Profile picture of <?php echo $row["name"]; ?>" src="photos/<?php echo $row['image']; ?>" alt="profile picture">
        </div>
        <div class="field">
            <h4>Name</h4><hr>
            <p><?php echo $row["name"]; ?></p>
        </div>
        <div class="field">
            <h4>Email Address</h4><hr>
            <p><?php echo $row["email"]; ?></p>
        </div>
        <div class="field">
            <h4>Phone Number</h4><hr>
            <p><?php echo $row["phone"]; ?></p>
        </div>
        <br>
        <div class="fielddsb">
            <a href="logout.php" class="btn">Logout</a>
            <a href="editprofile.php" class="btn">Edit Profile</a>
        </div>
        <?php
            }
        ?>
        </div>
    </div>
</body>
</html>