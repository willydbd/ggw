<!-- MESSAGE BOX-->
<div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
            <div class="mb-content">
                <h3 style="color: #ccd4cd;">Are you sure you want to log out?</h3>                    
                <h3 style="color: #ccd4cd;">Press No if you want to continue work. Press Yes to logout current user.</h3>
            </div>
            <div class="mb-footer">
                <div class="pull-right">
                    <a href="<?php echo base_url() ?>Trainee/logout" class="btn btn-success btn-lg">Yes</a>
                    <button class="btn btn-default btn-lg mb-control-close">No</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MESSAGE BOX-->

<!-- START PRELOADS -->
<audio id="audio-alert" src="<?php echo base_url(); ?>gsi-assets/audio/alert.mp3" preload="auto"></audio>
<audio id="audio-fail" src="<?php echo base_url(); ?>gsi-assets/audio/fail.mp3" preload="auto"></audio>
<!-- END PRELOADS -->

                  
        
    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>gsi-assets/js/plugins/bootstrap/bootstrap.min.js"></script>        
        <!-- END PLUGINS -->