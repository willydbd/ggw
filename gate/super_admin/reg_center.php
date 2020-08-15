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
                    <li class="active">Center Registration</li>
                </ul>
                <!-- END BREADCRUMB --> 
                
                <!-- PAGE TITLE -->
                <div class="page-title">                    
                    <h2><a href="<?php echo base_url(); ?>Admin/center_list"><span class="fa fa-arrow-circle-o-left"></span></a> Center Registration</h2>
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
                                        <a href="#" id="basic_site_information_handle" class="list-group-item active">
                                            <span class="sidenumber">1 - </span><i class="glyphicon glyphicon-info-sign"></i> Basic Site Information
                                        </a>
                                        <a href="#" id="site_information_handle" class="list-group-item">
                                            <span class="sidenumber">2 - </span><i class="glyphicon glyphicon-th"></i> Site Information
                                        </a>
                                        <a href="#" id="site_suitability_assessment_handle" class="list-group-item">
                                            <span class="sidenumber">3 - </span><i class="glyphicon glyphicon-tower"></i> Site Suitability Assessment
                                        </a>
                                        

                                    </div>                              
                                </div>
                            </div>
                        </div>

                        

                        <div class="col-md-8" id="basic_site_information">
                            <div id=basic_site_information_msg></div>
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-success">
                                <div class="panel-body">
                                    <h3><i class="glyphicon glyphicon-info-sign"></i> BASIC SITE INFORMATION</h3>

                                    <?php

                                        $center_name = $project = $village = $lga = $date = $state = '';

                                        if(!empty($basic_site_info_data) && is_array($basic_site_info_data))
                                        {
                                            $center_name = $basic_site_info_data[0]['center_name'];
                                            $project = $basic_site_info_data[0]['project'];
                                            $village = $basic_site_info_data[0]['community'];
                                            $lga = $basic_site_info_data[0]['lga'];
                                            $state = $basic_site_info_data[0]['state'];
                                            $date = $basic_site_info_data[0]['date'];
                                            

                                            if(!empty($date))
                                                $date = date('Y-m-d',strtotime($date));
                                        }

                                    ?>                                
                                    <!-- <form action="javascript:alert('Validated!');" role="form" class="form-horizontal" > -->
                                    <form action="#" role="form" class="form-horizontal" >
                                        <div class="row" style="line-height: 3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div>
                                                        <code> Center Name </code>
                                                        <input type="text" value="<?php echo $center_name;  ?>" class="form-control" id="center_name" placeholder="Center Name"/>
                                                    </div>
                                                    <div>
                                                        <code> Date </code>
                                                        <input type="date" value="<?php echo $date;  ?>" class="form-control" id="date" placeholder="Date"/>
                                                    </div>
                                                    <div>
                                                        <code> Project </code>
                                                        <input value="<?php echo $project;  ?>" type="text" class="form-control" id="project" placeholder="Project"/>
                                                    </div>
                                                </div>                                                
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                                                                        
                                                    <div style="margin-top: -9px;">
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
                                                        <code> Village / Community</code>
                                                        <input value="<?php echo $village;  ?>" type="text" class="form-control" id="village" placeholder="Village/Community"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                        </div>

                                        


                                                                                                                                                        
                                        
                                        <div style="margin-top: 20px;">
                                            <!-- <code> </code>
                                                        <input type="submit" class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" value="Next" name="Next"> --> 
                                            <div class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" id="basic_site_information_bt">Next >></div>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>                        
                            <!-- END WIZARD WITH VALIDATION -->

                        </div>

                        <div class="col-md-8 hidden" id="site_information">
                            <div id=site_information_msg></div>
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-success">
                                <div class="panel-body">
                                    <h3><i class="glyphicon glyphicon-th"></i> SITE INFORMATION</h3>
                                    <?php
                                        $easting=$northing=$area_size=$altitude=$tenure=$locality_description=$habitat_description=$regional_ecosystem=$broad_vegetation_group=$slope_position=$slope_degree=$slope_aspect=$type=$depth=$colour=$texture=$soil_notes=$sources=$map_cut=$geology_unit=$river=$stream=$lake=$others=$soil_erosion=$silt=$sand=$sedimentation=$evidence_of_runoff=$gullies=$rills=$channel=$artifacts=$ecofacts=$historical_monument= '';
                                        if(!empty($site_location_data) && is_array($site_location_data))
                                        {
                                            $hc_val = $site_location_data[0];
                                            $easting = $hc_val['easting'];
                                            $northing = $hc_val['northing'];
                                            $area_size = $hc_val['area_size'];
                                            $altitude = $hc_val['altitude'];
                                            $tenure = $hc_val['tenure_value'];
                                            $locality_description = $hc_val['locality_description'];
                                        }
                                        if(!empty($site_vegetation_landcover_data) && is_array($site_vegetation_landcover_data))
                                        {
                                            $hc_val = $site_vegetation_landcover_data[0];
                                            $habitat_description = $hc_val['habitat_description'];
                                            $regional_ecosystem = $hc_val['regional_ecosystem'];
                                            $broad_vegetation_group = $hc_val['broad_vegetation_group'];
                                        }
                                        if(!empty($site_terrain_attributes_data) && is_array($site_terrain_attributes_data))
                                        {
                                            $hc_val = $site_terrain_attributes_data[0];
                                            $slope_position = $hc_val['slope_position'];
                                            $slope_degree = $hc_val['slope_degree'];
                                            $slope_aspect = $hc_val['slope_aspect'];
                                        }
                                        if(!empty($site_soil_data) && is_array($site_soil_data))
                                        {
                                            $hc_val = $site_soil_data[0];
                                            $type = $hc_val['type'];
                                            $depth = $hc_val['depth'];
                                            $colour = $hc_val['colour'];
                                            $texture = $hc_val['texture'];
                                            $soil_notes = $hc_val['soil_notes'];
                                        }
                                        if(!empty($site_geology_data) && is_array($site_geology_data))
                                        {
                                            $hc_val = $site_geology_data[0];
                                            $sources = $hc_val['sources'];
                                            $map_cut = $hc_val['map_cutting_outcrops'];
                                            $geology_unit = $hc_val['geology_unit'];
                                        }
                                        if(!empty($site_drainage_data) && is_array($site_drainage_data))
                                        {
                                            $hc_val = $site_drainage_data[0];
                                            $river = $hc_val['river'];
                                            $stream = $hc_val['stream'];
                                            $lake = $hc_val['lake'];
                                            $others = $hc_val['others'];
                                        }
                                        if(!empty($site_land_disturbance_types_data) && is_array($site_land_disturbance_types_data))
                                        {
                                            $hc_val = $site_land_disturbance_types_data[0];
                                            $soil_erosion = $hc_val['soil_erosion'];
                                            $silt = $hc_val['silt'];
                                            $sand = $hc_val['sand'];
                                            $sedimentation = $hc_val['sedimentation'];
                                            $evidence_of_runoff = $hc_val['evidence_of_runoff'];
                                            $gullies = $hc_val['gullies'];
                                            $rills = $hc_val['rills'];
                                            $channel = $hc_val['channel'];
                                        }
                                        if(!empty($site_archaeological_attributes_data) && is_array($site_archaeological_attributes_data))
                                        {
                                            $hc_val = $site_archaeological_attributes_data[0];
                                            $artifacts = $hc_val['artifacts'];
                                            $ecofacts = $hc_val['ecofacts'];
                                            $historical_monument = $hc_val['historical_monument'];
                                            
                                        }

                                    ?>                                
                                    <form action="#" role="form" class="form-horizontal" >
                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            <h3>Location (GPS Reference)</h3>
                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <!-- <div>
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

                                                    </div>  -->

                                                    <div style="margin-top: 0px;">
                                                        <code> Longitude </code>
                                                        <input type="text" class="form-control" id="easting" placeholder="Longitude (Easting)" value="<?php echo $easting ?>" />
                                                    </div>
                                                    <div style="margin-top: 0px;">
                                                        <code> Latitude</code>
                                                        <input type="text" class="form-control" id="northing" placeholder="Latitude (Northing)" value="<?php echo $northing ?>"/>
                                                    </div>
                                                                                                    
                                                </div>
                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Area Size </code>
                                                        <input type="text" class="form-control" id="area_size" placeholder="Area Size" value="<?php echo $area_size ?>"/>
                                                    </div>
                                                    <div style="margin-top: 0px;">
                                                        <code> Altitude </code>
                                                        <input type="text" class="form-control" id="altitude" placeholder="Altitude" value="<?php echo $altitude ?>"/>
                                                    </div>                                                  

                                                </div>                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Tenure </code>
                                                        <input type="text" class="form-control" id="tenure" placeholder="Tenure" value="<?php echo $tenure ?>"/>
                                                    </div>
                                                    <div style="margin-top: 0px;">
                                                        <code> Locality Description </code>
                                                        <input type="text" class="form-control" id="locality_description" placeholder="Locality Description" value="<?php echo $locality_description ?>"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                                                                                                                                        
                                        </div>
                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            <h3>Vegetation / Land Cover</h3>
                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div style="margin-top: 0px;">
                                                        <code> Habitat Description </code>
                                                        <input type="text" class="form-control" id="habitat_description" placeholder="Habitat Description" value="<?php echo $habitat_description ?>" />
                                                    </div>                                                                                                    
                                                </div>
                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Regional Ecosystem </code>
                                                        <input type="text" class="form-control" id="regional_ecosystem" placeholder="Regional Ecosystem" value="<?php echo $regional_ecosystem ?>"/>
                                                    </div>                                                  

                                                </div>                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Broad Vegetation Group </code>
                                                        <input type="text" class="form-control" id="broad_vegetation_group" placeholder="Broad Vegetation Group" value="<?php echo $broad_vegetation_group ?>"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                                                                                                                                        
                                        </div>
                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            <h3>Terrain Attributes</h3>
                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div style="margin-top: 0px;">
                                                        <code> Slope Position </code>
                                                        <input type="text" class="form-control" id="slope_position" placeholder="Slope Position" value="<?php echo $slope_position ?>" />
                                                    </div>                                                                                                    
                                                </div>
                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Slope Degree </code>
                                                        <input type="text" class="form-control" id="slope_degree" placeholder="Slope Degree" value="<?php echo $slope_degree ?>"/>
                                                    </div>                                                  

                                                </div>                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Slope Aspect </code>
                                                        <input type="text" class="form-control" id="slope_aspect" placeholder="Slope Aspect" value="<?php echo $slope_aspect ?>"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                                                                                                                                        
                                        </div>
                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            <h3>Soil</h3>
                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div style="margin-top: 0px;">
                                                        <code> Type </code>
                                                        <input type="text" class="form-control" id="type" placeholder="Type" value="<?php echo $type ?>" />
                                                    </div>                                                                                                    
                                                </div>
                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Depth </code>
                                                        <input type="text" class="form-control" id="depth" placeholder="Depth" value="<?php echo $depth ?>"/>
                                                    </div>                                                  

                                                </div>                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Structure </code>
                                                        <input type="text" class="form-control" id="colour" placeholder="Structure (Colour)" value="<?php echo $colour ?>"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Texture </code>
                                                        <input type="text" class="form-control" id="texture" placeholder="Texture" value="<?php echo $texture ?>"/>
                                                    </div>                                                  

                                                </div>                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Soil Notes </code>
                                                        <input type="text" class="form-control" id="soil_notes" placeholder="Soil Notes" value="<?php echo $soil_notes ?>"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                                                                                                                                        
                                        </div>
                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            <h3>Geology</h3>
                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div style="margin-top: 0px;">
                                                        <code> Sources </code>
                                                        <input type="text" class="form-control" id="sources" placeholder="Sources" value="<?php echo $sources ?>" />
                                                    </div>                                                                                                    
                                                </div>
                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Map|Cutting|Outcrops </code>
                                                        <input type="text" class="form-control" id="map_cut" placeholder="Map|Cutting|Outcrops" value="<?php echo $map_cut ?>"/>
                                                    </div>                                                  

                                                </div>                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Geology Unit </code>
                                                        <input type="text" class="form-control" id="geology_unit" placeholder="Geology Unit" value="<?php echo $geology_unit ?>"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                                                                                                                                        
                                        </div>
                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            <h3>Drainage</h3>
                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div style="margin-top: 0px;">
                                                        <code> River </code>
                                                        <input type="text" class="form-control" id="river" placeholder="River" value="<?php echo $river ?>" />
                                                    </div>                                                                                                    
                                                </div>
                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Stream </code>
                                                        <input type="text" class="form-control" id="stream" placeholder="Stream" value="<?php echo $stream ?>"/>
                                                    </div>                                                  

                                                </div>                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Lake </code>
                                                        <input type="text" class="form-control" id="lake" placeholder="Lake" value="<?php echo $lake ?>"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Others </code>
                                                        <input type="text" class="form-control" id="others" placeholder="Others" value="<?php echo $others ?>"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                                                                                                                                        
                                        </div>
                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            <h3>Land Disturbance / Disturbance Type(s)</h3>
                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div style="margin-top: 0px;">
                                                        <code> Soil Erosion </code>
                                                        <input type="text" class="form-control" id="soil_erosion" placeholder="Soil Erosion" value="<?php echo $soil_erosion ?>" />
                                                    </div>                                                                                                    
                                                </div>
                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Silt </code>
                                                        <input type="text" class="form-control" id="silt" placeholder="Silt" value="<?php echo $silt ?>"/>
                                                    </div>                                                  

                                                </div>                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Sand </code>
                                                        <input type="text" class="form-control" id="sand" placeholder="Sand" value="<?php echo $sand ?>"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Sedimentation </code>
                                                        <input type="text" class="form-control" id="sedimentation" placeholder="Sedimentation" value="<?php echo $sedimentation ?>"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Evidence of runoff </code>
                                                        <input type="text" class="form-control" id="evidence_of_runoff" placeholder="Evidence of runoff" value="<?php echo $evidence_of_runoff ?>"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Gullies </code>
                                                        <input type="text" class="form-control" id="gullies" placeholder="Gullies" value="<?php echo $gullies ?>"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Rills </code>
                                                        <input type="text" class="form-control" id="rills" placeholder="Rills" value="<?php echo $rills ?>"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Channel </code>
                                                        <input type="text" class="form-control" id="channel" placeholder="Channel" value="<?php echo $channel ?>"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                                                                                                                                        
                                        </div>
                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            <h3>Archaelogical Attributes</h3>
                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div style="margin-top: 0px;">
                                                        <code> Artifacts </code>
                                                        <input type="text" class="form-control" id="artifacts" placeholder="Artifacts" value="<?php echo $artifacts ?>" />
                                                    </div>                                                                                                    
                                                </div>
                                                
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Ecofacts </code>
                                                        <input type="text" class="form-control" id="ecofacts" placeholder="Ecofacts" value="<?php echo $ecofacts ?>"/>
                                                    </div>                                                  

                                                </div>                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Historical Monument </code>
                                                        <input type="text" class="form-control" id="historical_monument" placeholder="Historical Monument" value="<?php echo $historical_monument ?>"/>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                                                                                                                                        
                                        </div>

                                        <div>
                                            
                                            <div class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" id="site_information_bt">Next >></div>
                                        </div>
                                    </form>
                                </div>
                            </div>                        
                            <!-- END WIZARD WITH VALIDATION -->

                        </div>

                        <div class="col-md-8 hidden" id="site_suitability_assessment">
                            <div id="site_suitability_assessment_msg"></div>
                            <!-- START WIZARD WITH VALIDATION -->
                            <div class="panel panel-success">
                                <div class="panel-body">
                                    <h3><i class="glyphicon glyphicon-tower"></i> Site Suitability Assessment</h3>
                                    <?php
                                        $order_s=$order_n=$highly_suitable=$moderately_suitable=$marginally_suitable=$curr_not_suitable=$perm_not_suitable=$comment='';

                                        if(!empty($site_suitability_orders_data) && is_array($site_suitability_orders_data))
                                        {
                                            $sc_val = $site_suitability_orders_data[0];
                                            $order_s = $sc_val['order_s'];
                                            $order_n = $sc_val['order_n'];
                                        }
                                        if(!empty($site_suitability_classes_order_s_data) && is_array($site_suitability_classes_order_s_data))
                                        {
                                            $sc_val = $site_suitability_classes_order_s_data[0];
                                            $highly_suitable = $sc_val['class_s1'];
                                            $moderately_suitable = $sc_val['class_s2'];
                                            $marginally_suitable = $sc_val['class_s3'];
                                        }
                                        if(!empty($site_suitability_classes_order_n_data) && is_array($site_suitability_classes_order_n_data))
                                        {
                                            $sc_val = $site_suitability_classes_order_n_data[0];
                                            $curr_not_suitable = $sc_val['class_n1'];
                                            $perm_not_suitable = $sc_val['class_n2'];
                                        }
                                        if(!empty($site_general_observation_comment_data) && is_array($site_general_observation_comment_data))
                                        {
                                            $sc_val = $site_general_observation_comment_data[0];
                                            $comment = $sc_val['gen_comment'];
                                        }

                                    ?>                                 
                                    <form action="#" role="form" class="form-horizontal" >
                                        <div class="row" style="line-height: 3">
                                            <h3>Suitability Orders</h3>
                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div style="margin-top: 0px;">
                                                        <code> Order S(Suitable) </code>
                                                        <input type="text" class="form-control" id="order_s" placeholder="Order S(Suitable)" value="<?php echo $order_s ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Order N(Not Suitable)</code>
                                                        <input type="text" class="form-control" id="order_n" placeholder="Order N(Not Suitable)" value="<?php echo $order_n ?>"/>
                                                    </div>
                                                                                                    
                                                </div>
                                                
                                            </div>
                                                                                                                                                        
                                        </div>
                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            <h3>Suitability Classes(Order S)</h3>
                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div style="margin-top: 0px;">
                                                        <code> Class S1(Highly Suitable) </code>
                                                        <input type="text" class="form-control" id="highly_suitable" placeholder="Class S1(Highly Suitable)" value="<?php echo $highly_suitable ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Class S2(Moderately Suitable)</code>
                                                        <input type="text" class="form-control" id="moderately_suitable" placeholder="Class S2(Moderately Suitable)" value="<?php echo $moderately_suitable ?>"/>
                                                    </div>
                                                                                                    
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Class S3(Marginally Suitable)</code>
                                                        <input type="text" class="form-control" id="marginally_suitable" placeholder="Class S3(Marginally Suitable)" value="<?php echo $marginally_suitable ?>"/>
                                                    </div>
                                                                                                    
                                                </div>
                                                
                                            </div>
                                                                                                                                                        
                                        </div>
                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            <h3>Suitability Classes(Order N)</h3>
                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div style="margin-top: 0px;">
                                                        <code> Class N1(Currently Not Suitable) </code>
                                                        <input type="text" class="form-control" id="curr_not_suitable" placeholder="Class N1(Currently Not Suitable)" value="<?php echo $curr_not_suitable ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div style="margin-top: 0px;">
                                                        <code> Class N2(Permanently Not Suitable)</code>
                                                        <input type="text" class="form-control" id="perm_not_suitable" placeholder="Class N2(Permanently Not Suitable)" value="<?php echo $perm_not_suitable ?>"/>
                                                    </div>
                                                                                                    
                                                </div>
                                                
                                            </div>
                                            
                                                                                                                                                        
                                        </div>
                                        
                                        <div class="row" style="line-height: 3; margin-top: 40px;">
                                            <h3>General Observation / Comment</h3>
                                            <div class="col-md-4">
                                                <div class="form-group">                
                                                    <div style="margin-top: 0px;">
                                                        <code> Comment </code>
                                                        <input type="text" class="form-control" id="comment" placeholder="Comment" value="<?php echo $comment ?>" />
                                                    </div>
                                                </div>
                                            </div>                                            
                                                                                                                                                        
                                        </div>

                                        <div>
                                            <div class="btn btn-success pull-right" style="margin: 10px; padding: 7px 28px; border: 2px solid #154c3a;" id="site_suitability_assessment_bt">Submit</div> 
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

            $("#basic_site_information_handle").click(function()
            {
                basic_site_information();
            });

            $("#site_information_handle").click(function()
            {
                //alert("hello");
                site_information();
            });

            $("#site_suitability_assessment_handle").click(function()
            {
                site_suitability_assessment();
            });

            

            

            function site_suitability_assessment()
            {
                $("#site_suitability_assessment_handle").addClass("active");
                $("#site_information_handle").removeClass("active");
                $("#basic_site_information_handle").removeClass("active");
                
                $("#site_information").addClass("hidden");
                $("#basic_site_information").addClass("hidden");
                $("#site_suitability_assessment").removeClass("hidden");
            }

            function site_information()
            {
                $("#site_information_handle").addClass("active");
                $("#basic_site_information_handle").removeClass("active");
                $("#site_suitability_assessment_handle").removeClass("active");

                
                $("#basic_site_information").addClass("hidden");
                $("#site_suitability_assessment").addClass("hidden");                
                $("#site_information").removeClass("hidden");
            }

            function basic_site_information()
            {
                $("#basic_site_information_handle").addClass("active");
                $("#site_information_handle").removeClass("active");
                $("#site_suitability_assessment_handle").removeClass("active");

                $("#site_information").addClass("hidden");
                $("#site_suitability_assessment").addClass("hidden");                
                $("#basic_site_information").removeClass("hidden");
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

         $("#basic_site_information_bt").click(function ()
         {
                pageLoadingFrame("show");
                    setTimeout(function(){
                        pageLoadingFrame("hide");
                    },1500);

                var center_name = $("#center_name").val();
                var nig_states = $("#nig_states").val();
                var village = $("#village").val();
                var project = $("#project").val();                
                var lga = $("#lga").val();
                var date = $("#date").val();
                
                var trans = $("#traineeID").val();
                //alert(center_name +' - '+nig_states+' - '+village);
                if((center_name !='') && (nig_states != 0) && (village != ''))
                {
                    $.post(destination,
                    {
                      logger_save: "logger_ext_post",
                      center_name: center_name,
                      date: date,
                      project: project,
                      nig_states: nig_states,
                      village: village,
                      lga: lga,
                      dtrans: trans,
                      record_type: "basic_site_information"
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
                                /*if(imageDataURI != '')
                                {
                                    postImage();
                                } */                      
                                site_information();
                            }
                            else if(data == '2')
                            {
                                $("#basic_site_information_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Updated Successfully</strong></div>');   
                                /*if(imageDataURI != '')
                                {
                                    postImage();
                                }*/                                                        
                                site_information();
                            }
                            else if(data == '-1')
                            {
                                $("#basic_site_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fields are empty!</strong></div>');
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

        $("#site_information_bt").click(function ()
         {
                pageLoadingFrame("show");
                    setTimeout(function(){
                        pageLoadingFrame("hide");
                    },1500);

                var center_name = $("#center_name").val();
                var nig_states = $("#nig_states").val();
                var village = $("#village").val();

                var easting=$("#easting").val();
                var northing=$("#northing").val();
                var area_size=$("#area_size").val();
                var altitude=$("#altitude").val();
                var tenure=$("#tenure").val();
                var locality_description=$("#locality_description").val();
                var habitat_description=$("#habitat_description").val();
                var regional_ecosystem=$("#regional_ecosystem").val();
                var broad_vegetation_group=$("#broad_vegetation_group").val();
                var slope_position=$("#slope_position").val();
                var slope_degree=$("#slope_degree").val();
                var slope_aspect=$("#slope_aspect").val();
                var type=$("#type").val();
                var depth=$("#depth").val();
                var colour=$("#colour").val();
                var texture=$("#texture").val();
                var soil_notes=$("#soil_notes").val();
                var sources=$("#sources").val();
                var map_cut=$("#map_cut").val();
                var geology_unit=$("#geology_unit").val();
                var river=$("#river").val();
                var stream=$("#stream").val();
                var lake=$("#lake").val();
                var others=$("#others").val();
                var soil_erosion=$("#soil_erosion").val();
                var silt=$("#silt").val();
                var sand=$("#sand").val();
                var sedimentation=$("#sedimentation").val();
                var evidence_of_runoff=$("#evidence_of_runoff").val();
                var gullies=$("#gullies").val();
                var rills=$("#rills").val();
                var channel=$("#channel").val();
                var artifacts=$("#artifacts").val();
                var ecofacts=$("#ecofacts").val();
                var historical_monument=$("#ecofacts").val();

                
                var trans = $("#traineeID").val();
                

                if((center_name !='') && (nig_states != 0) && (village != ''))
                {
                    
                    $.post(destination,
                    {
                        logger_save: "logger_ext_post",
                        center_name:center_name,
                        nig_states:nig_states,
                        village:village,
                        easting:easting,
                        northing:northing,
                        area_size:area_size,
                        altitude:altitude,
                        tenure:tenure,
                        locality_description:locality_description,
                        habitat_description:habitat_description,
                        regional_ecosystem:regional_ecosystem,
                        broad_vegetation_group:broad_vegetation_group,
                        slope_position:slope_position,
                        slope_degree:slope_degree,
                        slope_aspect:slope_aspect,
                        type:type,
                        depth:depth,
                        colour:colour,
                        texture:texture,
                        soil_notes:soil_notes,
                        sources:sources,
                        map_cut:map_cut,
                        geology_unit:geology_unit,
                        river:river,
                        stream:stream,
                        lake:lake,
                        others:others,
                        soil_erosion:soil_erosion,
                        silt:silt,
                        sand:sand,
                        sedimentation:sedimentation,
                        evidence_of_runoff:evidence_of_runoff,
                        gullies:gullies,
                        rills:rills,
                        channel:channel,
                        artifacts:artifacts,
                        ecofacts:ecofacts,
                        historical_monument:historical_monument,

                        dtrans: trans,
                        record_type: "site_information"
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
                                $("#site_information_handle").append('<i class="fa fa-check-square-o" style="font-size: 10px; color: #006400 !important; "></i>');
                                $("#site_information_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Saved Successfully</strong></div>');                        
                                site_suitability_assessment();
                            }
                            else if(data == '-1')
                            {
                                $("#basic_site_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fields are empty!</strong></div>');
                                basic_site_information();
                            }
                            else if(data == '01')
                            {
                                $("#site_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong, record could not be saved!</strong></div>');
                            }
                            else if(data == '-200')
                            {
                                $("#site_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record holder not known!</strong></div>');
                            }                           

                        }
                      }
                      //alert(data);

                    });
                }
                else
                {
                    $("#basic_site_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Please Provide Trainee Basic Info!</strong></div>');
                    basic_site_information();
                }
                

         });
        
        $("#site_suitability_assessment_bt").click(function ()
         {
                pageLoadingFrame("show");
                    setTimeout(function(){
                        pageLoadingFrame("hide");
                    },1500);

                var center_name = $("#center_name").val();
                var nig_states = $("#nig_states").val();
                var village = $("#village").val();

                var order_s= $("#order_s").val();
                var order_n= $("#order_n").val();
                var highly_suitable= $("#highly_suitable").val();
                var moderately_suitable= $("#moderately_suitable").val();
                var marginally_suitable= $("#marginally_suitable").val();
                var curr_not_suitable= $("#curr_not_suitable").val();
                var perm_not_suitable= $("#perm_not_suitable").val();
                var comment=$("#comment").val();

                var trans = $("#traineeID").val();
                //alert (qcode+ '-'+tname+ '-'+thumbcode+ '-'+dclerk);                                

                if((center_name !='') && (nig_states != 0) && (village != ''))
                {                    
                    $.post(destination,
                    {
                        logger_save: "logger_ext_post",
                        center_name:center_name,
                        nig_states:nig_states,
                        village:village,

                        order_s:order_s,
                        order_n:order_n,
                        highly_suitable:highly_suitable,
                        moderately_suitable:moderately_suitable,
                        marginally_suitable:marginally_suitable,
                        curr_not_suitable:curr_not_suitable,
                        perm_not_suitable:perm_not_suitable,
                        comment:comment,

                        dtrans: trans,
                        record_type: "site_suitability_assessment"
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
                                $("#site_suitability_assessment_handle").append('<i class="fa fa-check-square-o" style="font-size: 10px; color: #006400 !important; "></i>');
                                $("#site_suitability_assessment_msg").html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record Saved Successfully</strong></div>');                        
                                var redir = "<?php echo base_url() ?>"+'Admin/center_list/';
                                location.assign(redir);
                            }
                            else if(data == '-1')
                            {
                                $("#basic_site_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Important Fields are empty!</strong></div>');
                                basic_site_information();
                            }
                            else if(data == '01')
                            {
                                $("#site_suitability_assessment_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Something went wrong, record could not be saved!</strong></div>');
                            }
                            else if(data == '-200')
                            {
                                $("#site_suitability_assessment_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record holder not known!</strong></div>');
                            }                           

                        }
                      }
                      

                    });
                }
                else
                {
                    $("#basic_site_information_msg").html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Please Provide Trainee Basic Info!</strong></div>');
                    basic_site_information();
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






