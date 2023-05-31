<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TechSolutionsHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script>

</body>

</html>

<?php

session_start();

// Navbar starts here  
echo ' <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
    <a class="navbar-brand" href="/forum/index.php">TechOverflow</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/forum/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/forum/about.php">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/forum/addcategory.php">Add Category</a>
            </li>
        </ul>
        <div class="row mx-2">
        <form action="search.php" class="d-flex my-2 my-lg-0" role="search" method="get">
            <input name="search" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success" type="submit">Search</button>
            </form>
        </div>';

        // Removing login and signup options from navbar after login 
        if(isset($_SESSION['loggedin']) and $_SESSION['loggedin']=true)
        {
            echo '
            <a href="/forum/user.php" role="button" class="btn btn-danger ml-2">'.$_SESSION['user_email'].'</button>
            <a href="/forum/partials/_logout.php" role="button" class="btn btn-outline-success mx-2">Logout</a>';
        }
        else
        {
            echo '
            <button class="btn btn-outline-success ml-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <button class="btn btn-outline-success mx-2" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>';
        }

        echo ' </div>
            </div>
    </nav>';

    include "./partials/_loginModal.php";
    include "./partials/_signupModal.php";

    // Handling sign up 
    if(isset($_GET['signupsuccess'])==true)
    {
        if( $_GET['signupsuccess']=="false")
        {
            $showError=$_GET['error'];
            echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
            <strong>Signup Failed!</strong>'.$showError.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'; 
        }
        else
        {
            echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong> Your account has been created.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
    // Handling login 
    else if(isset($_GET['loginsuccess'])==true)
    {
        if($_GET['loginsuccess']=="true" and $_GET['error']=="false")
        {
            echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong> You are now logged in.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        else
        {
            $showError=$_GET['error'];
            echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
            <strong>Login Failed!</strong>'.$showError.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'; 
        }
    }
?>