<!DOCTYPE HTML>
<html>
<head>
    <title>Networked Appetite </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles/style.css" type="text/css">
</head>
<?php
//Navigation Area
include('base/navbar.php');
?>
<!---slider area---->

<body>
    <div id="slider-container" class="container-fluid">
        <ul>
            <li>
                <input type="radio" checked="checked" name="slide" id="slide-image-1">
                <div class="slide">
                    <img src="images/homepage_image/homepage_slider/vegetables.jpg">
                    <div class="content">
                        <a class="button button-hero" href="shop.php">Fill Your Appetite Now</a>
                    </div>
                </div>
            </li>
            <li>
                <input type="radio" name="slide" id="slide-image-2">
                <div class="slide">
                    <img src="images/homepage_image/homepage_slider/delicateness.jpg">
                    <div class="content">
                        <a class="button button-hero" href="shop.php">Fill Your Appetite Now</a>
                    </div>
                </div>
            </li>
            <li>
                <input type="radio" name="slide" id="slide-image-3">
                <div class="slide">
                    <img src="images/homepage_image/homepage_slider/meat.jpg">
                    <div class="content">
                        <a class="button button-hero" href="shop.php">Fill Your Appetite Now</a>
                    </div>
                </div>
            </li>
            <li>
                <input type="radio" name="slide" id="slide-image-4">
                <div class="slide">
                    <img src="images/homepage_image/homepage_slider/bakery.jpg">
                    <div class="content">
                        <a class="button button-hero" href="shop.php">Fill Your Appetite Now</a>
                    </div>
                </div>
            </li>
            <li>
                <input type="radio" name="slide" id="slide-image-5">
                <div class="slide">
                    <img src="images/homepage_image/homepage_slider/seafood.jpg">
                    <div class="content">
                        <a class="button button-hero" href="shop.php">Fill Your Appetite Now</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <!---Product Details----->
    <div class="container" data-aos="fade-up" style="margin-top:50px;">
        <div class="row">
            <div class="col-md-3">
                <div class="abouticon">
                    <i class="fas fa-shipping-fast fa-4x about"></i>
                    <h5>FAST DELIVERY</h5>
                    <p>ON TIME FOOD DELIVERY</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="abouticon">
                    <i class="fas fa-seedling fa-4x about"></i>
                    <h5>ALWAYS FRESH</h5>
                    <p>DIRECTLY FROM LOCALS</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="abouticon">
                    <i class="fas fa-award fa-4x about"></i>
                    <h5>SUPERIOR QUALITY</h5>
                    <p>QUALITY PRODUCTS</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="abouticon">
                    <i class="fas fa-info-circle fa-4x about"></i>
                    <h5>SUPPORT</h5>
                    <p>24/7 SUPPORT</p>
                </div>
            </div>
        </div>
    </div>
    <!---End Product Details----->

    <!---Product Details----->
    <div class="container">
        <div class="row" data-aos="fade-up" data-aos-duration="2200">
            <div class="col-md-4" data-aos="flip-right">
                <img class="moredetails" src="images/homepage_image/fruits.jpg">
            </div>
            <div class="col-md-4 word" data-aos="zoom-out-down" data-aos-duration="2200">
                <h4>Networked Appetite</h4>
                <p>Never go hungry again.</p>
            </div>
            <div class="col-md-4" data-aos="flip-left" data-aos-duration="2200">
                <img class="moredetails" src="images/homepage_image/cereals.jpg">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4" data-aos="flip-right" data-aos-duration="2200">
                <img class="moredetails" src="images/homepage_image/seafood.jpg">
            </div>
            <div class="col-md-4" data-aos="zoom-in-up" data-aos-duration="2200">
                <img class="moredetails" src="images/homepage_image/donuts.jpg">
            </div>
            <div class="col-md-4" data-aos="flip-left" data-aos-duration="2200">
                <img class="moredetails" src="images/homepage_image/vegetables.jpg">
            </div>
        </div>
    </div>
    <div class="emptyspace">

    </div>
    <!---Product Images Start-->
    <div class="container" data-aos="fade-up" data-aos-duration="1000">
        <div class="row">
            <div class="col-md-12 productabout " style="text-align: center;">
                <h1>Featured Products</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="outline list1">
                    <img class="prod" src="images/homepage_image/homepage_products/bakery1.png">
                    <span class="status">10%</span>
                    <div class="data l1">
                        <h3>Cup Cakes</h3>
                        <p>£2.00</p>
                        <a href=""><i class="fas fa-th-list"></i></a>
                        <a href="login.php"><i class="fas fa-cart-plus"></i></a>
                        <a href=""><i class="fas fa-heart"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="outline list2">
                    <img class="prod" src="images/homepage_image/homepage_products/meat1.png">
                    <div class="data l2">
                        <h3>Beef Meat</h3>
                        <p>£13.75</p>
                        <a href=""><i class="fas fa-th-list"></i></a>
                        <a href="login.php"><i class="fas fa-cart-plus"></i></a>
                        <a href=""><i class="fas fa-heart"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="outline list3">
                    <img class="prod" src="images/homepage_image/homepage_products/donut.png">
                    <span class="status">15%</span>
                    <div class="data l3">
                        <h3>Donuts</h3>
                        <p>£1.75</p>
                        <a href=""><i class="fas fa-th-list"></i></a>
                        <a href="login.php"><i class="fas fa-cart-plus"></i></a>
                        <a href=""><i class="fas fa-heart"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="outline list4">
                    <img class="prod" src="images/homepage_image/homepage_products/fruits.png">
                    <span class="status">5%</span>
                    <div class="data l4">
                        <h3>Seasonal Fruits</h3>
                        <p>£7.56</p>
                        <a href=""><i class="fas fa-th-list"></i></a>
                        <a href="login.php"><i class="fas fa-cart-plus"></i></a>
                        <a href=""><i class="fas fa-heart"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="outline list5">
                    <img class="prod" src="images/homepage_image/homepage_products/cucumber-tomato.png">
                    <div class="data l5">
                        <h3>Tomato/Cucumber</h3>
                        <p>£0.95</p>
                        <a href=""><i class="fas fa-th-list"></i></a>
                        <a href="login.php"><i class="fas fa-cart-plus"></i></a>
                        <a href=""><i class="fas fa-heart"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="outline list6">
                    <img class="prod" src="images/homepage_image/homepage_products/salmon.png">
                    <span class="status">10%</span>
                    <div class="data l6">
                        <h3>Salmon Fish</h3>
                        <p>£15.37</p>
                        <a href=""><i class="fas fa-th-list"></i></a>
                        <a href="login.php"><i class="fas fa-cart-plus"></i></a>
                        <a href=""><i class="fas fa-heart"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="outline list7">
                    <img class="prod" src="images/homepage_image/homepage_products/chicken.png">

                    <div class="data l7">
                        <h3>Chicken Meat</h3>
                        <p>£9.05</p>
                        <a href=""><i class="fas fa-th-list"></i></a>
                        <a href="login.php"><i class="fas fa-cart-plus"></i></a>
                        <a href=""><i class="fas fa-heart"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="outline list8">
                    <img class="prod" src="images/homepage_image/homepage_products/processed_meat.png">
                    <span class="status">5%</span>
                    <div class="data l8">
                        <h3>Processed Meat</h3>
                        <p>£11.07</p>
                        <a href=""><i class="fas fa-th-list"></i></a>
                        <a href="login.php"><i class="fas fa-cart-plus"></i></a>
                        <a href=""><i class="fas fa-heart"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid news">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <h2>Subcribe to our Newsletter</h2>
                <p>Get e-mail updates about our latest shops and special offers</p>
            </div>
            <div class="col-md-6">
            <?php
            if(isset($_POST['submit'])){
                echo'<script>alert("Email '.$_POST["email"].' is now subscribed for newsletters. Thank you.")</script>';
                echo"<script>setTimeout(function() {window.location.href= 'index.php';}, 1000);</script>";
            }
            ?>
                <form action="" method="POST">
                    <input type="text" name="email" placeholder="Enter Email Address">
                    <button type="submit" name="submit">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
    <!---Product Images End-->
    <?php
    //Footer Area
    include('base/footer.php');
    ?>
</body>
<script src="js/functions.js"></script>
</html>