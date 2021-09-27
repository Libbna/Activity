<?php
require_once "includes/database.php";
require_once "includes/createpost_validate.php";
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="http://blog/">
    <link href="includes/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/7ed99e45ec.js" crossorigin="anonymous"></script>

</head>

<body style="transform:none">
    <div class="homepage-header-wrapper">
        <header>
            <div class='logo'>
                <h3>Vozga</h3>
            </div>
            <div class="search-form">
                <div class="form-toggle">
                    <form action="search.php" method="get">
                        <input class="search-text" type="text" name="search" placeholder="Search" autocomplete="off" autofocus><span class="hide"><i class="fas fa-times"></i></span>
                    </form>
                </div>
                <div class="icon">
                    <span class="show"><i class="fas fa-search" style="color:white; font-size: 14px;font-weight: 600;"></i></span>
                </div>
            </div>

            <img class='hamburger' src='images/hamburger.png' alt='hamburger'></img>
            <ul class='list'>
                <li class="sub-list"><a>Category<i class="fas fa-chevron-down" style="color:white; font-size: 14px; font-weight: 600; padding:5px;"></i></a>
                    <ul>
                        <li><a href="category.php/Food">Food</a></li>
                        <li><a href="category.php/Music">Music</a></li>
                        <li><a href="category.php/Sports">Sports</a></li>
                        <li><a href="category.php/Gymnastics">Gymnastics</a></li>
                        <li><a href="category.php/Travel">Travel</a></li>
                    </ul>
                </li>
                <li><a href='homepage'>Home</a></li>
                <li><a href='register'>Register</a></li>
                <li><a href='login'>Login</a></li>
            </ul>
        </header>
    </div>
    <script>
        const button = document.querySelector('.icon');
        const search = document.querySelector('.form-toggle');
        const navBar = document.querySelector('.list');
        const hideBtn = document.querySelector('.hide');
        button.onclick = function() {
            search.classList.remove('inactive');
            search.classList.toggle('active');
            navBar.classList.toggle('inactive');
            navBar.classList.remove('active');
        }
        hideBtn.onclick = function() {
            search.classList.remove('active');
            search.classList.toggle('inactive');
            navBar.classList.toggle('active');
            navBar.classList.remove('inactive');
        }
    </script>
    <script src='script.js'></script>
    <title>Homepage</title>
    <div class='slider-wrapper'>
        <?php
        $sql = "SELECT * FROM banners";
        $result = mysqli_query($con, $sql);
        $i = 0;
        if (mysqli_num_rows($result) > $i) {
            while ($images = mysqli_fetch_assoc($result)) {
                $input_image = "images/" . $images['image'];
                $output_image = "images/resized/" . $images['image'];
                $width = 1600;
                $height = 832;
                $resource = imagecreatefromjpeg($input_image);
                $scaled = imagescale($resource, $width, $height);
                imagejpeg($scaled, $output_image);
        ?>
                <div class="post-slider" style="background-image: url(<?php echo $output_image; ?>)">
                    <div class="post-wrapper" style="background-color: rgba(0,0,0,0.25);">
                        <div class="post">
                            <div class="wrapper">
                                <div class="intro-wrapper">
                                    <div class="intro-head">
                                        <h3><?php echo $images['banner_title']; ?></h3>
                                    </div>
                                    <div class="intro-text">
                                        <p><?php echo $images['banner_snippet']; ?></p>
                                    </div>
                                    <div class="intro-button">
                                        <a class="btn">Get Started</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--post end-->
                    </div><!-- post wrapper end-->
                </div>
        <?php
                $i = $i + 1;
            }
        }
        ?>

    </div><!-- slider wrapper end-->
    <div class='content clear'>
        <div class='main_content'>
            <?php
            $results_per_page = 6;
            if (isset($_POST['pg-num'])) {
                $results_per_page = $_POST['pg-num'];
            } else {
                $results_per_page = 6;
            }
            $sql = "SELECT * FROM posts";
            $result = mysqli_query($con, $sql);
            $i = 0;
            $num_of_result = mysqli_num_rows($result);
            $num_of_pages = ceil($num_of_result / $results_per_page);
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }
            $start_limit = ($page - 1) * $results_per_page;
            $sql = "SELECT * FROM posts LIMIT " . $start_limit . ',' . $results_per_page;
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > $i) {
                while ($data = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="main-post">
                        <?php
                        $input_image = "images/" . $data['image'];
                        $output_image = "images/resized" . $data['image'];
                        $width = 408;
                        $height = 220;
                        $resource = imagecreatefromjpeg($input_image);
                        $scaled = imagescale($resource, $width, $height);
                        imagejpeg($scaled, $output_image);
                        $desc = $data['description'];
                        $desc = substr($desc, 0, 100) . '...';
                        ?>
                        <img class="image" src="<?php echo $output_image; ?>" , alt="post_image"><a href="category/<?php echo $data['category']; ?>" class="post-category"><?php echo $data['category']; ?></a>
                        <div class="post-preview-wrapper">
                            <a href="single/<?php echo $data['p_id']; ?>" class="post-title"><?php echo $data['title']; ?></a>
                            <div class="post-preview">
                                <span class="author-name"><i class="fas fa-user"></i>Name</span>
                                <span class="post-date"><i class="fas fa-calendar-week">Date</i></span>
                                <p class="desc"><?php echo $desc; ?></p>
                            </div>
                        </div>
                    </div>

</div><!-- slider wrapper end-->
<div class='content clear'>
<div class='main_content'>
    <?php
        $results_per_page=6;
        if(isset($_POST['pg-num'])){
            $results_per_page=$_POST['pg-num'];
        }
        else{
            $results_per_page=6;
        }
        $sql="SELECT * FROM posts";
        $result=mysqli_query($con,$sql);
        $i=0;
        $num_of_result=mysqli_num_rows($result);    
        $num_of_pages=ceil($num_of_result/$results_per_page);
        if(!isset($_GET['page'])){
            $page=1;
        }else{
            $page=$_GET['page'];
        }
        $start_limit=($page-1)*$results_per_page;
        $sql="SELECT login.username FROM login JOIN posts WHERE (login.id = posts.user_id)";
        $result=mysqli_query($con,$sql);
        if(mysqli_num_rows($result) > $j){
            while($authName=mysqli_fetch_assoc($result)){  
                $author=$authName['username'];
                $j=$j+1;
            }
        }  
        $sql="SELECT * FROM posts LIMIT ".$start_limit.','.$results_per_page;
        $result=mysqli_query($con,$sql);
        if(mysqli_num_rows($result) > $i){
            while($data=mysqli_fetch_assoc($result)){
    ?>
    <div class="main-post">
        <?php 
             $input_image="images/".$data['image'];
             $output_image="images/resized/".$data['image'];
             $width=408;
             $height=220;
             $resource=imagecreatefromjpeg($input_image);
             $scaled=imagescale($resource, $width, $height);
             imagejpeg($scaled,$output_image);
             $desc=$data['description'];
             $desc = substr($desc,0,100).'...';             
        ?>
        <img class="image" src="<?php echo $output_image;?>", alt="post_image"><a href="category/<?php echo $data['category'];?>" class="post-category"><?php echo $data['category']; ?></a>
        <div class="post-preview-wrapper">
            <a href="single/<?php echo $data['p_id'];?>" class="post-title"><?php echo $data['title'];?></a>
            <div class="post-preview">
                    <span class="author-name"><i class="fas fa-user"></i><?php echo $author; ?></span>
                    <span class="post-date"><i class="fas fa-calendar-week">Date</i></span>
                    <p class="desc"><?php echo $desc; ?></p>
                </div>
        </div>
    </div>
    <?php 
        }
    }
        
    ?>
    <center>
    <div class='index-homepage'>

            <?php
                }
            }

            ?>
            <center>
                <div class='index-homepage'>
                    <?php
                    for ($page = 1; $page <= $num_of_pages; $page++) {
                        echo '<a href="homepage/' . $page . '">' . $page . '</a> ';
                    }   ?>
                </div>
            </center>

        </div>

        <div class="side-content">
            <div class="side-posts">
                <div class="social">
                    <h2 class="social-title">Social</h2>
                    <ul class="social-icons">
                        <li class="fb"><i class="fab fa-facebook-f"></i></li>
                        <li class="tw"><i class="fab fa-twitter"></i></li>
                        <li class="ln"><i class="fab fa-linkedin-in"></i></li>
                        <li class="rd"><i class="fab fa-reddit"></i></li>
                        <li class="pn"><i class="fab fa-pinterest"></i></li>
                        <li class="vk"><i class="fab fa-vk"></i></li>
                        <li class="ins"><i class="fab fa-instagram"></i></li>
                        <li class="yt"><i class="fab fa-youtube"></i></li>
                        <li class="wt"><i class="fab fa-whatsapp"></i></li>
                        <li class="rss"><i class="fas fa-rss"></i></li>
                    </ul>
                </div>
                <div class="popular-post-wrapper">
                    <div class="popular-posts-title">
                        <h2>Popular posts</h2>
                    </div>
                    <div class="popular-post">
                        <?php
                        $sql = "SELECT * FROM posts LIMIT 0,3";
                        $result = mysqli_query($con, $sql);
                        if (mysqli_num_rows($result) > $i) {
                            while ($data = mysqli_fetch_assoc($result)) {
                        ?>
                                <?php
                                $input_image = "images/" . $data['image'];
                                $output_image = "images/resized/" . $data['image'];
                                $width = 75;
                                $height = 60;
                                $resource = imagecreatefromjpeg($input_image);
                                $scaled = imagescale($resource, $width, $height);
                                imagejpeg($scaled, $output_image);
                                ?>
                                <img src="<?php echo $output_image; ?>" alt="" class="popular-image">
                                <h3 class="popular-post-title"><?php echo $data['title']; ?></h3>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="subscribe-wrapper">
                    <div class="subscribe">
                        <h2>Subscribe Us</h2>
                    </div>
                    <div class="subscribe-video">
                        <div class="video-wrap">
                            <iframe width="284" height="130" src="https://www.youtube.com/embed/CY4hLz87hu4" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="facebook-wrapper">
                    <div class="facebook">
                        <h2>Facebook</h2>
                    </div>
                    <div class="facebook-page">
                        <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fway2themes%2Fposts%2F731449897061662&show_text=true&width=500" width="285" height="150" style="border:none;overflow:hidden;padding:10px" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                    </div>
                </div>
                <div class="side-category-wrapper">
                    <div class="side-category">
                        <h2>Category</h2>
                    </div>
                    <ul class="categories">
                        <li>><a href="category.php?category=Food">Food<span class="count">(1) </span></a></li>
                        <li>><a href="category.php?category=Music">Music<span class="count">(1) </span></a></li>
                        <li>><a href="category.php?category=Sports">Sports<span class="count">(1) </span></a></li>
                        <li>><a href="category.php?category=Gymnastics">Gymnastics<span class="count">(1) </span></a></li>
                        <li>><a href="category.php?category=Travel">Travel<span class="count">(1) </span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.slider-wrapper').slick();
    </script>
    <?php
    </center>
    
</div>
<?php include('includes/side_content.php')?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('.slider-wrapper').slick();
</script>
<?ph
    require "includes/footer2.php";
    ?>