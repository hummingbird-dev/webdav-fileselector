$(document).ready(function() {
    //get form entries
    var proxy = $("#proxy").val();
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
 	    url: proxy + '/webdav-fileselector',
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
	    $.getScript(proxy + '/js/webdav-fileselector-js/hummingbird-treeview.js').done(function(){
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
});
