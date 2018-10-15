<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>webdav-fileselector</title>

	<!-- Font Awesome-->
	<link rel="stylesheet" href="{{ url( $proxy . "/css/webdav-fileselector-css/font-awesome-custom/web-fonts-with-css/css/fontawesome-all.min.css" ) }}">
	
	<!-- Bootstrap CSS-->
	<link rel="stylesheet" href="{{  url( $proxy . "/css/webdav-fileselector-css/bootstrap-3.3.7-dist/css/bootstrap.min.css"  ) }}">
	
	<!-- jQuery -->
	<script src="{{  url( $proxy . "/js/webdav-fileselector-js/jquery-3.3.1.min.js"  ) }}"></script>

	<!-- Bootstrap JS -->
	<script src="{{  url( $proxy . "/css/webdav-fileselector-css/bootstrap-3.3.7-dist/js/bootstrap.min.js"  ) }}"></script>

	<!-- hummingbird-treeview -->
	<link rel="stylesheet" href="{{  url( $proxy . "/css/webdav-fileselector-css/hummingbird-treeview.css"  ) }}">

	<!-- custom css -->
	<link rel="stylesheet" href="{{  url( $proxy . "/css/webdav-fileselector-css/webdav-fileselector.css"  ) }}">

	<!-- custom js -->
	<script src="{{  url( $proxy . "/js/webdav-fileselector-js/webdav-fileselector.js"  ) }}"></script>

	
	
    </head>
    <body>

	<nav class="navbar navbar-default navbar-custom">
	    <div class="container-fluid">
		<div class="navbar-header">
		    <a class="navbar-brand" href="#">WebDAV File Selector</a>
		</div>
		<ul class="nav navbar-nav">
		    <!-- <li class="active"><a href="#">Home</a></li>
			 <li><a href="#">Page 1</a></li>
			 <li><a href="#">Page 2</a></li>
			 <li><a href="#">Page 3</a></li> -->
		</ul>
	    </div>
	    </nav>

	
	<div class="row " style="display:none" id="waiting_anim">
	    <div class="col-sm-3">
	    </div>
	    <div class="col-sm-6 SPA_init text-center jumbotron">
		<h1 id="waiting_anim_text">Please wait, we are connecting your private work space ...</h1>
		<h1><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></h1>
	    </div>
	    <div class="col-sm-3">
	    </div>
	</div>



	<div class="container-fluid">
	    <div class="row getdata">
		<div class="col-sm-3">
		</div>
		<div class="col-sm-6">
		    <div class="text-left">
		    </div>
		    <br><br><br>
		    <div class="panel panel-default">
			<div class="panel-body text-left">
			    <form class="form-horizontal" role="form">
				<div class="form-group">
				    <label for="username" class="col-md-4 control-label">username</label>
				    <div class="col-md-6">
					<input id="username" type="text" class="form-control" name="username" value="{{ $username }}" required autofocus>
				    </div>
				</div>
				<div class="form-group">
				    <label for="password" class="col-md-4 control-label">password</label>
				    <div class="col-md-6">
					<input id="password" type="password" class="form-control" name="password" value="{{ $password }}" required autofocus>
				    </div>
				</div>
				<div class="form-group">
				    <label for="url" class="col-md-4 control-label">URL</label>
				    <div class="col-md-6">
					<input id="url" type="text" class="form-control" name="url" value="{{ $url }}" required autofocus>
				    </div>
				</div>
				<input id="proxy" type="hidden" class="form-control" name="proxy" value="{{ $proxy }}" required autofocus>
			    </form>
			    <br>
			    <button class="btn btn-block btn-responsive btn-primary" id="getb2drop_button" style="font-size: 42px">Get</button>	    							   
			</div>			
		    </div>
		</div>
		<div class="col-sm-3">
		</div>
	    </div>

	    <div class="row result" style="display:none;">
		<div class="col-sm-1">
		</div>

		<div class="col-sm-10 ">
		    <div class="row">
			<div class="col-sm-6 text-center">
			    <h2><u>Private workspace</u></h2>
			    <br>
			    <div class="dropdown">
				<div class="input-group stylish-input-group">
				    <input id="search_input" type="text" class="form-control" placeholder="Search" onclick="this.select()">
				    <span class="input-group-addon" style="border-left:0">
					<button type="submit" id="search_button">
					    <span class="glyphicon glyphicon-search"></span>
					</button>
				    </span>
				    <ul class="dropdown-menu h-scroll" id="search_output">
				    </ul>
				</div>
			    </div>
			    <br>
			    <span class="text-left" id="result">
			    </span>
			</div>
			<div class="col-sm-6 text-center">
			    <h2><u>Selected</u></h2>
			    <br>
			    <div style="height: 400px; overflow-y: scroll;">
			    <span class="text-left" style="font-size:20px;" id="selection">
			    </span>
			    <div>
			</div>
		    </div>		    
		</div>

		<div class="col-sm-1">
		</div>
	    </div>

	    <br>
	    <br>
	    <div class="row result" style="display:none;">
	    	<div class="row">
		    <div class="col-sm-10">
		    </div>
		    <div class="col-sm-2">
		    	<button class="btn btn-block btn-responsive btn-primary" id="continue_button" style="font-size: 18px">Continue</button>
		    </div>
		</div>					   
	    </div>
			    
	</div>


	@if ($webdav_auto)
	    <script>	     
	     $(document).ready(function() {
		 var webdav_auto = {{ $webdav_auto }};
		 if (webdav_auto) {
		     $("#getb2drop_button").trigger("click")
		 }
	     });
	    </script>
	@endif



	
    </body>
</html>
