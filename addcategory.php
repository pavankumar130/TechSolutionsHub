
<?php
    include "./partials/_header.php";
    include "./partials/_dbconnect.php";
?>

<!-- Insert into categories table  -->
<?php
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $category_name=$_POST['category_name'];
        $category_description=$_POST['category_description'];

        $duplicate=false;
        $table_fetch="SELECT * FROM `categories`";
        $table_connect=mysqli_query($conn,$table_fetch);

        while($row=mysqli_fetch_assoc($table_connect))
        {
            if($category_name==$row['category_name'])
            {
                $duplicate=true;
            }
        }

        if($duplicate==false && $table_connect && strlen($category_name)>0 && strlen($category_description)>0)
        {
            $qry="INSERT INTO `categories`(`category_name`, `category_description`) VALUES ('$category_name','$category_description')";
            $res=mysqli_query($conn,$qry);

            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Success! </strong> Category has been added.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        else if($duplicate)
        {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Failed ! </strong> Category  already exists.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        else if(strlen($category_name)>0 && strlen($category_description)>0)
        {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Failed ! </strong> Server is busy right now. Please try again later.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        else
        {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Failed ! </strong> Category name and description cannot be empty.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';   
        }
    }
?>

<!-- Form to add a new thread-----------------------------------------  -->
<?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
    {
        echo '<div class="container" style="margin-bottom: 50px;">
        <h1 class="py-2">Add Category</h1>
        <form action="'. $_SERVER["REQUEST_URI"] .'" method="post">
            <div class="mb-3">
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="category_name" aria-describedby="emailHelp" name="category_name">
                <div id="title" class="form-text">Keep your title as crisp and short as possible.</div>
            </div>
            <div class="form-group">
                <label for="category_description">Category Description</label>
                <textarea name="category_description" id="category_description" rows="3" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Add category</button>
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
               You are not logged in. Please login to add a category.
            </p>
        </div>';
    }
?>