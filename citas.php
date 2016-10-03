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
	<link rel="stylesheet" href="assets/css/loader/loader.css" >
    <script src="assets/js/jquery-1.11.3.min.js"></script>
</head>
<body class="page-body page-fade" data-url="http://demo.neontheme.com">
<?php echo "<input type='hidden' value='".$_SESSION['idSucursal']."' id='idSucursal' />";
      echo "<input type='hidden' value='".( $_SESSION['idUsuario'] )."' id='idUsuario' />";
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
					<?php
						if  ($_SESSION["idRol"] == '0' || $_SESSION["idRol"] == '1')
							echo '
								<div class="col-sm-3">
											<div class="form-group">
												<label class="control-label">Agencias</label>
												<select name="cbSucursalesFiltro" id="cbSucursalesFiltro" class="select2" data-allow-clear="true" data-placeholder="Seleccione una Agencia ..."  >
															<option value ="0"></option>   
												</select>
											</div>
								</div>';
						else if ($_SESSION["idRol"] == '2')
						echo '
						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label">Ejecutivos</label>
								<select name="cbEjecutivosFiltro" id="cbEjecutivosFiltro" class="select2" data-allow-clear="true" data-placeholder="Seleccione un Ejecutivo ..."  >
											<option></option>
											<option value = "0"></option>   
								</select>
							</div>
						</div>';
					?>	
					<input type='hidden' value='0' id='idEjecutivo' />
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
					<?php
						// ESTA VALIDACION ES PARA QUE EL ADMINISTRADOR NO PUEDA AGREGAR CITAS
						if  ($_SESSION["idRol"] != '0' && $_SESSION["idRol"] != '1' )
						echo '
							<button class="btn btn-primary btn-icon icon-left" style="top:4px" type="button" id="btnAddCita">
									 <i class="entypo-list-add"></i> Agregar Cita
							</button>
							<button class="btn btn-primary btn-icon icon-left" style="top:4px" type="button" id="btnAddCliente">
									 <i class="entypo-list-add"></i> Agregar Cliente
							</button>';
						?>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile-1"> 
                            <table class="table table-bordered datatable" id="tblCitas">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cliente</th>
                                            <th>Vehiculo</th>
											<th>Placas</th>
                                            <th>Fecha</th>
                                            <th>Origen</th>
											<th>Ejecutivo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyCitas">
                                    </tbody>
                                     <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Cliente</th>
                                            <th>Vehiculo</th>
											<th>Placas</th>
                                            <th>Fecha</th>
                                            <th>Origen</th>
											<th>Ejecutivo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                             </table>
                        </div>
                    </div>
                </div>
        </div>


<div class="modal fade" id="addCita">
        <div class="modal-dialog" id="sizeAddCita" >
            <div class="modal-content" id="addCitaContent">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Agregar Cita</h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="formCitas" method="post" class="">
                        <div class="form-group validate-has-error">

                        </div>
                        <div class="row">
                             <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Cliente</label>
                                    <select name="cbClientes" id="cbClientes" class="select2" data-allow-clear="true" data-placeholder="Seleccione un cliente ..."  >
                                                <option></option>   
                                    </select>
                                </div>
                              </div>
                                
                             <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Vehiculo</label>
                                        <select name="cbVehiculos" id="cbVehiculos" class="select2" data-allow-clear="true" data-placeholder="Seleccione un Vehiculo ...">
                                                    <option></option>
                                                    <optgroup label="Clientes"></optgroup>
                                        </select>
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Sucursales</label>
                                    <select name="cbSucursales" id="cbSucursales" class="select2" data-allow-clear="true" data-placeholder="Seleccione una Sucursal ...">
                                                 <option></option>
                                                <optgroup label="Sucursales"></optgroup>
                                               
                                    </select>
                                </div>
                              </div>
                                
                             <div class="col-md-6">
                              <div class="form-group">
                                    <label class="control-label">Departamento</label>
                                    <select name="cbDptos" id="cbDptos" class="select2" data-allow-clear="true" data-placeholder="Seleccione un Departamento ...">
                                                <option></option>
                                                <optgroup label="Departamentos"></optgroup>
                                    </select>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class=" control-label">Dia</label>
                                    <input type="text" id="diaCita"   name="diaCita" class="form-control datepicker" data-start-date="-1d" data-end-date="+4w" sty>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                <label class="control-label">Horas Disponibles</label>
                                <select name="cbHoras" id="cbHoras" class="select2" data-allow-clear="true" data-placeholder="Seleccione una Hora ...">
                                            <option></option>
                                            <optgroup label="Horas Disponibles"></optgroup>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class=" control-label">Servicio de Traslado</label>
                                        <div class="make-switch" id="requiereServicio" name="requiereServicio"
                                         data-text-label="<i class='fa fa-car'></i>"
                                         data-on-label="Si" data-off-label="No">
                                            <input type="checkbox" checked="checked"  />
                                         </div>
                                </div>
                            </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Ejecutivos</label>
                                        <select name="cbEjecutivos" id="cbEjecutivos" class="select2" data-allow-clear="true" data-placeholder="Seleccione un ejecutivo ...">
                                                <option></option>
                                                <optgroup label="Ejecutivos"></optgroup>
                                            </select>
                                    </div>
                                </div>
                        </div>  
                        <button type="reset" class="btn btn-default" style="display:none"  id="resetFrmCita"/> 
                    </form>                                   
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-info" id="btnGuardarCita">Guardar</button>
                    <button type="button" class="btn btn-info" id="btnActualizar" style="display:none">Actualizar</button>
                </div>
            </div>
        </div>
</div>            


<div class="modal fade" id="addCliente">
        <div class="modal-dialog" id="sizeAddCliente" >
            <div class="modal-content" id="addCitaCliente">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Agregar Cliente</h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="formCliente" method="post" class="validate">
                        <div class="row">
                             <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Nombre Completo</label>
                                    <input class="form-control" type="text" placeholder="Nombre" data-message-required="Porfavor especifique un nombre" data-validate="required" name="nombre" id="nombre">
                                </div>
                            </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Telefono</label>
                                    <input class="form-control" type="text" placeholder="telefono" data-message-number="Porfavor especifique un telefono"
                                        data-message-required="Porfavor especifique un telefono valido" data-validate="required,number" name="telefono" id="telefono">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-header">
                                <h4 class="modal-title">Datos del Vehiculo</h4>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                             <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Modelo</label>
                                    <input class="form-control" type="text" placeholder="Modelo" data-message-required="Porfavor especifique un Modelo" data-validate="required" name="modelo" id="modelo">
                                </div>
                            </div>
                             <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Marca</label>
                                    <input class="form-control" type="text" placeholder="Marca" data-message-required="Porfavor especifique una Marca" data-validate="required" name="marca" id="marca">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Año</label>
                                    <input class="form-control" type="text" placeholder="Año" data-message-required="Porfavor especifique el año" data-message-number="Porfavor especifique un año valido" data-validate="required,number" name="ano" id="ano">
                                </div>
                            </div>
                             <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Placas</label>
                                    <input class="form-control" type="text" placeholder="Placas" data-message-required="Porfavor especifique las placas" data-validate="required" name="placas" id="placas">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Mail</label>
                                    <input class="form-control" type="text" placeholder="Mail" 
									data-message-required="Porfavor especifique un correo"
									data-message-email="Porfavor especifique mail valido" data-validate="required,email" name="mail" id="mail">
                                </div>
                            </div>
                        </div>   
                        <button type="reset" class="btn btn-default" style="display:none"  id="resetFrmCliente"/>  
                    </form>                                   
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-info" id="btnGuardarCliente">Guardar</button>
                    <button type="button" class="btn btn-info" id="btnActualizar" style="display:none">Actualizar</button>
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
<script src="js/citas.js"></script>
     
</html>
<?php
}else
    header("Location: Login.php");
    
?>




