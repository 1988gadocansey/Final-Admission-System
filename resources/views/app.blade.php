<!DOCTYPE html>
<html ng-app="tutapos">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Takoradi Technical University | Admissions Forms Sales</title>
        
        <link href="{{ asset('/public/css/app.css')}}" rel="stylesheet">
        <link href="{{ asset('/public/css/footer.css')}}" rel="stylesheet">
        <!-- Fonts -->
        <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="{{url('public/images/logo.png')}}" type="image/x-icon" />
        <link rel="stylesheet" href="{!! url('public/assets/select2/css/select2.min.css') !!}" media="all">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    <link   href="{!! url('public/assets/bootstrap-fileinput/bootstrap-fileinput.css') !!}" rel="stylesheet">        
         <link rel="stylesheet" href="{!! url('public/assets/sweet-alert/sweet-alert.min.css') !!}" media="all">
         <style>
             input{
                 text-transform: uppercase;
             }
         </style>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <img class="image-responsive"alt="logo" style="width:auto;height:67px;margin-top: -12px" src="{{url('public/logo.png')}}"> 
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">

                        @if(!empty(Auth::user()->FORM_NO)) 	
                        <li><a href="{{ url('/customers')}}"> Your Application Form Number :  {{Auth::user()->FORM_NO}}</a></li>
                        @endif	 
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::guest())
                        <li><a href="{{ url('/auth/login')}}">Login</a></li>
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Hi {{ Auth::user()->FORM_NO }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout')}}">{{trans('menu.logout')}}</a></li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

        <footer class="footer hidden-print">
            <div class="container">
                <center><p class="text-muted">Powered by TPconnect <a href="http://www.ttu.edu.gh/tpconnect">Takoradi Technical University | </a> Admissions</a>.</center>
                </p>
            </div>
        </footer>
        <script src="{!! url('public/assets/js/vue.min.js') !!}"></script>
<script src="{!! url('public/assets/js/vue-form.min.js') !!}"></script
        <!-- Scripts -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
       

    <script language="javascript" type="text/javascript">
                      $(document).ready(function(){
            $('.saves').on('click', function(e){


            var name = $(this).closest('tr').find('.name').val();
                    var program = $(this).closest('tr').find('.program').val();
                     var level= $(this).closest('tr').find('.level').val();
                     
                     //alert(hall);
                    UIkit.modal.confirm("Are you sure you want to add this group "
                            , function(){
                            modal = UIkit.modal.blockUI("<div class='uk-text-center'>Creating Group <br/><img class='uk-thumbnail uk-margin-top' src='{!! url('public/assets/img/spinners/spinner.gif')  !!}' /></div>");
                                    //setTimeout(function(){ modal.hide() }, 500) })()            
                                    $.ajax({
                                     
                                            type: "POST",
                                            url:"admit",
                                            data: { applicant:student, program:program,hall:hall,admit:admit}, //your form data to post goes 
                                            dataType: "html",
                                    }).done(function(data){
                            modal.hide();
                                    
                                     UIkit.modal.alert("Group created successfully");
                                   // $("#ts_pager_filter").load(window.location + " #ts_pager_filter");
                                    // console.log(data);
                                     location.reload();
//        return (function(modal){ modal = UIkit.modal.blockUI("<div class='uk-text-center'>Processing Transcript Order<br/><img class='uk-thumbnail uk-margin-top' src='{!! url('public/assets/img/spinners/spinner.gif')  !!}' /></div>"); setTimeout(function(){ modal.hide() }, 500) })();
                            });
                            }
                    );
            });
             
            });
                function printDiv(divID) {
                //Get the HTML of div
                var divElements = document.getElementById(divID).innerHTML;
                        //Get the HTML of whole page
                        var oldPage = document.body.innerHTML;
                        //Reset the page's HTML with div's HTML only
                        document.body.innerHTML =
                        "<html><head><title></title></head><body>" +
                        divElements + "</body>";
                        //Print Page
                        window.print();
                        //Restore orignal HTML
                        document.body.innerHTML = oldPage;
                }
    </script>
     
             <script src="{!! url('public/assets/bootstrap-fileinput/bootstrap-fileinput.js') !!}"></script>
 
<script src="{!! url('public/assets/sweet-alert/sweet-alert.min.js') !!}"></script>
 @yield('js')
    </body>
</html>
