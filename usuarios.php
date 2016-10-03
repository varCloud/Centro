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
</head>
<body class="page-body page-fade" data-url="http://demo.neontheme.com">
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
                <h2>Usuarios</h2>
            <br />

	<div class="panel panel-primary" id="charts_env">
                <div class="panel-heading">
                    <div class="panel-title"></div>
                    <div class="panel-options">
                    <button class="btn btn-primary btn-icon icon-left" style="top:4px" type="button" id="btnAddUsuario"
                            >
                             <i class="entypo-list-add"></i> Agregar
                             </button>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="tab-pane active">
                        <div class="t" id="area-chart">
                             <table class="table table-bordered datatable" id="tblUsuarios">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Sucursal</th>
										<th>Rol</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyUsuarios">
                                </tbody>
                                 <tfoot>
                                    <tr>
                                       <th>#</th>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Sucursal</th>
										<th>Rol</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                             </table>
                        </div>
                    </div>
                </div>
    </div>


<div class="modal fade" id="addUsuario">
        <div class="modal-dialog" id="sizeAddUsuario" >
            <div class="modal-content" id="addUsuarioContent">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Agregar Usuario</h4>
                </div>
                <div class="modal-body">
				<form role="form" id="frmUs" method="post" >
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Completo" data-validate="required" >
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                     <label class="control-label">Usuario</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" data-validate="required"  />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">constrase&ntilde;a</label>
                                <input type="text" class="form-control" id="contra" name="contra" data-validate="required" data-message-required="Placas es requerido." placeholder="constrase&ntilde;a">
                            </div>
                        </div>
						 <div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Rol</label>
								<select name="cbRoles" id="cbRoles" class="select2" data-allow-clear="true" 
								data-placeholder="Seleccione un Rol ...">
								<option></option>
								<optgroup label="Roles"></optgroup>
								</select>
							</div>
						</div>
                    </div>
				    <div class="row">
                        <div class="col-md-12">
							<div class="form-group">
								<label class="control-label">Sucursal</label>
								<select name="cbSucursal" id="cbSucursal" class="select2" data-allow-clear="true"
								data-placeholder="Seleccione una Sucursal ...">
								<option></option>
								<optgroup label="Sucursales"></optgroup>
								</select>
							</div>
                        </div>
                    </div>
					 <input type='hidden' value='null' id='idUsuarioEditar' name ="idUsuarioEditar" />
					 <button type="reset" class="btn btn-default" style="display:none"  id="resetUs"/> 
					</form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-info" id="btnGuardarUs">Guardar</button>
                    <button type="button" class="btn btn-info" id="btnActualizar" style="display:none">Actualizar</button>
                </div>
            </div>
        </div>
    </div>            
</body>
    
    <link rel="stylesheet" href="assets/css/alertify/alertify.core.css" />
    <link rel="stylesheet" href="assets/css/alertify/alertify.default.css" id="toggleCSS" />

    <link rel="stylesheet" href="assets/css/font-icons/font-awesome/css/font-awesome.min.css" >
    <link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css" >
    <link rel="stylesheet" href="assets/js/select2/select2.css">
    <link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css" id="style-resource-1">
    <link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css" id="style-resource-2">
    <link rel="stylesheet" href="assets/js/icheck/skins/square/_all.css" id="style-resource-6">

 
    <script src="assets/js/bootstrap.js" id="script-resource-3"></script>
    <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script>
    <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
    <script src="assets/js/datatables/datatablesOriginal.js"></script>
    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script src="assets/js/bootstrap-timepicker.min.js"></script>  
	<script src="assets/js/jquery.validate.min.js" id="script-resource-8"></script>
    <script src="assets/js/joinable.js" id="script-resource-4"></script>
    <script src="assets/js/resizeable.js" id="script-resource-5"></script>
    <script src="assets/js/neon-api.js" id="script-resource-6"></script>
    <script src="assets/js/cookies.min.js" id="script-resource-7"></script>

	<script src="assets/js/select2/select2.min.js" id="script-resource-8"></script>
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
<script src="js/usuarios.js"></script>

     
</html>
<?php
}else
    header("Location: Login.php");
    
?>
    



