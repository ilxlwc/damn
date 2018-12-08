<!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">  
	    <title>双盈信息科技</title>
        <meta name="description" content="双盈信息科技">
	    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
	    <link href="../css/font-awesome.min.css" rel="stylesheet">
	    <link href="../css/bootstrap.min.css" rel="stylesheet">
	    <link href="../css/templatemo-style.css" rel="stylesheet">
	    
	    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>
	<body class="light-gray-bg">
		<div class="templatemo-content-widget templatemo-login-widget white-bg">
			<header class="text-center">
	          <div class="square"></div>
	          <h1>&nbsp;双盈信息科技</h1>
	        </header>
	        <form action="/submin_login" method="post" class="templatemo-login-form">
	        	{{ csrf_field() }}
	        	<div class="form-group">
	        		<div class="input-group">
		        		<div class="input-group-addon"><i class="fa fa-user fa-fw"></i></div>
		              	<input type="text" name="name" id="name" class="form-control" placeholder="用户名">           
		          	</div>	
	        	</div>
	        	<div class="form-group">
	        		<div class="input-group">
		        		<div class="input-group-addon"><i class="fa fa-key fa-fw"></i></div>
		              	<input type="password" name="password" id="password" class="form-control" placeholder="密  码">           
		          	</div>	
	        	</div>
				<div class="form-group">
					<button type="submit" class="templatemo-blue-button width-100">登  录</button>
				</div>
	        </form>
		</div>
	</body>
	@if (count($errors))
	<div class="templatemo-content-widget templatemo-login-widget templatemo-register-widget orange-bg">
	 @foreach ($errors->all() as $error)
        <p class="white-text"><strong>{{ $error }}</strong></p>
     @endforeach		
	</div>
	@endif
</html>