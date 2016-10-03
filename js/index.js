
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var diasNumero = new Array("7","1","2","3","4","5","6");

 var opts = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
       };

function Notificacion(tipoNoti,msj,titulo)
{
    switch(tipoNoti)
    {
        case 'success':
         toastr.success(msj , titulo, opts);
        break;

        case 'info':
         toastr.info(msj , titulo, opts);
        break;

        case 'error':
         toastr.error(msj , titulo, opts);
        break;

        case 'warning':
         toastr.warning(msj , titulo, opts);
        break;
    }
   
}
              
function CerrarSesion()
{
      $.ajax({
        type: "POST",
        url: "php/DAO/logoutDAO.php",
        data: "",
        async: false,
        dataType: "json",
        success: function(datos) {

            if(datos.login_status=='success')
            {
                window.location.href = "index.php";
            }

        }
    });

}

function LimpiaTabla(tabla)
{
   $('#'+tabla).DataTable().clear().destroy();
}

function InicializaTabla(tabla)
{
    
     $('#'+tabla).DataTable({
      "language": {
            "lengthMenu": "Muestra _MENU_ registros por pagina",
            "zeroRecords": "No existe registro",
            "info": "Pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No existe informacion para mostrar",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search":         "Buscar:",
            "paginate": {
                            "first":      "First",
                            "last":       "Last",
                            "next":       "Siguiente",
                            "previous":   "Anterior"
                        },
        },
        "bDestroy": true, // es necesario para poder ejecutar la funcion LimpiaTabla()
     });
}
      

function resetAlert () {
	
    $("#toggleCSS").attr("href", "assets/css/alertify/alertify.default.css");
    alertify.set({
        labels : {
            ok     : "Aceptar",
            cancel : "Cancelar"
        },
        delay : 5000,
        buttonReverse : false,
        buttonFocus   : "Aceptar"
    });
}  

function Resetform(button)
{
    $("#"+button).trigger('click');
    $(".form-group").removeClass('validate-has-error'); 
	$(".form-group").find('.error').css('display','none');
	$(".select2").select2("val", "");
	$(".form-group").find('.validate-has-error').css('display','none');
	
}

function ObtenerCitasDiarias()
{
	if($("#idRol").val()=="0" || $("#idRol").val()=="1")
	{
		$.ajax({
			type: "POST",
			url: "php/DAO/citasDAO.php",
			data: "accion=obtenerCitasXDia",
			async: false,
			dataType: "json",
			success: function(datos) {
		   if(datos != null)
				{				
						data='';
					   $.each(datos, function(i, item) {
						  data+='<div class="col-sm-3 col-xs-6">';
						  data+=' <div class="tile-stats tile-red">';
						  data+=' <div class="icon"><i class="entypo-users"></i></div>';
						  data+=' <div class="num" data-start="0" data-end="'+item.total+'" data-postfix="" data-duration="1500" data-delay="0">'+item.total+'</div>';
						  data+='	<h3>Agencia: '+item.descripcion+'</h3>';
						  data+='	<p>Citas pendientes por atender el dia de hoy de.</p>';
						  data+='</div>';
						  data+='</div>'; 
					   });
					$("#citasPendientes").html(data);
				}
			}
		});
	}
}



function MuestraLoader(msj)
{
	
	if(msj !='')
	{
		//alert(msj);
		$("#labelLoader").html(msj);
	}else
	{
		$("#Cargando").html(msj);
	}
	$("#loader").show();
}

function OcultarLoader(msj)
{
	$("#loader").hide();
}

$( document ).ready(function() {
	ObtenerCitasDiarias();
});
