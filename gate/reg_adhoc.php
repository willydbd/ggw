<!DOCTYPE html>
<html lang="en">
    
<head>        
        <!-- META SECTION -->
        <?php $this->load->view('wp-includes/meta'); ?>
        <title>National Agency for the Great Green Wall - Field Data Entry</title>         

        <!-- my added -->
            

            <!-- CSS -->
            

            <style type="text/css">
                .button-group, .play-area {
                  border: 1px solid #154c3a;
                  padding: 1em 1%;
                  margin-bottom: 1em;
                  max-height: 190px;
                }

                .button {
                  padding: 0.5em;
                  margin-right: 1em;
                }

                .play-area-sub {
                  width: 40%;
                  /*padding: 1em 1%;*/
                  display: inline-block;
                  text-align: center;
                }

                #capture {
                  display: none;
                }

                #snapshot {
                  display: inline-block;
                  width: 185px;
                  border: solid 3px #154c3a;
                  height: 140px;
                }

                #snapshot img {
                    width: 100%;
                    height: 100%;
                }
                .cambutton
                {
                    margin: 10px 0px;
                }
                .cambutton h3
                {
                    color: #fff;
                }

                code{
                    color: #154c3a;
                    background: #dbe8e7;
                    overflow: scroll;
                    white-space: nowrap;
                }

            </style>

        <!-- my added -->
</head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <!-- START PAGE SIDEBAR -->
            <?php $this->load->view('wp-includes/sidebar'); ?>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <?php $this->load->view('wp-includes/header'); ?>
                <!-- END X-NAVIGATION VERTICAL -->                     

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>Trainee/entry_gate">Dashboard</a></li>
                    <li class="active">Adhoc Staff Registration</li>
                </ul>
                <!-- END BREADCRUMB --> 
                
                <!-- PAGE TITLE -->
                <div class="page-title">                    
                    <h2><a href="<?php echo base_url(); ?>Trainee/adhoc_list"><span class="fa fa-arrow-circle-o-left"></span></a> Adhoc Staff Registration</h2>
                </div>
                <!-- END PAGE TITLE -->                
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                    <input type="hidden" id="traineeID" value="<?php echo $trans; ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel panel-colorful">
                                <div class="panel-body">
                                    <div class="list-group border-bottom">
                                        <a href="#" id="basic_adhoc_staff_information_handle" class="list-group-item active">
                                            <span class="sidenumber">1 - </span><i class="glyphicon glyphicon-info-sign"></i> Basic Information
                                        </a>
                                        <a href="#" id="adhoc_staff_family_handle" class="list-group-item">
                                            <span class="sidenumber">2 - </span><i class="glyphicon glyphicon-th"></i> Family Information
                                        </a>
                                        <a href="#" id="adhoc_staff_education_handle" class="list-group-item">
                                            <span class="sidenumber">2 - </span><i class="glyphicon glyphicon-th"></i> Educational Information
                                        </a>
                                        <a href="#" id="adhoc_staff_profcert_handle" class="list-group-item">
                                            <span class="sidenumber">3 - </span><i class="glyphicon glyphicon-tower"></i> Professional Certificate
                                        </a>
                                        

                                    </div>                              
                                </div>
                            </div>
                        </div>

                        

                        <div class="col-md-8" id="basic_adhoc_staff_information">
                            <div id=basic_adhoc_staff_information_msg></div>
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-success">
                                <div class="panel-body">
                                    <h3><i class="glyphicon glyphicon-info-sign"></i> BASIC ADHOC STAFF INFORMATION</h3>

                                    <?php

                                        $surname = $firstname = $phone = $email = $lastname = ''; 
                                        $state = $lga = $gender = $site_center_id = $marital_status = '';
                                        $dob = $birth_place = $street = $city = $role = '';

                                        $init_photo = $photo = '';

                                        $nysc_period = $nysc_service_place = $nysc_discharge_date = $nysc_certifcate_num = '';

                                        $spouse_state = $spouse_name = $father_state = $father_name = $mother_name = $mother_state = '';
                                        

                                        if(!empty($adhoc_basic_info_data) && is_array($adhoc_basic_info_data))
                                        {
                                            $adhoc_vv = $adhoc_basic_info_data[0];
                                            $surname = $adhoc_vv['surname'];
                                            $firstname = $adhoc_vv['firstname'];
                                            $phone = $adhoc_vv['phone'];
                                            $lga = $adhoc_vv['lga'];
                                            $state = $adhoc_vv['state'];
                                            $email = $adhoc_vv['email'];
                                            $lastname = $adhoc_vv['lastname'];
                                            $dob = $adhoc_vv['dob'];
                                            $birth_place = $adhoc_vv['birth_place'];
                                            $street = $adhoc_vv['street'];
                                            $city = $adhoc_vv['city'];
                                            $role = $adhoc_vv['role'];
                                            $nysc_period = $adhoc_vv['nysc_period'];
                                            $nysc_service_place = $adhoc_vv['nysc_service_place'];
                                            $nysc_discharge_date = $adhoc_vv['nysc_discharge_date'];
                                            $nysc_certifcate_num = $adhoc_vv['nysc_certifcate_num'];
                                            $spouse_name = $adhoc_vv['spouse_name'];
                                            $spouse_state = $adhoc_vv['spouse_state'];
                                            $mother_name = $adhoc_vv['mother_name'];
                                            $mother_state = $adhoc_vv['mother_state'];
                                            $father_name = $adhoc_vv['father_name'];
                                            $father_state = $adhoc_vv['father_state'];
                                            $gender = $adhoc_vv['gender'];
                                            $photo = $adhoc_vv['photo'];
                                            $marital_status = $adhoc_vv['marital_status'];
                                            $site_center_id = $adhoc_vv['site_center_id'];
                                            

                                            if(!empty($dob))
                                                $dob = date('Y-m-d',strtotime($dob));
                                            if(!empty($nysc_discharge_date))
                                                $nysc_discharge_date = date('Y-m-d',strtotime($nysc_discharge_date));
                                        }

                                    ?>                                
                                    <!-- <form action="javascript:alert('Validated!');" role="form" class="form-horizontal" > -->
                                    <form action="#" role="form" class="form-horizontal" >
                                        <div class="row" style="line-height: 3">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Surname </code>
                                                        <input type="surname" value="<?php echo $surname;  ?>" class="form-control" id="surname" placeholder="Surname"/>
                                                    </div>
                                                    <div style="margin-top: 5px;">
                                                        <code> First Name </code>
                                                        <input type="text" value="<?php echo $firstname;  ?>" class="form-control" id="firstname" placeholder="First Name"/>
                                                    </div>                                                    
                                                    <div style="margin-top: 5px;">
                                                        <code> Last Name </code>
                                                        <input value="<?php echo $lastname;  ?>" type="text" class="form-control" id="lastname" placeholder="Last Name"/>
                                                    </div>
                                                    <div style="margin-top: 7px;">
                                                        <code> E-mail Address </code>
                                                        <input type="email" value="<?php echo $email;  ?>" class="form-control" id="email" placeholder="E-mail Address"/>
                                                    </div>
                                                    <div style="margin-top: 6px;">
                                                        <code> Phone Number </code>
                                                        <input type="phone" value="<?php echo $phone;  ?>" class="form-control" id="phone" placeholder="Phone Number"/>
                                                    </div>
                                                </div>                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: -5px;">
                                                        <?php

                                                            $tr_gender_sel = '<code> Gender </code>
                                                            <select class="form-control select" id="gender" data-live-search="true">
                                                            <option value="0">Select Gender</option>';

                                                            if($gender == 1)
                                                            {
                                                                $tr_gender_sel .= '<option value="1" selected>Male</option>
                                                                    <option value="2">Female</option>';
                                                            }
                                                            else if($gender == 2)
                                                            {
                                                                $tr_gender_sel .= '<option value="2" selected>Female</option>
                                                                    <option value="1">Male</option>';
                                                            }
                                                            else
                                                            {
                                                                $tr_gender_sel .= '<option value="1">Male</option>';
                                                                $tr_gender_sel .= '<option value="2">Female</option>';
                                                            }

                                                            echo $tr_gender_sel.'</select>';

                                                        ?>
                                                    </div>
                                                                                                        
                                                    <div style="margin-top: 0px;">
                                                        <?php

                                                            $nig_state_sel = '<code> Staff State </code>
                                                            <select class="form-control select" id="nig_states" data-live-search="true">
                                                            <option value="0">Select State</option>';

                                                            if(!empty($nig_states) && is_array($nig_states))
                                                            {
                                                                foreach ($nig_states as $key => $val) 
                                                                {
                                                                    $stateval = $val["state"];
                                                                    if($state == $stateval)
                                                                    {
                                                                        $nig_state_sel .= '<option value="'.$stateval.'" selected>'.$stateval.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $nig_state_sel .= '<option value="'.$stateval.'">'.$stateval.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $nig_state_sel.'</select>';

                                                        ?>
                                                        
                                                            
                                                    </div> 

                                                    <div style="margin-top: 0px;">
                                                        <input type="hidden" value="Nigeria" id="countryval">
                                                        <input type="hidden" value="<?php echo $lga; ?>" id="lgaval">
                                                        
                                                            <?php 
                                                                $ng_lga_sel = '<code> L.G.A</code>
                                                            <select class="form-control select" name="lga" data-live-search="true" id="lga">
                                                            <option value="0">Select L.G.A</option>';

                                                                if(!empty($lga))
                                                                {
                                                                    $ng_lga_sel .= '<option value="'.$lga.'" selected>'.$lga.'</option>';
                                                                }
                                                                
                                                                echo $ng_lga_sel .= '</select>';


                                                            ?>   
                                                    </div>

                                                    <div style="margin-top: 0px;">
                                                        <?php

                                                            $tr_marital_st_sel = '<code> Marital Status </code>
                                                            <select class="form-control select" id="marital_status" data-live-search="true">
                                                            <option value="0">Select Marital Status</option>';

                                                            if(!empty($marital_status_data) && is_array($marital_status_data))
                                                            {
                                                                foreach ($marital_status_data as $key => $val) 
                                                                {
                                                                    $tr_marital_st_str = $val["item"];
                                                                    $tr_marital_st_val = $val["id"];
                                                                    if($marital_status == $tr_marital_st_val)
                                                                    {
                                                                        $tr_marital_st_sel .= '<option value="'.$tr_marital_st_val.'" selected>'.$tr_marital_st_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $tr_marital_st_sel .= '<option value="'.$tr_marital_st_val.'">'.$tr_marital_st_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $tr_marital_st_sel.'</select>';

                                                        ?>   
                                                    </div>

                                                    <div style="margin-top: 0px;">
                                                        <?php

                                                            $center_name_sel = '<code> Assign Center </code>
                                                            <select class="form-control select" id="center_name" data-live-search="true">
                                                            <option value="0">Select Center</option>';

                                                            if(!empty($basic_site_info_data) && is_array($basic_site_info_data))
                                                            {
                                                                foreach ($basic_site_info_data as $key => $val) 
                                                                {
                                                                    $center_name_val = $val["id"];
                                                                    $center_name_str = $val["center_name"];
                                                                    if($site_center_id == $center_name_val)
                                                                    {
                                                                        $center_name_sel .= '<option value="'.$center_name_val.'" selected>'.$center_name_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $center_name_sel .= '<option value="'.$center_name_val.'">'.$center_name_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $center_name_sel.'</select>';

                                                        ?>
                                                        
                                                            
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: -2px;">
                                                        <code> Date of Birth </code>
                                                        <input type="date" value="<?php echo $dob;  ?>" class="form-control" id="dob" placeholder="Date of Birth"/>
                                                    </div>
                                                    <div style="margin-top: 7px;">
                                                        <code> Place of Birth </code>
                                                        <input type="text" value="<?php echo $birth_place;  ?>" class="form-control" id="birth_place" placeholder="Place of Birth"/>
                                                    </div>                                                    
                                                    <div style="margin-top: 7px;">
                                                        <code> Contact Address (City) </code>
                                                        <input value="<?php echo $city;  ?>" type="text" class="form-control" id="city" placeholder="Contact Address (City)"/>
                                                    </div>
                                                    <div style="margin-top: 6px;">
                                                        <code> Contact Address (Street) </code>
                                                        <input value="<?php echo $street;  ?>" type="text" class="form-control" id="street" placeholder="Contact Address (Street)"/>
                                                    </div>
                                                    <div style="margin-top: 4px;">
                                                        <code> Adhoc Role (Forest Guard, Cleaner etc.) </code>
                                                        <input value="<?php echo $role;  ?>" type="text" class="form-control" id="role" placeholder="Adhoc Role (Forest Guard, Cleaner, Extension Worker etc.)"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>
                                            
                                        </div>     

                                        <div class="row text-center" style="margin-top: 20px;">
                                            <!-- The buttons to control the stream -->
                                            <div class=" col-md-4 button-group" style="padding: 10px; display: inline-grid;">
                                              <button id="btn-start" type="button" class="cambutton btn btn-primary active "><h3><i class="glyphicon glyphicon-camera"></i> Open Camera</h3></button>
                                              <button id="btn-stop" type="button" class="cambutton btn btn-danger active disabled"><h3><i class="fa fa-times-circle"></i> Stop Camera</h3></button>
                                              <button id="btn-capture" type="button" class="cambutton btn btn-success active disabled"><h3><i class="fa fa-camera-retro"></i> Capture Image</h3></button>
                                            </div>

                                            <!-- Video Element & Canvas -->
                                            <div class="col-md-4 play-area">
                                              <h3>The Stream</h3>
                                                <!-- <video id="stream" width="320" height="240"></video> -->
                                                <video id="stream" width="185" height="140" style="border: solid 3px #154c3a; "></video>
                                            </div>

                                            <div class="col-md-4 play-area">
                                              <h3>The Capture</h3>
                                                <!-- <canvas id="capture" width="320" height="240"></canvas> -->
                                                <canvas id="capture" width="185" height="140" style="border: solid 3px #154c3a; "></canvas>
                                                <div id="snapshot">
                                                    <?php
                                                        $photopath = base_url().'gsi-assets/image_uploads/adhoc_staff/'.$photo;
                                                        //var_dump($photopath);
                                                        if(!empty($photo) && (@getimagesize($photopath)))
                                                        {
                                                            $init_photo = $photopath;
                                                            echo '<img src="'.$photopath.'" width="240">';
                                                        }
                                                    ?>
                                                </div>
                                            </div>

                                              
                                        </div>                                                                                                  
                                        
                                        <div style="margin-top: 20px;">
                                            <!-- <code> </code>
                                                        <input type="submit" class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" value="Next" name="Next"> --> 
                                            <div class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" id="basic_adhoc_staff_information_bt">Next >></div>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>                        
                            <!-- END WIZARD WITH VALIDATION -->

                        </div>

                        <div class="col-md-8 hidden" id="adhoc_staff_family">
                            <div id=adhoc_staff_family_msg></div>
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-success">
                                <div class="panel-body">
                                    <h3><i class="glyphicon glyphicon-th"></i> FAMILY INFORMATION</h3>
                                                                    
                                    <form action="#" role="form" class="form-horizontal" >
                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            <div class="col-md-4">
                                                <div class="form-group">                

                                                    <div style="margin-top: 0px;">
                                                        <code> Spouse Name </code>
                                                        <input type="text" class="form-control" id="spouse_name" placeholder="Spouse Name" value="<?php echo $spouse_name ?>" />
                                                    </div>

                                                    <div style="margin-top: 0px;">
                                                        <?php

                                                            $nig_state_sel = '<code> Spouse State </code>
                                                            <select class="form-control select" id="spouse_state" data-live-search="true">
                                                            <option value="0">Select State</option>';

                                                            if(!empty($nig_states) && is_array($nig_states))
                                                            {
                                                                foreach ($nig_states as $key => $val) 
                                                                {
                                                                    $stateval = $val["state"];
                                                                    if($spouse_state == $stateval)
                                                                    {
                                                                        $nig_state_sel .= '<option value="'.$stateval.'" selected>'.$stateval.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $nig_state_sel .= '<option value="'.$stateval.'">'.$stateval.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $nig_state_sel.'</select>';

                                                        ?>
                                                    </div>
                                                                                                    
                                                </div>
                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                

                                                    <div style="margin-top: 0px;">
                                                        <code> Mother Name </code>
                                                        <input type="text" class="form-control" id="mother_name" placeholder="Mother Name" value="<?php echo $mother_name ?>" />
                                                    </div>
                                                    
                                                    <div style="margin-top: 0px;">
                                                        <?php

                                                            $nig_state_sel = '<code> Mother State </code>
                                                            <select class="form-control select" id="mother_state" data-live-search="true">
                                                            <option value="0">Select State</option>';

                                                            if(!empty($nig_states) && is_array($nig_states))
                                                            {
                                                                foreach ($nig_states as $key => $val) 
                                                                {
                                                                    $stateval = $val["state"];
                                                                    if($mother_state == $stateval)
                                                                    {
                                                                        $nig_state_sel .= '<option value="'.$stateval.'" selected>'.$stateval.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $nig_state_sel .= '<option value="'.$stateval.'">'.$stateval.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $nig_state_sel.'</select>';

                                                        ?>
                                                    </div>
                                                                                                    
                                                </div>
                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                

                                                    <div style="margin-top: 0px;">
                                                        <code> Father Name </code>
                                                        <input type="text" class="form-control" id="father_name" placeholder="Father Name" value="<?php echo $father_name ?>" />
                                                    </div>
                                                    
                                                    <div style="margin-top: 0px;">
                                                        <?php

                                                            $nig_state_sel = '<code> Father State </code>
                                                            <select class="form-control select" id="father_state" data-live-search="true">
                                                            <option value="0">Select State</option>';

                                                            if(!empty($nig_states) && is_array($nig_states))
                                                            {
                                                                foreach ($nig_states as $key => $val) 
                                                                {
                                                                    $stateval = $val["state"];
                                                                    if($father_state == $stateval)
                                                                    {
                                                                        $nig_state_sel .= '<option value="'.$stateval.'" selected>'.$stateval.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $nig_state_sel .= '<option value="'.$stateval.'">'.$stateval.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $nig_state_sel.'</select>';

                                                        ?>
                                                    </div>
                                                                                                    
                                                </div>
                                                
                                            </div>

                                                                                                                                                                                                    
                                        </div>
                                        

                                        <div>
                                            
                                            <div class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" id="adhoc_staff_family_bt">Next >></div>
                                        </div>
                                    </form>
                                </div>
                            </div>                        
                            <!-- END WIZARD WITH VALIDATION -->

                        </div>

                        <div class="col-md-8 hidden" id="adhoc_staff_education">
                            <div id=adhoc_staff_education_msg></div>
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-success">
                                <div class="panel-body">
                                    <h3><i class="glyphicon glyphicon-th"></i> EDUCATION INFORMATION</h3>
                                    <?php
                                        $edu_type = $edu_from = $edu_to = $edu_cert_obtained = '';
                                        $name = $edu_cert_number = '';
                                        $pry_name1 = $sec_name1 = $tert_name1 = '';
                                        $pry_name2 = $sec_name2 = $tert_name2 = '';
                                        $pry_name3 = $sec_name3 = $tert_name3 = '';
                                        $pry_start_yr1 = $sec_start_yr1 = $tert_start_yr1 = '';
                                        $pry_start_yr2 = $sec_start_yr2 = $tert_start_yr2 = '';
                                        $pry_start_yr3 = $sec_start_yr3 = $tert_start_yr3 = '';
                                        $pry_end_yr1 = $sec_end_yr1 = $tert_end_yr1 = '';
                                        $pry_end_yr2 = $sec_end_yr2 = $tert_end_yr2 = '';
                                        $pry_end_yr3 = $sec_end_yr3 = $tert_end_yr3 = '';
                                        $pry_cert_obt1 = $sec_cert_obt1 = $tert_cert_obt1 = '';
                                        $pry_cert_obt2 = $sec_cert_obt2 = $tert_cert_obt2 = '';
                                        $pry_cert_obt3 = $sec_cert_obt3 = $tert_cert_obt3 = '';
                                        $pry_cert_num1 = $sec_cert_num1 = $tert_cert_num1 = '';
                                        $pry_cert_num2 = $sec_cert_num2 = $tert_cert_num2 = '';
                                        $pry_cert_num3 = $sec_cert_num3 = $tert_cert_num3 = '';
                                        $profcert_name1 = '';
                                        $profcert_start_yr1 = '';
                                        $profcert_end_yr1 = '';
                                        $profcert_cert_obt1 = '';
                                        $profcert_cert_num1 = '';

                                        $profcert_name2 = '';
                                        $profcert_start_yr2 = '';
                                        $profcert_end_yr2 = '';
                                        $profcert_cert_obt2 = '';
                                        $profcert_cert_num2 = '';

                                        $profcert_name3 = '';
                                        $profcert_start_yr3 = '';
                                        $profcert_end_yr3 = '';
                                        $profcert_cert_obt3 = '';
                                        $profcert_cert_num3 = '';


                                        if(!empty($adhoc_education_data) && is_array($adhoc_education_data))
                                        {
                                            foreach ($adhoc_education_data as $key => $value) 
                                            {
                                            
                                                $hc_val = $value;
                                                $edu_type = $hc_val['edu_type'];
                                                $edu_from = $hc_val['edu_from'];
                                                $edu_to = $hc_val['edu_to'];
                                                $edu_cert_obtained = $hc_val['edu_cert_obtained'];
                                                $edu_cert_number = $hc_val['edu_cert_number'];
                                                $name = $hc_val['name'];

                                                if($edu_type == 'p1')
                                                {
                                                    $pry_name1 = $name;                                
                                                    $pry_start_yr1 = $edu_from;
                                                    $pry_end_yr1 = $edu_to;
                                                    $pry_cert_obt1 = $edu_cert_obtained;
                                                    $pry_cert_num1 = $edu_cert_number;
                                                }
                                                else if($edu_type == 'p2')
                                                {
                                                    $pry_name2 = $name;                                
                                                    $pry_start_yr2 = $edu_from;
                                                    $pry_end_yr2 = $edu_to;
                                                    $pry_cert_obt2 = $edu_cert_obtained;
                                                    $pry_cert_num2 = $edu_cert_number;
                                                }
                                                else if($edu_type == 'p3')
                                                {
                                                    $pry_name3 = $name;                                
                                                    $pry_start_yr3 = $edu_from;
                                                    $pry_end_yr3 = $edu_to;
                                                    $pry_cert_obt3 = $edu_cert_obtained;
                                                    $pry_cert_num3 = $edu_cert_number;
                                                }
                                                else if($edu_type == 's1')
                                                {
                                                    $sec_name1 = $name;                                
                                                    $sec_start_yr1 = $edu_from;
                                                    $sec_end_yr1 = $edu_to;
                                                    $sec_cert_obt1 = $edu_cert_obtained;
                                                    $sec_cert_num1 = $edu_cert_number;
                                                }
                                                else if($edu_type == 's2')
                                                {
                                                    $sec_name2 = $name;                                
                                                    $sec_start_yr2 = $edu_from;
                                                    $sec_end_yr2 = $edu_to;
                                                    $sec_cert_obt2 = $edu_cert_obtained;
                                                    $sec_cert_num2 = $edu_cert_number;
                                                }
                                                else if($edu_type == 's3')
                                                {
                                                    $sec_name3 = $name;                                
                                                    $sec_start_yr3 = $edu_from;
                                                    $sec_end_yr3 = $edu_to;
                                                    $sec_cert_obt3 = $edu_cert_obtained;
                                                    $sec_cert_num3 = $edu_cert_number;
                                                }
                                                else if($edu_type == 't1')
                                                {
                                                    $tert_name1 = $name;                                
                                                    $tert_start_yr1 = $edu_from;
                                                    $tert_end_yr1 = $edu_to;
                                                    $tert_cert_obt1 = $edu_cert_obtained;
                                                    $tert_cert_num1 = $edu_cert_number;
                                                }
                                                else if($edu_type == 't2')
                                                {
                                                    $tert_name2 = $name;                                
                                                    $tert_start_yr2 = $edu_from;
                                                    $tert_end_yr2 = $edu_to;
                                                    $tert_cert_obt2 = $edu_cert_obtained;
                                                    $tert_cert_num2 = $edu_cert_number;
                                                }
                                                else if($edu_type == 't3')
                                                {
                                                    $tert_name3 = $name;                                
                                                    $tert_start_yr3 = $edu_from;
                                                    $tert_end_yr3 = $edu_to;
                                                    $tert_cert_obt3 = $edu_cert_obtained;
                                                    $tert_cert_num3 = $edu_cert_number;
                                                }
                                                if($edu_type == 'prof1')
                                                {
                                                    $profcert_name1 = $name;                                
                                                    $profcert_start_yr1 = $edu_from;
                                                    $profcert_end_yr1 = $edu_to;
                                                    $profcert_cert_obt1 = $edu_cert_obtained;
                                                    $profcert_cert_num1 = $edu_cert_number;
                                                }
                                                else if($edu_type == 'prof2')
                                                {
                                                    $profcert_name2 = $name;                                
                                                    $profcert_start_yr2 = $edu_from;
                                                    $profcert_end_yr2 = $edu_to;
                                                    $profcert_cert_obt2 = $edu_cert_obtained;
                                                    $profcert_cert_num2 = $edu_cert_number;
                                                }
                                                else if($edu_type == 'prof3')
                                                {
                                                    $profcert_name3 = $name;                                
                                                    $profcert_start_yr3 = $edu_from;
                                                    $profcert_end_yr3 = $edu_to;
                                                    $profcert_cert_obt3 = $edu_cert_obtained;
                                                    $profcert_cert_num3 = $edu_cert_number;
                                                }
                                            }
                                            
                                        }
                                        

                                    ?>                                
                                    <form action="#" role="form" class="form-horizontal" >
                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            <h3>Primary Education</h3>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Primary School Name</code>
                                                        <input type="text" value="<?php echo $pry_name1;  ?>" class="form-control" id="pry_name1" placeholder="Primary School Name"/>
                                                    </div>
                                                    <div>
                                                        <code> Start Year </code>
                                                        <input type="date" value="<?php echo $pry_start_yr1;  ?>" class="form-control" id="pry_start_yr1" placeholder="Start Year"/>
                                                    </div>
                                                    <div>
                                                        <code> End Year </code>
                                                        <input type="date" value="<?php echo $pry_end_yr1;  ?>" class="form-control" id="pry_end_yr1" placeholder="End Year"/>
                                                    </div>
                                                    <div>
                                                        <code> Certificate Obtained </code>
                                                        <input type="text" value="<?php echo $pry_cert_obt1;  ?>" class="form-control" id="pry_cert_obt1" placeholder="Certificate Obtained"/>
                                                    </div>                                                    
                                                    <div>
                                                        <code> Certificate Number </code>
                                                        <input value="<?php echo $pry_cert_num1;  ?>" type="text" class="form-control" id="pry_cert_num1" placeholder="Certificate Number"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Primary School Name 2 </code>
                                                        <input type="text" value="<?php echo $pry_name2;  ?>" class="form-control" id="pry_name2" placeholder="Primary School Name"/>
                                                    </div>
                                                    <div>
                                                        <code> Start Year </code>
                                                        <input type="date" value="<?php echo $pry_start_yr2;  ?>" class="form-control" id="pry_start_yr2" placeholder="Start Year"/>
                                                    </div>
                                                    <div>
                                                        <code> End Year </code>
                                                        <input type="date" value="<?php echo $pry_end_yr2;  ?>" class="form-control" id="pry_end_yr2" placeholder="End Year"/>
                                                    </div>
                                                    <div>
                                                        <code> Certificate Obtained </code>
                                                        <input type="text" value="<?php echo $pry_cert_obt2;  ?>" class="form-control" id="pry_cert_obt2" placeholder="Certificate Obtained"/>
                                                    </div>                                                    
                                                    <div>
                                                        <code> Certificate Number </code>
                                                        <input value="<?php echo $pry_cert_num2;  ?>" type="text" class="form-control" id="pry_cert_num2" placeholder="Certificate Number"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Primary School Name 3</code>
                                                        <input type="text" value="<?php echo $pry_name3;  ?>" class="form-control" id="pry_name3" placeholder="Primary School Name"/>
                                                    </div>
                                                    <div>
                                                        <code> Start Year </code>
                                                        <input type="date" value="<?php echo $pry_start_yr3;  ?>" class="form-control" id="pry_start_yr3" placeholder="Start Year"/>
                                                    </div>
                                                    <div>
                                                        <code> End Year </code>
                                                        <input type="date" value="<?php echo $pry_end_yr3;  ?>" class="form-control" id="pry_end_yr3" placeholder="End Year"/>
                                                    </div>
                                                    <div>
                                                        <code> Certificate Obtained </code>
                                                        <input type="text" value="<?php echo $pry_cert_obt3;  ?>" class="form-control" id="pry_cert_obt3" placeholder="Certificate Obtained"/>
                                                    </div>                                                    
                                                    <div>
                                                        <code> Certificate Number </code>
                                                        <input value="<?php echo $pry_cert_num3;  ?>" type="text" class="form-control" id="pry_cert_num3" placeholder="Certificate Number"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>
                                                                                                                                                        
                                        </div>

                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            <h3>Secondary Education</h3>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Secondary School Name</code>
                                                        <input type="text" value="<?php echo $sec_name1;  ?>" class="form-control" id="sec_name1" placeholder="Secondary School Name"/>
                                                    </div>
                                                    <div>
                                                        <code> Start Year </code>
                                                        <input type="date" value="<?php echo $sec_start_yr1;  ?>" class="form-control" id="sec_start_yr1" placeholder="Start Year"/>
                                                    </div>
                                                    <div>
                                                        <code> End Year </code>
                                                        <input type="date" value="<?php echo $sec_end_yr1;  ?>" class="form-control" id="sec_end_yr1" placeholder="End Year"/>
                                                    </div>
                                                    <div>
                                                        <code> Certificate Obtained </code>
                                                        <input type="text" value="<?php echo $sec_cert_obt1;  ?>" class="form-control" id="sec_cert_obt1" placeholder="Certificate Obtained"/>
                                                    </div>                                                    
                                                    <div>
                                                        <code> Certificate Number </code>
                                                        <input value="<?php echo $sec_cert_num1;  ?>" type="text" class="form-control" id="sec_cert_num1" placeholder="Certificate Number"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Secondary School Name 2 </code>
                                                        <input type="text" value="<?php echo $sec_name2;  ?>" class="form-control" id="sec_name2" placeholder="Secondary School Name"/>
                                                    </div>
                                                    <div>
                                                        <code> Start Year </code>
                                                        <input type="date" value="<?php echo $sec_start_yr2;  ?>" class="form-control" id="sec_start_yr2" placeholder="Start Year"/>
                                                    </div>
                                                    <div>
                                                        <code> End Year </code>
                                                        <input type="date" value="<?php echo $sec_end_yr2;  ?>" class="form-control" id="sec_end_yr2" placeholder="End Year"/>
                                                    </div>
                                                    <div>
                                                        <code> Certificate Obtained </code>
                                                        <input type="text" value="<?php echo $sec_cert_obt2;  ?>" class="form-control" id="sec_cert_obt2" placeholder="Certificate Obtained"/>
                                                    </div>                                                    
                                                    <div>
                                                        <code> Certificate Number </code>
                                                        <input value="<?php echo $sec_cert_num2;  ?>" type="text" class="form-control" id="sec_cert_num2" placeholder="Certificate Number"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Secondary School Name 3</code>
                                                        <input type="text" value="<?php echo $sec_name3;  ?>" class="form-control" id="sec_name3" placeholder="Secondary School Name"/>
                                                    </div>
                                                    <div>
                                                        <code> Start Year </code>
                                                        <input type="date" value="<?php echo $sec_start_yr3;  ?>" class="form-control" id="sec_start_yr3" placeholder="Start Year"/>
                                                    </div>
                                                    <div>
                                                        <code> End Year </code>
                                                        <input type="date" value="<?php echo $sec_end_yr3;  ?>" class="form-control" id="sec_end_yr3" placeholder="End Year"/>
                                                    </div>
                                                    <div>
                                                        <code> Certificate Obtained </code>
                                                        <input type="text" value="<?php echo $sec_cert_obt3;  ?>" class="form-control" id="sec_cert_obt3" placeholder="Certificate Obtained"/>
                                                    </div>                                                    
                                                    <div>
                                                        <code> Certificate Number </code>
                                                        <input value="<?php echo $sec_cert_num3;  ?>" type="text" class="form-control" id="sec_cert_num3" placeholder="Certificate Number"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>
                                                                                                                                                        
                                        </div>
                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            <h3>Tertiary Education</h3>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Name of Institution</code>
                                                        <input type="text" value="<?php echo $tert_name1;  ?>" class="form-control" id="tert_name1" placeholder="Name of Institution"/>
                                                    </div>
                                                    <div>
                                                        <code> Start Year </code>
                                                        <input type="date" value="<?php echo $tert_start_yr1;  ?>" class="form-control" id="tert_start_yr1" placeholder="Start Year"/>
                                                    </div>
                                                    <div>
                                                        <code> End Year </code>
                                                        <input type="date" value="<?php echo $tert_end_yr1;  ?>" class="form-control" id="tert_end_yr1" placeholder="End Year"/>
                                                    </div>
                                                    <div>
                                                        <code> Certificate Obtained </code>
                                                        <input type="text" value="<?php echo $tert_cert_obt1;  ?>" class="form-control" id="tert_cert_obt1" placeholder="Certificate Obtained"/>
                                                    </div>                                                    
                                                    <div>
                                                        <code> Certificate Number </code>
                                                        <input value="<?php echo $tert_cert_num1;  ?>" type="text" class="form-control" id="tert_cert_num1" placeholder="Certificate Number"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Name of Institution 2 </code>
                                                        <input type="text" value="<?php echo $tert_name2;  ?>" class="form-control" id="tert_name2" placeholder="Name of Institution"/>
                                                    </div>
                                                    <div>
                                                        <code> Start Year </code>
                                                        <input type="date" value="<?php echo $tert_start_yr2;  ?>" class="form-control" id="tert_start_yr2" placeholder="Start Year"/>
                                                    </div>
                                                    <div>
                                                        <code> End Year </code>
                                                        <input type="date" value="<?php echo $tert_end_yr2;  ?>" class="form-control" id="tert_end_yr2" placeholder="End Year"/>
                                                    </div>
                                                    <div>
                                                        <code> Certificate Obtained </code>
                                                        <input type="text" value="<?php echo $tert_cert_obt2;  ?>" class="form-control" id="tert_cert_obt2" placeholder="Certificate Obtained"/>
                                                    </div>                                                    
                                                    <div>
                                                        <code> Certificate Number </code>
                                                        <input value="<?php echo $tert_cert_num2;  ?>" type="text" class="form-control" id="tert_cert_num2" placeholder="Certificate Number"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Name of Institution 3</code>
                                                        <input type="text" value="<?php echo $tert_name3;  ?>" class="form-control" id="tert_name3" placeholder="Name of Institution"/>
                                                    </div>
                                                    <div>
                                                        <code> Start Year </code>
                                                        <input type="date" value="<?php echo $tert_start_yr3;  ?>" class="form-control" id="tert_start_yr3" placeholder="Start Year"/>
                                                    </div>
                                                    <div>
                                                        <code> End Year </code>
                                                        <input type="date" value="<?php echo $tert_end_yr3;  ?>" class="form-control" id="tert_end_yr3" placeholder="End Year"/>
                                                    </div>
                                                    <div>
                                                        <code> Certificate Obtained </code>
                                                        <input type="text" value="<?php echo $tert_cert_obt3;  ?>" class="form-control" id="tert_cert_obt3" placeholder="Certificate Obtained"/>
                                                    </div>                                                    
                                                    <div>
                                                        <code> Certificate Number </code>
                                                        <input value="<?php echo $tert_cert_num3;  ?>" type="text" class="form-control" id="tert_cert_num3" placeholder="Certificate Number"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>
                                                                                                                                                        
                                        </div>
                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            
                                            <h3>NYSC</h3>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div>
                                                        <code> NYSC Period</code>
                                                        <input type="date" value="<?php echo $nysc_period;  ?>" class="form-control" id="nysc_period" placeholder="NYSC Period"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div>
                                                        <code> NYSC Service Place </code>
                                                        <input type="text" value="<?php echo $nysc_service_place;  ?>" class="form-control" id="nysc_service_place" placeholder="NYSC Service Place"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div>
                                                        <code> NYSC Discharge Date</code>
                                                        <input type="date" value="<?php echo $nysc_discharge_date;  ?>" class="form-control" id="nysc_discharge_date" placeholder="NYSC Discharge Date"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div>
                                                        <code> NYSC Certificate Number</code>
                                                        <input type="text" value="<?php echo $nysc_certifcate_num;  ?>" class="form-control" id="nysc_certifcate_num" placeholder="NYSC Certificate Number"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>
                                                                                                                                                        
                                        </div>
                                        

                                        <div>
                                            
                                            <div class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" id="adhoc_staff_education_bt">Next >></div>
                                        </div>
                                    </form>
                                </div>
                            </div>                        
                            <!-- END WIZARD WITH VALIDATION -->

                        </div>
                        <div class="col-md-8 hidden" id="adhoc_staff_profcert">
                            <div id=adhoc_staff_profcert_msg></div>
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-success">
                                <div class="panel-body">
                                    <h3><i class="glyphicon glyphicon-th"></i> PROFESSIONAL CERTIFICATE</h3>
                                                                   
                                    <form action="#" role="form" class="form-horizontal" >
                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            <h3>Professional Program</h3>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Name of Institution</code>
                                                        <input type="text" value="<?php echo $profcert_name1;  ?>" class="form-control" id="profcert_name1" placeholder="Name of Institution"/>
                                                    </div>
                                                    <div>
                                                        <code> Start Year </code>
                                                        <input type="date" value="<?php echo $profcert_start_yr1;  ?>" class="form-control" id="profcert_start_yr1" placeholder="Start Year"/>
                                                    </div>
                                                    <div>
                                                        <code> End Year </code>
                                                        <input type="date" value="<?php echo $profcert_end_yr1;  ?>" class="form-control" id="profcert_end_yr1" placeholder="End Year"/>
                                                    </div>
                                                    <div>
                                                        <code> Certificate Obtained </code>
                                                        <input type="text" value="<?php echo $profcert_cert_obt1;  ?>" class="form-control" id="profcert_cert_obt1" placeholder="Certificate Obtained"/>
                                                    </div>                                                    
                                                    <div>
                                                        <code> Certificate Number </code>
                                                        <input value="<?php echo $profcert_cert_num1;  ?>" type="text" class="form-control" id="profcert_cert_num1" placeholder="Certificate Number"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Name of Institution 2 </code>
                                                        <input type="text" value="<?php echo $profcert_name2;  ?>" class="form-control" id="profcert_name2" placeholder="Name of Institution"/>
                                                    </div>
                                                    <div>
                                                        <code> Start Year </code>
                                                        <input type="date" value="<?php echo $profcert_start_yr2;  ?>" class="form-control" id="profcert_start_yr2" placeholder="Start Year"/>
                                                    </div>
                                                    <div>
                                                        <code> End Year </code>
                                                        <input type="date" value="<?php echo $profcert_end_yr2;  ?>" class="form-control" id="profcert_end_yr2" placeholder="End Year"/>
                                                    </div>
                                                    <div>
                                                        <code> Certificate Obtained </code>
                                                        <input type="text" value="<?php echo $profcert_cert_obt2;  ?>" class="form-control" id="profcert_cert_obt2" placeholder="Certificate Obtained"/>
                                                    </div>                                                    
                                                    <div>
                                                        <code> Certificate Number </code>
                                                        <input value="<?php echo $profcert_cert_num2;  ?>" type="text" class="form-control" id="profcert_cert_num2" placeholder="Certificate Number"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Name of Institution 3</code>
                                                        <input type="text" value="<?php echo $profcert_name3;  ?>" class="form-control" id="profcert_name3" placeholder="Name of Institution"/>
                                                    </div>
                                                    <div>
                                                        <code> Start Year </code>
                                                        <input type="date" value="<?php echo $profcert_start_yr3;  ?>" class="form-control" id="profcert_start_yr3" placeholder="Start Year"/>
                                                    </div>
                                                    <div>
                                                        <code> End Year </code>
                                                        <input type="date" value="<?php echo $profcert_end_yr3;  ?>" class="form-control" id="profcert_end_yr3" placeholder="End Year"/>
                                                    </div>
                                                    <div>
                                                        <code> Certificate Obtained </code>
                                                        <input type="text" value="<?php echo $profcert_cert_obt3;  ?>" class="form-control" id="profcert_cert_obt3" placeholder="Certificate Obtained"/>
                                                    </div>                                                    
                                                    <div>
                                                        <code> Certificate Number </code>
                                                        <input value="<?php echo $profcert_cert_num3;  ?>" type="text" class="form-control" id="profcert_cert_num3" placeholder="Certificate Number"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>
                                                                                                                                                        
                                        </div>

                                        
                                        

                                        <div>
                                            
                                            <div class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" id="adhoc_staff_profcert_bt">Submit</div>
                                        </div>
                                    </form>
                                </div>
                            </div>                        
                            <!-- END WIZARD WITH VALIDATION -->

                        </div>

                        

                    </div>
                    
                </div>
                <!-- PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        
        <?php $this->load->view('wp-includes/footer'); ?>
        
        <!-- THIS PAGE PLUGINS -->    
        
        <script type='text/javascript' src='<?php echo base_url(); ?>gsi-assets/js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/smartwizard/jquery.smartWizard-2.0.min.js"></script>        
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/jquery-validation/jquery.validate.js"></script>


        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/bootstrap/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/bootstrap/bootstrap-timepicker.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/bootstrap/bootstrap-colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
        
        <!-- END PAGE PLUGINS -->
        
        <!-- START TEMPLATE -->
        <!-- <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/settings.js"></script> -->
        
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins.js"></script>        
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/actions.js"></script>        
        <!-- END TEMPLATE -->

       

        <script>
            var stateval = $("#nig_states").val();
            var lgaval = $("#lgaval").val();
            if(stateval != '0')
                load_lga(stateval,lgaval);
            

            
            var destination = "<?php echo base_url() ?>"+'Trainee/post_enroll_adhoc';
            var imageAttached = false;
            var imageDataURI = '';
            var imgpostcount = 0;

            $("#basic_adhoc_staff_information_handle").click(function()
            {
                basic_adhoc_staff_information();
            });

            $("#adhoc_staff_education_handle").click(function()
            {
                adhoc_staff_education();
            });

            $("#adhoc_staff_family_handle").click(function()
            {
                adhoc_staff_family();
            });

            $("#adhoc_staff_profcert_handle").click(function()
            {
                adhoc_staff_profcert();
            });

            

            

            function adhoc_staff_profcert()
            {
                $("#adhoc_staff_profcert_handle").addClass("active");
                $("#adhoc_staff_education_handle").removeClass("active");
                $("#basic_adhoc_staff_information_handle").removeClass("active");
                $("#adhoc_staff_family_handle").removeClass("active");
                
                $("#adhoc_staff_education").addClass("hidden");
                $("#basic_adhoc_staff_information").addClass("hidden");
                $("#adhoc_staff_family").addClass("hidden");
                $("#adhoc_staff_profcert").removeClass("hidden");
                
            }

            function adhoc_staff_education()
            {
                $("#adhoc_staff_education_handle").addClass("active");
                $("#basic_adhoc_staff_information_handle").removeClass("active");
                $("#adhoc_staff_profcert_handle").removeClass("active");
                $("#adhoc_staff_family_handle").removeClass("active");

                
                $("#basic_adhoc_staff_information").addClass("hidden");
                $("#adhoc_staff_profcert").addClass("hidden"); 
                $("#adhoc_staff_family").addClass("hidden");                
                $("#adhoc_staff_education").removeClass("hidden");
            }

            function adhoc_staff_family()
            {
                $("#adhoc_staff_family_handle").addClass("active");
                $("#adhoc_staff_education_handle").removeClass("active");
                $("#basic_adhoc_staff_information_handle").removeClass("active");
                $("#adhoc_staff_profcert_handle").removeClass("active");

                
                $("#basic_adhoc_staff_information").addClass("hidden");
                $("#adhoc_staff_profcert").addClass("hidden");                
                $("#adhoc_staff_education").addClass("hidden");
                $("#adhoc_staff_family").removeClass("hidden");
            }

            function basic_adhoc_staff_information()
            {
                $("#basic_adhoc_staff_information_handle").addClass("active");
                $("#adhoc_staff_education_handle").removeClass("active");
                $("#adhoc_staff_profcert_handle").removeClass("active");
                $("#adhoc_staff_family_handle").removeClass("active");

                $("#adhoc_staff_education").addClass("hidden");
                $("#adhoc_staff_profcert").addClass("hidden");            
                $("#adhoc_staff_family").addClass("hidden");                
                $("#basic_adhoc_staff_information").removeClass("hidden");
            }

            function load_lga(state,lgaval)
            {
                //alert(state);
                switch (state) 
                {
                  case "Abia State":
                    var data = ['Select L.G.A', 'Aba North', 'Aba South', 'Arochukwu', 'Bende', 'Ikwuano', 'Isiala Ngwa North', 'Isiala Ngwa South', 'Isuikwuato', 'Obi Ngwa', 'Ohafia', 'Osisioma', 'Ugwunagbo', 'Ukwa East', 'Ukwa West', 'Umuahia North', 'muahia South', 'Umu Nneochi']; 
                     break;
                   
                   case "Adamawa State":
                    var data = ['Select L.G.A', 'Demsa', 'Fufure', 'Ganye', 'Gayuk', 'Gombi', 'Grie', 'Hong', 'Jada', 'Larmurde', 'Madagali', 'Maiha', 'Mayo Belwa', 'Michika', 'Mubi North', 'Mubi South', 'Numan', 'Shelleng', 'Song', 'Toungo', 'Yola North', 'Yola South'];
                     break;
                      case "Akwa Ibom State":
                    var data = ['Select L.G.A', 'Abak', 'Eastern Obolo', 'Eket', 'Esit Eket', 'Essien Udim', 'Etim Ekpo', 'Etinan', 'Ibeno', 'Ibesikpo Asutan', 'Ibiono-Ibom', 'Ika', 'Ikono', 'Ikot Abasi', 'Ikot Ekpene', 'Ini', 'Itu', 'Mbo', 'Mkpat-Enin', 'Nsit-Atai', 'Nsit-Ibom', 'Nsit-Ubium', 'Obot Akara', 'Okobo', 'Onna', 'Oron', 'Oruk Anam', 'Udung-Uko', 'Ukanafun', 'Uruan', 'Urue-Offong Oruko', 'Uyo'];
                     break;
                     case "Anambra State":
                    var data = ['Select L.G.A', 'Aguata', 'Anambra East', 'Anambra West', 'Anaocha', 'Awka North', 'Awka South', 'Ayamelum', 'Dunukofia', 'Ekwusigo', 'Idemili North', 'Idemili South', 'Ihiala', 'Njikoka', 'Nnewi North', 'Nnewi South', 'Ogbaru', 'Onitsha North', 'Onitsha South', 'Orumba North', 'Orumba South', 'Oyi'];
                     break;

                      case "Bauchi State":
                    var data = ['Select L.G.A', 'Alkaleri', 'Bauchi', 'Bogoro', 'Damban', 'Darazo', 'Dass', 'Gamawa', 'Ganjuwa', 'Giade', 'Itas-Gadau', 'Jama are', 'Katagum', 'Kirfi', 'Misau', 'Ningi', 'Shira', 'Tafawa Balewa', ' Toro', ' Warji', ' Zaki'];

                     break;
                     
                     case "Bayelsa State":
                    var data = ['Select L.G.A', 'Brass', 'Ekeremor', 'Kolokuma Opokuma', 'Nembe', 'Ogbia', 'Sagbama', 'Southern Ijaw', 'Yenagoa'];

                     break;
                     case "Benue State":
                    var data = ['Select L.G.A', 'Agatu', 'Apa', 'Ado', 'Buruku', 'Gboko', 'Guma', 'Gwer East', 'Gwer West', 'Katsina-Ala', 'Konshisha', 'Kwande', 'Logo', 'Makurdi', 'Obi', 'Ogbadibo', 'Ohimini', 'Oju', 'Okpokwu', 'Oturkpo', 'Tarka', 'Ukum', 'Ushongo', 'Vandeikya'];

                     break;
                     case "Borno State":
                    var data =  ['Select L.G.A', 'Abadam', 'Askira-Uba', 'Bama', 'Bayo', 'Biu', 'Chibok', 'Damboa', 'Dikwa', 'Gubio', 'Guzamala', 'Gwoza', 'Hawul', 'Jere', 'Kaga', 'Kala-Balge', 'Konduga', 'Kukawa', 'Kwaya Kusar', 'Mafa', 'Magumeri', 'Maiduguri', 'Marte', 'Mobbar', 'Monguno', 'Ngala', 'Nganzai', 'Shani'];

                     break;
                     case "Cross River State":
                    var data =  ['Select L.G.A', 'Abi', 'Akamkpa', 'Akpabuyo', 'Bakassi', 'Bekwarra', 'Biase', 'Boki', 'Calabar Municipal', 'Calabar South', 'Etung', 'Ikom', 'Obanliku', 'Obubra', 'Obudu', 'Odukpani', 'Ogoja', 'Yakuur', 'Yala'];

                     break;
                     
                     case "Delta State":
                    var data =  ['Select L.G.A', 'Aniocha North', 'Aniocha South', 'Bomadi', 'Burutu', 'Ethiope East', 'Ethiope West', 'Ika North East', 'Ika South', 'Isoko North', 'Isoko South', 'Ndokwa East', 'Ndokwa West', 'Okpe', 'Oshimili North', 'Oshimili South', 'Patani', 'Sapele', 'Udu', 'Ughelli North', 'Ughelli South', 'Ukwuani', 'Uvwie', 'Warri North', 'Warri South', 'Warri South West'];

                     break;
                     
                     case "Ebonyi State":
                    var data = ['Select L.G.A', 'Abakaliki', 'Afikpo North', 'Afikpo South', 'Ebonyi', 'Ezza North', 'Ezza South', 'Ikwo', 'Ishielu', 'Ivo', 'Izzi', 'Ohaozara', 'Ohaukwu', 'Onicha'];
                     break;
                     case "Edo State":
                    var data = ['Select L.G.A', 'Akoko-Edo', 'Egor', 'Esan Central', 'Esan North-East', 'Esan South-East', 'Esan West', 'Etsako Central', 'Etsako East', 'Etsako West', 'Igueben', 'Ikpoba Okha', 'Orhionmwon', 'Oredo', 'Ovia North-East', 'Ovia South-West', 'Owan East', 'Owan West', 'Uhunmwonde'];
                     break;
                     
                      case "Ekiti State":
                    var data = ['Select L.G.A', 'Ado Ekiti', 'Efon', 'Ekiti East', 'Ekiti South-West', 'Ekiti West', 'Emure', 'Gbonyin', 'Ido Osi', 'Ijero', 'Ikere', 'Ikole', 'Ilejemeje', 'Irepodun-Ifelodun', 'Ise-Orun', 'Moba', 'Oye'];
                     break;
                      case "Rivers State":
                    var data = ['Select L.G.A', 'Port Harcourt', 'Obio-Akpor', 'Okrika', 'Ogu–Bolo', 'Eleme', 'Tai', 'Gokana', 'Khana', 'Oyigbo', 'Opobo–Nkoro', 'Andoni', 'Bonny', 'Degema', 'Asari-Toru', 'Akuku-Toru', 'Abua–Odual', 'Ahoada West', 'Ahoada East', 'Ogba–Egbema–Ndoni', 'Emohua', 'Ikwerre', 'Etche', 'Omuma'];
                     break;
                     case "Enugu State":
                    var data =  ['Select L.G.A', 'Aninri', 'Awgu', 'Enugu East', 'Enugu North', 'Enugu South', 'Ezeagu', 'Igbo Etiti', 'Igbo Eze North', 'Igbo Eze South', 'Isi Uzo', 'Nkanu East', 'Nkanu West', 'Nsukka', 'Oji River', 'Udenu', 'Udi', 'Uzo Uwani'];
                     break;
                     case "F C T":
                    var data =  ['Select L.G.A', 'Abaji', 'Bwari', 'Gwagwalada', 'Kuje', 'Kwali', 'Municipal Area Council'];
                     break;
                     case "Gombe State":
                    var data =   ['Select L.G.A', 'Akko', 'Balanga', 'Billiri', 'Dukku', 'Funakaye', 'Gombe', 'Kaltungo', 'Kwami', 'Nafada', 'Shongom', 'Yamaltu-Deba'];
                     break;
                     case "Imo State":
                    var data =   ['Select L.G.A', 'Aboh Mbaise', 'Ahiazu Mbaise', 'Ehime Mbano', 'Ezinihitte', 'Ideato North', 'Ideato South', 'Ihitte-Uboma', 'Ikeduru', 'Isiala Mbano', 'Isu', 'Mbaitoli', 'Ngor Okpala', 'Njaba', 'Nkwerre', 'Nwangele', 'Obowo', 'Oguta', 'Ohaji-Egbema', 'Okigwe', 'Orlu', 'Orsu', 'Oru East', 'Oru West', 'Owerri Municipal', 'Owerri North', 'Owerri West', 'Unuimo'];
                     break;
                     case "Jigawa State":
                    var data =   ['Select L.G.A', 'Auyo', 'Babura', 'Biriniwa', 'Birnin Kudu', 'Buji', 'Dutse', 'Gagarawa', 'Garki', 'Gumel', 'Guri', 'Gwaram', 'Gwiwa', 'Hadejia', 'Jahun', 'Kafin Hausa', 'Kazaure', 'Kiri Kasama', 'Kiyawa', 'Kaugama', 'Maigatari', 'Malam Madori', 'Miga', 'Ringim', 'Roni', 'Sule Tankarkar', 'Taura', 'Yankwashi'];
                     break;
                      case "Kaduna State":
                    var data =  ['Select L.G.A', 'Birnin Gwari', 'Chikun', 'Giwa', 'Igabi', 'Ikara', 'Jaba', 'Jema a', 'Kachia', 'Kaduna North', 'Kaduna South', 'Kagarko', 'Kajuru', 'Kaura', 'Kauru', 'Kubau', 'Kudan', 'Lere', 'Makarfi', 'Sabon Gari', 'Sanga', 'Soba', 'Zangon Kataf', 'Zaria'];
                     break;
                     case "Kano State":
                    var data = ['Select L.G.A', 'Ajingi', 'Albasu', 'Bagwai', 'Bebeji', 'Bichi', 'Bunkure', 'Dala', 'Dambatta', 'Dawakin Kudu', 'Dawakin Tofa', 'Doguwa', 'Fagge', 'Gabasawa', 'Garko', 'Garun Mallam', 'Gaya', 'Gezawa', 'Gwale', 'Gwarzo', 'Kabo', 'Kano Municipal', 'Karaye', 'Kibiya', 'Kiru', 'Kumbotso', 'Kunchi', 'Kura', 'Madobi', 'Makoda', 'Minjibir', 'Nasarawa', 'Rano', 'Rimin Gado', 'Rogo', 'Shanono', 'Sumaila', 'Takai', 'Tarauni', 'Tofa', 'Tsanyawa', 'Tudun Wada', 'Ungogo', 'Warawa', 'Wudil'];
                     break;
                     case "Katsina State":
                    var data = ['Select L.G.A', 'Bakori', 'Batagarawa', 'Batsari', 'Baure', 'Bindawa', 'Charanchi', 'Dandume', 'Danja', 'Dan Musa', 'Daura', 'Dutsi', 'Dutsin Ma', 'Faskari', 'Funtua', 'Ingawa', 'Jibia', 'Kafur', 'Kaita', 'Kankara', 'Kankia', 'Katsina', 'Kurfi', 'Kusada', 'Mai Adua', 'Malumfashi', 'Mani', 'Mashi', 'Matazu', 'Musawa', 'Rimi', 'Sabuwa', 'Safana', 'Sandamu', 'Zango'];
                     break;
                     case "Kebbi State":
                    var data =  ['Select L.G.A', 'Aleiro', 'Arewa Dandi', 'Argungu', 'Augie', 'Bagudo', 'Birnin Kebbi', 'Bunza', 'Dandi', 'Fakai', 'Gwandu', 'Jega', 'Kalgo', 'Koko Besse', 'Maiyama', 'Ngaski', 'Sakaba', 'Shanga', 'Suru', 'Wasagu Danko', 'Yauri', 'Zuru'];
                     break;
                     case "Kogi State":
                    var data =  ['Select L.G.A', 'Adavi', 'Ajaokuta', 'Ankpa', 'Bassa', 'Dekina', 'Ibaji', 'Idah', 'Igalamela Odolu', 'Ijumu', 'Kabba Bunu', 'Kogi', 'Lokoja', 'Mopa Muro', 'Ofu', 'Ogori Magongo', 'Okehi', 'Okene', 'Olamaboro', 'Omala', 'Yagba East', 'Yagba West'];
                     break;
                     case "Kwara State":
                    var data =  ['Select L.G.A', 'Asa', 'Baruten', 'Edu', 'Ekiti', 'Ifelodun', 'Ilorin East', 'Ilorin South', 'Ilorin West', 'Irepodun', 'Isin', 'Kaiama', 'Moro', 'Offa', 'Oke Ero', 'Oyun', 'Pategi'];
                     break;
                     case "Lagos State":
                    var data = ['Select L.G.A', 'Agege', 'Ajeromi-Ifelodun', 'Alimosho', 'Amuwo-Odofin', 'Apapa', 'Badagry', 'Epe', 'Eti Osa', 'Ibeju-Lekki', 'Ifako-Ijaiye', 'Ikeja', 'Ikorodu', 'Kosofe', 'Lagos Island', 'Lagos Mainland', 'Mushin', 'Ojo', 'Oshodi-Isolo', 'Shomolu', 'Surulere'];
                     break;
                     case "Nasarawa State":
                    var data = ['Select L.G.A', 'Akwanga', 'Awe', 'Doma', 'Karu', 'Keana', 'Keffi', 'Kokona', 'Lafia', 'Nasarawa', 'Nasarawa Egon', 'Obi', 'Toto', 'Wamba'];
                     break;
                     case "Niger State":
                    var data = ['Select L.G.A', 'Agaie', 'Agwara', 'Bida', 'Borgu', 'Bosso', 'Chanchaga', 'Edati', 'Gbako', 'Gurara', 'Katcha', 'Kontagora', 'Lapai', 'Lavun', 'Magama', 'Mariga', 'Mashegu', 'Mokwa', 'Moya', 'Paikoro', 'Rafi', 'Rijau', 'Shiroro', 'Suleja', 'Tafa', 'Wushishi'];
                     break;
                     case "Ogun State":
                    var data = ['Select L.G.A', 'Abeokuta North', 'Abeokuta South', 'Ado-Odo Ota', 'Egbado North', 'Egbado South', 'Ewekoro', 'Ifo', 'Ijebu East', 'Ijebu North', 'Ijebu North East', 'Ijebu Ode', 'Ikenne', 'Imeko Afon', 'Ipokia', 'Obafemi Owode', 'Odeda', 'Odogbolu', 'Ogun Waterside', 'Remo North', 'Shagamu'];
                     break;
                     case "Ondo State":
                    var data = ['Select L.G.A', 'Akoko North-East', 'Akoko North-West', 'Akoko South-West', 'Akoko South-East', 'Akure North', 'Akure South', 'Ese Odo', 'Idanre', 'Ifedore', 'Ilaje', 'Ile Oluji-Okeigbo', 'Irele', 'Odigbo', 'Okitipupa', 'Ondo East', 'Ondo West', 'Ose', 'Owo'];
                     break;
                     case "Osun State":
                    var data = ['Select L.G.A', 'Atakunmosa East', 'Atakunmosa West', 'Aiyedaade', 'Aiyedire', 'Boluwaduro', 'Boripe', 'Ede North', 'Ede South', 'Ife Central', 'Ife East', 'Ife North', 'Ife South', 'Egbedore', 'Ejigbo', 'Ifedayo', 'Ifelodun', 'Ila', 'Ilesa East', 'Ilesa West', 'Irepodun', 'Irewole', 'Isokan', 'Iwo', 'Obokun', 'Odo Otin', 'Ola Oluwa', 'Olorunda', 'Oriade', 'Orolu', 'Osogbo'];
                     break;
                     case "Oyo State":
                    var data = ['Select L.G.A', 'Afijio', 'Akinyele', 'Atiba', 'Atisbo', 'Egbeda', 'Ibadan North', 'Ibadan North-East', 'Ibadan North-West', 'Ibadan South-East', 'Ibadan South-West', 'Ibarapa Central', 'Ibarapa East', 'Ibarapa North', 'Ido', 'Irepo', 'Iseyin', 'Itesiwaju', 'Iwajowa', 'Kajola', 'Lagelu', 'Ogbomosho North', 'Ogbomosho South', 'Ogo Oluwa', 'Olorunsogo', 'Oluyole', 'Ona Ara', 'Orelope', 'Ori Ire', 'Oyo', 'Oyo East', 'Saki East', 'Saki West', 'Surulere'];
                     break;
                      case "Plateau State":
                    var data = ['Select L.G.A', 'Bokkos', 'Barkin Ladi', 'Bassa', 'Jos East', 'Jos North', 'Jos South', 'Kanam', 'Kanke', 'Langtang South', 'Langtang North', 'Mangu', 'Mikang', 'Pankshin', 'Qua an Pan', 'Riyom', 'Shendam', 'Wase'];
                     break;
                       case "Sokoto State":
                    var data = ['Select L.G.A', 'Binji', 'Bodinga', 'Dange Shuni', 'Gada', 'Goronyo', 'Gudu', 'Gwadabawa', 'Illela', 'Isa', 'Kebbe', 'Kware', 'Rabah', 'Sabon Birni', 'Shagari', 'Silame', 'Sokoto North', 'Sokoto South', 'Tambuwal', 'Tangaza', 'Tureta', 'Wamako', 'Wurno', 'Yabo'];
                     break;
                       case "Taraba State":
                    var data =  ['Select L.G.A', 'Ardo Kola', 'Bali', 'Donga', 'Gashaka', 'Gassol', 'Ibi', 'Jalingo', 'Karim Lamido', 'Kumi', 'Lau', 'Sardauna', 'Takum', 'Ussa', 'Wukari', 'Yorro', 'Zing'];
                     break;
                      case "Yobe State":
                    var data =   ['Select L.G.A', 'Bade', 'Bursari', 'Damaturu', 'Fika', 'Fune', 'Geidam', 'Gujba', 'Gulani', 'Jakusko', 'Karasuwa', 'Machina', 'Nangere', 'Nguru', 'Potiskum', 'Tarmuwa', 'Yunusari', 'Yusufari'];
                     break;
                      case "Zamfara State":
                    var data =   ['Select L.G.A', 'Anka', 'Bakura', 'Birnin Magaji Kiyaw', 'Bukkuyum', 'Bungudu', 'Gummi', 'Gusau', 'Kaura Namoda', 'Maradun', 'Maru', 'Shinkafi', 'Talata Mafara', 'Chafe', 'Zurmi'];
                   
                   }
                    
                    

              
                var i;
                var html = [];
                //loop through the array
                for (var i = 0; i < data.length; i++) {//begin for loop

                  //add the option elements to the html array
                  if(lgaval == data[i])
                    html.push("<option value="+ data[i] +" selected>" + data[i] + "</option>")
                  else  
                    html.push("<option value="+ data[i] +">" + data[i] + "</option>")
                  

                }//end for loop

                //add the option values to the select list with an id of lga
                document.getElementById("lga").innerHTML = html.join('');
                //$('#lga').Selectpicker('refresh');
                
            }

         $("#basic_adhoc_staff_information_bt").click(function ()
         {
                pageLoadingFrame("show");
                    setTimeout(function(){
                        pageLoadingFrame("hide");
                    },1500);

                var surname = $("#surname").val();
                var firstname = $("#firstname").val();
                var phone = $("#phone").val();
                var email = $("#email").val();
                var lastname = $("#lastname").val();
                var gender = $("#gender").val();
                var marital_status = $("#marital_status").val();
                var dob = $("#dob").val();
                var birth_place = $("#birth_place").val();
                var street = $("#street").val();
                var city = $("#city").val();
                var role = $("#role").val();

                var center_name = $("#center_name").val();
                var nig_states = $("#nig_states").val();
                var lga = $("#lga").val();
                
                var trans = $("#traineeID").val();
                //alert(center_name +' - '+nig_states+' - '+village);
                var photo = document.getElementById("snapshot").innerHTML;
                var init_photo = '<?php echo $init_photo; ?>';

                if(imageAttached || init_photo)
                {
                    if((surname !='') && (nig_states != 0) && (email != ''))
                    {
                        $.post(destination,
                        {
                          logger_save: "logger_ext_post",
                          surname :surname,
                          firstname :firstname,
                          phone :phone,
                          email :email,
                          lastname :lastname,
                          gender :gender,
                          marital_status :marital_status,
                          dob :dob,
                          birth_place :birth_place,                      
                          city :city,
                          role :role,

                          village :street,
                          center_name :center_name,
                          nig_states :nig_states,
                          lga :lga,
                          dtrans: trans,
                          record_type: "basic_adhoc_staff_information"
                        })
                        .done(function (data) 
                        {                       
                            
                          if(data != undefined)
                          {
                            //alert(data);
                            if(data.length > 0)
                            {
                                data = JSON.parse(data);
                                if(data[0] == '1')
                                {
                                    $("#basic_adhoc_staff_information_handle").append('<i class="fa fa-check-square-o" style="font-size: 10px; color: #006400 !important; "></i>');
                                    $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Saved Successfully</strong></div>');   
                                    $("#traineeID").val(data[1]);   
                                    if(imageDataURI != '')
                                    {
                                        postImage();
                                    }                       
                                    //adhoc_staff_family();
                                }
                                else if(data == '2')
                                {
                                    $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Updated Successfully</strong></div>');   
                                    if(imageDataURI != '')
                                    {
                                        postImage();
                                    }                                                        
                                    //adhoc_staff_family();
                                }
                                else if(data == '-1')
                                {
                                    $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fields are empty!</strong></div>');
                                }
                                else if(data == '01')
                                {
                                    $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong, record could not be saved!</strong></div>');
                                }
                                else if(data == '-200')
                                {
                                    $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record holder not known!</strong></div>');
                                }                           

                            }
                          }
                          //alert(data);

                        });
                    }
                    else
                    {
                        $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fields are empty!</strong></div>');
                    }
                }
                else
                {
                    $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Please Capture Adhoc Staff Photo!</strong></div>');
                }
                

         });

        $("#adhoc_staff_family_bt").click(function ()
         {
                pageLoadingFrame("show");
                    setTimeout(function(){
                        pageLoadingFrame("hide");
                    },1500);

                var spouse_state = $("#spouse_state").val();
                var spouse_name = $("#spouse_name").val();
                var father_state = $("#father_state").val();
                var father_name = $("#father_name").val();
                var mother_name = $("#mother_name").val();
                var mother_state = $("#mother_state").val();

                var center_name = $("#center_name").val();
                var nig_states = $("#nig_states").val();
                var lga = $("#lga").val();
                
                var trans = $("#traineeID").val();
                //alert(center_name +' - '+nig_states+' - '+village);
                if((father_name !='') && (nig_states != 0) && (mother_name != ''))
                {
                    $.post(destination,
                    {
                      logger_save: "logger_ext_post",
                      spouse_state : spouse_state,
                      spouse_name : spouse_name,
                      father_state : father_state,
                      father_name : father_name,
                      mother_name : mother_name,
                      mother_state : mother_state,

                      village :lga,
                      center_name :center_name,
                      nig_states :nig_states,
                      dtrans: trans,
                      record_type: "adhoc_staff_family"
                    })
                    .done(function (data) 
                    {                       
                        
                      if(data != undefined)
                      {
                        //alert(data);
                        if(data.length > 0)
                        {
                            data = JSON.parse(data);
                            if(data[0] == '1')
                            {
                                $("#basic_adhoc_staff_information_handle").append('<i class="fa fa-check-square-o" style="font-size: 10px; color: #006400 !important; "></i>');
                                $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Saved Successfully</strong></div>');   
                                $("#traineeID").val(data[1]);   
                                /*if(imageDataURI != '')
                                {
                                    postImage();
                                } */                      
                                adhoc_staff_education();
                            }
                            else if(data == '2')
                            {
                                $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Updated Successfully</strong></div>');   
                                /*if(imageDataURI != '')
                                {
                                    postImage();
                                }*/                                                        
                                adhoc_staff_education();
                            }
                            else if(data == '-1')
                            {
                                $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fields are empty!</strong></div>');
                            }
                            else if(data == '01')
                            {
                                $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong, record could not be saved!</strong></div>');
                            }
                            else if(data == '-200')
                            {
                                $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record holder not known!</strong></div>');
                            }                           

                        }
                      }
                      //alert(data);

                    });
                }
                else
                {
                    $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fieldss are empty!</strong></div>');
                }
                

         });


        $("#adhoc_staff_education_bt").click(function ()
         {
                pageLoadingFrame("show");
                    setTimeout(function(){
                        pageLoadingFrame("hide");
                    },1500);

                var pry_name1 = $("#pry_name1").val(); 
                var sec_name1 = $("#sec_name1").val(); 
                var tert_name1 = $("#tert_name1").val();
                var pry_name2 = $("#pry_name2").val(); 
                var sec_name2 = $("#sec_name2").val(); 
                var tert_name2 = $("#tert_name2").val();
                var pry_name3 = $("#pry_name3").val(); 
                var sec_name3 = $("#sec_name3").val(); 
                var tert_name3 = $("#tert_name3").val();

                var pry_start_yr1 = $("#pry_start_yr1").val(); 
                var sec_start_yr1 = $("#sec_start_yr1").val(); 
                var tert_start_yr1 = $("#tert_start_yr1").val();
                var pry_start_yr2 = $("#pry_start_yr2").val(); 
                var sec_start_yr2 = $("#sec_start_yr2").val(); 
                var tert_start_yr2 = $("#tert_start_yr2").val();
                var pry_start_yr3 = $("#pry_start_yr3").val(); 
                var sec_start_yr3 = $("#sec_start_yr3").val(); 
                var tert_start_yr3 = $("#tert_start_yr3").val();

                var pry_end_yr1 = $("#pry_end_yr1").val(); 
                var sec_end_yr1 = $("#sec_end_yr1").val(); 
                var tert_end_yr1 = $("#tert_end_yr1").val();
                var pry_end_yr2 = $("#pry_end_yr2").val(); 
                var sec_end_yr2 = $("#sec_end_yr2").val(); 
                var tert_end_yr2 = $("#tert_end_yr2").val();
                var pry_end_yr3 = $("#pry_end_yr3").val(); 
                var sec_end_yr3 = $("#sec_end_yr3").val(); 
                var tert_end_yr3 = $("#tert_end_yr3").val();

                var pry_cert_obt1 = $("#pry_cert_obt1").val(); 
                var sec_cert_obt1 = $("#sec_cert_obt1").val(); 
                var tert_cert_obt1 = $("#tert_cert_obt1").val();
                var pry_cert_obt2 = $("#pry_cert_obt2").val(); 
                var sec_cert_obt2 = $("#sec_cert_obt2").val(); 
                var tert_cert_obt2 = $("#tert_cert_obt2").val();
                var pry_cert_obt3 = $("#pry_cert_obt3").val(); 
                var sec_cert_obt3 = $("#sec_cert_obt3").val(); 
                var tert_cert_obt3 = $("#tert_cert_obt3").val();

                var pry_cert_num1 = $("#pry_cert_num1").val(); 
                var sec_cert_num1 = $("#sec_cert_num1").val(); 
                var tert_cert_num1 = $("#tert_cert_num1").val();
                var pry_cert_num2 = $("#pry_cert_num2").val(); 
                var sec_cert_num2 = $("#sec_cert_num2").val(); 
                var tert_cert_num2 = $("#tert_cert_num2").val();
                var pry_cert_num3 = $("#pry_cert_num3").val(); 
                var sec_cert_num3 = $("#sec_cert_num3").val(); 
                var tert_cert_num3 = $("#tert_cert_num3").val();

                var nysc_period = $("#nysc_period").val();
                var nysc_service_place = $("#nysc_service_place").val();
                var nysc_discharge_date = $("#nysc_discharge_date").val();
                var nysc_certifcate_num = $("#nysc_certifcate_num").val();

                var center_name = $("#center_name").val();
                var nig_states = $("#nig_states").val();
                var lga = $("#lga").val();
                
                var trans = $("#traineeID").val();
                //alert(center_name +' - '+nig_states+' - '+village);
                if((pry_name1 !='') && (sec_name1 != 0) && (center_name != ''))
                {
                    $.post(destination,
                    {
                      logger_save: "logger_ext_post",
                      pry_name1 : pry_name1, 
                        sec_name1 : sec_name1, 
                        tert_name1 : tert_name1,
                        pry_name2 : pry_name2, 
                        sec_name2 : sec_name2, 
                        tert_name2 : tert_name2,
                        pry_name3 : pry_name3, 
                        sec_name3 : sec_name3, 
                        tert_name3 : tert_name3,

                        pry_start_yr1 : pry_start_yr1, 
                        sec_start_yr1 : sec_start_yr1, 
                        tert_start_yr1 : tert_start_yr1,
                        pry_start_yr2 : pry_start_yr2, 
                        sec_start_yr2 : sec_start_yr2, 
                        tert_start_yr2 : tert_start_yr2,
                        pry_start_yr3 : pry_start_yr3, 
                        sec_start_yr3 : sec_start_yr3, 
                        tert_start_yr3 : tert_start_yr3,

                        pry_end_yr1 : pry_end_yr1, 
                        sec_end_yr1 : sec_end_yr1, 
                        tert_end_yr1 : tert_end_yr1,
                        pry_end_yr2 : pry_end_yr2, 
                        sec_end_yr2 : sec_end_yr2, 
                        tert_end_yr2 : tert_end_yr2,
                        pry_end_yr3 : pry_end_yr3, 
                        sec_end_yr3 : sec_end_yr3, 
                        tert_end_yr3 : tert_end_yr3,

                        pry_cert_obt1 : pry_cert_obt1, 
                        sec_cert_obt1 : sec_cert_obt1, 
                        tert_cert_obt1 : tert_cert_obt1,
                        pry_cert_obt2 : pry_cert_obt2, 
                        sec_cert_obt2 : sec_cert_obt2, 
                        tert_cert_obt2 : tert_cert_obt2,
                        pry_cert_obt3 : pry_cert_obt3, 
                        sec_cert_obt3 : sec_cert_obt3, 
                        tert_cert_obt3 : tert_cert_obt3,

                        pry_cert_num1 : pry_cert_num1, 
                        sec_cert_num1 : sec_cert_num1, 
                        tert_cert_num1 : tert_cert_num1,
                        pry_cert_num2 : pry_cert_num2, 
                        sec_cert_num2 : sec_cert_num2, 
                        tert_cert_num2 : tert_cert_num2,
                        pry_cert_num3 : pry_cert_num3, 
                        sec_cert_num3 : sec_cert_num3, 
                        tert_cert_num3 : tert_cert_num3,

                        nysc_period : nysc_period,
                        nysc_service_place : nysc_service_place,
                        nysc_discharge_date : nysc_discharge_date,
                        nysc_certifcate_num : nysc_certifcate_num,


                      village :lga,
                      center_name :center_name,
                      nig_states :nig_states,
                      dtrans: trans,
                      record_type: "adhoc_staff_education"
                    })
                    .done(function (data) 
                    {                       
                        
                      if(data != undefined)
                      {
                        //alert(data);
                        if(data.length > 0)
                        {
                            data = JSON.parse(data);
                            if(data[0] == '1')
                            {
                                $("#basic_adhoc_staff_information_handle").append('<i class="fa fa-check-square-o" style="font-size: 10px; color: #006400 !important; "></i>');
                                $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Saved Successfully</strong></div>');   
                                $("#traineeID").val(data[1]);   
                                /*if(imageDataURI != '')
                                {
                                    postImage();
                                } */                      
                                adhoc_staff_profcert();
                            }
                            else if(data == '2')
                            {
                                $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Updated Successfully</strong></div>');   
                                /*if(imageDataURI != '')
                                {
                                    postImage();
                                }*/                                                        
                                adhoc_staff_profcert();
                            }
                            else if(data == '-1')
                            {
                                $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fields are empty!</strong></div>');
                            }
                            else if(data == '01')
                            {
                                $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong, record could not be saved!</strong></div>');
                            }
                            else if(data == '-200')
                            {
                                $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record holder not known!</strong></div>');
                            }                           

                        }
                      }
                      //alert(data);

                    });
                }
                else
                {
                    $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fieldss are empty!</strong></div>');
                }
                

         });
        
        
        $("#adhoc_staff_profcert_bt").click(function ()
         {
                pageLoadingFrame("show");
                    setTimeout(function(){
                        pageLoadingFrame("hide");
                    },1500);

                var center_name = $("#center_name").val();
                var nig_states = $("#nig_states").val();
                var lga = $("#lga").val();

                var profcert_name1 = $("#profcert_name1").val();
                var profcert_start_yr1 = $("#profcert_start_yr1").val();
                var profcert_end_yr1 = $("#profcert_end_yr1").val();
                var profcert_cert_obt1 = $("#profcert_cert_obt1").val(); 
                var profcert_cert_num1 = $("#profcert_cert_num1").val();

                var profcert_name2 = $("#profcert_name2").val();
                var profcert_start_yr2 = $("#profcert_start_yr2").val();
                var profcert_end_yr2 = $("#profcert_end_yr2").val();
                var profcert_cert_obt2 = $("#profcert_cert_obt2").val(); 
                var profcert_cert_num2 = $("#profcert_cert_num2").val();

                var profcert_name3 = $("#profcert_name3").val();
                var profcert_start_yr3 = $("#profcert_start_yr3").val();
                var profcert_end_yr3 = $("#profcert_end_yr3").val();
                var profcert_cert_obt3 = $("#profcert_cert_obt3").val(); 
                var profcert_cert_num3 = $("#profcert_cert_num3").val();

                var trans = $("#traineeID").val();
                //alert (qcode+ '-'+tname+ '-'+thumbcode+ '-'+dclerk);                                

                if((center_name !='') && (nig_states != 0) && (profcert_name1 != ''))
                {                    
                    $.post(destination,
                    {
                        logger_save: "logger_ext_post",
                        center_name:center_name,
                        nig_states:nig_states,
                        village:lga,

                        profcert_name1 : profcert_name1,
                        profcert_start_yr1 : profcert_start_yr1,
                        profcert_end_yr1 : profcert_end_yr1,
                        profcert_cert_obt1 : profcert_cert_obt1, 
                        profcert_cert_num1 : profcert_cert_num1,

                        profcert_name2 : profcert_name2,
                        profcert_start_yr2 : profcert_start_yr2,
                        profcert_end_yr2 : profcert_end_yr2,
                        profcert_cert_obt2 : profcert_cert_obt2, 
                        profcert_cert_num2 : profcert_cert_num2,

                        profcert_name3 : profcert_name3,
                        profcert_start_yr3 : profcert_start_yr3,
                        profcert_end_yr3 : profcert_end_yr3,
                        profcert_cert_obt3 : profcert_cert_obt3, 
                        profcert_cert_num3 : profcert_cert_num3,

                        dtrans: trans,
                        record_type: "adhoc_staff_profcert"
                    })
                    .done(function (data) 
                    {                       
                      console.log(data);
                      if(data != undefined)
                      {
                        if(data.length > 0)
                        {
                            data = JSON.parse(data);
                            if(data == '1')
                            {
                                $("#adhoc_staff_profcert_handle").append('<i class="fa fa-check-square-o" style="font-size: 10px; color: #006400 !important; "></i>');
                                $("#adhoc_staff_profcert_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Saved Successfully</strong></div>');                        
                                var redir = "<?php echo base_url() ?>"+'Trainee/adhoc_list/';
                                location.assign(redir);
                            }
                            else if(data == '-1')
                            {
                                $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fields are empty!</strong></div>');
                                basic_adhoc_staff_information();
                            }
                            else if(data == '01')
                            {
                                $("#adhoc_staff_profcert_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong, record could not be saved!</strong></div>');
                            }
                            else if(data == '-200')
                            {
                                $("#adhoc_staff_profcert_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record holder not known!</strong></div>');
                            }                           

                        }
                      }
                      

                    });
                }
                else
                {
                    $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Please Provide Trainee Basic Info!</strong></div>');
                    basic_adhoc_staff_information();
                }
                

         });

        
        

        </script>


        <script>
            // The buttons to start & stop stream and to capture the image
            var btnStart = document.getElementById( "btn-start" );
            var btnStop = document.getElementById( "btn-stop" );
            var btnImageCapture = document.getElementById( "btn-capture" );

            // The stream & capture
            var stream = document.getElementById( "stream" );
            var capture = document.getElementById( "capture" );
            var snapshot = document.getElementById( "snapshot" );

            // The video stream
            var cameraStream = null;

            // Attach listeners
            btnStart.addEventListener( "click", startStreaming );
            btnStop.addEventListener( "click", stopStreaming );
            btnImageCapture.addEventListener( "click", captureSnapshot );

            // Start Streaming
            function startStreaming() {

                $("#btn-stop").removeClass("disabled");
                $("#btn-capture").removeClass("disabled");
                $("#btn-start").addClass("disabled");

                var mediaSupport = 'mediaDevices' in navigator;

                if( mediaSupport && null == cameraStream ) {

                    navigator.mediaDevices.getUserMedia( { video: true } )
                    .then( function( mediaStream ) {

                        cameraStream = mediaStream;

                        stream.srcObject = mediaStream;

                        stream.play();
                    })
                    .catch( function( err ) {

                        console.log( "Unable to access camera: " + err );
                        alert("Unable to access camera");
                    });
                }
                else {

                    alert( 'Your browser does not support media devices.' );

                    return;
                }
            }

            // Stop Streaming
            function stopStreaming() {
                $("#btn-capture").addClass("disabled");
                $("#btn-stop").addClass("disabled");
                $("#btn-start").removeClass("disabled");
                if( null != cameraStream ) {

                    var track = cameraStream.getTracks()[ 0 ];

                    track.stop();
                    stream.load();

                    cameraStream = null;
                }
            }

            function captureSnapshot() {

                if( null != cameraStream ) {

                    var shutter = new Audio();
                    shutter.autoplay = false;
                    //shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' : 'shutter.mp3';
                    shutter.src = '<?php echo base_url()."gsi-assets/audio/shutter.mp3"; ?>';
                    shutter.play();

                    var ctx = capture.getContext( '2d' );
                    var img = new Image();

                    ctx.drawImage( stream, 0, 0, capture.width, capture.height );
                
                    img.src     = capture.toDataURL( "image/jpg" );
                    img.width   = 240;

                    snapshot.innerHTML = '';

                    snapshot.appendChild( img );

                    imageAttached = true;
                    var dataURI = snapshot.firstChild.getAttribute( "src" );
                    imageDataURI = dataURI;
                    
                }
            }


            function postImage()
            {
                //var src = $(this).attr('src');
                var trans = $("#traineeID").val();
                var ddat = {"id": trans, "base64": imageDataURI}; 
                
                $.post(destination,
                {
                    logger_save: "logger_ext_post",
                    postcount: imgpostcount,
                    photoData: ddat
                })
                .done(function (data) 
                {
                    imgpostcount = imgpostcount+1;
                    if(data == '3')
                    {
                        $("#basic_adhoc_staff_information_handle").append('<i class="fa fa-check-square-o" style="font-size: 10px; color: #006400 !important; "></i>');
                        $("#basic_adhoc_staff_information_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Saved Successfully</strong></div>');                            
                        adhoc_staff_family();
                    }
                    else if(data == '-3')
                    {
                        $("#trainee_location_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong, image could not upload!</strong></div>');
                    }
                    else if(data == '2')
                    {
                        $("#trainee_location_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Updated Successfully</strong></div>');   
                                                
                        adhoc_staff_family();
                    }

                    //alert(data);

                });

                

            }

            
        </script>

        



        <!-- my added -->



        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/bootstrap/bootstrap-select.js"></script>

        <script>
            $("#nig_states").change( function()
            {
                stateval = $("#nig_states").val();
                //alert(stateval);
                //console.log(stateval);
                load_lga(stateval,lgaval);
                $('#lga').selectpicker('refresh');
            });
        </script>
            
    
       
    </body>

</html>






