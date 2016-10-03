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
    <!-- TS14647012744832: Xenon - Boostrap Admin Template created by Laborator / Please buy this theme and support the updates -->
    <div class="page-container">

        <!-- MENU -->
          <?php include 'Menu/menu.php';?>

    <div class="main-content" >
         <?php include 'Header/header.php';?>   
            <hr />
                <h2>Clientes</h2>
            <br />

        <div class="panel minimal minimal-gray">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h4>Clientes</h4></div>
                    <div class="panel-options">
                        <ul class="nav nav-tabs">
                            <li class="active" aprobado="1" ><a href="#profile-1"  data-toggle="tab">Clientes</a></li>
                           <!-- <li aprobado="0"><a href="#profile-2" data-toggle="tab"  >Clientes Eliminados</a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile-1"> 
                            <table class="table table-bordered datatable" id="tblClientesActivos">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Usuario/Mail</th>
                                            <th>fecha de alta</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyClientes">
                                    </tbody>
                                     <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Usuario/Mail</th>
                                            <th>fecha de alta</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                             </table>
                        </div>
                    <!--  esta es por si  quieres veer los clientes eliminados podria ser un historial
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
                    -->
                    </div>
                </div>
        </div>

<div class="modal fade" id="addCliente">
        <div class="modal-dialog" id="sizeAddCliente" >
            <div class="modal-content" id="addClienteContent">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Actualizar Cliente</h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="formCliente" method="post" class="validate">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" 
                                     data-validate="required" data-message-required="Porfavor especifique un nombre" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail" class="control-label">Usuario/Mail</label>
                                    <input type="text" class="form-control" id="mail" name="mail" data-validate="required,email" data-message-required="Porfavor especifique un e-mail" 
                                    data-message-email="Porvafor especifique e-mail valido" placeholder="Mail">
                                </div>
                            </div>							
                          <!--   <div class="col-md-6">
                                <div class="form-group">
                                         <label class="control-label">Usuario</label>
                                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" data-validate="required" disabled=""  />
                                </div>
                            </div>
							-->
                        </div>
                        <div class="row">
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Fecha Alta</label>
                                    <input type="text" class="form-control" name="fechaAlta" id="fechaAlta" disabled=""/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                               <table class="table table-bordered datatable" id="tblVehiculosActivos">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Año</th>
                                                <th>Placas</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyVehiculos">
                                        </tbody>
                                         <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Año</th>
                                                <th>Placas</th>
                                            </tr>
                                        </tfoot>
                                 </table>
                            </div>
                        </div>    
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

    <link rel="stylesheet" href="assets/css/font-icons/font-awesome/css/font-awesome.min.css" >
    <link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css" >
   
    <link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css" id="style-resource-1">
    <link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css" id="style-resource-2">
    <link rel="stylesheet" href="assets/js/icheck/skins/square/_all.css" id="style-resource-6">

 
    <script src="assets/js/bootstrap.js" id="script-resource-3"></script>
    <script src="assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script>
    <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
    <script src="assets/js/datatables/datatablesOriginal.js"></script>


    <script src="assets/js/joinable.js" id="script-resource-4"></script>
    <script src="assets/js/resizeable.js" id="script-resource-5"></script>
    <script src="assets/js/neon-api.js" id="script-resource-6"></script>
    <script src="assets/js/cookies.min.js" id="script-resource-7"></script>

    <script src="assets/js/selectboxit/jquery.selectBoxIt.min.js" ></script>

    <script src="assets/js/icheck/icheck.min.js" id="script-resource-18"></script>
    <script src="assets/js/alertify.min.js"></script>

    <script src="assets/js/toastr.js" id="script-resource-15"></script>
    <script src="assets/js/bootstrap-switch.min.js" id="script-resource-8"></script>
    <script src="assets/js/jquery.validate.min.js" id="script-resource-8"></script>
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
<script src="js/clientes.js"></script>

     
</html>
    <?php
}else
    header("Location: Login.php");
    
?>



