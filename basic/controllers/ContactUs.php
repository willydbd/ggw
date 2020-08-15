<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContactUs extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public $key = '';
    public $from = '';
    public $from_name = '';
    public $to = '';
    public $to_name = '';
    public $cc = '';
    public $mail_message = '';
    public $mail_subject = '';
    public $bcc = '';
    public $today = '';
    public $attached_file = '';


	function __construct() 
	{ 
		 parent::__construct();
                //$this->load->model('admin_model'); //calling the model file name news_model.php
                $this->load->helper('url_helper');
                $this->load->helper('url');
                $this->load->library('encryption');
                $this->load->library('email');
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->load->helper('date');
                $this->load->library('session');
                $this->load->helper('captcha');
                $this->load->helper('file');
                

                $this->key = 'gh@#ffyf!;kjiuh&*rgd';//$this->random_key_string();

                $this->today = date('Y-m-d H:i:s');
	}

	public function index()
	{

		if(isset($this->session->userdata['captcha_image_path']))
		{
			//FCPATH - path to front controller, usually index.php
			//APPPATH - path to application folder
			//BASEPATH - path to system folder.

			//$tfg = "./captcha_images/".$this->session->userdata['captcha_image_path'];
			$tfg = FCPATH."captcha_images/".$this->session->userdata['captcha_image_path'];			
			
			if(is_file($tfg))
				unlink($tfg);			
	    }

		$cap = $this->refresh_captcha();
		$contact_us_data['cap_image'] = $cap['captcha_image'];
		$contact_us_data['cap_code'] = $cap['captcha_code'];
		$this->session->set_userdata('captcha_image_path',$cap['captcha_image_path']);

		if(!empty($_POST['logger']))
		{
			$from_email = $this->test_input( $_POST['your-email'] );
			$c_subj = $this->test_input( $_POST['your-subject'] );
			$c_name = $this->test_input( $_POST['your-name'] );
			$c_msg = $this->test_input( $_POST['your-message'] );
			$c_code = $this->test_input( $_POST['your-captcha'] );			

			$this->from = $from_email;
			$this->from_name = $c_name;
			$this->to = 'support@goldensoulindustries.com';
			$this->to_name = 'Golden Soul Industries Support';
			$this->cc = 'sinache@goldensoulindustries.com';
			//$this->cc = 'braverydude@gmail.com';
			$contact_us_data['contname'] = $c_name;
			$contact_us_data['msubj'] = $c_subj;
			$contact_us_data['cname'] = $c_name.' ::Web Contact';
			$contact_us_data['cemail'] = $from_email;
			$contact_us_data['msg'] = $c_msg;	

			$this->mail_subject = $c_subj;
			$this->mail_message = $this->load->view('mails/contact',$contact_us_data,TRUE);
 
			$this->form_validation->set_rules('your-email', 'Your Email', 'required');
			if($this->form_validation->run() == TRUE)
				$this->form_validation->set_rules('your-email', 'Your Email', 'valid_email');

			$this->form_validation->set_rules('your-subject', 'Your Mail Subject', 'required'); 
			$this->form_validation->set_rules('your-name', 'Your Name', 'required'); 
			$this->form_validation->set_rules('your-message', 'Your Message', 'required'); 
			$this->form_validation->set_rules('your-captcha', 'Captcha', 'required');
		
			if($this->form_validation->run() == TRUE)
			{
				if($c_code == $this->session->userdata("captcha_code") )
				{
					$this->dispatchMail();
				}
				else
				{
					/*$this->session->set_flashdata("email_sent_error","Invalid Code, Try Again cc: ".$c_code." bc: ".$this->session->userdata("captcha_code"));*/
					$this->session->set_flashdata("email_sent_error","Invalid Code, Try Again");
				}				
			}
		}

		$this->session->set_userdata('captcha_code',$cap['captcha_code']);
		
		$this->load->view('contact_us',$contact_us_data);

	}
    public function dispatchMail()
    {
            $from = $this->from;
            $to = $this->to;
            $from_name = $this->from_name;
            $to_name = $this->to_name;
            $bcc = $this->bcc;
            $cc = $this->cc;
            $subject = $this->mail_subject;
            $message = $this->mail_message;

            require 'phpmailer/PHPMailerAutoload.php'; // Phpmail package already on server

			$mail = new PHPMailer();

			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->SMTPAuth = true; // enable SMTP authentication
			$mail->Host = "localhost"; // sets the SMTP server
			$mail->Port = 25; // set the SMTP port for the GMAIL server
			$mail->Username = "support@goldensoulindustries.com"; // SMTP account username
			$mail->Password = "Htu4VEnb*)Ih"; // SMTP account password

			$mail->SetFrom($from, $from_name);
			$mail->AddReplyTo($from,$from_name);
			$mail->Subject = $subject;
			//$mail->
			$mail->MsgHTML($message);
			$mail->AddAddress($to);
			$mail->AddCC($cc, "");
			$mail->AddBCC($bcc, "");
			
			//$mail->AddAttachment(""); // C:\Users\Akinsola\Documents\501.pdf --file full path
			

			if(!$mail->Send()) 
			{
				$this->session->set_flashdata("email_sent_error","Oops! something went wrong, try again"); 
			} else {
				$this->session->set_flashdata("email_sent_success","Email sent successfully."); 
			}

	         //$this->session->set_flashdata("email_sent",$this->email->print_debugger()); */

    }
    public function test_input($data)
	{
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	public function refresh_captcha($length = 10)
	{
		$rstr = $this->generateRandomString(8,'numeric');
		$vals = array(
        'word'          => $rstr,
        'img_path'      => 'captcha_images/',
        'img_url'       => base_url().'captcha_images/',
        'font_path'     => './path/to/fonts/texb.ttf',
        'img_width'     => '150',
        'img_height'    => '45',
        'expiration'    => 7200,
        'word_length'   => 8,
        'font_size'     => '60',
        'img_id'        => 'Captcha_Imageid',
        'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

        // White background and border, black text and red grid
        'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
		        )
		);

		$cap_val =  create_captcha($vals);
		$captcha_values['captcha_code'] = $cap_val['word'];
		$captcha_values['captcha_image'] = $cap_val['image'];
		$captcha_values['captcha_image_path'] = $cap_val['filename'];

		return $captcha_values;

	}

	public function generateRandomString($length = 10,$data_type=false) 
	{
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    if($data_type == 'numeric')
	    	$characters = '0123456789';
	    if($data_type == 'alphabetic')
	    	$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) 
	    {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}


}
