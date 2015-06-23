<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Primaryinternational.com Admin :: Login</title>


    <!-- Core CSS - Include with every page -->
    {{ HTML::style('assets/css/bootstrap.min.css') }}
    {{ HTML::style('assets/font-awesome/css/font-awesome.css') }}
 
 	<!-- SB Admin CSS - Include with every page -->
    {{ HTML::style('assets/css/admin/sb-admin.css') }}
    <!-- Core CSS - Include with every page -->
   

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">

                        @if ($errors->any())
                        <div class="alert alert-error">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Error!</strong><br> {{ implode('<br>', $errors->all()) }}
                        </div>
                        @endif

                     @if (Session::has('message'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger">

                {{ Session::get('message') }}

            </div>
        </div>

    </div>
    @endif
                        {{ Form::open(array('url' => 'login', 'class' => 'box login','role'=>'form')); }}
                            <fieldset>
                                <div class="form-group">
                                <label>Email</label>
                                    {{ Form::text('email','',array("class"=>"form-control", "placeholder"=>"E-mail", "required", "name"=>"email", "type"=>"email", "autofocus")) }}
                                    {{ $errors->first('email','<p class="text-red">:message</p>'); }}
                                </div>
                                <div class="form-group">
                                <label>Password</label>
                                    <input class="form-control" placeholder="Password" required name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Login" tabindex="4">
                                
                            </fieldset>
                       {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Core Scripts - Include with every page -->
{{ HTML::script('assets/js/jquery-1.10.2.js') }}
{{ HTML::script('assets/js/bootstrap.min.js') }}
{{ HTML::script('assets/js/plugins/metisMenu/jquery.metisMenu.js') }}

<!-- SB Admin Scripts - Include with every page -->
{{ HTML::script('assets/js/sb-admin.js') }}
</body>

</html>