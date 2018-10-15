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
 	    url: url_to_webdav_fileselector_post,
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
	    //---------------------------------------------------------------------------------------------------//
	    //-----------------------------load the hummingbird-treeview.js--------------------------------------//
	    //---------------------------------------------------------------------------------------------------//
	    console.log(url_to_treeview)
	    $.getScript(url_to_treeview).done(function(){
		$(document).ready(function() {
		    //apply options for the treeview
		    //define symbols for the folders
		    $.fn.hummingbird.defaults.collapsedSymbol= "fa-folder";
		    $.fn.hummingbird.defaults.expandedSymbol= "fa-folder-open";

		    //-------------------disable checking of whole folders/groups------------------------//
		    //$.fn.hummingbird.defaults.checkboxesGroups= "disabled";
		    //-------------------disable checking of whole folders/groups------------------------//

		    //initialization of the treeview
		    $("#treeview").hummingbird();
		    //get checked items
		    var List = {"id" : [], "dataid" : [], "text" : []};
		    $("#treeview").on("CheckUncheckDone", function(){
			//------------------get ids and uncheck old selection---------------//
			//------------------to restrict selection to one item---------------//
			//------------------use the "checkboxesGroups" option above!--------//
			// if (List.id != "") {
			//     $.each(List.id, function(i,e) {
			// 	$("#treeview").hummingbird("uncheckNode",{attr:"id",name: '"' + e + '"',collapseChildren:false});
			//     });
			// }
			//------------------------------------------------------------------//
			//------------------------------------------------------------------//
			List = {"id" : [], "dataid" : [], "text" : []};
			$("#treeview").hummingbird("getChecked",{list:List,onlyEndNodes:true});
			$("#selection").html(List.text.join("<br>"));
			//the full paths of the selected files are in the array List.dataid
			//console.log("Full WebDAV paths of the selected files: " + List.dataid)
		    });
		    //search functionality
		    $("#treeview").hummingbird("search",{treeview_container:"treeview_container", search_input:"search_input", search_output:"search_output", search_button:"search_button", scrollOffset:-515, onlyEndNodes:false});


		    

		    //-------------------###################################----------------------//
		    //-------------------use more treeview functionality----------------------//
		    //-------------------###################################----------------------//

		    
		    //------------------filtering---------------------------------------//
		    //$("#treeview").hummingbird("filter",{str: ".txt|.odv|.jpg|.zip"});
		    //------------------filtering---------------------------------------//
		});
	    });
	}
    });
});
