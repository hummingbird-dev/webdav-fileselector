<?php

namespace HummingbirdDev\WebdavFileselector;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests;

class WebdavFileselectorController extends Controller
{

    public function get()
    {
        return view('webdav-fileselector::client');
    }


    
    public function post(Request $request)
    {
        $b2drop_username = $request->username;
        $b2drop_password = $request->password;
        $b2drop_url = $request->url;

        $headers = array(
            'Content-Type: text/xml',
            //'Content-Type: application/json',
            'Depth:infinity'
            //'Depth:1'
        );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://b2drop.eudat.eu/remote.php/webdav/');
            //curl_setopt($curl, CURLOPT_URL, 'https://b2drop.eudat.eu/remote.php/webdav/SDN_test_Elba.Data');

            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PROPFIND" );
            curl_setopt($curl, CURLOPT_USERPWD, $b2drop_username . ":" . $b2drop_password );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            $result = curl_exec($curl);
            //Log::info(print_r($result,1));            
            $xml = simplexml_load_string($result);
            //$xml = simplexml_load_file("/var/www/html/Log/xml.xml");


        $data = array(
            '<div class="hummingbird-treeview-converter" data-height="400px" data-scroll="true">'
        );


        /* sleep(4); */

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
            log::info("this_file= " . $this_file);
            log::info("match= " . print_r($match,1));
            log::info("num= " . $num);
            $hyphen = "";
            for ($i=3;$i<=$num;$i++) {
                $hyphen = $hyphen . "-";
            }
                

            
            if ($this_type == "folder") {
                //$data[] = '<li id="item1" data-id="test1">' . $hyphen . $match_folder[0] . '</li>';
                $data[] = '<li>' . $hyphen . $match_folder[0] . '</li>'; 
            }

            
            if ($this_type == "file") {
                //$data[] = '<li id="item1" data-id="test1">' . $hyphen . $match_file[0] . '</li>';
                $data[] = '<li>' . $hyphen . $match_file[0] . '</li>'; 
            }



            
        }

        $data[] = '</div>'; 

        //log::info(print_r($data,1));
            
        echo json_encode($data);
    }

}

?>