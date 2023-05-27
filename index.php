<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
    #ques {
        min-height: 433px;
    }
    </style>
    <title>Welcome to iDiscuss - Coding Forums</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        // Insert into thread db
        $cat_title = $_POST['category_name'];
        $cat_desc = $_POST['category_description'];

        $cat_title = str_replace("<", "&lt;", $cat_title);
        $cat_title = str_replace(">", "&gt;", $cat_title); 

        $cat_desc = str_replace("<", "&lt;", $cat_desc);
        $cat_desc = str_replace(">", "&gt;", $cat_desc); 
        
    
        $cat_insert ="SELECT * FROM categories";
        $cat_result=mysqli_query($conn,$cat_insert);
        $duplicapte=false;
        while($row=mysqli_fetch_assoc($cat_result)){
        if($row['category_name']==$cat_title && $row['category_description']==$cat_desc){
            $duplicapte=true;
        }

        }
        if(!$duplicapte && strlen($cat_title)>0 && strlen($cat_desc)>0){
            $sql = "INSERT INTO `categories` (`category_name`, `category_description`, `created`) VALUES ( '$cat_title', '$cat_desc', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showAlert = true;
            if($showAlert){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your category has been added! 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>';
            } 
        }
        elseif(strlen($cat_desc)<0 || strlen($cat_title)<0){
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>failed!</strong> Plese enter the category and description to added!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
        }
        else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>failed!</strong> Your categroy has been already added! Please wait for community to respond
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>';
        }

    }
    ?>

    <!-- Slider starts here -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/slider-5.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/slider-2.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/slider-6.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Category container starts here -->
    <div class="container my-4" id="ques">
        <h2 class="text-center my-4">iDiscuss - Browse Categories</h2>
        <div class="row my-4">
            <!-- Fetch all the categories and use a loop to iterate through categories -->
    <?php 
    $sql = "SELECT * FROM `categories`"; 
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
    // echo $row['category_id'];
    // echo $row['category_name'];
    $id = $row['category_id'];
    $cat = $row['category_name'];
    $desc = $row['category_description'];
    echo '<div class="col-md-4 my-2">
            <div class="card" style="width: 18rem;">
                <img src="img/card-'.$id. '.jpg" class="card-img-top" alt="image for this category">
                <div class="card-body">
                    <h5 class="card-title"><a href="threadlist.php?catid=' . $id . '">' . $cat . '</a></h5>
                    <p class="card-text">' . substr($desc, 0, 90). '... </p>
                    <a href="threadlist.php?catid=' . $id . '" class="btn btn-primary">View Threads</a>
                </div>
            </div>
            </div>';
    } 
    ?>
        </div>
    </div>

    <?php 
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){ 
    echo '<div class="container">
            <h1 class="py-2">Add Category If You Not Found</h1> 
            <form action="'. $_SERVER["REQUEST_URI"] . '" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Category Name</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted">Keep your title as short and crisp as
                        possible</small>
                </div>
                <input type="hidden" name="sno" value="">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Category Description</label>
                    <textarea class="form-control" id="category_description" name="category_description" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>';
    }
    else{
        echo '
        <div class="container">
        <h1 class="py-2">Start a Discussion</h1> 
        <p class="lead">You are not logged in. Please login to be able to start a Discussion</p>
        </div>
        ';
    }

    ?>

    <?php include 'partials/_footer.php';?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>

</html>