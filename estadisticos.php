 <?php

session_start();
if(isset($_SESSION['usuario']) ||isset($_SESSION["Admin"]))
{

?>

<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from demo.neontheme.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 31 May 2016 13:27:56 GMT -->
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Admin Trans" />
    <meta name="author" content="Laborator.co" />
    <link rel="icon" href="Imgs/icon.png">
    <title>AdminTrans | Dalton</title>
    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
    <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
    <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">

    <!-- css para el slider-->
    <link rel="stylesheet" href="assets/frontend/css/neon.css" >
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
	  echo "<input type='hidden' value='".$_SESSION['idRol']."' id='idRol' />";
 ?>
    <!-- TS14647012744832: Xenon - Boostrap Admin Template created by Laborator / Please buy this theme and support the updates -->
    <div class="page-container">

        <!-- MENU -->
          <?php include 'Menu/menu.php';?>

    <div class="main-content" >
 <?php include 'Header/header.php';?>        
                <h2>Citas</h2>
				  <hr />
				<div class = "row">
					<div class="col-sm-2">
						<div class="form-group">
							<label class="control-label">Tipo Informacion</label>
							<select name="cbTipoInformacion" id="cbTipoInformacion" class="select2" data-allow-clear="true" data-placeholder="--Seleccione--"  >
										   <option></option>
                                           <optgroup label="Tipo de Informacion">
										   <option value = "1" >Servicios</option>
										   <option value = "2">Citas</option>
										   </optgroup>  
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						 <label class="control-label">Fecha Citas</label>
								<div class="input-group">
									<div class="input-group-addon"> <a href="#"><i class="entypo-calendar"></i></a> </div>
								    <input type="text"  sytle ="height: 39px;" id="dtpFecha" name="dtpFecha" class="form-control daterange" data-format="D, dd MM yyyy">
									
								</div>
						</div>
					</div>
					<div class="col-sm-3">
								<div class="form-group">
									<label class="control-label">Agencias</label>
									<select name="cbSucursalesFiltro" id="cbSucursalesFiltro" class="select2" data-allow-clear="true" data-placeholder="Seleccione una Agencia ..."  >
												<option></option>
												<optgroup label="Agencias"></optgroup>  
									</select>
								</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label">Ejecutivos</label>
							<select name="cbEjecutivosFiltro" id="cbEjecutivosFiltro" class="select2" data-allow-clear="true" data-placeholder="Seleccione un Ejecutivo ..."  >
											<option></option>
											<optgroup label="Ejecutivos"></optgroup>  
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label">Choferes</label>
							<select name="cbChoferesFiltro" id="cbChoferesFiltro" class="select2" data-allow-clear="true" data-placeholder="Seleccione un Ejecutivo ..."  >
											<option></option>
											<optgroup label="Choferes"></optgroup>  
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label">Estado del Servicio</label>
							<select name="cbEdoServicioFiltro" id="cbEdoServicioFiltro" class="select2" data-allow-clear="true" data-placeholder="Seleccione un Estado ..."  >
										   <option></option>
                                           <optgroup label="Estado del Servicio">
										   <option value = "null" >Todos los Servicios</option>
										  <!-- <option value = "-1">Con cita</option> -->
										   <option value = "0">Activos</option>
										   <option value = "1">Finalizados</option>
										   </optgroup>  
							</select>
						</div>
					</div>		
					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label">Agendados</label>
							<select name="cbConCita" id="cbConCita" class="select2" data-allow-clear="true" data-placeholder="Seleccione ..."  >
										   <option></option>
                                           <optgroup label="Servicios Agendados">
										   <option value = "null" >Todos los Servicios</option>
										  <!-- <option value = "-1">Con cita</option> -->
										   <option value = "1">Con Cita</option>
										   <option value = "0">Sin Cita</option>
										   </optgroup>  
							</select>
						</div>
					</div>						
					<div class="col-md-1">
						<div class="form-group">
						<label class="control-label">Buscar</label>
							<button class="btn btn-success" style="top:10px;%" type="button" id="btnFiltro">
									 <i class="fa fa-search-plus"></i>
							</button>	
						</div>
					</div>					
				</div>
            <br />

        <div class="panel minimal minimal-gray">
                <div class="panel-heading">
                    <div class="panel-title">
                    </div>
                    <div class="panel-options">
                    </div>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile-1"> 
                            <table class="table table-bordered datatable" id="tblEstadisticos">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cliente</th>
                                            <th>Vehiculo</th>
											<th>Placas</th>
                                            <th>Chofer</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyEstadisticos">
                                    </tbody>
                                     <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Cliente</th>
                                            <th>Vehiculo</th>
											<th>Placas</th>
                                            <th>Chofer</th>
                                        </tr>
                                    </tfoot>
                             </table>
                        </div>
                    </div>
                </div>
        </div>



</body>
    
    <link rel="stylesheet" href="assets/css/alertify/alertify.core.css" />
    <link rel="stylesheet" href="assets/css/alertify/alertify.default.css" id="toggleCSS" />
    <link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css" >
    <link rel="stylesheet" href="assets/js/select2/select2.css">
    <link rel="stylesheet" href="assets/css/font-icons/font-awesome/css/font-awesome.min.css" >
    <link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css" id="style-resource-1">
    <link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css" id="style-resource-2">
 	<link rel="stylesheet" href="assets/js/daterangepicker/daterangepicker-bs3.css">
    <script src="assets/js/bootstrap.js" id="script-resource-3"></script>
    <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script>
    <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
    <script src="assets/js/datatables/datatablesOriginal.js"></script>
    <script src="assets/js/joinable.js" id="script-resource-4"></script>
    <script src="assets/js/resizeable.js" id="script-resource-5"></script>
    <script src="assets/js/neon-api.js" id="script-resource-6"></script>
    <script src="assets/js/cookies.min.js" id="script-resource-7"></script>
    <script src="assets/js/select2/select2.min.js" id="script-resource-8"></script>
    <script src="assets/js/alertify.min.js"></script>
    <script src="assets/js/toastr.js" id="script-resource-15"></script>
    <script src="assets/js/bootstrap-datepicker.js" id="script-resource-12"></script>
	<script src="assets/js/moment.min.js" id=""></script>
	<script src="assets/js/daterangepicker/daterangepicker.js"></script>
	<!-- <script src="assets/js/datepickerrange_es.js"></script> -->

    <script src="assets/js/datepicker_es.js"></script> 

    <script src="assets/js/jquery.validate.min.js" id="script-resource-8"></script>
    <script src="assets/js/bootstrap-switch.min.js"></script>
    <script src="assets/js/neon-chat.js" id="script-resource-16"></script>

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
<script src="js/estadisticos.js"></script>
     
</html>
<?php
}else
    header("Location: Login.php");
    
?>

