<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Shop extends CI_Controller {

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
                $this->load->helper('email');
                

                $this->key = 'gh@#ffyf!;kjiuh&*rgd';//$this->random_key_string();

                $this->today = date('Y-m-d H:i:s');
	}

	public function index($showlimit=9, $showoffset=0, $sort=0, $range=0,$category=0,$price=0, $color=0,$skintype=0,$skinconcern=0)
	{
		$table = 'social_media';
		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
		$_SESSION['social_media_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

		//var_dump($price);
		$skintype = urldecode($skintype);
		$skinconcern = urldecode($skinconcern);

		$searchitem = '';
		if($_GET && !empty($_GET['search']))
			$searchitem = $this->test_input(urldecode($_GET['search']));

		$aanu_data['range'] = $range;
		$aanu_data['category'] = $category;
		$aanu_data['price'] = $price;
		$aanu_data['color'] = $color;
		$aanu_data['showlimit'] = $showlimit;
		$aanu_data['sort'] = $sort;
		$aanu_data['showoffset'] = $showoffset;
		$aanu_data['skintype'] = $skintype;
		$aanu_data['skinconcern'] = $skinconcern;
		$aanu_data['searchitem'] = $searchitem;
		//$skinconcern = 'skin tone';

		$aanu_data['rangename'] = '';
		$aanu_data['categoryname'] = '';
		
		$aanu_data['showitem'] = [6,9,15,25,50,75,100];
		$aanu_data['sortingitems'] = array('name' => 'Default Sorting',
										   'rating' => 'Sort Popularity',
										   'price' => 'Sort Price',
										   'category' => 'Sort Category',
										   'range' => 'Sort Range' );

		$aanu_data['skinconcernitems'] = ["Brightening","Dehydration","Firmness","Lines and Wrinkles","Pigmentation","Sensitivity","Skin tone"];
		$aanu_data['skintypeitems'] = ["Normal","Combination","Oily","Dry","Mature Skin tone"];

		$table = 'skin_concern';
		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
		$aanu_data['skinconcernitems'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

		$table = 'skin_type';
		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
		$aanu_data['skintypeitems'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);


		$table = 'quotes';
		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
		$aanu_data['quote_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);


		
		$aanu_data['pagemsg'] = "";


		$table = 'products';
		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
		if($range != 0) 
			$fieldcond['range_id'] = $range;
		if($category != 0)
		{
			if($category == 1)	
				$fieldcond['category_id !='] = 2;
			else
				$fieldcond['category_id'] = $category;
		} 			
		if($color != 0) 
			$fieldcond['color'] = $color;

		
		if($price != 0) 
		{
			//var_dump($price);
			$prpr = explode('-', $price);
			$prpr1 = $prpr[0];
			$prpr2 = $prpr[1];
			$fieldcond['current_price>='] = $prpr1;
			$fieldcond['current_price<='] = $prpr2;

		}

		if(is_numeric($showlimit)) 
			$limitoffsetcond = $showlimit.',0';
		if(is_numeric($showoffset)) 
			$limitoffsetcond = $showlimit.', '.$showoffset;
		if($sort == 'rating') 
			$ordercond = 'rating desc';
		else if($sort == 'price') 
			$ordercond = 'current_price asc';
		else if($sort == 'category') 
			$ordercond = 'category_id asc';
		else if($sort == 'range') 
			$ordercond = 'range_id asc';
		else if($sort == 'name') 
			$ordercond = 'name asc';	

		/*if(!is_numeric($skintype) && !empty($skintype))
			$matchvallike['skin_type'] = $skintype;
		if(!is_numeric($skinconcern) && !empty($skinconcern))
			$matchvallike['skin_concern'] = $skinconcern;*/
		if(!empty($skintype) && is_numeric($skintype) && !empty($skinconcern) && is_numeric($skinconcern))
		{
			$table2 = 'product_match';
			$fieldval2 = 'range_id'; 
			$fieldcond2 = array('skin_concern_id' => $skinconcern, 'skin_type_id' => $skintype);
			$ordercond2 = $limitoffsetcond2 = $matchvallike2 = false;
			$prod_ma_range = $this->control_engine->master_get($table2,$fieldval2,$fieldcond2,$ordercond2,$limitoffsetcond2,$matchvallike2);

			if(!empty($prod_ma_range) && is_array($prod_ma_range))
			{
				$fieldcond['range_id'] = $prod_ma_range[0]['range_id'];
			}
		}

		if(!empty($searchitem))
			$matchvallike['name'] = $searchitem;

		
		$aanu_data['product_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

		$aanu_data['pr_data_total'] = 0;
		$aanu_data['pr_data_pages'] = 0;
		$limitoffsetcond = false;$fieldval="count(*) as total";
		$pr_total = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
		if(!empty($pr_total) && is_array($pr_total))
			$aanu_data['pr_data_total'] = $pr_total[0]['total'];
		if(!empty($aanu_data['pr_data_total']) && $aanu_data['pr_data_total']>$showlimit)
			$aanu_data['pr_data_pages'] = ceil($aanu_data['pr_data_total']/$showlimit);

		// var_dump($aanu_data['pr_data_pages']);
		// var_dump($aanu_data['pr_data_total']);

		

		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = $fieldcond = false;
		$aanu_data['product_range'] = $this->control_engine->master_get('product_range',$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

		if(!empty($aanu_data['product_range']) && is_array($aanu_data['product_range']) && is_numeric($range))
		{
			foreach ($aanu_data['product_range'] as $key => $val) 
			{
				if($val['id'] == $range)
				{
					$aanu_data['pagemsg'] = $val['range_text'];
					$aanu_data['rangename'] = $val['name'];
				}
			}
		}

		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = $fieldcond = false;
		$aanu_data['product_category'] = $this->control_engine->master_get('product_category',$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

		if(!empty($aanu_data['product_category']) && is_array($aanu_data['product_category']) && is_numeric($category))
		{
			foreach ($aanu_data['product_category'] as $key => $val) 
			{
				if($val['id'] == $category)
				{
					$aanu_data['categoryname'] = $val['name'];
				}
			}
		}


		$appender = '';
		if($category != 0 && empty($appender) ) $appender = '('.$aanu_data['categoryname'];
		else if($category != 0 && !empty($appender) ) $appender .= ', '.$aanu_data['categoryname'];

		if($price != 0 && empty($appender) ) $appender = '(£'.$price;
		else if($price != 0 && !empty($appender) ) $appender .= ', £'.$price;

		if($color != 0 && empty($appender) ) $appender = '('.$color;
		else if($color != 0 && !empty($appender) ) $appender .= ', '.$color;

		if(!empty($appender)) $appender .= ')';

		if(is_numeric($skinconcern) && !empty($skinconcern) && !empty($aanu_data['skinconcernitems']) && is_array($aanu_data['skinconcernitems']))
		{
			$skinconcern_name = '';
			foreach ($aanu_data['skinconcernitems'] as $key => $value) 
			{
				if($value["id"]==$skinconcern)
					$skinconcern_name = $value["name"];
			}
			$appender .= '<br>Skin Concern: '.$skinconcern_name;
		}

		if(is_numeric($skintype) && !empty($skintype) && !empty($aanu_data['skintypeitems']) && is_array($aanu_data['skintypeitems']))
		{
			$skintype_name = '';
			foreach ($aanu_data['skintypeitems'] as $key => $value) 
			{
				if($value["id"]==$skintype)
					$skintype_name = $value["name"];
			}
			$appender .= '<br>Skin Type: '.$skintype_name;
		}

		if(!empty($searchitem))
			$appender .= '<br>Search Result: '.$searchitem;

		//var_dump($skintype);
		

		$aanu_data['appender'] = $appender;

		$this->load->view('shop',$aanu_data);
	}

	public function product_details($trans=1)
	{
		$aanu_data['trans'] = $trans;
		$_SESSION['page_para'] = intval($trans);
		//var_dump($_SESSION['page_para']);

		if(!empty($_POST['customerreview']) )
		{
			//var_dump($_POST);

			$customer_id = 0;
			$customer_name = 'Anonymous';

			if(!empty($_SESSION['customer_info']) && is_array($_SESSION['customer_info']))
            {
            	$customer_id = $_SESSION['customer_info']['id'];
				$customer_name = $_SESSION['customer_info']['contact_name'];
            }

			$table = 'product_reviews';
			$rating = $review = '';

			$this->form_validation->set_rules('rating', 'Rating', 'required');
			$this->form_validation->set_rules('review', 'Review', 'required');

			if(($this->form_validation->run() == TRUE)  )
			{
				$rating = $this->test_input($_POST['rating']);
				//$rating = 3;
				$review = $this->test_input($_POST['review']);

				$dataval = array(
								'customer_id' => $customer_id,
								'customer_name' => $customer_name,
								'product_id' => $trans,
								'product_rating' => $rating,
								'review' => $review,
								'updated' => date('Y-m-d h:i:s', time()) 
							);

				$idc = $this->control_engine->insert_master($dataval, $table)[1];

			}

			

		}

		$table = 'quotes';
		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
		$aanu_data['quote_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

		$table = 'product_reviews';
		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
		$fieldcond = array('product_id' => $trans ); $ordercond = "updated desc";$limitoffsetcond = '10, 0';
		$aanu_data['review_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

		
		$table = 'products';
		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;	
		$fieldcond = array('id' => $trans );	
		$aanu_data['product_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
		

		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = $fieldcond = false;
		$aanu_data['product_range'] = $this->control_engine->master_get('product_range',$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

		
		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = $fieldcond = false;
		$aanu_data['product_category'] = $this->control_engine->master_get('product_category',$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

		$rangeholder = 1;
		if(!empty($aanu_data['product_data']) && is_array($aanu_data['product_data']))
		{
			$rangeholder = $aanu_data['product_data'][0]['range_id'];
		}

		$table = 'products';
		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;	
		$fieldcond = array('id !=' => $trans, 'range_id' => $rangeholder );	
		$aanu_data['other_product_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);


		$this->load->view('product_details',$aanu_data);	
	}

	public function wishlist()
	{
		$aanu_data['pagemsg'] = "";
		$table = 'aboutpage';
		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
		//$aanu_data['pagedata'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
		$this->load->view('wishlist',$aanu_data);	
	}

	public function cart()
	{
		$aanu_data['pagemsg'] = "";
		$table = 'aboutpage';
		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
		//$aanu_data['pagedata'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
		$this->load->view('cart',$aanu_data);	
	}

	public function checkout($logerror=false)
	{
		$aanu_data['ntfo'] = '';
		/*if(($logerror !== false)&&($this->base64_url_decode($logerror)==1))
		{
			$aanu_data['ntfo']='<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button> <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span> Invalid Login Parameter </div>';
		}
		if(($logerror !== false)&&($this->base64_url_decode($logerror)==2))
		{
			$aanu_data['ntfo']='<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button> <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span> This account does not exist with us. <a href="'.base_url().'customer/signup"><h5> Register Instead</h5></a>  </div>';
		}*/

		

		$table='customers';
		$aanu_data['contact_name'] = "";
		$aanu_data['email'] = "";
		$aanu_data['password'] = "";
		$aanu_data['cpassword'] = "";
		$target_file = '';
		$aanu_data['ntf'] = '';

		if(!empty($_POST['customersignuplogger']) )
		{
			//var_dump($_POST);

			
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('contact_name', 'Contact Name', 'required');
			$this->form_validation->set_rules('town_city', 'Town/City', 'required');
			$this->form_validation->set_rules('postcode_zip', 'Post Code/Zip', 'required');
			$this->form_validation->set_rules('contact_address', 'Contact Address', 'required');
			$this->form_validation->set_rules('phone', 'Phone', 'required');

			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('re_pass', 'Confirm Password', 'required');

			if(($this->form_validation->run() == TRUE)  )
			{
				$email = $this->test_input($_POST['email']);
				$contact_name = $this->test_input($_POST['contact_name']);
				$country = $this->test_input($_POST['country']);
				$state = $this->test_input($_POST['state']);
				$town_city = $this->test_input($_POST['town_city']);
				$postcode_zip = $this->test_input($_POST['postcode_zip']);
				$contact_address = $this->test_input($_POST['contact_address']);
				$phone = $this->test_input($_POST['phone']);
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
										'contact_name' => $contact_name,
										'email' => $email,
										'contact_address' => $contact_address,
										'country' => $country,
										'state' => $state,
										'town_city' => $town_city,
										'postcode_zip' => $postcode_zip,
										'contact_address' => $contact_address,
										'phone' => $phone,
										'password' => $generatedhash,
										'updated' => date('Y-m-d h:i:s', time()) 
									);

					$idc = $this->control_engine->insert_master($dataval, $table)[1];
					if(!empty($idc))
					{
						$aanu_data['ntf'] = 'Registration Successful. Please check your mail for verification link. You may proceed with checking out';
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
						$this->to_name = $contact_name;
						//$this->cc = 'enquiries@aanu-london.com,support@aanu-london.com';
						$this->mail_subject = 'ACCOUNT VERIFICATION | AANU-LONDON';
						$contact_us_data['msg'] = "Welcome to Aanu-London Family, your very own skin-care, nature’s way. Save time on purchasing and checking out by logging into your account";
						$contact_us_data['gotoaccount_text'] = 'Go-to My Account';
						$contact_us_data['gotoaccount_link'] = base_url().'customer/profile/'.$this->base64_url_encode($email);	
						$contact_us_data['newsletter_link'] = base_url().'welcome/index/'.$this->base64_url_encode($email).'/#aanulondonnewsletter';

						$this->mail_message = $this->load->view('mails/regcustomer',$contact_us_data,TRUE);
						$this->dispatchMail();

						$table = 'customers';
						$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = false;
						$fieldval = false;//"id,email,password";
						$fieldcond = array('email' => $email );
						$tll = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
						
						if(!empty($tll) && is_array($tll))
						{
							$_SESSION['customer_info'] = $tll[0];
							$_SESSION['customer_gate_pass'] = $tll[0]['id'];
						}

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

		$aanu_data['pagemsg'] = "";
		$table = 'aboutpage';
		$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
		//$aanu_data['pagedata'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

		

		$this->load->view('checkout',$aanu_data);	
	}

	//public function paypal_create_order($arg1=false,$arg2=false,$arg3=false)
	public function paypal_create_order($arg1 = false, $arg2 = false)
	{
		
		//if(!$arg1 || !$arg2 || !$arg3)
		if(!$arg1 || !$arg2)
		{
			redirect('/Welcome/notfound'); //redirect('/controller/method') or in a real world example redirect('/main');
		}
		else
		{
			$payRefId = $this->base64_url_decode($arg1);
			$payAmount = $this->base64_url_decode($arg2);
			//$orderID = $arg3;

			if(!empty($_POST['logger_save']) && $_POST['logger_save'] == "logger_ext_post")
			{
				$db_ref_id = $_POST['db_ref_id'];
		        $db_amount = $_POST['db_amount'];
		        $db_currency_code = $_POST['db_currency_code'];
		        $db_status = $_POST['db_status'];
		        $db_payment_id = $_POST['db_payment_id'];
		        $db_descr = $_POST['db_descr'];
		        $db_order_id = $_POST['db_order_id'];
		        $db_intent = $_POST['db_intent'];
		        $db_payer_id = $_POST['db_payer_id'];
		        $db_payer_name = $_POST['db_payer_name'];
		        $db_payer_email= $_POST['db_payer_email'];
		        $db_payer_phone = $_POST['db_payer_phone'];
		        $db_shipping_name = $_POST['db_shipping_name'];
		        $db_shipping_addr = $_POST['db_shipping_addr'];
		        $db_pay_create_time = $_POST['db_pay_create_time'];
		        $db_pay_update_time = $_POST['db_pay_update_time'];

		        $nmb_contact_name = $_POST['nmb_contact_name'];
                $nmb_contact_address = $_POST['nmb_contact_address'];
                $nmb_postcode_zip = $_POST['nmb_postcode_zip'];
                $nmb_email = $_POST['nmb_email'];
                $nmb_phone = $_POST['nmb_phone'];
                $nmb_country = $_POST['nmb_country'];
                $nmb_state = $_POST['nmb_state'];
                $nmb_town_city = $_POST['nmb_town_city'];
                $cart_info_detail = $_POST['cart_info_detail'];
                $userid = $_POST['userid'];  

                if(!empty($cart_info_detail))
                	$cart_info_detail = $this->base64_url_decode($cart_info_detail);      
		        

		        define("URI_SANDBOX", "https://api.sandbox.paypal.com");

				define("URI_LIVE", "https://api.paypal.com");


		        //$uri = URI_SANDBOX.'/v1/oauth2/token';
		        $uri = URI_LIVE.'/v1/oauth2/token';

				/*$clientId = 'AQVm9aEHlcxTE3PTg6ERLi7rttXijwjrb1ICtbbSN1BJPSzVFvTDWSmVqX1k7ki52llvyHGvRgF_n2T1';
				$secret = 'EEUiAvV6onUlDxleJ1BSSeW11oSQE_wL1KCxM70MXUMDcZgrWF2-PMZNlOoh7VpyG5uU-iE46FXgZ2Ku';*/

				//$clientId = 'AQ5sgsslseveaBUDJXZejFuQql-GmSP_woQnBCftDS6oWbJ2AFg6bunWkfpjcQXVaE23mcK0YH7NhWRy';
				//$secret = 'EBEAOJhlMfTOtBmBdao1JVutOEXPxuI47KgFFUbI8FvFhB9RLd66m7ctgE3YAJ3XdbkJcv6wMaQ0iY50';

				//AbS8RSRsB51-F81f6eu53zleTLlujeBfvTuqrSuznmdTDnVT7m6NaVrHdwzy8_odRlLYgG-zA8ZL1h8H

				//EFKdcNk-gFAlO6xW6cudbpppRFkomV9ctjb5MKwMothZmLfecWp0OfLyBMaxkEpZSfgPjXb9YXuvI_r7


				$clientId = 'AbS8RSRsB51-F81f6eu53zleTLlujeBfvTuqrSuznmdTDnVT7m6NaVrHdwzy8_odRlLYgG-zA8ZL1h8H';
				$secret = 'EFKdcNk-gFAlO6xW6cudbpppRFkomV9ctjb5MKwMothZmLfecWp0OfLyBMaxkEpZSfgPjXb9YXuvI_r7';

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $uri);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSLVERSION , 6); //NEW ADDITION
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
				curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
				curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

				$result = curl_exec($ch);
				$access_token = '';
				if(empty($result))die("Error: No response.");
				else
				{
				    $json = json_decode($result);
				    $access_token = $json->access_token;
				    //var_dump($access_token);
				    //echo '<br><br>';
				}

				curl_close($ch);


				$url = URI_LIVE."/v2/checkout/orders/".$db_order_id;
				//$url = URI_SANDBOX."/v2/checkout/orders/".$db_order_id;
				//$url = URI_SANDBOX."/v2/payments/captures/45X49818WC8598729";
				//$url = URI_SANDBOX."/v1/payments/payment/PAY-45X49818WC8598729";
				$accessToken=$access_token; //'A21AAF1xF2iiuTJay0k8qtXt3RRkCzRCpNBGnUH17V2tzDVo9QYjF3zdZ-o2sxvolQvdCJBEyCbFqFetZ2GvidbJTAXYfZNAA';//$access_token;
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_POST, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				    'Authorization: Bearer ' . $accessToken,
				    'Accept: application/json',
				    'Content-Type: application/json'
				));
				$response = curl_exec($curl);

				if(empty($response))die("Error: No response.");
				else
				{
				    $detail = json_decode($response);
				}
				curl_close($curl);

				//var_dump($detail);

				if(!empty($detail))
				{
					
					//print_r($response);
					$db_ref_id2 = $detail->purchase_units[0]->reference_id;
					//var_dump($db_ref_id2);
					//print_r($detail);
			        $db_amount2 = $detail->purchase_units[0]->payments->captures[0]->amount->value;
			        $db_currency_code2 = $detail->purchase_units[0]->payments->captures[0]->amount->currency_code;
			        $db_status2 = $detail->purchase_units[0]->payments->captures[0]->status;
			        $db_payment_id2 = $detail->purchase_units[0]->payments->captures[0]->id;
			        $db_order_id2 = $detail->id;
			        $db_payer_id2 = $detail->payer->payer_id;
			        $db_payer_email2 = $detail->payer->email_address;

			        if( ($db_ref_id2==$payRefId) && ($db_amount2==$payAmount) && 
			        	($db_currency_code2==$db_currency_code) && ($db_status2==$db_status) &&
			        	($db_payment_id2==$db_payment_id) && ($db_order_id2==$db_order_id) && 
			        	($db_payer_id2==$db_payer_id) && ($db_payer_email2==$db_payer_email) 
			          )
			        {
			        	$table = 'transactions';
				        $dataval = array('reference_id' => $db_ref_id, 
				        	             'amount' => $db_amount,
				        	             'currency_code' => $db_currency_code,
				        	             'status' => $db_status,
				        	             'payment_id' => $db_payment_id,
				        	             'purchase_description' => $db_descr,
				        	             'order_id' => $db_order_id,
				        	             'intent' => $db_intent,
				        	             'payer_id' => $db_payer_id,
				        	             'payer_name' => $db_payer_name,
				        	             'payer_email' => $db_payer_email,
				        	             'payer_phone' => $db_payer_phone,
				        	             'shipping_name' => $db_shipping_name,
				        	             'shipping_address' => $db_shipping_addr,
				        	             'payment_create_time' => $db_pay_create_time,
				        	             'payment_update_time' => $db_pay_update_time, 
				        	             'updated' => date('Y-m-d h:i:s', time()) 
				        	            );

						/*$idc = $this->control_engine->insert_master($dataval, $table)[1];
						if(!empty($idc))
							echo "success";
						else
							echo "Something Went Wrong";*/
			        	$s_data2 = $this->control_engine->master_insert_dup($table,$dataval);
			        	$msg = '';
			        	$item_paid_for = array();
			        	if($s_data2)
			        	{

			        		if(!empty($cart_info_detail))
			                {
			                    $ddd = json_decode($cart_info_detail);
			                    if(is_array($ddd))
			                    {
			                        $pr_info = $ddd[0];
			                        $totalprice = $ddd[1]->total_price;
			                        //var_dump($pr_info);
			                        
			                        $totalprice = number_format($totalprice,2);
			                        
			                        if(!empty($pr_info) && is_array($pr_info))
			                        {
			                            for ($i=0; $i <sizeof($pr_info); $i++) 
			                            {
			                                $unitprice = number_format(floor($pr_info[$i]->price/$pr_info[$i]->qtty),2);
			                                $norm_pr = number_format($pr_info[$i]->price,2);
			                                //$pr_info[$i]->prname
			                                //$pr_info[$i]->qtty

			                                
			                                $table2 = 'order_packages';
									        $dataval2 = array('user_id' => $userid, 
									        	             'currency_code' => $db_currency_code,
									        	             'product_id' => $pr_info[$i]->id,
									        	             'product_name' => $pr_info[$i]->prname,
									        	             'product_image' => $pr_info[$i]->img,
									        	             'quantity' => $pr_info[$i]->qtty,
									        	             'unit_price' => $unitprice,
									        	             'order_id' => $db_order_id,
									        	             'updated' => date('Y-m-d h:i:s', time()) 
									        	            );

									        array_push($item_paid_for, $dataval2);

			                                $s_data3 = $this->control_engine->insert_master($dataval2, $table2)[1];

			                                
			                            }

			                        }
			                        
			                    }

			                }			                


			        		$fieldval = $ordercond = $limitoffsetcond = $matchvallike = false;
							$fieldcond = array('reference_id' => $payRefId, 'payment_id' => $db_payment_id, 'order_id' => $db_order_id );
							$fieldval = 'id,order_delivery';
							$feedbacker = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
							$feedback = 0;
							$transactionid = 0;
							if(!empty($feedbacker) && is_array($feedbacker))
							{
								foreach ($feedbacker as $key => $value) 
								{
									$feedback = $feedback + $value['order_delivery'];
									$transactionid = $value['id'];
								}
							}
							
							if(!empty($feedback))
							{
								$msg = 'Dear esteemed customer! Your transaction ['.$payRefId.'] order has been delivered. Please contact us for clarity.';
								$msg = $this->base64_url_encode($msg);
							}



							$table3 = 'order_log';
					        $dataval3 = array('user_id' => $userid, 
					        	             'contact_name' => $nmb_contact_name,
					        	             'contact_address' => $nmb_contact_address,
					        	             'postcode_zip' => $nmb_postcode_zip,
					        	             'email' => $nmb_email,
					        	             'phone' => $nmb_phone,
					        	             'country' => $nmb_country,
					        	             'state' => $nmb_state,
					        	             'town_city' => $nmb_town_city,
					        	             'order_id' => $db_order_id,
					        	             'transaction_ref'  => $db_ref_id,
					        	             'transaction_id' => $transactionid,
					        	             'payment_status' => $db_status, 
					        	             'updated' => date('Y-m-d h:i:s', time()) 
					        	            );

					        $s_data4 = $this->control_engine->insert_master($dataval3, $table3)[1];

					        if(!empty($s_data4))
					        {
					        	$_SESSION["cart_info_detail"] = '';
					        	$datavaly = array(
										'cart_box' => $_SESSION["cart_info_detail"],
										'updated' => date('Y-m-d h:i:s', time()) 
									);
								$fieldcondy = array('id' => $userid );

								//var_dump($_POST);
								$s_datay2 = $this->control_engine->update_master($datavaly,'customers',$fieldcondy);

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

					        	$contact_us_data['payment_method'] = 'PayPal Express Checkout';
					        	$contact_us_data['shipping_method'] = 'Parcel2Go Tracked 2-3 Working Days Order by Noon';
					        	$contact_us_data['order_id'] = $db_order_id;
					        	$contact_us_data['pay_time'] = date('d F, Y | h:m a', strtotime($db_pay_create_time));

					        	$contact_us_data['payer_email'] = $db_payer_email;

					        	$contact_us_data['billing_address'] = $contact_us_data['shipping_address'] = $nmb_contact_name.'<br>'.$nmb_contact_address.'<br>'.$nmb_postcode_zip.'<br>'.$nmb_town_city.'<br>'.$nmb_state.'<br>'.$nmb_country.'<br>Tel: '.$nmb_phone;

					        	

					        	$contact_us_data['item_paid_for'] = $item_paid_for;

					        	$this->from = $contact_us_data['mcmail']; 
								$this->from_name = 'AANU-LONDON';
								$this->to = $nmb_email;
								$this->to_name = $nmb_contact_name;
								//$this->cc = 'enquiries@aanu-london.com,support@aanu-london.com';
								$this->mail_subject = "YOU'VE PLACED ORDER | AANU-LONDON";

								$this->mail_message = $this->load->view('mails/ordercustomer',$contact_us_data,TRUE);
								$this->dispatchMail();

					        }

							/*$from_email_address = "Aanu-London <payments-facilitator@aanu-london.com>";
							$email_to = $db_payer_name . " <" . $db_payer_email . ">";
				            $email_subject = "Completed Order from Aanu-london.com";
				            $email_body = "Thank you for the " . $db_descr . "." . "\r\n" . "\r\n" . "This is an example email only." . "\r\n" . "\r\n" . "Thank you.";
				            mail($email_to, $email_subject, $email_body, "From: " . $from_email_address);*/

			        	}

			        	$mmau = $this->base64_url_encode('paypal_create_order');
			        	redirect('/Cart/complete/'.$mmau.'/'.$msg);
			        }
			        else
			        {
			        	/*var_dump($db_ref_id2);
						var_dump($payRefId); 
						var_dump($db_amount2);
						var_dump($payAmount); 
						var_dump($db_currency_code2);
						var_dump($db_currency_code); 
						var_dump($db_status2);
						var_dump($db_status);
						var_dump($db_payment_id2);
						var_dump($db_payment_id); 
						var_dump($db_order_id2);
						var_dump($db_order_id); 
						var_dump($db_payer_id2);
						var_dump($db_payer_id); 
						var_dump($db_payer_email2);
						var_dump($db_payer_email);*/

			        	$msg = 'Dear esteemed customer! Something went fishy in your transaction ['.$payRefId.'] process, and we decided to put your trasanction on hold. Please contact us for clarity.';
			        	$msg = $this->base64_url_encode($msg);
			        	$mmau = $this->base64_url_encode('paypal_create_order');
			        	redirect('/Cart/failed/'.$mmau.'/'.$msg);
			        }

				}
				else
				{
					redirect('/Cart/failed');
				}


				
			}
			else
			{
				redirect('/Welcome/notfound');
			}


			


		}
		
		//var_dump($_POST);



		/*if(!empty($_POST['logger_save']) && $_POST['logger_save'] == "logger_ext_post")
		{
			$db_ref_id = $_POST['db_ref_id'];
	        $db_amount = $_POST['db_amount'];
	        $db_currency_code = $_POST['db_currency_code'];
	        $db_status = $_POST['db_status'];
	        $db_payment_id = $_POST['db_payment_id'];
	        $db_descr = $_POST['db_descr'];
	        $db_order_id = $_POST['db_order_id'];
	        $db_intent = $_POST['db_intent'];
	        $db_payer_id = $_POST['db_payer_id'];
	        $db_payer_name = $_POST['db_payer_name'];
	        $db_payer_email= $_POST['db_payer_email'];
	        $db_payer_phone = $_POST['db_payer_phone'];
	        $db_shipping_name = $_POST['db_shipping_name'];
	        $db_shipping_addr = $_POST['db_shipping_addr'];
	        $db_pay_create_time = $_POST['db_pay_create_time'];
	        $db_pay_update_time = $_POST['db_pay_update_time'];


			$table = 'transactions';
	        $dataval = array('reference_id' => $db_ref_id, 
	        	             'amount' => $db_amount,
	        	             'currency_code' => $db_currency_code,
	        	             'status' => $db_status,
	        	             'payment_id' => $db_payment_id,
	        	             'purchase_description' => $db_descr,
	        	             'order_id' => $db_order_id,
	        	             'intent' => $db_intent,
	        	             'payer_id' => $db_payer_id,
	        	             'payer_name' => $db_payer_name,
	        	             'payer_email' => $db_payer_email,
	        	             'payer_phone' => $db_payer_phone,
	        	             'shipping_name' => $db_shipping_name,
	        	             'shipping_address' => $db_shipping_addr,
	        	             'payment_create_time' => $db_pay_create_time,
	        	             'payment_update_time' => $db_pay_update_time, 
	        	             'updated' => date('Y-m-d h:i:s', time()) );

						$idc = $this->control_engine->insert_master($dataval, $table)[1];
						if(!empty($idc))
							echo "success";
						else
							echo "Something Went Wrong";
		}*/

		/*if(!empty($detail))
		{
			$db_ref_id = $detail->purchase_units[0]->reference_id;
	        $db_amount = $detail->purchase_units[0]->payments->captures[0]->amount->value;
	        $db_currency_code = $detail->purchase_units[0]->payments->captures[0]->amount->currency_code;
	        $db_status = $detail->purchase_units[0]->payments->captures[0]->status;
	        $db_payment_id = $detail->purchase_units[0]->payments->captures[0]->id;
	        $db_descr = $detail->purchase_units[0]->description;
	        $db_order_id = $detail->id;
	        $db_intent = $detail->intent;
	        $db_payer_id = $detail->payer->payer_id;
	        $db_payer_name = $detail->payer->name->given_name.", ".$detail->payer->name->surname;
	        $db_payer_email= $detail->payer->email_address;
	        $db_payer_phone = $detail->payer->phone->phone_number->national_number;
	        $db_shipping_name = $_POST['db_shipping_name'];
	        $db_shipping_addr = $_POST['db_shipping_addr'];
	        $db_pay_create_time = $_POST['db_pay_create_time'];
	        $db_pay_update_time = $_POST['db_pay_update_time'];


			$table = 'transactions';
	        $dataval = array('reference_id' => $db_ref_id, 
	        	             'amount' => $db_amount,
	        	             'currency_code' => $db_currency_code,
	        	             'status' => $db_status,
	        	             'payment_id' => $db_payment_id,
	        	             'purchase_description' => $db_descr,
	        	             'order_id' => $db_order_id,
	        	             'intent' => $db_intent,
	        	             'payer_id' => $db_payer_id,
	        	             'payer_name' => $db_payer_name,
	        	             'payer_email' => $db_payer_email,
	        	             'payer_phone' => $db_payer_phone,
	        	             'shipping_name' => $db_shipping_name,
	        	             'shipping_address' => $db_shipping_addr,
	        	             'payment_create_time' => $db_pay_create_time,
	        	             'payment_update_time' => $db_pay_update_time, 
	        	             'updated' => date('Y-m-d h:i:s', time()) );

						$idc = $this->control_engine->insert_master($dataval, $table)[1];
						if(!empty($idc))
							echo "success";
						else
							echo "Something Went Wrong";
		}

		echo "No Server Request";
		
		$this->load->view('index',$aanu_data);*/	

		redirect('/Welcome/index');

	}

	public function mail_check()
	{
		$contact_us_data['msubj'] = "contact enquiry";
		$contact_us_data['cname'] = "Ibrahim Nwachi";
		$contact_us_data['cemail'] = "sinache@gmail.com";
		$contact_us_data['msg'] = "contact messg";



		$this->load->view('mails/contact',$contact_us_data);	
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
