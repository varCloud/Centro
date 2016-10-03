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
    <div class="page-container">


        <!-- MENU -->
          <?php include 'Menu/menu.php';?>


        <div class="main-content" >
          <?php include 'Footer/footer.php';?>
            <hr />
                <h2>Departamentos</h2>
            <br />
             <div class="panel panel-primary" id="charts_env">
                <div class="panel-heading">
                    <div class="panel-title"></div>
                    <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" style="top:4px" type="button" id="btnAddDpto"
                            >
                             <i class="entypo-list-add"></i> Agregar
                             </button>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="tab-pane active">
                        <div class="t" id="area-chart">
                             <table class="table table-bordered datatable" id="tblDptos">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Departamento</th>
                                        <th>Telefono</th>
                                        <th>Sucursal</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyDpto">
                                </tbody>
                                 <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Departamento</th>
                                        <th>telefono</th>
                                        <th>Sucursal</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                             </table>
                        </div>
                    </div>
                </div>
            </div>


<div class="modal fade" id="addDpto">
        <div class="modal-dialog" id="sizeAdDpto" style="width:25%" >
            <div class="modal-content" id="addDptoContent">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Agregar Departamento</h4>
                </div>
                <div class="modal-body">
                      <form role="form" id="formDpto" method="post" class = "validate" >
                            <div class="row">
                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Departamento</label>
                                            <input type="text" class="form-control" name="dpto" id="dpto"  placeholder="Departamento"  data-validate="required" data-message-required="Porfavor especifique un departamento"/>
                                        </div>
                                    </div>
                            </div>
                            <div class="row">
                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Telefono</label>
                                            <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Telefono"  data-validate="required,number" data-message-required="Porfavor especifique un telefono" 
                                             data-message-number="El telefono solo puede tener digitos" />
                                        </div>
                                    </div>
                            </div>
                            <input type="reset" value="Reset" id="resetFrmDpto" style="display:none" >
                       </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-info" id="btnGuardarDpto">Guardar</button>
                    <button type="button" class="btn btn-info" id="btnActualizarDpto" style="display:none">Actualizar</button>

                </div>
            </div>
        </div>
</div>            

</body>
    
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

    <script src="assets/js/icheck/icheck.min.js" id="script-resource-18"></script>
    <script src="assets/js/alertify.min.js"></script>

    <script src="assets/js/toastr.js" id="script-resource-15"></script>
    <script src="assets/js/neon-chat.js" id="script-resource-16"></script>
    <!-- JavaScripts initializations and stuff -->
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
<script src="js/dptos.js"></script>

     
</html>

<?php
}else
    header("Location: Login.php");
    
?>



