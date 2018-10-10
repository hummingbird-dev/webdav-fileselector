$(document).ready(function() {
    //get form entries
    var proxy = $("#proxy").val();
    $("#getb2drop_button").on("click", function(){
	$(".getdata").hide();
	$("#waiting_anim").show();	     
	var data = {"username" : $("#username").val(), "password" : $("#password").val(), "url" : $("#url").val()};
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
 	    },
 	    success: function(data){
 		//console.log("AJAX SUCCESS");
 	    }
 	});
    }

    //ajax complete
    $(document).ajaxComplete(function(e,xhr,settings){
	if (settings.func=="getb2drop_complete") {
	    var result = JSON.parse(xhr.responseText);
	    $("#waiting_anim").hide();	     
	    $(".result").show();
	    $("#result").html(result.join(" "));
	    $.getScript(proxy + '/js/webdav-fileselector-js/hummingbird-treeview.js').done(function(){
		$(document).ready(function() {
		    //define symbols for the groups
		    $.fn.hummingbird.defaults.collapsedSymbol= "fa-folder";
		    $.fn.hummingbird.defaults.expandedSymbol= "fa-folder-open";

		    //-------------------disable checking of whole groups------------------------//
		    //$.fn.hummingbird.defaults.checkboxesGroups= "disabled";
		    //-------------------disable checking of whole groups------------------------//

		    //initialization
		    $("#treeview").hummingbird();
		    //get checked
		    $("#treeview").on("CheckUncheckDone", function(){
			var List = [];
			$("#treeview").hummingbird("getChecked",{attr:"text",list:List,onlyEndNodes:true});
			$("#selection").html(List.join("<br>"));
		    });
		    //search
		    $("#treeview").hummingbird("search",{treeview_container:"treeview_container", search_input:"search_input", search_output:"search_output", search_button:"search_button", scrollOffset:-515, onlyEndNodes:false});


		    

		    //-------------------###################################----------------------//
		    //-------------------use optional treeview functionality----------------------//
		    //-------------------###################################----------------------//

		    

		    //------------------get paths---------------------------------------//
		    // $("#treeview").on("CheckUncheckDone", function(){
		    // 	var Paths = [];
		    // 	$("#treeview").hummingbird("getChecked",{attr:"data-id",list:Paths,onlyEndNodes:true});
		    // 	console.log(Paths)
		    // });
		    //------------------get paths---------------------------------------//



		    
		    //------------------get ids and uncheck old selection---------------//
		    //------------------to restrict selection to one item---------------//
		    //------------------use the "checkboxesGroups" option above!--------//
		    // var Ids = [];
		    // $("#treeview").on("CheckUncheckDone", function(){
		    // 	//uncheck old selection
		    // 	if (Ids != "") {
		    // 	    $.each(Ids, function(i,e) {
		    // 		$("#treeview").hummingbird("uncheckNode",{attr:"id",name: '"' + e + '"',collapseChildren:false});
		    // 	    });
		    // 	}
			
		    // 	Ids = [];
		    // 	$("#treeview").hummingbird("getChecked",{attr:"id",list:Ids,onlyEndNodes:true});
		    // });
		    //------------------get ids and uncheck old selection---------------//

			


		    
		    //------------------filtering---------------------------------------//
		    //$("#treeview").hummingbird("filter",{str: ".txt|.odv|.jpg|.zip"});
		    //------------------filtering---------------------------------------//
		});
	    });
	}
    });
});
