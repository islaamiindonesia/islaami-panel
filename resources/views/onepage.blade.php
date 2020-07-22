<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Islaami - {{ $title }}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset("assets/onepage/vendor/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset("assets/onepage/css/one-page-wonder.min.css") }}" rel="stylesheet">
</head>

<body>

<section>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <div style="text-align: center">
                    <!-- Brand Logo -->
                    <img src="{{ asset("assets/img/playmi_logo.png") }}" alt="Islaami Logo" style="width: 200px;" class="mb-3">
                    <h1>{{ $title }}</h1>
                    {!! $content !!}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap core JavaScript -->
<script src="{{ asset("assets/onepage/vendor/jquery/jquery.min.js") }}"></script>
<script src="{{ asset("assets/onepage/vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>

</body>
</html>
