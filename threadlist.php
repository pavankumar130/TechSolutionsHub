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
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" cros sorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script>
</body>

</html>

<!-- Import header-----------------------------------------   -->
<?php
require "./partials/_header.php";
require "./partials/_dbconnect.php";
?>

<!-- Get category id to which threads belong to-----------------------------------------  -->
<?php
$id = $_GET['catid'];
$sql = "SELECT * FROM categories WHERE category_id=$id";
$result = mysqli_query($conn, $sql);


while ($row = mysqli_fetch_assoc($result)) {
    $cat_name = $row['category_name'];
    $cat_desc = $row['category_description'];
}
?>

<!-- Insert new threads-----------------------------------------  -->
<?php
    $showAlert=false;
    $method=$_SERVER['REQUEST_METHOD'];
    
    if($method=='POST')
    {
        // Insert thread into db 
        $thread_title=$_POST['title'];
        $thread_description=$_POST['desc'];
        $thread_user_id=$_SESSION['sno'];

        $table_fetch="SELECT * FROM `threads`";
        $table_connect=mysqli_query($conn,$table_fetch);

        $duplicate=false;
        $showAlert="";

        while($row=mysqli_fetch_assoc($table_connect))
        {
            if($thread_description==$row['thread_description'] && $thread_title==$row['thread_title'] && $thread_user_id==$row['thread_user_id'])
            {
                $duplicate=true;
                $showAlert="You have already posted a thread with same title and description";
            }
            else if($thread_description==NULL or $thread_title==NULL)
            {
                $duplicate=true;
                $showAlert="Title , Description cannot be empty.";
            }
        }

        if($duplicate==false)
        {
            $sql="INSERT INTO `threads` (`thread_title`,`thread_description`,`thread_category_id`,`thread_user_id`) VALUES
            ('$thread_title','$thread_description','$id','$thread_user_id')";

            $result=mysqli_query($conn,$sql);

            if( strlen($showAlert)==0 )
            {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your query has been added! Please wait for community to respond
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        }
        else
        {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Success!</strong> '.$showAlert.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    }
?>


<!-- Wecome header to forums-----------------------------------------  -->
<div class="container my-4">
    <div class="jumbotron">
        <h1 class="display-4">Welcome to <?php echo $cat_name ?> forums</h1>
        <p class="lead"><?php echo $cat_desc ?>
            <hr class="my-4">
        <p>This is a peer to peer forum for sharing knowledge with each other. Spam / Advertising / Self promotions are
            strictly not allowed. Do not post copyright infringing content or material. Do not post offensive comments
            or posts. Donot cross post questions . Remain respectful with other members in forum.</p>
        <a href="#" role="button" class="btn btn-success btn-lg">Learn more</a>
    </div>
</div>

<!-- Form to add a new thread-----------------------------------------  -->
<?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
    {
        echo '<div class="container" style="margin-bottom: 50px;">
        <h1 class="py-2">Start a discussion</h1>
        <form action="'. $_SERVER["REQUEST_URI"] .'" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" aria-describedby="emailHelp" name="title">
                <div id="title" class="form-text">Keep your title as crisp and short as possible.</div>
            </div>
            <div class="form-group">
                <label for="desc">Elaborate your problem</label>
                <textarea name="desc" id="desc" rows="3" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>';
    }
    else
    {
        echo '<div class="container">
            <div style="margin-bottom: 5px;">
                <h1 class="py-2">Post a comment</h1>
            </div>
            <p class="lead">
               You are not logged in. Please login to comment on this thread.
            </p>
        </div>';
    }
?>

<!-- Display existing threads-----------------------------------------  -->
<div class="container" style=" min-height:433px">
    <h1 style="margin-bottom: 10px;">Browse questions</h1>
    <?php
    $sql = "SELECT * FROM threads WHERE thread_category_id=$id";
    $result = mysqli_query($conn, $sql);

    $entry = false;

    while ($row = mysqli_fetch_assoc($result)) 
    {
        $thread_title = $row['thread_title'];
        $thread_desc = $row['thread_description'];
        $thread_id = $row['thread_id'];
        $thread_time=$row['timestamp'];
        $thread_user_id=$row['thread_user_id'];

        $sql2="SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2=mysqli_query($conn,$sql2);

        $row2=mysqli_fetch_assoc($result2);

        // Printing existing threads 
        echo ' 
        <div class="d-flex my-3">
            <div class="flex-shrink-0">
                <img src="./Images/userdefault.jfif" alt="..." width="34px" height="34px">
            </div>
            <div class="flex-grow-1 ms-3">
                <h5 class="mt-0"><a href="thread.php?threadid=' . $thread_id . '" class="text-dark" style="text-decoration: none;">' . $thread_title . '</a></h5>
                ' . $thread_desc . '
                <p class="font-weight-bold my-0">Asked by <b>'.$row2['user_email'].'  at '. $thread_time.'</b></p>
            </div>
        </div>';

        $entry = true;
    }

    if (!$entry) 
    {
        echo ' 
       <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">No Threads found.</h1>
                <p class="lead">Be the first person to ask question
                on ' . $cat_name . ' .</p>
            </div>
        </div>';
    }
    ?>
</div>



<!-- Import footer-----------------------------------------   -->
<?php
require "./partials/_footer.php";
?>