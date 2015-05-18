<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Adisorn">
        <meta name="keyword" content="">
        <link rel="shortcut icon" href="{{URL::to('favicon.ico')}}">
        <title>MIS OFFICE 1.0</title>
        <!-- Bootstrap core CSS -->
        {{HTML::style('css/bootstrap.min.css')}}
        {{HTML::style('css/bootstrap-reset.css')}}
        <!--external css-->
        {{HTML::style('assets/font-awesome/css/font-awesome.css')}}
        <!-- Custom styles for this template -->
        {{HTML::style('css/style.css')}}
        {{HTML::style('css/style-responsive.css')}}
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
        {{HTML::script('js/html5shiv.js')}}
        {{HTML::script('js/respond.min.js')}}
        <![endif]-->
    </head>
    <body class="login-body">
        <div class="container">
            @yield('content')
        </div>
        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Forgot Password ?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Enter your e-mail address below to reset your password.</p>
                        <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                        <button class="btn btn-success" type="button">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->
        <!-- js placed at the end of the document so the pages load faster -->
        {{HTML::script('js/jquery.js')}}
        {{HTML::script('js/bootstrap.min.js')}}
        @yield('script_code')
        <script type="text/javascript">
            Notification.requestPermission(function (status) {
                var n = new Notification("Welcome to MIS Office V1.0", {body: "ยินดีต้อนรับเข้าสู่ระบบจัดการข้อมูลออนไลน์"});
            });
        </script>
    </body>
</html>
