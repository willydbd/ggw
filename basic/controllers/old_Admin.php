<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Admin extends CI_Controller {

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
                //$this->load->controller("Results");
                

                $this->key = 'gh@#ffyf!;kjiuh&*rgd';//$this->random_key_string();

                $this->today = date('Y-m-d H:i:s');
	}

	public function entry_gate()
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$table='blog';			
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$limitoffsetcond = '5,0';
			$dash_data['blog_list'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$table='customers';			
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'count(*) as total';
			$dash_data['users_stat'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$table='transactions';			
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'count(*) as total, updated';
			$dash_data['order_stat'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$table='order_packages';			
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'count(*) as total';
			$dash_data['package_stat'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$table='blog';			
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'count(*) as total';
			$dash_data['blog_stat'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			//users_stat order_stat package_stat blog_stat


			$table='order_packages';
			$fieldval = 'order_packages.quantity as qtty, order_packages.updated as timeval, products.range_id as rid';
			$ordercond = ['order_packages.updated desc'];
	        $jt_wt_cond = array("products" => "products.id=order_packages.product_id");
	        $fieldcond = $limitoffsetcond = false;
			$dash_data['chart_data'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond);

			//var_dump($dash_data['chart_data']);

			$table='products';
			$fieldval = 'products.name as prname, products.id as prid, products.current_price as cprice, products.image as primg, product_range.name as rangename, product_category.name as catename';
			$fieldcond = array('products.range_id' => 1);
			$ordercond = ['products.updated desc'];
			$limitoffsetcond = '1,0';
	        $jt_wt_cond = array("product_range" => "product_range.id=products.range_id",
	        					"product_category" => "product_category.id=products.category_id");
			$dash_data['product_data_1'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond);


			$fieldcond = array('products.range_id' => 2);
			$ordercond = ['products.updated desc'];
			$limitoffsetcond = '1,0';
	        $jt_wt_cond = array("product_range" => "product_range.id=products.range_id",
	        					"product_category" => "product_category.id=products.category_id");
			$dash_data['product_data_2'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond);

			$fieldcond = array('products.range_id' => 3);
			$ordercond = ['products.updated desc'];
			$limitoffsetcond = '1,0';
	        $jt_wt_cond = array("product_range" => "product_range.id=products.range_id",
	        					"product_category" => "product_category.id=products.category_id");
			$dash_data['product_data_3'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond);

			$this->load->view('gsi-portal/index', $dash_data);
		}
	}
	public function product_range_edit($trans=false)
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$table='product_range';
			$dash_data['rangename'] = "";
			$dash_data['rangetext'] = "";

			if(!empty($_POST['logger']) )
			{
				//var_dump($_POST);

				$this->form_validation->set_rules('rangename', 'Range Name', 'required');

				if(($this->form_validation->run() == TRUE)  )
				{
					$rangename = $this->test_input($_POST['rangename']);
					$rangetext = $this->test_input($_POST['rangetext']);

					if(!empty($rangename) && $trans == false)
					{
						$dataval = array('name' => $rangename, 'range_text' => $rangetext, 'updated' => date('Y-m-d h:i:s', time()) );
						$idc = $this->control_engine->insert_master($dataval, $table)[1];
						if(!empty($idc))
							$this->session->set_flashdata("record_save","Record Saved!");				    
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
					    }
					}
					else if(!empty($rangename) && $trans !== false)
					{
						$dataval = array('name' => $rangename, 'range_text' => $rangetext, 'updated' => date('Y-m-d h:i:s', time()) );
						$fieldcond = array('id' => $trans );
						$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
				    	if($s_data2)
				    	{
							$this->session->set_flashdata("record_save","Record Updated!");
						}						
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
					    }

					}

					$dash_data['rangename'] = $rangename;
					$dash_data['rangetext'] = $rangetext;

				}


				
			}


			if(!empty($trans) && is_numeric($trans))
			{
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond  = array('id' => $trans );
				$edit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($edit_data) && is_array($edit_data))
				{
					$dash_data['rangename'] = $edit_data[0]['name'];
					$dash_data['rangetext'] = $edit_data[0]['range_text'];
				}
			}
			
			

			$this->load->view('gsi-portal/edit-product-range', $dash_data);
		}
			
	}
	public function product_range_list($trans=false,$remid='')
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$dash_data['remid'] = $remid;
			$table='product_range';

			if(!empty($remid))
			{
				$remid = $this->base64_url_decode($remid);
				$fieldcond = array('id' => $remid );
				$this->control_engine->delete_master($table,$fieldcond);
			}


			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['range_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			


			if(!empty($trans) && is_numeric($trans))
			{
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond  = array('id' => $trans );
				$edit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($edit_data) && is_array($edit_data))
				{
					$dash_data['name'] = $edit_data[0]['name'];
					$dash_data['range_text'] = $edit_data[0]['range_text'];
				}
			}
			

			$this->load->view('gsi-portal/product-range-list', $dash_data);
		}
			
	}

	public function product_category_edit($trans=false)
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$table='product_category';
			$dash_data['rangename'] = "";

			if(!empty($_POST['logger']) )
			{
				//var_dump($_POST);

				$this->form_validation->set_rules('rangename', 'Category Name', 'required');

				if(($this->form_validation->run() == TRUE)  )
				{
					$rangename = $this->test_input($_POST['rangename']);

					if(!empty($rangename) && $trans == false)
					{
						$dataval = array('name' => $rangename, 'updated' => date('Y-m-d h:i:s', time()) );
						$idc = $this->control_engine->insert_master($dataval, $table)[1];
						if(!empty($idc))
							$this->session->set_flashdata("record_save","Record Saved!");				    
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
					    }
					}
					else if(!empty($rangename) && $trans !== false)
					{
						$dataval = array('name' => $rangename, 'updated' => date('Y-m-d h:i:s', time()) );
						$fieldcond = array('id' => $trans );
						$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
				    	if($s_data2)
				    	{
							$this->session->set_flashdata("record_save","Record Updated!");
						}						
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
					    }

					}

					$dash_data['rangename'] = $rangename;

				}


				
			}


			if(!empty($trans) && is_numeric($trans))
			{
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond  = array('id' => $trans );
				$edit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($edit_data) && is_array($edit_data))
				{
					$dash_data['rangename'] = $edit_data[0]['name'];
				}
			}
			
			

			$this->load->view('gsi-portal/edit-product-category', $dash_data);
		}
			
	}
	public function product_category_list($trans=false,$remid='')
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$dash_data['remid'] = $remid;
			$table='product_category';

			if(!empty($remid))
			{
				$remid = $this->base64_url_decode($remid);
				$fieldcond = array('id' => $remid );
				$this->control_engine->delete_master($table,$fieldcond);
			}


			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['cate_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			


			if(!empty($trans) && is_numeric($trans))
			{
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond  = array('id' => $trans );
				$edit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($edit_data) && is_array($edit_data))
				{
					$dash_data['name'] = $edit_data[0]['name'];
				}
			}
			

			$this->load->view('gsi-portal/product-category-list', $dash_data);
		}
			
	}

	public function quote_edit($trans=false)
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$table='quotes';
			$dash_data['quote'] = "";
			$dash_data['cite'] = "";

			if(!empty($_POST['logger']) )
			{
				//var_dump($_POST);

				$this->form_validation->set_rules('quote', 'Quote Message', 'required');

				if(($this->form_validation->run() == TRUE)  )
				{
					$quote = $this->test_input($_POST['quote']);
					$cite = $this->test_input($_POST['cite']);

					if(!empty($quote) && $trans == false)
					{
						$dataval = array('message' => $quote, 'cite' => $cite, 'updated' => date('Y-m-d h:i:s', time()) );
						$idc = $this->control_engine->insert_master($dataval, $table)[1];
						if(!empty($idc))
							$this->session->set_flashdata("record_save","Record Saved!");				    
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
					    }
					}
					else if(!empty($quote) && $trans !== false)
					{
						$dataval = array('message' => $quote, 'cite' => $cite, 'updated' => date('Y-m-d h:i:s', time()) );
						$fieldcond = array('id' => $trans );
						$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
				    	if($s_data2)
				    	{
							$this->session->set_flashdata("record_save","Record Updated!");
						}						
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
					    }

					}

					$dash_data['quote'] = $quote;
					$dash_data['cite'] = $cite;

				}


				
			}


			if(!empty($trans) && is_numeric($trans))
			{
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond  = array('id' => $trans );
				$edit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($edit_data) && is_array($edit_data))
				{
					$dash_data['quote'] = $edit_data[0]['message'];
					$dash_data['cite'] = $edit_data[0]['cite'];
				}
			}
			
			

			$this->load->view('gsi-portal/edit-quote', $dash_data);
		}
			
	}
	public function quote_list($trans=false,$remid='')
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$dash_data['remid'] = $remid;
			$table='quotes';

			if(!empty($remid))
			{
				$remid = $this->base64_url_decode($remid);
				$fieldcond = array('id' => $remid );
				$this->control_engine->delete_master($table,$fieldcond);
			}


			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['quote_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			


			if(!empty($trans) && is_numeric($trans))
			{
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond  = array('id' => $trans );
				$edit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($edit_data) && is_array($edit_data))
				{
					$dash_data['message'] = $edit_data[0]['message'];
					$dash_data['cite'] = $edit_data[0]['cite'];
				}
			}
			

			$this->load->view('gsi-portal/quote-list', $dash_data);
		}
			
	}

	public function faq_edit($trans=false)
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$table='faq';
			$dash_data['question'] = "";
			$dash_data['answer'] = "";

			if(!empty($_POST['logger']) )
			{
				//var_dump($_POST);

				$this->form_validation->set_rules('question', 'Question', 'required');
				$this->form_validation->set_rules('answer', 'Answer', 'required');

				if(($this->form_validation->run() == TRUE)  )
				{
					$question = $this->test_input($_POST['question']);
					$answer = $this->test_input($_POST['answer']);

					if(!empty($question) && $trans == false)
					{
						$dataval = array('question' => $question, 'answer' => $answer, 'updated' => date('Y-m-d h:i:s', time()) );
						$idc = $this->control_engine->insert_master($dataval, $table)[1];
						if(!empty($idc))
							$this->session->set_flashdata("record_save","Record Saved!");				    
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
					    }
					}
					else if(!empty($question) && $trans !== false)
					{
						$dataval = array('question' => $question, 'answer' => $answer, 'updated' => date('Y-m-d h:i:s', time()) );
						$fieldcond = array('id' => $trans );
						$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
				    	if($s_data2)
				    	{
							$this->session->set_flashdata("record_save","Record Updated!");
						}						
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
					    }

					}

					$dash_data['question'] = $question;
					$dash_data['answer'] = $answer;

				}


				
			}


			if(!empty($trans) && is_numeric($trans))
			{
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond  = array('id' => $trans );
				$edit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($edit_data) && is_array($edit_data))
				{
					$dash_data['question'] = $edit_data[0]['question'];
					$dash_data['answer'] = $edit_data[0]['answer'];
				}
			}
			
			

			$this->load->view('gsi-portal/edit-faq', $dash_data);
		}
			
	}

	public function faq_list($trans=false,$remid='')
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$dash_data['remid'] = $remid;
			$table='faq';

			if(!empty($remid))
			{
				$remid = $this->base64_url_decode($remid);
				$fieldcond = array('id' => $remid );
				$this->control_engine->delete_master($table,$fieldcond);
			}


			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['faq_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			


			if(!empty($trans) && is_numeric($trans))
			{
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond  = array('id' => $trans );
				$edit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($edit_data) && is_array($edit_data))
				{
					$dash_data['question'] = $edit_data[0]['question'];
					$dash_data['answer'] = $edit_data[0]['answer'];
				}
			}
			

			$this->load->view('gsi-portal/faq-list', $dash_data);
		}
			
	}

	public function order_list($trans=false,$remid='')
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$dash_data['remid'] = $remid;
			$table='transactions';

			if(($trans!== false)&&(!empty($remid)))
			{
				$remid = $this->base64_url_decode($remid);
				$dataval = array('delivery_status' => $remid, 'updated' => date('Y-m-d h:i:s', time()) );
				$fieldcond = array('transaction_id' => $trans );
				$s_data2 = $this->control_engine->update_master($dataval,'order_log',$fieldcond);
		    	if($s_data2)
		    	{
					$this->session->set_flashdata("record_save","Record Updated!");
				}						
			    else
			    {
			    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
			    }

			}


			/*if(!empty($remid))
			{
				$remid = $this->base64_url_decode($remid);
				$fieldcond = array('id' => $remid );
				$this->control_engine->delete_master($table,$fieldcond);
			}*/

			

			if((!empty($_POST['delivery_status']))&&(!empty($_POST['transaction_id'])))
			{
				//var_dump($_POST);

				$this->form_validation->set_rules('tracking_number', 'Tracking Number', 'required');
				$this->form_validation->set_rules('shipping_ref', 'Shipping Reference', 'required');

				if(($this->form_validation->run() == TRUE)  )
				{
					$tracking_number = $this->test_input($_POST['tracking_number']);
					$shipping_ref = $this->test_input($_POST['shipping_ref']);
					$transaction_id = $this->test_input($_POST['transaction_id']);
					$delivery_status = $this->test_input($_POST['delivery_status']);

					//var_dump($_POST);
					
					$dataval = array('shipping_ref' => $shipping_ref, 'tracking_number' => $tracking_number, 'delivery_status' => $delivery_status, 'shipped_date' => date('Y-m-d h:i:s', time()), 'updated' => date('Y-m-d h:i:s', time()) );
					$fieldcond = array('transaction_id' => $transaction_id );
					$s_data2 = $this->control_engine->update_master($dataval,'order_log',$fieldcond);
			    	if($s_data2)
			    	{
						$this->session->set_flashdata("record_save","Record Updated!");

						$table='transactions';
						$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
						$fieldcond = array('id' => $transaction_id );
						$tr_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

						if(!empty($tr_data)&&is_array($tr_data))
						{

							$contact_us_data['mcmail'] = "info@aanu-london.com";
							$contact_us_data['enqmail'] = "info@aanu-london.com";
							$contact_us_data['mphone'] = "";
							$contact_us_data['mphyaddr'] = "";
							$table = 'social_media';
							$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
							$social_media_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

							if(!empty($social_media_data) && is_array($social_media_data))
				            {
				                foreach ($social_media_data as $key => $value) 
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
				        	$contact_us_data['order_id'] = $tr_data[0]['order_id'];
				        	$contact_us_data['pay_time'] = date('d F, Y | h:m a', strtotime($tr_data[0]['payment_create_time']));

				        	$contact_us_data['payer_email'] = $tr_data[0]['payer_email'];

				        	$table='order_log';
							$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
							$fieldcond = array('transaction_id' => $transaction_id );
							$log_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

							$nmb_contact_name = $nmb_contact_address = $nmb_postcode_zip = $nmb_phone = $nmb_town_city = $nmb_state = $nmb_country = $nmb_email = '';


							if(!empty($log_data)&&is_array($log_data))
							{
								$nmb_contact_name = $log_data[0]['contact_name'];
								$nmb_contact_address = $log_data[0]['contact_address'];
								$nmb_postcode_zip = $log_data[0]['postcode_zip'];
								$nmb_phone = $log_data[0]['phone'];
								$nmb_town_city = $log_data[0]['town_city'];
								$nmb_state = $log_data[0]['state'];
								$nmb_country = $log_data[0]['country'];
								$nmb_email = $log_data[0]['email'];

							}

							

				        	$contact_us_data['billing_address'] = $contact_us_data['shipping_address'] = $nmb_contact_name.'<br>'.$nmb_contact_address.'<br>'.$nmb_postcode_zip.'<br>'.$nmb_town_city.'<br>'.$nmb_state.'<br>'.$nmb_country.'<br>Tel: '.$nmb_phone;

				        	$contact_us_data['tracking_number'] = $tracking_number;
				        	$contact_us_data['shipping_ref'] = $shipping_ref;
				        	$contact_us_data['courier'] = 'Parcel2Go';


				        	$table='order_packages';
							$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
							$fieldcond = array('order_id' => $contact_us_data['order_id'] );
							$package_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

							$item_paid_for = '';

							if(!empty($package_data) && is_array($package_data))
								$item_paid_for = $package_data;

				        	$contact_us_data['item_paid_for'] = $item_paid_for;


				        	$this->from = $contact_us_data['mcmail']; 
							$this->from_name = 'AANU-LONDON';
							$this->to = $nmb_email;
							$this->to_name = $nmb_contact_name;
							//$this->cc = 'enquiries@aanu-london.com,support@aanu-london.com';
							$this->mail_subject = "YOUR ORDER IS ON ITS WAY | AANU-LONDON";

							$this->mail_message = $this->load->view('mails/shippedordercustomer',$contact_us_data,TRUE);
							$this->dispatchMail();

						}

						

					}						
				    else
				    {
				    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
				    }

					
					
				}


				
			}


			$table='transactions';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['transactions_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['orders_data'] = $this->control_engine->master_get('order_log',$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);		
			

			$this->load->view('gsi-portal/transactions_list', $dash_data);

		}
			
	}

	public function order_info($trans=1)
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$table = 'order_log';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldcond = array('id' => $trans );
			$dash_data['orders_data_log'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$order_id = 0;
			if(!empty($dash_data['orders_data_log']) && is_array($dash_data['orders_data_log']))
			{
				$order_id = $dash_data['orders_data_log'][0]['order_id'];
			}

			$table = 'order_packages';	
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldcond  = array('order_id' => $order_id);
			$dash_data['orders_data_packages'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);	

			$table = 'transactions';	
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldcond  = array('order_id' => $order_id);
			$dash_data['orders_data_transactions'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);	
			


			$this->load->view('gsi-portal/order_info', $dash_data);

		}
			
	}

	public function term_list($trans=false,$remid='')
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$dash_data['remid'] = $remid;
			$table='terms_condition';

			if(!empty($remid))
			{
				$remid = $this->base64_url_decode($remid);
				$fieldcond = array('id' => $remid );
				$this->control_engine->delete_master($table,$fieldcond);
			}


			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['terms_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			


			if(!empty($trans) && is_numeric($trans))
			{
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond  = array('id' => $trans );
				$edit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($edit_data) && is_array($edit_data))
				{
					$dash_data['section'] = $edit_data[0]['section'];
					$dash_data['content'] = $edit_data[0]['content'];
				}
			}
			

			$this->load->view('gsi-portal/terms-list', $dash_data);
		}
			
	}

	public function term_edit($trans=false)
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$table='terms_condition';
			$dash_data['section'] = "";
			$dash_data['content'] = "";

			if(!empty($_POST['logger']) )
			{
				//var_dump($_POST);

				$this->form_validation->set_rules('section', 'Section', 'required');
				$this->form_validation->set_rules('content', 'Content', 'required');

				if(($this->form_validation->run() == TRUE)  )
				{
					$question = $this->test_input($_POST['section']);
					$answer = $this->test_input($_POST['content']);

					if(!empty($question) && $trans == false)
					{
						$dataval = array('section' => $question, 'content' => $answer, 'updated' => date('Y-m-d h:i:s', time()) );
						$idc = $this->control_engine->insert_master($dataval, $table)[1];
						if(!empty($idc))
							$this->session->set_flashdata("record_save","Record Saved!");				    
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
					    }
					}
					else if(!empty($question) && $trans !== false)
					{
						$dataval = array('section' => $question, 'content' => $answer, 'updated' => date('Y-m-d h:i:s', time()) );
						$fieldcond = array('id' => $trans );
						$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
				    	if($s_data2)
				    	{
							$this->session->set_flashdata("record_save","Record Updated!");
						}						
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
					    }

					}

					$dash_data['section'] = $question;
					$dash_data['content'] = $answer;

				}


				
			}


			if(!empty($trans) && is_numeric($trans))
			{
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond  = array('id' => $trans );
				$edit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($edit_data) && is_array($edit_data))
				{
					$dash_data['section'] = $edit_data[0]['section'];
					$dash_data['content'] = $edit_data[0]['content'];
				}
			}
			
			

			$this->load->view('gsi-portal/edit-term', $dash_data);
		}
			
	}

	public function privacy($trans=1)
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$table='privacy_policy';
			$dash_data['section'] = "";
			$dash_data['content'] = "";

			if(!empty($_POST['logger']) )
			{
				//var_dump($_POST);

				//$this->form_validation->set_rules('section', 'Section', 'required');
				$this->form_validation->set_rules('content', 'Content', 'required');

				if(($this->form_validation->run() == TRUE)  )
				{
					//$question = $this->test_input($_POST['section']);
					$answer = $this->test_input($_POST['content']);
					//$answer = mysqli_escape_string($_POST['content']);

					if(!empty($answer) && $trans == false)
					{
						$dataval = array( 'content' => $answer, 'updated' => date('Y-m-d h:i:s', time()) );
						$idc = $this->control_engine->insert_master($dataval, $table)[1];
						if(!empty($idc))
							$this->session->set_flashdata("record_save","Record Saved!");				    
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
					    }
					}
					else if(!empty($answer) && $trans !== false)
					{
						$dataval = array('content' => $answer, 'updated' => date('Y-m-d h:i:s', time()) );
						$fieldcond = array('id' => $trans );
						$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
				    	if($s_data2)
				    	{
							$this->session->set_flashdata("record_save","Record Updated!");
						}						
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
					    }

					}

					//$dash_data['section'] = $question;
					$dash_data['content'] = $answer;

				}


				
			}


			if(!empty($trans) && is_numeric($trans))
			{
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond  = array('id' => $trans );
				$edit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($edit_data) && is_array($edit_data))
				{
					//$dash_data['section'] = $edit_data[0]['section'];
					$dash_data['content'] = $edit_data[0]['content'];
				}
			}
			
			

			$this->load->view('gsi-portal/privacy', $dash_data);
		}
			
	}

	public function social_media_edit($trans=false)
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$table='social_media';
			$dash_data['title'] = "";
			$dash_data['address'] = "";

			if(!empty($_POST['logger']) )
			{
				//var_dump($_POST);

				$this->form_validation->set_rules('title', 'Title', 'required');

				if(($this->form_validation->run() == TRUE)  )
				{
					$title = $this->test_input($_POST['title']);
					$address = $this->test_input($_POST['address']);

					if(!empty($title) && $trans == false)
					{
						$dataval = array('title' => $title, 'address' => $address, 'updated' => date('Y-m-d h:i:s', time()) );
						$idc = $this->control_engine->insert_master($dataval, $table)[1];
						if(!empty($idc))
							$this->session->set_flashdata("record_save","Record Saved!");				    
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
					    }
					}
					else if(!empty($title) && $trans !== false)
					{
						$dataval = array('title' => $title, 'address' => $address, 'updated' => date('Y-m-d h:i:s', time()) );
						$fieldcond = array('id' => $trans );
						$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
				    	if($s_data2)
				    	{
							$this->session->set_flashdata("record_save","Record Updated!");
						}						
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
					    }

					}

					$dash_data['title'] = $title;
					$dash_data['address'] = $address;

				}


				
			}


			if(!empty($trans) && is_numeric($trans))
			{
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond  = array('id' => $trans );
				$edit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($edit_data) && is_array($edit_data))
				{
					$dash_data['title'] = $edit_data[0]['title'];
					$dash_data['address'] = $edit_data[0]['address'];
				}
			}
			
			

			$this->load->view('gsi-portal/edit-social-media', $dash_data);
		}
			
	}
	public function social_media($trans=false,$remid='')
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$dash_data['remid'] = $remid;
			$table='social_media';

			if(!empty($remid))
			{
				$remid = $this->base64_url_decode($remid);
				$fieldcond = array('id' => $remid );
				$this->control_engine->delete_master($table,$fieldcond);
			}


			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['quote_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			


			if(!empty($trans) && is_numeric($trans))
			{
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond  = array('id' => $trans );
				$edit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($edit_data) && is_array($edit_data))
				{
					$dash_data['title'] = $edit_data[0]['title'];
					$dash_data['cite'] = $edit_data[0]['address'];
				}
			}
			

			$this->load->view('gsi-portal/social-media', $dash_data);
		}
			
	}

	public function product_information_edit($trans=false)
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$table='products';
			$dash_data['productname'] = "";
			$dash_data['curprice'] = "";
			$dash_data['oldprice'] = "";
			$dash_data['qtty'] = "";
			$dash_data['range'] = "";
			$dash_data['cate'] = "";
			$dash_data['f_capcover_img'] = "";
			$dash_data['color'] = "";
			$dash_data['rating'] = "";
			$dash_data['descr'] = "";
			$dash_data['skintype'] = "";
			$dash_data['shelflive'] = "";
			$dash_data['size'] = "";
			$dash_data['usage'] = "";
			$dash_data['keying'] = "";
			$dash_data['fulling'] = "";
			$dash_data['skinconcern'] = "";
			$target_file = '';

			if(!empty($_POST['logger']) )
			{
				//var_dump($_POST);

				$this->form_validation->set_rules('productname', 'Product Name', 'required');
				$this->form_validation->set_rules('curprice', 'Current Price', 'required');
				$this->form_validation->set_rules('qtty', 'Quantity', 'required');
				$this->form_validation->set_rules('range', 'Product Range', 'required');
				$this->form_validation->set_rules('cate', 'Product Category', 'required');

				if(($this->form_validation->run() == TRUE)  )
				{
					$productname = $this->test_input($_POST['productname']);
					$curprice = $this->test_input($_POST['curprice']);
					$oldprice = $this->test_input($_POST['oldprice']);
					$qtty = $this->test_input($_POST['qtty']);
					$range = $this->test_input($_POST['range']);
					$cate = $this->test_input($_POST['cate']);
					$color = $this->test_input($_POST['color']);
					$rating = $this->test_input($_POST['rating']);
					$descr = $this->test_input($_POST['descr']);
					$skintype = $this->test_input($_POST['skintype']);
					$shelflive = $this->test_input($_POST['shelflive']);
					$size = $this->test_input($_POST['size']);
					$usage = $this->test_input($_POST['usage']);
					$keying = $this->test_input($_POST['keying']);
					$fulling = $this->test_input($_POST['fulling']);
					$skinconcern = $this->test_input($_POST['skinconcern']);

					if(!empty($productname) && $trans == false)
					{
						$dataval = array(
											'name' => $productname,
											'current_price' => $curprice,
											'old_price' => $oldprice,
											'rating' => $rating,
											'color' => $color,
											'range_id' => $range,
											'category_id' => $cate,
											'quantity' => $qtty,
											'description' => $descr,
											'skin_type' => $skintype,
											'skin_concern' => $skinconcern,
											'size' => $size,
											'usage_instruction' => $usage,
											'key_func_ingred' => $keying,
											'full_ingred_list' => $fulling,
											'shelf_live' => $shelflive,
											'updated' => date('Y-m-d h:i:s', time()) 
										);

						$idc = $this->control_engine->insert_master($dataval, $table)[1];
						if(!empty($idc))
						{
							$this->session->set_flashdata("record_save","Record Saved!");
							$fieldname = 'cover_img_file';
							if (!empty($_FILES[$fieldname]['name']))
							{
								$target_file = '';
								$target_dir = "gsi-assets/gsi-uploads/product-images/";
								is_dir($target_dir) OR mkdir($target_dir,0755);
								$config['upload_path'] = $target_dir;
								$path=$config['upload_path'];
								$config['allowed_types'] = 'gif|jpg|jpeg|png';
								$config['max_size'] = '896000';
								$config['max_width'] = '1920';
								$config['max_height'] = '1280';

								$tst = time();					    	
								$imf = basename($_FILES[$fieldname]['name']);
							    $imf = str_replace(' ', '_', $imf);
							    $target_file = $tst."_" . $imf;
								$config['file_name'] = $target_file;
								$this->load->library('upload', $config);

							    $this->upload->initialize($config);
							    if (!$this->upload->do_upload($fieldname))
							    {
							    	$target_file = '';
							        $this->session->set_flashdata("record_error",$this->upload->display_errors());
							    }
							    else
							    {
							    	$dataval = array('image' => $target_file );
							    	$fieldcond = array('id' => $idc );
									$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
							    	if($s_data2)
							    	{
										$this->session->set_flashdata("record_save","Record Saved and Image Uploaded!");
									}
							    	
							    }
							}

						}
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
					    }
					}
					else if(!empty($productname) && $trans !== false)
					{
						$dataval = array(
											'name' => $productname,
											'current_price' => $curprice,
											'old_price' => $oldprice,
											'rating' => $rating,
											'color' => $color,
											'range_id' => $range,
											'category_id' => $cate,
											'quantity' => $qtty,
											'description' => $descr,
											'skin_type' => $skintype,
											'skin_concern' => $skinconcern,
											'size' => $size,
											'usage_instruction' => $usage,
											'key_func_ingred' => $keying,
											'full_ingred_list' => $fulling,
											'shelf_live' => $shelflive,
											'updated' => date('Y-m-d h:i:s', time()) 
										);

						$fieldcond = array('id' => $trans );
						$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
				    	if($s_data2)
				    	{
							$this->session->set_flashdata("record_save","Record Updated!");
							$fieldname = 'cover_img_file';
							if (!empty($_FILES[$fieldname]['name']))
							{
								$target_dir = "gsi-assets/gsi-uploads/product-images/";
								is_dir($target_dir) OR mkdir($target_dir,0755);
								$config['upload_path'] = $target_dir;
								$path=$config['upload_path'];
								$config['allowed_types'] = 'gif|jpg|jpeg|png';
								$config['max_size'] = '896000';
								$config['max_width'] = '1920';
								$config['max_height'] = '1280';

								$tst = time();					    	
								$imf = basename($_FILES[$fieldname]['name']);
							    $imf = str_replace(' ', '_', $imf);
							    $target_file = $tst."_" . $imf;
								$config['file_name'] = $target_file;
								$this->load->library('upload', $config);

							    $this->upload->initialize($config);
							    if (!$this->upload->do_upload($fieldname))
							    {
							    	$target_file = '';
							        $this->session->set_flashdata("record_error",$this->upload->display_errors());
							    }
							    else
							    {
							    	$dataval = array('image' => $target_file );
							    	$fieldcond = array('id' => $trans );
									$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
							    	if($s_data2)
							    	{
										$this->session->set_flashdata("record_save","Record Updated and Image Uploaded!");
									}
							    	
							    }
							}
						}						
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be updated!");
					    }

					    $dash_data['productname'] = $productname;
						$dash_data['curprice'] = $curprice;
						$dash_data['oldprice'] = $oldprice;
						$dash_data['qtty'] = $qtty;
						$dash_data['range'] = $range;
						$dash_data['cate'] = $cate;
						$dash_data['f_capcover_img'] = 'gsi-assets/gsi-uploads/product-images/'.$target_file;
						$dash_data['color'] = $color;
						$dash_data['rating'] = $rating;
						$dash_data['skintype'] = $skintype;
						$dash_data['shelflive'] = $shelflive;
						$dash_data['size'] = $size;
						$dash_data['usage'] = $usage;
						$dash_data['keying'] = $keying;
						$dash_data['fulling'] = $fulling;
						$dash_data['skinconcern'] = $skinconcern;

					}

					

				}


				
			}


			if(!empty($trans) && is_numeric($trans))
			{
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond  = array('id' => $trans );
				$edit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($edit_data) && is_array($edit_data))
				{
					$dash_data['productname'] = $edit_data[0]['name'];
					$dash_data['curprice'] = $edit_data[0]['current_price'];
					$dash_data['oldprice'] = $edit_data[0]['old_price'];
					$dash_data['qtty'] = $edit_data[0]['quantity'];
					$dash_data['range'] = $edit_data[0]['range_id'];
					$dash_data['cate'] = $edit_data[0]['category_id'];
					$dash_data['f_capcover_img'] = 'gsi-assets/gsi-uploads/product-images/'.$edit_data[0]['image'];
					$dash_data['color'] = $edit_data[0]['color'];
					$dash_data['rating'] = $edit_data[0]['rating'];
					$dash_data['descr'] = $edit_data[0]['description'];

					$dash_data['skintype'] = $edit_data[0]['skin_type'];
					$dash_data['shelflive'] = $edit_data[0]['shelf_live'];
					$dash_data['size'] = $edit_data[0]['size'];
					$dash_data['usage'] = $edit_data[0]['usage_instruction'];
					$dash_data['keying'] = $edit_data[0]['key_func_ingred'];
					$dash_data['fulling'] = $edit_data[0]['full_ingred_list'];
					$dash_data['skinconcern'] = $edit_data[0]['skin_concern'];
				}
			}

			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = $fieldcond = false;
			$dash_data['product_range'] = $this->control_engine->master_get('product_range',$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = $fieldcond = false;
			$dash_data['product_category'] = $this->control_engine->master_get('product_category',$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			
			

			$this->load->view('gsi-portal/edit_product_info', $dash_data);
		}
			
	}

	public function product_list($pagetype=1,$remid='')
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			if($pagetype==1)
				$dash_data['pagetypename'] = "Basic";
			if($pagetype==2)
				$dash_data['pagetypename'] = "Key";
			if($pagetype==3)
				$dash_data['pagetypename'] = "Elementary";

			$dash_data['pagetype'] = $pagetype;
			$dash_data['remid'] = $remid;
			$table='products';

			if(!empty($remid))
			{
				$remid = $this->base64_url_decode($remid);
				$fieldcond = array('id' => $remid );
				$this->control_engine->delete_master($table,$fieldcond);
			}

			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['product_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = $fieldcond = false;
			$dash_data['product_range'] = $this->control_engine->master_get('product_range',$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = $fieldcond = false;
			$dash_data['product_category'] = $this->control_engine->master_get('product_category',$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			
			

			$this->load->view('gsi-portal/product-list', $dash_data);
		}
			
	}

	public function product_information($trans=1)
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else if(is_numeric($trans))
		{
			/*$dash_data['pagetype'] = $pagetype;
			$dash_data['remid'] = $remid;*/
			$dash_data['trans'] = $trans;
			$dash_data['product_name'] = 'Product Information';
			$table='products';

			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldcond = array('id' => $trans );
			$dash_data['product_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = $fieldcond = false;
			$dash_data['product_range'] = $this->control_engine->master_get('product_range',$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = $fieldcond = false;
			$dash_data['product_category'] = $this->control_engine->master_get('product_category',$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			
			

			$this->load->view('gsi-portal/product-info', $dash_data);
		}
		else
		{
			$this->product_list(1);
		}
			
	}

	public function blog_edit($trans=false)
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$table='blog';
			$dash_data['title'] = "";
			$dash_data['f_capcover_img'] = "";
			$dash_data['descr'] = "";
			$target_file = '';

			if(!empty($_POST['logger']) )
			{
				//var_dump($_POST);

				$this->form_validation->set_rules('title', 'Blog Title', 'required');
				$this->form_validation->set_rules('descr', 'Blog Details', 'required');

				if(($this->form_validation->run() == TRUE)  )
				{
					$title = $this->test_input($_POST['title']);
					$descr = $this->test_input($_POST['descr']);

					if(!empty($title) && $trans == false)
					{
						$dataval = array(
											'title' => $title,
											'content' => $descr,
											'updated' => date('Y-m-d h:i:s', time()) 
										);

						$idc = $this->control_engine->insert_master($dataval, $table)[1];
						if(!empty($idc))
						{
							$this->session->set_flashdata("record_save","Record Saved!");
							$fieldname = 'cover_img_file';
							if (!empty($_FILES[$fieldname]['name']))
							{
								$target_file = '';
								$target_dir = "gsi-assets/gsi-uploads/blog-images/";
								is_dir($target_dir) OR mkdir($target_dir,0755);
								$config['upload_path'] = $target_dir;
								$path=$config['upload_path'];
								$config['allowed_types'] = 'gif|jpg|jpeg|png';
								$config['max_size'] = '896000';
								$config['max_width'] = '1920';
								$config['max_height'] = '1280';

								$tst = time();					    	
								$imf = basename($_FILES[$fieldname]['name']);
							    $imf = str_replace(' ', '_', $imf);
							    $target_file = $tst."_" . $imf;
								$config['file_name'] = $target_file;
								$this->load->library('upload', $config);

							    $this->upload->initialize($config);
							    if (!$this->upload->do_upload($fieldname))
							    {
							    	$target_file = '';
							        $this->session->set_flashdata("record_error",$this->upload->display_errors());
							    }
							    else
							    {
							    	$dataval = array('image' => $target_file );
							    	$fieldcond = array('id' => $idc );
									$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
							    	if($s_data2)
							    	{
										$this->session->set_flashdata("record_save","Record Saved and Image Uploaded!");
									}
							    	
							    }
							}

						}
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be saved!");
					    }

					    $dash_data['title'] = $title;
						$dash_data['descr'] = $descr;
						$dash_data['f_capcover_img'] = 'gsi-assets/gsi-uploads/blog-images/'.$target_file;
					}
					if(!empty($title) && $trans !== false)
					{
						$dataval = array(
											'title' => $title,
											'content' => $descr,
											'updated' => date('Y-m-d h:i:s', time()) 
										);

						$fieldcond = array('id' => $trans );
						$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
				    	if($s_data2)
				    	{
							$this->session->set_flashdata("record_save","Record Updated!");
							$fieldname = 'cover_img_file';
							if (!empty($_FILES[$fieldname]['name']))
							{
								$target_dir = "gsi-assets/gsi-uploads/blog-images/";
								is_dir($target_dir) OR mkdir($target_dir,0755);
								$config['upload_path'] = $target_dir;
								$path=$config['upload_path'];
								$config['allowed_types'] = 'gif|jpg|jpeg|png';
								$config['max_size'] = '896000';
								$config['max_width'] = '1920';
								$config['max_height'] = '1280';

								$tst = time();					    	
								$imf = basename($_FILES[$fieldname]['name']);
							    $imf = str_replace(' ', '_', $imf);
							    $target_file = $tst."_" . $imf;
								$config['file_name'] = $target_file;
								$this->load->library('upload', $config);

							    $this->upload->initialize($config);
							    if (!$this->upload->do_upload($fieldname))
							    {
							    	$target_file = '';
							        $this->session->set_flashdata("record_error",$this->upload->display_errors());
							    }
							    else
							    {
							    	$dataval = array('image' => $target_file );
							    	$fieldcond = array('id' => $trans );
									$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
							    	if($s_data2)
							    	{
										$this->session->set_flashdata("record_save","Record Updated and Image Uploaded!");
									}
							    	
							    }
							}
						}						
					    else
					    {
					    	$this->session->set_flashdata("record_error","Sorry, record could not be updated!");
					    }

					    $dash_data['title'] = $title;
						$dash_data['descr'] = $descr;
						$dash_data['f_capcover_img'] = 'gsi-assets/gsi-uploads/blog-images/'.$target_file;

					}

					

				}


				
			}


			if(!empty($trans) && is_numeric($trans))
			{
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond  = array('id' => $trans );
				$edit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($edit_data) && is_array($edit_data))
				{
					$dash_data['title'] = $edit_data[0]['title'];
					$dash_data['descr'] = $edit_data[0]['content'];
					$dash_data['f_capcover_img'] = 'gsi-assets/gsi-uploads/blog-images/'.$edit_data[0]['image'];
				}
			}
			

			$this->load->view('gsi-portal/edit-blog-info', $dash_data);
		}
			
	}

	public function blog_list($trans=false,$remid='')
	{
		if (empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$this->index();
		}
		else
		{
			$dash_data['trans'] = $trans;
			$dash_data['remid'] = $remid;
			$table='blog';

			if(!empty($remid))
			{
				$remid = $this->base64_url_decode($remid);
				$fieldcond = array('id' => $remid );
				$this->control_engine->delete_master($table,$fieldcond);
			}

			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['blog_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			


			if(!empty($trans) && is_numeric($trans))
			{
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond  = array('id' => $trans );
				$edit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($edit_data) && is_array($edit_data))
				{
					$dash_data['title'] = $edit_data[0]['title'];
					$dash_data['f_capcover_img'] = 'gsi-assets/gsi-uploads/product-images/'.$edit_data[0]['image'];
					$dash_data['content'] = $edit_data[0]['content'];
				}
			}
			

			$this->load->view('gsi-portal/blog-list', $dash_data);
		}
			
	}

	public function index()
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
		if(is_array($reff));
		{
			$coreectref = false;
			$refcount = 0;
			//foreach ($reff as $key => $val) 
			for ($i=0; $i < sizeof($reff); $i++)
			{
				//if(!empty($reff[$i])&&((strpos($reff[$i], 'admin') !== false)||(strpos($reff[$i], 'Admin') !== false))&&(strpos($reff[$i], 'logout') === false)&&($i<(sizeof($reff)-1)))
				//var_dump($this->findString("logout",$reff[$i],"i",""));
				//if(!empty($reff[$i])&&($this->findString("admin",$reff[$i],"i","") !== false)&&($this->findString("logout",$reff[$i],"i","") === false)&&($i<(sizeof($reff)-1)))
				if(!empty($reff[$i])&&($this->findString("admin",$reff[$i],"i","") !== false)&&($this->findString("logout",$reff[$i],"i","") === false)&&($i<(sizeof($reff)-1)))
				{
					$coreectref = true;					
				}
				if($this->findString("logout",$reff[$i],"i","") !== false)
				{
					$coreectref = false;
					//var_dump($coreectref);
				}

				//$coreectref = false;
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
		// $_SESSION['result_gate_pass'] = '';
		// $_SESSION['result_gate_pass_time'] = '';
		if(empty($_SESSION['result_gate_pass']))
		{
			$ff = false;	
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
		}
		
		$ttv = $ttv2 = '';
		$dashboard_data['ntf'] = '';
		if(!empty($_POST['logger']) )
		{
			$ttv = $_POST['password'];
			$ttv2 = $_POST['Username'];	

			$ttv = $this->test_input($_POST['password']);
			$ttv2 = $this->test_input($_POST['Username']);	
			$table = 'users';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = false;
			$fieldval = "id,username,password";
			$fieldcond = array('user_type' => 1 );
			$tll = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			
			if(!empty($tll) && is_array($tll))
			{
				foreach ($tll as $key => $value) 
				{
					if( ($value['username'] == $ttv2) && password_verify($ttv, $value['password']) )
					{
						$_SESSION['result_gate_pass'] = $value['id'];
						$_SESSION['result_gate_pass_time'] = time();
						$ff = true;
					}
				}
			}
			if(!$ff)
			{
				//$dashboard_data['ntf'] = 'gg';
				$dashboard_data['ntf'] = '<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button> <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span> Invalid Login Parameter </div>';
			}
		}

		if(($ff)&&(!empty($reffer)))
		{
			redirect('/'.$reffer);
		}
		else if($ff)
			$this->entry_gate(); 
		else
			$this->load->view('gsi-portal/login',$dashboard_data);
	}

	public function logout()
	{
		$_SESSION['result_gate_pass'] = '';
		$_SESSION['result_gate_pass_time'] = '';
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