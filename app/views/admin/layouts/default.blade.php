<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Primarynational.com Admin</title>
    {{ HTML::script('assets/js/jquery-1.10.2.js') }}
    {{ HTML::script('assets/js/jquery-ui-1.10.4.custom.min.js') }}
    {{ HTML::style('assets/css/jquery-ui.css') }}
    <!-- Core CSS - Include with every page -->
    
    {{ HTML::style('assets/css/bootstrap.min.css') }}
<!--    {{ HTML::style('assets/css/bootstrap-tagsinput.css') }}-->

    {{ HTML::style('assets/font-awesome/css/font-awesome.min.css') }}

    <!-- Page-Level Plugin CSS - Dashboard -->
    {{ HTML::style('assets/css/plugins/morris/morris-0.4.3.min.css') }}
    {{ HTML::style('assets/css/plugins/timeline/timeline.css') }}

    <!-- SB Admin CSS - Include with every page -->
    {{ HTML::style('assets/css/admin/sb-admin.css') }}
    {{ HTML::style('assets/css/datepicker3.css') }}
    {{ HTML::style('assets/css/summernote.css') }}
    {{ HTML::style('assets/css/jquery.tagsinput.css') }}

    {{ HTML::script('assets/js/bootstrap.min.js') }}
    {{ HTML::script('assets/js/summernote.js') }}

<!--    {{ HTML::script('assets/js/bootstrap-tagsinput.js') }}-->
    {{ HTML::script('assets/js/jquery.tagsinput.js') }}


</head>

<body>

    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/admin') }}">Primarynational.com  admin</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ url('admin/profile') }}"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

        </nav>

        <nav class="navbar-default navbar-static-side" role="navigation">
        @include('admin/elements/menu')
        </nav>
        <div id="page-wrapper">
            <br/>
            @if (Session::has('error_msg'))
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ Session::get('error_msg') }}
            </div>

            @endif
            @if (Session::has('success_msg'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ Session::get('success_msg') }}
            </div>

            @endif

            @yield('content')


        </div>
    </div>
    <!-- /#wrapper -->

    <!-- Core Scripts - Include with every page -->
    
<!--    {{ HTML::script('assets/js/bootstrap.min.js') }}-->
    {{ HTML::script('assets/js/plugins/metisMenu/jquery.metisMenu.js') }}

    <!-- SB Admin Scripts - Include with every page -->
    {{ HTML::script('assets/js/sb-admin.js') }}

   {{ HTML::script('assets/js/bootstrap-datepicker.js') }}

</body>
</html>
