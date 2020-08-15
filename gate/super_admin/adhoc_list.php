<!DOCTYPE html>
<html lang="en">
    
<head>        
        <!-- META SECTION -->
        <?php $this->load->view('super_admin/wp-includes/meta'); ?>
        <title>National Agency for the Great Green Wall - List of Observers</title>         

        
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
                    <li class="active">Registered Adhoc Staff</li>
                </ul>
                <!-- END BREADCRUMB --> 
                
                <!-- PAGE TITLE -->
                <div class="page-title">                    
                    <h2><a href="<?php echo base_url(); ?>Admin/entry_gate"><span class="fa fa-arrow-circle-o-left"></span></a> REGISTERED ADHOC STAFF</h2>
                </div>
                <!-- END PAGE TITLE -->                
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                    <input type="hidden" id="traineeID" value="<?php echo $trans; ?>">
                    <div class="row">

                        

                        <div class="col-md-12" id="trainee_location">
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <!-- <h3 class="panel-title">REGISTERED TRAINEE</h3> -->
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button> 
                                        <a class="btn btn-success" href="<?php echo base_url().'Admin/adhoc_edit/'; ?>"><i class="glyphicon glyphicon-plus"></i> Add Adhoc Staff</a>
                                        
                                        <ul class="dropdown-menu">
                                            <!-- <li><a href="#" onClick ="$('#customers2').tableExport({type:'json',escape:'false'});"><img src='<?php echo base_url(); ?>gsi-assets/img/icons/json.png' width="24"/> JSON</a></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'json',escape:'false',ignoreColumn:'[2,3]'});"><img src='<?php echo base_url(); ?>gsi-assets/img/icons/json.png' width="24"/> JSON (ignoreColumn)</a></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'json',escape:'true'});"><img src='<?php echo base_url(); ?>gsi-assets/img/icons/json.png' width="24"/> JSON (with Escape)</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'xml',escape:'false'});"><img src='<?php echo base_url(); ?>gsi-assets/img/icons/xml.png' width="24"/> XML</a></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'sql'});"><img src='<?php echo base_url(); ?>gsi-assets/img/icons/sql.png' width="24"/> SQL</a></li>
                                            <li class="divider"></li> -->
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'csv',escape:'false'});"><img src='<?php echo base_url(); ?>gsi-assets/img/icons/csv.png' width="24"/> CSV</a></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'txt',escape:'false'});"><img src='<?php echo base_url(); ?>gsi-assets/img/icons/txt.png' width="24"/> TXT</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'excel',escape:'false'});"><img src='<?php echo base_url(); ?>gsi-assets/img/icons/xls.png' width="24"/> XLS</a></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'doc',escape:'false'});"><img src='<?php echo base_url(); ?>gsi-assets/img/icons/word.png' width="24"/> Word</a></li>
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'powerpoint',escape:'false'});"><img src='<?php echo base_url(); ?>gsi-assets/img/icons/ppt.png' width="24"/> PowerPoint</a></li>
                                            <li class="divider"></li>
                                            <!-- <li><a href="#" onClick ="$('#customers2').tableExport({type:'png',escape:'false'});"><img src='<?php echo base_url(); ?>gsi-assets/img/icons/png.png' width="24"/> PNG</a></li> -->
                                            <li><a href="#" onClick ="$('#customers2').tableExport({type:'pdf',escape:'false'});"><img src='<?php echo base_url(); ?>gsi-assets/img/icons/pdf.png' width="24"/> PDF</a></li>
                                        </ul>
                                    </div>                                    
                                    
                                </div>
                                <div class="panel-body"> 

                                    <div class="table-responsive">
                                        <table id="customers2" class="table table-striped datatable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px;">S/N</th>
                                                    <th style="width: 200px;">Staff Name</th>
                                                    <th>Assigned Center</th>
                                                    <th>State</th>
                                                    <th>Role</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Photo</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $count = 0;
                                                    $tbb = '';
                                                    if(!empty($adhoc_basic_info_data) && is_array($adhoc_basic_info_data))
                                                    {

                                                        foreach ($adhoc_basic_info_data as $key => $trld_val) 
                                                        {
                                                            $count++;
                                                            $trid = $trld_val['id'];
                                                            $surname = $trld_val['surname'];
                                                            $firstname = $trld_val['firstname'];
                                                            $lastname = $trld_val['lastname'];
                                                            $state = $trld_val['state'];
                                                            $role = $trld_val['role'];
                                                            $pass_code = $trld_val['passcode'];
                                                            $email = $trld_val['email'];
                                                            $phone = $trld_val['phone'];
                                                            $photo = $trld_val['photo'];
                                                            $center_name_ID = $trld_val['site_center_id'];
                                                            $center_name_str = '';

                                                            $photopath = base_url().'gsi-assets/image_uploads/adhoc_staff/'.$photo;
                                                            //var_dump($photopath);
                                                            if(!empty($photo) && (@getimagesize($photopath)))
                                                            {
                                                                $init_photo = $photopath;
                                                                $photo = '<img src="'.$photopath.'" width="40">';
                                                            }

                                                            if(!empty($basic_site_info_data) && is_array($basic_site_info_data))
                                                            {
                                                                foreach ($basic_site_info_data as $key => $val) 
                                                                {
                                                                    $center_name_val = $val["id"];
                                                                    
                                                                    if($center_name_ID == $center_name_val)
                                                                    {
                                                                        $center_name_str = $val["center_name"];
                                                                    }
                                                                    
                                                                    
                                                                }
                                                            }

                                                            

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$surname.' '.$firstname.' '.$lastname.'</td>
                                                                        <td>'.$center_name_str.'</td>
                                                                        <td>'.$state.'</td>
                                                                        <td>'.$role.'</td>
                                                                        <td>'.$email.'</td>
                                                                        <td>'.$phone.'</td>
                                                                        
                                                                        <td>'.$photo.'</td>
                                                                        <td>
                                                                           
                                                                            <a href="'.base_url().'Admin/adhoc_edit/'.$trid.'" class="btn-sm btn-danger">
                                                                                <i class="glyphicon glyphicon-edit"></i>
                                                                            </a>

                                                                            <a href="'.base_url().'Admin/adhoc_profile/'.$trid.'" class="btn-sm btn-primary">
                                                                                <i class="glyphicon glyphicon-eye-open"></i>
                                                                            </a>

                                                                        </td>
                                                                    </tr>';

                                                        }
                                                    }

                                                    echo $tbb;

                                                ?>  
                                                
                                            </tbody>
                                        </table>                             
                                    
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

       

        
            
    
       
    </body>

</html>






