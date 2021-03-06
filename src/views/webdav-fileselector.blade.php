<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">


        <title>webdav-fileselector</title>

	<!-- Font Awesome-->
	<link rel="stylesheet" href="hummingbird-dev/webdav-fileselector/font-awesome-custom/web-fonts-with-css/css/fontawesome-all.min.css">

	<!-- Styles -->
	<link href="hummingbird-dev/webdav-fileselector/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- hummingbird-treeview -->
	<link rel="stylesheet" href="hummingbird-dev/webdav-fileselector/hummingbird-treeview.css">

	<!-- custom css -->
	<link rel="stylesheet" href="hummingbird-dev/webdav-fileselector/webdav-fileselector.css">


	<!-- Scripts -->
	<script src="hummingbird-dev/webdav-fileselector/jquery-3.3.1.min.js"></script>
	<script src="hummingbird-dev/webdav-fileselector/tether.min.js"></script>
	<script src="hummingbird-dev/webdav-fileselector/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>
	
	<!-- custom js -->
	<script src="hummingbird-dev/webdav-fileselector/webdav-fileselector.js"></script>

	
    </head>

    </head>
    <body>
	<div class="container">
	    <div class="row ">
		<div class="col-sm-3 text-center">
		</div>
		<div class="col-sm-6 text-center {{ $xparas->jumbotron }}">
		    @if ($xparas->minimal_view == "0")
		    <div id="heading">
			<h1>hummingbird-dev -- webdav-fileselector </h1>
			Find the sources at GitHub:<br>
			<a href="https://github.com/hummingbird-dev/webdav-fileselector" target="_blank">webdav-fileselector</a><br>
			<a href="https://github.com/hummingbird-dev/hummingbird-treeview" target="_blank">hummingbird-treeview</a><br>
			<br>
		    </div>
		    @endif
		    @if ($xparas->minimal_view == "1")
		    <div id="mini_heading" class="text-center">
			<h1>Fileselector</h1>
		    </div>
		    @endif
		    <form id="form_file_selector" method="POST" action="">
			{{ csrf_field() }}
			<input type="hidden" name="b2drop_username" value="{{ $xparas->b2drop_username }}">
			<input type="hidden" name="b2drop_password" value="{{ $xparas->b2drop_password }}">
			<input type="hidden" name="b2drop_url" value="{{ $xparas->b2drop_url }}">
			<input type="hidden" name="select_only_one_item" value="{{ $xparas->select_only_one_item }}">
			<input type="hidden" name="show_only_parent_folder" value="{{ $xparas->show_only_parent_folder }}">
			<input type="hidden" name="disable_folder_checking" value="{{ $xparas->disable_folder_checking }}">
			<input type="hidden" name="disable_root_node" value="{{ $xparas->disable_root_node }}">
			<input type="hidden" name="getChecked_onlyEndNodes" value="{{ $xparas->getChecked_onlyEndNodes }}">
			<input type="hidden" name="filter" value="{{ $xparas->filter }}">
			<input type="hidden" name="fileselector_height" value="{{ $xparas->fileselector_height }}">
			<input type="hidden" name="minimal_view" value="{{ $xparas->minimal_view }}">
			<input type="hidden" name="jumbotron" value="{{ $xparas->jumbotron }}">
			<button type="submit" id="start" class="btn btn-outline-primary">Click to start</button>
		    </form>
		    <div id="loading" style="display:none;">			
			<h4 id="loading_text">Loading &nbsp; <i class="fa fa-spinner fa-spin" style="font-size:24px"></i></h4>
		    </div>
		    <div class="dropdown" style="display:none;" id="search_div">
			<div class="input-group stylish-input-group">
			    <input id="search_input" type="text" class="form-control" placeholder="Search" onclick="this.select()">
			    <span class="input-group-addon" style="border-left:0">
				<button type="submit" id="search_button">
				    <i class="fa fa-search" aria-hidden="true"></i>				    
				</button>
			    </span>
			    <ul class="dropdown-menu h-scroll" id="search_output">
			    </ul>
			</div>
		    </div>
		    <br>
		    <div id="treeview_div" class="text-left">
		    </div>
		</div>
		<div class="col-sm-3 text-center">

		</div>
	    </div>
	</div>

	<script>
	 window.addEventListener("message",function(e) {
	     console.log("message event",e);
	     var key = e.message ? "message" : "data";
	     data = e[key];
	     console.log("file_path= " + data.dataid)
	     console.log("file_id= " + data.id)
	     console.log("file_text= " + data.text)
	 },false);
	</script>
	

    </body>
</html>







