<?php
    include './partials/_header.php';
    include './partials/_dbconnect.php';
?>

<div class="container my-4">
    <h1 style="margin-bottom: 10px;">Your Threads</h1>
    <?php
        $thread_user_id=$_SESSION['sno'];
        $sql = "SELECT * FROM threads WHERE thread_user_id=$thread_user_id";
        $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) 
    {
        $thread_title = $row['thread_title'];
        $thread_desc = $row['thread_description'];
        $thread_id = $row['thread_id'];
        $thread_time=$row['timestamp'];
        $thread_user_id=$row['thread_user_id'];

        // Printing existing threads 
        echo ' 
        <div class="d-flex my-3">
            <div class="flex-shrink-0">
                <img src="./Images/userdefault.jfif" alt="..." width="34px" height="34px">
            </div>
            <div class="flex-grow-1 ms-3">
                <h5 class="mt-0"><a href="thread.php?threadid=' . $thread_id . '" class="text-dark" style="text-decoration: none;">' . $thread_title . '</a></h5>
                ' . $thread_desc . '
                <p class="font-weight-bold my-0">Asked at '. $thread_time.'</b></p>
            </div>
        </div>';
    }

    ?>
</div>

<div class="container my-4">
    <h1 style="margin-bottom: 10px;">Your Comments</h1>
    <?php
        $thread_user_id=$_SESSION['sno'];
        $sql = "SELECT * FROM comments WHERE comment_by=$thread_user_id";
        $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) 
    {
        $comment_content = $row['comment_content'];
        $thread_time = $row['comment_time'];

        $query2="SELECT * FROM threads WHERE thread_user_id=$thread_user_id";
        $result2=mysqli_query($conn,$query2);
       
        // Printing existing threads 
        while($roww=mysqli_fetch_assoc($result2))
        {
            $thread_id=$roww['thread_id'];
            $thread_title=$roww['thread_title'];
            $thread_desc=$roww['thread_description'];
            $thread_time=$roww['timestamp'];

            echo ' 
            <div class="d-flex my-3">
                <div class="flex-shrink-0">
                    <img src="./Images/userdefault.jfif" alt="..." width="34px" height="34px">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h5 class="mt-0"><a href="thread.php?threadid=' . $thread_id . '" class="text-dark" style="text-decoration: none;">'. $thread_title . '</a></h5><b> Thread Description :  </b>
                    ' . $thread_desc . '
                    <p class="font-weight-bold my-0"><b> Your comment :</b> '.$comment_content.'</b><br> at '. $thread_time .' </p>
                </div>
            </div>';
        }
    }
    ?>
</div>