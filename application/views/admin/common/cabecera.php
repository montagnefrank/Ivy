<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url()?>admin/panel">
                    <img id="headlogo" src="<?php echo base_url()?>public/images/logo2.png"/>
                </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                             
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i><span class="badge">
                            <?php if(isset($alarmas)){
                            $cant=0;
                            foreach ($alarmas as $alarm):
                                $cant++;
                             endforeach;
                             
                             echo $cant;
                            }     
                        ?>
                            
                            
                        </span> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        
                        <?php if(isset($alarmas)){
                            
                            foreach ($alarmas as $alarm):
                         ?>       
                                <li>
                                    <a href="<?php echo base_url()?>admin/pendientes/obtener_pendiente1/<?php echo $alarm->id_pendiente ?>">
                                        <div>
                                            <i class="fa fa-comment fa-fw"></i> <?php echo substr ( $alarm->cpdescripcion , 0 ,50 ); ?>
                                            <span class="pull-right text-muted small"><?php echo $alarm->cpfecha." ". $alarm->cphora ?></span>
                                        </div>
                                    </a>
                                </li>     
                                <li class="divider"></li>
                                
                        <?php  endforeach;
                        } 
                        ?>
                        <li>
                            <a class="text-center" href="<?php echo base_url()?>admin/pendientes/obtener_todospendiente">
                                <strong>Ver todas las Alarmas</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <?php echo $sesion['usuario']; ?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url()?>admin/inicio/logout"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesion</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                       <?php  
                            foreach($main_tabs[$sesion['rol']] as $tabid=>$val): 
                              
                             echo '<li>';
                                //si es 4 es padre
                                if(count($val)==3){
                                    echo '<a href="#"><span class="fa '.$val['icon'].'"></span> '.$tabid.'<span class="fa arrow"></span></a>
                                         
                                            <ul class="nav nav-second-level">';
                                    
                                                for($i=0;$i< count($val['hijos']);$i++){
                                                     echo '<li><a href="'.base_url().'admin/'.$val['hijos'][$i]['cont'].'"><span class="fa '.$val['hijos'][$i]['icon'].'"></span> '.$val['hijos'][$i]['nombre'].'</a></li>';
                                                }
                                            echo '</ul>';
                                }
                                else
                                {
                                  echo '<a href="'.base_url().'admin/'.$val['cont'].'"><i class="fa '.$val['icon'].'"></i> '.$tabid.'</a>';  
                                }
                                echo '</li>';
                            endforeach;
                        ?>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>