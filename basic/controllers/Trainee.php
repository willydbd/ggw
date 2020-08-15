<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Trainee extends CI_Controller {

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

	public function entry_gate()
	{
		if(empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800) || ($_SESSION['result_gate_user_type'] != '3'))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$_SESSION['result_gate_user_type'] = '';
			$_SESSION['result_gate_user_id'] = '';

			$this->index();
		}
		else
		{
			$SESSION['result_gate_pass_time'] = time();

			$dash_data['sync_server_url']='';
		
			$table = 'server_url';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['sync_server_url'] = $sync_server_url = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($sync_server_url) && is_array($sync_server_url))
			{
				$_SESSION['sync_server_url'] = $sync_server_url[0]['url'];
			}


			$table='trainee_location';
			$fieldval = 'trainee_location.id as trid,trainee_location.name_of_trainee as ntr, trainee_location.center_name_ID as cid, trainee_human_capital.gender as gen, trainee_location.state as state, trainee_location.lga as lga, trainee_location.village as vill, marital_status.item as marst, trainee_location.phone as phone, trainee_location.photo as photo, trainee_age.item as age';
			$ordercond = ['trainee_location.updated desc'];
	        $jt_wt_cond = array("trainee_human_capital" => "trainee_human_capital.trainee_ID=trainee_location.id", "marital_status" => "marital_status.id=trainee_human_capital.marital_status", "trainee_age" => "trainee_age.id=trainee_human_capital.age");
	        $fieldcond = $limitoffsetcond = false;
			$dash_data['trainee_location_data'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond);	


			//var_dump($_SESSION['result_gate_user_id']);
			$trans = $_SESSION['result_gate_user_id'];
			$table = 'staff_info';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldcond = array('id' => $trans );
			$dash_data['staff_info_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			//var_dump($dash_data['staff_info_data']);

			if(!empty($dash_data['staff_info_data']) && is_array($dash_data['staff_info_data']))
			{
				$centerID = $dash_data['staff_info_data'][0]['center_name_ID'];
				$_SESSION['result_gate_Data_Entry_Clerk'] = $dash_data['staff_info_data'][0]['surname']. ' '.$dash_data['staff_info_data'][0]['firstname']. ' '.$dash_data['staff_info_data'][0]['lastname'];

				$table = 'basic_site_info';
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond = array('id' => $centerID );
				$dash_data['basic_site_info_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
				
				if(!empty($dash_data['basic_site_info_data']) && is_array($dash_data['basic_site_info_data']))
				{
					//var_dump($dash_data['basic_site_info_data']);
					$_SESSION['result_gate_CENTER_NAME'] = $dash_data['basic_site_info_data'][0]['center_name'];
					$_SESSION['result_gate_CENTER_STATE'] = $dash_data['basic_site_info_data'][0]['state'];
					$_SESSION['result_gate_CENTER_ID'] = $dash_data['basic_site_info_data'][0]['id'];

					$center_name_ID = $_SESSION['result_gate_CENTER_ID'];

					$poster_container = array();

					$table = 'trainee_location';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_name_ID, 'rec_db_sync' => 0 );
					$trainee_location_data_sync = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					if(!empty($trainee_location_data_sync))
					{
						$poster = array();
						$poster['rrrdata'] = base64_encode(json_encode($trainee_location_data_sync));
						$poster['rrrtable'] = $table;
						array_push($poster_container, $poster);
					}

					$table = 'trainee_human_capital';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_name_ID, 'rec_db_sync' => 0 );
					$trainee_human_capital_data_sync = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					if(!empty($trainee_human_capital_data_sync))
					{
						$poster = array();
						$poster['rrrdata'] = base64_encode(json_encode($trainee_human_capital_data_sync));
						$poster['rrrtable'] = $table;
						array_push($poster_container, $poster);
					}					

					$table = 'trainee_social_capital';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_name_ID, 'rec_db_sync' => 0 );
					$trainee_social_capital_data_sync = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					if(!empty($trainee_social_capital_data_sync))
					{
						$poster = array();
						$poster['rrrdata'] = base64_encode(json_encode($trainee_social_capital_data_sync));
						$poster['rrrtable'] = $table;
						array_push($poster_container, $poster);
					}

					$table = 'trainee_natural_capital';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_name_ID, 'rec_db_sync' => 0 );
					$trainee_natural_capital_data_sync = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					if(!empty($trainee_natural_capital_data_sync))
					{
						$poster = array();
						$poster['rrrdata'] = base64_encode(json_encode($trainee_natural_capital_data_sync));
						$poster['rrrtable'] = $table;
						array_push($poster_container, $poster);
					}

					$table = 'trainee_physical_capital';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_name_ID, 'rec_db_sync' => 0 );
					$trainee_physical_capital_data_sync = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					if(!empty($trainee_physical_capital_data_sync))
					{
						$poster = array();
						$poster['rrrdata'] = base64_encode(json_encode($trainee_physical_capital_data_sync));
						$poster['rrrtable'] = $table;
						array_push($poster_container, $poster);
					}

					$table = 'trainee_financial_capital';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_name_ID, 'rec_db_sync' => 0 );
					$trainee_financial_capital_data_sync = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					if(!empty($trainee_financial_capital_data_sync))
					{
						$poster = array();
						$poster['rrrdata'] = base64_encode(json_encode($trainee_financial_capital_data_sync));
						$poster['rrrtable'] = $table;
						array_push($poster_container, $poster);
					}

					$table = 'trainee_fingerprint_info';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('site_center_id' => $center_name_ID, 'rec_db_sync' => 0 );
					$trainee_fingerprint_info_data_sync = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					if(!empty($trainee_fingerprint_info_data_sync))
					{
						$poster = array();
						$poster['rrrdata'] = base64_encode(json_encode($trainee_fingerprint_info_data_sync));
						$poster['rrrtable'] = $table;
						array_push($poster_container, $poster);
					}

					$table = 'adhoc_basic_info';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('site_center_id' => $center_name_ID, 'rec_db_sync' => 0 );
					$adhoc_basic_info_sync = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					if(!empty($adhoc_basic_info_sync))
					{
						$poster = array();
						$poster['rrrdata'] = base64_encode(json_encode($adhoc_basic_info_sync));
						$poster['rrrtable'] = $table;
						array_push($poster_container, $poster);
					}

					$table = 'adhoc_education';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('site_center_id' => $center_name_ID, 'rec_db_sync' => 0 );
					$adhoc_education_sync = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					if(!empty($adhoc_education_sync))
					{
						$poster = array();
						$poster['rrrdata'] = base64_encode(json_encode($adhoc_education_sync));
						$poster['rrrtable'] = $table;
						array_push($poster_container, $poster);
					}


					$dash_data['poster_container'] = base64_encode(json_encode($poster_container));


				}

			}

				
			

			$this->load->view('index', $dash_data);
		}
	}

	public function center_info($trans=false)
	{
		if(empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800) || ($_SESSION['result_gate_user_type'] != 3))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$_SESSION['result_gate_user_type'] = '';
			$_SESSION['result_gate_user_id'] = '';

			$this->index();
		}
		else
		{
			$SESSION['result_gate_pass_time'] = time();
			$trans = $_SESSION['result_gate_CENTER_ID'];
			$dash_data['trans'] = $trans;

			if(!empty($trans) && is_numeric($trans))
			{
				$table = 'basic_site_info';
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond = array('id' => $trans );
				$dash_data['basic_site_info_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($dash_data['basic_site_info_data'][0]['id']))
				{
					$center_nameID = $dash_data['basic_site_info_data'][0]['id'];

					$table = 'site_location';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_nameID );
					$dash_data['site_location_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					$table = 'site_vegetation_landcover';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_nameID );
					$dash_data['site_vegetation_landcover_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					$table = 'site_terrain_attributes';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_nameID );
					$dash_data['site_terrain_attributes_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					$table = 'site_soil';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_nameID );
					$dash_data['site_soil_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					$table = 'site_geology';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_nameID );
					$dash_data['site_geology_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					$table = 'site_drainage';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_nameID );
					$dash_data['site_drainage_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					$table = 'site_land_disturbance_types';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_nameID );
					$dash_data['site_land_disturbance_types_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					$table = 'site_archaeological_attributes';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_nameID );
					$dash_data['site_archaeological_attributes_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					$table = 'site_suitability_orders';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_nameID );
					$dash_data['site_suitability_orders_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					$table = 'site_suitability_classes_order_s';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_nameID );
					$dash_data['site_suitability_classes_order_s_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					$table = 'site_suitability_classes_order_n';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_nameID );
					$dash_data['site_suitability_classes_order_n_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					$table = 'site_general_observation_comment';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('center_name_ID' => $center_nameID );
					$dash_data['site_general_observation_comment_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				}								

			}

			$table = 'nigerian_states_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['nig_states'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$table = 'nigerian_states_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['nig_states'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);


			$this->load->view('center_info', $dash_data);
		}
			
	}

	public function adhoc_list($trans=false)
	{
		if(empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800) || ($_SESSION['result_gate_user_type'] != 3))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$_SESSION['result_gate_user_type'] = '';
			$_SESSION['result_gate_user_id'] = '';

			$this->index();
		}
		else
		{
			$SESSION['result_gate_pass_time'] = time();
			$dash_data['trans'] = $trans;


			if(!empty($trans) && is_numeric($trans))
			{
				$table = 'basic_site_info';												

			}

			
			$table = 'adhoc_basic_info';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['adhoc_basic_info_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$table = 'basic_site_info';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['basic_site_info_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);		
			

			$this->load->view('adhoc_list', $dash_data);
		}
			
	}

	public function adhoc_profile($trans=1)
	{
		if(empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800) || ($_SESSION['result_gate_user_type'] != 3))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$_SESSION['result_gate_user_type'] = '';
			$_SESSION['result_gate_user_id'] = '';

			$this->index();
		}
		else
		{
			$SESSION['result_gate_pass_time'] = time();
			$dash_data['trans'] = $trans;


			if(!empty($trans) && is_numeric($trans))
			{
				$table = 'basic_site_info';												

			}

			
			$table = 'adhoc_basic_info';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldcond = array('id' => $trans );
			$dash_data['adhoc_basic_info_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$table = 'basic_site_info';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['basic_site_info_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);		
			

			$this->load->view('adhoc_profile', $dash_data);
		}
			
	}

	public function enroll_edit($trans=false)
	{
		if(empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800) || ($_SESSION['result_gate_user_type'] != '3'))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$_SESSION['result_gate_user_type'] = '';
			$_SESSION['result_gate_user_id'] = '';

			$this->index();
		}
		else
		{
			$SESSION['result_gate_pass_time'] = time();
			$dash_data['trans'] = $trans;


			if(!empty($trans) && is_numeric($trans))
			{
				$table = 'trainee_location';
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond = array('id' => $trans );
				$dash_data['trainee_location_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				if(!empty($dash_data['trainee_location_data'][0]['id']))
				{
					$traineeID = $dash_data['trainee_location_data'][0]['id'];

					$table = 'trainee_human_capital';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('trainee_ID' => $traineeID );
					$dash_data['trainee_human_capital_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					$table = 'trainee_social_capital';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('trainee_ID' => $traineeID );
					$dash_data['trainee_social_capital_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					$table = 'trainee_natural_capital';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('trainee_ID' => $traineeID );
					$dash_data['trainee_natural_capital_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					$table = 'trainee_physical_capital';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('trainee_ID' => $traineeID );
					$dash_data['trainee_physical_capital_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					$table = 'trainee_financial_capital';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('trainee_ID' => $traineeID );
					$dash_data['trainee_financial_capital_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

					$table = 'trainee_fingerprint_info';
					$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
					$fieldcond = array('trainee_ID' => $traineeID );
					$dash_data['trainee_fingerprint_info_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				}								

			}

			$table = 'nigerian_states_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['nig_states'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$table = 'nigerian_states_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['nig_states'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$table = 'trainee_age';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['trainee_age_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'marital_status';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['marital_status_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'out_of_village_seasonal';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['out_of_village_seasonal_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'out_migrated';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['out_migrated_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'educational_level';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['educational_level_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'technical_training';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['technical_training_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'capacity_development';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['capacity_development_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'starter_pack';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['starter_pack_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'socio_economic_group';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['socio_economic_group_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'external_institutions';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['external_institutions_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'agricultural_land';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['agricultural_land_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'land_ownership';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['land_ownership_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'main_land_use';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['main_land_use_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'goods_tools_owned';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['goods_tools_owned_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'first_source_livelihood';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['first_source_livelihood_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'second_source_livelihood';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['second_source_livelihood_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'trend_of_income';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['trend_of_income_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'micro_credit';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['micro_credit_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			$table = 'energy_sources';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['energy_sources_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$table = 'trainee_fingerprint_info';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['probe_trainee_fingerprint_info_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			
			

			$this->load->view('enroll', $dash_data);
		}
			
	}

	public function adhoc_edit($trans=false)
	{
		if(empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800) || ($_SESSION['result_gate_user_type'] != 3))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$_SESSION['result_gate_user_type'] = '';
			$_SESSION['result_gate_user_id'] = '';

			$this->index();
		}
		else
		{
			$SESSION['result_gate_pass_time'] = time();
			$dash_data['trans'] = $trans;

			if(!empty($trans) && is_numeric($trans))
			{
				$table = 'adhoc_basic_info';
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond = array('id' => $trans );
				$dash_data['adhoc_basic_info_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

				$table = 'adhoc_education';
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$fieldcond = array('adhoc_ID' => $trans );
				$dash_data['adhoc_education_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);												

			}

			$table = 'nigerian_states_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['nig_states'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$table = 'basic_site_info';
				$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
				$dash_data['basic_site_info_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$table = 'marital_status';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['marital_status_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);


			$this->load->view('reg_adhoc', $dash_data);
		}
			
	}

	public function trainee_list($trans=false)
	{
		
		if(empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800) || ($_SESSION['result_gate_user_type'] != '3'))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$_SESSION['result_gate_user_type'] = '';
			$_SESSION['result_gate_user_id'] = '';

			$this->index();
		}
		else
		{
			$SESSION['result_gate_pass_time'] = time();
			$dash_data['trans'] = $trans;


			if(!empty($trans) && is_numeric($trans))
			{
				$table = 'trainee_location';												

			}

			
			$table='trainee_location';
			$fieldval = 'trainee_location.id as trid,trainee_location.name_of_trainee as ntr, trainee_location.center_name_ID as cid, trainee_location.data_entry_clerk as decl, trainee_human_capital.gender as gen, trainee_location.state as state, trainee_location.lga as lga, trainee_location.village as vill, marital_status.item as marst, trainee_location.phone as phone, trainee_location.photo as photo, trainee_age.item as age';
			$ordercond = ['trainee_location.updated desc'];
	        $jt_wt_cond = array("trainee_human_capital" => "trainee_human_capital.trainee_ID=trainee_location.id", "marital_status" => "marital_status.id=trainee_human_capital.marital_status", "trainee_age" => "trainee_age.id=trainee_human_capital.age");
	        $fieldcond = $limitoffsetcond = false;
			$dash_data['trainee_location_data'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond);		
			

			$this->load->view('trainee_list', $dash_data);
		}
			
	}

	public function trainee_stat($trans=false)
	{
		
		if(empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800) || ($_SESSION['result_gate_user_type'] != '3'))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$_SESSION['result_gate_user_type'] = '';
			$_SESSION['result_gate_user_id'] = '';

			$this->index();
		}
		else
		{
			$SESSION['result_gate_pass_time'] = time();
			$dash_data['trans'] = $trans;


			if(!empty($trans) && is_numeric($trans))
			{
				$table = 'trainee_location';												

			}

			$table = 'goods_tools_owned';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['goods_tools_owned_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$table = 'trainee_location';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['trainee_location_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$table = 'trainee_human_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'COUNT(gender) as total, gender';
			$groupclause=["gender"];
			$dash_data['gender_group'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike,$groupclause);
			//var_dump($dash_data['gender_group']);

			$table = 'trainee_human_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'trainee_age.item as age_group, count(trainee_human_capital.id) as total, trainee_human_capital.age';
			$groupclause=["trainee_human_capital.age"];
			$jt_wt_cond = array("trainee_age" => "trainee_age.id=trainee_human_capital.age");
			$dash_data['age_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);	

			//var_dump($dash_data['age_group']);

			$table = 'trainee_human_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'marital_status.item as marital_group, count(trainee_human_capital.id) as total, trainee_human_capital.marital_status';
			$groupclause=["trainee_human_capital.marital_status"];
			$jt_wt_cond = array("marital_status" => "marital_status.id=trainee_human_capital.marital_status");
			$dash_data['marital_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);

			$table = 'trainee_human_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'COUNT(id) as total'; $fieldcond = array('out_migrated >=' => 1 );
			$dash_data['out_migrated_group'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike,$groupclause);

			//var_dump($dash_data['out_migrated_group']);

			/*$table = 'trainee_human_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'out_migrated.item as out_migrated_group, count(trainee_human_capital.id) as total, trainee_human_capital.out_migrated';
			$groupclause=["trainee_human_capital.out_migrated"];
			$jt_wt_cond = array("out_migrated" => "out_migrated.id=trainee_human_capital.out_migrated");
			$dash_data['out_migrated_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);*/

			//var_dump($dash_data['age_group']);

			$table = 'trainee_human_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'educational_level.item as educational_level_group, count(trainee_human_capital.id) as total, trainee_human_capital.educational_level';
			$groupclause=["trainee_human_capital.educational_level"];
			$jt_wt_cond = array("educational_level" => "educational_level.id=trainee_human_capital.educational_level");
			$dash_data['educational_level_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);

			$table = 'trainee_human_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'technical_training.item as technical_training_group, count(trainee_human_capital.id) as total, trainee_human_capital.tech_training';
			$groupclause=["trainee_human_capital.tech_training"];
			$jt_wt_cond = array("technical_training" => "technical_training.id=trainee_human_capital.tech_training");
			$dash_data['technical_training_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);

			$table = 'trainee_human_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'capacity_development.item as capacity_development_group, count(trainee_human_capital.id) as total, trainee_human_capital.capacity_dev_need';
			$groupclause=["trainee_human_capital.capacity_dev_need"];
			$jt_wt_cond = array("capacity_development" => "capacity_development.id=trainee_human_capital.capacity_dev_need");
			$dash_data['capacity_development_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);



			$table = 'trainee_social_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'external_institutions.item as external_institutions_group, count(trainee_social_capital.id) as total, trainee_social_capital.connection_with_ext_institution';
			$groupclause=["trainee_social_capital.connection_with_ext_institution"];
			$jt_wt_cond = array("external_institutions" => "external_institutions.id=trainee_social_capital.connection_with_ext_institution");
			$dash_data['external_institutions_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);

			$table = 'trainee_social_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'socio_economic_group.item as socio_economic_group, count(trainee_social_capital.id) as total, trainee_social_capital.involved_socio_economic_interest_group';
			$groupclause=["trainee_social_capital.involved_socio_economic_interest_group"];
			$jt_wt_cond = array("socio_economic_group" => "socio_economic_group.id=trainee_social_capital.involved_socio_economic_interest_group");
			$dash_data['socio_economic_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);

			$table = 'trainee_natural_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'agricultural_land.item as agricultural_land_group, count(trainee_natural_capital.id) as total, trainee_natural_capital.agric_land_access_for_farming';
			$groupclause=["trainee_natural_capital.agric_land_access_for_farming"];
			$jt_wt_cond = array("agricultural_land" => "agricultural_land.id=trainee_natural_capital.agric_land_access_for_farming");
			$dash_data['agricultural_land_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);

			//var_dump($dash_data['agricultural_land_group']);

			$table = 'trainee_natural_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'land_ownership.item as land_ownership_group, count(trainee_natural_capital.id) as total, trainee_natural_capital.ownership_agric_land';
			$groupclause=["trainee_natural_capital.ownership_agric_land"];
			$jt_wt_cond = array("land_ownership" => "land_ownership.id=trainee_natural_capital.ownership_agric_land");
			$dash_data['land_ownership_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);

			$table = 'trainee_natural_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'main_land_use.item as main_land_use_group, count(trainee_natural_capital.id) as total, trainee_natural_capital.mainland_use';
			$groupclause=["trainee_natural_capital.mainland_use"];
			$jt_wt_cond = array("main_land_use" => "main_land_use.id=trainee_natural_capital.mainland_use");
			$dash_data['main_land_use_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);

			$table = 'trainee_natural_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'energy_sources.item as energy_sources_group, count(trainee_natural_capital.id) as total, trainee_natural_capital.sources_of_energy_for_cooking';
			$groupclause=["trainee_natural_capital.sources_of_energy_for_cooking"];
			$jt_wt_cond = array("energy_sources" => "energy_sources.id=trainee_natural_capital.sources_of_energy_for_cooking");
			$dash_data['energy_sources_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);

			$table = 'trainee_physical_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'goods_tools_owned.item as goods_tools_owned_group, count(trainee_physical_capital.id) as total, trainee_physical_capital.goods_tools_owned';
			$groupclause=["trainee_physical_capital.goods_tools_owned"];
			$jt_wt_cond = array("goods_tools_owned" => "goods_tools_owned.id=trainee_physical_capital.goods_tools_owned");
			$dash_data['goods_tools_owned_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);

			$table = 'trainee_financial_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'first_source_livelihood.item as first_source_group, count(trainee_financial_capital.id) as total, trainee_financial_capital.first_source_livelihood';
			$groupclause=["trainee_financial_capital.first_source_livelihood"];
			$jt_wt_cond = array("first_source_livelihood" => "first_source_livelihood.id=trainee_financial_capital.first_source_livelihood");
			$dash_data['first_source_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);

			$table = 'trainee_financial_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'second_source_livelihood.item as second_source_group, count(trainee_financial_capital.id) as total, trainee_financial_capital.second_source_livelihood';
			$groupclause=["trainee_financial_capital.second_source_livelihood"];
			$jt_wt_cond = array("second_source_livelihood" => "second_source_livelihood.id=trainee_financial_capital.second_source_livelihood");
			$dash_data['second_source_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);

			$table = 'trainee_financial_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'trend_of_income.item as trend_income_group, count(trainee_financial_capital.id) as total, trainee_financial_capital.trend_of_income';
			$groupclause=["trainee_financial_capital.trend_of_income"];
			$jt_wt_cond = array("trend_of_income" => "trend_of_income.id=trainee_financial_capital.trend_of_income");
			$dash_data['trend_income_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);

			$table = 'trainee_financial_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'COUNT(practices_off_season) as total, practices_off_season';
			$groupclause=["practices_off_season"]; $fieldcond = array('practices_off_season' => '1' );
			$dash_data['practices_off_season_group'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike,$groupclause);
			//var_dump($dash_data['practices_off_season_group']);

			$table = 'trainee_financial_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'COUNT(production_cash_crops) as total, production_cash_crops';
			$groupclause=["production_cash_crops"]; $fieldcond = array('production_cash_crops' => '1' );
			$dash_data['production_cash_crops_group'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike,$groupclause);

			$table = 'trainee_financial_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'SUM(no_livestock_cattle) as total_cattle, SUM(no_livestock_goat) as total_goat, SUM(no_livestock_sheep) as total_sheep, SUM(no_livestock_poultry) as total_poultry';
			$dash_data['livestock_group'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);


			//var_dump($dash_data['livestock_group']);
	
			

			$this->load->view('trainee_stat', $dash_data);

		}
			
	}

	public function adhoc_stat($trans=false)
	{
		
		if(empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800) || ($_SESSION['result_gate_user_type'] != '3'))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$_SESSION['result_gate_user_type'] = '';
			$_SESSION['result_gate_user_id'] = '';

			$this->index();
		}
		else
		{
			$SESSION['result_gate_pass_time'] = time();
			$dash_data['trans'] = $trans;


			if(!empty($trans) && is_numeric($trans))
			{
				$table = 'trainee_location';												

			}

			$table = 'adhoc_basic_info';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['adhoc_basic_info_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$table = 'adhoc_basic_info';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'COUNT(gender) as total, gender';
			$groupclause=["gender"];
			$dash_data['gender_group'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike,$groupclause);
			//var_dump($dash_data['gender_group']);
		

			$table = 'adhoc_basic_info';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$fieldval = 'marital_status.item as marital_group, count(adhoc_basic_info.id) as total, adhoc_basic_info.marital_status';
			$groupclause=["adhoc_basic_info.marital_status"];
			$jt_wt_cond = array("marital_status" => "marital_status.id=adhoc_basic_info.marital_status");
			$dash_data['marital_group'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$groupclause);

			$this->load->view('adhoc_stat', $dash_data);

		}
			
	}

	public function profile($trans=1)
	{
		if(empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800) || ($_SESSION['result_gate_user_type'] != '3'))
		{
			$_POST['Username'] = $_POST['password'] = '';
			$_SESSION['result_gate_pass'] = '';
			$_SESSION['result_gate_pass_time'] = '';
			$_SESSION['result_gate_user_type'] = '';
			$_SESSION['result_gate_user_id'] = '';

			$this->index();
		}
		else
		{
			$SESSION['result_gate_pass_time'] = time();
			$dash_data['trans'] = $trans;


			if(!empty($trans) && is_numeric($trans))
			{
				$table = 'trainee_location';												

			}

			
			$table='trainee_location';
			$fieldval =    'trainee_location.id as trid,
							trainee_location.name_of_trainee as ntr,
							trainee_location.center_name_ID as cid, 
							trainee_human_capital.gender as gen, 
							trainee_human_capital.annual_income as an_inc, 
							marital_status.item as marital_st, 
							trainee_human_capital.no_child_male as no_male, 
							trainee_human_capital.no_child_female as no_female, 
							trainee_human_capital.undertaken_capacity_dev as skills_needed, 
							socio_economic_group.item as soc_grp, 
							educational_level.item as edu_lev, 
							technical_training.item as tech_train, 
							capacity_development.item as cap_dev, 
							trainee_location.state as state, 
							trainee_location.lga as lga, 
							trainee_location.village as vill,
							trainee_location.phone as phone, 
							trainee_location.photo as photo, 
							trainee_age.item as age, 
							first_source_livelihood.item as f_income, 
							second_source_livelihood.item as s_income,
							basic_site_info.center_name as center_name';

			$ordercond = ['trainee_location.updated desc'];
	        $jt_wt_cond = array("trainee_human_capital" => "trainee_human_capital.trainee_ID=trainee_location.id", "marital_status" => "marital_status.id=trainee_human_capital.marital_status", 
	        	"trainee_age" => "trainee_age.id=trainee_human_capital.age",
	        	"educational_level" => "educational_level.id=trainee_human_capital.educational_level",
	        	"technical_training" => "technical_training.id=trainee_human_capital.tech_training",
	        	"capacity_development" => "capacity_development.id=trainee_human_capital.capacity_dev_need",
	        	"trainee_social_capital" => "trainee_social_capital.trainee_ID=trainee_location.id",
	        	"trainee_financial_capital" => "trainee_financial_capital.trainee_ID=trainee_location.id",
	        	"first_source_livelihood" => "first_source_livelihood.id=trainee_financial_capital.first_source_livelihood",
	        	"second_source_livelihood" => "second_source_livelihood.id=trainee_financial_capital.second_source_livelihood",
	        	"socio_economic_group" => "socio_economic_group.id=trainee_social_capital.involved_socio_economic_interest_group",
	        	"basic_site_info" => "basic_site_info.id=trainee_location.center_name_ID");

	        $fieldcond = array('trainee_location.id' => $trans); $limitoffsetcond = false;
			$dash_data['trainee_location_data'] = $this->control_engine->master_get_join($table,$jt_wt_cond,$fieldval,$fieldcond,$ordercond,$limitoffsetcond);		
			

			$this->load->view('trainee_profile', $dash_data);
		}
			
	}

	public function post_enroll_trainee($trans=false)
	{
		//var_dump($_POST['data']);
		/*var_dump($_POST);
		var_dump($_FILES);
		var_dump($_POST['traineeID']);*/
		//var_dump($_POST);
			$rrrr = '';
			if(!empty($_POST['logger_save']) )
			{
				if(!empty($_POST['tname']) && !empty($_POST['center_name_ID']) && !empty($_POST['mantra_mfs_100_serial']))
				{
					if($_POST['record_type'] == "trainee_location")
					{
						$center_name_ID = $this->test_input($_POST['center_name_ID']);
						$tname = $this->test_input($_POST['tname']);
						$village = $this->test_input($_POST['village']);
						$lga = $this->test_input($_POST['lga']);
						$phone = $this->test_input($_POST['phone']);
						// $thumbcode = $this->test_input($_POST['thumbcode']);
						// $thumbcode_ANSI = $this->test_input($_POST['thumbcode_ANSI']);						
						$dclerk = $this->test_input($_POST['dclerk']);
						$gps = $this->test_input($_POST['gps']);
						$dtrans = $this->test_input($_POST['dtrans']);
						$nig_states = $this->test_input($_POST['nig_states']);



						$thumbcode_ISO_indexleft = $this->test_input($_POST['thumbcode_ISO_indexleft']);
	                    $thumbcode_ANSI_indexleft = $this->test_input($_POST['thumbcode_ANSI_indexleft']);
	                    $thumbcode_ISO_thumbleft = $this->test_input($_POST['thumbcode_ISO_thumbleft']);
	                    $thumbcode_ANSI_thumbleft = $this->test_input($_POST['thumbcode_ANSI_thumbleft']);
	                    $thumbcode_ISO_indexright = $this->test_input($_POST['thumbcode_ISO_indexright']);
	                    $thumbcode_ANSI_indexright = $this->test_input($_POST['thumbcode_ISO_indexleft']);
	                    $thumbcode_ISO_thumbright = $this->test_input($_POST['thumbcode_ANSI_indexright']);
	                    $thumbcode_ANSI_thumbright = $this->test_input($_POST['thumbcode_ANSI_thumbright']);
	                    $mantra_mfs_100_serial = $this->test_input($_POST['mantra_mfs_100_serial']);

						$table = "trainee_location";
						$dataval = array('center_name_ID' => $center_name_ID,
										 'name_of_trainee' => $tname,
										 'village' => $village,
										 'lga' => $lga,
										 'state' => $nig_states,
										 'phone' => $phone,
										 'gps_location' => $gps,
										 'data_entry_clerk' => $dclerk,
										 'updated' => date('Y-m-d h:i:s', time())
										  );

						

						if(is_numeric($dtrans))
						{
							$table_finger = "trainee_fingerprint_info";
							$dataval_finger = array('site_center_id' => $center_name_ID,
										 'trainee_ID' => $dtrans,
										 'mantra_mfs_100_serial' => $mantra_mfs_100_serial,
										 'thumbcode_ISO_indexleft' => $thumbcode_ISO_indexleft,
				                         'thumbcode_ANSI_indexleft' => $thumbcode_ANSI_indexleft,
				                         'thumbcode_ISO_thumbleft' => $thumbcode_ISO_thumbleft,
				                         'thumbcode_ANSI_thumbleft' => $thumbcode_ANSI_thumbleft,
				                         'thumbcode_ISO_indexright' => $thumbcode_ISO_indexright,
				                         'thumbcode_ANSI_indexright' => $thumbcode_ANSI_indexright,
				                         'thumbcode_ISO_thumbright' => $thumbcode_ISO_thumbright,
				                         'thumbcode_ANSI_thumbright' => $thumbcode_ANSI_thumbright,
										 'updated' => date('Y-m-d h:i:s', time())
										  );
							$fingg = $this->control_engine->master_insert_dup($table_finger,$dataval_finger);

							$fieldcond  = array('id' => $dtrans );
							$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
					    	if($s_data2)
								$rrrr = '2'; //records updated					
						    else
						    	$rrrr = '01'; //records couldnt be saved
						    
						}
						else
						{
							$trainee_id = $this->control_engine->master_insert_dup($table,$dataval);
	        				if(!empty($trainee_id))
	        				{
	        					$table_finger = "trainee_fingerprint_info";
								$dataval_finger = array('site_center_id' => $center_name_ID,
										 'trainee_ID' => $trainee_id,
										 'mantra_mfs_100_serial' => $mantra_mfs_100_serial,
										 'thumbcode_ISO_indexleft' => $thumbcode_ISO_indexleft,
				                         'thumbcode_ANSI_indexleft' => $thumbcode_ANSI_indexleft,
				                         'thumbcode_ISO_thumbleft' => $thumbcode_ISO_thumbleft,
				                         'thumbcode_ANSI_thumbleft' => $thumbcode_ANSI_thumbleft,
				                         'thumbcode_ISO_indexright' => $thumbcode_ISO_indexright,
				                         'thumbcode_ANSI_indexright' => $thumbcode_ANSI_indexright,
				                         'thumbcode_ISO_thumbright' => $thumbcode_ISO_thumbright,
				                         'thumbcode_ANSI_thumbright' => $thumbcode_ANSI_thumbright,
										 'updated' => date('Y-m-d h:i:s', time())
										  );
	        					$fingg = $this->control_engine->master_insert_dup($table_finger,$dataval_finger);

	        					$dataval = array('date_registered' => date('Y-m-d h:i:s', time()),
	        									  'fingerprint_ID' => $fingg
										  );
	        					$fieldcond  = array('id' => $trainee_id );
								$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);

	        					$rrrr = array();
	        					array_push($rrrr, '1');
	        					array_push($rrrr, $trainee_id);
	        				}
	        				else
	        					$rrrr = '01'; //records couldnt be saved
						}

						
						
					}
					else if($_POST['record_type'] == "human_capital")
					{
						$dtrans = $this->test_input($_POST['dtrans']);
						$tr_gender = $this->test_input($_POST['tr_gender']);
		                $tr_age = $this->test_input($_POST['tr_age']);
		                $tr_marital_st = $this->test_input($_POST['tr_marital_st']);
		                $tn_male = $this->test_input($_POST['tn_male']);
		                $tn_female = $this->test_input($_POST['tn_female']);
		                $family_pos = $this->test_input($_POST['family_pos']);
		                $avg_male = $this->test_input($_POST['avg_male']);
		                $avg_female = $this->test_input($_POST['avg_female']);
		                $male_sch = $this->test_input($_POST['male_sch']);
		                $female_sch = $this->test_input($_POST['female_sch']);
		                $out_village = $this->test_input($_POST['out_village']);
		                $out_migrated = $this->test_input($_POST['out_migrated']);
		                $edu_lev = $this->test_input($_POST['edu_lev']);
		                $tech_train = $this->test_input($_POST['tech_train']);
		                $cap_dev = $this->test_input($_POST['cap_dev']);
		                $und_cap = $this->test_input($_POST['und_cap']);
		                $annual_income = $this->test_input($_POST['annual_income']);
		                $starter_pack = $this->test_input($_POST['starter_pack']);
						

						$table = "trainee_human_capital";
						$dataval = array(
										 	'child_female_school' => $female_sch,
											'trainee_ID' => $dtrans,
											'gender' => $tr_gender,
											'age' => $tr_age,
											'marital_status' => $tr_marital_st,
											'position_family' => $family_pos,
											'no_child_male' => $tn_male,
											'no_child_female' => $tn_female,
											'avg_age_child_male' => $avg_male,
											'avg_age_child_female' => $avg_female,
											'child_male_school' => $male_sch,
											'child_female_school' => $female_sch,
											'out_of_village' => $out_village,
											'out_migrated' => $out_migrated,
											'educational_level' => $edu_lev,
											'tech_training' => $tech_train,
											'capacity_dev_need' => $cap_dev,
											'undertaken_capacity_dev' => $und_cap,
											'annual_income' => $annual_income,
											'starter_pack' => $starter_pack,
										 	'updated' => date('Y-m-d h:i:s', time())
										);

						$tr_hc = $this->control_engine->master_insert_dup($table,$dataval);
        				if(!empty($tr_hc))
        					$rrrr = '1';
        				else
        					$rrrr = '01'; //records couldnt be saved					
						
					}
					else if($_POST['record_type'] == "social_capital")
					{
						$dtrans = $this->test_input($_POST['dtrans']);
						$part_soc_eco = $this->test_input($_POST['part_soc_eco']);
		                $inv_soc_eco = $this->test_input($_POST['inv_soc_eco']);
		                $con_ext = $this->test_input($_POST['con_ext']);
						
						$table = "trainee_social_capital";
						$dataval = array(
										 	'trainee_ID' => $dtrans,
											'participation_socio_economic_interest_group' => $part_soc_eco,
											'involved_socio_economic_interest_group' => $inv_soc_eco,
											'connection_with_ext_institution' => $con_ext,
										 	'updated' => date('Y-m-d h:i:s', time())
										);

						$tr_sc = $this->control_engine->master_insert_dup($table,$dataval);
        				if(!empty($tr_sc))
        					$rrrr = '1';
        				else
        					$rrrr = '01'; //records couldnt be saved					
						
					}
					else if($_POST['record_type'] == "natural_capital")
					{
						$dtrans = $this->test_input($_POST['dtrans']);
						$agric_land = $this->test_input($_POST['agric_land']);
		                $land_own = $this->test_input($_POST['land_own']);
		                $main_use = $this->test_input($_POST['main_use']);
		                $energy_source = $this->test_input($_POST['energy_source']);
						
						$table = "trainee_natural_capital";
						$dataval = array(
										 	'trainee_ID' => $dtrans,
											'agric_land_access_for_farming' => $agric_land,
											'ownership_agric_land' => $land_own,
											'mainland_use' => $main_use,
											'sources_of_energy_for_cooking' => $energy_source,
										 	'updated' => date('Y-m-d h:i:s', time())
										);

						$tr_nc = $this->control_engine->master_insert_dup($table,$dataval);
        				if(!empty($tr_nc))
        					$rrrr = '1';
        				else
        					$rrrr = '01'; //records couldnt be saved					
						
					}
					else if($_POST['record_type'] == "physical_capital")
					{
						$dtrans = $this->test_input($_POST['dtrans']);
						//$goods_tools = $this->test_input($_POST['goods_tools']);
						$goods_tools = json_encode($_POST['goods_tools']);

						/*$goods_tools = $_POST['goods_tools'];
						if(is_array($goods_tools))
							$goods_tools = json_encode($_POST['goods_tools']);
						else
							$goods_tools = $this->test_input($goods_tools);*/
						
						$table = "trainee_physical_capital";
						$dataval = array(
										 	'trainee_ID' => $dtrans,
											'goods_tools_owned' => $goods_tools,
										 	'updated' => date('Y-m-d h:i:s', time())
										);

						$tr_pc = $this->control_engine->master_insert_dup($table,$dataval);
        				if(!empty($tr_pc))
        					$rrrr = '1';
        				else
        					$rrrr = '01'; //records couldnt be saved					
						
					}
					else if($_POST['record_type'] == "financial_capital")
					{
						$dtrans = $this->test_input($_POST['dtrans']);						
						$first_source = $this->test_input($_POST["first_source"]);
		                $second_source = $this->test_input($_POST["second_source"]);
		                $trend_income = $this->test_input($_POST["trend_income"]);
		                $off_season = $this->test_input($_POST["off_season"]);
		                $cash_crops = $this->test_input($_POST["cash_crops"]);
		                $monetary = $this->test_input($_POST["monetary"]);
		                $sav_monetary = $this->test_input($_POST["sav_monetary"]);
		                $access_microcredit = $this->test_input($_POST["access_microcredit"]);
		                $no_cattle = $this->test_input($_POST["no_cattle"]);
		                $no_goats = $this->test_input($_POST["no_goats"]);
		                $no_sheep = $this->test_input($_POST["no_sheep"]);
		                $no_poultry = $this->test_input($_POST["no_poultry"]);
		                $male_schfees_spent = $this->test_input($_POST["male_schfees_spent"]);
		                $female_schfees_spent = $this->test_input($_POST["female_schfees_spent"]);
		                $male_amt_spent = $this->test_input($_POST["male_amt_spent"]);
		                $female_amt_spent = $this->test_input($_POST["female_amt_spent"]);
						
						$table = "trainee_financial_capital";
						$dataval = array(
										 	'trainee_ID' => $dtrans,
											'first_source_livelihood' => $first_source,
											'second_source_livelihood' => $second_source,
											'trend_of_income' => $trend_income,
											'practices_off_season' => $off_season,
											'production_cash_crops' => $cash_crops,
											'monetary_remittance' => $monetary,
											'no_livestock_cattle' => $no_cattle,
											'no_livestock_goat' => $no_goats,
											'no_livestock_sheep' => $no_sheep,
											'no_livestock_poultry' => $no_poultry,
											'bank_monetary_savings' => $sav_monetary,
											'access_to_microcredit' => $access_microcredit,
											'average_amount_schoolfees_spend_male' => $male_schfees_spent,
											'average_amount_schoolfees_spend_female' => $female_schfees_spent,
											'average_amount_spend_male' => $male_amt_spent,
											'average_amount_spend_female' => $female_amt_spent,
										 	'updated' => date('Y-m-d h:i:s', time())
										);

						$tr_fc = $this->control_engine->master_insert_dup($table,$dataval);
        				if(!empty($tr_fc))
        					$rrrr = '1';
        				else
        					$rrrr = '01'; //records couldnt be saved					
						
					}
					else
						$rrrr = '-200'; //record holder not known
				}
				else if(!empty($_POST['photoData']))
				{
				    $base64 = $_POST['photoData']['base64'];
				    $traineeID = $_POST['photoData']['id'];
				    $baseFromJavascript = $base64;

				    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseFromJavascript));

				    $target_file = '';
				    $img_center_id = $_SESSION['result_gate_CENTER_ID'];
					$target_dir = "gsi-assets/image_uploads/trainee_center_".$img_center_id."/";
					is_dir($target_dir) OR mkdir($target_dir,0755);
					$target_file = time()."_" . $traineeID.'.jpg';

				    //file_put_contents($filepath,$data);
				    $filepath = $target_dir.$target_file;

					if(file_put_contents($filepath,$data))
					{
						$dataval = array('photo' => $target_file );
				    	$fieldcond = array('id' => $traineeID );
						$s_data2 = $this->control_engine->update_master($dataval,'trainee_location',$fieldcond);
				    	if($s_data2)
				    	{
				    		if(!empty($_POST['postcount']) && ($_POST['postcount'] >= 1))
								$rrrr = 2;
							else
								$rrrr = 3;
						}
					}

					
				}
				else
					$rrrr = '-1'; //important field not entered
				
			}
			else
				$rrrr = '-2';

			echo json_encode($rrrr);


	}

	public function post_enroll_adhoc($trans=false)
	{
		//var_dump($_POST['data']);
		/*var_dump($_POST);
		var_dump($_FILES);
		var_dump($_POST['center_nameID']);*/
			$rrrr = '';
			if(!empty($_POST['logger_save']) )
			{
				if(!empty($_POST['center_name']) && !empty($_POST['nig_states']) && !empty($_POST['village']))
				{
					if($_POST['record_type'] == "basic_site_information")
					{
						$center_name = $this->test_input($_POST['center_name']);
						$date = $this->test_input($_POST['date']);
						$project = $this->test_input($_POST['project']);
						$village = $this->test_input($_POST['village']);
						$lga = $this->test_input($_POST['lga']);
						$dtrans = $this->test_input($_POST['dtrans']);
						$nig_states = $this->test_input($_POST['nig_states']);
						

						$table = "basic_site_info";
						$dataval = array('center_name' => $center_name,
										 'project' => $project,
										 'date' => $date,
										 'community' => $village,
										 'lga' => $lga,
										 'state' => $nig_states,
										 'updated' => date('Y-m-d h:i:s', time())
										  );

						if(is_numeric($dtrans))
						{
							$fieldcond  = array('id' => $dtrans );
							$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
					    	if($s_data2)
								$rrrr = '2'; //records updated					
						    else
						    	$rrrr = '01'; //records couldnt be saved
						    
						}
						else
						{
							$center_name_ID = $this->control_engine->master_insert_dup($table,$dataval);
	        				if(!empty($center_name_ID))
	        				{
	        					$rrrr = array();
	        					array_push($rrrr, '1');
	        					array_push($rrrr, $center_name_ID);
	        				}
	        				else
	        					$rrrr = '01'; //records couldnt be saved
						}

						
						
					}
					else if($_POST['record_type'] == "site_information")
					{
						$dtrans = $this->test_input($_POST['dtrans']);
						$easting= $this->test_input($_POST['easting']);
						$northing= $this->test_input($_POST['northing']);
						$area_size= $this->test_input($_POST['area_size']);
						$altitude= $this->test_input($_POST['altitude']);
						$tenure= $this->test_input($_POST['tenure']);
						$locality_description= $this->test_input($_POST['locality_description']);
						$table = "site_location";
						$dataval = array(
											'center_name_ID' => $dtrans,
											'easting' => $easting,
											'northing' => $northing,
											'area_size' => $area_size,
											'altitude' => $altitude,
											'tenure_value' => $tenure,
											'locality_description' => $locality_description,
										 	'updated' => date('Y-m-d h:i:s', time())
										);
						$sl_hc = $this->control_engine->master_insert_dup($table,$dataval);

						$habitat_description= $this->test_input($_POST['habitat_description']);
						$regional_ecosystem= $this->test_input($_POST['regional_ecosystem']);
						$broad_vegetation_group= $this->test_input($_POST['broad_vegetation_group']);
						$table = "site_vegetation_landcover";
						$dataval = array(
											'center_name_ID' => $dtrans,
											'habitat_description' => $habitat_description,
											'regional_ecosystem' => $regional_ecosystem,
											'broad_vegetation_group' => $broad_vegetation_group,
										 	'updated' => date('Y-m-d h:i:s', time())
										);
						$sv_hc = $this->control_engine->master_insert_dup($table,$dataval);

						$slope_position= $this->test_input($_POST['slope_position']);
						$slope_degree= $this->test_input($_POST['slope_degree']);
						$slope_aspect= $this->test_input($_POST['slope_aspect']);
						$table = "site_terrain_attributes";
						$dataval = array(
											'center_name_ID' => $dtrans,
											'slope_position' => $slope_position,
											'slope_aspect' => $slope_aspect,
										 	'updated' => date('Y-m-d h:i:s', time())
										);
						$st_hc = $this->control_engine->master_insert_dup($table,$dataval);

						$type= $this->test_input($_POST['type']);
						$depth= $this->test_input($_POST['depth']);
						$colour= $this->test_input($_POST['colour']);
						$texture= $this->test_input($_POST['texture']);
						$soil_notes= $this->test_input($_POST['soil_notes']);
						$table = "site_soil";
						$dataval = array(
											'center_name_ID' => $dtrans,
											'type' => $type,
											'depth' => $depth,
											'colour' => $colour,
											'texture' => $texture,
											'soil_notes' => $soil_notes,
										 	'updated' => date('Y-m-d h:i:s', time())
										);
						$ss_hc = $this->control_engine->master_insert_dup($table,$dataval);

						$sources= $this->test_input($_POST['sources']);
						$map_cut= $this->test_input($_POST['map_cut']);
						$geology_unit= $this->test_input($_POST['geology_unit']);
						$table = "site_geology";
						$dataval = array(
											'center_name_ID' => $dtrans,
											'sources' => $sources,
											'map_cutting_outcrops' => $map_cut,
											'geology_unit' => $geology_unit,
										 	'updated' => date('Y-m-d h:i:s', time())
										);
						$sg_hc = $this->control_engine->master_insert_dup($table,$dataval);

						$river= $this->test_input($_POST['river']);
						$stream= $this->test_input($_POST['stream']);
						$lake= $this->test_input($_POST['lake']);
						$others= $this->test_input($_POST['others']);
						$table = "site_drainage";
						$dataval = array(
											'center_name_ID' => $dtrans,
											'river' => $river,
											'stream' => $stream,
											'lake' => $lake,
											'others' => $others,
										 	'updated' => date('Y-m-d h:i:s', time())
										);
						$sd_hc = $this->control_engine->master_insert_dup($table,$dataval);

						$soil_erosion= $this->test_input($_POST['soil_erosion']);
						$silt= $this->test_input($_POST['silt']);
						$sand= $this->test_input($_POST['sand']);
						$sedimentation= $this->test_input($_POST['sedimentation']);
						$evidence_of_runoff= $this->test_input($_POST['evidence_of_runoff']);
						$gullies= $this->test_input($_POST['gullies']);
						$rills= $this->test_input($_POST['rills']);
						$channel= $this->test_input($_POST['channel']);
						$table = "site_land_disturbance_types";
						$dataval = array(
											'center_name_ID' => $dtrans,
											'soil_erosion' => $soil_erosion,
											'silt' => $silt,
											'sand' => $sand,
											'sedimentation' => $sedimentation,
											'evidence_of_runoff' => $evidence_of_runoff,
											'gullies' => $gullies,
											'rills' => $rills,
											'channel' => $channel,
										 	'updated' => date('Y-m-d h:i:s', time())
										);
						$sld_hc = $this->control_engine->master_insert_dup($table,$dataval);
						

						$artifacts= $this->test_input($_POST['artifacts']);
						$ecofacts= $this->test_input($_POST['ecofacts']);
						$historical_monument= $this->test_input($_POST['historical_monument']);
						$table = "site_archaeological_attributes";
						$dataval = array(
											'center_name_ID' => $dtrans,
											'artifacts' => $artifacts,
											'ecofacts' => $ecofacts,
											'historical_monument' => $historical_monument,
										 	'updated' => date('Y-m-d h:i:s', time())
										);
						$saa_hc = $this->control_engine->master_insert_dup($table,$dataval);
						

						//if(!empty($tr_hc))
        				if(!empty($sl_hc) && !empty($sv_hc) && !empty($st_hc) && !empty($ss_hc) && !empty($sg_hc) && !empty($sd_hc) && !empty($sld_hc) && !empty($saa_hc))
        					$rrrr = '1';
        				else
        					$rrrr = '01'; //records couldnt be saved					
						
					}
					else if($_POST['record_type'] == "site_suitability_assessment")
					{
						$dtrans = $this->test_input($_POST['dtrans']);

		                $order_s= $this->test_input($_POST['order_s']);
						$order_n= $this->test_input($_POST['order_n']);
						$table = "site_suitability_orders";
						$dataval = array(
										 	'center_name_ID' => $dtrans,
											'order_s' => $order_s,
											'order_n' => $order_n,
										 	'updated' => date('Y-m-d h:i:s', time())
										);
						$so_sa = $this->control_engine->master_insert_dup($table,$dataval);

						$highly_suitable= $this->test_input($_POST['highly_suitable']);
						$moderately_suitable= $this->test_input($_POST['moderately_suitable']);
						$marginally_suitable= $this->test_input($_POST['marginally_suitable']);
						$table = "site_suitability_classes_order_s";
						$dataval = array(

										 	'center_name_ID' => $dtrans,
											'class_s1' => $highly_suitable,
											'class_s2' => $moderately_suitable,
											'class_s3' => $marginally_suitable,
										 	'updated' => date('Y-m-d h:i:s', time())
										);
						$scs_sa = $this->control_engine->master_insert_dup($table,$dataval);

						$curr_not_suitable= $this->test_input($_POST['curr_not_suitable']);
						$perm_not_suitable= $this->test_input($_POST['perm_not_suitable']);
						$table = "site_suitability_classes_order_n";
						$dataval = array(
										 	'center_name_ID' => $dtrans,
											'class_n1' => $curr_not_suitable,
											'class_n2' => $perm_not_suitable,
										 	'updated' => date('Y-m-d h:i:s', time())
										);
						$scn_sa = $this->control_engine->master_insert_dup($table,$dataval);

						$comment= $this->test_input($_POST['comment']);
						$table = "site_general_observation_comment";
						$dataval = array(
										 	'center_name_ID' => $dtrans,
											'gen_comment' => $comment,
										 	'updated' => date('Y-m-d h:i:s', time())
										);
						$scom_sa = $this->control_engine->master_insert_dup($table,$dataval);
						
						//$so_sa = /*$scs_sa = $scn_sa = $scom_sa =*/ 1;

						
        				//if(!empty($so_sa) && !empty($scs_sa) && !empty($scn_sa) && !empty($scom_sa))
        				if(!empty($scs_sa) && !empty($scn_sa) && !empty($scom_sa))
        					$rrrr = '1';
        				else
        					$rrrr = '01'; //records couldnt be saved

        					//$rrrr .= $so_sa;					
						
					}
					else if($_POST['record_type'] == "staff_information")
					{
						$center_name = $this->test_input($_POST['center_name']);
						$surname = $this->test_input($_POST['village']);
						$firstname = $this->test_input($_POST['firstname']);
						$phone = $this->test_input($_POST['phone']);
						$email = $this->test_input($_POST['email']);
						$lastname = $this->test_input($_POST['lastname']);
						$lga = $this->test_input($_POST['lga']);
						$dtrans = $this->test_input($_POST['dtrans']);
						$nig_states = $this->test_input($_POST['nig_states']);
						

						$table = "staff_info";
						$dataval = array('center_name_ID' => $center_name,
										 'surname' => $surname,
										 'firstname' => $firstname,
										 'lastname' => $lastname,
										 'email' => $email,
										 'phone' => $phone,
										 'lga' => $lga,
										 'state' => $nig_states,
										 'updated' => date('Y-m-d h:i:s', time())
										  );

						$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
						$fieldcond = array('email' => $email );
						$staff_info_maindata = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
						if(!empty($staff_info_maindata[0]['id']))
						{
							$rrrr = '019'; //user exists
						}
						else
						{
							if(is_numeric($dtrans))
							{
								$fieldcond  = array('id' => $dtrans );
								$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
						    	if($s_data2)
									$rrrr = '2'; //records updated					
							    else
							    	$rrrr = '01'; //records couldnt be saved

							    $table_users = "users";
							    $fieldcond = array('user_type' => 3,
							    				   'user_id' => $dtrans );

								$dataval_users = array(
												 'username' => $email,
												 'updated' => date('Y-m-d h:i:s', time())
												  );
								$s_data_user = $this->control_engine->update_master($dataval_users,$table_users,$fieldcond);
							    
							}
							else
							{
								$staff_ID = $this->control_engine->master_insert_dup($table,$dataval);
		        				if(!empty($staff_ID))
		        				{
		        					$passcode = BaseIntEncoder::encode(time()*100);
		        					$dataval = array('passcode' => $passcode);
		        					$fieldcond  = array('id' => $staff_ID );
									$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);

		        					$rrrr = array();
		        					array_push($rrrr, '1');
		        					array_push($rrrr, $staff_ID);

		        					$table_users = "users";
									$dataval_users = array('user_type' => 3,
													 'username' => $email,
													 'password' => md5($passcode),
													 'user_id' => $staff_ID,
													 'updated' => date('Y-m-d h:i:s', time())
													  );
									$s_data_user = $this->control_engine->master_insert_dup($table_users,$dataval_users);
		        				}
		        				else
		        					$rrrr = '01'; //records couldnt be saved
							}

						}

						

						
						
					}
					else if($_POST['record_type'] == "basic_adhoc_staff_information")
					{
						$center_name = $this->test_input($_POST['center_name']);						
						$lga = $this->test_input($_POST['lga']);
						$dtrans = $this->test_input($_POST['dtrans']);
						$nig_states = $this->test_input($_POST['nig_states']);
						$street = $this->test_input($_POST['village']);

						$surname = $this->test_input($_POST['surname']);
                        $firstname = $this->test_input($_POST['firstname']);
                        $phone = $this->test_input($_POST['phone']);
                        $email = $this->test_input($_POST['email']);
                        $lastname = $this->test_input($_POST['lastname']);
                        $gender = $this->test_input($_POST['gender']);
                        $marital_status = $this->test_input($_POST['marital_status']);
                        $dob = $this->test_input($_POST['dob']);
                        $birth_place = $this->test_input($_POST['birth_place']);                      
                        $city = $this->test_input($_POST['city']);
                        $role = $this->test_input($_POST['role']);
						

						$table = "adhoc_basic_info";
						$dataval = array('site_center_id' => $center_name,
										 'surname' => $surname,
										 'firstname' => $firstname,
										 'lastname' => $lastname,
										 'email' => $email,
										 'phone' => $phone,
										 'lga' => $lga,
										 'state' => $nig_states,
										 'street' => $street,
										 'role' => $role,
										 'gender' => $gender,
										 'marital_status' => $marital_status,
										 'dob' => $dob,
										 'birth_place' => $birth_place,
										 'city' => $city,
										 'updated' => date('Y-m-d h:i:s', time())
										  );

						if(is_numeric($dtrans))
						{
							$fieldcond  = array('id' => $dtrans );
							$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
					    	if($s_data2)
								$rrrr = '2'; //records updated					
						    else
						    	$rrrr = '01'; //records couldnt be saved
						    
						}
						else
						{
							$staff_ID = $this->control_engine->master_insert_dup($table,$dataval);
	        				if(!empty($staff_ID))
	        				{
	        					$passcode = BaseIntEncoder::encode(time()*100);
	        					$dataval = array('passcode' => $passcode);
	        					$fieldcond  = array('id' => $staff_ID );
								$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);

	        					$rrrr = array();
	        					array_push($rrrr, '1');
	        					array_push($rrrr, $staff_ID);
	        				}
	        				else
	        					$rrrr = '01'; //records couldnt be saved
						}

						
						
					}
					else if($_POST['record_type'] == "adhoc_staff_family")
					{
						$center_name = $this->test_input($_POST['center_name']);						
						$lga = $this->test_input($_POST['village']);
						$dtrans = $this->test_input($_POST['dtrans']);
						$nig_states = $this->test_input($_POST['nig_states']);

						$spouse_state = $this->test_input($_POST['spouse_state']);
		                $spouse_name = $this->test_input($_POST['spouse_name']);
		                $father_state = $this->test_input($_POST['father_state']);
		                $father_name = $this->test_input($_POST['father_name']);
		                $mother_name = $this->test_input($_POST['mother_name']);
		                $mother_state = $this->test_input($_POST['mother_state']);
						

						$table = "adhoc_basic_info";
						$dataval = array('spouse_state' => $spouse_state,
										 'spouse_name' => $spouse_name,
										 'father_name' => $father_name,
										 'father_state' => $father_state,
										 'mother_state' => $mother_state,
										 'mother_name' => $mother_name,
										 'updated' => date('Y-m-d h:i:s', time())
										  );

						if(is_numeric($dtrans))
						{
							$fieldcond  = array('id' => $dtrans );
							$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
					    	if($s_data2)
								$rrrr = '2'; //records updated					
						    else
						    	$rrrr = '01'; //records couldnt be saved
						    
						}
						else
						{
	        				$rrrr = '01'; //records couldnt be saved
						}						
						
					}
					else if($_POST['record_type'] == "adhoc_staff_education")
					{
						$center_name = $this->test_input($_POST['center_name']);						
						$lga = $this->test_input($_POST['village']);
						$dtrans = $this->test_input($_POST['dtrans']);
						$nig_states = $this->test_input($_POST['nig_states']);

						$pry_name1 = $this->test_input($_POST['pry_name1']); 
		                $sec_name1 = $this->test_input($_POST['sec_name1']); 
		                $tert_name1 = $this->test_input($_POST['tert_name1']);
		                $pry_name2 = $this->test_input($_POST['pry_name2']); 
		                $sec_name2 = $this->test_input($_POST['sec_name2']); 
		                $tert_name2 = $this->test_input($_POST['tert_name2']);
		                $pry_name3 = $this->test_input($_POST['pry_name3']); 
		                $sec_name3 = $this->test_input($_POST['sec_name3']); 
		                $tert_name3 = $this->test_input($_POST['tert_name3']);

		                $pry_start_yr1 = $this->test_input($_POST['pry_start_yr1']); 
		                $sec_start_yr1 = $this->test_input($_POST['sec_start_yr1']); 
		                $tert_start_yr1 = $this->test_input($_POST['tert_start_yr1']);
		                $pry_start_yr2 = $this->test_input($_POST['pry_start_yr2']); 
		                $sec_start_yr2 = $this->test_input($_POST['sec_start_yr2']); 
		                $tert_start_yr2 = $this->test_input($_POST['tert_start_yr2']);
		                $pry_start_yr3 = $this->test_input($_POST['pry_start_yr3']); 
		                $sec_start_yr3 = $this->test_input($_POST['sec_start_yr3']); 
		                $tert_start_yr3 = $this->test_input($_POST['tert_start_yr3']);

		                $pry_end_yr1 = $this->test_input($_POST['pry_end_yr1']); 
		                $sec_end_yr1 = $this->test_input($_POST['sec_end_yr1']); 
		                $tert_end_yr1 = $this->test_input($_POST['tert_end_yr1']);
		                $pry_end_yr2 = $this->test_input($_POST['pry_end_yr2']); 
		                $sec_end_yr2 = $this->test_input($_POST['sec_end_yr2']); 
		                $tert_end_yr2 = $this->test_input($_POST['tert_end_yr2']);
		                $pry_end_yr3 = $this->test_input($_POST['pry_end_yr3']); 
		                $sec_end_yr3 = $this->test_input($_POST['sec_end_yr3']); 
		                $tert_end_yr3 = $this->test_input($_POST['tert_end_yr3']);

		                $pry_cert_obt1 = $this->test_input($_POST['pry_cert_obt1']); 
		                $sec_cert_obt1 = $this->test_input($_POST['sec_cert_obt1']); 
		                $tert_cert_obt1 = $this->test_input($_POST['tert_cert_obt1']);
		                $pry_cert_obt2 = $this->test_input($_POST['pry_cert_obt2']); 
		                $sec_cert_obt2 = $this->test_input($_POST['sec_cert_obt2']); 
		                $tert_cert_obt2 = $this->test_input($_POST['tert_cert_obt2']);
		                $pry_cert_obt3 = $this->test_input($_POST['pry_cert_obt3']); 
		                $sec_cert_obt3 = $this->test_input($_POST['sec_cert_obt3']); 
		                $tert_cert_obt3 = $this->test_input($_POST['tert_cert_obt3']);

		                $pry_cert_num1 = $this->test_input($_POST['pry_cert_num1']); 
		                $sec_cert_num1 = $this->test_input($_POST['sec_cert_num1']); 
		                $tert_cert_num1 = $this->test_input($_POST['tert_cert_num1']);
		                $pry_cert_num2 = $this->test_input($_POST['pry_cert_num2']); 
		                $sec_cert_num2 = $this->test_input($_POST['sec_cert_num2']); 
		                $tert_cert_num2 = $this->test_input($_POST['tert_cert_num2']);
		                $pry_cert_num3 = $this->test_input($_POST['pry_cert_num3']); 
		                $sec_cert_num3 = $this->test_input($_POST['sec_cert_num3']); 
		                $tert_cert_num3 = $this->test_input($_POST['tert_cert_num3']);

		                $nysc_period = $this->test_input($_POST['nysc_period']);
		                $nysc_service_place = $this->test_input($_POST['nysc_service_place']);
		                $nysc_discharge_date = $this->test_input($_POST['nysc_discharge_date']);
		                $nysc_certifcate_num = $this->test_input($_POST['nysc_certifcate_num']);
						

						$table = "adhoc_basic_info";
						$dataval = array('nysc_period' => $nysc_period,
										 'nysc_service_place' => $nysc_service_place,
										 'nysc_discharge_date' => $nysc_discharge_date,
										 'nysc_certifcate_num' => $nysc_certifcate_num,
										 'updated' => date('Y-m-d h:i:s', time())
										  );

						if(is_numeric($dtrans))
						{
							$fieldcond  = array('id' => $dtrans );
							$s_data2 = $this->control_engine->update_master($dataval,$table,$fieldcond);
					    	if($s_data2)
								$rrrr = '2'; //records updated					
						    else
						    	$rrrr = '01'; //records couldnt be saved

						    
						    $table_e = "adhoc_education";

						    //PRIMARY
	                        $dataval_e = array(
	                        				'site_center_id' => $center_name,
											'edu_type' => 'p1',
											'edu_from' => $pry_start_yr1, 
					                        'edu_to' => $pry_end_yr1, 
					                        'edu_cert_obtained' => $pry_cert_obt1,
					                        'name' => $pry_name1, 
					                        'edu_cert_number' => $pry_cert_num1,
					                        'adhoc_ID' => $dtrans,
										 	'updated' => date('Y-m-d h:i:s', time())
										  );
	                        $edu_ID = $this->control_engine->master_insert_dup($table_e,$dataval_e);

	                        $dataval_e = array(
	                        				'site_center_id' => $center_name,
											'edu_type' => 'p2',
											'edu_from' => $pry_start_yr2, 
					                        'edu_to' => $pry_end_yr2, 
					                        'edu_cert_obtained' => $pry_cert_obt2,
					                        'name' => $pry_name2, 
					                        'edu_cert_number' => $pry_cert_num2,
					                        'adhoc_ID' => $dtrans,
										 	'updated' => date('Y-m-d h:i:s', time())
										  );
	                        $edu_ID = $this->control_engine->master_insert_dup($table_e,$dataval_e);

	                        $dataval_e = array(
	                        				'site_center_id' => $center_name,
											'edu_type' => 'p3',
											'edu_from' => $pry_start_yr3, 
					                        'edu_to' => $pry_end_yr3, 
					                        'edu_cert_obtained' => $pry_cert_obt3,
					                        'name' => $pry_name3, 
					                        'edu_cert_number' => $pry_cert_num3,
					                        'adhoc_ID' => $dtrans,
										 	'updated' => date('Y-m-d h:i:s', time())
										  );
	                        $edu_ID = $this->control_engine->master_insert_dup($table_e,$dataval_e);


	                        //SECONDARY
	                        $dataval_e = array(
	                        				'site_center_id' => $center_name,
											'edu_type' => 's1',
											'edu_from' => $sec_start_yr1, 
					                        'edu_to' => $sec_end_yr1, 
					                        'edu_cert_obtained' => $sec_cert_obt1,
					                        'name' => $sec_name1, 
					                        'edu_cert_number' => $sec_cert_num1,
					                        'adhoc_ID' => $dtrans,
										 	'updated' => date('Y-m-d h:i:s', time())
										  );
	                        $edu_ID = $this->control_engine->master_insert_dup($table_e,$dataval_e);

	                        $dataval_e = array(
	                        				'site_center_id' => $center_name,
											'edu_type' => 's2',
											'edu_from' => $sec_start_yr2, 
					                        'edu_to' => $sec_end_yr2, 
					                        'edu_cert_obtained' => $sec_cert_obt2,
					                        'name' => $sec_name2, 
					                        'edu_cert_number' => $sec_cert_num2,
					                        'adhoc_ID' => $dtrans,
										 	'updated' => date('Y-m-d h:i:s', time())
										  );
	                        $edu_ID = $this->control_engine->master_insert_dup($table_e,$dataval_e);

	                        $dataval_e = array(
	                        				'site_center_id' => $center_name,
											'edu_type' => 's3',
											'edu_from' => $sec_start_yr3, 
					                        'edu_to' => $sec_end_yr3, 
					                        'edu_cert_obtained' => $sec_cert_obt3,
					                        'name' => $sec_name3, 
					                        'edu_cert_number' => $sec_cert_num3,
					                        'adhoc_ID' => $dtrans,
										 	'updated' => date('Y-m-d h:i:s', time())
										  );
	                        $edu_ID = $this->control_engine->master_insert_dup($table_e,$dataval_e);


	                        //TERTIARY
	                        $dataval_e = array(
	                        				'site_center_id' => $center_name,
											'edu_type' => 't1',
											'edu_from' => $tert_start_yr1, 
					                        'edu_to' => $tert_end_yr1, 
					                        'edu_cert_obtained' => $tert_cert_obt1,
					                        'name' => $tert_name1, 
					                        'edu_cert_number' => $tert_cert_num1,
					                        'adhoc_ID' => $dtrans,
										 	'updated' => date('Y-m-d h:i:s', time())
										  );
	                        $edu_ID = $this->control_engine->master_insert_dup($table_e,$dataval_e);

	                        $dataval_e = array(
	                        				'site_center_id' => $center_name,
											'edu_type' => 't2',
											'edu_from' => $tert_start_yr2, 
					                        'edu_to' => $tert_end_yr2, 
					                        'edu_cert_obtained' => $tert_cert_obt2,
					                        'name' => $tert_name2, 
					                        'edu_cert_number' => $tert_cert_num2,
					                        'adhoc_ID' => $dtrans,
										 	'updated' => date('Y-m-d h:i:s', time())
										  );
	                        $edu_ID = $this->control_engine->master_insert_dup($table_e,$dataval_e);

	                        $dataval_e = array(
	                        				'site_center_id' => $center_name,
											'edu_type' => 't3',
											'edu_from' => $tert_start_yr3, 
					                        'edu_to' => $tert_end_yr3, 
					                        'edu_cert_obtained' => $tert_cert_obt3,
					                        'name' => $tert_name3, 
					                        'edu_cert_number' => $tert_cert_num3,
					                        'adhoc_ID' => $dtrans,
										 	'updated' => date('Y-m-d h:i:s', time())
										  );
	                        $edu_ID = $this->control_engine->master_insert_dup($table_e,$dataval_e);



						    
						}
						else
						{
	        				$rrrr = '01'; //records couldnt be saved
						}						
						
					}
					else if($_POST['record_type'] == "adhoc_staff_profcert")
					{
						$center_name = $this->test_input($_POST['center_name']);						
						$lga = $this->test_input($_POST['village']);
						$dtrans = $this->test_input($_POST['dtrans']);
						$nig_states = $this->test_input($_POST['nig_states']);

						$profcert_name1 = $this->test_input($_POST['profcert_name1']);
						$profcert_start_yr1 = $this->test_input($_POST['profcert_start_yr1']);
						$profcert_end_yr1 = $this->test_input($_POST['profcert_end_yr1']);
						$profcert_cert_obt1 = $this->test_input($_POST['profcert_cert_obt1']);
						$profcert_cert_num1 = $this->test_input($_POST['profcert_cert_num1']);

						$profcert_name2 = $this->test_input($_POST['profcert_name2']);
						$profcert_start_yr2 = $this->test_input($_POST['profcert_start_yr2']);
						$profcert_end_yr2 = $this->test_input($_POST['profcert_end_yr2']);
						$profcert_cert_obt2 = $this->test_input($_POST['profcert_cert_obt2']);
						$profcert_cert_num2 = $this->test_input($_POST['profcert_cert_num2']);

						$profcert_name3 = $this->test_input($_POST['profcert_name3']);
						$profcert_start_yr3 = $this->test_input($_POST['profcert_start_yr3']);
						$profcert_end_yr3 = $this->test_input($_POST['profcert_end_yr3']);
						$profcert_cert_obt3 = $this->test_input($_POST['profcert_cert_obt3']);
						$profcert_cert_num3 = $this->test_input($_POST['profcert_cert_num3']);

						if(is_numeric($dtrans))
						{
												    
						    $table_e = "adhoc_education";

						    //PRIMARY
	                        $dataval_e = array(
											'edu_type' => 'prof1',
											'edu_from' => $profcert_start_yr1, 
					                        'edu_to' => $profcert_end_yr1, 
					                        'edu_cert_obtained' => $profcert_cert_obt1,
					                        'name' => $profcert_name1, 
					                        'edu_cert_number' => $profcert_cert_num1,
					                        'adhoc_ID' => $dtrans,
										 	'updated' => date('Y-m-d h:i:s', time())
										  );
	                        $edu_ID = $this->control_engine->master_insert_dup($table_e,$dataval_e);

	                        $dataval_e = array(
											'edu_type' => 'prof2',
											'edu_from' => $profcert_start_yr2, 
					                        'edu_to' => $profcert_end_yr2, 
					                        'edu_cert_obtained' => $profcert_cert_obt2,
					                        'name' => $profcert_name2, 
					                        'edu_cert_number' => $profcert_cert_num2,
					                        'adhoc_ID' => $dtrans,
										 	'updated' => date('Y-m-d h:i:s', time())
										  );
	                        $edu_ID = $this->control_engine->master_insert_dup($table_e,$dataval_e);

	                        $dataval_e = array(
											'edu_type' => 'prof3',
											'edu_from' => $profcert_start_yr3, 
					                        'edu_to' => $profcert_end_yr3, 
					                        'edu_cert_obtained' => $profcert_cert_obt3,
					                        'name' => $profcert_name3, 
					                        'edu_cert_number' => $profcert_cert_num3,
					                        'adhoc_ID' => $dtrans,
										 	'updated' => date('Y-m-d h:i:s', time())
										  );
	                        $edu_ID = $this->control_engine->master_insert_dup($table_e,$dataval_e);

	                        if(!empty($edu_ID))
	                        {
	                        	$rrrr = array();
	        					array_push($rrrr, '1');
	        					//array_push($rrrr, $edu_ID);				
	                        }
						    else
						    	$rrrr = '01'; //records couldnt be saved
						    
						}
						else
						{
	        				$rrrr = '01'; //records couldnt be saved
						}						
						
					}
					else
						$rrrr = '-200'; //record holder not known
				}
				else if(!empty($_POST['photoData']))
				{
				    $base64 = $_POST['photoData']['base64'];
				    $traineeID = $_POST['photoData']['id'];
				    $baseFromJavascript = $base64;

				    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseFromJavascript));

				    $target_file = '';
					$target_dir = "gsi-assets/image_uploads/adhoc_staff/";
					is_dir($target_dir) OR mkdir($target_dir,0755);
					$target_file = time()."_" . $traineeID.'.jpg';

				    //file_put_contents($filepath,$data);
				    $filepath = $target_dir.$target_file;

					if(file_put_contents($filepath,$data))
					{
						$dataval = array('photo' => $target_file );
				    	$fieldcond = array('id' => $traineeID );
						$s_data2 = $this->control_engine->update_master($dataval,'adhoc_basic_info',$fieldcond);
				    	if($s_data2)
				    	{
				    		if(!empty($_POST['postcount']) && ($_POST['postcount'] >= 1))
								$rrrr = 2;
							else
								$rrrr = 3;
						}
					}

					
				}
				else
					$rrrr = '-1'; //important field not entered
				
			}
			else
				$rrrr = '-2';

			echo json_encode($rrrr);


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
			$fieldval = false; //"id,user_username,password";
			//$fieldcond = array('user_type' => 1 );
			$fieldcond = array('username' => $ttv2, 'password' => md5($ttv) );
			$tll = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			
			if(!empty($tll) && is_array($tll))
			{
				foreach ($tll as $key => $value) 
				{
					$_SESSION['result_gate_pass'] = $value['id'];
					$_SESSION['result_gate_user_type'] = $value['user_type'];
					$_SESSION['result_gate_user_id'] = $value['user_id'];
					$_SESSION['result_gate_pass_time'] = time();
					$ff = true;
				}
			}
			if(!$ff)
			{
				//$dashboard_data['ntf'] = 'gg';
				$dashboard_data['ntf'] = '<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button> <span class="vd_alert-icon"><i class="fa fa-exclamation-circle vd_red"></i></span> Invalid Login Parameter </div>';
			}
		}

		/*if(($ff)&&(!empty($reffer)))
		{
			redirect('/'.$reffer);
		}
		else if($ff)
			$this->entry_gate(); */
		if($ff && ($_SESSION['result_gate_user_type'] == 2))
			redirect('Admin/entry_gate');
		else if($ff && ($_SESSION['result_gate_user_type'] == 3))
			$this->entry_gate(); 
		else
			$this->load->view('login',$dashboard_data);
	}

	public function logout()
	{
		session_unset();
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