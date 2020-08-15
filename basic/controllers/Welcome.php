<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Welcome extends CI_Controller {

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
                $this->load->model('control_engine'); //calling the model file name news_model.php
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
                $this->load->helper('email');
                

                $this->key = 'gh@#ffyf!;kjiuh&*rgd';//$this->random_key_string();

                $this->today = date('Y-m-d H:i:s');
	}

	public function index($automated_newsletter_sub=false)
	{
		$dash_data['sync_server_url']='';
		
		$table = 'server_url';
		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
		$dash_data['sync_server_url'] = $sync_server_url = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
		if(!empty($sync_server_url) && is_array($sync_server_url))
		{
			$_SESSION['sync_server_url'] = $sync_server_url[0]['url'];
		}

		$this->load->view('index',$dash_data);
	}

	

	public function documentation()
	{
		$this->load->view('welcome_message');
	}

	public function server_info()
	{
		phpinfo();
		/*$a1=array("a"=>"red","b"=>"green","c"=>"blue","d"=>"yellow");
		$a2=array("a"=>"purple","b"=>"orange");
		$a1 = [3,4,1,2,6,7,99,4];
		//array_splice($a1,0,2,$a2);
		//array_splice($a1,3,1);
		//array_push($a1, $a2['a']);
		// $a1 = false;
		// $a1["abg"]="red_abg";
		for ($i=0; $i <sizeof($a1); $i++) 
		{
			if($a1[$i]==4)
				array_splice($a1,$i,1);
		}
		print_r($a1);*/
	}

	


	public function mail_check()
	{
		$contact_us_data['msubj'] = "contact enquiry";
		$contact_us_data['cname'] = "Ibrahim Nwachi";
		$contact_us_data['cemail'] = "sinache@gmail.com";
		$contact_us_data['msg'] = "Hello Admin, I love your product, can you reduce price for me over order of aabout $1000";
		$contact_us_data['mcmail'] = "info@aanu-london.com";
		$contact_us_data['mphone'] = "+44 (0) 203 745 1268";
		$contact_us_data['mphyaddr'] = "85 Great Portland Street, First Floor. London, W1W 7LT. United Kingdom";
		$contact_us_data['enqmail'] = "info@aanu-london.com";
		  



		//$this->load->view('mails/contact',$contact_us_data);

		
		$contact_us_data['msg'] = "Welcome to Aanu-London Family, your very own skin-care, nature’s way. Save time on purchasing and checking out by logging into your account";
		$contact_us_data['gotoaccount_text'] = 'Go-to My Account';	
		$contact_us_data['gotoaccount_link'] = '#';	
		$contact_us_data['newsletter_link'] = '#';
		//$this->load->view('mails/regcustomer',$contact_us_data);	

		$contact_us_data['msg'] = "Thank you for your order from Aanu-London. Once your package ships we will send you a tracking number.";	
		//$this->load->view('mails/ordercustomer',$contact_us_data);	

		$contact_us_data['msg'] = "Thank you for your order from Aanu-London. Your Order <b>#0123456789</b> has shipped and the Shipping information is:";	
		$this->load->view('mails/shippedordercustomer',$contact_us_data);

		//$this->load->view('mails/sample_mail_contact',$contact_us_data);	
		//$this->load->view('mails/sample_mail2',$contact_us_data);	
	}

	public function mail_check2()
	{
		$contact_us_data['msubj'] = "contact enquiry";
		$contact_us_data['cname'] = "Ibrahim Nwachi";
		$contact_us_data['cemail'] = "sinache@gmail.com";
		$contact_us_data['msg'] = "Hello Admin, I love your product, can you reduce price for me over order of aabout $1000";
		$contact_us_data['mcmail'] = "info@aanu-london.com";
		$contact_us_data['mphone'] = "+44 (0) 203 745 1268";
		$contact_us_data['mphyaddr'] = "85 Great Portland Street, First Floor. London, W1W 7LT. United Kingdom";
		$contact_us_data['enqmail'] = "info@aanu-london.com";
		  



		//$this->load->view('mails/contact',$contact_us_data);

		$contact_us_data['msg'] = "Welcome to Aanu-London Family, your very own skin-care, nature’s way. Save time on purchasing and checking out by logging into your account";
		$contact_us_data['gotoaccount_text'] = 'Go-to My Account';	
		$contact_us_data['gotoaccount_link'] = '#';	
		$contact_us_data['newsletter_link'] = '#';
		//$this->load->view('mails/regcustomer',$contact_us_data);	

		$contact_us_data['msg'] = "Thank you for your order from Aanu-London. Once your package ships we will send you a tracking number.";	
		//$this->load->view('mails/ordercustomer',$contact_us_data);	

		$contact_us_data['msg'] = "Thank you for your order from Aanu-London. Your Order <b>#0123456789</b> has shipped and the Shipping information is:";	
		$this->load->view('mails/shippedordercustomer',$contact_us_data);	

			
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

            //require 'phpmailer/PHPMailerAutoload.php'; // Phpmail package already on server
            //require 'PHPMailer-master/PHPMailerAutoload.php';
			//$mail = new PHPMailer();

			// include_once(FCPATH.'PHPMailer/src/PHPMailer.php');
		 //  	include_once(FCPATH.'PHPMailer/src/SMTP.php');
		 //    $mail = new PHPMailer\PHPMailer\PHPMailer();
            
            //var_dump(APPPATH);
	        require APPPATH.'libraries/PHPMailer-master/src/Exception.php';
			require APPPATH.'libraries/PHPMailer-master/src/PHPMailer.php';
			require APPPATH.'libraries/PHPMailer-master/src/SMTP.php';
            $mail = new PHPMailer(true); //true to catch exception

			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->SMTPAuth = true; // enable SMTP authentication
			$mail->Host = "smtp.1and1.com";//"auth.smtp.1and1.co.uk";//"smtp.ionos.co.uk";//"localhost";//smtp.gmail.com sets the SMTP server for gmail
			$mail->Port = 25;//587; //25; // set the SMTP port for the GMAIL server
			$mail->Username = "developer@aanu-london.com";//"info@aanu-london.com"; // SMTP account username
			$mail->Password = "SAkins@4321";//"YuzG23PeYuv.YQY";//"Abbtu4VEnb*)Ih"; // SMTP account password
    
    		$mail->SMTPSecure = 'tls';

			$mail->SetFrom($from, $from_name);
			$mail->AddReplyTo($from,$from_name);
			$mail->Subject = $subject;
			//$mail->
			$mail->MsgHTML($message);
			$mail->AddAddress($to);
			//$mail->AddCC($cc, "");
			//$mail->AddBCC($bcc, "");

			//$mail->WordWrap = 80; // Set word wrap to 80 characters
		    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		    $mail->isHTML(true);  // Set email format to HTML
			
			//$mail->AddAttachment(""); // C:\Users\Akinsola\Documents\501.pdf --file full path
			

			if(!$mail->Send()) 
			{
				$this->session->set_flashdata("email_sent_error","Oops! something went wrong, try again");
				//echo $mail->ErrorInfo; 
			} else {
				$this->session->set_flashdata("email_sent_success","Email sent successfully."); 
			}

	        //$this->session->set_flashdata("email_sent",$this->email->print_debugger()); 

	        /*catch (Exception $e)
			{
			   /* PHPMailer exception. *
			   echo $e->errorMessage();
			}
			catch (\Exception $e)
			{
			   /* PHP exception (note the backslash to select the global namespace Exception class). *
			   echo $e->getMessage();
			}*/

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

	public function test_input($data)
	{
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
    
	public function base64_url_encode($input) {
	 return strtr(base64_encode($input), '+/=', '-_-');
	}

	public function base64_url_decode($input) {
	 return base64_decode(strtr($input, '-_-', '+/='));
	}


}
