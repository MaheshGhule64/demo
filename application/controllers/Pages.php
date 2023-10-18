<?php

class Pages extends CI_Controller{

    public function __construct(){
        parent::__construct();
      //  $this->load->library('ffmpeg');
        //$this->ffmpeg->execute('sdkds');

    }


    public function MakeCurlCall($url,$payload,$method){

        $curl = curl_init();

        curl_setopt_array($curl, array(
           CURLOPT_URL => $url,
           CURLOPT_POSTFIELDS => $payload,
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => '',
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 0,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => $method,
      ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    
public function validation1(){

    $display = array(
        'msg' => "Please provide restaurant_id for get timing of restaurant and template_id for get html of footer",
        'status' => 401
    );

    $this->output->set_content_type('appliacation/json');
    $this->output->set_status_header(401);
    $this->output->set_output(json_encode($display));
}

public function validation2(){

    $display = array(
        'msg' => "Please provide template_id for get html of footer",
        'status' => 401
    );

    $this->output->set_content_type('appliacation/json');
    $this->output->set_status_header(401);
    $this->output->set_output(json_encode($display));
}
public function getHtmlForFooter($restaurant_id, $template_id){


$url_time = "http://localhost/Webbuilder/get_timing/" . $restaurant_id;
$url_html = "http://localhost/Webbuilder/get_html/" . $template_id;

$actualData = $this->MakeCurlCall($url_time, "", "GET");
$actualHtml = $this->MakeCurlCall($url_html, "", "GET");

$data = json_decode($actualData);
$content = json_decode($actualHtml);

$actual_html = ($content->data[0]->html);

//print_r($content);


$startPos=strpos($actual_html,"#starts#");
$endPos=strpos($actual_html,"#ends#");
$firstPart=substr($actual_html,0,$startPos);
$lastPart=substr($actual_html,$endPos+strlen('#ends#'));

$dynamicContentPart=substr($actual_html,$startPos+strlen('#starts#'),$endPos-$startPos-strlen("#starts#"));
$modifiedActualFinalContent='';

foreach($data->data as $row){

    $sequence = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

    if($row->timing_close=='close'){

        $day = $row->day;
        $length = strlen($day);

        if($length>18){

            $days_arr = explode(",", $day);

            $flag = true;
            for($i=0; $i<count($days_arr)-1; $i++){
                $idx = array_search($days_arr[$i], $sequence) + 1;
                $idx1 = array_search($days_arr[$i+1], $sequence) + 1;

              

                if(!(($idx+1)==$idx1)){
                    $flag = false;
                    break;
                }
            }

            if($flag==true){

                $first_day = $days_arr[0];
                $last_day = $days_arr[count($days_arr)-1];
                
                $final = $first_day . "-" . $last_day;

                $modifiedContent=str_replace("#days#", $final ,$dynamicContentPart);
                $modifiedContent=str_replace("#time#","close",$modifiedContent);
            }
            else{
                
                $modifiedContent=str_replace("#days#",$day,$dynamicContentPart);
                $modifiedContent=str_replace("#time#","close",$modifiedContent);
            }
        }
        else{

            $modifiedContent=str_replace("#days#",$day,$dynamicContentPart);
            $modifiedContent=str_replace("#time#","close",$modifiedContent);
        }
    }
    else{

        $day = $row->day;
        $length = strlen($day);

        if($length>18){

            $days_arr = explode(",", $day);
           
            $flag = true;

            for($i=0; $i<count($days_arr)-1; $i++){
                $idx = array_search($days_arr[$i], $sequence) + 1;
                $idx1 = array_search($days_arr[$i+1], $sequence) + 1;

// new changes for pushing 


// checking main branch code for develop branch


                if(!(($idx+1)==$idx1)){
                    $flag = false;
                    break;
                }
            }


            if($flag==true){

                $first_day = $days_arr[0];
                $last_day = $days_arr[count($days_arr)-1];
                
                $final = $first_day . "-" . $last_day;

                $modifiedContent=str_replace("#days#", $final ,$dynamicContentPart);
                $start_time = $row->timing_start;
                $end_time =  $row->timing_end;
                $fulltime = $start_time . "-" . $end_time;
                $modifiedContent=str_replace("#time#", $fulltime , $modifiedContent);
               
            }
            else{
                
                $modifiedContent=str_replace("#days#",$day,$dynamicContentPart);
                $start_time = $row->timing_start;
                $end_time =  $row->timing_end;
                $fulltime = $start_time . "-" . $end_time;
                $modifiedContent=str_replace("#time#", $fulltime , $modifiedContent);
                
            }
        }
        else{

            $modifiedContent=str_replace("#days#",$day,$dynamicContentPart);
            $start_time = $row->timing_start;
            $end_time =  $row->timing_end;
            $fulltime = $start_time . "-" . $end_time;
            $modifiedContent=str_replace("#time#", $fulltime , $modifiedContent);
        }
        
    }

    $modifiedActualFinalContent=$modifiedActualFinalContent.$modifiedContent;

}



$result= $content->data[0]->css . $firstPart . $modifiedActualFinalContent . $lastPart;

return $result;
}


public function validation3(){

    $display = array(
        'msg' => "Please provide id for get html of our deals and restaurant_id for getting items of the restaurant",
        'status' => 401
    );

    $this->output->set_content_type('appliacation/json');
    $this->output->set_status_header(401);
    $this->output->set_output(json_encode($display));
}

public function validation4(){

    $display = array(
        'msg' => "Please provide restaurant_id for getting items of the restaurant",
        'status' => 401
    );

    $this->output->set_content_type('appliacation/json');
    $this->output->set_status_header(401);
    $this->output->set_output(json_encode($display));
}

public function get_our_deals_data($id, $restaurant_id){

    $url_html = "http://localhost/Webbuilder/get_deals_html/" . $id;
    $url_menu = "http://localhost/Webbuilder/get_menu_details/" . $restaurant_id;

    $html_data = $this->MakeCurlCall($url_html, "", "GET");
    $menu_data = $this->MakeCurlCall($url_menu, "", "GET");

    $content = (json_decode($html_data));

    $actual_html = $content->data[0]->html;

    $start_Pos = strpos($actual_html, "#starts#");
    $first_part = substr($actual_html, 0, $start_Pos);
    $end_Pos = strpos($actual_html, "#ends#");
    $last_part = substr($actual_html, ($end_Pos + strlen("#ends#")));
    $dynamic_part = substr($actual_html,$start_Pos + strlen('#starts#') , $end_Pos - $start_Pos - strlen("#starts#"));
   
    $modified_final_content = "";

    $actual_data = (json_decode($menu_data));
    
    foreach($actual_data->data as $row){

        $modified_content = str_replace("#ImageUrl#", $row->menu_image, $dynamic_part);
        $modified_content = str_replace("#MenuPrice#", $row->menu_item_price, $modified_content);
        $modified_content = str_replace("#MenuName#", $row->menu_item_name, $modified_content);
        $modified_content = str_replace("#MenuCategory#", $row->main_category_name_english, $modified_content);
        $modified_content = str_replace("#MenuDescription#", $row->menu_item_description_1, $modified_content);

        $modified_final_content .= $modified_content;

    }
    
    $result = $content->data[0]->css . $first_part . $modified_final_content . $last_part;

    return $result;


}


public function validation5(){

    $display = array(
        'msg' => "Please provide website_id for getting header menu and id for getting header html",
        'status' => 401
    );

    $this->output->set_content_type('appliacation/json');
    $this->output->set_status_header(401);
    $this->output->set_output(json_encode($display));
}

public function validation6(){

    $display = array(
        'msg' => "Please provide id for getting header html",
        'status' => 401
    );

    $this->output->set_content_type('appliacation/json');
    $this->output->set_status_header(401);
    $this->output->set_output(json_encode($display));
}

public function get_header_data($website_id, $id){

    $url_menu = "http://localhost/Webbuilder/get_header_menu/" . $website_id;
    $url_html = "http://localhost/Webbuilder/get_header_html/" . $id;

    $header_data = $this->MakeCurlCall($url_menu, "", "GET");
    $header_html = $this->MakeCurlCall($url_html, "", "GET");

    $content = json_decode($header_html);
    $actual_data = json_decode($header_data);
    
    $actual_html = $content->data[0]->html;

    $start1_pos = strpos($actual_html, "#starts1#");
    $first_part = substr($actual_html, 0, $start1_pos);
    $end1_pos = strpos($actual_html, "#ends1#");
    $menu1_part = substr($actual_html, ($start1_pos + strlen("#starts1#")), ($end1_pos - $start1_pos - strlen("#starts1#")));
    $start2_pos = strpos($actual_html, "#starts2#");
    $start3_pos = strpos($actual_html, "#starts3#");
    $end2_pos = strpos($actual_html, "#ends2#");
    $end3_pos = strpos($actual_html, "#ends3#");
    $menu2_part = substr($actual_html, ($start2_pos + strlen("#starts2#")), $start3_pos - $start2_pos - strlen("#starts2#"));
    $submenu_part = substr($actual_html, ($start3_pos + strlen("#starts3#")), $end3_pos - $start3_pos - strlen("#starts3#"));
    $last_part = substr($actual_html, ($end2_pos + strlen("#ends2#")));


    $final_modified_content = "";

    
    foreach($actual_data->data as $row){
        if($row->sub_menu == null){
           $modified_content = str_replace("#menu#", $row->menu_name, $menu1_part);
           if($row->page_or_link == 1){

           $modified_content = str_replace("#link#", $row->menu_name . ".html", $modified_content);      

           }
           else{

           $modified_content = str_replace("#link#", $row->menu_link, $modified_content);      

           }
           
        }
        else{

           $modified1_content = str_replace("#menu1#", $row->menu_name, $menu2_part);

           $sub_menu = $row->sub_menu;
           $sub_menu_link = $row->sub_menu_link;

           if(str_contains($sub_menu, ',')){

            $arr = explode(',' , $sub_menu);
            $arr1 = explode(',' , $sub_menu_link);
            $i = 0;


            $modified2_content = "";
            foreach($arr as $row1){

                $modified_content = str_replace("#submenu#", $row1, $submenu_part);
                
                if($row->page_link_sub_menu == 1){

                    $modified_content = str_replace("#link#", $row1 . ".html", $modified_content);      
         
                    }
                    else{  

                    $modified_content = str_replace("#link#", $arr1[$i], $modified_content);      
         
                    }

                $modified2_content .= $modified_content;
                
                $i++;
            }

           $modified_content  = $modified1_content . $modified2_content;


           }
           else{

            
            $modified_content = str_replace("#submenu#", $row->sub_menu, $submenu_part);

            if($row->page_link_sub_menu == 1){

                $modified_content = str_replace("#link#", $row->sub_menu . ".html", $modified_content);      
     
                }
                else{  

                $modified_content = str_replace("#link#", $sub_menu_link, $modified_content);      
     
                }

          //  $modified_content = str_replace("#link#", "#", $modified_content); 

           $modified_content  = $modified1_content . $modified_content;

           }                 


        }

        $final_modified_content .=  $modified_content;
    }

 
    $result = $content->data[0]->css . $first_part . $final_modified_content . $last_part;


    return $result;


}


public function validation7(){

    $display = array(
        'msg' => "Please Provide id for get html of about us and restaurant_id for getting contact details",
        'status' => 401
    );

    $this->output->set_content_type('appliacation/json');
    $this->output->set_status_header(401);
    $this->output->set_output(json_encode($display));
}

public function validation8(){

    $display = array(
        'msg' => "Please Provide restaurant_id for getting contact details",
        'status' => 401
    );

    $this->output->set_content_type('appliacation/json');
    $this->output->set_status_header(401);
    $this->output->set_output(json_encode($display));
}

public function about_us_html_contact($id, $restaurant_id){

    $url_html = "http://localhost/Webbuilder/get_about_us_contact_html/" . $id;
    $url_contact = "http://localhost/Webbuilder/get_resta_contact/" . $restaurant_id;

    $html = $this->MakeCurlCall($url_html, "", "GET");
    $details = $this->MakeCurlCall($url_contact, "", "GET");

    $content = json_decode($html);
    //print_r($content);
    $actual_html = $content->data[0]->html;
   // echo $actual_html;
    $actual_data = json_decode($details);

    //print_r($actual_data);
    $start_pos = strpos( $actual_html ,"#starts#");
    $first_part = substr($actual_html, 0, $start_pos);
    $end_pos = strpos($actual_html, "#ends#");
    $last_part = substr($actual_html, ($end_pos + strlen("#ends#")));
    $dynamic_part = substr($actual_html, $start_pos + strlen("#starts#"), ($end_pos - $start_pos) - strlen("#starts#"));
    
    $finalcontent = "";
    $modify_content = str_replace("#address#", $actual_data->data[0]->restaurant_address, $dynamic_part);
    $modify_content = str_replace("#phone#", $actual_data->data[0]->restaurant_number, $modify_content);
    $modify_content = str_replace("#email#", $actual_data->data[0]->restaurant_email, $modify_content);

    $finalcontent .= $modify_content;

    $result = $first_part . $finalcontent. $last_part;

    return($result);



}



public function validation9(){

    $display = array(
        'msg' => "Please Provide id for get gallery html and restaurant_id for getting image url",
        'status' => 401
    );

    $this->output->set_content_type('appliacation/json');
    $this->output->set_status_header(401);
    $this->output->set_output(json_encode($display));
}


public function validation10(){

    $display = array(
        'msg' => "Please Provide restaurant_id for getting image url",
        'status' => 401
    );

    $this->output->set_content_type('appliacation/json');
    $this->output->set_status_header(401);
    $this->output->set_output(json_encode($display));
}


public function get_gallery_html_image_url($id, $restaurant_id){

    $url_html = "http://localhost/Webbuilder/get_gallery_html/" . $id;
    $url_image = "http://localhost/Webbuilder/get_gallery_image_url/" . $restaurant_id;

    $html = $this->MakeCurlCall($url_html, "", "GET");
    $image = $this->MakeCurlCall($url_image, "", "GET");

    $content = json_decode($html);
    $actual_html = $content->data[0]->html;
    $data = json_decode($image);
    $actual_data = $data->data;
    //print_r($actual_data); 

    $start_pos = strpos($actual_html, "#starts#");
    $first_part = substr($actual_html, 0, $start_pos);
    $end_pos = strpos($actual_html, "#ends#");
    $last_part = substr($actual_html, $end_pos + strlen("#ends#"));
    $dynamic_part = substr($actual_html, $start_pos + strlen("#starts#"), ($end_pos - $start_pos) - strlen("#starts#"));
    //echo $dynamic_part;
    $final_modification = "";

    foreach($actual_data as $rows){

        $final_modification .= str_replace("#imageurl#", $rows->image_name, $dynamic_part);

    }

    $result = $first_part . $final_modification . $last_part;

    return $result;


}

    public function index(){

        $result['result'] = $this->get_header_data(1,2);

        $this->load->view('Header', $result);

        $data['our_deals'] = $this->get_our_deals_data(1, 1);

        $this->load->view('Home', $data);
       // $this->load->view('Contact', $data);
       $data['show'] = $this->get_gallery_html_image_url(1,3);

       $this->load->view('Gallery', $data);


        $data['data'] = $this->getHtmlForFooter(1, 1);
        $data['result'] = $this->about_us_html_contact(1,1);

        $this->load->view('Footer', $data);

    }






    public function about(){
        $result['result'] = $this->get_header_data(1,1);
        
        $this->load->view('Header', $result);        
        $this->load->view('About');
        $data['data'] = $this->getHtmlForFooter(5, 1);
        $this->load->view('Footer', $data);

    }

    public function contact(){

        $result['result'] = $this->get_header_data(1,1);

        $this->load->view('Header', $result);
        $this->load->view('Contact');
        $data['data'] = $this->getHtmlForFooter(5, 1);
        $this->load->view('Footer', $data);

    }


    public function gallery(){

        $result['result'] = $this->get_header_data(1,1);

        $this->load->view('Header', $result);
        $this->load->view('Gallery');
        $data['data'] = $this->getHtmlForFooter(5, 1);        
        $this->load->view('Footer', $data);

    }

    public function get_reservation_html($id){

        $url = "http://localhost/Webbuilder/get_book_table_html/" . $id;
        $data = $this->MakeCurlCall($url, "", "GET");
        
        $content = json_decode($data);
        $html = $content->data[0]->html;
        
        return $html;


    }

    public function reservation(){

        $result['result'] = $this->get_header_data(1,1);
        $this->load->view('Header', $result);
    
        $data['html'] = $this->get_reservation_html(1);
        $this->load->view('Reservation', $data);

        $data['data'] = $this->getHtmlForFooter(1, 1);
        $data['result'] = $this->about_us_html_contact(1,5 );
        
        $this->load->view('Footer', $data);

    }
}