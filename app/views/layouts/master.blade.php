<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Adisorn">
        <meta name="keyword" content="">
        <link rel="shortcut icon" href="{{URL::to('favicon.ico')}}">
        <title>MIS Office</title>
        {{HTML::style('css/bootstrap.min.css')}}
        {{HTML::style('css/bootstrap-reset.css')}}
        {{HTML::style('font-awesome/css/font-awesome.min.css')}}
        @yield('style')
        {{HTML::style('css/style.css')}}
        {{HTML::style('css/style-responsive.css')}}
        <!--[if lt IE 9]>
         {{HTML::script('js/html5shiv.js')}}
        {{HTML::script('js/respond.min.js')}}
        <![endif]-->
    </head>
    <body class="full-width">
        <section id="container" class="">
            <header class="header white-bg">
                @include('layouts.sidebar_top')
            </header>
            <section id="main-content">
                <section class="wrapper">
                    @yield('content')
                </section>
            </section>
            <footer class="site-footer">
                <div class="text-center">
                    2015 &copy; MIS Office 1.0
                    <a href="#" class="go-top">
                        <i class="fa fa-angle-up"></i>
                    </a>
                </div>
            </footer>
        </section>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="button-close" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-warning" id="button-confirm">Confirm</button>
                        <button type="button" class="btn btn-primary" id="button-ok">OK</button>
                    </div>
                </div>
            </div>
        </div>
        {{HTML::script('js/jquery.js')}}
        {{HTML::script('js/jquery-1.8.3.min.js')}}
        {{HTML::script('js/bootstrap.min.js')}}
        {{HTML::script('js/respond.min.js')}}
        {{HTML::script('js/jquery.dcjqaccordion.2.7.js')}}
        {{HTML::script('js/jquery.scrollTo.min.js')}}
        {{HTML::script('js/jquery.nicescroll.js')}}
        {{HTML::script('js/jquery.cookie.js')}}
        @yield('script')
        {{HTML::script('js/common-scripts.js')}}
        @yield('script_code')
    </body>
</html>
