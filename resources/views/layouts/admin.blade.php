<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Admin Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

        <!-- jvectormap -->
        <link href="{{asset('plugins/jvectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet" type="text/css" />


        <!-- DataTables -->
        <link href="{{asset('plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App css -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/jquery-ui.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/metisMenu.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />

    </head>
    <style>
      #global-loader {
      position: absolute;
      z-index: 50000;
      background: white;
      left: 0;
      top: 0;
      right: 0;
      bottom: 0;
      height: 100%;
      width: 100%;
      margin: 0 auto;
      text-align: center; }
      #global-loader img {
        position: absolute;
        right: 0;
        bottom: 0;
        top: 43%;
        left: 0;
        margin: 0 auto;
        text-align: center; }
      a{
        cursor: pointer;
      }
    </style>

@yield('css')
<body>
  

      @include('includes.header')

    
    

      @include('includes.sidebar')
        <div class="page-wrapper">
          <!-- Page Content-->
          <div class="page-content">

            <div class="container-fluid">

            
              @if ($message = Session::get('success'))
                <div class="my-3">
                  <div class="alert alert-success text-center">
                      <p class="mb-0">{{ $message }}</p>
                  </div>
                </div>
              @endif
              @if ($message = Session::get('error'))
                <div class="my-3">
                  <div class="alert alert-danger text-center">
                      <p class="mb-0">{{ $message }}</p>
                  </div>
                </div>
              @endif


              @if($errors->any())
                {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
              @endif
            
              


              @yield('content')
            

              <!--Footer-->

              @include('includes.footer')


            <!-- End Footer-->
            </div>
          </div>
        </div>
  <!-- js -->
  <!-- jQuery  -->
        <script src="{{asset('assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/js/metismenu.min.js')}}"></script>
        <script src="{{asset('assets/js/waves.js')}}"></script>
        <script src="{{asset('assets/js/feather.min.js')}}"></script>
        <script src="{{asset('assets/js/jquery.slimscroll.min.js')}}"></script>
        <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>

        <script src="{{asset('plugins/apexcharts/apexcharts.min.js')}}"></script>
        <script src="{{asset('plugins/moment/moment.js')}}"></script>
        <script src="{{asset('plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
        <script src="{{asset('plugins/jvectormap/jquery-jvectormap-us-aea-en.js')}}"></script>
        <script src="{{asset('assets/pages/jquery.analytics_dashboard.init.js')}}"></script>

        <!-- App js -->
        <!-- Required datatable js -->
        <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>

        <script>
            //$('#datatable').DataTable();

        </script>
        <script src="{{asset('assets/js/app.js')}}"></script>
   
        @yield('js')

    </body>

</html>
 