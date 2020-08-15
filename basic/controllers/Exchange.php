<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Exchange extends CI_Controller {

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

	public function initiator()
	{
		$poster_container = array();

		$export_tables = ['users', 'server_url', 'basic_site_info', 'site_archaeological_attributes', 'site_drainage', 'site_general_observation_comment', 'site_geology', 'site_land_disturbance_types', 'site_location', 'site_soil', 'site_suitability_classes_order_n', 'site_suitability_classes_order_s', 'site_suitability_orders', 'site_terrain_attributes', 'site_vegetation_landcover', 'nigerian_states_capital', 'trainee_age', 'marital_status', 'out_of_village_seasonal', 'out_migrated', 'educational_level', 'technical_training', 'capacity_development', 'starter_pack', 'socio_economic_group', 'external_institutions', 'agricultural_land', 'land_ownership', 'main_land_use', 'goods_tools_owned', 'first_source_livelihood', 'second_source_livelihood', 'trend_of_income', 'micro_credit', 'energy_sources', 'staff_info'];
		foreach ($export_tables as $key => $tabval) 
		{
			$table = $tabval;
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$export_data_sync = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($export_data_sync))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($export_data_sync));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}
		}
		
		/*$table = 'users';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$users_data_sync = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($users_data_sync))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($users_data_sync));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'server_url';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$users_data_sync = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($users_data_sync))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($users_data_sync));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}*/

		

		/*$table = 'nigerian_states_capital';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$nig_states = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($nig_states))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($nig_states));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}


			$table = 'trainee_age';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$trainee_age_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($trainee_age_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($trainee_age_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'marital_status';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$marital_status_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($marital_status_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($marital_status_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'out_of_village_seasonal';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$out_of_village_seasonal_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($out_of_village_seasonal_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($out_of_village_seasonal_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'out_migrated';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$out_migrated_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($out_migrated_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($out_migrated_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'educational_level';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$educational_level_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($educational_level_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($educational_level_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'technical_training';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$technical_training_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($technical_training_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($technical_training_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'capacity_development';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$capacity_development_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($capacity_development_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($capacity_development_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'starter_pack';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$starter_pack_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($starter_pack_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($starter_pack_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'socio_economic_group';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$socio_economic_group_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($socio_economic_group_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($socio_economic_group_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'external_institutions';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$external_institutions_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($external_institutions_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($external_institutions_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'agricultural_land';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$agricultural_land_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($agricultural_land_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($agricultural_land_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'land_ownership';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$land_ownership_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($land_ownership_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($land_ownership_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'main_land_use';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$main_land_use_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($main_land_use_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($main_land_use_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'goods_tools_owned';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$goods_tools_owned_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($goods_tools_owned_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($goods_tools_owned_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'first_source_livelihood';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$first_source_livelihood_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($first_source_livelihood_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($first_source_livelihood_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'second_source_livelihood';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$second_source_livelihood_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($second_source_livelihood_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($second_source_livelihood_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'trend_of_income';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$trend_of_income_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($trend_of_income_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($trend_of_income_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'micro_credit';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$micro_credit_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($micro_credit_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($micro_credit_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}

			$table = 'energy_sources';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$energy_sources_data = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);
			if(!empty($energy_sources_data))
			{
				$poster = array();
				$poster['rrrdata'] = base64_encode(json_encode($energy_sources_data));
				$poster['rrrtable'] = $table;
				array_push($poster_container, $poster);
			}
		*/


		echo base64_encode(json_encode($poster_container));

		
			

	}

	public function embrace()
	{
		$rrrr = array();
		if(!empty($_POST['datatopost']))
		{
			$datatopost = $this->test_input($_POST['datatopost']);
			if(!empty($datatopost))
			{
				$vpc = json_decode(base64_decode($datatopost));
				
				foreach ($vpc as $key => $vpc_value) 
                {
                    $rrrdata = json_decode(base64_decode($vpc_value->rrrdata));
                    $rrrtable = $vpc_value->rrrtable;
                    /*if($rrrtable == 'users')
                    	$rrrtable = 'users2';*/

                    foreach ($rrrdata as $key => $dataval) 
					{
						$newdataval = array();
						$recid_tonote = '';
						foreach ($dataval as $key => $val) 
						{
							if($key == 'id')
							{
								$recid_tonote = $val;
								if($rrrtable == 'server_url')
								$newdataval[$key] = $val;	
							}
							else
								$newdataval[$key] = $val;
						}

						$rec_id = $this->control_engine->master_insert_dup($rrrtable,$newdataval);
						
    					
						if(!empty($rec_id))
						{
							$error_log = array();
							$error_log['recid_tonote'] = $recid_tonote;
							$error_log['rec_table'] = $rrrtable;
							$error_log['recid_concern'] = $rec_id;
	    					array_push($rrrr, $error_log);
						}
						

					}

                    
                }

			}

		}

		//echo json_encode($rrrr);
			
	}

	

	public function adhoc_list($trans=false)
	{
		if(empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800) || ($_SESSION['result_gate_user_type'] != 2))
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
			

			$this->load->view('super_admin/adhoc_list', $dash_data);
		}
			
	}

	public function staff_list($trans=false)
	{
		if(empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800) || ($_SESSION['result_gate_user_type'] != 2))
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

			
			$table = 'staff_info';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['staff_info_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);

			$table = 'basic_site_info';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['basic_site_info_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);		
			

			$this->load->view('super_admin/staff_list', $dash_data);
		}
			
	}

	public function center_list($trans=false)
	{
		if(empty($_SESSION['result_gate_pass']) || empty($_SESSION['result_gate_pass_time'])  || ((time() - $_SESSION['result_gate_pass_time']) > 1800) || ($_SESSION['result_gate_user_type'] != 2))
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

			
			$table = 'basic_site_info';
			$fieldcond = $ordercond = $limitoffsetcond = $matchvallike = $fieldval = false;
			$dash_data['basic_site_info_data'] = $this->control_engine->master_get($table,$fieldval,$fieldcond,$ordercond,$limitoffsetcond,$matchvallike);		
			

			$this->load->view('super_admin/center_list', $dash_data);
		}
			
	}

	

	public function index()
	{
		redirect('Trainee');
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