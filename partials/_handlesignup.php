<?php
    include './_dbconnect.php';
    
    $showError="false";
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $user_email=$_POST['signupEmail'];
        $user_password=$_POST['signupPassword'];
        $cpassword=$_POST['signupcPassword'];

        $exists="SELECT * FROM `users` WHERE `user_email`='$user_email'";
        $result=mysqli_query($conn,$exists);

        if(mysqli_num_rows($result)>0)
        {
            $showError="Email already in use.";
        }
        else
        {
            if($user_password==$cpassword)
            {
                $hash=password_hash($user_password,PASSWORD_DEFAULT);
                $sql="INSERT INTO `users` (`user_email`,`user_password`) VALUES ('$user_email','$hash')";

                $result=mysqli_query($conn,$sql);

                if($result)
                {
                    $showError=true;
                    header("Location: /forum/index.php?signupsuccess=true&showError=false");
                    exit();
                }
            }
            else
            {
                $showError="Passwords donot match!";
            }
            header("Location: /forum/index.php?signupsuccess=false&error=$showError");
            exit();
        }
        header("Location: /forum/index.php");
    }
?>