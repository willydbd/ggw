<!DOCTYPE html>
<html lang="en">
    
<head>        
        <!-- META SECTION -->
        <?php $this->load->view('wp-includes/meta'); ?>
        <title>National Agency for the Great Green Wall - List of Trainee</title>    

        <style type="text/css">
            @media print {
            body * {
              visibility: hidden;
              border: none;
            }
            #section-to-print, #section-to-print * {
              visibility: visible;
              width: 100%;
            }
            #naggw_logo
            {
                float: left;
                width: 22%;
            }
            #section-to-print .control-label{
                text-align: left;
            }
            #section-to-print .panel{
                float: left;
                width: 100%;
                margin-bottom: 20px;
                position: relative;
            }
            #section-to-print .col-md-3 {
                width: 25%;
                float: left;
            }
            #section-to-print .col-md-6 {
                width: 50%;
                float: left;
            }
            #section-to-print .col-md-5 {
                /*width: 30%;*/
                text-align: left;
            }
            #section-to-print label
            {
                border-right: 1px dashed #D5D5D5;
            }
            #section-to-print .col-md-7 {
                /*width: 60%;*/
                text-align: right;
                margin-top: -40px;
            }

          } 
        </style>     

        
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
                    <h2><a href="<?php echo base_url(); ?>Trainee/entry_gate" class="fa fa-arrow-circle-o-left"></a> TRAINEE PROFILE</h2>
                    <button id="printButton" class="btn btn-default pull-right"><span class="fa fa-print"></span> Print Photocard</button>
                </div>
                <!-- END PAGE TITLE -->                
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                    <input type="hidden" id="traineeID" value="<?php echo $trans; ?>">
                    <?php
                    $center_name = "National Agency for the Great Green Wall";
                        if(!empty($trainee_location_data) && is_array($trainee_location_data))
                        {
                            $trld_val = $trainee_location_data[0];
                            $trid = $trld_val['trid'];
                            $name = $trld_val['ntr'];
                            $age = $trld_val['age'];
                            $gender = $trld_val['gen'];
                            $state = $trld_val['state'];
                            $lga = $trld_val['lga'];
                            $vill = $trld_val['vill'];
                            $phone = $trld_val['phone'];
                            $photo = $trld_val['photo'];
                            $an_inc = $trld_val['an_inc'];
                            $center_name_ID = $trld_val['cid'];
                            $marital_st = $trld_val['marital_st'];
                            $tot_child = $trld_val['no_male'] + $trld_val['no_female'];
                            $edu_lev = $trld_val['edu_lev'];
                            $tech_train = $trld_val['tech_train'];
                            $cap_dev = $trld_val['cap_dev'];
                            $skills_needed = $trld_val['skills_needed'];
                            $f_income = $trld_val['f_income'];
                            $s_income = $trld_val['s_income'];
                            $soc_grp = $trld_val['soc_grp'];
                            $center_name = $trld_val['center_name'];

                            if($tot_child >1)
                                $tot_child = $tot_child.' Children';
                            else
                                $tot_child = $tot_child.' Child';
                            
                            
                            if($gender==1)
                                $gender = 'Male';
                            else
                                $gender = 'Female';

                            $photopath = base_url().'gsi-assets/image_uploads/trainee_center_'.$center_name_ID.'/'.$photo;
                            //var_dump($photopath);
                            if(!empty($photo) && (@getimagesize($photopath)))
                            {
                                $init_photo = $photopath;
                                $photo = '<img src="'.$photopath.'" style="width: 100%;" class="img-thumbnail">';
                            }

                            /* $center_name_ID = $data_entry_clerk = '1';
                             if(!empty($_SESSION['result_gate_Data_Entry_Clerk']))
                                $data_entry_clerk = $_SESSION['result_gate_Data_Entry_Clerk'];

                             if(!empty($_SESSION['result_gate_CENTER_ID']))
                                $center_name_ID = $_SESSION['result_gate_CENTER_ID'];*/

                             //$an_inc = 'NAGGW-'.sprintf("%04s",$trid);
                             $an_inc = 'NAGGW-'.$center_name_ID.'-'.sprintf("%04s",$trid);

                            
                        }
                    ?>
                    <div class="row">
                        <div class="col-md-12" id="trainee_location">
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-colorful" id="section-to-print">                                
                                <div class="panel-body"> 
                                    <div class="col-md-3">
                            
                                        <form action="#" class="form-horizontal">
                                        <div class="panel panel-default" style="border: none; box-shadow: none;">                                
                                            <div class="panel-body text-center">
                                                
                                                <div class="text-center" id="user_image">
                                                    <?php echo $photo ?>
                                                </div> 
                                                <br>    
                                                <h3><span class="fa fa-user"></span> <?php echo $name ?></h3>
                                                <h3><span class="fa fa-phone-square"></span> <?php echo $phone ?></h3>
                                                <h3><span class="glyphicon glyphicon-map-marker"></span> <?php echo $vill ?></h3>
                                                <p><?php echo $state ?> | <?php echo $lga ?> L.G.A</p>
                                                <p><?php echo $gender ?> | <?php echo $age ?></p>
                                                <p><?php echo $marital_st ?> | <?php echo $tot_child ?></p>                               
                                            </div>
                                            
                                        </div>
                                        </form>
                                        
                                    </div>

                                    <div class="col-md-6" style="border-right: solid 1px #154c3a; border-left: solid 1px #154c3a;">
                            
                                        <div class="panel panel-default" style="border: none;box-shadow: none;">
                                            <div class="panel-body">
                                                <img id="naggw_logo" src="<?php echo base_url(); ?>gsi-assets/logo.jpg" alt="NAGGW logo" style="width: 22%; float: left; margin-right: 10px;margin-top: -8px;" />
                                                <div id="company_name" style="margin-top: 5px;">
                                                    <h3 class="text-center" style="line-height: 1.3"> NATIONAL AGENCY FOR THE GREAT GREEN WALL</h3>
                                                    <h3 class="text-center" style="font-size: 15px;"><?php echo strtoupper($center_name); ?></h3>                                                   
                                                </div>
                                                
                                                
                                            </div>
                                            <div class="panel-body form-group-separated">
                                                <form action="#" class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="col-md-5 control-label">Registration ID</label>
                                                        <div class="col-md-7">
                                                            <h3 style="font-size: 14px;"><?php echo $an_inc ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5 control-label">Primary Occupation</label>
                                                        <div class="col-md-7">
                                                            <h3 style="font-size: 14px;"><?php echo $f_income ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5 control-label">Secondary Occupation</label>
                                                        <div class="col-md-7">
                                                            <h3 style="font-size: 14px;"><?php echo $s_income ?></h3>
                                                        </div>
                                                    </div>                                                    
                                                    <div class="form-group">
                                                        <label class="col-md-5 control-label">Highest level of Educ.</label>
                                                        <div class="col-md-7">
                                                            <h3 style="font-size: 14px;"><?php echo $edu_lev ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5 control-label">Training/Skills Interested</label>
                                                        <div class="col-md-7">
                                                            <h3 style="font-size: 14px;"><?php echo $skills_needed ?></h3>
                                                        </div>
                                                    </div>                                          
                                                </form>
                                            </div>
                                        </div>
                                        
                                        
                                        

                                    </div>

                                    <div class="col-md-3">
                                        <div class="panel panel-default form-horizontal" style="border: none; box-shadow: none;">
                                            <!-- <div class="panel-body text-center" style="margin-bottom: -50px;"> -->
                                            <div class="panel-body text-center">
                                                <h3><span class="fa fa-info-circle"></span> Quick Info</h3>
                                                <p>Some quick info about this trainee</p>
                                                <!-- <img src="<?php echo base_url(); ?>gsi-assets/fingerprint.png" alt="fingerprint" style="width: 80%; margin-top: -8px;" />
                                                <span class="fa fa-check text-success" style="font-size: 50px; position: relative; top: -51px; right: -60px;"></span> -->
                                            </div>
                                            <div class="panel-body form-group-separated">                                    
                                                <!-- <div class="form-group" style="word-break: break-all;">
                                                    Rk1SACAyMAAAAADAAAABPAFiAMUAxQEAAAAoG4C+ALT3AEDtALb+AID4ALF8AEEBALtwAICeAQnuAIEMAHH1AIDxAEf/AECJAT3aAEAhALkMAEC+AKN+AIC2AIT+AED/AMnsAED2AIz1AEEPALl9AEElAJpyAEA+AN0DAEDbACoEAECGACUMAECTALj5AID2AMNzAIEBALLzAEEHAML1AICVASDpAIBZAQ79AIAyAKmMAIB0AUPZAEBmAUnaAAAA
                                                </div> -->
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label">Technical Train. Undertaken</label>
                                                    <div class="col-md-6 line-height-30"><?php echo $tech_train ?></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label">Skills/Capacity Dev. Needed </label>
                                                    <div class="col-md-6 line-height-30"><?php echo $cap_dev; ?></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label">Socio-Economic Group Involved </label>
                                                    <div class="col-md-6 line-height-30"><?php echo $soc_grp; ?></div>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                        
                                    </div>

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
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/tableexport/tableExport.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/tableexport/jquery.base64.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/tableexport/html2canvas.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/tableexport/jspdf/libs/sprintf.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/tableexport/jspdf/jspdf.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/tableexport/jspdf/libs/base64.js"></script>
        
        <!-- END PAGE PLUGINS -->
        
        <!-- START TEMPLATE -->
        <!-- <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/settings.js"></script> -->
        
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins.js"></script>        
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/actions.js"></script>        
        <!-- END TEMPLATE -->

       <script>
           $("#printButton").click(function(){
          window.print();
        });
       </script>

        
            
    
       
    </body>

</html>






