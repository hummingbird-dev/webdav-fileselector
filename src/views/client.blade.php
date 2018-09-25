<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>webdav-fileselector</title>

	<!-- Font Awesome-->
	<!-- <link rel="stylesheet" href="{ url("css/webdav-fileselector-css/Font-Awesome-master/web-fonts-with-css/css/fontawesome-all.min.css") }}"> -->
	<link rel="stylesheet" href="{{ url("css/webdav-fileselector-css/font-awesome-custom/web-fonts-with-css/css/fontawesome-all.min.css") }}">
	<!-- <link rel="stylesheet" href="{{ url("css/webdav-fileselector-css/fontawesome-all.min.css") }}"> -->

	<!-- Bootstrap CSS-->
	<link rel="stylesheet" href="{{ url("css/webdav-fileselector-css/bootstrap-3.3.7-dist/css/bootstrap.min.css") }}">

	<!-- custom css -->
	<link rel="stylesheet" href="{{ url("css/webdav-fileselector-css/webdav-fileselector.css") }}">
	
	<!-- jQuery -->
	<script src="{{ url("js/webdav-fileselector-js/jquery-3.3.1.min.js") }}"></script>
	<!-- <script src="{{ url("js/getb2drop_js/jquery.min.js") }}"></script> -->

	<!-- Bootstrap JS -->
	<script src="{{ url("css/webdav-fileselector-css/bootstrap-3.3.7-dist/js/bootstrap.min.js") }}"></script>

	<!-- hummingbird-treeview -->
	<link rel="stylesheet" href="{{ url("css/webdav-fileselector-css/hummingbird-treeview.css") }}">

	
	
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
					<input id="username" type="text" class="form-control" name="username" value="abfd3609-6157-4043-94b3-4ff6287f78ed" required autofocus disabled>
				    </div>
				</div>
				<div class="form-group">
				    <label for="password" class="col-md-4 control-label">password</label>
				    <div class="col-md-6">
					<input id="password" type="password" class="form-control" name="password" value="BGpgP-YcDAq-bWoAa-F2bi4-fgTZ3" required autofocus disabled>
				    </div>
				</div>
				<div class="form-group">
				    <label for="url" class="col-md-4 control-label">URL</label>
				    <div class="col-md-6">
					<input id="url" type="text" class="form-control" name="url" value='https://b2drop.eudat.eu/remote.php/webdav/' required autofocus disabled>
				    </div>
				</div>
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



	<script>
	 //get form entries
	 $("#getb2drop_button").on("click", function(){
	     $(".getdata").hide();
	     $("#waiting_anim").show();	     
	     //console.log("clicked");
	     var data = {"username" : $("#username").val(), "password" : $("#password").val(), "url" : $("#url").val()};
	     //console.log(data);
	     //call ajax
	     getb2drop_ajax(data);
	 });

	 //ajax
	 function getb2drop_ajax(data) {
 	     $.ajax({
 		 type: "POST",
 		 url: "{{ url('/webdav-fileselector') }}",
 		 data: data,
 		 dataType: "json",
 		 func: "getb2drop_complete",                                 
 		 cache: "false",
 		 error:   function(data){
 		     //console.log("AJAX ERROR");
 		     //console.log(data)
 		 },
 		 success: function(data){
 		     //console.log("AJAX SUCCESS");
 		     //console.log(data)
 		 }
 	     });
	 }

	 //ajax complete
	 $(document).ajaxComplete(function(e,xhr,settings){
	     if (settings.func=="getb2drop_complete") {
		 //console.log(xhr.responseText)
		 var result = JSON.parse(xhr.responseText);
		 $("#waiting_anim").hide();	     
		 $(".result").show();
		 $("#result").html(result.join(" "));
		 $.getScript("{{ url("js/webdav-fileselector-js/hummingbird-treeview.js") }}").done(function(){
		     $(document).ready(function() {
			 $.fn.hummingbird.defaults.collapsedSymbol= "fa-folder";
			 $.fn.hummingbird.defaults.expandedSymbol= "fa-folder-open";
			 $("#treeview").hummingbird();
			 $("#treeview").on("CheckUncheckDone", function(){
			     var List = [];
			     $("#treeview").hummingbird("getChecked",{attr:"text",list:List,onlyEndNodes:true});
			     $("#selection").html(List.join("<br>"));
			     //var L = List.length;
			 });
		     });
		 });
	     }
	 });
	</script>




	
    </body>
</html>