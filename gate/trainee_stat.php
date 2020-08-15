<!DOCTYPE html>
<html lang="en">
    
<head>        
        <!-- META SECTION -->
        <?php $this->load->view('wp-includes/meta'); ?>
        <title>National Agency for the Great Green Wall - Statistics</title>         

        
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
                    <li class="active">Trainee Statistics</li>
                </ul>
                <!-- END BREADCRUMB --> 
                
                <!-- PAGE TITLE -->
                <div class="page-title">                    
                    <h2><a href="<?php echo base_url(); ?>Trainee/entry_gate"><span class="fa fa-arrow-circle-o-left"></span></a> TRAINEE STATISTICS</h2>
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
                                        <a class="btn btn-success" href="<?php echo base_url().'Trainee/enroll_edit/'; ?>"><i class="glyphicon glyphicon-plus"></i> Enroll Trainee</a>
                                        
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
                                                    <th>Statistics Item</th>
                                                    <th>Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $count = 0;
                                                    $tbb = '';
                                                    

                                                    if(!empty($trainee_location_data) && is_array($trainee_location_data))
                                                    {
                                                        $total_trainee = sizeof($trainee_location_data);
                                                        $count++;    
                                                        $tbb .= '<tr>
                                                                    <td>'.$count.'</td>
                                                                    <td>Total Number of Trainee</td>
                                                                    <td>'.$total_trainee.'</td>
                                                                    
                                                                </tr>';                                                       
                                                    }

                                                    if(!empty($gender_group) && is_array($gender_group))
                                                    {
                                                        
                                                        foreach ($gender_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Num. of Trainee [';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            if($vv['gender'] == '1')
                                                                $stat_item .= 'Male';
                                                            else
                                                                $stat_item .= 'Female'; 

                                                            $stat_item .= ']';

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }


                                                    if(!empty($age_group) && is_array($age_group))
                                                    {
                                                        
                                                        foreach ($age_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Trainee Age Bracket [';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            if(!empty($vv['age_group']))
                                                                $stat_item .= $vv['age_group'];
                                                            else if(empty($vv['age']))
                                                                $stat_item .= 'none';
                                                            else
                                                                $stat_item .= $vv['age']; 

                                                            $stat_item .= ']';

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }

                                                    if(!empty($marital_group) && is_array($marital_group))
                                                    {
                                                        
                                                        foreach ($marital_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Trainee Marital Status [';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            if(!empty($vv['marital_group']))
                                                                $stat_item .= $vv['marital_group'];
                                                            else if(empty($vv['marital_status']))
                                                                $stat_item .= 'none';
                                                            else
                                                                $stat_item .= $vv['marital_status']; 

                                                            $stat_item .= ']';

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }

                                                    if(!empty($out_migrated_group) && is_array($out_migrated_group))
                                                    {
                                                        $stat_item = 'Num. of Trainee that Migrated for Work';
                                                        $stat_val = $out_migrated_group[0]['total'];
                                                        $count++;

                                                        $tbb .= '<tr>
                                                                    <td>'.$count.'</td>
                                                                    <td>'.$stat_item.'</td>
                                                                    <td>'.$stat_val.'</td>

                                                                </tr>';                                                       
                                                                                                               
                                                    }

                                                    if(!empty($educational_level_group) && is_array($educational_level_group))
                                                    {
                                                        
                                                        foreach ($educational_level_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Highest Level of Education Attended by Trainee [';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            if(!empty($vv['educational_level_group']))
                                                                $stat_item .= $vv['educational_level_group'];
                                                            else if(empty($vv['educational_level']))
                                                                $stat_item .= 'none';
                                                            else
                                                                $stat_item .= $vv['educational_level']; 

                                                            $stat_item .= ']';

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }

                                                    if(!empty($technical_training_group) && is_array($technical_training_group))
                                                    {
                                                        
                                                        foreach ($technical_training_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Num. of Technical Trainee Undertaken by Trainee [';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            if(!empty($vv['technical_training_group']))
                                                                $stat_item .= $vv['technical_training_group'];
                                                            else if(empty($vv['tech_training']))
                                                                $stat_item .= 'none';
                                                            else
                                                                $stat_item .= $vv['tech_training']; 

                                                            $stat_item .= ']';

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }

                                                    if(!empty($capacity_development_group) && is_array($capacity_development_group))
                                                    {
                                                        
                                                        foreach ($capacity_development_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Num. of Capacity Development Needed by Trainee [';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            if(!empty($vv['capacity_development_group']))
                                                                $stat_item .= $vv['capacity_development_group'];
                                                            else if(empty($vv['capacity_dev_need']))
                                                                $stat_item .= 'none';
                                                            else
                                                                $stat_item .= $vv['capacity_dev_need']; 

                                                            $stat_item .= ']';

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }

                                                    if(!empty($external_institutions_group) && is_array($external_institutions_group))
                                                    {
                                                        
                                                        foreach ($external_institutions_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Num. of Trainee Connected with External Institution[';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            if(!empty($vv['external_institutions_group']))
                                                                $stat_item .= $vv['external_institutions_group'];
                                                            else if(empty($vv['connection_with_ext_institution']))
                                                                $stat_item .= 'none';
                                                            else
                                                                $stat_item .= $vv['connection_with_ext_institution']; 

                                                            $stat_item .= ']';

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }

                                                    if(!empty($socio_economic_group) && is_array($socio_economic_group))
                                                    {
                                                        
                                                        foreach ($socio_economic_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Num. of Trainee Involved with Socio Economic Interest Group[';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            if(!empty($vv['socio_economic_group']))
                                                                $stat_item .= $vv['socio_economic_group'];
                                                            else if(empty($vv['involved_socio_economic_interest_group']))
                                                                $stat_item .= 'none';
                                                            else
                                                                $stat_item .= $vv['involved_socio_economic_interest_group']; 

                                                            $stat_item .= ']';

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }


                                                    if(!empty($agricultural_land_group) && is_array($agricultural_land_group))
                                                    {
                                                        
                                                        foreach ($agricultural_land_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Num. of Agricultural Land having Access to farming [';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            if(!empty($vv['agricultural_land_group']))
                                                                $stat_item .= $vv['agricultural_land_group'];
                                                            else if(empty($vv['agric_land_access_for_farming']))
                                                                $stat_item .= 'none';
                                                            else
                                                                $stat_item .= $vv['agric_land_access_for_farming']; 

                                                            $stat_item .= ']';

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }


                                                    if(!empty($land_ownership_group) && is_array($land_ownership_group))
                                                    {
                                                        
                                                        foreach ($land_ownership_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Ownership of Agricultural Land Used for Farming [';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            if(!empty($vv['land_ownership_group']))
                                                                $stat_item .= $vv['land_ownership_group'];
                                                            else if(empty($vv['ownership_agric_land']))
                                                                $stat_item .= 'none';
                                                            else
                                                                $stat_item .= $vv['ownership_agric_land']; 

                                                            $stat_item .= ']';

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }

                                                    if(!empty($main_land_use_group) && is_array($main_land_use_group))
                                                    {
                                                        
                                                        foreach ($main_land_use_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Num. of Main Land Use in the Area [';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            if(!empty($vv['main_land_use_group']))
                                                                $stat_item .= $vv['main_land_use_group'];
                                                            else if(empty($vv['mainland_use']))
                                                                $stat_item .= 'none';
                                                            else
                                                                $stat_item .= $vv['mainland_use']; 

                                                            $stat_item .= ']';

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }

                                                    if(!empty($energy_sources_group) && is_array($energy_sources_group))
                                                    {
                                                        
                                                        foreach ($energy_sources_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Num. of Sources of Energy [';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            if(!empty($vv['energy_sources_group']))
                                                                $stat_item .= $vv['energy_sources_group'];
                                                            else if(empty($vv['sources_of_energy_for_cooking']))
                                                                $stat_item .= 'none';
                                                            else
                                                                $stat_item .= $vv['sources_of_energy_for_cooking']; 

                                                            $stat_item .= ']';

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }

                                                    if(!empty($goods_tools_owned_group) && is_array($goods_tools_owned_group))
                                                    {
                                                        
                                                        foreach ($goods_tools_owned_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Num. of Tools and Goods Owned by Trainee [';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            if(!empty($vv['goods_tools_owned_group']))
                                                                $stat_item .= $vv['goods_tools_owned_group'];
                                                            else if(empty($vv['goods_tools_owned']))
                                                                $stat_item .= 'none';
                                                            else if(is_array(json_decode($vv['goods_tools_owned'])))
                                                            {
                                                                $goods_tools = json_decode($vv['goods_tools_owned']);
                                                                $gtv_seen = array();
                                                                if(!empty($goods_tools_owned_data) && is_array($goods_tools_owned_data))
                                                                {
                                                                    foreach ($goods_tools_owned_data as $key => $val) 
                                                                    {
                                                                        $goods_tools_str = $val["item"];
                                                                        $goods_tools_val = $val["id"];
                                                                        if(is_array($goods_tools))
                                                                        {
                                                                            foreach ($goods_tools as $key => $gtv) 
                                                                            {
                                                                                if($gtv == $goods_tools_val)
                                                                                {
                                                                                    array_push($gtv_seen, $goods_tools_str);
                                                                                }
                                                                            }      

                                                                        }
                                                                        
                                                                    }
                                                                }
                                                                if(!empty($gtv_seen))
                                                                {
                                                                    $stat_item .= implode($gtv_seen, ', ');
                                                                }

                                                            }
                                                            else
                                                                $stat_item .= $vv['goods_tools_owned']; 
                                                            

                                                            $stat_item .= ']';

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }


                                                    if(!empty($first_source_group) && is_array($first_source_group))
                                                    {
                                                        
                                                        foreach ($first_source_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Num. of First Sources of Livelihood by Trainee [';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            if(!empty($vv['first_source_group']))
                                                                $stat_item .= $vv['first_source_group'];
                                                            else if(empty($vv['first_source_livelihood']))
                                                                $stat_item .= 'none';
                                                            else
                                                                $stat_item .= $vv['first_source_livelihood']; 

                                                            $stat_item .= ']';

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }

                                                    if(!empty($second_source_group) && is_array($second_source_group))
                                                    {
                                                        
                                                        foreach ($second_source_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Num. of Second Sources of Livelihood by Trainee [';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            if(!empty($vv['second_source_group']))
                                                                $stat_item .= $vv['second_source_group'];
                                                            else if(empty($vv['second_source_livelihood']))
                                                                $stat_item .= 'none';
                                                            else
                                                                $stat_item .= $vv['second_source_livelihood']; 

                                                            $stat_item .= ']';

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }

                                                    if(!empty($trend_income_group) && is_array($trend_income_group))
                                                    {
                                                        
                                                        foreach ($trend_income_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Num. of Trend of Income by the Trainee in the Last 2 years [';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            if(!empty($vv['trend_income_group']))
                                                                $stat_item .= $vv['trend_income_group'];
                                                            else if(empty($vv['trend_of_income']))
                                                                $stat_item .= 'none';
                                                            else
                                                                $stat_item .= $vv['trend_of_income']; 

                                                            $stat_item .= ']';

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }

                                                    if(!empty($practices_off_season_group) && is_array($practices_off_season_group))
                                                    {
                                                        
                                                        foreach ($practices_off_season_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Num. of Trainee Practising Off-Season Agriculture';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }

                                                    if(!empty($production_cash_crops_group) && is_array($production_cash_crops_group))
                                                    {
                                                        
                                                        foreach ($production_cash_crops_group as $key => $vv) 
                                                        {
                                                            $stat_item = 'Num. of Trainee Practising Production Cash Crops';
                                                            $stat_val = '';
                                                            $count++;         
                                                            $stat_val = $vv['total'];
                                                            

                                                            $tbb .= '<tr>
                                                                        <td>'.$count.'</td>
                                                                        <td>'.$stat_item.'</td>
                                                                        <td>'.$stat_val.'</td>
                                                                        
                                                                    </tr>';                                                           
                                                        }   
                                                                                                               
                                                    }

                                                    if(!empty($livestock_group) && is_array($livestock_group))
                                                    {
                                                        $vv = $livestock_group[0];
                                                        $stat_item = 'Num. of Livestock [Cattle]';
                                                        $count++;         
                                                        $stat_val = $vv['total_cattle'];
                                                        $tbb .= '<tr>
                                                                    <td>'.$count.'</td>
                                                                    <td>'.$stat_item.'</td>
                                                                    <td>'.$stat_val.'</td>
                                                                    
                                                                </tr>';

                                                        $stat_item = 'Num. of Livestock [Goat]';
                                                        $count++;         
                                                        $stat_val = $vv['total_goat'];
                                                        $tbb .= '<tr>
                                                                    <td>'.$count.'</td>
                                                                    <td>'.$stat_item.'</td>
                                                                    <td>'.$stat_val.'</td>
                                                                    
                                                                </tr>';


                                                        $stat_item = 'Num. of Livestock [Sheep]';
                                                        $count++;         
                                                        $stat_val = $vv['total_sheep'];
                                                        $tbb .= '<tr>
                                                                    <td>'.$count.'</td>
                                                                    <td>'.$stat_item.'</td>
                                                                    <td>'.$stat_val.'</td>
                                                                    
                                                                </tr>';


                                                        $stat_item = 'Num. of Livestock [Poultry]';
                                                        $count++;         
                                                        $stat_val = $vv['total_poultry'];
                                                        $tbb .= '<tr>
                                                                    <td>'.$count.'</td>
                                                                    <td>'.$stat_item.'</td>
                                                                    <td>'.$stat_val.'</td>
                                                                    
                                                                </tr>';   
                                                                                                               
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
           $('#customers2').dataTable({
                                    "lengthMenu": [25, 50, 75, 100, 125, 150],
                                    "pageLength": 50
                                  });
       </script>

        
            
    
       
    </body>

</html>






