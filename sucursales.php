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
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="Laborator.co" />
    <link rel="icon" href="Imgs/icon.png">
    <title>AdminTrans | Dalton</title>
    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
    <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
    <link rel="stylesheet" href="assets/css/bootstrap.css" id="style-resource-4">
    <link rel="stylesheet" href="assets/css/neon-core.css" id="style-resource-5">
    <link rel="stylesheet" href="assets/css/neon-theme.css" id="style-resource-6">
    <link rel="stylesheet" href="assets/css/neon-forms.css" id="style-resource-7">
    <link rel="stylesheet" href="assets/css/custom.css" id="style-resource-8">
    <link rel="stylesheet" href="assets/js/datatables/datatables.css" id="style-resource-9">
    <script src="assets/js/jquery-1.11.3.min.js"></script>


    <!--[if lt IE 9]><script src="http://demo.neontheme.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]> <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> <![endif]-->
    <!-- TS1464701274: Neon - Responsive Admin Template created by Laborator -->
</head>
<body class="page-body page-fade" data-url="http://demo.neontheme.com">
    <!-- TS14647012744832: Xenon - Boostrap Admin Template created by Laborator / Please buy this theme and support the updates -->
 <?php echo "<input type='hidden' value='".$_SESSION['idSucursal']."' id='idSucursal' />";
      echo "<input type='hidden' value='".$_SESSION['idUsuario']."' id='idUsuario' />";
	  echo "<input type='hidden' value='".$_SESSION['idRol']."' id='idRol' />";
 ?>
	<div class="page-container">


        <!-- MENU -->
          <?php include 'Menu/menu.php';?>


        <div class="main-content" >
          <?php include 'Header/header.php';?>   
            <hr />
  <h2>Agencias</h2>

            <br />
             <div class="panel panel-primary" id="charts_env">
                <div class="panel-heading">
                    <div class="panel-title"></div>
                    <div class="panel-options">
				<?php
					if  ($_SESSION["idRol"] == '0' || $_SESSION["idRol"] == '1')
							echo '
                    <button class="btn btn-primary btn-icon icon-left" style="top:4px" type="button" id="btnAddSucu">
                             <i class="entypo-list-add"></i> Agregar
        			 </button>';
				?>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="tab-pane active">
                        <div class="t" id="area-chart">
                             <table class="table table-bordered datatable" id="tblSucursales">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Agencia</th>
                                        <th>Folio Actual</th>
                                        <th>Tiempo entre citas</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="bodySucu">
                                </tbody>
                                 <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Agencia</th>
                                        <th>Folio Actual</th>
                                        <th>Tiempo entre citas</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                             </table>
                        </div>
                    </div>
                </div>
            </div>


<div class="modal fade" id="addSucu">
    <div class="modal-dialog" id="sizeAddSucu" >
        <div class="modal-content" id="addSucuContent">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Agregar Agencia</h4>
            </div>
            <div class="modal-body">
            <form role="form" id="formSucursal" method="post" class = "validate" >
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">Agencia</label>
                            <input type="text" class="form-control" id="sucursal" name="sucursal" placeholder="Agencia" data-validate="required" data-message-required="Porfavor especifique una sucursal">
                            <input type="hidden" name="idSucu" id="idSucu"  value="0" />
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="telefono" data-validate="required,number" data-message-required="Porfavor especifique un telefono"
                                data-message-number="El telefono solo puede tener digitos" >
                      
                        </div>
                    </div>
                </div>
                <div class='row'>
                     <div class="col-md-12">
					 		<div class="form-group">
                                     <label class="control-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" 
									name="direccion" placeholder="Ejm. Curtidores de Teremendo 423, Vasco de Quiroga, Morelia, México" data-validate="required" 
									data-message-required="Porf avor especifique una direccion tipo Google Maps" />
									<span style="color: blue; font-size: 11px; padding: 3px;">Formato de búsqueda: calle, número, colonia, ciudad y estado.</span>
                            </div>
							<input type="hidden" class="form-control" id="lat" name="lat" />
							<input type="hidden" class="form-control" id="lng" name="lng" />
                    </div>
                </div>
                </form>
                 <div class="panel minimal minimal-gray">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Configurar Horario</h4></div>
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tabAvanzado" data-toggle="tab">Avanzado</a></li>
                               <!-- <li><a href="#tabTipico" data-toggle="tab">Tipico</a></li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabAvanzado"> 
                               <table class="table table-bordered table-responsive"  cellpadding="0" cellspacing="0" id="tblCalendario">
                                     <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Dia</th>
                                                <th class="col-md-4">TipoHorario</th>
                                                <th>Hora Min</th>
                                                <th>Hora Max</th>
                                                <th id="headerMin">Hora Min</th>
                                                <th id="headerMax">Hora Max</th>
                                            </tr>
                                     </thead>
                                     <tbody>
                                            <tr  style="height:5px;">
                                                <td>
                                                    <input type="checkbox"  class="icheck-2" tabindex="6" style="position: absolute; opacity: 0;">
                                                </td>
                                                <td>Lunes</td>
                                                <td>
                                                         <select name="test" class="selectboxit" data-first-option="true" name="tipoHorario" id="tipoHorario">
                                                          <!--  <option value="0">Seleccione Horario</option> -->
                                                            <option value="1">Corrido</option>
                                                            <option value="2">Oficina</option>
                                                        </select>
                                                </td>
                                                <td id="LOficinaMin">
                                                        <div class="form-group" style="margin-bottom: 4px">
                                                            <input type="text" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="9:00 AM" data-show-meridian="false" data-minute-step="5" id="horaMinIni" /> 
                                                        </div>
                                                </td>
                                                <td  id="LOficinaMax">
                                                    <div class="form-group" style="margin-bottom: 4px">
                                                            <input type="text" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="9:00 AM" data-show-meridian="false" data-minute-step="5" id="horaMaxIni" /> 
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox"  class="icheck-2" tabindex="6" style="position: absolute; opacity: 0;">
                                                </td>
                                                <td>Martes</td>
                                                <td>
                                                         <select name="test" class="selectboxit" data-first-option="true" name="tipoHorario" id="tipoHorario">
                                                           <!--  <option value="0">Seleccione Horario</option> -->
                                                            <option value="1">Corrido</option>
                                                            <option value="2">Oficina</option>
                                                        </select>
                                                </td>
                                                <td>
                                                       <div class="form-group" style="margin-bottom: 4px">
                                                            <input type="text" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="9:00 AM" data-show-meridian="false" data-minute-step="5" id="horaMinIni" /> 
                                                     </div>
                                                </td>
                                                <td>
                                                          <div class="form-group" style="margin-bottom: 4px">
                                                            <input type="text" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="9:00 AM" data-show-meridian="false" data-minute-step="5" id="horaMaxIni" /> 
                                                        </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox"  class="icheck-2" tabindex="6" style="position: absolute; opacity: 0;">
                                                </td>
                                                <td>Miercoles</td>
                                                <td>
                                                         <select name="test" class="selectboxit" data-first-option="true" name="tipoHorario" id="tipoHorario">
                                                            <!--  <option value="0">Seleccione Horario</option> -->
                                                            <option value="1">Corrido</option>
                                                            <option value="2">Oficina</option>
                                                        </select>
                                                </td>
                                                <td>
                                                        <div class="form-group" style="margin-bottom: 4px">
                                                            <input type="text" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="9:00 AM" data-show-meridian="false" data-minute-step="5" id="horaMinIni" /> 
                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="form-group" style="margin-bottom: 4px">
                                                            <input type="text" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="9:00 AM" data-show-meridian="false" data-minute-step="5" id="horaMaxIni" /> 
                                                        </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox"  class="icheck-2" tabindex="6" style="position: absolute; opacity: 0;">
                                                </td>
                                                <td>Jueves</td>
                                                <td>
                                                         <select name="test" class="selectboxit" data-first-option="true" name="tipoHorario" id="tipoHorario">
                                                            <!--  <option value="0">Seleccione Horario</option> -->
                                                            <option value="1">Corrido</option>
                                                            <option value="2">Oficina</option>
                                                        </select>
                                                </td>
                                                <td>
                                                        <div class="form-group" style="margin-bottom: 4px">
                                                            <input type="text" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="9:00 AM" data-show-meridian="false" data-minute-step="5" id="horaMinIni" /> 
                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="form-group" style="margin-bottom: 4px">
                                                            <input type="text" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="9:00 AM" data-show-meridian="false" data-minute-step="5" id="horaMaxIni" /> 
                                                        </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <input type="checkbox"  class="icheck-2" tabindex="6" style="position: absolute; opacity: 0;">
                                                </td>
                                                <td>Viernes</td>
                                                <td>
                                                    <select name="test" class="selectboxit" data-first-option="true" name="tipoHorario" id="tipoHorario">
                                                            <!--  <option value="0">Seleccione Horario</option> -->
                                                            <option value="1">Corrido</option>
                                                            <option value="2">Oficina</option>
                                                        </select>
                                                </td>
                                                <td>
                                                        <div class="form-group" style="margin-bottom: 4px">
                                                            <input type="text" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="9:00 AM" data-show-meridian="false" data-minute-step="5" id="horaMinIni" /> 
                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="form-group" style="margin-bottom: 4px">
                                                            <input type="text" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="9:00 AM" data-show-meridian="false" data-minute-step="5" id="horaMaxIni" /> 
                                                        </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox"  class="icheck-2" tabindex="6" style="position: absolute; opacity: 0;">
                                                </td>
                                                <td>Sabado</td>
                                                <td>
                                                         <select name="test" class="selectboxit" data-first-option="true" name="tipoHorario" id="tipoHorario">
                                                           <!--  <option value="0">Seleccione Horario</option> -->
                                                            <option value="1">Corrido</option>
                                                            <option value="2">Oficina</option>
                                                        </select>
                                                </td>
                                                <td>
                                                       <div class="form-group" style="margin-bottom: 4px">
                                                            <input type="text" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="9:00 AM" data-show-meridian="false" data-minute-step="5" id="horaMinIni" /> 
                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="form-group" style="margin-bottom: 4px">
                                                            <input type="text" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="9:00 AM" data-show-meridian="false" data-minute-step="5" id="horaMaxIni" /> 
                                                        </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox"  class="icheck-2" tabindex="6" style="position: absolute; opacity: 0;">
                                                </td>
                                                <td>Domingo</td>
                                                <td>
                                                         <select name="test" class="selectboxit" data-first-option="true" name="tipoHorario" id="tipoHorario">
                                                            <!--  <option value="0">Seleccione Horario</option> -->
                                                            <option value="1">Corrido</option>
                                                            <option value="2">Oficina</option>
                                                        </select>
                                                </td>
                                                <td>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="9:00 AM" data-show-meridian="false" data-minute-step="5" id="horaMinIni" /> 
                                                        </div>
                                                </td>
                                                <td>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="9:00 AM" data-show-meridian="false" data-minute-step="5" id="horaMaxIni" /> 
                                                        </div>
                                                </td>
                                            </tr>
                                     </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tabTipico"> 
                                  <div class="row">
                                         <table class="table table-bordered table-responsive" id="tblCalendarioTipico">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Dia(s)</th>
                                                    <th class="col-md-4">TipoHorario</th>
                                                    <th>Hora Min</th>
                                                    <th>Hora Max</th>
                                                    <th id="headerMinTipico">Hora Min</th>
                                                    <th id="headerMaxTipico">Hora Max</th>
                                                </tr>
                                         </thead>
                                         <tbody>
                                                <tr>
                                                  <td>1</td>
                                                    <td> 
                                                          <a href="#"><i class="entypo-calendar"></i>
                                                          <span class="title"> Lunes a Viernes </span></a></li>
                                                    </td>
                                                    <td>
                                                        <select name="test" class="selectboxit" data-first-option="false" name="tipoHorarioTipico" id="tipoHorarioTipico">
                                                        <option value="0">Seleccione Horario</option>
                                                        <option value="1">Corrido</option>
                                                        <option value="2">Oficina</option>
                                                        </select>
                                  
                                                    </td>
                                                    <td id="OficinaMin">
                                                                <input type="text" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="9:00 AM" data-show-meridian="true" data-minute-step="5" id="horaMinIni" /> 
                                                    </td>
                                                    <td  id="LOficinaMax">
                                                            <div class="">
                                                                <input type="text" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="9:00 AM" data-show-meridian="true" data-minute-step="5" id="horaMaxIni" /> 
                                                            </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                         </table>                                                                                    
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tiempo entre Citas </label>
                            <div class="col-sm-5">
                                <div class="input-spinner">
                                    <button type="button" class="btn btn-default">-</button>
                                    <input id="timepoEntreCitas" type="text" class="form-control size-1" value="1" data-min="0" data-max="60" />
                                    <button type="button" class="btn btn-default">+</button>
                                     <label class="col-sm-3 control-label">Minutos</label>   
                                </div>
                            </div>                       
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-info" id="btnGuardar">Guardar</button>
                <button type="button" class="btn btn-info" id="btnActualizar" style="display:none">Actualizar</button>
            </div>
        </div>
        </div>
</div>            


<div class="modal fade" id="addDpto">
    <div class="modal-dialog" id="sizeAddDpto" >
        <div class="modal-content" id="addDptoContent">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Agregar Departamentos a la Agencia</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="formAddDpto" method="post" class = "validate" >
                </form>
 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-info" id="btnAsignarDpto">Asignar</button>
            </div>
        </div>
    </div>
</div>   
</body>
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
}​
</style>

    <link rel="stylesheet" href="assets/css/alertify/alertify.core.css" />
    <link rel="stylesheet" href="assets/css/alertify/alertify.default.css" id="toggleCSS" />

    <link rel="stylesheet" href="assets/css/font-icons/font-awesome/css/font-awesome.min.css" >
    <link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css" >
    <link rel="stylesheet" href="assets/js/daterangepicker/daterangepicker-bs3.css" >
    <link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css" id="style-resource-1">
    <link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css" id="style-resource-2">
    <link rel="stylesheet" href="assets/js/icheck/skins/square/_all.css" id="style-resource-6">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
 
    <script src="assets/js/bootstrap.js" id="script-resource-3"></script>
    <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script>
    <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
    <script src="assets/js/datatables/datatablesOriginal.js"></script>
    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script src="assets/js/bootstrap-timepicker.min.js"></script>  
    <script src="assets/js/jquery.validate.min.js"></script>
    <script src="assets/js/joinable.js" id="script-resource-4"></script>
    <script src="assets/js/resizeable.js" id="script-resource-5"></script>
    <script src="assets/js/neon-api.js" id="script-resource-6"></script>
    <script src="assets/js/cookies.min.js" id="script-resource-7"></script>

    <script src="assets/js/selectboxit/jquery.selectBoxIt.min.js" ></script>



    <script src="assets/js/icheck/icheck.min.js" id="script-resource-18"></script>
    <script src="assets/js/alertify.min.js"></script>

    <script src="assets/js/toastr.js" id="script-resource-15"></script>
    <script src="assets/js/neon-chat.js" id="script-resource-16"></script>
    <!-- JavaScripts initializations and stuff -->
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
<script src="js/sucursales.js"></script>

     
</html>

<?php
}else
    header("Location: Login.php");
    
?>



