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

<?php
require "./partials/_header.php";
?>

<!-- Search results  -->
<div class="container" style="margin-bottom: 40px;">
    <h2 class="text-center" style="margin-top: 40px; margin-bottom: 30px;">Search Results</h2>
    <div class="row">

        <!-- Fetching all categories  -->
        <?php
            require "./partials/_dbconnect.php";

            $category_name=$_GET['search'];
            $sql="SELECT * FROM categories WHERE category_name LIKE '%$category_name%'";
            $result=mysqli_query($conn,$sql);

            while($row=mysqli_fetch_assoc($result))
            {
                $cat=$row['category_name'];
                $cat_id=$row['category_id'];
               echo '<div class="col-md-4  my-2">
                    <div class="card" style="width: 25rem; height:600px">
                        <img src="https://source.unsplash.com/500x400/?'.$cat.',code" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><a href="threadlist.php?catid='.$cat_id.'">'.$cat.'</a></h5>
                            <p class="card-text">'.$row['category_description'].'</p>
                            <a href="threadlist.php?catid='.$cat_id.'" class="btn btn-primary">View threads</a>
                        </div>
                    </div>
                </div>';
            }
        ?>

    </div>
</div>

<!-- Import footer-----------------------------------------   -->
<?php
require "./partials/_footer.php";
?>