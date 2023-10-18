<?php

class Reservation extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library(array('session', 'email'));

    }

    public function index(){


        $name = $this->input->post('name');
        $from_email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $date = $this->input->post('date');
        $time = $this->input->post('time');
        $people = $this->input->post('people');
        $message = $this->input->post('message');



        $body = "Name : ". $name . "<br>";
        $body .= "Phone : " . $phone ."<br>";
        $body .=  "Date : " . $date . "<br>";
        $body .= "Time : " . $time ."<br>";
        $body .= "People : " . $people ."<br>";

        $message = $body . $message;

       $to_email = 'info@softawork.eu';

            //configure email settings
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://mail.softawork.eu';
            $config['smtp_port'] = '465';
            $config['smtp_user'] = 'info@softawork.eu';
            $config['smtp_pass'] = '#CFT.gxrEPK%';
            $config['mailtype'] = 'html';
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $config['newline'] = "\r\n"; //use double quotes
            $this->load->library('email');
            $this->email->initialize($config);                   

            //send mail
            $this->email->from($to_email, $name);
            $this->email->to($to_email);
            $this->email->subject("Book our Table");
            $this->email->message($message);

            
          
            //$result = mail($to_email, $subject, $message);
           // echo $result;
            if ($this->email->send())
            {
                // mail sent

               $display = array(
                'msg' => "Mail send successfully",
                'status' => 200
               );

               
            $this->output->set_content_type("application/json");
            $this->output->set_status_header(200);
            $this->output->set_output(json_encode($display));

            }
            else
            {
              
                show_error($this->email->print_debugger());    
                $display = array(
                    'msg' => "Mail not send successfully",
                    'status' => 401
                   );

                   
            $this->output->set_content_type("application/json");
            $this->output->set_status_header(401);
            $this->output->set_output(json_encode($display));

            }

    }
}