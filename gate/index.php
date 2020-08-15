<!DOCTYPE html>
<html lang="en">
    
<head>        
        <!-- META SECTION -->
        <?php $this->load->view('wp-includes/meta'); ?>
        <title>National Agency for the Great Green Wall - List of Trainee</title>         

        
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
                
                <!-- END BREADCRUMB --> 
                
                <!-- PAGE TITLE -->
                <?php 

                    $stat_total_trainee = 0;
                    if(!empty($trainee_location_data) && is_array($trainee_location_data))
                        $stat_total_trainee = sizeof($trainee_location_data);


                ?>
                <div class="page-title">                    
                    <h2><span class="fa fa-users"></span> Address Book <small><?php echo $stat_total_trainee; ?> Registered Trainee</small></h2>
                   
                    
                </div>
                
                <!-- END PAGE TITLE -->                
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <a class="btn btn-success pull-right" href="<?php echo base_url().'Trainee/enroll_edit/'; ?>"><i class="glyphicon glyphicon-plus"></i> Enroll Trainee</a>

                                    <div class="btn btn-danger pull-left" onclick="syncRec()"><i class="glyphicon glyphicon-refresh"></i> Synchronize Record</div>                                    
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        <?php

                            /*trainee_location_data_sync
                            trainee_human_capital_data_sync
                            trainee_social_capital_data_sync
                            trainee_natural_capital_data_sync
                            trainee_physical_capital_data_sync
                            trainee_financial_capital_data_sync
                            trainee_fingerprint_info_data_sync*/

                            $central_db_data = '';

                            if(!empty($poster_container))
                            {
                                $central_db_data = $poster_container;
                                
                            }


                            $central_server_url = '';
                            if(!empty($_SESSION['sync_server_url']))
                            {
                                $central_server_url = $_SESSION['sync_server_url'];
                                //var_dump($central_server_url);
                                //$central_server_url = base_url().'Exchange/';
                            }

                            echo '<input type="hidden" value="'.$central_db_data.'" id="central_db_data">';
                            echo '<input type="hidden" value="'.$central_server_url.'" id="central_server_url">';



                            //var_dump($_SESSION['result_gate_user_type']);
                            $count = 0;
                            if(!empty($trainee_location_data) && is_array($trainee_location_data))
                            {
                                foreach ($trainee_location_data as $key => $trld_val) 
                                {
                                    $count++;
                                    $trid = $trld_val['trid'];
                                    $name = $trld_val['ntr'];
                                    $age = $trld_val['age'];
                                    $gender = $trld_val['gen'];
                                    $state = $trld_val['state'];
                                    $lga = $trld_val['lga'];
                                    $vill = $trld_val['vill'];
                                    $marst = $trld_val['marst'];
                                    $phone = $trld_val['phone'];
                                    $photo = $trld_val['photo'];
                                    $center_name_ID = $trld_val['cid'];



                                    $an_inc = 'NAGGW-'.$center_name_ID.'-'.sprintf("%04s",$trid);

                                    if($gender==1)
                                        $gender = 'Male';
                                    else
                                        $gender = 'Female';

                                    $photopath = base_url().'gsi-assets/image_uploads/trainee_center_'.$center_name_ID.'/'.$photo;
                                    //var_dump($photopath);
                                    if(!empty($photo) && (@getimagesize($photopath)))
                                    {
                                        $init_photo = $photopath;
                                        $photo = '<img src="'.$photopath.'" width="40">';
                                    }

                                    echo '<div class="col-md-3">
                                            <!-- CONTACT ITEM -->
                                            <div class="panel panel-default">
                                                <div class="panel-body profile">
                                                    <div class="profile-image">
                                                        <img src="'.$photopath.'" alt="'.$name.'"/>
                                                    </div>
                                                    <div class="profile-data">
                                                        <div class="profile-data-name">'.strtoupper($name).'</div>
                                                        <div class="profile-data-title">ID: '.$an_inc.'</div>
                                                    </div>
                                                    <div class="profile-controls">
                                                        <a href="'.base_url().'Trainee/profile/'.$trid.'" class="profile-control-left"><span class="fa fa-info"></span></a>
                                                        <a href="tel: '.$phone.'" class="profile-control-right"><span class="fa fa-phone"></span></a>
                                                    </div>
                                                </div>                                
                                                <div class="panel-body">                                    
                                                    <div class="contact-info">
                                                        <p><small>Mobile</small><br/>'.$phone.'</p>
                                                        <p><small>State/LGA</small><br/>'.$state.'/'.$lga.'</p>
                                                        <p><small>Gender</small><br/>'.$gender.'</p>                                   
                                                    </div>
                                                </div>                                
                                            </div>
                                            <!-- END CONTACT ITEM -->
                                        </div>';
                                }
                            }

                        ?>
                        
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
            
            function initiate_system()
            {
                
                pageLoadingFrame("show");
                    
                /*setTimeout(function(){
                        pageLoadingFrame("hide");
                    },1500);*/

                //var destination = "<?php echo base_url() ?>"+'Exchange/initiator';
                

                var destination = $("#central_server_url").val()+'initiator';

                /*$.ajax({
                   type: 'POST',
                   crossDomain: true,
                   data: '{"some":"json"}',
                   dataType: 'jsonp',
                   url: destination,
                   success: function(jsondata)
                   {
                        console.log("done");
                         if(jsondata != undefined)
                          {
                            //data = atob(data);
                            if(jsondata.length > 0)
                            {
                                console.log(jsondata);
                                /*data = JSON.parse(data);
                                console.log(data);*

                                //post_data(jsondata);
                            }
                          }

                   },
                    error: function (responseData, textStatus, errorThrown) {
                        alert('POST failed.');
                    }

                });*/


                $.post(destination,
                {
                  
                })
                .done(function (data) 
                {                     
                  
                  if(data != undefined)
                  {
                    //data = atob(data);
                    if(data.length > 0)
                    {
                        /*data = JSON.parse(data);
                        console.log(data);*/

                        post_data(data);
                    }
                  }
                });

            }

            function post_data(datatopost)
            {
                var destination_embrace = "<?php echo base_url() ?>"+'Exchange/embrace';
                //var destination_embrace = $("#central_server_url").val()+'embrace';
                $.post(destination_embrace,
                {
                  datatopost : datatopost
                })
                .done(function (data) 
                {  
                    pageLoadingFrame("hide");           
                    if(data != undefined)
                    {
                        if(data.length > 0)
                        {
                            data = JSON.parse(data);        
                            console.log(data);
                        }
                    }
                  
                    //alert(data);

                });
            }

            function syncRec()
            {
                pageLoadingFrame("show");
                var datatopost = $("#central_db_data").val();
                //var destination_embrace = "<?php echo base_url() ?>"+'Exchange/embrace';
                var destination_embrace = $("#central_server_url").val()+'embrace';
                $.post(destination_embrace,
                {
                  datatopost : datatopost
                })
                .done(function (data) 
                {  
                    pageLoadingFrame("hide");           
                    if(data != undefined)
                    {
                        if(data.length > 0)
                        {
                            data = JSON.parse(data);        
                            console.log(data);
                        }
                    }
                  
                    //alert(data);

                });
            }

       </script>

        
            
    
       
    </body>

</html>






