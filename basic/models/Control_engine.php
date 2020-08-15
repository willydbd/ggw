<?php

class Control_engine extends CI_Model {

	//$this->db->insert_id()
	//$this->db->affected_rows()
	//echo $this->db->count_all('my_table');
	//$data = array('name' => $name, 'email' => $email, 'url' => $url);
	//$str = $this->db->insert_string('table_name', $data);

        public function __construct()

        {

                $this->load->database();

                //$this->load->library('encryption'); //in controller

        }

        public function master_insert_dup($table,$dataval)
        {
        	//Setting multiple field as a single key field
        	//ALTER TABLE `js1_results` ADD UNIQUE main_fields( `student_id`, `class_id`,`subj_id`,`term`,`acad_session` );
        	//ALTER TABLE `trainee_natural_capital` ADD UNIQUE main_fields( `trainee_ID` )
        	if( (!empty($table))&&(!empty($dataval)) )
        	{
        		 $duplicate_data = array();
			    foreach($dataval AS $key => $value) 
			    {
			        $duplicate_data[] = sprintf("%s='%s'", $key, $value);
			    }

			    $sql = sprintf(
			    				"%s ON DUPLICATE KEY UPDATE %s", 
			    				$this->db->insert_string($table, $dataval), 
			    				implode(',', $duplicate_data));
			    $this->db->query($sql);
			    return $this->db->insert_id();
        	}

        	return '';
        }


        public function master_get($table,$fieldval=false,$fieldcond=false,$ordercond = false,$limitoffsetcond = false,$matchvallike = false, $groupclause=false)
		{		

				//$fieldval = 'title, content, date';
				//$fieldcond = array('company_email' => $compemail );
				//$table = 'company_info';
				//$ordercond = 'date_applied DESC'
				//$limitoffsetcond = '7,0';  limit 7 offset 0
				//$matchvallike  = array('company_name' => $company_typed );
				//$groupclause = ['title','date']
				if($fieldval === false)
				{
					if($fieldcond === false)
			        {
			        	if(!($matchvallike === false) )
			        	{
			        		$this->db->like($matchvallike);
			            	 		                 
			            }
						if( !($groupclause === false) )
			            {
			            	$this->db->group_by($groupclause);
			            }
			        	if(!($ordercond === false) )
			        	{

			            	if(is_array($ordercond))
					    	{
					    		foreach ($ordercond as $key => $value) 
					    		{
					    			$this->db->order_by($value);
					    		}
					    	}
					    	else
					    		$this->db->order_by($ordercond);
			            	 		                 
			            }   

			            if( !($limitoffsetcond === false) )
			            {
			            	$limit = explode(',', $limitoffsetcond);
			            	if(sizeof($limit)>1)
			            		$this->db->limit($limit[0], $limit[1]);
			            	else
			            		$this->db->limit($limitoffsetcond);
			            }
			                
			            	$query =$this->db->get($table);//select * from table
			                return $query->result_array();

			        } 
			        else
			        {
			        	if(!($matchvallike === false) )
			        	{
			        		$this->db->like($matchvallike);
			            	 		                 
			            }
			            if( !($groupclause === false) )
			            {
			            	$this->db->group_by($groupclause);
			            }
			        	if(!($ordercond === false))
			        	{
			            	if(is_array($ordercond))
					    	{
					    		foreach ($ordercond as $key => $value) 
					    		{
					    			$this->db->order_by($value);
					    		}
					    	}
					    	else
					    		$this->db->order_by($ordercond);
			            	
			            }  
			             if( !($limitoffsetcond === false) )
			            {
			            	$limit = explode(',', $limitoffsetcond);
			            	if(sizeof($limit)>1)
			            		$this->db->limit($limit[0], $limit[1]);
			            	else
			            		$this->db->limit($limitoffsetcond);
			            } 			               
			        	
			            $query = $this->db->get_where($table, $fieldcond);
			        	//return $query->row_array();
			        	return $query->result_array();
			        	

			        }
			    }
			    else
			    {
			    	if($fieldcond === false)
			        {
			        	if(!($matchvallike === false) )
			        	{
			        		$this->db->like($matchvallike);
			            	 		                 
			            }
			            if( !($groupclause === false) )
			            {
			            	$this->db->group_by($groupclause);
			            }
			        	if(!($ordercond === false) )
			        	{

			            	if(is_array($ordercond))
					    	{
					    		foreach ($ordercond as $key => $value) 
					    		{
					    			$this->db->order_by($value);
					    		}
					    	}
					    	else
					    		$this->db->order_by($ordercond);
			            	 		                 
			            }   

			            if( !($limitoffsetcond === false) )
			            {
			            	$limit = explode(',', $limitoffsetcond);
			            	if(sizeof($limit)>1)
			            		$this->db->limit($limit[0], $limit[1]);
			            	else
			            		$this->db->limit($limitoffsetcond);
			            }
			                
			                //$this->db->select('title, content, date');
			            	$this->db->select($fieldval);
			            	$query =$this->db->get($table);//select title, content, date from table
			                return $query->result_array();

			        } 
			        else
			        {
			        	if(!($matchvallike === false) )
			        	{
			        		$this->db->like($matchvallike);
			            	 		                 
			            }
			            if( !($groupclause === false) )
			            {
			            	$this->db->group_by($groupclause);
			            }
			        	if(!($ordercond === false))
			        	{
			            	if(is_array($ordercond))
					    	{
					    		foreach ($ordercond as $key => $value) 
					    		{
					    			$this->db->order_by($value);
					    		}
					    	}
					    	else
					    		$this->db->order_by($ordercond);
			            	
			            }  
			             if( !($limitoffsetcond === false) )
			            {
			            	$limit = explode(',', $limitoffsetcond);
			            	if(sizeof($limit)>1)
			            		$this->db->limit($limit[0], $limit[1]);
			            	else
			            		$this->db->limit($limitoffsetcond);
			            } 
			               
			        	$this->db->select($fieldval);
			            $query = $this->db->get_where($table, $fieldcond);
			        	//return $query->row_array();
			        	return $query->result_array();
			        	

			        }
			    } 

		}

		

		//public function master_get_join($fieldval=false,$table,$j_table1,$j_cond1,$j_table2,$j_cond2,$j_table3,$j_cond3,$j_table4,$j_cond4,$ordercond = false, $limitoffsetcond = false)
		public function master_get_join($table,$jt_wt_cond=false,$fieldval=false,$fieldcond=false,$ordercond = false, $limitoffsetcond = false, $groupclause=false)
		{
			//$fieldval = 'table_a.id as id1, table_b.id as id2, table_a. name as uname';
			//$j_table1 = 'company_info'
            //$j_cond1 = 'company_info.id = loan_info.company_id'
            //$jt_wt_cond = array($j_table1 => $j_cond1,$j_table2 => $j_cond2 );

			if(is_array($jt_wt_cond) && ($jt_wt_cond !== false))
			{
				foreach ($jt_wt_cond as $key => $value) 
				{
					$this->db->join($key, $value, 'left');
				}
			}
			if( !($groupclause === false) )
            {
            	$this->db->group_by($groupclause);
            }
			if(! ($ordercond === false) )
		    {
		    	if(is_array($ordercond))
		    	{
		    		foreach ($ordercond as $key => $value) 
		    		{
		    			$this->db->order_by($value);
		    		}
		    	}
		    	else
		    		$this->db->order_by($ordercond);
		    }
		    if( !($limitoffsetcond === false) )
            {
            	$limit = explode(',', $limitoffsetcond);
            	if(sizeof($limit)>1)
            		$this->db->limit($limit[0], $limit[1]);
            	else
            		$this->db->limit($limitoffsetcond);
            }

			//$query = $this->db->get();
			if($fieldcond === false)
			{
				if($fieldval !== false)
				{
					$this->db->select($fieldval);
				    $query =$this->db->get($table);			
				}
				else
				{
					$this->db->from($table);
					$query = $this->db->get();
				}
			}
			else
			{
				if($fieldval !== false)
				{
					$this->db->select($fieldval);			
				    $query = $this->db->get_where($table, $fieldcond);
				}
				else
				{
					$query = $this->db->get_where($table, $fieldcond);	
				}
				
			}

			return $query->result_array();

		}

		

		

		public function insert_master($dataval, $table)
		{
			/*$dataval = array(
	                            'username' => $staffemail,
	                            'password' => $user_password,
	                            'users_type_id' => 3,                                    
	                            );*/

	        $data[0] = $this->db->insert($table, $dataval);
	        $data[1] = $this->db->insert_id();
		    return $data;

		}

		public function update_master($dataval, $table, $condfieldval=false)
		{
			/*$condfieldval = array(
									'name' => "john",
									'status !=' => 2,
									'degree <' => 1
								 );
			  alternatively
			  $condfieldval = "name='Joe' AND status='boss' OR status='active'";
			*/

			if(($condfieldval !== false))
			{
				if(is_array($condfieldval))
				{
					foreach ($condfieldval as $field => $val) 
					{
						$this->db->where($field, $val);
					}
				}
				else
					$this->db->where($condfieldval);
				
			}
			
			
			return $this->db->update($table, $dataval);
		}

		public function delete_master($table, $condfieldval=false)
		{
			/*$condfieldval = array(
									'name' => "john",
									'status !=' => 2,
									'degree <' => 1
								 );
			  alternatively
			  $condfieldval = "name='Joe' AND status='boss' OR status='active'";
			*/

			if(($condfieldval !== false))
			{
				if(is_array($condfieldval))
				{
					foreach ($condfieldval as $field => $val) 
					{
						$this->db->where($field, $val);
					}
				}
				else
					$this->db->where($condfieldval);
				
			}
			
			
			return $this->db->delete($table);
		}


		public function custom_query($qq=false)
		{
			if($qq !== false)
			{
				$qq = $this->db->query($qq);
				return  $qq->result_array(); //$this->db->result();
			}
			return '';

		}
		




}

?>