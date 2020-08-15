<!DOCTYPE html>
<html lang="en">
    
<head>        
        <!-- META SECTION -->
        <?php $this->load->view('super_admin/wp-includes/meta'); ?>
        <title>National Agency for the Great Green Wall - Adhoc Staff Profile</title>    

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
            #adhoc_passport
            {
                /*float: right;*/
                position: relative;
                right: -30px;
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
            #section-to-print .col-md-2 {
                width: 16%;
                float: left;
            }
            #section-to-print .col-md-8 {
                width: 66%;
                float: left;
            }
            #section-to-print .col-md-9 {
                width: 80%;
                float: left;
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
            <?php $this->load->view('super_admin/wp-includes/sidebar'); ?>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <?php $this->load->view('super_admin/wp-includes/header'); ?>
                <!-- END X-NAVIGATION VERTICAL -->                     

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>Admin/entry_gate">Dashboard</a></li>
                    <li class="active">Adhoc Staff Profile</li>
                </ul>
                <!-- END BREADCRUMB --> 
                
                <!-- PAGE TITLE -->
                <div class="page-title">                    
                    <h2><a href="<?php echo base_url(); ?>Admin/entry_gate" class="fa fa-arrow-circle-o-left"></a> ADHOC STAFF PROFILE</h2>
                    <button id="printButton" class="btn btn-default pull-right"><span class="fa fa-print"></span> Print Photocard</button>
                </div>
                <!-- END PAGE TITLE -->                
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                    <input type="hidden" id="traineeID" value="<?php echo $trans; ?>">
                    <?php
                    $center_name = "National Agency for the Great Green Wall";
                        if(!empty($adhoc_basic_info_data) && is_array($adhoc_basic_info_data))
                        {
                            $trld_val = $adhoc_basic_info_data[0];
                            $trid = $trld_val['id'];
                            $surname = $trld_val['surname'];
                            $firstname = $trld_val['firstname'];
                            $lastname = $trld_val['lastname'];
                            $gender = $trld_val['gender'];
                            $state = $trld_val['state'];
                            $role = $trld_val['role'];
                            $site_center_id = $trld_val['site_center_id'];
                            $phone = $trld_val['phone'];
                            $photo = $trld_val['photo'];
                            $lga = $trld_val['lga'];

                            
                            
                            
                            if($gender==1)
                                $gender = 'Male';
                            else
                                $gender = 'Female';

                            $photopath = base_url().'gsi-assets/image_uploads/adhoc_staff/'.$photo;
                            //$photopath = base_url().'gsi-assets/image_uploads/trainee_center_id/1574775566_1.jpg';
                            
                            //var_dump($photopath);
                            if(!empty($photo) && (@getimagesize($photopath)))
                            {
                                $init_photo = $photopath;
                                $photo = '<img id="adhoc_passport" src="'.$photopath.'" style="width: 100%;margin-top: -5px; height: 85px;" class="img-thumbnail">';
                                
                            }

                            /* $center_name_ID = $data_entry_clerk = '1';
                             if(!empty($_SESSION['result_gate_Data_Entry_Clerk']))
                                $data_entry_clerk = $_SESSION['result_gate_Data_Entry_Clerk'];

                             if(!empty($_SESSION['result_gate_CENTER_ID']))
                                $center_name_ID = $_SESSION['result_gate_CENTER_ID'];*/

                             //$an_inc = 'NAGGW-'.sprintf("%04s",$trid);
                             $an_inc = 'NAGGWAD-'.$site_center_id.'-'.sprintf("%04s",$trid);

                            if(!empty($basic_site_info_data) && is_array($basic_site_info_data))
                            {
                                foreach ($basic_site_info_data as $key => $val) 
                                {
                                    $center_name_val = $val["id"];
                                    
                                    if($site_center_id == $center_name_val)
                                    {
                                        $center_name = $val["center_name"];
                                    }
                                    
                                    
                                }
                            }


                            
                        }
                    ?>
                    <div class="row">
                        <div class="col-md-12" id="trainee_location">
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-colorful" id="section-to-print">                                
                                <div class="panel-body"> 
                                    

                                    <div class="col-md-9" id="print_main_body">
                            
                                        <div class="panel panel-default" style="border: none;box-shadow: none;    margin: 0 15%; border: 2px solid #0f3529;"> 
                                            <div class="panel-body">
                                                <div class="col-md-2">
                                                    <img id="naggw_logo" src="<?php echo base_url(); ?>gsi-assets/logo.jpg" alt="NAGGW logo" style="width: 100%;margin-top: -10px;" />
                                                </div>

                                                <div class="col-md-8" id="company_name" style="margin-top: 5px;">
                                                    <h3 class="text-center" style="line-height: 1.3"> NATIONAL AGENCY FOR THE GREAT GREEN WALL</h3>
                                                    <h3 class="text-center" style="font-size: 15px;"><?php echo strtoupper($center_name); ?></h3>                                                   
                                                </div>

                                                <div class="col-md-2">                              
                                                    <?php echo $photo ?>
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
                                                        <label class="col-md-5 control-label">Name</label>
                                                        <div class="col-md-7">
                                                            <h3 style="font-size: 14px;"><?php echo $surname.' '.$firstname.' '.$lastname; ?></h3>
                                                        </div>
                                                    </div>                                                    
                                                    <div class="form-group">
                                                        <label class="col-md-5 control-label">Gender</label>
                                                        <div class="col-md-7">
                                                            <h3 style="font-size: 14px;"><?php echo $gender ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5 control-label">State/LGA</label>
                                                        <div class="col-md-7">
                                                            <h3 style="font-size: 14px;"><?php echo $state.' / '.$lga.' L.G.A'; ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5 control-label">Designation</label>
                                                        <div class="col-md-7">
                                                            <h3 style="font-size: 14px;"><?php echo $role ?></h3>
                                                        </div>
                                                    </div>                                          
                                                </form>
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
        
        <?php $this->load->view('super_admin/wp-includes/footer'); ?>
        
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






