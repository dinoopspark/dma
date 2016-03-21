<!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title') - Database management application</title>

        <!-- Bootstrap core CSS -->
        <link href="{{ asset('gentelella/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('gentelella/css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css" />
    </head>


    <body class="nav-md">

        <div class="container body">


            <div class="main_container">


                @yield('main')
                
            </div>
        </div>
    </body>
</html>
