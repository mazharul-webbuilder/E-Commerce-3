<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Netel Mart</title>

    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/bootstrap.css')}}" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{asset('frontend/css/style.css')}}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{asset('frontend/css/responsive.css')}}" rel="stylesheet" />
</head>

<body>

<div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
        <div class="container">
            <nav class="navbar navbar-expand-lg custom_nav-container ">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset(setting()->game_logo) }}" alt="ssss">
                    <span>
            </span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="s-1"> </span>
                    <span class="s-2"> </span>
                    <span class="s-3"> </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
                        <ul class="navbar-nav  ">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> Service </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> Blog </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Contact </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <!-- end header section -->
    <!-- slider section -->
    <section class=" slider_section ">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ">
                    <div class="detail_box">
                        <h1>
                            Netel Mart <br>
                            Ecoomerce Platform
                        </h1>
                        <p>
                            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem
                        </p>
                        <a href="" class="">
                            Contact Us
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 offset-lg-1">
                    <div class="img_content">
                        <div class="img_container">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="img-box">
                                            <img src="{{asset('frontend/images/slider-img.jpg')}}" alt="">
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="img-box">
                                            <img src="{{asset('frontend/images/slider-img.jpg')}}" alt="">
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="img-box">
                                            <img src="{{asset('frontend/images/slider-img.jpg')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- end slider section -->
</div>


<!-- service section -->
<section class="service_section layout_padding">
    <div class="container">
        <div class="heading_container">
            <h2>
                Our Services
            </h2>
            <img src="{{asset('frontend/images/plug.png')}}" alt="">
        </div>

        <div class="service_container">
            <div class="box">
                <div class="img-box">
                    <img src="{{asset('frontend/images/s1.png')}}" class="img1" alt="">
                </div>
                <div class="detail-box">
                    <h5>
                        Ludo Game
                    </h5>
                    <p>
                        There are many variations of passages of Lorem Ipsum available,
                    </p>
                </div>
            </div>
            <div class="box active">
                <div class="img-box">
                    <img src="{{asset('frontend/images/s2.png')}}" class="img1" alt="">
                </div>
                <div class="detail-box">
                    <h5>
                        Share Holders
                    </h5>
                    <p>
                        There are many variations of passages of Lorem Ipsum available,
                    </p>
                </div>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="{{asset('frontend/images/s3.png')}}" class="img1" alt="">
                </div>
                <div class="detail-box">
                    <h5>
                        Club Owner
                    </h5>
                    <p>
                        There are many variations of passages of Lorem Ipsum available,
                    </p>
                </div>
            </div>
            <div class="box ">
                <div class="img-box">
                    <img src="{{asset('frontend/images/s4.png')}}" class="img1" alt="">
                </div>
                <div class="detail-box">
                    <h5>
                        Commission Distribution
                    </h5>
                    <p>
                        There are many variations of passages of Lorem Ipsum available,
                    </p>
                </div>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="{{asset('frontend/images/s5.png')}}" class="img1" alt="">
                </div>
                <div class="detail-box">
                    <h5>
                        Netel Mart Ecommerce
                    </h5>
                    <p>
                        There are many variations of passages of Lorem Ipsum available,
                    </p>
                </div>
            </div>
        </div>
        <div class="btn-box">
            <a href="">
                Read More
            </a>
        </div>
    </div>
</section>
<!-- end service section -->

<!-- about section -->
<section class="about_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="detail-box">
                    <div class="heading_container">
                        <h2>
                            About Us
                        </h2>
                        <img src="{{asset('frontend/images/plug.png')}}" alt="">
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                        enim ad minim veniam, quis nostrud exercitation ullamco laboris
                        nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                        in reprehenderit in voluptate velit
                    </p>
                    <a href="">
                        Read More
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="img_container">
                    <div class="img-box b1">
                        <img src="{{asset('frontend/images/about-img1.jpg')}}" alt="" />
                    </div>
                    <div class="img-box b2">
                        <img src="{{asset('frontend/images/about-img2.jpg')}}" alt="" />
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<section class="blog_section layout_padding">
    <div class="container">
        <div class="heading_container">
            <h2>
                Blog
            </h2>
            <img src="{{asset('frontend/images/plug.png')}}" alt="">
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="img-box">
                        <img src="{{asset('frontend/images/blog1.jpg')}}" alt="">
                    </div>
                    <div class="detail-box">
                        <h5>
                            Blog Title Goes Here
                        </h5>
                        <p>
                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="img-box">
                        <img src="{{asset('frontend/images/blog2.jpg')}}" alt="">
                    </div>
                    <div class="detail-box">
                        <h5>
                            Blog Title Goes Here
                        </h5>
                        <p>
                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact_section layout_padding">
    <div class="container ">
        <div class="heading_container">
            <h2>
                Contact Us
            </h2>
            <img src="{{asset('frontend/images/plug.png')}}" alt="">
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form action="">
                    <div>
                        <input type="text" placeholder="Name" />
                    </div>
                    <div>
                        <input type="email" placeholder="Email" />
                    </div>
                    <div>
                        <input type="text" placeholder="Phone Number" />
                    </div>
                    <div>
                        <input type="text" class="message-box" placeholder="Message" />
                    </div>
                    <div class="d-flex ">
                        <button>
                            SEND
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <div class="map_container">
                    <div class="map-responsive">
                        <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Eiffel+Tower+Paris+France" width="600" height="300" frameborder="0" style="border:0; width: 100%; height:100%" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="info_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-9">
                <div class="info_form">
                    <form action="">
                        <input type="text" placeholder="Enter your email">
                        <button>
                            subscribe
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="info_social">
                    <div>
                        <a href="">
                            <img src="{{asset('frontend/images/fb.png')}}" alt="">
                        </a>
                    </div>
                    <div>
                        <a href="">
                            <img src="{{asset('frontend/images/twitter.png')}}" alt="">
                        </a>
                    </div>
                    <div>
                        <a href="">
                            <img src="{{asset('frontend/images/linkedin.png')}}" alt="">
                        </a>
                    </div>
                    <div>
                        <a href="">
                            <img src="{{asset('frontend/images/instagram.png')}}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<footer class="container-fluid footer_section">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-9 mx-auto">
                <p>
                    &copy; {{date('Y')}} All Rights Reserved By
                    <a href="#">Netel Mart</a>
                </p>
            </div>
        </div>
    </div>
</footer>
<!-- footer section -->
<script src="{{asset('frontend/js/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('frontend/js/bootstrap.js')}}"></script>

</body>

</html>
