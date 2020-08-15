<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

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
                

                $this->key = 'gh@#ffyf!;kjiuh&*rgd';//$this->random_key_string();

                $this->today = date('Y-m-d H:i:s');
	}


	public function cart_process($mod=false)
	{
		if(!empty($_POST['logger_save']) && $_POST['logger_save'] == "logger_ext_post")
		{

			if($mod == false)
			{
				$prdid = $_POST['prdid'];//$this->test_input($_POST['prdid']);
				$prqtty = $_POST['prqtty'];//$this->test_input($_POST['prqtty']);
				$prname = $_POST['prname'];//$this->test_input($_POST['prname']);
				$primg = $_POST['primg'];//$this->test_input($_POST['primg']);
				$prprice = $_POST['prprice'];//$this->test_input($_POST['prprice']);
				$cart_info_detail = $_POST['cart_info_detail'];//$this->test_input($_POST['cart_info_detail']);
				
				//echo 'babmamaa';

				if(empty($cart_info_detail) || !is_array(json_decode($cart_info_detail)))
				{
					//echo 'baba';
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
					$_SESSION['cart_info_detail'] = $eee;

					if(!empty($_SESSION['customer_gate_pass']))
					{
						$table = 'customers';
						$dataval = array('cart_box' => $_SESSION['cart_info_detail']);
						$fieldcond = array('id' => $_SESSION['customer_gate_pass'] );
						$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
					}
					
					echo $eee;

				}

				else
				{
					$ddd = json_decode($cart_info_detail);
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

							echo $_SESSION['cart_info_detail'] = json_encode($ddd);
							if(!empty($_SESSION['customer_gate_pass']))
							{
								$table = 'customers';
								$dataval = array('cart_box' => $_SESSION['cart_info_detail']);
								$fieldcond = array('id' => $_SESSION['customer_gate_pass'] );
								$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
							}
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
							$_SESSION['cart_info_detail'] = $eee;
							if(!empty($_SESSION['customer_gate_pass']))
							{
								$table = 'customers';
								$dataval = array('cart_box' => $_SESSION['cart_info_detail']);
								$fieldcond = array('id' => $_SESSION['customer_gate_pass'] );
								$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
							}
							echo $eee;

						}

						

					}
					
					
				}
			}
			else
			{
				$prdid = $_POST['prdid'];//$this->test_input($_POST['prdid']);
				$cart_info_detail = $_POST['cart_info_detail'];//$this->test_input($_POST['cart_info_detail']);

				$ntotalq = $ntotalpr = 0;

				if(!empty($cart_info_detail))
				{
					$ddd = json_decode($cart_info_detail);
					if(is_array($ddd))
					{
						$pr_info = $ddd[0];
						
						if(!empty($pr_info) && is_array($pr_info))
						{

							//$ntotalq = $ntotalpr = 45;

							$i_just_rem = false;
							
							for ($i=0; $i <sizeof($pr_info); $i++) 
							{ 
								if(isset($pr_info[$i]->id) && ($pr_info[$i]->id == $prdid))
								{
									array_splice($pr_info, $i,1);
									//$ddd[0] = $pr_info;
									$i_just_rem = true;
								}
								else if(isset($pr_info[$i]->id))
									$i_just_rem = false;

								/*if(!$i_just_rem)
								{
									//$ntotalpr = $ntotalpr + $pr_info[$i]->price;
									$ntotalq = $ntotalq + $pr_info[$i]->qtty;
								}*/


							}



							if(!empty($pr_info))
							{
								//$ntotalq = $ntotalpr = 23;
								foreach ($pr_info as $key => $value) 
								{
									//$ntotalpr = $ntotalq = 65;
									$ntotalq = $ntotalq + $value->qtty;
									$ntotalpr = $ntotalpr + $value->price;
								}
								
							}
							
						}

						$ddd[0] = $pr_info;
						
						if(empty($pr_info))
						{
							$ddd[0] = '';
						}

						if(!empty($ddd[1]))
						{
							$ddd[1]->total_qtty = $ntotalq;
							$ddd[1]->total_price = $ntotalpr;
						}

						/*if(!empty($ddd[0]))
							echo $_SESSION['cart_info_detail'] = json_encode($ddd);
						else
							echo $_SESSION['cart_info_detail'] = '';*/

						echo $_SESSION['cart_info_detail'] = json_encode($ddd);
						if(!empty($_SESSION['customer_gate_pass']))
						{
							$table = 'customers';
							$dataval = array('cart_box' => $_SESSION['cart_info_detail']);
							$fieldcond = array('id' => $_SESSION['customer_gate_pass'] );
							$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
						}


						//echo $pr_info;

					}
					
					
				}
			}

		}
		

	}

	public function complete($auth=false,$msg=false)
	{
		if($this->base64_url_decode($auth) == 'paypal_create_order')
		{
			if(!$msg)
				$aanu_data['msg'] = 'Your order is on the way and should get to you within 24 to 48hrs';
			else
				$aanu_data['msg'] = $this->base64_url_decode($msg);

			$this->load->view('trasanction_complete',$aanu_data);
		}
		else
		{
			redirect('Welcome/notfound');
		}

		
	}	

	public function failed($auth=false,$msg=false)
	{
		//var_dump($this->base64_url_decode($auth));
		if($this->base64_url_decode($auth) == 'paypal_create_order')
		{
			if(!$msg)
				$aanu_data['msg'] = '';
			else
				$aanu_data['msg'] = $this->base64_url_decode($msg);

			$this->load->view('trasanction_failed',$aanu_data);
		}
		else
		{
			redirect('Welcome/notfound');
		}

			
	}	

	

	public function paypal_payment_notification()
	{
		$aanu_data = '';
		$this->load->view('paypal_ipn_usage',$aanu_data);	
	}
    

	public function base64_url_encode($input) {
	 return strtr(base64_encode($input), '+/=', '-_-');
	}

	public function base64_url_decode($input) {
	 return base64_decode(strtr($input, '-_-', '+/='));
	}


}
