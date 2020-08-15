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
                    <li class="active">Trainee Enrollment</li>
                </ul>
                <!-- END BREADCRUMB --> 
                
                <!-- PAGE TITLE -->
                <div class="page-title">                    
                    <h2><a href="<?php echo base_url(); ?>Trainee/trainee_list"><span class="fa fa-arrow-circle-o-left"></span></a> Trainee Enrollment</h2>
                </div>
                <!-- END PAGE TITLE -->                
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                    <input type="hidden" id="traineeID" value="<?php echo $trans; ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="panel panel-colorful">
                                <div class="panel-body">
                                    <div class="list-group border-bottom">
                                        <a href="#" id="trainee_location_handle" class="list-group-item active">
                                            <span class="sidenumber">1 - </span><i class="glyphicon glyphicon-qrcode"></i> Trainee Location
                                        </a>
                                        <a href="#" id="human_capital_handle" class="list-group-item">
                                            <span class="sidenumber">2 - </span><i class="glyphicon glyphicon-user"></i> Human Capital
                                        </a>
                                        <a href="#" id="social_capital_handle" class="list-group-item">
                                            <span class="sidenumber">3 - </span><i class="glyphicon glyphicon-screenshot"></i> Social Capital
                                        </a>
                                        <a href="#" id="natural_capital_handle" class="list-group-item">
                                            <span class="sidenumber">4 - </span><i class="glyphicon glyphicon-tree-deciduous"></i> Natural Capital
                                        </a>
                                        <a href="#" id="physical_capital_handle" class="list-group-item">
                                            <span class="sidenumber">5 - </span><i class="glyphicon glyphicon-briefcase"></i> Physical Capital
                                        </a>
                                        <a href="#" id="financial_capital_handle" class="list-group-item">
                                            <span class="sidenumber">6 - </span><i class="glyphicon glyphicon-tower"></i> Financial Capital
                                        </a>
                                    </div>                              
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9" id="trainee_location">
                            <div id=trainee_location_msg></div>
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-success">
                                <div class="panel-body">
                                    <h3><i class="glyphicon glyphicon-qrcode"></i> Trainee Location</h3>

                                    <?php

                                        $center_name_ID = $tname = $village = $lga = $phone = $dclerk = $date = $state = $photo = $init_photo = $gps = '';

                                        $thumbcode_ISO_indexleft = $thumbcode_ANSI_indexleft = '';
                                        $thumbcode_ISO_thumbleft = $thumbcode_ANSI_thumbleft = '';

                                        $thumbcode_ISO_indexright = $thumbcode_ANSI_indexright = '';
                                        $thumbcode_ISO_thumbright = $thumbcode_ANSI_thumbright = '';
                                        $mantra_mfs_100_serial = '';

                                        $fingerdata = array();                                       
                                        if(!empty($probe_trainee_fingerprint_info_data) && is_array($probe_trainee_fingerprint_info_data))
                                        {
                                            foreach ($probe_trainee_fingerprint_info_data as $key => $val) 
                                            {
                                                array_push($fingerdata, $val['thumbcode_ISO_indexleft']);
                                                array_push($fingerdata, $val['thumbcode_ISO_thumbleft']);
                                                array_push($fingerdata, $val['thumbcode_ISO_indexright']);
                                                array_push($fingerdata, $val['thumbcode_ISO_thumbright']);

                                            }
                                            
                                        }

                                        echo '<input type="hidden" id="fingerdata" value="'.base64_encode(json_encode($fingerdata)).'">
                                        ';
                                        //var_dump(json_encode($fingerdata));

                                        if(!empty($trainee_fingerprint_info_data) && is_array($trainee_fingerprint_info_data))
                                        {
                                            $thumbcode_ISO_indexleft = $trainee_fingerprint_info_data[0]['thumbcode_ISO_indexleft'];
                                            $thumbcode_ANSI_indexleft = $trainee_fingerprint_info_data[0]['thumbcode_ANSI_indexleft'];
                                            $thumbcode_ISO_thumbleft = $trainee_fingerprint_info_data[0]['thumbcode_ISO_thumbleft'];
                                            $thumbcode_ANSI_thumbleft = $trainee_fingerprint_info_data[0]['thumbcode_ANSI_thumbleft'];

                                            $thumbcode_ISO_indexright = $trainee_fingerprint_info_data[0]['thumbcode_ISO_indexright'];
                                            $thumbcode_ANSI_indexright = $trainee_fingerprint_info_data[0]['thumbcode_ANSI_indexright'];
                                            $thumbcode_ISO_thumbright = $trainee_fingerprint_info_data[0]['thumbcode_ISO_thumbright'];
                                            $thumbcode_ANSI_thumbright = $trainee_fingerprint_info_data[0]['thumbcode_ANSI_thumbright'];
                                            $mantra_mfs_100_serial = $trainee_fingerprint_info_data[0]['mantra_mfs_100_serial'];
                                        }

                                       

                                        if(!empty($trainee_location_data) && is_array($trainee_location_data))
                                        {
                                            $center_name_ID = $trainee_location_data[0]['center_name_ID'];
                                            $tname = $trainee_location_data[0]['name_of_trainee'];
                                            $village = $trainee_location_data[0]['village'];
                                            $lga = $trainee_location_data[0]['lga'];
                                            $state = $trainee_location_data[0]['state'];
                                            $phone = $trainee_location_data[0]['phone'];
                                            $dclerk = $trainee_location_data[0]['data_entry_clerk'];
                                            //$date = $trainee_location_data[0]['date'];
                                            $photo = $trainee_location_data[0]['photo'];
                                            $gps = $trainee_location_data[0]['gps_location'];

                                            /*if(!empty($date))
                                                $date = date('Y-m-d',strtotime($date));*/
                                        }

                                         //$center_name_ID = $dclerk = '1';

                                         if(!empty($_SESSION['result_gate_Data_Entry_Clerk']))
                                            $dclerk = $_SESSION['result_gate_Data_Entry_Clerk'];

                                         if(!empty($_SESSION['result_gate_CENTER_ID']))
                                            $center_name_ID = $_SESSION['result_gate_CENTER_ID'];

                                    ?>                                
                                    <!-- <form action="javascript:alert('Validated!');" role="form" class="form-horizontal" > -->
                                    <!-- <button class="btn btn-primary" onclick="return Capture('verifyfingerprint')">Verify Finger Print</button> -->
                                    <form action="#" role="form" class="form-horizontal" >
                                        <div class="row" style="line-height: 3">
                                            <div class="col-md-4">
                                                <div class="form-group">                           
                                                        <!-- <input type="text" value="<?php echo $qcode;  ?>" class="form-control" id="qcode" placeholder="Questionaire Code"/> -->
                                                        <!-- <input type="date" value="<?php echo $date;  ?>" class="form-control" id="date" placeholder="Date"/> -->
                                                    <div>
                                                        <input type="hidden" value="<?php echo $center_name_ID;  ?>" class="form-control" id="center_name_ID"/>
                                                        <input type="hidden" value="<?php echo $dclerk;  ?>" class="form-control" id="dclerk"/>
                                                        <code> Name of Trainee </code>
                                                        <input value="<?php echo $tname;  ?>" type="text" class="form-control" id="tname" placeholder="Name of Trainee"/>
                                                    </div>
                                                </div>                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                                                                        
                                                    <div>
                                                        <?php

                                                            $nig_state_sel = '<code> Trainee State </code>
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
                                                </div> 
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
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
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Village / Community</code>
                                                        <input value="<?php echo $village;  ?>" type="text" class="form-control" id="village" placeholder="Village/Community"/>
                                                    </div>
                                                    
                                                </div>                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>                                                        
                                                        <code> GPS Location </code>
                                                        <input value="<?php echo $gps;  ?>" type="text" class="form-control" id="gps" placeholder="GPS Location" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Phone </code>
                                                        <input value="<?php echo $phone;  ?>" type="phone" class="form-control" id="phone" placeholder="Phone"/>
                                                    </div>
                                                </div>
                                            </div>

                                            

                                        </div><br>

                                        <div class="row text-center">
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
                                                        $photopath = base_url().'gsi-assets/image_uploads/trainee_center_'.$center_name_ID.'/'.$photo;
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

                                        <div class="row"> 
                                            <!-- LEFT HAND PROCESS -->  
                                            <div class="col-md-6" style="border: 1px solid #154c3a;">
                                                <div class="row">
                                                    <div class="col-md-6" style="margin: 17px 0 0 -14px;">
                                                        <img src="<?php echo base_url(); ?>gsi-assets/left_print.jpg" alt="fingerprint" style="width: 40%; padding: 2px; float: left;margin-left: -6px;" />
                                                        <h3 style="margin: 28px 0 0 0;">LEFT HAND</h3>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="button" id="btnCapture_leftindex" class="cambutton btn btn-primary active" onclick="return Capture('leftindex')"><h5 style="color: #fff;"><i class="fa fa-thumbs-up"></i>Capture Index</h5></button>
                                                        <button type="button" id="btnCapture_leftthumb" class="cambutton btn btn-primary active" onclick="return Capture('leftthumb')"><h5 style="color: #fff;"><i class="fa fa-thumbs-up"></i>Capture Thumb</h5></button>
                                                    </div>
                                                    
                                                </div>

                                                <div class="row text-center" style="padding-bottom: 20px;">
                                                    <div class="col-md-6">
                                                        <img src="<?php echo base_url(); ?>gsi-assets/fingerprint.png" alt="fingerprint" id="imgFinger_leftindex" style="width: 58%; border: solid 2px #154c3a; padding: 2px; margin-top: 13px;" />
                                                        <span class="fa fa-check text-success hidden" id="thumbsuccessind_leftindex" style="font-size: 30px; position: relative; bottom: -40px; right: 18px;"></span>

                                                        <input value="<?php echo $thumbcode_ISO_indexleft;  ?>" type="hidden" id="txtIsoTemplate_indexleft"/>
                                                        <input value="<?php echo $thumbcode_ANSI_indexleft;  ?>" id="txtAnsiTemplate_indexleft" type="hidden"/>
                                                        <input value="<?php echo $mantra_mfs_100_serial;  ?>" id="mantra_mfs_100_serial" type="hidden"/>
                                                        
                                                        
                                                    </div>
                                                    <div class="col-md-6">
                                                        <img src="<?php echo base_url(); ?>gsi-assets/fingerprint.png" alt="fingerprint" id="imgFinger_leftthumb" style="width: 58%; border: solid 2px #154c3a; padding: 2px; margin-top: 13px;" />
                                                        <span class="fa fa-check text-success hidden" id="thumbsuccessind_leftthumb" style="font-size: 30px; position: relative; bottom: -40px; right: 18px;"></span>

                                                        <input value="<?php echo $thumbcode_ISO_thumbleft;  ?>" type="hidden" id="txtIsoTemplate_thumbleft"/>
                                                        <input value="<?php echo $thumbcode_ANSI_thumbleft;  ?>" id="txtAnsiTemplate_thumbleft" type="hidden"/>
                                                        
                                                    </div>
                                                </div>

                                               

                                            </div> 
                                            <!-- RIGHT HAND PROCESS -->
                                            <div class="col-md-6" style="border: 1px solid #154c3a;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <button type="button" id="btnCapture_rightindex" class="cambutton btn btn-primary active" onclick="return Capture('rightindex')"><h5 style="color: #fff;"><i class="fa fa-thumbs-up"></i>Capture Index</h5></button>
                                                        <button type="button" id="btnCapture_rightthumb" class="cambutton btn btn-primary active" onclick="return Capture('rightthumb')"><h5 style="color: #fff;"><i class="fa fa-thumbs-up"></i>Capture Thumb</h5></button>
                                                    </div>
                                                    <div class="col-md-6" style="margin: 17px 0 0 -14px;">
                                                        <img src="<?php echo base_url(); ?>gsi-assets/right_print.jpg" alt="fingerprint" style="width: 40%; padding: 2px; float: right; margin-right: -22px;" />
                                                        <h3 style="margin: -37px 42px 0 0; float: right;">RIGHT HAND</h3>
                                                    </div>
                                                </div>

                                                <div class="row text-center" style="padding-bottom: 20px;">
                                                    <div class="col-md-6">
                                                        <img src="<?php echo base_url(); ?>gsi-assets/fingerprint.png" alt="fingerprint" id="imgFinger_rightindex" style="width: 58%; border: solid 2px #154c3a; padding: 2px; margin-top: 13px;" />
                                                        <span class="fa fa-check text-success hidden" id="thumbsuccessind_rightindex" style="font-size: 30px; position: relative; bottom: -40px; right: 18px;"></span>

                                                        <input value="<?php echo $thumbcode_ISO_indexright;  ?>" type="hidden" id="txtIsoTemplate_indexright"/>
                                                        <input value="<?php echo $thumbcode_ANSI_indexright;  ?>" id="txtAnsiTemplate_indexright" type="hidden"/>
                                                        
                                                    </div>
                                                    <div class="col-md-6">
                                                        <img src="<?php echo base_url(); ?>gsi-assets/fingerprint.png" alt="fingerprint" id="imgFinger_rightthumb" style="width: 58%; border: solid 2px #154c3a; padding: 2px; margin-top: 13px;" />
                                                        <span class="fa fa-check text-success hidden" id="thumbsuccessind_rightthumb" style="font-size: 30px; position: relative; bottom: -40px; right: 18px;"></span>

                                                        <input value="<?php echo $thumbcode_ISO_thumbright;  ?>" type="hidden" id="txtIsoTemplate_thumbright"/>
                                                        <input value="<?php echo $thumbcode_ANSI_thumbright;  ?>" id="txtAnsiTemplate_thumbright" type="hidden"/>
                                                        
                                                    </div>
                                                </div>
                                                
                                            </div> 
                                        </div>

                                        



                                                                                                                                                        
                                        
                                        <div style="margin-top: 20px;">
                                            
                                            <div class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" id="trainee_location_bt">Next >></div>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>                        
                            <!-- END WIZARD WITH VALIDATION -->

                        </div>

                        <div class="col-md-9 hidden" id="human_capital">
                            <div id=human_capital_msg></div>
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-success">
                                <div class="panel-body">
                                    <h3><i class="glyphicon glyphicon-user"></i> Human Capital</h3>
                                    <?php
                                        $tr_gender=$tr_age=$tr_marital_st=$tn_male=$tn_female=$family_pos=$avg_male=$avg_female=$male_sch=$female_sch=$out_village=$out_migrated=$edu_lev=$tech_train=$cap_dev=$und_cap=$starter_pack=$annual_income='';
                                        if(!empty($trainee_human_capital_data) && is_array($trainee_human_capital_data))
                                        {
                                            $hc_val = $trainee_human_capital_data[0];
                                            $tr_gender = $hc_val['gender'];
                                            $tr_age = $hc_val['age'];
                                            $tr_marital_st = $hc_val['marital_status'];
                                            $tn_male = $hc_val['no_child_male'];
                                            $tn_female = $hc_val['no_child_female'];
                                            $family_pos = $hc_val['position_family'];
                                            $avg_male = $hc_val['avg_age_child_male'];
                                            $avg_female = $hc_val['avg_age_child_female'];
                                            $male_sch = $hc_val['child_male_school'];
                                            $female_sch = $hc_val['child_female_school'];
                                            $out_village = $hc_val['out_of_village'];
                                            $out_migrated = $hc_val['out_migrated'];
                                            $edu_lev = $hc_val['educational_level'];
                                            $tech_train = $hc_val['tech_training'];
                                            $cap_dev = $hc_val['capacity_dev_need'];
                                            $und_cap = $hc_val['undertaken_capacity_dev'];
                                            $annual_income = $hc_val['annual_income'];
                                            $starter_pack = $hc_val['gender'];

                                            
                                        }

                                    ?>                                
                                    <form action="#" role="form" class="form-horizontal" >
                                        <div class="row" style="line-height: 3">
                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div>
                                                        <?php

                                                            $tr_gender_sel = '<code> Trainee Gender </code>
                                                            <select class="form-control select" id="tr_gender" data-live-search="true">
                                                            <option value="0">Select Trainee Gender</option>';

                                                            if($tr_gender == 1)
                                                            {
                                                                $tr_gender_sel .= '<option value="1" selected>Male</option>
                                                                    <option value="2">Female</option>';
                                                            }
                                                            else if($tr_gender == 2)
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
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div>                                                   
                                                    <!-- <div style="margin-top: 37px;"> -->
                                                        <?php

                                                            $tr_age_sel = '<code> Trainee Age </code>
                                                            <select class="form-control select" id="tr_age" data-live-search="true">
                                                            <option value="0">Select Trainee Age</option>';

                                                            if(!empty($trainee_age_data) && is_array($trainee_age_data))
                                                            {
                                                                foreach ($trainee_age_data as $key => $val) 
                                                                {
                                                                    $tr_age_str = $val["item"];
                                                                    $tr_age_val = $val["id"];
                                                                    if($tr_age == $tr_age_val)
                                                                    {
                                                                        $tr_age_sel .= '<option value="'.$tr_age_val.'" selected>'.$tr_age_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $tr_age_sel .= '<option value="'.$tr_age_val.'">'.$tr_age_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $tr_age_sel.'</select>';

                                                        ?>
                                                        
                                                            
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 37px;"> -->
                                                        <?php

                                                            $tr_marital_st_sel = '<code> Marital Status </code>
                                                            <select class="form-control select" id="tr_marital_st" data-live-search="true">
                                                            <option value="0">Select Marital Status</option>';

                                                            if(!empty($marital_status_data) && is_array($marital_status_data))
                                                            {
                                                                foreach ($marital_status_data as $key => $val) 
                                                                {
                                                                    $tr_marital_st_str = $val["item"];
                                                                    $tr_marital_st_val = $val["id"];
                                                                    if($tr_marital_st == $tr_marital_st_val)
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
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 43px;"> -->
                                                        <code> Total No. of Male Child </code>
                                                        <input type="text" class="form-control" id="tn_male" placeholder="Total number of Male Child" value="<?php echo $tn_male ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 43px;"> -->
                                                        <code> Total No. of Female Child</code>
                                                        <input type="text" class="form-control" id="tn_female" placeholder="Total number of Female Child" value="<?php echo $tn_female ?>"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 43px;"> -->
                                                        <code> Trainee Position in Family </code>
                                                        <input type="text" class="form-control" id="family_pos" placeholder="Trainee Position in Family" value="<?php echo $family_pos ?>"/>
                                                    </div>                                                
                                                </div>                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                    <!-- <div style="margin-top: 5px;"> -->
                                                        <code> Average Age of Male Child/Dependent </code>
                                                        <input type="text" class="form-control" id="avg_male" placeholder="Average age of Male Child" value="<?php echo $avg_male ?>"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 38px;"> -->
                                                        <code> Average Age of Female Child </code>
                                                        <input type="text" class="form-control" id="avg_female" placeholder="Average age of Female Child" value="<?php echo $avg_female ?>"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 37px;"> -->
                                                        <code> No. of Male Child Attending School </code>
                                                        <input type="text" class="form-control" id="male_sch" placeholder="No of Male Child Attending School" value="<?php echo $male_sch ?>"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 42px;"> -->
                                                        <code> No of Female Child Attending School </code>
                                                        <input type="text" class="form-control" id="female_sch" placeholder="No of Female Child Attending School" value="<?php echo $female_sch ?>"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 43px;"> -->
                                                        <?php

                                                            $out_village_sel = '<code> Temp. out of Village for Seasonal Job </code>
                                                            <select class="form-control select" id="out_village" data-live-search="true">
                                                            <option value="0">seasonal job out of village</option>';

                                                            if(!empty($out_of_village_seasonal_data) && is_array($out_of_village_seasonal_data))
                                                            {
                                                                foreach ($out_of_village_seasonal_data as $key => $val) 
                                                                {
                                                                    $out_village_str = $val["item"];
                                                                    $out_village_val = $val["id"];
                                                                    if($out_village == $out_village_val)
                                                                    {
                                                                        $out_village_sel .= '<option value="'.$out_village_val.'" selected>'.$out_village_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $out_village_sel .= '<option value="'.$out_village_val.'">'.$out_village_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $out_village_sel.'</select>';

                                                        ?>
                                                        
                                                            
                                                    </div> 
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 41px;"> -->
                                                        <?php

                                                            $out_migrated_sel = '<code> Out Migrated for Work </code>
                                                            <select class="form-control select" id="out_migrated" data-live-search="true">
                                                            <option value="0">Select Out Migrated</option>';

                                                            if(!empty($out_migrated_data) && is_array($out_migrated_data))
                                                            {
                                                                foreach ($out_migrated_data as $key => $val) 
                                                                {
                                                                    $out_migrated_str = $val["item"];
                                                                    $out_migrated_val = $val["id"];
                                                                    if($out_migrated == $out_migrated_val)
                                                                    {
                                                                        $out_migrated_sel .= '<option value="'.$out_migrated_val.'" selected>'.$out_migrated_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $out_migrated_sel .= '<option value="'.$out_migrated_val.'">'.$out_migrated_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $out_migrated_sel.'</select>';

                                                        ?>
                                                        
                                                            
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <?php

                                                            $edu_lev_sel = '<code> Highest Level of Education </code>
                                                            <select class="form-control select" id="edu_lev" data-live-search="true">
                                                            <option value="0">Select Highest Level of Education</option>';

                                                            if(!empty($educational_level_data) && is_array($educational_level_data))
                                                            {
                                                                foreach ($educational_level_data as $key => $val) 
                                                                {
                                                                    $edu_lev_str = $val["item"];
                                                                    $edu_lev_val = $val["id"];
                                                                    if($edu_lev == $edu_lev_val)
                                                                    {
                                                                        $edu_lev_sel .= '<option value="'.$edu_lev_val.'" selected>'.$edu_lev_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $edu_lev_sel .= '<option value="'.$edu_lev_val.'">'.$edu_lev_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $edu_lev_sel.'</select>';

                                                        ?>
                                                        
                                                            
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 38px;"> -->
                                                        <?php

                                                            $tech_train_sel = '<code> Technical Training Undertaken </code>
                                                            <select class="form-control select" id="tech_train" data-live-search="true">
                                                            <option value="0">Select Technical Training</option>';

                                                            if(!empty($technical_training_data) && is_array($technical_training_data))
                                                            {
                                                                foreach ($technical_training_data as $key => $val) 
                                                                {
                                                                    $tech_train_str = $val["item"];
                                                                    $tech_train_val = $val["id"];
                                                                    if($tech_train == $tech_train_val)
                                                                    {
                                                                        $tech_train_sel .= '<option value="'.$tech_train_val.'" selected>'.$tech_train_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $tech_train_sel .= '<option value="'.$tech_train_val.'">'.$tech_train_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $tech_train_sel.'</select>';

                                                        ?>
                                                        
                                                            
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div class="sel_specify_holder">
                                                    <!-- <div style="margin-top: 36px;" class="sel_specify_holder"> -->
                                                        <?php

                                                            $cap_dev_sel = '<code> Capacity Development Needs </code>
                                                            <select class="form-control select sel_specify" id="cap_dev" data-live-search="true">
                                                            <option value="0">Select Capacity Dev. Need</option>';

                                                            if(strlen($cap_dev) > 3)
                                                            {
                                                                 $cap_dev_sel .= '<option value="'.$cap_dev.'" selected>'.$cap_dev.'</option>';
                                                            }

                                                            if(!empty($capacity_development_data) && is_array($capacity_development_data))
                                                            {
                                                                foreach ($capacity_development_data as $key => $val) 
                                                                {
                                                                    $cap_dev_str = $val["item"];
                                                                    $cap_dev_val = $val["id"];
                                                                    if($cap_dev == $cap_dev_val)
                                                                    {
                                                                        $cap_dev_sel .= '<option value="'.$cap_dev_val.'" selected>'.$cap_dev_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $cap_dev_sel .= '<option value="'.$cap_dev_val.'">'.$cap_dev_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $cap_dev_sel.'</select>';

                                                        ?>
                                                        
                                                            
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 43px;"> -->
                                                        <code> Skill/Capacity Dev. to be undertaken </code>
                                                        <input type="text" class="form-control" id="und_cap" placeholder="Skill/Capacity Dev. to be undertaken" value="<?php echo $und_cap ?>"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 42px;"> -->
                                                        <?php

                                                            $starter_pack_sel = '<code> Starter Pack Given</code>
                                                            <select class="form-control select" id="starter_pack" data-live-search="true">
                                                            <option value="0">Select Starter Pack Given</option>';

                                                            if(!empty($starter_pack_data) && is_array($starter_pack_data))
                                                            {
                                                                foreach ($starter_pack_data as $key => $val) 
                                                                {
                                                                    $starter_pack_str = $val["item"];
                                                                    $starter_pack_val = $val["id"];
                                                                    if($starter_pack == $starter_pack_val)
                                                                    {
                                                                        $starter_pack_sel .= '<option value="'.$starter_pack_val.'" selected>'.$starter_pack_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $starter_pack_sel .= '<option value="'.$starter_pack_val.'">'.$starter_pack_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $starter_pack_sel.'</select>';

                                                        ?>
                                                        
                                                           
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 43px;"> -->
                                                        <code> Annual Income </code>
                                                        <input type="number" class="form-control" id="annual_income" placeholder="Annual Income" value="<?php echo $annual_income ?>"/>
                                                    </div>
                                                </div>
                                            </div>                 
                                        </div>

                                        <div>
                                            
                                            <div class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" id="human_capital_bt">Next >></div>
                                        </div>
                                    </form>
                                </div>
                            </div>                        
                            <!-- END WIZARD WITH VALIDATION -->

                        </div>

                        <div class="col-md-9 hidden" id="social_capital">
                            <div id="social_capital_msg"></div>
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-success">
                                <div class="panel-body" style="min-height: 350px;">
                                    <h3><i class="glyphicon glyphicon-screenshot"></i> Social Capital</h3>
                                    <?php
                                        $part_soc_eco=$inv_soc_eco=$con_ext='';

                                        if(!empty($trainee_social_capital_data) && is_array($trainee_social_capital_data))
                                        {
                                            $sc_val = $trainee_social_capital_data[0];
                                            $part_soc_eco = $sc_val['participation_socio_economic_interest_group'];
                                            $inv_soc_eco = $sc_val['involved_socio_economic_interest_group'];
                                            $con_ext = $sc_val['connection_with_ext_institution'];
                                        }

                                    ?>                                 
                                    <form action="#" role="form" class="form-horizontal" >
                                        <div class="row" style="line-height: 3">
                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div>
                                                        <?php

                                                            $part_soc_eco_sel = '<code> Participation in Soc-Econ. Int. Group </code>
                                                            <select class="form-control select" id="part_soc_eco" data-live-search="true">
                                                            <option value="0">Participation Socio Econ. Int. Group</option>';

                                                            if($part_soc_eco == 3)
                                                            {
                                                                $part_soc_eco_sel .= '<option value="3" selected>Yes</option>
                                                                    <option value="2">No</option>
                                                                    <option value="1">N/A</option>';
                                                            }
                                                            else if($part_soc_eco == 2)
                                                            {
                                                                $part_soc_eco_sel .= '<option value="2" selected>No</option>
                                                                    <option value="3">Yes</option>
                                                                    <option value="1">N/A</option>';
                                                            }
                                                            else if($part_soc_eco == 1)
                                                            {
                                                                 $part_soc_eco_sel .= '<option value="1" selected>N/A</option>
                                                                     <option value="3">Yes</option>
                                                                    <option value="2">No</option>';
                                                            }
                                                            else
                                                            {
                                                                $part_soc_eco_sel .= '<option value="3">Yes</option>
                                                                    <option value="2">No</option>
                                                                    <option value="1">N/A</option>';
                                                            }

                                                            echo $part_soc_eco_sel.'</select>';

                                                        ?>
                                                        
                                                            
                                                    </div>                                          
                                                </div>                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div class="sel_specify_holder">
                                                        <?php

                                                            $inv_soc_eco_sel = '<code> Involved Soc-Econ. Int. Group </code>
                                                            <select class="form-control select sel_specify" id="inv_soc_eco" data-live-search="true">
                                                            <option value="0">Involved Socio Eco. Int. Group</option>';

                                                            if(strlen($inv_soc_eco) > 3)
                                                            {
                                                                 $inv_soc_eco_sel .= '<option value="'.$inv_soc_eco.'" selected>'.$inv_soc_eco.'</option>';
                                                            }

                                                            if(!empty($socio_economic_group_data) && is_array($socio_economic_group_data))
                                                            {
                                                                foreach ($socio_economic_group_data as $key => $val) 
                                                                {
                                                                    $inv_soc_eco_str = $val["item"];
                                                                    $inv_soc_eco_val = $val["id"];
                                                                    if($inv_soc_eco == $inv_soc_eco_val)
                                                                    {
                                                                        $inv_soc_eco_sel .= '<option value="'.$inv_soc_eco_val.'" selected>'.$inv_soc_eco_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $inv_soc_eco_sel .= '<option value="'.$inv_soc_eco_val.'">'.$inv_soc_eco_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $inv_soc_eco_sel.'</select>';

                                                        ?>
                                                        
                                                    </div>                                          
                                                </div>                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div class="sel_specify_holder">
                                                        <?php

                                                            $con_ext_sel = '<code> Conn. with external inst. for support</code>
                                                            <select class="form-control select sel_specify" id="con_ext" data-live-search="true">
                                                            <option value="0">Connection with ext. inst.</option>';
                                                            if(strlen($con_ext) > 3)
                                                            {
                                                                 $con_ext_sel .= '<option value="'.$energy_source.'" selected>'.$con_ext.'</option>';
                                                            }

                                                            if(!empty($external_institutions_data) && is_array($external_institutions_data))
                                                            {
                                                                foreach ($external_institutions_data as $key => $val) 
                                                                {
                                                                    $con_ext_str = $val["item"];
                                                                    $con_ext_val = $val["id"];
                                                                    if($con_ext == $con_ext_val)
                                                                    {
                                                                        $con_ext_sel .= '<option value="'.$con_ext_val.'" selected>'.$con_ext_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $con_ext_sel .= '<option value="'.$con_ext_val.'">'.$con_ext_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $con_ext_sel.'</select>';

                                                        ?>
                                                        
                                                    </div>                                          
                                                </div>                                                
                                            </div>
                                                                                                                                                        
                                        </div>
                                        <div>
                                            <div class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" id="social_capital_bt">Next >></div> 
                                        </div>
                                    </form>
                                </div>
                            </div>                        
                            <!-- END WIZARD WITH VALIDATION -->

                        </div>

                        <div class="col-md-9 hidden" id="natural_capital">
                            <div id="natural_capital_msg"></div>
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-success">
                                <div class="panel-body" style="min-height: 350px;">
                                    <h3><i class="glyphicon glyphicon-tree-deciduous"></i> Natural Capital</h3>

                                    <?php                                        
                                        $agric_land=$land_own=$main_use=$energy_source='';

                                        if(!empty($trainee_natural_capital_data) && is_array($trainee_natural_capital_data))
                                        {
                                            $nc_val = $trainee_natural_capital_data[0];
                                            $agric_land = $nc_val['agric_land_access_for_farming'];
                                            $land_own = $nc_val['ownership_agric_land'];
                                            $main_use = $nc_val['mainland_use'];
                                            $energy_source = $nc_val['sources_of_energy_for_cooking'];
                                        }

                                    ?>
                                    <form action="#" role="form" class="form-horizontal" >
                                        <div class="row" style="line-height: 3">
                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div>
                                                        <?php

                                                            $agric_land_sel = '<code> Agric Farm Land Accessed </code>
                                                            <select class="form-control select" id="agric_land" data-live-search="true">
                                                            <option value="0">Agric Land for Farming</option>';

                                                            if(!empty($agricultural_land_data) && is_array($agricultural_land_data))
                                                            {
                                                                foreach ($agricultural_land_data as $key => $val) 
                                                                {
                                                                    $agric_land_str = $val["item"];
                                                                    $agric_land_val = $val["id"];
                                                                    if($agric_land == $agric_land_val)
                                                                    {
                                                                        $agric_land_sel .= '<option value="'.$agric_land_val.'" selected>'.$agric_land_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $agric_land_sel .= '<option value="'.$agric_land_val.'">'.$agric_land_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $agric_land_sel.'</select>';

                                                        ?>
                                                        
                                                    </div>                                          
                                                </div>                                                
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div>
                                                        <?php

                                                            $land_own_sel = '<code> Ownership of Farm Land </code>
                                                            <select class="form-control select" id="land_own" data-live-search="true">
                                                            <option value="0">Ownership of Land</option>';

                                                            if(!empty($land_ownership_data) && is_array($land_ownership_data))
                                                            {
                                                                foreach ($land_ownership_data as $key => $val) 
                                                                {
                                                                    $land_own_str = $val["item"];
                                                                    $land_own_val = $val["id"];
                                                                    if($land_own == $land_own_val)
                                                                    {
                                                                        $land_own_sel .= '<option value="'.$land_own_val.'" selected>'.$land_own_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $land_own_sel .= '<option value="'.$land_own_val.'">'.$land_own_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $land_own_sel.'</select>';

                                                        ?>
                                                                                                                  
                                                    </div>                                          
                                                </div>                                                
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div>
                                                        <?php

                                                            $main_use_sel = '<code> Mainland use in the Area </code>
                                                            <select class="form-control select" id="main_use" data-live-search="true">
                                                            <option value="0">Mainland use in the Area</option>';

                                                            if(!empty($main_land_use_data) && is_array($main_land_use_data))
                                                            {
                                                                foreach ($main_land_use_data as $key => $val) 
                                                                {
                                                                    $main_use_str = $val["item"];
                                                                    $main_use_val = $val["id"];
                                                                    if($agric_land == $main_use_val)
                                                                    {
                                                                        $main_use_sel .= '<option value="'.$main_use_val.'" selected>'.$main_use_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $main_use_sel .= '<option value="'.$main_use_val.'">'.$main_use_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $main_use_sel.'</select>';

                                                        ?>
                                                        
                                                            
                                                    </div>                                          
                                                </div>                                                
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div class="sel_specify_holder">
                                                        <?php

                                                            $energy_source_sel = '<code> Cooking Sources of Energy</code>
                                                            <select class="form-control select sel_specify" id="energy_source" data-live-search="true">
                                                            <option value="0">Sources of Energy for Cooking</option>';
                                                            if(strlen($energy_source) > 3)
                                                            {
                                                                 $energy_source_sel .= '<option value="'.$energy_source.'" selected>'.$energy_source.'</option>';
                                                            }

                                                            if(!empty($energy_sources_data) && is_array($energy_sources_data))
                                                            {
                                                                foreach ($energy_sources_data as $key => $val) 
                                                                {
                                                                    $energy_source_str = $val["item"];
                                                                    $energy_source_val = $val["id"];
                                                                    if($energy_source == $energy_source_val)
                                                                    {
                                                                        $energy_source_sel .= '<option value="'.$energy_source_val.'" selected>'.$energy_source_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $energy_source_sel .= '<option value="'.$energy_source_val.'">'.$energy_source_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            

                                                            echo $energy_source_sel.'</select>';

                                                        ?>
                                                        
                                                    </div>                                          
                                                </div>                                                
                                            </div>
                                                                                                                                                        
                                        </div>
                                        <div>
                                            <div class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" id="natural_capital_bt">Next >></div> 
                                        </div>
                                    </form>
                                </div>
                            </div>                        
                            <!-- END WIZARD WITH VALIDATION -->

                        </div>

                        <div class="col-md-9 hidden" id="physical_capital">
                            <div id="physical_capital_msg"></div>
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-success">
                                <div class="panel-body" style="min-height: 350px;">
                                    <h3><i class="glyphicon glyphicon-briefcase"></i> Physical Capital</h3>
                                    <?php                                        
                                        $goods_tools='';

                                        if(!empty($trainee_physical_capital_data) && is_array($trainee_physical_capital_data))
                                        {
                                            $pc_val = $trainee_physical_capital_data[0];
                                            $goods_tools = $pc_val['goods_tools_owned'];
                                            $goods_tools = json_decode($goods_tools);
                                        }

                                    ?>
                                    <form action="#" role="form" class="form-horizontal" >
                                        <div class="row" style="line-height: 3">
                                            <div class="col-md-12">
                                                <div class="form-group">                
                                                    <div class="sel_specify_holder">
                                                        <?php

                                                            $goods_tools_sel = '<code> Goods & Tools Owned</code>
                                                            <select class="form-control select sel_specify" id="goods_tools" data-live-search="true" multiple>
                                                            <option value="0">Select goods and tools owned</option>';
                                                            /*if(!is_array($goods_tools)&&(strlen($goods_tools) > 3))
                                                            {
                                                                 $goods_tools_sel .= '<option value="'.$goods_tools.'" selected>'.$goods_tools.'</option>';
                                                            }*/

                                                            if(!empty($goods_tools_owned_data) && is_array($goods_tools_owned_data))
                                                            {
                                                                foreach ($goods_tools_owned_data as $key => $val) 
                                                                {
                                                                    $goods_tools_str = $val["item"];
                                                                    $goods_tools_val = $val["id"];
                                                                    $gtv_seen = false;
                                                                    if(is_array($goods_tools))
                                                                    {
                                                                        foreach ($goods_tools as $key => $gtv) 
                                                                        {
                                                                            if($gtv == $goods_tools_val)
                                                                            {
                                                                                $goods_tools_sel .= '<option value="'.$goods_tools_val.'" selected>'.$goods_tools_str.'</option>';
                                                                                $gtv_seen = true;
                                                                            }
                                                                        }
                                                                        if(!$gtv_seen)
                                                                        {
                                                                            $goods_tools_sel .= '<option value="'.$goods_tools_val.'">'.$goods_tools_str.'</option>';
                                                                        }

                                                                    }
                                                                    else
                                                                    {
                                                                        if($goods_tools == $goods_tools_val)
                                                                        {
                                                                            $goods_tools_sel .= '<option value="'.$goods_tools_val.'" selected>'.$goods_tools_str.'</option>';
                                                                        }
                                                                        else
                                                                        {
                                                                             $goods_tools_sel .= '<option value="'.$goods_tools_val.'">'.$goods_tools_str.'</option>';
                                                                        }

                                                                    }
                                                                    
                                                                    
                                                                }
                                                            }

                                                            echo $goods_tools_sel.'</select>';

                                                        ?>

                                                    </div>                                          
                                                </div>                                                
                                            </div>
                                                                                                                                                        
                                        </div>
                                        <div>
                                            <div class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" id="physical_capital_bt">Next >></div> 
                                        </div>
                                    </form>
                                </div>
                            </div>                        
                            <!-- END WIZARD WITH VALIDATION -->

                        </div>

                        <div class="col-md-9 hidden" id="financial_capital">
                            <div id="financial_capital_msg"></div>
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-success">
                                <div class="panel-body">
                                    <h3><i class="glyphicon glyphicon-tower"></i> Financial Capital</h3>
                                    <?php

                                        $first_source=$second_source=$trend_income=$off_season=$cash_crops=$monetary=$sav_monetary=$access_microcredit=$no_cattle=$no_goats=$no_sheep=$no_poultry=$male_schfees_spent=$female_schfees_spent=$male_amt_spent=$female_amt_spent='';

                                        if(!empty($trainee_financial_capital_data) && is_array($trainee_financial_capital_data))
                                        {
                                            $fc_val = $trainee_financial_capital_data[0];
                                            $first_source = $fc_val['first_source_livelihood'];
                                            $second_source = $fc_val['second_source_livelihood'];
                                            $trend_income = $fc_val['trend_of_income'];
                                            $off_season = $fc_val['practices_off_season'];
                                            $cash_crops = $fc_val['production_cash_crops'];
                                            $monetary = $fc_val['monetary_remittance'];
                                            $sav_monetary = $fc_val['bank_monetary_savings'];
                                            $access_microcredit = $fc_val['access_to_microcredit'];
                                            $no_cattle = $fc_val['no_livestock_cattle'];
                                            $no_goats = $fc_val['no_livestock_goat'];
                                            $no_sheep = $fc_val['no_livestock_sheep'];
                                            $no_poultry = $fc_val['no_livestock_poultry'];
                                            $male_schfees_spent = $fc_val['average_amount_schoolfees_spend_male'];
                                            $female_schfees_spent = $fc_val['average_amount_schoolfees_spend_female'];
                                            $male_amt_spent = $fc_val['average_amount_spend_male'];
                                            $female_amt_spent = $fc_val['average_amount_spend_female'];

                                            
                                        }

                                    ?>                                
                                    <form action="#" role="form" class="form-horizontal" >
                                        <div class="row" style="line-height: 3">
                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div class="sel_specify_holder">
                                                        <?php

                                                            $first_source_sel = '<code> 1st source of livelihood</code>
                                                            <select class="form-control select sel_specify" id="first_source" data-live-search="true">
                                                            <option value="0">Select first source of livelyhood</option>';
                                                            if(strlen($first_source) > 3)
                                                            {
                                                                 $first_source_sel .= '<option value="'.$first_source.'" selected>'.$first_source.'</option>';
                                                            }

                                                            if(!empty($first_source_livelihood_data) && is_array($first_source_livelihood_data))
                                                            {
                                                                foreach ($first_source_livelihood_data as $key => $val) 
                                                                {
                                                                    $first_source_str = $val["item"];
                                                                    $first_source_val = $val["id"];
                                                                    if($first_source == $first_source_val)
                                                                    {
                                                                        $first_source_sel .= '<option value="'.$first_source_val.'" selected>'.$first_source_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $first_source_sel .= '<option value="'.$first_source_val.'">'.$first_source_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $first_source_sel.'</select>';

                                                        ?>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div class="sel_specify_holder">
                                                    <!-- <div style="margin-top: 37px;" class="sel_specify_holder"> -->
                                                        <?php

                                                            $second_source_sel = '<code> 2nd source of livelihood </code>
                                                            <select class="form-control select sel_specify" id="second_source" data-live-search="true">
                                                            <option value="0">Select second source of livelyhood</option>';

                                                            if(strlen($second_source) > 3)
                                                            {
                                                                 $second_source_sel .= '<option value="'.$second_source.'" selected>'.$second_source.'</option>';
                                                            }

                                                            if(!empty($second_source_livelihood_data) && is_array($second_source_livelihood_data))
                                                            {
                                                                foreach ($second_source_livelihood_data as $key => $val) 
                                                                {
                                                                    $second_source_str = $val["item"];
                                                                    $second_source_val = $val["id"];
                                                                    if($second_source == $second_source_val)
                                                                    {
                                                                        $second_source_sel .= '<option value="'.$second_source_val.'" selected>'.$second_source_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $second_source_sel .= '<option value="'.$second_source_val.'">'.$second_source_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $second_source_sel.'</select>';

                                                        ?>
                                                        
                                                    </div> 
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 37px;"> -->
                                                        <?php

                                                            $trend_income_sel = '<code> Income Trend for last 2yrs</code>
                                                            <select class="form-control select" id="trend_income" data-live-search="true">
                                                            <option value="0">Select Trend of income</option>';

                                                            if(!empty($trend_of_income_data) && is_array($trend_of_income_data))
                                                            {
                                                                foreach ($trend_of_income_data as $key => $val) 
                                                                {
                                                                    $trend_income_str = $val["item"];
                                                                    $trend_income_val = $val["id"];
                                                                    if($trend_income == $trend_income_val)
                                                                    {
                                                                        $trend_income_sel .= '<option value="'.$trend_income_val.'" selected>'.$trend_income_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $trend_income_sel .= '<option value="'.$trend_income_val.'">'.$trend_income_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $trend_income_sel.'</select>';

                                                        ?>                                                       
                                                           
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 37px;"> -->
                                                        <?php

                                                            $off_season_sel = '<code> Practice Off Season Agric </code>
                                                            <select class="form-control select" id="off_season" data-live-search="true">
                                                            <option value="0">Off Season Agric. Practice</option>';

                                                            if($off_season == 1)
                                                            {
                                                                $off_season_sel .= '<option value="1" selected>Yes</option>
                                                                    <option value="2">No</option>';
                                                            }
                                                            else if($off_season == 2)
                                                            {
                                                                $off_season_sel .= '<option value="2" selected>No</option>
                                                                    <option value="1">Yes</option>';
                                                            }
                                                            else
                                                            {
                                                                $off_season_sel .= '<option value="1">Yes</option>';
                                                                $off_season_sel .= '<option value="2">No</option>';
                                                            }

                                                            echo $off_season_sel.'</select>';

                                                        ?>
                                                        
                                                            
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div>
                                                        <?php

                                                            $cash_crops_sel = '<code> Production of cash crops </code>
                                                            <select class="form-control select" id="cash_crops" data-live-search="true">
                                                            <option value="0">Production of cash crops</option>';

                                                            if($cash_crops == 1)
                                                            {
                                                                $cash_crops_sel .= '<option value="1" selected>Yes</option>
                                                                    <option value="2">No</option>';
                                                            }
                                                            else if($cash_crops == 2)
                                                            {
                                                                $cash_crops_sel .= '<option value="2" selected>No</option>
                                                                    <option value="1">Yes</option>';
                                                            }
                                                            else
                                                            {
                                                                $cash_crops_sel .= '<option value="1">Yes</option>';
                                                                $cash_crops_sel .= '<option value="2">No</option>';
                                                            }

                                                            echo $cash_crops_sel.'</select>';

                                                        ?>
                                                        
                                                    </div> 
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 37px;"> -->
                                                        <?php

                                                            $monetary_sel = '<code>Rec. Mon. Rem(Out-Mig Mem)</code>
                                                            <select class="form-control select" id="monetary" data-live-search="true">
                                                            <option value="0">Monetary Remittances</option>';

                                                            if($monetary == 1)
                                                            {
                                                                $monetary_sel .= '<option value="1" selected>Yes</option>
                                                                    <option value="2">No</option>';
                                                            }
                                                            else if($monetary == 2)
                                                            {
                                                                $monetary_sel .= '<option value="2" selected>No</option>
                                                                    <option value="1">Yes</option>';
                                                            }
                                                            else
                                                            {
                                                                $monetary_sel .= '<option value="1">Yes</option>';
                                                                $monetary_sel .= '<option value="2">No</option>';
                                                            }

                                                            echo $monetary_sel.'</select>';

                                                        ?>
                                                        
                                                            
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 37px;"> -->
                                                        <?php

                                                            $sav_monetary_sel = '<code> Monetary Savings in Banks</code>
                                                            <select class="form-control select" id="sav_monetary" data-live-search="true">
                                                            <option value="0">monetary savings</option>';

                                                            if($sav_monetary == 1)
                                                            {
                                                                $sav_monetary_sel .= '<option value="1" selected>Yes</option>
                                                                    <option value="2">No</option>';
                                                            }
                                                            else if($sav_monetary == 2)
                                                            {
                                                                $sav_monetary_sel .= '<option value="2" selected>No</option>
                                                                    <option value="1">Yes</option>';
                                                            }
                                                            else
                                                            {
                                                                $sav_monetary_sel .= '<option value="1">Yes</option>';
                                                                $sav_monetary_sel .= '<option value="2">No</option>';
                                                            }

                                                            echo $sav_monetary_sel.'</select>';

                                                        ?>
                                                        
                                                            
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 37px;"> -->
                                                        <?php

                                                            $access_microcredit_sel = '<code> Micro-Credit Access</code>
                                                            <select class="form-control select" id="access_microcredit" data-live-search="true">
                                                            <option value="0">micro-credit access</option>';

                                                            if(!empty($micro_credit_data) && is_array($micro_credit_data))
                                                            {
                                                                foreach ($micro_credit_data as $key => $val) 
                                                                {
                                                                    $access_microcredit_str = $val["item"];
                                                                    $access_microcredit_val = $val["id"];
                                                                    if($access_microcredit == $access_microcredit_val)
                                                                    {
                                                                        $access_microcredit_sel .= '<option value="'.$access_microcredit_val.'" selected>'.$access_microcredit_str.'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                         $access_microcredit_sel .= '<option value="'.$access_microcredit_val.'">'.$access_microcredit_str.'</option>';
                                                                    }
                                                                    
                                                                }
                                                            }

                                                            echo $access_microcredit_sel.'</select>';

                                                        ?>
                                                        
                                                    </div>                                         
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Num. of Cattle Owned </code>
                                                        <input type="number" class="form-control" id="no_cattle" placeholder="Num. of Cattle Owned" value="<?php echo $no_cattle; ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 35px;"> -->
                                                        <code> Num. of Goats Owned </code>
                                                        <input type="number" class="form-control" id="no_goats" placeholder="Num. of Goats Owned" value="<?php echo $no_goats; ?>"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 39px;"> -->
                                                        <code> Num. of Sheep Owned </code>
                                                        <input type="number" class="form-control" id="no_sheep" placeholder="Num. of Sheep Owned" value="<?php echo $no_sheep; ?>"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 36px;"> -->
                                                        <code> Num of Poultry Owned </code>
                                                        <input type="number" class="form-control" id="no_poultry" placeholder="Num. of Poultry Owned" value="<?php echo $no_poultry; ?>"/>
                                                    </div>                                          
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Avg Sch. Fees - Male</code>
                                                        <input type="number" class="form-control" id="male_schfees_spent" placeholder="Avg School Fees on Male Child" value="<?php echo $male_schfees_spent; ?>"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 37px;"> -->
                                                        <code> Avg Sch. Fees - Female</code>
                                                        <input type="number" class="form-control" id="female_schfees_spent" placeholder="Avg School Fees on Female Child" value="<?php echo $female_schfees_spent; ?>"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 37px;"> -->
                                                        <code> Avg Amt. Spent - Male</code>
                                                        <input type="number" class="form-control" id="male_amt_spent" placeholder="Avg Amt. Spent on Male Child" value="<?php echo $male_amt_spent; ?>"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">                
                                                    <div>
                                                    <!-- <div style="margin-top: 36px;"> -->
                                                        <code> Avg Amt. Spent - Female</code>
                                                        <input type="number" class="form-control" id="female_amt_spent" placeholder="Avg Amt. Spent on Female Child" value="<?php echo $female_amt_spent; ?>"/>
                                                    </div>                                          
                                                </div>
                                            </div>
                                                                                                                                                        
                                        </div>
                                        <div>
                                            <div class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" id="financial_capital_bt">Submit </div> 
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

        <div class="message-box animated fadeIn" data-sound="alert" id="fingerprint_alert">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="glyphicon glyphicon-ban-circle"></span> User Exist!!!</div>
                    <div class="mb-content">                   
                        <h3 style="color: #ccd4cd;">The user you are trying to register has already been captured</h3>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button class="btn btn-success btn-lg mb-control-close" id="fingerprint_alert_close">Okay</button>
                        </div>
                    </div>
                </div>
            </div>
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

        <!-- <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/bootstrap/bootstrap-select.js"></script> -->
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


            
            var destination = "<?php echo base_url() ?>"+'Trainee/post_enroll_trainee';
            var imageAttached = false;
            var imageDataURI = '';
            var imgpostcount = 0;

            $("#trainee_location_handle").click(function()
            {
                trainee_location();
            });

            $("#human_capital_handle").click(function()
            {
                human_capital();
            });

            $("#social_capital_handle").click(function()
            {
                social_capital();
            });

            $("#natural_capital_handle").click(function()
            {
                natural_capital();
            });

            $("#physical_capital_handle").click(function()
            {
                physical_capital();
            });

            $("#financial_capital_handle").click(function()
            {
                financial_capital();
            });

            function financial_capital()
            {
                $("#financial_capital_handle").addClass("active");
                $("#human_capital_handle").removeClass("active");
                $("#social_capital_handle").removeClass("active");
                $("#natural_capital_handle").removeClass("active");
                $("#physical_capital_handle").removeClass("active");
                $("#trainee_location_handle").removeClass("active");

                
                $("#human_capital").addClass("hidden");
                $("#social_capital").addClass("hidden");
                $("#natural_capital").addClass("hidden");
                $("#physical_capital").addClass("hidden");
                $("#trainee_location").addClass("hidden");
                $("#financial_capital").removeClass("hidden");   
            }

            function physical_capital()
            {
                $("#physical_capital_handle").addClass("active");
                $("#human_capital_handle").removeClass("active");
                $("#social_capital_handle").removeClass("active");
                $("#natural_capital_handle").removeClass("active");
                $("#trainee_location_handle").removeClass("active");
                $("#financial_capital_handle").removeClass("active");

                
                $("#human_capital").addClass("hidden");
                $("#social_capital").addClass("hidden");
                $("#natural_capital").addClass("hidden");
                $("#trainee_location").addClass("hidden");
                $("#financial_capital").addClass("hidden");
                $("#physical_capital").removeClass("hidden");
            }

            function natural_capital()
            {
                $("#natural_capital_handle").addClass("active");
                $("#human_capital_handle").removeClass("active");
                $("#social_capital_handle").removeClass("active");
                $("#trainee_location_handle").removeClass("active");
                $("#physical_capital_handle").removeClass("active");
                $("#financial_capital_handle").removeClass("active");

                
                $("#human_capital").addClass("hidden");
                $("#social_capital").addClass("hidden");
                $("#trainee_location").addClass("hidden");
                $("#physical_capital").addClass("hidden");
                $("#financial_capital").addClass("hidden");
                $("#natural_capital").removeClass("hidden");
            }

            function social_capital()
            {
                $("#social_capital_handle").addClass("active");
                $("#human_capital_handle").removeClass("active");
                $("#trainee_location_handle").removeClass("active");
                $("#natural_capital_handle").removeClass("active");
                $("#physical_capital_handle").removeClass("active");
                $("#financial_capital_handle").removeClass("active");

                
                $("#human_capital").addClass("hidden");
                $("#trainee_location").addClass("hidden");
                $("#natural_capital").addClass("hidden");
                $("#physical_capital").addClass("hidden");
                $("#financial_capital").addClass("hidden");
                $("#social_capital").removeClass("hidden");
            }

            function human_capital()
            {
                $("#human_capital_handle").addClass("active");
                $("#trainee_location_handle").removeClass("active");
                $("#social_capital_handle").removeClass("active");
                $("#natural_capital_handle").removeClass("active");
                $("#physical_capital_handle").removeClass("active");
                $("#financial_capital_handle").removeClass("active");

                
                $("#trainee_location").addClass("hidden");
                $("#social_capital").addClass("hidden");
                $("#natural_capital").addClass("hidden");
                $("#physical_capital").addClass("hidden");
                $("#financial_capital").addClass("hidden");
                $("#human_capital").removeClass("hidden");
            }

            function trainee_location()
            {
                $("#trainee_location_handle").addClass("active");
                $("#human_capital_handle").removeClass("active");
                $("#social_capital_handle").removeClass("active");
                $("#natural_capital_handle").removeClass("active");
                $("#physical_capital_handle").removeClass("active");
                $("#financial_capital_handle").removeClass("active");

                
                $("#human_capital").addClass("hidden");
                $("#social_capital").addClass("hidden");
                $("#natural_capital").addClass("hidden");
                $("#physical_capital").addClass("hidden");
                $("#financial_capital").addClass("hidden");
                $("#trainee_location").removeClass("hidden");
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
                //$('#lga').selectpicker('refresh');
                //$("#lga").selectpicker('refresh').empty().append(output).selectpicker('refresh').trigger('change');
                
            }

            $("#trainee_location_bt").click(function ()
             {
                    pageLoadingFrame("show");
                    
                    setTimeout(function(){
                            pageLoadingFrame("hide");
                        },1500);

                    var center_name_ID=$("#center_name_ID").val();
                    //var date=$("#date").val();
                    var tname=$("#tname").val();
                    var village=$("#village").val();
                    var lga=$("#lga").val();
                    var nig_states=$("#nig_states").val();
                    var phone=$("#phone").val();
                    /*var thumbcode=$("#txtIsoTemplate").val();
                    var thumbcode_ANSI=$("#txtAnsiTemplate").val();  */

                    var thumbcode_ISO_indexleft = $("#txtIsoTemplate_indexleft").val();
                    var thumbcode_ANSI_indexleft = $("#txtAnsiTemplate_indexleft").val();
                    var thumbcode_ISO_thumbleft = $("#txtIsoTemplate_thumbleft").val();
                    var thumbcode_ANSI_thumbleft = $("#txtAnsiTemplate_thumbleft").val();
                    var thumbcode_ISO_indexright = $("#txtIsoTemplate_indexright").val();
                    var thumbcode_ANSI_indexright = $("#txtAnsiTemplate_indexright").val();
                    var thumbcode_ISO_thumbright = $("#txtIsoTemplate_thumbright").val();
                    var thumbcode_ANSI_thumbright = $("#txtAnsiTemplate_thumbright").val();
                    var mantra_mfs_100_serial = $("#mantra_mfs_100_serial").val();

                    var dclerk=$("#dclerk").val();
                    var gps=$("#gps").val();
                    var trans = $("#traineeID").val();
                    //alert (center_name_ID+ '-'+tname+ '-'+thumbcode+ '-'+dclerk);
                    var photo = document.getElementById("snapshot").innerHTML;
                    var init_photo = '<?php echo $init_photo; ?>';

                    if(imageAttached || init_photo)
                    {
                        $.post(destination,
                        {
                          logger_save: "logger_ext_post",
                          center_name_ID: center_name_ID,
                          //date: date,
                          tname: tname,
                          nig_states: nig_states,
                          village: village,
                          lga: lga,
                          phone: phone,
                          thumbcode_ISO_indexleft : thumbcode_ISO_indexleft,
                          thumbcode_ANSI_indexleft : thumbcode_ANSI_indexleft,
                          thumbcode_ISO_thumbleft : thumbcode_ISO_thumbleft,
                          thumbcode_ANSI_thumbleft : thumbcode_ANSI_thumbleft,
                          thumbcode_ISO_indexright : thumbcode_ISO_indexright,
                          thumbcode_ANSI_indexright : thumbcode_ANSI_indexright,
                          thumbcode_ISO_thumbright : thumbcode_ISO_thumbright,
                          thumbcode_ANSI_thumbright : thumbcode_ANSI_thumbright,
                          mantra_mfs_100_serial : mantra_mfs_100_serial,

                          dclerk: dclerk,
                          gps: gps,
                          dtrans: trans,
                          record_type: "trainee_location"
                        })
                        .done(function (data) 
                        {                       
                          
                          if(data != undefined)
                          {
                            console.log(data);
                            if(data.length > 0)
                            {
                                data = JSON.parse(data);
                                if(data[0] == '1')
                                {
                                    /*$("#trainee_location_handle").append('<i class="fa fa-check-square-o" style="font-size: 10px; color: #006400 !important; "></i>');*/
                                    $("#trainee_location_msg").html('<div class="alert alert-warning" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Saved Successfully but image not captured</strong></div>');   
                                    $("#traineeID").val(data[1]);   
                                    if(imageDataURI != '')
                                    {
                                        postImage();
                                    }                       
                                    //human_capital();
                                }
                                else if(data == '2')
                                {
                                    $("#trainee_location_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Updated Successfully</strong></div>');   
                                    if(imageDataURI != '')
                                    {
                                        postImage();
                                    }                                                        
                                    human_capital();
                                }
                                else if(data == '-1')
                                {
                                    $("#trainee_location_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fields are empty!</strong></div>');
                                }
                                else if(data == '01')
                                {
                                    $("#trainee_location_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong, record could not be saved!</strong></div>');
                                }
                                else if(data == '-200')
                                {
                                    $("#trainee_location_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record holder not known!</strong></div>');
                                }                           

                            }
                          }
                          //alert(data);

                        });
                    }
                    else
                    {
                        $("#trainee_location_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Please Capture Trainee Photo!</strong></div>');
                    }
                    

             });

            $("#human_capital_bt").click(function ()
             {
                    pageLoadingFrame("show");
                        setTimeout(function(){
                            pageLoadingFrame("hide");
                        },1500);

                    var center_name_ID=$("#center_name_ID").val();
                    var tname=$("#tname").val();
                    //var thumbcode=$("#txtIsoTemplate").val();
                    var trans = $("#traineeID").val();
                    //alert (center_name_ID+ '-'+tname+ '-'+thumbcode+ '-'+dclerk);
                    var tr_gender = $("#tr_gender").val();
                    var tr_age = $("#tr_age").val();
                    var tr_marital_st = $("#tr_marital_st").val();
                    var tn_male = $("#tn_male").val();
                    var tn_female = $("#tn_female").val();
                    var family_pos = $("#family_pos").val();
                    var avg_male = $("#avg_male").val();
                    var avg_female = $("#avg_female").val();
                    var male_sch = $("#male_sch").val();
                    var female_sch = $("#female_sch").val();
                    var out_village = $("#out_village").val();
                    var out_migrated = $("#out_migrated").val();
                    var edu_lev = $("#edu_lev").val();
                    var tech_train = $("#tech_train").val();
                    var cap_dev = $("#cap_dev").val();
                    var und_cap = $("#und_cap").val();
                    var annual_income = $("#annual_income").val();
                    var starter_pack = $("#starter_pack").val();
                    var mantra_mfs_100_serial = $("#mantra_mfs_100_serial").val();
                    

                    if((center_name_ID != '') && (tname != '') && (mantra_mfs_100_serial != '') && (trans>=1))
                    {
                        
                        $.post(destination,
                        {
                            logger_save: "logger_ext_post",
                            center_name_ID: center_name_ID,
                            tname: tname,
                            mantra_mfs_100_serial: mantra_mfs_100_serial,

                            tr_gender : tr_gender,
                            tr_age : tr_age,
                            tr_marital_st : tr_marital_st,
                            tn_male : tn_male,
                            tn_female : tn_female,
                            family_pos : family_pos,
                            avg_male : avg_male,
                            avg_female : avg_female,
                            male_sch : male_sch,
                            female_sch : female_sch,
                            out_village : out_village,
                            out_migrated : out_migrated,
                            edu_lev : edu_lev,
                            tech_train : tech_train,
                            cap_dev : cap_dev,
                            und_cap : und_cap,
                            annual_income : annual_income,
                            starter_pack : starter_pack,

                            dtrans: trans,
                            record_type: "human_capital"
                        })
                        .done(function (data) 
                        {                       
                            
                          if(data != undefined)
                          {
                            if(data.length > 0)
                            {
                                data = JSON.parse(data);
                                if(data == '1')
                                {
                                    $("#human_capital_handle").append('<i class="fa fa-check-square-o" style="font-size: 10px; color: #006400 !important; "></i>');
                                    $("#human_capital_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Saved Successfully</strong></div>');                        
                                    social_capital();
                                }
                                else if(data == '-1')
                                {
                                    $("#trainee_location_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fields are empty!</strong></div>');
                                    trainee_location();
                                }
                                else if(data == '01')
                                {
                                    $("#human_capital_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong, record could not be saved!</strong></div>');
                                }
                                else if(data == '-200')
                                {
                                    $("#human_capital_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record holder not known!</strong></div>');
                                }                           

                            }
                          }
                          //alert(data);

                        });
                    }
                    else
                    {
                        $("#trainee_location_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Please Provide Trainee Basic Info!</strong></div>');
                        trainee_location();
                    }
                    

             });
        
            $("#social_capital_bt").click(function ()
             {
                    pageLoadingFrame("show");
                        setTimeout(function(){
                            pageLoadingFrame("hide");
                        },1500);

                    var center_name_ID=$("#center_name_ID").val();
                    var tname=$("#tname").val();
                    //var thumbcode=$("#txtIsoTemplate").val();
                    var mantra_mfs_100_serial = $("#mantra_mfs_100_serial").val();
                    var trans = $("#traineeID").val();
                    //alert (center_name_ID+ '-'+tname+ '-'+thumbcode+ '-'+dclerk);
                    var part_soc_eco = $("#part_soc_eco").val();
                    var inv_soc_eco = $("#inv_soc_eco").val();
                    var con_ext = $("#con_ext").val();                

                    if((center_name_ID != '') && (tname != '') && (mantra_mfs_100_serial != '') && (trans>=1))
                    {
                        
                        $.post(destination,
                        {
                            logger_save: "logger_ext_post",
                            center_name_ID: center_name_ID,
                            tname: tname,
                            mantra_mfs_100_serial: mantra_mfs_100_serial,

                            part_soc_eco : part_soc_eco,
                            inv_soc_eco : inv_soc_eco,
                            con_ext : con_ext,

                            dtrans: trans,
                            record_type: "social_capital"
                        })
                        .done(function (data) 
                        {                       
                            
                          if(data != undefined)
                          {
                            if(data.length > 0)
                            {
                                data = JSON.parse(data);
                                if(data == '1')
                                {
                                    $("#social_capital_handle").append('<i class="fa fa-check-square-o" style="font-size: 10px; color: #006400 !important; "></i>');
                                    $("#social_capital_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Saved Successfully</strong></div>');                        
                                    natural_capital();
                                }
                                else if(data == '-1')
                                {
                                    $("#trainee_location_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fields are empty!</strong></div>');
                                    trainee_location();
                                }
                                else if(data == '01')
                                {
                                    $("#social_capital_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong, record could not be saved!</strong></div>');
                                }
                                else if(data == '-200')
                                {
                                    $("#social_capital_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record holder not known!</strong></div>');
                                }                           

                            }
                          }
                          //alert(data);

                        });
                    }
                    else
                    {
                        $("#trainee_location_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Please Provide Trainee Basic Info!</strong></div>');
                        trainee_location();
                    }
                    

             });

            $("#natural_capital_bt").click(function ()
             {
                    pageLoadingFrame("show");
                        setTimeout(function(){
                            pageLoadingFrame("hide");
                        },1500);

                    var center_name_ID=$("#center_name_ID").val();
                    var tname=$("#tname").val();
                    //var thumbcode=$("#txtIsoTemplate").val();
                    var mantra_mfs_100_serial = $("#mantra_mfs_100_serial").val();
                    var trans = $("#traineeID").val();
                    
                    var agric_land = $("#agric_land").val();
                    var land_own = $("#land_own").val();
                    var main_use = $("#main_use").val();
                    var energy_source = $("#energy_source").val();    

                    alert(center_name_ID+ '-'+tname+ '-'+mantra_mfs_100_serial+ '-'+dclerk);            

                    if((center_name_ID != '') && (tname != '') && (mantra_mfs_100_serial != '') && (trans>=1))
                    {
                        
                        $.post(destination,
                        {
                            logger_save: "logger_ext_post",
                            center_name_ID: center_name_ID,
                            tname: tname,
                            mantra_mfs_100_serial: mantra_mfs_100_serial,

                            agric_land : agric_land,
                            land_own : land_own,
                            main_use : main_use,
                            energy_source : energy_source,

                            dtrans: trans,
                            record_type: "natural_capital"
                        })
                        .done(function (data) 
                        {                       
                            
                          if(data != undefined)
                          {
                            if(data.length > 0)
                            {
                                data = JSON.parse(data);
                                if(data == '1')
                                {
                                    $("#natural_capital_handle").append('<i class="fa fa-check-square-o" style="font-size: 10px; color: #006400 !important; "></i>');
                                    $("#natural_capital_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Saved Successfully</strong></div>');                        
                                    physical_capital();
                                }
                                else if(data == '-1')
                                {
                                    $("#trainee_location_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fields are empty!</strong></div>');
                                    trainee_location();
                                }
                                else if(data == '01')
                                {
                                    $("#natural_capital_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong, record could not be saved!</strong></div>');
                                }
                                else if(data == '-200')
                                {
                                    $("#natural_capital_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record holder not known!</strong></div>');
                                }                           

                            }
                          }
                          //alert(data);

                        });
                    }
                    else
                    {
                        $("#trainee_location_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Please Provide Trainee Basic Info!</strong></div>');
                        trainee_location();
                    }
                    

             });

            $("#physical_capital_bt").click(function ()
             {
                    pageLoadingFrame("show");
                        setTimeout(function(){
                            pageLoadingFrame("hide");
                        },1500);

                    var center_name_ID=$("#center_name_ID").val();
                    var tname=$("#tname").val();
                    //var thumbcode=$("#txtIsoTemplate").val();
                    var mantra_mfs_100_serial = $("#mantra_mfs_100_serial").val();
                    var trans = $("#traineeID").val();
                    //alert (center_name_ID+ '-'+tname+ '-'+thumbcode+ '-'+dclerk);
                    var goods_tools = $("#goods_tools").val();
                    //console.log(goods_tools);
                    if((center_name_ID != '') && (tname != '') && (mantra_mfs_100_serial != '') && (trans>=1))
                    {
                        
                        $.post(destination,
                        {
                            logger_save: "logger_ext_post",
                            center_name_ID: center_name_ID,
                            tname: tname,
                            mantra_mfs_100_serial: mantra_mfs_100_serial,

                            goods_tools : goods_tools,

                            dtrans: trans,
                            record_type: "physical_capital"
                        })
                        .done(function (data) 
                        {                       
                            
                          if(data != undefined)
                          {
                            if(data.length > 0)
                            {
                                data = JSON.parse(data);
                                if(data == '1')
                                {
                                    $("#physical_capital_handle").append('<i class="fa fa-check-square-o" style="font-size: 10px; color: #006400 !important; "></i>');
                                    $("#physical_capital_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Saved Successfully</strong></div>');                        
                                    financial_capital();
                                }
                                else if(data == '-1')
                                {
                                    $("#trainee_location_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fields are empty!</strong></div>');
                                    trainee_location();
                                }
                                else if(data == '01')
                                {
                                    $("#physical_capital_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong, record could not be saved!</strong></div>');
                                }
                                else if(data == '-200')
                                {
                                    $("#physical_capital_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record holder not known!</strong></div>');
                                }                           

                            }
                          }
                          //alert(data);

                        });
                    }
                    else
                    {
                        $("#trainee_location_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Please Provide Trainee Basic Info!</strong></div>');
                        trainee_location();
                    }
                    

             });
            
            $("#financial_capital_bt").click(function ()
             {
                    pageLoadingFrame("show");
                        setTimeout(function(){
                            pageLoadingFrame("hide");
                        },1500);

                    // var center_name_ID=$("#center_name_ID").val();
                    var center_name_ID=$("#center_name_ID").val();
                    var tname=$("#tname").val();
                    //var thumbcode=$("#txtIsoTemplate").val();
                    var mantra_mfs_100_serial = $("#mantra_mfs_100_serial").val();
                    var trans = $("#traineeID").val();
                    //alert (center_name_ID+ '-'+tname+ '-'+thumbcode+ '-'+dclerk);
                    var first_source = $("#first_source").val();
                    var second_source = $("#second_source").val();
                    var trend_income = $("#trend_income").val();
                    var off_season = $("#off_season").val();
                    var cash_crops = $("#cash_crops").val();
                    var monetary = $("#monetary").val();
                    var sav_monetary = $("#sav_monetary").val();
                    var access_microcredit = $("#access_microcredit").val();
                    var no_cattle = $("#no_cattle").val();
                    var no_goats = $("#no_goats").val();
                    var no_sheep = $("#no_sheep").val();
                    var no_poultry = $("#no_poultry").val();
                    var male_schfees_spent = $("#male_schfees_spent").val();
                    var female_schfees_spent = $("#female_schfees_spent").val();
                    var male_amt_spent = $("#male_amt_spent").val();
                    var female_amt_spent = $("#female_amt_spent").val();                

                    if((center_name_ID != '') && (tname != '') && (mantra_mfs_100_serial != '') && (trans>=1))
                    {
                        
                        $.post(destination,
                        {
                            logger_save: "logger_ext_post",
                            center_name_ID: center_name_ID,
                            tname: tname,
                            mantra_mfs_100_serial: mantra_mfs_100_serial,

                            first_source : first_source,
                            second_source : second_source,
                            trend_income : trend_income,
                            off_season : off_season,
                            cash_crops : cash_crops,
                            monetary : monetary,
                            sav_monetary : sav_monetary,
                            access_microcredit : access_microcredit,
                            no_cattle : no_cattle,
                            no_goats : no_goats,
                            no_sheep : no_sheep,
                            no_poultry : no_poultry,
                            male_schfees_spent : male_schfees_spent,
                            female_schfees_spent : female_schfees_spent,
                            male_amt_spent : male_amt_spent,
                            female_amt_spent : female_amt_spent,

                            dtrans: trans,
                            record_type: "financial_capital"
                        })
                        .done(function (data) 
                        {                       
                            
                          if(data != undefined)
                          {
                            if(data.length > 0)
                            {
                                data = JSON.parse(data);
                                if(data == '1')
                                {
                                    $("#financial_capital_handle").append('<i class="fa fa-check-square-o" style="font-size: 10px; color: #006400 !important; "></i>');
                                    $("#financial_capital_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Saved Successfully</strong></div>');                        
                                    //social_capital();
                                    var redir = "<?php echo base_url() ?>"+'Trainee/profile/'+trans;
                                    location.assign(redir);
                                }
                                else if(data == '-1')
                                {
                                    $("#trainee_location_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fields are empty!</strong></div>');
                                    trainee_location();
                                }
                                else if(data == '01')
                                {
                                    $("#financial_capital_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong, record could not be saved!</strong></div>');
                                }
                                else if(data == '-200')
                                {
                                    $("#financial_capital_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record holder not known!</strong></div>');
                                }                           

                            }
                          }
                          //alert(data);

                        });
                    }
                    else
                    {
                        $("#trainee_location_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Please Provide Trainee Basic Info!</strong></div>');
                        trainee_location();
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
                        $("#trainee_location_handle").append('<i class="fa fa-check-square-o" style="font-size: 10px; color: #006400 !important; "></i>');
                        $("#trainee_location_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Saved Successfully</strong></div>');                            
                        human_capital();
                    }
                    else if(data == '-3')
                    {
                        $("#trainee_location_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong, image could not upload!</strong></div>');
                    }
                    else if(data == '2')
                    {
                        $("#trainee_location_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Updated Successfully</strong></div>');   
                                                
                        human_capital();
                    }

                    //alert(data);

                });

                

            }


            $("#fingerprint_alert_close").click(function()
            {
                $("#fingerprint_alert").removeClass("open");
            });

            
        </script>

        <!-- my added -->



        <!-- finger print sdk -->
        <script src="<?php echo base_url(); ?>gsi-assets/mantra_mfs_100_sdk_lib/jquery-1.8.2.js"></script>
        <script src="<?php echo base_url(); ?>gsi-assets/mantra_mfs_100_sdk_lib/mfs100-9.0.2.6.js"></script>
        <script language="javascript" type="text/javascript">


            var quality = 60; //(1 to 100) (recommanded minimum 55)
            var timeout = 10; // seconds (minimum=10(recommanded), maximum=60, unlimited=0 )

            function GetInfo() {
                document.getElementById('mantra_mfs_100_serial').value = "";
                /*document.getElementById('tdSerial').innerHTML = "";
                document.getElementById('tdCertification').innerHTML = "";
                document.getElementById('tdMake').innerHTML = "";
                document.getElementById('tdModel').innerHTML = "";
                document.getElementById('tdWidth').innerHTML = "";
                document.getElementById('tdHeight').innerHTML = "";
                document.getElementById('tdLocalMac').innerHTML = "";
                document.getElementById('tdLocalIP').innerHTML = "";
                document.getElementById('tdSystemID').innerHTML = "";
                document.getElementById('tdPublicIP').innerHTML = "";*/


                //var key = document.getElementById('txtKey').value;

                var res;
                res = GetMFS100Info();
                /*if (key.length == 0) {
                    res = GetMFS100Info();
                }
                else {
                    res = GetMFS100KeyInfo(key);
                }*/

                if (res.httpStaus) {

                    // document.getElementById('txtStatus').value = "ErrorCode: " + res.data.ErrorCode + " ErrorDescription: " + res.data.ErrorDescription;

                    if (res.data.ErrorCode == "0") {
                        document.getElementById('mantra_mfs_100_serial').value = res.data.DeviceInfo.SerialNo;
                        /*document.getElementById('tdSerial').innerHTML = res.data.DeviceInfo.SerialNo;
                        document.getElementById('tdCertification').innerHTML = res.data.DeviceInfo.Certificate;
                        document.getElementById('tdMake').innerHTML = res.data.DeviceInfo.Make;
                        document.getElementById('tdModel').innerHTML = res.data.DeviceInfo.Model;
                        document.getElementById('tdWidth').innerHTML = res.data.DeviceInfo.Width;
                        document.getElementById('tdHeight').innerHTML = res.data.DeviceInfo.Height;
                        document.getElementById('tdLocalMac').innerHTML = res.data.DeviceInfo.LocalMac;
                        document.getElementById('tdLocalIP').innerHTML = res.data.DeviceInfo.LocalIP;
                        document.getElementById('tdSystemID').innerHTML = res.data.DeviceInfo.SystemID;
                        document.getElementById('tdPublicIP').innerHTML = res.data.DeviceInfo.PublicIP;*/
                    }
                }
                else {
                    alert(res.err);
                }
                return false;
            }

            function Capture(fing_val) {
                try {
                    /*document.getElementById('imgFinger').src = "data:image/bmp;base64,";
                    document.getElementById('txtIsoTemplate').value = "";
                    document.getElementById('txtAnsiTemplate').value = "";*/
                    
                    /*document.getElementById('txtStatus').value = "";
                    document.getElementById('txtImageInfo').value = "";
                    document.getElementById('txtIsoImage').value = "";
                    document.getElementById('txtRawData').value = "";
                    document.getElementById('txtWsqData').value = "";*/

                    //alert(fing_val);

                    var res = CaptureFinger(quality, timeout);
                    if (res.httpStaus) {

                        /*document.getElementById('txtStatus').value = "ErrorCode: " + res.data.ErrorCode + " ErrorDescription: " + res.data.ErrorDescription;*/

                        if (res.data.ErrorCode == "0") {
                            
                            if(fing_val == 'leftindex')
                            {
                                var tosearch = res.data.IsoTemplate;
                                var gallery_template = document.getElementById("fingerdata").value;
                                gallery_template = atob(gallery_template);
                                gallery_template = JSON.parse(gallery_template);
                                var fingerdata_found = false;
                                for (var i = 0; i < gallery_template.length; i++) 
                                {
                                    var veryvery = Verify(tosearch, gallery_template[i]);
                                    if(veryvery==1)
                                    {
                                        fingerdata_found = true;
                                    }
                                }
                                if(fingerdata_found)
                                {
                                    $("#fingerprint_alert").addClass("open");
                                }
                                else
                                {
                                    GetInfo();
                                    document.getElementById('imgFinger_leftindex').src = "data:image/bmp;base64," + res.data.BitmapData;
                                    var imageinfo = "Quality: " + res.data.Quality + " Nfiq: " + res.data.Nfiq + " W(in): " + res.data.InWidth + " H(in): " + res.data.InHeight + " area(in): " + res.data.InArea + " Resolution: " + res.data.Resolution + " GrayScale: " + res.data.GrayScale + " Bpp: " + res.data.Bpp + " WSQCompressRatio: " + res.data.WSQCompressRatio + " WSQInfo: " + res.data.WSQInfo;

                                    document.getElementById('txtIsoTemplate_indexleft').value = res.data.IsoTemplate;
                                    document.getElementById('txtAnsiTemplate_indexleft').value = res.data.AnsiTemplate;

                                    $("#thumbsuccessind_leftindex").removeClass("hidden");   
                                }

                                
                            }
                            else if(fing_val == 'leftthumb')
                            {
                                var tosearch = res.data.IsoTemplate;
                                var gallery_template = document.getElementById("fingerdata").value;
                                gallery_template = atob(gallery_template);
                                gallery_template = JSON.parse(gallery_template);
                                var fingerdata_found = false;
                                for (var i = 0; i < gallery_template.length; i++) 
                                {
                                    var veryvery = Verify(tosearch, gallery_template[i]);
                                    if(veryvery==1)
                                    {
                                        fingerdata_found = true;
                                    }
                                }
                                if(fingerdata_found)
                                {
                                    $("#fingerprint_alert").addClass("open");
                                }
                                else
                                {
                                    GetInfo();
                                    document.getElementById('imgFinger_leftthumb').src = "data:image/bmp;base64," + res.data.BitmapData;
                                    var imageinfo = "Quality: " + res.data.Quality + " Nfiq: " + res.data.Nfiq + " W(in): " + res.data.InWidth + " H(in): " + res.data.InHeight + " area(in): " + res.data.InArea + " Resolution: " + res.data.Resolution + " GrayScale: " + res.data.GrayScale + " Bpp: " + res.data.Bpp + " WSQCompressRatio: " + res.data.WSQCompressRatio + " WSQInfo: " + res.data.WSQInfo;

                                    document.getElementById('txtIsoTemplate_thumbleft').value = res.data.IsoTemplate;
                                    document.getElementById('txtAnsiTemplate_thumbleft').value = res.data.AnsiTemplate;

                                    $("#thumbsuccessind_leftthumb").removeClass("hidden");   
                                }

                                
                            }

                            else if(fing_val == 'rightindex')
                            {
                                var tosearch = res.data.IsoTemplate;
                                var gallery_template = document.getElementById("fingerdata").value;
                                gallery_template = atob(gallery_template);
                                gallery_template = JSON.parse(gallery_template);
                                var fingerdata_found = false;
                                for (var i = 0; i < gallery_template.length; i++) 
                                {
                                    var veryvery = Verify(tosearch, gallery_template[i]);
                                    if(veryvery==1)
                                    {
                                        fingerdata_found = true;
                                    }
                                }
                                if(fingerdata_found)
                                {
                                    $("#fingerprint_alert").addClass("open");
                                }
                                else
                                {
                                    GetInfo();
                                    document.getElementById('imgFinger_rightindex').src = "data:image/bmp;base64," + res.data.BitmapData;
                                    var imageinfo = "Quality: " + res.data.Quality + " Nfiq: " + res.data.Nfiq + " W(in): " + res.data.InWidth + " H(in): " + res.data.InHeight + " area(in): " + res.data.InArea + " Resolution: " + res.data.Resolution + " GrayScale: " + res.data.GrayScale + " Bpp: " + res.data.Bpp + " WSQCompressRatio: " + res.data.WSQCompressRatio + " WSQInfo: " + res.data.WSQInfo;

                                    document.getElementById('txtIsoTemplate_indexright').value = res.data.IsoTemplate;
                                    document.getElementById('txtAnsiTemplate_indexright').value = res.data.AnsiTemplate;

                                    $("#thumbsuccessind_rightindex").removeClass("hidden");   
                                }

                                
                            }
                            else if(fing_val == 'rightthumb')
                            {
                                var tosearch = res.data.IsoTemplate;
                                var gallery_template = document.getElementById("fingerdata").value;
                                gallery_template = atob(gallery_template);
                                gallery_template = JSON.parse(gallery_template);
                                var fingerdata_found = false;
                                for (var i = 0; i < gallery_template.length; i++) 
                                {
                                    var veryvery = Verify(tosearch, gallery_template[i]);
                                    if(veryvery==1)
                                    {
                                        fingerdata_found = true;
                                    }
                                }
                                if(fingerdata_found)
                                {
                                    $("#fingerprint_alert").addClass("open");
                                }
                                else
                                {
                                    GetInfo();
                                    document.getElementById('imgFinger_rightthumb').src = "data:image/bmp;base64," + res.data.BitmapData;
                                    var imageinfo = "Quality: " + res.data.Quality + " Nfiq: " + res.data.Nfiq + " W(in): " + res.data.InWidth + " H(in): " + res.data.InHeight + " area(in): " + res.data.InArea + " Resolution: " + res.data.Resolution + " GrayScale: " + res.data.GrayScale + " Bpp: " + res.data.Bpp + " WSQCompressRatio: " + res.data.WSQCompressRatio + " WSQInfo: " + res.data.WSQInfo;
                                    
                                    document.getElementById('txtIsoTemplate_thumbright').value = res.data.IsoTemplate;
                                    document.getElementById('txtAnsiTemplate_thumbright').value = res.data.AnsiTemplate;

                                    $("#thumbsuccessind_rightthumb").removeClass("hidden");   
                                }

                                
                            }
                            else
                            {
                                var tosearch = res.data.IsoTemplate;
                                var gallery_template = document.getElementById("fingerdata").value;
                                gallery_template = atob(gallery_template);
                                gallery_template = JSON.parse(gallery_template);
                                var fingerdata_found = false;
                                for (var i = 0; i < gallery_template.length; i++) 
                                {
                                    var veryvery = Verify(tosearch, gallery_template[i]);
                                    if(veryvery==1)
                                    {
                                        fingerdata_found = true;
                                    }
                                }
                                if(fingerdata_found)
                                {
                                    $("#fingerprint_alert").addClass("open");
                                }
                                else
                                    alert("this is unique");
                                
                            }

                            /*document.getElementById('txtImageInfo').value = imageinfo;                           
                            document.getElementById('txtIsoImage').value = res.data.IsoImage;
                            document.getElementById('txtRawData').value = res.data.RawData;
                            document.getElementById('txtWsqData').value = res.data.WsqImage;*/
                        }
                        else
                            alert("Scanner not connected " + res.data.ErrorCode);
                    }
                    else {
                        alert(res.err);
                    }
                }
                catch (e) {
                    alert(e);
                }
                return false;
            }

            function Verify(query_iso, from_other_iso) {
                try {
                    //var isotemplate = document.getElementById('txtIsoTemplate').value;
                    //var res = VerifyFinger(isotemplate, isotemplate);
                    var res = VerifyFinger(query_iso, from_other_iso);

                    if (res.httpStaus) {
                        if (res.data.Status) {
                            //alert("Finger matched");
                            return 1;
                        }
                        else {
                            if (res.data.ErrorCode != "0") {
                                //alert(res.data.ErrorDescription);
                                return res.data.ErrorDescription;
                            }
                            else {
                                //alert("Finger not matched");
                                return 0;
                            }
                        }
                    }
                    else {
                        //alert(res.err);
                        return res.err;
                    }
                }
                catch (e) {
                    //alert(e);
                    return e;
                }
                return false;

            }

            function Match() {
                try {
                    var isotemplate = document.getElementById('txtIsoTemplate').value;
                    var res = MatchFinger(quality, timeout, isotemplate);

                    if (res.httpStaus) {
                        if (res.data.Status) {
                            alert("Finger matched");
                        }
                        else {
                            if (res.data.ErrorCode != "0") {
                                alert(res.data.ErrorDescription);
                            }
                            else {
                                alert("Finger not matched");
                            }
                        }
                    }
                    else {
                        alert(res.err);
                    }
                }
                catch (e) {
                    alert(e);
                }
                return false;

            }

            function GetPid() {
                try {
                    var isoTemplateFMR = document.getElementById('txtIsoTemplate').value;
                    var isoImageFIR = document.getElementById('txtIsoImage').value;

                    var Biometrics = Array(); // You can add here multiple FMR value
                    Biometrics["0"] = new Biometric("FMR", isoTemplateFMR, "UNKNOWN", "", "");

                    var res = GetPidData(Biometrics);
                    if (res.httpStaus) {
                        if (res.data.ErrorCode != "0") {
                            alert(res.data.ErrorDescription);
                        }
                        else {
                            document.getElementById('txtPid').value = res.data.PidData.Pid
                            document.getElementById('txtSessionKey').value = res.data.PidData.Sessionkey
                            document.getElementById('txtHmac').value = res.data.PidData.Hmac
                            document.getElementById('txtCi').value = res.data.PidData.Ci
                            document.getElementById('txtPidTs').value = res.data.PidData.PidTs
                        }
                    }
                    else {
                        alert(res.err);
                    }

                }
                catch (e) {
                    alert(e);
                }
                return false;
            }
            function GetProtoPid() {
                try {
                    var isoTemplateFMR = document.getElementById('txtIsoTemplate').value;
                    var isoImageFIR = document.getElementById('txtIsoImage').value;

                    var Biometrics = Array(); // You can add here multiple FMR value
                    Biometrics["0"] = new Biometric("FMR", isoTemplateFMR, "UNKNOWN", "", "");

                    var res = GetProtoPidData(Biometrics);
                    if (res.httpStaus) {
                        if (res.data.ErrorCode != "0") {
                            alert(res.data.ErrorDescription);
                        }
                        else {
                            document.getElementById('txtPid').value = res.data.PidData.Pid
                            document.getElementById('txtSessionKey').value = res.data.PidData.Sessionkey
                            document.getElementById('txtHmac').value = res.data.PidData.Hmac
                            document.getElementById('txtCi').value = res.data.PidData.Ci
                            document.getElementById('txtPidTs').value = res.data.PidData.PidTs
                        }
                    }
                    else {
                        alert(res.err);
                    }

                }
                catch (e) {
                    alert(e);
                }
                return false;
            }
            function GetRbd() {
                try {
                    var isoTemplateFMR = document.getElementById('txtIsoTemplate').value;
                    var isoImageFIR = document.getElementById('txtIsoImage').value;

                    var Biometrics = Array();
                    Biometrics["0"] = new Biometric("FMR", isoTemplateFMR, "LEFT_INDEX", 2, 1);
                    Biometrics["1"] = new Biometric("FMR", isoTemplateFMR, "LEFT_MIDDLE", 2, 1);
                    // Here you can pass upto 10 different-different biometric object.


                    var res = GetRbdData(Biometrics);
                    if (res.httpStaus) {
                        if (res.data.ErrorCode != "0") {
                            alert(res.data.ErrorDescription);
                        }
                        else {
                            document.getElementById('txtPid').value = res.data.RbdData.Rbd
                            document.getElementById('txtSessionKey').value = res.data.RbdData.Sessionkey
                            document.getElementById('txtHmac').value = res.data.RbdData.Hmac
                            document.getElementById('txtCi').value = res.data.RbdData.Ci
                            document.getElementById('txtPidTs').value = res.data.RbdData.RbdTs
                        }
                    }
                    else {
                        alert(res.err);
                    }

                }
                catch (e) {
                    alert(e);
                }
                return false;
            }

            function GetProtoRbd() {
                try {
                    var isoTemplateFMR = document.getElementById('txtIsoTemplate').value;
                    var isoImageFIR = document.getElementById('txtIsoImage').value;

                    var Biometrics = Array();
                    Biometrics["0"] = new Biometric("FMR", isoTemplateFMR, "LEFT_INDEX", 2, 1);
                    Biometrics["1"] = new Biometric("FMR", isoTemplateFMR, "LEFT_MIDDLE", 2, 1);
                    // Here you can pass upto 10 different-different biometric object.


                    var res = GetProtoRbdData(Biometrics);
                    if (res.httpStaus) {
                        if (res.data.ErrorCode != "0") {
                            alert(res.data.ErrorDescription);
                        }
                        else {
                            document.getElementById('txtPid').value = res.data.RbdData.Rbd
                            document.getElementById('txtSessionKey').value = res.data.RbdData.Sessionkey
                            document.getElementById('txtHmac').value = res.data.RbdData.Hmac
                            document.getElementById('txtCi').value = res.data.RbdData.Ci
                            document.getElementById('txtPidTs').value = res.data.RbdData.RbdTs
                        }
                    }
                    else {
                        alert(res.err);
                    }

                }
                catch (e) {
                    alert(e);
                }
                return false;
            }
        </script>
        <!-- finger print sdk -->
            
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

            $(".sel_specify").change( function()
            {
                var id_sel = $(this).attr('id');
                if((id_sel == 'cap_dev')||(id_sel == 'cap_dev_111'))
                {
                    var selchangevalue = $("#cap_dev").val();
                    if(selchangevalue == '10')
                    {
                        $("#cap_dev").removeAttr("id");
                        $(this).attr('id','cap_dev_111');
                        var apendel = '<input type="text" class="form-control" id="cap_dev" placeholder="Please specify here"/>';
                        var fgg = $(this).closest('.sel_specify_holder').attr('id','cap_dev_000');
                        //console.log(fgg);
                        $("#cap_dev_000").append(apendel);
                    }
                    else
                    {
                        var fgg2 = document.getElementById("cap_dev_111");
                        if(fgg2 != null)
                        {
                            $("#cap_dev").remove();
                            $(this).attr('id','cap_dev');
                        }
                        
                    }
                    
                }
                else if((id_sel == 'inv_soc_eco')||(id_sel == 'inv_soc_eco_111'))
                {
                    var selchangevalue = $("#inv_soc_eco").val();
                    if(selchangevalue == '12')
                    {
                        $("#inv_soc_eco").removeAttr("id");
                        $(this).attr('id','inv_soc_eco_111');
                        var apendel = '<input type="text" class="form-control" id="inv_soc_eco" placeholder="Please specify here"/>';
                        var fgg = $(this).closest('.sel_specify_holder').attr('id','inv_soc_eco_000');
                        //console.log(fgg);
                        $("#inv_soc_eco_000").append(apendel);
                    }
                    else
                    {
                        var fgg2 = document.getElementById("inv_soc_eco_111");
                        if(fgg2 != null)
                        {
                            $("#inv_soc_eco").remove();
                            $(this).attr('id','inv_soc_eco');
                        }
                        
                    }
                    
                }
                else if((id_sel == 'con_ext')||(id_sel == 'con_ext_111'))
                {
                    var selchangevalue = $("#con_ext").val();
                    if(selchangevalue == '7')
                    {
                        $("#con_ext").removeAttr("id");
                        $(this).attr('id','con_ext_111');
                        var apendel = '<input type="text" class="form-control" id="con_ext" placeholder="Please specify here"/>';
                        var fgg = $(this).closest('.sel_specify_holder').attr('id','con_ext_000');
                        //console.log(fgg);
                        $("#con_ext_000").append(apendel);
                    }
                    else
                    {
                        var fgg2 = document.getElementById("con_ext_111");
                        if(fgg2 != null)
                        {
                            $("#con_ext").remove();
                            $(this).attr('id','con_ext');
                        }
                        
                    }
                    
                }
                else if((id_sel == 'goods_tools')||(id_sel == 'goods_tools_111'))
                {
                    var selchangevalue = $("#goods_tools").val();
                    if(selchangevalue == '12')
                    {
                        $("#goods_tools").removeAttr("id");
                        $(this).attr('id','goods_tools_111');
                        var apendel = '<input type="text" class="form-control" id="goods_tools" placeholder="Please specify here"/>';
                        var fgg = $(this).closest('.sel_specify_holder').attr('id','goods_tools_000');
                        //console.log(fgg);
                        $("#goods_tools_000").append(apendel);
                    }
                    else
                    {
                        var fgg2 = document.getElementById("goods_tools_111");
                        if(fgg2 != null)
                        {
                            $("#goods_tools").remove();
                            $(this).attr('id','goods_tools');
                        }
                        
                    }
                    
                }
                else if((id_sel == 'first_source')||(id_sel == 'first_source_111'))
                {
                    var selchangevalue = $("#first_source").val();
                    if(selchangevalue == '10')
                    {
                        $("#first_source").removeAttr("id");
                        $(this).attr('id','first_source_111');
                        var apendel = '<input type="text" class="form-control" id="first_source" placeholder="Please specify here"/>';
                        var fgg = $(this).closest('.sel_specify_holder').attr('id','first_source_000');
                        //console.log(fgg);
                        $("#first_source_000").append(apendel);
                    }
                    else
                    {
                        var fgg2 = document.getElementById("first_source_111");
                        if(fgg2 != null)
                        {
                            $("#first_source").remove();
                            $(this).attr('id','first_source');
                        }
                        
                    }
                    
                }
                else if((id_sel == 'second_source')||(id_sel == 'second_source_111'))
                {
                    var selchangevalue = $("#second_source").val();
                    if(selchangevalue == '10')
                    {
                        $("#second_source").removeAttr("id");
                        $(this).attr('id','second_source_111');
                        var apendel = '<input type="text" class="form-control" id="second_source" placeholder="Please specify here"/>';
                        var fgg = $(this).closest('.sel_specify_holder').attr('id','second_source_000');
                        //console.log(fgg);
                        $("#second_source_000").append(apendel);
                    }
                    else
                    {
                        var fgg2 = document.getElementById("second_source_111");
                        if(fgg2 != null)
                        {
                            $("#second_source").remove();
                            $(this).attr('id','second_source');
                        }
                        
                    }
                    
                }
                else if((id_sel == 'energy_source')||(id_sel == 'energy_source_111'))
                {
                    var selchangevalue = $("#energy_source").val();
                    if(selchangevalue == '6')
                    {
                        $("#energy_source").removeAttr("id");
                        $(this).attr('id','energy_source_111');
                        var apendel = '<input type="text" class="form-control" id="energy_source" placeholder="Please specify here"/>';
                        var fgg = $(this).closest('.sel_specify_holder').attr('id','energy_source_000');
                        //console.log(fgg);
                        $("#energy_source_000").append(apendel);
                    }
                    else
                    {
                        var fgg2 = document.getElementById("energy_source_111");
                        if(fgg2 != null)
                        {
                            $("#energy_source").remove();
                            $(this).attr('id','energy_source');
                        }
                        
                    }
                    
                }

                
            });

            //window.open('file:///C:"Buziol Games"/"Mario Forever"/"Mario Forever.exe"');
        </script>
        
       
    </body>

</html>






