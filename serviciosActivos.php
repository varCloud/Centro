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
 <?php echo "<input type='hidden' value='".$_SESSION['idSucursal']."' id='idSucursal' />";
      echo "<input type='hidden' value='".$_SESSION['idUsuario']."' id='idUsuario' />";
	  echo "<input type='hidden' value='".$_SESSION['lat']."' id='lat' />";
	  echo "<input type='hidden' value='".$_SESSION['lng']."' id='lng' />";
	  echo "<input type='hidden' value='".$_SESSION['idRol']."' id='idRol' />";
	  echo "<input type='hidden' value='".$_SESSION['direccionMapa']."' id='direccionMapa' />";
 ?>  

   
    <div class="page-container">


        <!-- MENU -->
          <?php include 'Menu/menu.php';?>


    <div class="main-content" >
          <?php include 'Footer/footer.php';?>
            <hr />
                <h2>Servicios Activos</h2 >
            <ht />
			  <div class = "row" style = "display:none">
					<div class="col-sm-3">
						<div class="form-group">
						 <label class="control-label">Fecha Citas</label>
								<div class="input-group">
									<div class="input-group-addon"> <a href="#"><i class="entypo-calendar"></i></a> </div>
								<!--	<input type="text" id="fechaCitasF" name="fechaCitasF" class="form-control daterange" data-format="D, dd MM yyyy">-->
								<input type="text" id="fechaInicio"   name="fechaInicio" class="form-control datepicker" data-start-date="-1d" data-end-date="+4w" sty>
							    <input type="hidden" id="fechaFin"  name="fechaFin"  value="" />		
								</div>
						</div>
					</div>					
				</div>
            <br />

        <div class="panel minimal minimal-gray">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h4>Servicios Activos</h4></div>
                    <div class="panel-options">
                        <ul class="nav nav-tabs">
							<li class="active" ><a  href="#serviciosActivos" tipoS="2" data-toggle="tab"  >Servicios Activos</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="tab-content" >
				   		<div class="tab-pane active" id="serviciosActivos"> 
                            <table class="table table-bordered datatable" id="tblServiciosActivos">
                                    <thead>
                                        <tr>
										    <th>#</th>
                                            <th>Cliente</th>
                                            <th>Vehiculo</th>
											<th>Placas</th>
											<th>Chofer Asignado</th>
                                            <th>Distancia</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyServiciosActivos">
                                    </tbody>
                                     <tfoot>
                                        <tr>
										    <th>#</th>
                                            <th>Cliente</th>
                                            <th>Vehiculo</th>
											<th>Placas</th>
											<th>Chofer Asignado</th>
                                            <th>Distancia</th>
                                        </tr>
                                    </tfoot>
                             </table>
                        </div>
					</div> <!-- DIV CONTENEDOR -->
                </div>
        </div>

	<div class="modal fade" id="addServicio">
        <div class="modal-dialog" id="sizeAddServicio" >
            <div class="modal-content" id="addServicioContent">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Servicio</h4>
                </div>
                <div class="modal-body">
				 <form role="form" id="formAddServicio" method="post" class="validate">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">Nombre Cliente</label>
								<input type="hidden" class="form-control" id="distancia" name="distancia"  />
								<input type="hidden" class="form-control" id="duracion" name="duracion"  />
								<input type="hidden" class="form-control" id="latOr" name="latOr"  />
								<input type="hidden" class="form-control" id="lnOr" name="lnOr"  >
								<input type="hidden" class="form-control" id="latDest" name="latDest"  >
								<input type="hidden" class="form-control" id="lngDest" name="lngDest"  >
								<input type="hidden" class="form-control" id="idChofer" name="idChofer"  >
								<input type="hidden" class="form-control" id="idServicio" name="idServicio"  >
								
                                <input type="text" class="form-control" id="nombreCompleto" 
										name="nombreCompleto" placeholder="Nombre Cliente" data-validate="required" 
										 data-message-required="Porfavor especifique el nombre del cliente">
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                     <label class="control-label">Descripcion Vehiculo</label>
                                    <input type="text" class="form-control" id="descripcionVehiculo" name="descripcionVehiculo" 
									placeholder="Descripcion del vehiculo" data-validate="required" 
									data-message-required="Porfavor especifique la descripcion del vehiculo" >                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">No.Orden</label>
                                <input type="text" class="form-control" id="noOrden" name="noOrden"
									   data-validate="required" data-message-required="No.Orden es requerido." 
									   placeholder="Numero de Orden" data-message-required="Porfavor especifique el numero de orden">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">Placas</label>
                                <input type="text" class="form-control" id="placas" name="placas"
									   data-validate="required" data-message-required="Porfavor especifique la placa del vehiculo." 
									   placeholder="Placas" >
                            </div>
                        </div>						
                    </div>
                    <div class="row">
						<div class="col-md-12">
                            <div class="form-group">
                                <label for="field-1" class="control-label">Origen (A)</label>
                                <input type="text" class="form-control" id="origen" value="<?php echo$_SESSION['direccionMapa'] ?>" 
								name="origen" placeholder="Origen" data-validate="required"
								data-message-required="Porfavor especifique el origen del servicio" >
                            </div>
                        </div>
					</div>
					<div class="row">
                         <div class="col-md-12">
                            <div class="form-group">
                                     <label class="control-label">Destino (B)</label>
                                    <input type="text" class="form-control" id="destino" 
									name="destino" placeholder="Destino" data-validate="required" 
									data-message-required="Porfavor especifique el destino del servicio" />
                            </div>
                        </div>
					</div>
					<div class="row">
						<div class="col-md-6">
                            <div class="form-group">
							    <label class="control-label">Obetener ruta </label>
								<button class="btn btn-success" style="top:10px;margin-left:10px;" type="button" id="btnRuta">
										 <i class="fa fa-map-marker"></i>
								</button>	
                            </div>
                        </div>
                    </div>  
					<div class="row">
							 <div class="col-md-12">
								<div class="form-group">				
									<div id="mapAddService" style="width:100%;height:380px;" ></div>
								</div>									
							</div>
					</div>
					<button type="reset" id="restAddCita" class="btn btn-default" data-dismiss="modal" style="display:none" >reset</button>
				</form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-info" id="btnAsignarChoferSinCita">Asignar Chofer</button>
                    <button type="button" class="btn btn-success" id="btnActualizar" style="display:none">Asignar Chofer</button>
                </div>
            </div>
        </div>
    </div>
	
	
	<div class="modal fade" id="modalMapaUbicacionChofer">
        <div class="modal-dialog" id="sizeMapa" >
            <div class="modal-content" id="addMapa">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Ubicacion Actual del Chofer </h4>
                </div>
                <div class="modal-body"> 
					<!--	<div class="row">
							 <div class="col-md-12">
								<div class="form-group">	
									<input type="text" class="form-control" id="destinoCliente" name="destinoCliente" placeholder="destino" data-validate="required" >								
								</div>									
							</div>	
						</div>
					-->
						<div class="row">
							 <div class="col-md-12">
								<div class="form-group">				
									<div id="mapaUbicacionChofer" style="width:100%;height:380px;" ></div>
								</div>									
							</div>
						</div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div> 	

</body>
    
    <link rel="stylesheet" href="assets/css/alertify/alertify.core.css" />
    <link rel="stylesheet" href="assets/css/alertify/alertify.default.css" id="toggleCSS" />

    <link rel="stylesheet" href="assets/css/font-icons/font-awesome/css/font-awesome.min.css" >
    <link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css" >
	<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css" >
    <link rel="stylesheet" href="assets/js/select2/select2.css">
   
    <link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css" id="style-resource-1">
    <link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css" id="style-resource-2">
    <link rel="stylesheet" href="assets/js/icheck/skins/square/_all.css" id="style-resource-6">

 <style>
.pac-container {
    background-color: #FFF;
      z-index: 10000051 !important;
    position: fixed;
    display: inline-block;
    float: left;
}
.modal{
    z-index: 20;   
}
.modal-backdrop{
    z-index: 10;        
}?
</style>
    <script src="assets/js/bootstrap.js" id="script-resource-3"></script>
    <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script>
    <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
    <script src="assets/js/datatables/datatablesOriginal.js"></script>
    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script src="assets/js/bootstrap-timepicker.min.js"></script>  
    <script src="assets/js/datepicker_es.js"></script> 
	<script src="assets/js/select2/select2.min.js" id="script-resource-8"></script>
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
	<script src="assets/js/jquery.validate.min.js" id="script-resource-8"></script>
    <!-- SCRIPT PARA EL SLIDER -->
    <script src="assets/frontend/js/nivo-lightbox/nivo-lightbox.min.js"></script>
    <!-- FIN SCRIPT PARA EL SLIDER -->
    <script src="assets/js/neon-custom.js" id="script-resource-17"></script>
    
    <!-- Demo Settings -->
    <script src="assets/js/neon-demo.js" id="script-resource-18"></script>
    <script src="assets/js/neon-skins.js" id="script-resource-19"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDiS48BXgqvjtNHsg2aIwTeMBWamOBKfxs&libraries=geometry,places"></script>
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
<script src="js/geoCoder.js"></script>
<script src="js/serviciosActivos.js"></script>
</html>
 <?php  include 'test.php';?>
<?php
}else
    header("Location: Login.php");
    
?>
    



