@include('sweetalert::alert')
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- <meta http-equiv="refresh" content="30"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>BDMS DASHBOARD</title>
        <link href="{{asset('backend/datatables/style.css')}}" rel="stylesheet" />
        <link href="{{asset('backend/css/styles.css')}}" rel="stylesheet" />

        <script src="{{asset('backend/fontawesome/all.js')}}" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
    <x-backend.layouts.partials.header/>
        <div id="layoutSidenav">
            <x-backend.layouts.partials.sidebar/>
            <div id="layoutSidenav_content">
                <main>
              {{$slot}}
                </main> 
                <x-backend.layouts.partials.footer/>
            </div>
        </div>
        <script src="{{asset('backend/js/scripts.js')}}"></script>

        <script src="{{asset('backend/datatables/simple-datatables@latest.js')}}" crossorigin="anonymous"></script>
        <script src="{{asset('backend/js/datatables-simple-demo.js')}}"></script>
        <script src="{{asset('backend/js/popper.min.js')}}"></script>
        <script src="{{asset('backend/js/bootstrap.min.js')}}"></script>
        </body>
</html>
