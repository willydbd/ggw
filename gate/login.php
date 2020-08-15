<!DOCTYPE html>
<html lang="en" style="background: #093e14;">
    
<head>        
        <!-- META SECTION -->
        <?php $this->load->view('wp-includes/meta'); ?>
        <title>NAGGW - Login</title>         

        
</head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <div class="login-container" style="background: #093e14;">
        
                <div class="login-box animated fadeInDown" >
                    
                    <div class="login-body panel panel-success" style="background: #fefefc;">
                        <div class="text-center">
                            <img src="<?php echo base_url(); ?>gsi-assets/logo.jpg" alt="NAGGW logo" style="width: 28%" />
                            <h3>National Agency for the Great Green Wall</h3>
                            <h4>Field Data Entry</h4>
                        </div>
                        <div>
                            <div class="login-title" style="color: #093e14;"><strong>Welcome</strong>, Please login</div>
                            
                            <?php

                                echo $ntf;

                                $prod_attributes = array('class' => 'form-horizontal', 'method' => 'post', );

                                echo form_open_multipart('Trainee/index/', $prod_attributes);
                                //var_dump(md5("6a7e7ve"))
                            ?>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input style="background: #1c3a23;" type="text" class="form-control" placeholder="Username" name="Username" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input style="background: #1c3a23;" type="password" class="form-control" placeholder="Password" name="password" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 pull-right">
                                        <input type="hidden" name="logger" value="logger">
                                        <input type="submit" style="background: #1c3a23;color: #fff;" value="Login" class="form-control btn btn-success" />
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <div class="col-md-6">
                                        <a href="#" class="btn btn-link btn-block">Forgot your password?</a>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-info btn-block">Log In</button>
                                    </div>
                                </div> -->
                            </form>
                        </div>
                    </div>
                    <!-- <div class="login-footer">
                        <div class="pull-left">
                            &copy; 2015 AppName
                        </div>
                        <div class="pull-right">
                            <a href="#">About</a> |
                            <a href="#">Privacy</a> |
                            <a href="#">Contact Us</a>
                        </div>
                    </div> -->
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






