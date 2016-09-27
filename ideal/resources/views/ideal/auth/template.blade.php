<!DOCTYPE html>
<html lang="en">
   
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $title }}</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
        <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
        <script src="{{asset('/js/jquery.js') }}"></script>
         <script src="{{ asset('/js/myscripAuth.js') }}"></script>
        
</head>
<body>
    
        <div class='header'>  
    
            <nav class="text_r">

                <nav id="login" name="{{session('user_id')}}"> Привет, <a href="http://ideal/userInfo?user_id={{session('user_id')}}">&nbsp{{session('login')}}</a><br></nav>
               <img src="{{ $foto }}" class='foto'>&nbsp;&nbsp;
               <label class="karma">{{$karma}}</label><br><br>
                <a href="http://ideal/exit">Выйти</a>

            </nav>
            @yield('content')
    </div>
</body>
</html>
