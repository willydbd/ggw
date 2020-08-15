<!DOCTYPE html>
<html lang="en">
    
<head>        
        <!-- META SECTION -->
        <?php $this->load->view('super_admin/wp-includes/meta'); ?>
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
                    <li class="active">Staff(Observer) Registration</li>
                </ul>
                <!-- END BREADCRUMB --> 
                
                <!-- PAGE TITLE -->
                <div class="page-title">                    
                    <h2><a href="<?php echo base_url(); ?>Admin/staff_list"><span class="fa fa-arrow-circle-o-left"></span></a> Staff(Observer) Registration</h2>
                </div>
                <!-- END PAGE TITLE -->                
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                    <input type="hidden" id="traineeID" value="<?php echo $trans; ?>">
                    <div class="row">                        

                        <div class="col-md-12" id="basic_site_information">
                            <div id=basic_site_information_msg></div>
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-success">
                                <div class="panel-body">
                                    <h3><i class="glyphicon glyphicon-info-sign"></i> STAFF INFORMATION</h3>

                                    <?php

                                        $surname = $firstname = $lastname = $lga = $state = $phone = $email = $center_name_ID = '';

                                        if(!empty($staff_info_data) && is_array($staff_info_data))
                                        {
                                            $surname = $staff_info_data[0]['surname'];
                                            $firstname = $staff_info_data[0]['firstname'];
                                            $lastname = $staff_info_data[0]['lastname'];
                                            $lga = $staff_info_data[0]['lga'];
                                            $state = $staff_info_data[0]['state'];
                                            $phone = $staff_info_data[0]['phone'];
                                            $email = $staff_info_data[0]['email'];
                                            $center_name_ID = $staff_info_data[0]['center_name_ID'];

                                        }

                                    ?>                                
                                    <!-- <form action="javascript:alert('Validated!');" role="form" class="form-horizontal" > -->
                                    <form action="#" role="form" class="form-horizontal" >
                                        <div class="row" style="line-height: 3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Surname </code>
                                                        <input type="surname" value="<?php echo $surname;  ?>" class="form-control" id="surname" placeholder="Surname"/>
                                                    </div>
                                                    <div>
                                                        <code> First Name </code>
                                                        <input type="text" value="<?php echo $firstname;  ?>" class="form-control" id="firstname" placeholder="First Name"/>
                                                    </div>                                                    
                                                    <div>
                                                        <code> Last Name </code>
                                                        <input value="<?php echo $lastname;  ?>" type="text" class="form-control" id="lastname" placeholder="Last Name"/>
                                                    </div>
                                                    <div>
                                                        <code> E-mail Address </code>
                                                        <input type="email" value="<?php echo $email;  ?>" class="form-control" id="email" placeholder="E-mail Address"/>
                                                    </div>
                                                </div>                                                
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                                                                        
                                                    <div style="margin-top: -9px;">
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

                                                            $center_name_sel = '<code> Assign Center </code>
                                                            <select class="form-control select" id="center_name" data-live-search="true">
                                                            <option value="0">Select Center</option>';

                                                            if(!empty($basic_site_info_data) && is_array($basic_site_info_data))
                                                            {
                                                                foreach ($basic_site_info_data as $key => $val) 
                                                                {
                                                                    $center_name_val = $val["id"];
                                                                    $center_name_str = $val["center_name"];
                                                                    if($center_name_ID == $center_name_val)
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

                                                    <div style="margin-top: 0px;">
                                                        <code> Phone Number</code>
                                                        <input value="<?php echo $phone;  ?>" type="phone" class="form-control" id="phone" placeholder="Phone Number"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                        </div>

                                        


                                                                                                                                                        
                                        
                                        <div style="margin-top: 20px;">
                                            <!-- <code> </code>
                                                        <input type="submit" class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" value="Next" name="Next"> --> 
                                            <div class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" id="staff_info_bt">Submit</div>
                                            
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
            

            
            var destination = "<?php echo base_url() ?>"+'Admin/post_enroll';
            var imageAttached = false;
            var imageDataURI = '';
            var imgpostcount = 0;

            

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

         $("#staff_info_bt").click(function ()
         {
                pageLoadingFrame("show");
                    setTimeout(function(){
                        pageLoadingFrame("hide");
                    },1500);

                var center_name = $("#center_name").val();
                var nig_states = $("#nig_states").val();
                var surname = $("#surname").val();
                var firstname = $("#firstname").val();                
                var lga = $("#lga").val();
                var lastname = $("#lastname").val();
                var phone = $("#phone").val();
                var email = $("#email").val();
                
                var trans = $("#traineeID").val();
                //alert(center_name +' - '+nig_states+' - '+surname);
                if((center_name !='') && (surname != 0) && (nig_states != ''))
                {
                    $.post(destination,
                    {
                      logger_save: "logger_ext_post",
                      center_name: center_name,
                      village: surname,
                      firstname: firstname,
                      nig_states: nig_states,
                      lastname: lastname,
                      phone: phone,
                      email: email,
                      lga: lga,
                      dtrans: trans,
                      record_type: "staff_information"
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
                                $("#basic_site_information_handle").append('<i class="fa fa-check-square-o" style="font-size: 10px; color: #006400 !important; "></i>');
                                $("#basic_site_information_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Saved Successfully</strong></div>');   
                                $("#traineeID").val(data[1]);   
                                var redir = "<?php echo base_url() ?>"+'Admin/staff_list/';
                                location.assign(redir);
                                /*if(imageDataURI != '')
                                {
                                    postImage();
                                } */                      
                                //site_information();
                            }
                            else if(data == '2')
                            {
                                $("#basic_site_information_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Updated Successfully</strong></div>');   
                                /*if(imageDataURI != '')
                                {
                                    postImage();
                                }*/                                                        
                                //site_information();
                            }
                            else if(data == '-1')
                            {
                                $("#basic_site_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fields are empty!</strong></div>');
                            }
                            else if(data == '019')
                            {
                                $("#basic_site_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Another staff already registered with this email address!</strong></div>');
                            }
                            else if(data == '01')
                            {
                                $("#basic_site_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong, record could not be saved!</strong></div>');
                            }
                            else if(data == '-200')
                            {
                                $("#basic_site_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record holder not known!</strong></div>');
                            }                           

                        }
                      }
                      //alert(data);

                    });
                }
                else
                {
                    $("#basic_site_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fields are empty!</strong></div>');
                }
                

         });

        
        
        

        
        

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






