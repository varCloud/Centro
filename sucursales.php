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


    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!-- Generic page styles -->
    <link rel="stylesheet" href="fu/css/style.css">
    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="fu/css/jquery.fileupload.css">
    <link rel="stylesheet" href="fu/css/jquery.fileupload-ui.css">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="fu/css/jquery.fileupload-noscript.css"></noscript>
    <noscript><link rel="stylesheet" href="fu/css/jquery.fileupload-ui-noscript.css"></noscript>

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
                <div class="row">
                    <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">

                        <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
                        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                        <div class="row fileupload-buttonbar" align="center"> 
                            <div class="col-lg-12">
                                <!-- The fileinput-button span is used to style the file input field as button -->
                                <span class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Agregar Imagenes...</span>
                                    <input type="file" name="files[]" id="file" multiple>
                                </span>
                                <button type="submit" class="btn btn-primary start">
                                    <i class="glyphicon glyphicon-upload"></i>
                                    <span>Guardar Todo</span>
                                </button>
                                <button type="reset" class="btn btn-warning cancel">
                                    <i class="glyphicon glyphicon-ban-circle"></i>
                                    <span>Cancelar Todo</span>
                                </button>
                                <button type="button" class="btn btn-danger delete">
                                    <i class="glyphicon glyphicon-trash"></i>
                                    <span>Eliminar Todo</span>
                                </button>
                                <input type="checkbox" class="toggle">
                                <!-- The global file processing state -->
                                <span class="fileupload-process"></span>
                            </div>
                            <!-- The global progress state -->
                            <div class="col-lg-5 fileupload-progress fade">
                                <!-- The global progress bar -->
                                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                </div>
                                <!-- The extended global progress state -->
                                <div class="progress-extended">&nbsp;</div>
                            </div>
                        </div>
                        <!-- The table listing the files available for upload/download -->
                        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                    </form>
                </div>

                <div class='row'>
                    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
                        <div class="slides"></div>
                        <h3 class="title"></h3>
                        <a class="prev">‹</a>
                        <a class="next">›</a>
                        <a class="close">×</a>
                        <a class="play-pause"></a>
                        <ol class="indicator"></ol>
                    </div>
                    <!-- The template to display files available for upload -->
                    <script id="template-upload" type="text/x-tmpl">
                    {% for (var i=0, file; file=o.files[i]; i++) { %}
                        <tr class="template-upload fade">
                            <td>
                                <span class="preview"></span>
                            </td>
                            <td>
                                <p class="name">{%=file.name%}</p>
                                <strong class="error text-danger"></strong>
                            </td>
                            <td>
                                <p class="size">Processing...</p>
                                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
                            </td>
                            <td>
                                {% if (!i && !o.options.autoUpload) { %}
                                    <button class="btn btn-primary start" disabled>
                                        <i class="glyphicon glyphicon-upload"></i>
                                        <span>Guardar </span>
                                    </button>
                                {% } %}
                                {% if (!i) { %}
                                    <button class="btn btn-warning cancel">
                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                        <span>Cancelar</span>
                                    </button>
                                {% } %}
                            </td>
                        </tr>
                    {% } %}
                    </script>
                    <!-- The template to display files available for download -->
                    <script id="template-download" type="text/x-tmpl">
                    var cal.calendario=[];

                    {% for (var i=0, file; file=o.files[i]; i++) {

                        var count = Object.keys(cal.calendario).length;
                        if(count > 0)
                        {
                            cal.calendario=[];
                        }
                        cal.calendario.push({ 
                            "url" : file.thumbnailUrl,
                            "name":file.name,
                            "thumb"  :file.thumbnailUrl            
                        });

                     %}

                        <tr class="template-download fade">
                            <td>
                                <span class="preview">
                                    {% if (file.thumbnailUrl) { %}
                                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                                    {% } %}
                                </span>
                            </td>
                            <td>
                                <p class="name">
                                    {% if (file.url) { %}
                                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                                    {% } else { %}
                                        <span>{%=file.name%}</span>
                                    {% } %}
                                </p>
                                {% if (file.error) { %}
                                    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                                {% } %}
                            </td>
                            <td>
                                <span class="size">{%=o.formatFileSize(file.size)%}</span>
                            </td>
                            <td>
                                {% if (file.deleteUrl) { %}
                                    <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                                        <i class="glyphicon glyphicon-trash"></i>
                                        <span>Eliminar</span>
                                    </button>
                                    <input type="checkbox" name="delete" value="1" class="toggle">
                                {% } else { %}
                                    <button class="btn btn-warning cancel">
                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                        <span>Cancelar</span>
                                    </button>
                                {% } %}
                            </td>
                        </tr>
                    {% } %}
                    </script>                
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
  
    <script src="assets/js/joinable.js" id="script-resource-4"></script>
    <script src="assets/js/resizeable.js" id="script-resource-5"></script>
    <script src="assets/js/neon-api.js" id="script-resource-6"></script>
    <script src="assets/js/cookies.min.js" id="script-resource-7"></script>
    <script src="assets/js/selectboxit/jquery.selectBoxIt.min.js" ></script>

     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="fu/js/vendor/jquery.ui.widget.js"></script>
    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
    <!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <!-- blueimp Gallery script -->
    <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="fu/js/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="fu/js/jquery.fileupload.js"></script>
    <!-- The File Upload processing plugin -->
    <script src="fu/js/jquery.fileupload-process.js"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="fu/js/jquery.fileupload-image.js"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="fu/js/jquery.fileupload-audio.js"></script>
    <!-- The File Upload video preview plugin -->
    <script src="fu/js/jquery.fileupload-video.js"></script>
    <!-- The File Upload validation plugin -->
    <script src="fu/js/jquery.fileupload-validate.js"></script>
    <!-- The File Upload user interface plugin -->
    <script src="fu/js/jquery.fileupload-ui.js"></script>
    <!-- The main application script -->
    <script src="fu/js/main.js"></script>

    <script src="assets/js/jquery.validate.min.js"></script>
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



