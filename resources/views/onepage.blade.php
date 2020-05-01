<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>One Page Wonder - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset("assets/onepage/vendor/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset("assets/onepage/css/one-page-wonder.min.css") }}" rel="stylesheet">
</head>

<body>
<!-- Navigation -->
<nav class="navbar navbar-custom fixed-top">
    <div class="container">
        <!-- Brand Logo -->
        <img src="{{ asset("assets/img/islaami_logo.png") }}" alt="Islaami Logo" style="width: 100px;">
    </div>
</nav>

<header class="masthead text-center text-white">
    <div class="masthead-content">
        <div class="container">
            <h1 class="masthead-heading mb-sm-auto">{{ $title }}</h1>
        </div>
    </div>
    <div class="bg-circle-1 bg-circle"></div>
    <div class="bg-circle-2 bg-circle"></div>
    <div class="bg-circle-3 bg-circle"></div>
    <div class="bg-circle-4 bg-circle"></div>
</header>

<section>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <div class="p-5">
                    {!! $content !!}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="py-1 bg-black">
    <div class="container">
        <p class="m-0 text-center text-white small">Copyright &copy; Your Website 2019</p>
    </div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="{{ asset("assets/onepage/vendor/jquery/jquery.min.js") }}"></script>
<script src="{{ asset("assets/onepage/vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>

</body>
</html>
