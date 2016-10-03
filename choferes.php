<?php

session_start();
if(isset($_SESSION['usuario']) ||isset($_SESSION["Admin"]))
{

?>
 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="Laborator.co" />
    <link rel="icon" href="Imgs/icon.png">
    <title>AdminTrans | Dalton</title>
    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
    <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
    <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
    <!-- css para el slider-->
    <link rel="stylesheet" href="assets/frontend/css/neon.css" >
    <link rel="stylesheet" href="assets/frontend/js/nivo-lightbox/nivo-lightbox.css" >
    <link rel="stylesheet" href="assets/frontend/js/nivo-lightbox/themes/default/default.css">
    <!-- FIN css para el slider-->

    <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
    <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
    <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
    <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
    <link rel="stylesheet" href="assets/js/datatables/datatables.css" >

    <script src="assets/js/jquery-1.11.3.min.js"></script>


    <!--[if lt IE 9]><script src="http://demo.neontheme.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]> <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> <![endif]-->
    <!-- TS1464701274: Neon - Responsive Admin Template created by Laborator -->
</head>
<body class="page-body page-fade" data-url="http://demo.neontheme.com">
    <!-- TS14647012744832: Xenon - Boostrap Admin Template created by Laborator / Please buy this theme and support the updates -->
    <div class="page-container">


        <!-- MENU -->
          <?php include 'Menu/menu.php';?>


    <div class="main-content" >
  <?php include 'Header/header.php';?>   
            <hr />
                <h2>Choferes</h2>
            <br />

        <div class="panel minimal minimal-gray">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h4>Choferes</h4></div>
                    <div class="panel-options">
                        <ul class="nav nav-tabs">
                            <li class="active" aprobado="1" ><a href="#profile-1"  data-toggle="tab">Choferes Activos</a></li>
                            <li aprobado="0"><a href="#profile-2" data-toggle="tab"  >Choferes Inactivos</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile-1"> 
                            <table class="table table-bordered datatable" id="tblChoferesAprobados">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Usuario</th>
                                            <th>telefono</th>
                                            <th>Placas</th>
                                            <th>Poliza</th>
                                            <th>Licencia</th>
                                            <th>Auto</th>
                                            <th>Usuario</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyChoferes">
                                    </tbody>
                                     <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Usuario</th>
                                            <th>telefono</th>
                                            <th>Placas</th>
                                            <th>Poliza</th>
                                            <th>Licencia</th>
                                            <th>Auto</th>
                                            <th>Usuario</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                             </table>
                        </div>
                        <div class="tab-pane" id="profile-2"> 
                            <table class="table table-bordered datatable" id="tblChoferesSinAprobar">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Usuario</th>
                                            <th>telefono</th>
                                            <th>Placas</th>
                                            <th>Poliza</th>
                                            <th>Licencia</th>
                                            <th>Auto</th>
                                            <th>Usuario</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyChoferesSinAprobar">
                                    </tbody>
                                     <tfoot>
                                        <tr>
                                             <th>#</th>
                                            <th>Usuario</th>
                                            <th>telefono</th>
                                            <th>Placas</th>
                                            <th>Poliza</th>
                                            <th>Licencia</th>
                                            <th>Auto</th>
                                            <th>Usuario</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                             </table>
                        </div>
                    </div>
                </div>
        </div>

<div class="modal fade" id="addChofer">
        <div class="modal-dialog" id="sizeAddSucu" >
            <div class="modal-content" id="addSucuContent">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Actualizar Chofer</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" data-validate="required" >
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                     <label class="control-label">Telefono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono" data-validate="required"  />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">Placas</label>
                                <input type="text" class="form-control" id="placas" name="placas" data-validate="required" data-message-required="Placas es requerido." placeholder="Placas">
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tipo Unidad</label>
                                <input type="text" class="form-control" name="tipoUnidad" id="tipoUnidad" data-validate="required" data-message-required="Telefono es requerido." placeholder="Tipo de Unidad" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-sm-6 col-xs-6">
                                <div class="gallery-item">
                                    <a id="itemG1" href="assets/frontend/images/portfolio-img-large-1.png" data-lightbox-gallery="g1" class="image slide" title="Poliza"> <img src="assets/frontend/images/gallery-thumb-1.png" class="img-rounded" "  /> <span class="hover-zoom"></span> <span class="title">Poliza</span> </a>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <div class="gallery-item">
                                    <a  id="itemG2" href="assets/frontend/images/portfolio-img-large-1.png" data-lightbox-gallery="g1" class="image slide" title="Licencia"> <img src="assets/frontend/images/gallery-thumb-1.png" class="img-rounded" /> <span class="hover-zoom"></span> <span class="title">Licencia</span> </a>
                                </div>
                            </div>
                        </div>
                    </div>                                      
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-sm-6 col-xs-6">
                                <div class="gallery-item">
                                    <a id="itemG3"  href="assets/frontend/images/portfolio-img-large-1.png" data-lightbox-gallery="g1" class="image slide" title="Automovil"> <img src="assets/frontend/images/gallery-thumb-1.png" class="img-rounded" " /> <span class="hover-zoom"></span> <span class="title">Automovil</span> </a>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <div class="gallery-item">
                                    <a  id="itemG4" href="assets/frontend/images/portfolio-img-large-1.png" data-lightbox-gallery="g1" class="image slide" title="Usuario"> <img src="assets/frontend/images/gallery-thumb-1.png" class="img-rounded" /> <span class="hover-zoom"></span> <span class="title">Usuario</span> </a>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="row">
                          <div class="form-group">
                                    <label class="col-sm-3 control-label">Aprobar usuario</label>
                                    <div class="col-sm-5">
                                        <div class="make-switch" id="aprobado" name="aprobado" 
										data-text-label="<i class='entypo-user'></i>"
										data-on-label="Si" data-off-label="No">
                                            <input type="checkbox" checked="checked"  />
                                         </div>
                                    </div>
                                </div>
                    </div>
                           <!-- <form role="form" id="form1" method="post" class="validate">
                                <div class="form-group">
                                    <label class="control-label">Required Field + Custom Message</label>
                                    <input type="text" class="form-control" name="name" data-validate="required" data-message-required="This is custom message for required field." placeholder="Required Field" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Email Field</label>
                                    <input type="text" class="form-control" name="email" data-validate="email" placeholder="Email Field" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Input Min Field</label>
                                    <input type="text" class="form-control" name="min_field" data-validate="number,minlength[4]" placeholder="Numeric + Minimun Length Field" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Input Max Field</label>
                                    <input type="text" class="form-control" name="max_field" data-validate="maxlength[2]" placeholder="Maximum Length Field" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Numeric Field</label>
                                    <input type="text" class="form-control" name="number" data-validate="number" placeholder="Numeric Field" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">URL Field</label>
                                    <input type="text" class="form-control" name="url" data-validate="required,url" placeholder="URL" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Credit Card Field</label>
                                    <input type="text" class="form-control" name="creditcard" data-validate="required,creditcard" placeholder="Credit Card" />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Validate</button>
                                    <button type="reset" class="btn">Reset</button>
                                </div>
                            </form>-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-info" id="btnGuardarCho">Guardar</button>
                    <button type="button" class="btn btn-info" id="btnActualizar" style="display:none">Actualizar</button>
                </div>
            </div>
        </div>
    </div>            

</body>
    
    <link rel="stylesheet" href="assets/css/alertify/alertify.core.css" />
    <link rel="stylesheet" href="assets/css/alertify/alertify.default.css" id="toggleCSS" />

    <link rel="stylesheet" href="assets/css/font-icons/font-awesome/css/font-awesome.min.css" >
    <link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css" >
   
    <link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css" id="style-resource-1">
    <link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css" id="style-resource-2">
    <link rel="stylesheet" href="assets/js/icheck/skins/square/_all.css" id="style-resource-6">

 
    <script src="assets/js/bootstrap.js" id="script-resource-3"></script>
    <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script>
    <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
    <script src="assets/js/datatables/datatablesOriginal.js"></script>
    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script src="assets/js/bootstrap-timepicker.min.js"></script>  

    <script src="assets/js/joinable.js" id="script-resource-4"></script>
    <script src="assets/js/resizeable.js" id="script-resource-5"></script>
    <script src="assets/js/neon-api.js" id="script-resource-6"></script>
    <script src="assets/js/cookies.min.js" id="script-resource-7"></script>

    <script src="assets/js/selectboxit/jquery.selectBoxIt.min.js" ></script>

    <script src="assets/js/icheck/icheck.min.js" id="script-resource-18"></script>
    <script src="assets/js/alertify.min.js"></script>

    <script src="assets/js/toastr.js" id="script-resource-15"></script>
    <script src="assets/js/bootstrap-switch.min.js" id="script-resource-8"></script>
    <script src="assets/js/neon-chat.js" id="script-resource-16"></script>
    <!-- SCRIPT PARA EL SLIDER -->
    <script src="assets/frontend/js/nivo-lightbox/nivo-lightbox.min.js"></script>
    <!-- FIN SCRIPT PARA EL SLIDER -->
    <script src="assets/js/neon-custom.js" id="script-resource-17"></script>
    
    <!-- Demo Settings -->
    <script src="assets/js/neon-demo.js" id="script-resource-18"></script>
    <script src="assets/js/neon-skins.js" id="script-resource-19"></script>
<script type="text/javascript">
         

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-28991003-7']);
            _gaq.push(['_setDomainName', 'demo.neontheme.com']);
            _gaq.push(['_trackPageview']);
            (function () {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();


</script>
<script src="js/index.js"></script>
<script src="js/choferes.js"></script>

     
</html>
<?php
}else
    header("Location: Login.php");
    
?>
    



