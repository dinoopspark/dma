<!doctype html>
<html>
    <head>
        <meta charset="utf-8">

        <style type="text/css" href="{{ asset('css/bootstrap.min.css') }}"></style>

        <script>
            var dmaGlobal = {base_url: "<?PHP echo url('/') ?>", ajax_url: "<?PHP echo url('/ajax') ?>"}
            alert(dmaGlobal.ajax_url);
        </script>

        <title>@yield('title') - Userlisting</title>
    </head>

    <body>



        <div class="container">

            <h2>USER<strong>LISTING</strong></h2>

            @include('tmp/nav')

            <h3>@yield('title')</h3>

            @if (Session::has('message'))
            <div class="flash alert">
                <p>{{ Session::get('message') }}</p>
            </div>
            @endif

            @yield('main')
        </div>

    </body>

</html>