<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Customer extends CI_Controller {

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
        $this->load->helper("file");
        $this->load->helper('email');
        

        $this->key = 'gh@#ffyf!;kjiuh&*rgd';//$this->random_key_string();

        $this->today = date('Y-m-d H:i:s');
	}

	public function profile($auth=false)
	{
		$dash_data = array();
		
		if($auth !== false)
		{
			$table = 'customers';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = false;
			$fieldval = false;//"id,email,password";
			$fieldcond = array('email' => $this->base64_url_decode($auth) );
			$tll = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			
			if(!empty($tll) && is_array($tll))
			{
				//$this->index(2);
				
				$dataval = array('activated' => 1);
				$fieldcond = array('email' => $this->base64_url_decode($auth) );
				$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
				if($s_data2)
				{
					$dash_data['activation'] = '<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button> <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span> Your account is successfully activated. </div>';
				}
				$_SESSION['customer_info'] = $tll[0];
				$_SESSION['customer_gate_pass'] = $tll[0]['id'];
				$_SESSION['customer_gate_pass_time'] = time();
				$ff = true;

				$this->load->view('profile', $dash_data);
			}
			else
				$this->index(1);

		}
		else if (empty($_SESSION['customer_gate_pass']) || empty($_SESSION['customer_gate_pass_time'])  || ((time() - $_SESSION['customer_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['customer_gate_pass'] = '';
			$_SESSION['customer_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$table = 'customers';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = false;
			$fieldval = false;//"id,email,password";
			$fieldcond = array('email' => $_SESSION['customer_info']['email'] );
			$tll = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			
			if(!empty($tll) && is_array($tll))
			{
				$_SESSION['customer_info'] = $tll[0];
				$_SESSION['customer_gate_pass'] = $tll[0]['id'];
				$_SESSION['customer_gate_pass_time'] = time();
				$ff = true;

				$this->load->view('profile', $dash_data);
				//$this->load->view('myorders', $dash_data);
			}
			else
				$this->index(1);			
			
		}

		
	}

	public function my_orders()
	{
		$dash_data = array();
		
		if (empty($_SESSION['customer_gate_pass']) || empty($_SESSION['customer_gate_pass_time'])  || ((time() - $_SESSION['customer_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['customer_gate_pass'] = '';
			$_SESSION['customer_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$table = 'customers';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = false;
			$fieldval = false;//"id,email,password";
			$fieldcond = array('email' => $_SESSION['customer_info']['email'] );
			$tll = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			
			if(!empty($tll) && is_array($tll))
			{
				$_SESSION['customer_info'] = $tll[0];
				$_SESSION['customer_gate_pass'] = $tll[0]['id'];
				$_SESSION['customer_gate_pass_time'] = time();
				$ff = true;

				$table = 'order_packages';		
				$fieldval = 'order_packages.product_name as product_name, order_packages.unit_price as unit_price, order_packages.currency_code as currency_code, order_packages.quantity as quantity, order_packages.product_image as product_image,

					order_log.order_id as order_id, order_log.shipped_date as shipped_date, order_log.delivery_status as delivery_status, order_log.country as country, order_log.state as state, order_log.town_city as town_city, order_log.postcode_zip as postcode_zip, order_log.contact_address as contact_address, order_log.shipping_ref as shipping_ref, order_log.tracking_number as tracking_number, order_log.delivery_date as delivery_date, order_log.transaction_ref as transaction_ref
					';
				$fieldcond = array('order_packages.user_id' => $_SESSION['customer_gate_pass']);
				$ordercond = ['order_packages.updated desc','order_packages.product_name asc'];
				$limitoffsetcond = false;
		        $jt_wt_cond = array("order_log" => "order_packages.user_id=order_log.user_id");

				$dash_data['orders_data'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond);

				//var_dump($dash_data['orders_data']);

				//$this->load->view('profile', $dash_data);
				$this->load->view('myorders', $dash_data);
			}
			else
				$this->index(1);


			
		}

		
	}	

	public function signup()
	{
		$table='customers';
		$dash_data['contact_name'] = "";
		$dash_data['email'] = "";
		$dash_data['password'] = "";
		$dash_data['cpassword'] = "";
		$target_file = '';
		$dash_data['ntf'] = '';

		if(!empty($_POST['customersignuplogger']) )
		{
			//var_dump($_POST);

			$this->form_validation->set_rules('fullname', 'Full Name', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('re_pass', 'Confirm Password', 'required');

			if(($this->form_validation->run() == TRUE)  )
			{
				$fullname = $this->test_input($_POST['fullname']);
				$email = $this->test_input($_POST['email']);
				$password = $this->test_input($_POST['password']);
				$re_pass = $this->test_input($_POST['re_pass']);

				$error_msg = ''; $generatedhash = '';
				if($password == $re_pass)
					$generatedhash = password_hash($password, PASSWORD_DEFAULT);
				else
					$error_msg .='Password Mismatch';
				if(!valid_email($email))
					$error_msg .='Invalid Email';

				$ordercond = $limitoffsetcond = $matchvallike = false;
				$fieldval = "email"; $fieldcond = array('email' => $email );
				$rchemail = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($rchemail) && is_array($rchemail))
				{
					//var_dump($rchemail);
					$error_msg .= 'This email already exist, Login Instead';
				}

				if(empty($error_msg))
				{
					$dataval = array(
										'contact_name' => $fullname,
										'email' => $email,
										'password' => $generatedhash,
										'updated' => date('Y-m-d h:i:s', time()) 
									);

					$idc = $this->control_engine->insert_master($dataval, $table)[1];
					if(!empty($idc))
					{
						$dash_data['ntf'] = 'Registration Successful. Please check your mail for verification link to continue';
						$this->session->set_flashdata("signup_record_save","Registration Successful. Please check your mail for verification link to continue");

						
						
						

						$contact_us_data['mcmail'] = "info@aanu-london.com";
						$contact_us_data['enqmail'] = "info@aanu-london.com";
						$contact_us_data['mphone'] = "";
						$contact_us_data['mphyaddr'] = "";
						$table = 'social_media';
						$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
						$_SESSION['social_media_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

						if(!empty($_SESSION['social_media_data']) && is_array($_SESSION['social_media_data']))
			            {
			                foreach ($_SESSION['social_media_data'] as $key => $value) 
			                {
			                    if($value['title'] == 'Contact-Email')
			                        $contact_us_data['mcmail'] = $value['address'];
			                    if($value['title'] == 'Enquiry-Email')
			                        $contact_us_data['enqmail'] = $value['address'];
			                    if($value['title'] == 'Physical-Address')
			                        $contact_us_data['mphyaddr'] = $value['address'];
			                    if($value['title'] == 'Phone-Number')
			                        $contact_us_data['mphone'] = $value['address'];
			                    
			                }
			            }

			            $this->from = $contact_us_data['mcmail']; 
						$this->from_name = 'AANU-LONDON';
						$this->to = $email;
						$this->to_name = $fullname;
						//$this->cc = 'enquiries@aanu-london.com,support@aanu-london.com';
						$this->mail_subject = 'ACCOUNT VERIFICATION | AANU-LONDON';
						$contact_us_data['msg'] = "Save time on purchasing and checking out by logging into your account";
						$contact_us_data['gotoaccount_text'] = 'Go-to My Account';
						$contact_us_data['gotoaccount_link'] = base_url().'customer/profile/'.$this->base64_url_encode($email);	
						$contact_us_data['newsletter_link'] = base_url().'welcome/index/'.$this->base64_url_encode($email).'/#aanulondonnewsletter';

						$this->mail_message = $this->load->view('mails/regcustomer',$contact_us_data,TRUE);
						$this->dispatchMail();
					}
				    else
				    {
				    	$this->session->set_flashdata("signup_record_error","Sorry, record could not be saved!");
				    }
				}
				else
				{
					$this->session->set_flashdata("signup_record_error",$error_msg);
				}
				

				

			}


			
		}

		//redirect('Welcome');
		$this->load->view('register',$dash_data);


	}

	public function change_details()
	{
		$dash_data=array();
		if (empty($_SESSION['customer_gate_pass']) || empty($_SESSION['customer_gate_pass_time'])  || ((time() - $_SESSION['customer_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['customer_gate_pass'] = '';
			$_SESSION['customer_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$table = 'customers';
			$target_file = '';

			if(!empty($_POST['customerprofilechange']) )
			{
				//var_dump($_POST);

				

				$this->form_validation->set_rules('contact_name', 'Contact Name', 'required');
				$this->form_validation->set_rules('town_city', 'Town/City', 'required');
				$this->form_validation->set_rules('postcode_zip', 'Post Code/Zip', 'required');
				$this->form_validation->set_rules('contact_address', 'Contact Address', 'required');
				$this->form_validation->set_rules('phone', 'Phone', 'required');

				if(($this->form_validation->run() == TRUE)  )
				{
					$contact_name = $this->test_input($_POST['contact_name']);
					$country = $this->test_input($_POST['country']);
					$state = $this->test_input($_POST['state']);
					$town_city = $this->test_input($_POST['town_city']);
					$postcode_zip = $this->test_input($_POST['postcode_zip']);
					$contact_address = $this->test_input($_POST['contact_address']);
					$phone = $this->test_input($_POST['phone']);
					$email = $this->test_input($_POST['email']);
					$current_password = $this->test_input($_POST['current_password']);
					$new_password = $this->test_input($_POST['new_password']);
					$confirm_new_password = $this->test_input($_POST['confirm_new_password']);

					$dataval = array(
										'contact_address' => $contact_address,
										'country' => $country,
										'state' => $state,
										'town_city' => $town_city,
										'postcode_zip' => $postcode_zip,
										'contact_address' => $contact_address,
										'phone' => $phone,
										'updated' => date('Y-m-d h:i:s', time()) 
									);
					$fieldcond = array('email' => $email );

					//var_dump($_POST);
					$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
					if($s_data2)
					{
						$mmmsg = "Record Saved!";
						//var_dump($mmmsg);
						if(isset($_POST['cbox']))
						{
							$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = false;
							$fieldval = "password";
							$fieldcond = array('email' => $email );
							$tll = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

							if(!empty($tll) && is_array($tll) && password_verify($current_password, $tll[0]["password"]))
							{

								if(!empty($new_password)&&($new_password == $confirm_new_password))
								{
									$generatedhash = password_hash($new_password, PASSWORD_DEFAULT);
									$dataval = array('password' => $generatedhash);
									$fieldcond = array('email' => $email );
									$s_data1 = $this->control_engine->update_master($dataval,$table,$fieldcond);
									if($s_data1)
										$mmmsg .= ' Password is also changed';
									else
										$mmmsg .= ' But Password could not be changed. You may try again later';
								}
								else
									$mmmsg .= ' But new password is mismatched';
							}
							else
								$mmmsg .= ' But Password could not be changed due to invalid verification';
							
						}
						
						$this->session->set_flashdata("record_save",$mmmsg);
						$dash_data['record_save'] = $mmmsg;
						//var_dump($this->session->flashdata('record_save'));
						//if(!empty($current_password))
					}
				    else
				    {
				    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
				    	$dash_data['record_error'] = "Sorry, record could not be saved!";
				    }
					

				    $fieldcond = $ordercond = $limitoffsetcond = $matchvallike = false;
					$fieldval = false;//"id,email,password";
					$fieldcond = array('email' => $_SESSION['customer_info']['email'] );
					$tll = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
					

				}


				
			}


			
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = false;
			$fieldval = false;//"id,email,password";
			$fieldcond = array('email' => $_SESSION['customer_info']['email'] );
			$tll = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			
			if(!empty($tll) && is_array($tll))
			{
				$_SESSION['customer_info'] = $tll[0];
				$_SESSION['customer_gate_pass'] = $tll[0]['id'];
				$_SESSION['customer_gate_pass_time'] = time();
				$ff = true;
			}


			
			

			$this->load->view('edit_profile', $dash_data);
		}
			
	}

	public function index($auth=false,$page_para=false)
	{
		//var_dump(base_url());
		$reff = '';
		if(!empty($_SERVER['HTTP_REFERER']))
			$reff = $_SERVER['HTTP_REFERER'];
		else if(!empty($_SERVER['PHP_SELF']))
			$reff = $_SERVER['PHP_SELF'];

		//var_dump($reff);
		//var_dump(base_url());		
		$reff = explode('/', $reff);
		$reffer = '';
		$referpass = '';
		if(is_array($reff));
		{
			$coreectref = false;
			$refcount = 0;
			//foreach ($reff as $key => $val) 
			for ($i=0; $i < sizeof($reff); $i++)
			{
				if( (!empty($reff[$i])&&($this->findString("checkout",$reff[$i],"i","") !== false)&&($this->findString("logout",$reff[$i],"i","") === false) ) ||
					(!empty($reff[$i])&&($this->findString("product_details",$reff[$i],"i","") !== false)&&($this->findString("logout",$reff[$i],"i","") === false) &&($i<(sizeof($reff)-1)) )
				  )
				{
					$coreectref = true;
					if($this->findString("checkout",$reff[$i],"i","") !== false)
						$referpass = "checkout";
					if($this->findString("product_details",$reff[$i],"i","") !== false)
						$referpass = "product_details";
				}
				if($this->findString("logout",$reff[$i],"i","") !== false)
				{
					$coreectref = false;
					//var_dump($coreectref);
				}

				if($coreectref && !empty($reff[$i]))
				{
					if($refcount == 0)
						$reffer .= $reff[$i];
					else
						$reffer .= '/'.$reff[$i];
					$refcount++;
				}
				else
					$reffer = '';
			}
		}
		
		$ff = true;
		// $_SESSION['customer_gate_pass'] = '';
		// $_SESSION['customer_gate_pass_time'] = '';
		if(empty($_SESSION['customer_gate_pass']))
		{
			$ff = false;	
			$_SESSION['customer_gate_pass'] = '';
			$_SESSION['customer_gate_pass_time'] = '';
		}
		
		$ttv = $ttv2 = '';
		$dashboard_data['ntf'] = '';
		if(!empty($_POST['customerloginlogger']) )
		{
			$ttv = $_POST['password'];
			$ttv2 = $_POST['email'];	

			$ttv = $this->test_input($_POST['password']);
			$ttv2 = $this->test_input($_POST['email']);	
			$table = 'customers';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = false;
			$fieldval = false;//"id,email,password";
			$fieldcond = array('email' => $ttv2 );
			$tll = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			
			if(!empty($tll) && is_array($tll))
			{
				if(password_verify($ttv, $tll[0]['password']))
				{
					if($tll[0]['activated'] == 1)
					{
						$_SESSION['customer_info'] = $tll[0];
						$_SESSION['customer_gate_pass'] = $tll[0]['id'];
						$_SESSION['customer_gate_pass_time'] = time();
						$ff = true;


						$offline = $online = $userid = false;

						if(!empty($_SESSION['cart_info_detail']))
							$offline = $_SESSION['cart_info_detail'];
						if(!empty($_SESSION['customer_info']['cart_box']))
							$online = $_SESSION['customer_info']['cart_box'];
						if(!empty($_SESSION['customer_gate_pass']))
							$userid = $_SESSION['customer_gate_pass'];

						$this->pre_cart_process($offline,$online,$userid);

						/*var_dump($offline);
						var_dump($online);
						var_dump($_SESSION['cart_info_detail']);*/
					}
					else
					{
						$dashboard_data['ntf'] .= '<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button> <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span> Your account needs activation. Please check your email to continue. </div>';
					}
					
				}
				else
				{
					$dashboard_data['ntfo'] = 1;
					$dashboard_data['ntf'] = '<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button> <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span> Invalid Login Parameter </div>';
					$this->session->set_flashdata("login_record_error","Invalid Login Parameter!");
				}
			}
			else
			{
				$dashboard_data['ntfo'] = 2;
				$dashboard_data['ntf'] .= '<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button> <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span> This account does not exist with us. <a href="'.base_url().'customer/signup"><h5> Register Instead</h5></a>  </div>';
			}
		}

		/*if(($ff)&&(!empty($reffer)))
		{
			redirect('/'.$reffer);
		}
		else if($ff)
			$this->profile(); */

		if(!empty($reffer))
		{
			//$referpass = '';
			//var_dump($dashboard_data['ntf']);
			if(!empty($dashboard_data['ntfo'])&&($dashboard_data['ntfo'] == 1))
			{
				$_SESSION['login_error'] = '<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button> <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span> Invalid Login Parameter </div>';
			}
			if(!empty($dashboard_data['ntfo'])&&($dashboard_data['ntfo'] == 2))
			{
				$_SESSION['login_error'] = '<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button> <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span> This account does not exist with us. <a href="'.base_url().'customer/signup"><h5> Register Instead</h5></a>  </div>';
			}

			
			//redirect('/Shop/'.$referpass.'/'.$this->base64_url_encode($dashboard_data['ntfo']));
			// var_dump($referpass);
			// var_dump($page_para);
			if($page_para !== false)
				redirect('/Shop/'.$referpass.'/'.$page_para);
			else
				redirect('/Shop/'.$referpass);
		}
		else if($ff)
			$this->profile();


		/*if($ff)
			$this->profile(); */
		else
		{
			if(($auth !== false)&&($auth==1))
			{
				$dashboard_data['ntf'] .= '<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button> <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span> Your account does not exist with us </div>';
			}
			else if(($auth !== false)&&($auth==2))
			{
				$dashboard_data['ntf'] .= '<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button> <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span> Your account is successfully activated. Please login below </div>';
			}
			//$this->load->view('about',$dashboard_data);
			$this->load->view('login',$dashboard_data);
			//redirect('Welcome/index/'.$para);
		}
	}

	public function merge_cart($main=false,$tobeadded=false)
	{
		
		$prdid = '';
		$prqtty = '';
		$prname = '';
		$primg = '';
		$prprice = '';
		
		if(!empty($main) && ($main!== false)&& !empty($tobeadded) && ($tobeadded!== false))
		{

			$prdid = $tobeadded['id'];
			$prqtty = $tobeadded['qtty'];
			$prname = $tobeadded['name'];
			$primg = $tobeadded['img'];
			$prprice = $tobeadded['price'];	

			$ddd = json_decode($main);
			if(is_array($ddd))
			{
				$pr_info = $ddd[0];
				$founded = false;
				$nprprice = $prprice * $prqtty;
				$ntotalq = $ntotalpr = 0;
				if(!empty($pr_info) && is_array($pr_info))
				{
					for ($i=0; $i <sizeof($pr_info); $i++) 
					{ 
						if(isset($pr_info[$i]->id) && ($pr_info[$i]->id == $prdid))
						{
							//$pr_info[$i]->qtty = $pr_info[$i]->qtty + $prqtty;
							$pr_info[$i]->qtty = $prqtty;
							$nprprice = $prprice * $pr_info[$i]->qtty;
							$pr_info[$i]->price = $nprprice;
							$founded = true;
						}
						$ntotalpr = $ntotalpr + $pr_info[$i]->price;
						$ntotalq = $ntotalq + $pr_info[$i]->qtty;

					}
					if($founded)
						$ddd[0] = $pr_info;
					else
					{
						$pr_details = array();
						$cart_details = array();
						$pr_data = array('id' => $prdid,
										 'img' => $primg,
										 'title' => $prname,
										 'price' => $nprprice,
										 'prname' => $prname,
										 'qtty' => $prqtty
						 				);
						array_push($ddd[0], $pr_data);
						$ntotalpr = $ntotalpr + $nprprice;
						$ntotalq = $ntotalq + $prqtty;
					}

					$cart_info = $ddd[1];
					if(isset($cart_info->total_qtty))
					{
						$cart_info->total_qtty = $ntotalq;
					}
					if(isset($cart_info->total_price))
					{
						$cart_info->total_price = $ntotalpr;
					}

					return json_encode($ddd);
				}
				else
				{
					$pr_details = array();
					$cart_details = array();
					$prprice = $prprice * $prqtty;
					$pr_data = array('id' => $prdid,
									 'img' => $primg,
									 'title' => $prname,
									 'price' => $prprice,
									 'prname' => $prname,
									 'qtty' => $prqtty
					 				);
					array_push($pr_details, $pr_data);

					$cart_data = array('total_qtty' => $prqtty,'total_price' => $prprice );
					array_push($cart_details, $pr_details);
					array_push($cart_details, $cart_data);

					$eee = json_encode($cart_details);
					return $eee;
					//echo $eee;

				}			

			}
			else
				return '';
		}

	}

	public function pre_cart_process($offline=false,$online=false,$userid=false)
	{
		if($offline !== false && $online !== false && $userid !== false && is_numeric($userid))
		{
			if(empty($online) && !empty($offline))
			{
				$online = $offline;
				$table = 'customers';
				$dataval = array('cart_box' => $online);
				$fieldcond = array('id' => $userid );
				$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
			}
			elseif(empty($offline) && !empty($online))
			{
				$offline = $online;
				$_SESSION['cart_info_detail'] = $offline;
			}
			else
			{
				$ddd = json_decode($offline);
				if(is_array($ddd))
				{
					$pr_info = $ddd[0];
					if(!empty($pr_info) && is_array($pr_info))
					{
						//var_dump($pr_info);
						for ($i=0; $i <sizeof($pr_info); $i++) 
						{ 
							if( isset($pr_info[$i]->id) && 
								isset($pr_info[$i]->qtty) &&
								isset($pr_info[$i]->prname) &&
								isset($pr_info[$i]->img) &&
								isset($pr_info[$i]->price)
							  )
							{
								$tobeadded = array();
								$tobeadded['id'] = $pr_info[$i]->id;
								$tobeadded['qtty'] = $pr_info[$i]->qtty;
								$tobeadded['name'] = $pr_info[$i]->prname;
								$tobeadded['img'] = $pr_info[$i]->img;
								$tobeadded['price'] = $pr_info[$i]->price;

								//var_dump($tobeadded);

								$main = $online;
								$main = $this->merge_cart($main,$tobeadded);
								$online = $main;
								$_SESSION['cart_info_detail'] = $online;

								$table = 'customers';
								$dataval = array('cart_box' => $online);
								$fieldcond = array('id' => $userid );
								$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);

							}
							else
								$_SESSION['cart_info_detail'] = $online;
								
						}
					}
					else
						$_SESSION['cart_info_detail'] = $online;
				}
				else
					$_SESSION['cart_info_detail'] = $online;
			}

		}

	}

	public function password_reset($email_auth=false,$pass_auth=false)
	{
		if(($email_auth !== false)&&($pass_auth !== false))
		{
			$email = $this->base64_url_decode($email_auth);	
			$pass = $this->base64_url_decode($pass_auth);	
			$newgeneratedpassword = password_hash($pass, PASSWORD_DEFAULT);

				
			$table = 'customers';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = false;
			$fieldval = false;//"id,email,password";
			$fieldcond = array('email' => $email );
			$tll = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			
			if(!empty($tll) && is_array($tll))
			{
				$dataval = array('password' => $newgeneratedpassword);
				$fieldcond = array('email' => $email );
				$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
				if($s_data2)
				{
					$this->index();
				}
				else
				{
					$this->load->view('password_reset',$dashboard_data);
				}
			}
			else
			{
				$this->index(1);
			}

		}
		else
		{
			$dashboard_data['ntf'] = '';
			if(!empty($_POST['customerloginlogger']) )
			{
				$email = $_POST['email'];	
				$email = $this->test_input($_POST['email']);	
				$table = 'customers';
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = false;
				$fieldval = false;//"id,email,password";
				$fieldcond = array('email' => $email );
				$tll = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
				
				if(!empty($tll) && is_array($tll))
				{
					$fullname = $tll[0]['contact_name'];

					$contact_us_data['mcmail'] = "info@aanu-london.com";
					$contact_us_data['enqmail'] = "info@aanu-london.com";
					$contact_us_data['mphone'] = "";
					$contact_us_data['mphyaddr'] = "";
					$table = 'social_media';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$_SESSION['social_media_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					if(!empty($_SESSION['social_media_data']) && is_array($_SESSION['social_media_data']))
		            {
		                foreach ($_SESSION['social_media_data'] as $key => $value) 
		                {
		                    if($value['title'] == 'Contact-Email')
		                        $contact_us_data['mcmail'] = $value['address'];
		                    if($value['title'] == 'Enquiry-Email')
		                        $contact_us_data['enqmail'] = $value['address'];
		                    if($value['title'] == 'Physical-Address')
		                        $contact_us_data['mphyaddr'] = $value['address'];
		                    if($value['title'] == 'Phone-Number')
		                        $contact_us_data['mphone'] = $value['address'];
		                    
		                }
		            }

		            $this->from = $contact_us_data['mcmail']; 
					$this->from_name = 'AANU-LONDON';
					$this->to = $email;
					$this->to_name = $fullname;
					//$this->cc = 'enquiries@aanu-london.com,support@aanu-london.com';
					$this->mail_subject = 'PASSWORD RESET | AANU-LONDON';

					$newpass = $this->generateRandomString(10);
					$newgeneratedpassword = password_hash($newpass, PASSWORD_DEFAULT);

					$contact_us_data['msg'] = "Dear ".$fullname.",<br>You requested for password on our website on ".date('Y-m-d h:i:s', time()).". Your new password is: <b>".$newpass."</b>. Click the login button below to confirm that you authorize the password reset";
					$contact_us_data['gotoaccount_text'] = 'Login to My Account';
					$contact_us_data['gotoaccount_link'] = base_url().'customer/password_reset/'.$this->base64_url_encode($email).'/'.$this->base64_url_encode($newpass);	
					$contact_us_data['newsletter_link'] = base_url().'welcome/index/'.$this->base64_url_encode($email).'/#aanulondonnewsletter';

					$this->mail_message = $this->load->view('mails/regcustomer',$contact_us_data,TRUE);
					$this->dispatchMail();
				}
				else
				{
					$dashboard_data['ntf'] .= '<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button> <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span> This account does not exist with us. <a href="'.base_url().'customer/signup"><h5> Register Instead</h5></a>  </div>';
				}
			}

			$this->load->view('password_reset',$dashboard_data);
		}


	}

	public function logout($trans=false)
	{
		$_SESSION['customer_gate_pass'] = '';
		$_SESSION['customer_gate_pass_time'] = '';
		$_SESSION['customer_info'] = '';
		$_SESSION['cart_info_detail'] = '';
		$trans_page_para = 1;
		if($trans !== false)
			$_SESSION['page_para'] = $trans;
		//var_dump($_SESSION['page_para']);
        if(!empty($_SESSION['page_para']))
        {
        	$trans_page_para = $_SESSION['page_para'];        	
			$this->index(0,$trans_page_para);	
        }
        else
        	$this->index();
            
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



	public function base64_url_encode($input) {
	 return strtr(base64_encode($input), '+/=', '-_-');
	}

	public function base64_url_decode($input) {
	 return base64_decode(strtr($input, '-_-', '+/='));
	}

	


    public function test_input($data)
	{
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	public function generateRandomString($length = 10) 
	{
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	public function findString($needle,$haystack,$i,$word)
	{   // $i should be "" or "i" for case insensitive
	    if (strtoupper($word)=="W")
	    {   // if $word is "W" then word search instead of string in string search.
	        if (preg_match("/\b{$needle}\b/{$i}", $haystack)) 
	        {
	            return true;
	        }
	    }
	    else
	    {
	        if(preg_match("/{$needle}/{$i}", $haystack)) 
	        {
	            return true;
	        }
	    }
	    return false;
	    // Put quotes around true and false above to return them as strings instead of as bools/ints.
	}


}

class BaseIntEncoder 
{

    //const $codeset = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    //readable character set excluded (0,O,1,l)
    const codeset = "23456789abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ";

    static function encode($n){
        $base = strlen(self::codeset);
        $converted = '';

        while ($n > 0) {
            $converted = substr(self::codeset, bcmod($n,$base), 1) . $converted;
            $n = self::bcFloor(bcdiv($n, $base));
        }

        return $converted ;
    }

    static function decode($code){
        $base = strlen(self::codeset);
        $c = '0';
        for ($i = strlen($code); $i; $i--) {
            $c = bcadd($c,bcmul(strpos(self::codeset, substr($code, (-1 * ( $i - strlen($code) )),1))
                    ,bcpow($base,$i-1)));
        }

        return bcmul($c, 1, 0);
    }

    static private function bcFloor($x)
    {
        return bcmul($x, '1', 0);
    }

    static private function bcCeil($x)
    {
        $floor = bcFloor($x);
        return bcadd($floor, ceil(bcsub($x, $floor)));
    }

    static private function bcRound($x)
    {
        $floor = bcFloor($x);
        return bcadd($floor, round(bcsub($x, $floor)));
    }
}