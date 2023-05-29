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

<!-- Get thread id to which current thread belongs to-----------------------------------------  -->
<?php
    $id=$_GET['threadid'];
    $sql="SELECT * FROM threads WHERE thread_id=$id";
    $result=mysqli_query($conn,$sql);


    while($row=mysqli_fetch_assoc($result))
    {
       $thread_title=$row['thread_title'];
       $thread_description=$row['thread_description'];
       $thread_id=$row['thread_id'];
       $thread_user_id=$row['thread_user_id'];

       $qry="SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
       $res=mysqli_query($conn,$qry);

       $rows=mysqli_fetch_assoc($res);
    }
?>

<!-- Insert new comments into comments database-----------------------------------------  -->
<?php
    $showAlert=false;
    $method=$_SERVER['REQUEST_METHOD'];
    
    if($method=='POST')
    {
        // Insert thread into db 
        $comment=$_POST['comment'];
        $comment_by=$_SESSION['sno'];

        $table_fetch="SELECT * FROM comments";
        $table_connect=mysqli_query($conn,$table_fetch);

        $showAlert="";

        while($row=mysqli_fetch_assoc($table_connect))
        {
            if($comment_by==$row['comment_by'] && $comment==$row['comment_content'])
            {
                $showAlert="You have commented the same answer previously.";
            }
            else if($comment==NULL )
            {
                $showAlert="Comment cannot be empty";
            }
        }

        if(strlen($showAlert)==0)
        {

            $sql="INSERT INTO `comments` (`comment_content`,`thread_id`,`comment_by`) VALUES ('$comment','$id','$comment_by');";
            $result=mysqli_query($conn,$sql);

            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your comment has been added!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        else
        {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Failed! </strong>'.$showAlert.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
?>

<!-- Thread question and description display header-----------------------------------------  -->
<div class="container my-4">
    <div class="jumbotron">
        <h1 class="display-4"> <?php echo $thread_title ?> </h1>
        <p class="lead"><?php echo $thread_description ?>
            <hr class="my-4">
        <p>This is a peer to peer forum for sharing knowledge with each other. Spam / Advertising / Self promotions are
            strictly not allowed. Do not post copyright infringing content or material. Do not post offensive comments
            or posts. Donot cross post questions . Remain respectful with other members in forum.</p>
        <p class="text-left">Posted by <b><?php echo $rows['user_email'] ?></b></p>
    </div>
</div>

<!-- Form to add comments to thread-----------------------------------------  -->
<?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
    {
        echo '<div class="container" style="margin-bottom: 50px;">
        <h1 class="py-2">Post a comment</h1>
        <form action="'. $_SERVER["REQUEST_URI"].'" method="post">
            <div class="form-group">
                <label for="comment">Type your comment</label>
                <textarea name="comment" id="comment" rows="3" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Post comment</button>
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

<!-- Display already existing comments   -->
<div class="container" style=" min-height:433px">
    <h1>Discussions</h1>

    <?php
        $id=$_GET['threadid'];
        $sql="SELECT * FROM comments WHERE thread_id=$id";
        $result=mysqli_query($conn,$sql);
        $thread_user_id=$_SESSION['sno'];

        $sql2="SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2=mysqli_query($conn,$sql2);

        $row2=mysqli_fetch_assoc($result2);

        $entry=false;

        while($row=mysqli_fetch_assoc($result))
        {
            $entry=true;
            $id=$row['comment_id'];
            $content=$row['comment_content'];
            $comment_time=$row['comment_time'];
            $thread_user_id=$row['comment_by'];

            $sql2="SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2=mysqli_query($conn,$sql2);
    
            $row2=mysqli_fetch_assoc($result2);

            echo ' 
            <div class="d-flex my-3">
                <div class="flex-shrink-0">
                    <img src="./Images/userdefault.jfif" alt="..." width="34px" height="34px">
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="font-weight-bold my-0"><b>'. $row2['user_email'] .' at '. $comment_time .'</b></p>
                    ' . $content . '
                </div>
            </div>';
    
        }

        if(!$entry)
        {
            echo ' 
            <div class="jumbotron jumbotron-fluid">
                 <div class="container">
                     <h1 class="display-4">No Comments found.</h1>
                     <p class="lead">Be the first person to comment .</p>
                 </div>
             </div>';
        }
    ?>
</div>


<!-- Import footer-----------------------------------------   -->
<?php
require "./partials/_footer.php";
?>