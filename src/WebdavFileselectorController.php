<?php

namespace HummingbirdDev\WebdavFileselector;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests;

class WebdavFileselectorController extends Controller
{

    public function get(Request $request)
    {

        Log::info("webdav-fileselector get");

        //if this function is called via POST
        //the form can be adjusted
        //validate
        $this->validate($request, [
            'b2drop_username' => 'nullable|string',
            'b2drop_password' => 'nullable|string',
            'b2drop_url' => 'nullable|string',
            'select_only_one_item' => 'nullable|boolean',
            'show_only_parent_folder' => 'nullable|boolean',
            'disable_folder_checking' => 'nullable|boolean',
            'disable_root_node' => 'nullable|boolean',
            'getChecked_onlyEndNodes' => 'nullable|boolean',
            'filter' => 'nullable|string',
            'button_name' => 'nullable|string',
            'fileselector_height' => 'nullable|string',
            'minimal_view' => 'nullable|boolean',
            'jumbotron' => 'nullable|string',
        ]);

        //set default
        $xparas = (object) array(
            'b2drop_username' => "smieruch",
            'b2drop_password' => "password",
            'b2drop_url' => "http://localhost:8099/remote.php/webdav/",
            'select_only_one_item' => '1',
            'show_only_parent_folder' => '0',
            'disable_folder_checking' => '1',
            'disable_root_node' => '0',
            'getChecked_onlyEndNodes' => '1',
            'filter' => '',
            'button_name' => '',
            'fileselector_height' => '400',
            'jumbotron' => "jumbotron",
            'minimal_view' => "0"
        );

        //set new if request exists
        $all_request = $request->all();
        //Log::info("request=".print_r($all_request,1));
        foreach ($all_request as $para_key => $para_val){
            Log::info("key=".$para_key."    "."val=".$para_val);
            if (isset($xparas->$para_key)){
                $xparas->$para_key = $para_val;
            }
        }


        return view('hummingbird-dev.webdav-fileselector.webdav-fileselector',compact('xparas'));



    }


    
    public function post(Request $request)
    {

        Log::info("webdav-fileselector post");
        $fileselector = "post";
        


        //header("Access-Control-Allow-Origin: *");


        Log::info("Zheight=".session('fileselector_height'));
        
        //validate
        $this->validate($request, [
            'b2drop_username' => 'required',
            'b2drop_password' => 'required',
            'b2drop_url' => 'required',
            'select_only_one_item' => 'nullable|boolean',
            'show_only_parent_folder' => 'nullable|boolean',
            'disable_folder_checking' => 'nullable|boolean',
            'disable_root_node' => 'nullable|boolean',
            'getChecked_onlyEndNodes' => 'nullable|boolean',
            'filter' => 'nullable|string',
            'button_name' => 'nullable|string',
            'fileselector_height' => 'nullable|string',
            'minimal_view' => 'nullable|boolean',
        ]);

        //curl headers
        $headers = array(
            'Content-Type: text/xml',
            'Depth:infinity'
            //'Depth:1'
        );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $request->b2drop_url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PROPFIND" );
            curl_setopt($curl, CURLOPT_USERPWD, $request->b2drop_username . ":" . $request->b2drop_password );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            $result = curl_exec($curl);
            //Log::info(print_r($result,1));            
            $xml = simplexml_load_string($result);
            //for offline testing
            //$xml = simplexml_load_file("/var/www/html/Log/xml.xml");


            if (!isset($request->fileselector_height)){
                $height=200;
            } else {
                $height=$request->fileselector_height;
            }
        $data = array(
            '<div class="hummingbird-treeview-converter" data-height="' . $height  . 'px" data-scroll="true">'
        );


        sleep(4);

        $folder_indentation = "";
        $indentation = "";
        //$lastfile = "";
        foreach ( $xml->children('DAV:') as $item ) {
            
            $this_file = (string) $item->href[0];

            
            preg_match('/[^\/]+$/',$this_file,$match_file);
            preg_match('/[^\/]+\/$/',$this_file,$match_folder);


            $this_type = "";
            
            if ($match_folder) {
                $this_type = "folder";
                //no hidden files
                if (preg_match_all('/\/\./',$this_file)) {
                    continue;
                }
            }

            if ($match_file) {
                $this_type = "file";
                //no hidden files
                if (preg_match_all('/\/\./',$this_file)) {
                    continue;
                }
            }

            //get number of folders, i.e. depth in the tree
            preg_match_all('/[^\/]+/',$this_file,$match);
            $num = count($match[0]);
            //log::info("this_file= " . $this_file);
            //log::info("match= " . print_r($match,1));
            //log::info("num= " . $num);
            $hyphen = "";
            for ($i=3;$i<=$num;$i++) {
                $hyphen = $hyphen . "-";
            }
                
            
            
            if ($this_type == "folder") {
                //$data[] = '<li id="item1" data-id="test1">' . $hyphen . $match_folder[0] . '</li>';
                $data[] = '<li data-id="' . $this_file  . '">' . $hyphen . urldecode($match_folder[0]) . '</li>'; 
            }

            
            if ($this_type == "file") {
                //$data[] = '<li id="item1" data-id="test1">' . $hyphen . $match_file[0] . '</li>';
                $data[] = '<li data-id="' . $this_file  . '">' . $hyphen . urldecode($match_file[0]) . '</li>'; 
            }



            
        }

        $data[] = '</div>';

        $paras = [
            'select_only_one_item' => $request->select_only_one_item,
            'disable_folder_checking' => $request->disable_folder_checking,
            'disable_root_node' => $request->disable_root_node,
            'getChecked_onlyEndNodes' => $request->getChecked_onlyEndNodes,
            'filter' => $request->filter,
            'button_name' => $request->button_name,
            'minimal_view' => $request->minimal_view,
        ];

        $all_data = array_merge(['data' => $data],['allparas' => $paras]);

        echo json_encode($all_data);

    }

}

?>