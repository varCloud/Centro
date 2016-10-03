var idClienteActual
var dtpF;


function initFormulario()
{

  $("#formCitas").validate({
      ignore: [], 
      rules: {
          cbClientes: {required: true,},
          cbVehiculos: {required: true,},
          cbSucursales: {required: true,},
          cbDptos: {required: true,},
          diaCita: {required: true,},
          cbHoras: {required: true,},
          
      },
      messages: {
        cbClientes: "Porfavor especifique un cliente",
        cbVehiculos: "Porfavor especifique un cehiculo",
        cbSucursales: "Porfavor especifique una sucursal",
        cbDptos: "Porfavor especifique un departamento",
        cbHoras: "Porfavor especifique una hora",
        diaCita: { required: "Porfavor especifique una fecha",  }
      },

       highlight: function(element){
          $(element).closest('.form-group').addClass('validate-has-error');
          $(element).closest('.form-group').find('label .error').addClass('validate-has-error');
         
        },
        
        unhighlight: function(element)
        {
          $(element).closest('.form-group').removeClass('validate-has-error');
          $(element).closest('.form-group').find('label .error').removeClass('validate-has-error');
        },

        errorPlacement: function(error, element) {
           $(error).addClass('validate-has-error');
            error.insertAfter(element);
        }

    });
}

function pintaTabla(datos)
{
	var data='';
	if($("#cbTipoInformacion").val() == "1")
	{
	 data ='<thead>';
		data +='<tr>';
			data +='<th>#</th>';
			data +='<th>Cliente</th>';
			data +='<th>Vehiculo</th>';
			data +='<th>Placas</th>';
			data +='<th>Chofer</th>';
			data +='<th>Ejecutvio</th>';
			data +='<th>Origen</th>';
			data +='<th>Destino</th>';
			data +='<th>Fecha / Hora</th>';
			data +='<th>Estado Servicio</th>';
		data +='</tr>';
	data +='</thead>';
	data +='<tbody id="bodyEstadisticos">';
	data +='</tbody>';
	 data +='<tfoot>';
		data +='<tr>';
			data +='<th>#</th>';
			data +='<th>Cliente</th>';
			data +='<th>Vehiculo</th>';
			data +='<th>Placas</th>';
			data +='<th>Chofer</th>';
			data +='<th>Ejecutvio</th>';
			data +='<th>Origen</th>';
			data +='<th>Destino</th>';
			data +='<th>Fecha / Hora</th>';
			data +='<th>Estado Servicio</th>';
		data +='</tr>';
	data +='</tfoot>';
	$("#tblEstadisticos").html(data);
	data='';
	        $.each(datos, function(i, item) {
                  data+='<tr>';
                  data+='<td>'+(i+1)+'</td>';
                  data+='<td>'+item.nombreCompleto+'</td>';
                  data+='<td>'+item.vehiculoDescripcion+'</td>';
				  data+='<td>'+item.placas+'</td>';
				  data+='<td>'+item.usuario+'</td>';
				  data+='<td>'+item.nombreEje+'</td>';
				  data+='<td>'+item.origen+'</td>';
				  data+='<td>'+item.destino+'</td>';
				  data+='<td>'+item.fecha+'</td>';
				  data+='<td><div align="center">'+(item.servicioFinalizado=="1" ? "<div class='label label-success'>Finalizado</div>" : "<div class='label label-info'>Activo</div>")+'</div></td>';
				  //data+='<td>'+(item.idChofer == 'null' ? 'Servicio sin chofer asignado ' : item.usuario)+'</td>';
				  //data+='<td><div align="center">'+(item.servicioFinalizado=="1" ? "<div class='label label-success'>SI</div>" : "<div class='label label-danger'>NO</div>")+'</div></td>';	  				  
                  data+='</tr>'
                });
             
			 $("#bodyEstadisticos").html(data);
             InicializaTabla("tblEstadisticos");
	}else
	{
		var data ='<thead>';
			data +='<tr>';
				data +='<th>#</th>';
				data +='<th>Cliente</th>';
				data +='<th>Vehiculo</th>';
				data +='<th>Placas</th>';
				data +='<th>Origen</th>';
				data +='<th>fecha de Cita</th>';
				data +='<th>Ejecutvio</th>';
			data +='</tr>';
		data +='</thead>';
		data +='<tbody id="bodyEstadisticos">';
		data +='</tbody>';
		 data +='<tfoot>';
			data +='<tr>';
				data +='<th>#</th>';
				data +='<th>Cliente</th>';
				data +='<th>Vehiculo</th>';
				data +='<th>Placas</th>';
				data +='<th>0rigen</th>';
				data +='<th>fecha de Cita</th>';
				data +='<th>Ejecutvio</th>';
			data +='</tr>';
		data +='</tfoot>';
		$("#tblEstadisticos").html(data);
	    data='';
		$.each(datos, function(i, item) {
                  data+='<tr>';
                  data+='<td>'+(i+1)+'</td>';
                  data+='<td>'+item.nombreCompleto+'</td>';
                  data+='<td>'+item.vehiculoDescripcion+'</td>';
				  data+='<td>'+item.placas+'</td>';
				  data+='<td><div align="center">'+(item.origen=="1" ? "<div class='label label-success'>App</div>" : "<div class='label label-info'>Administrativo</div>")+'</div></td>';
                  data+='<td>'+item.fechaCita+'</td>';
				  data+='<td>'+item.usuarioNombre+'</td>';
				  data+='</tr>'
                });
             
			 $("#bodyEstadisticos").html(data);
             InicializaTabla("tblEstadisticos");
	}
	return data;
	
}

function ObtenerChoferesFiltro()
{
	$.ajax({
		type: "POST",
		url: "php/DAO/estadisticosDAO.php",
		data: "accion=ObtenerChoferes",
		async: false,
		dataType: "json",
		success: function(datos) {
				 var data ='';
				 var data ='<option value=""></option>';
				 data +='<optgroup label="Choferes">';
				 data +='<option value="null">Todos los Choferes </option>';
					$.each(datos, function(i, item) {
						data+='<option value='+item.idChofer+'>'+item.usuario+'</option>';
					  });
				  data+='</optgroup>';

			  $("#cbChoferesFiltro").html(data);
			  $('#cbChoferesFiltro').val('null');
			  $('#cbChoferesFiltro').trigger('change');
		}
		});
}

function obtenerSucursalesFiltro()
{

	  $.ajax({
		type: "POST",
		url: "php/DAO/sucuDAO.php",
		data: "accion=obtenerSucursales&acitvo="+1+"&idSucursal=null",
		async: false,
		dataType: "json",
		success: function(datos) {
				 var data ='';
				 var data ='<option value=""></option>';
				 data +='<optgroup label="Agencias">';
				 data +='<option value="null">Todas</option>';
					$.each(datos, function(i, item) {
						data+='<option value='+item.idSucursal+'>'+item.descripcion+'</option>';
					  });
				  data+='</optgroup>';

			  $("#cbSucursalesFiltro").html(data);
		}
		});
}

function ObtenerDptosXSucursal(idSucursal)
{
  $.ajax({
    type: "POST",
    url: "php/DAO/dptosDAO.php",
    data: "accion=obtenerDptosXsucursal&acitvo="+1+"&idSucursal="+idSucursal,
    async: false,
    dataType: "json",
    success: function(datos) {
             var data ='';
             data +='<optgroup label="Departamentos">';

                $.each(datos, function(i, item) {
                    if(item.activo=='1')
                      data+='<option value='+item.idDpto+'>'+item.descripcion+'</option>';
                  });
              data+='</optgroup>';

          $("#cbDptos").html(data);
          $("#cbDptos").parent().find('div').css('width','100%');
    }
    });
}

function ObtenerUsuarioXSucursal(idSucursal)
{
    $.ajax({
    type: "POST",
    url: "php/DAO/usuarioDAO.php",
    data: "accion=obtenerUsuarios&activo="+1+"&idSucursal="+$('#cbSucursalesFiltro').val()+"&idRol="+$("#idRol").val(),
    async: false,
    dataType: "json",
    success: function(datos) {
             var data ='';
             data +='<optgroup label="Ejecutivos">';

                $.each(datos, function(i, item) {
                      data+='<option value='+item.idUsuario+'>'+item.nombreCompleto+'</option>';
                  });
              data+='</optgroup>';

          $("#cbEjecutivos").html(data);
    }
    }); 
}

function ObtenerUsuarioXSucursalFiltro(idSucursal)
{
		$.ajax({
		type: "POST",
		url: "php/DAO/usuarioDAO.php",
		data: "accion=obtenerUsuarios&activo="+1+"&idSucursal="+idSucursal+"&idRol="+$("#idRol").val(),
		async: false,
		dataType: "json",
		success: function(datos) {
			if(datos != null)
		   {
				 var data ='';
				 data +='<optgroup label="Ejecutivos">';	
				 data+='<option value=null>Todos los ejecutivos</option>';				 
					$.each(datos, function(i, item) {
						  data+='<option value='+item.idUsuario+'>'+item.nombreCompleto+'</option>';
					  });
				  data+='</optgroup>';
			  $("#cbEjecutivosFiltro").html(data);
			  $('#cbEjecutivosFiltro').val('null');
			  $('#cbEjecutivosFiltro').trigger('change');
		   }else
		   {
			  var data ='';
				 data+='<optgroup label="Ejecutivos">';			 
				 data+='<option value=null>Todos los ejecutivos</option>';
				 data+='</optgroup>';
			  $("#cbEjecutivosFiltro").html(data);
			  $('#cbEjecutivosFiltro').val("null");
			  $('#cbEjecutivosFiltro').trigger('change');
		   }
		}
		}); 
}

function ObtenerInformacionFiltro ()
{
	var filtro = {
	    tipoInformacion:$("#cbTipoInformacion").val(),
	   fechaInicio:dtpF.startDate.format('YYYY-MM-DD') ,
       fechaFin: dtpF.endDate.format('YYYY-MM-DD') ,
       idEjecutivo:$("#cbEjecutivosFiltro").val(),
	   idSucursal :$("#cbSucursalesFiltro").val(),
	   idChofer :$("#cbChoferesFiltro").val(),
	   idEstadoServicio :$("#cbEdoServicioFiltro").val(),
	   conCita : $("#cbConCita").val()
    };
	
	$.ajax({
    type: "POST",
    url: "php/DAO/estadisticosDAO.php",
    data: "accion=obtenerInformacion&filtro="+JSON.stringify(filtro),
    async: false,
    dataType: "json",
    success: function(datos) {
		if(datos != null)
		   {
			 LimpiaTabla("tblEstadisticos");
			 pintaTabla(datos);

            /* var data ='';
               $.each(datos, function(i, item) {
                  data+='<tr>';
                  data+='<td>'+(i+1)+'</td>';
                  data+='<td>'+item.nombreCompleto+'</td>';
                  data+='<td>'+item.vehiculoDescripcion+'</td>';
				  data+='<td>'+item.placas+'</td>';
				  data+='<td>'+item.usuario+'</td>';
                  data+='</tr>'
                });
               $("#bodyEstadisticos").html(data);
               InicializaTabla("tblEstadisticos");*/
		  }else
		  {
			LimpiaTabla("tblEstadisticos"); 
			InicializaTabla("tblEstadisticos");
		  }
    }
    });
}

$( document ).ready(function() {

  ObtenerChoferesFiltro();
  $("#cbEdoServicioFiltro").parent().parent().css('display','none');
  $("#cbChoferesFiltro").parent().parent().css('display','none');
  $("#cbConCita").parent().parent().css('display','none');
  
  $('#btnFiltro').click(function(e) {
	ObtenerInformacionFiltro();
  });  
  
$('.select2').on('click', function (evt) {
 $(this).parent().find('.error').css('display','none');
});


$('#cbSucursalesFiltro').on('change', function (evt) {
		ObtenerUsuarioXSucursalFiltro($('#cbSucursalesFiltro').val());

});

$('#cbTipoInformacion').on('change', function (evt) {
		if($('#cbTipoInformacion').val() == 1){
		    $("#cbEdoServicioFiltro").parent().parent().css('display','');
			$("#cbChoferesFiltro").parent().parent().css('display','');
			  $("#cbConCita").parent().parent().css('display','');
		}
		else{
			$("#cbEdoServicioFiltro").parent().parent().css('display','none');
			$("#cbChoferesFiltro").parent().parent().css('display','none');
			$("#cbConCita").parent().parent().css('display','none');
		}

});


InicializaTabla("tblEstadisticos");
obtenerSucursalesFiltro();
var f=new Date();
var fechaHoy=   f.getMonth()+1   + "/" + f.getDate() + "/" + f.getFullYear();

$("#dtpFecha").daterangepicker(
{
	autoUpdateInput: true,
	"startDate": fechaHoy,
    "endDate": fechaHoy,

    "locale": {
        "format": "MM/DD/YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "De",
        "toLabel": "Hasta",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "D",
            "L",
            "M",
            "M",
            "J",
            "V",
            "S"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "Primer Dia": 1
    },

});

	 dtpF = $('#dtpFecha').data('daterangepicker');
	$("#dtpFecha").val(dtpF.startDate.format('MM/DD/YYYY') + ' - ' + dtpF.endDate.format('MM/DD/YYYY'));
});

