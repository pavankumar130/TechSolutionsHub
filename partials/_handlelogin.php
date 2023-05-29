<?php
    include "./_dbconnect.php";

    $showError="false";

    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $email=$_POST['loginEmail'];
        $password=$_POST['loginPassword'];

        $query="SELECT * FROM `users` WHERE `user_email`='$email'";
        $result=mysqli_query($conn,$query);

        if(mysqli_num_rows($result)>0)
        {
            while($row=mysqli_fetch_assoc($result))
            {
                if(password_verify($password,$row['user_password']))
                {
                    session_start();
                    $_SESSION['loggedin']=true;
                    $_SESSION['user_email']=$email;
                    $_SESSION['sno']=$row['sno'];

                    header("Location: /forum/index.php?loginsuccess=true&error=$showError");
                    exit();
                }
            }

            $showError="Username and password donot match !";
        }
        else
        {
            $showError="No user exists with this email";
        }
        header("Location: /forum/index.php?loginsuccess=false&error=$showError");
        exit();
    }
    header("Location: /forum/login.php");
?>