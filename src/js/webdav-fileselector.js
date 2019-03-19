
var List = {"id" : [], "dataid" : [], "text" : []};
var paras = {};

var first_visit = true;


$.ajaxSetup({
    headers: {
    	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$(document).ready(function() {


    //form
    $("#start").on("click", function(e){
    	e.preventDefault();

	//show loading anim
	$("#form_file_selector").hide();
	$("#loading").show();

	
	//get post data
	var post_data = $("#form_file_selector").serializeArray();

	//ajax
    	$.ajax({
    	    type: "POST",
    	    url: "/webdav-fileselector-post",
    	    data: post_data,
    	    dataType: "json",
    	    func: "getb2drop_complete",                                 
    	    cache: "false",
    	    error:   function(data){
    		console.log("AJAX ERROR");
    	    },
    	    success: function(data){
    		console.log("AJAX SUCCESS");
    	    }
    	});
	


    });



    $(document).ajaxComplete(function(e,xhr,settings){
    	if (settings.func=="getb2drop_complete") {
    	    var result = JSON.parse(xhr.responseText);
	    //treeview
	    $("#treeview_div").html(result.data.join(" "));
	    //paras
	    paras = result.allparas;
	    console.log(paras)

	    // if (paras.minimal_view == "1"){
	    // 	$("#heading").hide();
	    // 	$("#mini_heading").show();
	    // }
	    
	    
	    $.getScript("hummingbird-dev/webdav-fileselector/hummingbird-treeview.js").done(function(){
    		$(document).ready(function() {
		    $("#form_file_selector").hide();
		    $.fn.hummingbird.defaults.collapsedSymbol= "fa-folder";
		    $.fn.hummingbird.defaults.expandedSymbol= "fa-folder-open";



		    //-------------------disable checking of whole folders/groups------------------------//
    		    if (paras.disable_folder_checking == "1"){
    			$.fn.hummingbird.defaults.checkboxesGroups= "disabled";
    		    }
    		    //-------------------disable checking of whole folders/groups------------------------//


		    //-------------------init----------------------------------------------------------//
		    $("#treeview").hummingbird();
		    if (first_visit == true){
			$("#loading").hide();
			first_visit = false;
		    }

		    //-------------------init----------------------------------------------------------//


		    
    		    //-------------------expand root node-----------------------------------------------//
    		    $("#treeview").hummingbird("expandNode",{attr:"id",name: "hum_1",expandParents:true});
		    //-------------------expand root node-----------------------------------------------//

		    

    		    //-------------------disaable root node--------------------------------------------//
    		    if (paras.disable_root_node == "1"){
    			$("#treeview").hummingbird("disableNode",{attr:"id",name: "hum_1",state:false,disableChildren:false});
    		    }
    		    //-------------------disaable root node--------------------------------------------//

		    
    		    //------------------get ids and uncheck old selection---------------//
    		    //------------------to restrict selection to one item---------------//
    		    //------------------use the "checkboxesGroups" option above!--------//
		    $("#treeview").on("CheckUncheckDone", function(){
			if (paras.select_only_one_item == "1"){
    			    if (List.id != "") {
    				$.each(List.id, function(i,e) {
    				    $("#treeview").hummingbird("uncheckNode",{attr:"id",name: '"' + e + '"',collapseChildren:false});
    				});
    			    }
    			}
    			//------------------------------------------------------------------//
    			//------------------------------------------------------------------//
    			List = {"id" : [], "dataid" : [], "text" : []};
    			$("#treeview").hummingbird("getChecked",{list:List,onlyEndNodes:paras.getChecked_onlyEndNodes});

    			if (paras.show_only_parent_folder == "1") {
    			    var re = new RegExp('^(.*?)\/', 'g');
    			    var new_List = List.text.join().replace(/(?:\r\n|\r|\n)/g, '').replace(/,/g,"");
    			    //var new_List = List.text.join(List.text);
    			    //console.log(new_List)
    			    $("#selection").html(new_List.match(re));
    			} else {
    			    $("#selection").html(List.text.join("<br>"));
    			}
    			//the full paths of the selected files are in the array List.dataid
    			//console.log("Full WebDAV paths of the selected files: " + List.dataid)

    			//if (List.text.toString().match(/.odv/g)) {
    			    //automaticall check the corresponding odv folder
    			    //var folder = List.text.toString().replace('.odv','.Data');
    			//$("#treeview").hummingbird("checkNode",{attr:"text",name: folder,collapseChildren:false});
    			//}
			
			//fire event
			//console.log("fire")
			parent.postMessage(List,"*");
    		    });


		    //--------------------search functionality-----------------------------
		    $("#search_div").show();
    		    $("#treeview").hummingbird("search",{treeview_container:"treeview_container", search_input:"search_input", search_output:"search_output", search_button:"search_button", scrollOffset:-515, onlyEndNodes:false});
		    //--------------------search functionality-----------------------------


		    //----------------------filter--------------------------------//
		    if (paras.filter){
    			$("#treeview").hummingbird("filter",{str:paras.filter,box_disable:false,onlyEndNodes:false,filterChildren:true});
		    }
		    //----------------------filter--------------------------------//

		    
		});
	    });
	}
    });




});
