var idClienteActual
function Eliminar(idCita,servicioTaxi)
{
  var activo =0;
    resetAlert();
    alertify.confirm("Estas seguro que deseas eliminar la cita "+(servicioTaxi =="1" ? " esta cita requiere servicio de taxi " :"")+" ?", function (e) {
        if (e) {
            $.ajax({
                    type: "POST",
                    url: "php/DAO/citasDAO.php",
                    data: "accion=eliminarCita&idCita="+idCita,
                    async: false,
                    dataType: "json",
                    success: function(datos) {
                            if(datos.msj=='success')
                            {
                               ObtenerCitasFiltro();
                               Notificacion('success','Cita eliminada exitosamente','Mensaje');
                            }
                           else
                              Notificacion('error','Error al intentar eliminar la cita','Mensaje');
                        } 
                    });
        }
    });
     
}

function GuardarCita(esActualizacion)
{
  if($("#formCitas").valid())
  {
    $.ajax({
        type: "POST",
        url: "php/DAO/citasDAO.php",
        data: "accion=guardarCita&"+$("#formCitas").serialize()+"&idSucursal="+$('#idSucursal').val()+"&requiereServicio="+$('#requiereServicio').bootstrapSwitch('status')+"&esActualizacion="+esActualizacion+"&idDpto="+$('#cbDptos').val(),
        async: false,
        dataType: "json",
        success: function(datos) {
                      if(datos.msj=='success')
                      {
                        ObtenerCitasFiltro();
                        Notificacion('success','Cita Guardada exitosamente','Mensaje');
                      }
                     else
                        Notificacion('error','error al guardar la cita','Mensaje');
                  $('#addCita').modal('hide');
         }
    });
  }
    
}

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

function ActualizarTabActual()
{
    if($('.nav-tabs').find('.active').attr('aprobado')==0)
        ObetnerAllChoferes(0,"tblChoferesSinAprobar");
     else
        ObetnerAllChoferes(1,"tblChoferesAprobados");

}

function ObetnerAllClientes()
{
   $.ajax({
    type: "POST",
    url: "php/DAO/clienteDAO.php",
    data: "accion=obtenerClientes&acitvo="+1,
    async: false,
    dataType: "json",
    success: function(datos) {
		if(datos != null)
		   {
             var data ='<option value=""></option>';
             data +='<optgroup label="Clientes">';
                $.each(datos, function(i, item) {
                    data+='<option value='+item.idCliente+'>'+item.nombreCompleto+'</option>';
                  });
              data+='</optgroup>';

			  $("#cbClientes").html(data);
			  $("#cbClientes").parent().find('div').css('width','100%');
		   }
    }
    });
}

function ObtenerVehiculos(idCliente)
{
  $.ajax({
    type: "POST",
    url: "php/DAO/clienteDAO.php",
    data: "accion=obtenerUnCliente&idCliente="+idCliente,
    async: false,
    dataType: "json",
    success: function(datos) {
      LimpiaTabla("tblVehiculosActivos");
        var data ='';
          if(datos.estatus == 1){
             data ='<optgroup label="Vehiculos"></optgroup>';
            $.each(datos.Vehiculo, function(i, item) {
                  data+='<option value='+item.idVehiculo+'>'+item.marca+' '+item.modelo+' '+item.ano+'</option>';
                });
            $("#cbVehiculos").html(data);
            
          }else
            Notificacion('info',datos.msj,'Mensaje');
      }
    });
}

function obtenerSucursales()
{
  $.ajax({
    type: "POST",
    url: "php/DAO/sucuDAO.php",
    data: "accion=obtenerSucursales&acitvo="+1+"&idSucursal="+$("#idSucursal").val(),
    async: false,
    dataType: "json",
    success: function(datos) {
			if(datos != null)
		   {
				 var data ='';
				 var data ='<option value=""></option>';
				 data +='<optgroup label="Sucursales">';

					$.each(datos, function(i, item) {
						data+='<option value='+item.idSucursal+'>'+item.descripcion+'</option>';
					  });
				  data+='</optgroup>';

			  $("#cbSucursales").html(data);
			  $("#cbSucursales").parent().find('div').css('width','100%');
		   }
    }
    });
}

function obtenerSucursalesFiltro()
{
	if($("#idRol").val() == "1" || $("#idRol").val() == "0")
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
				 data +='<option value="null">Todas las Agencias</option>';
					$.each(datos, function(i, item) {
						data+='<option value='+item.idSucursal+'>'+item.descripcion+'</option>';
					  });
				  data+='</optgroup>';

			  $("#cbSucursalesFiltro").html(data);
			  $("#cbSucursalesFiltro").parent().find('div').css('width','100%');
			  $('#cbSucursalesFiltro').val( ($('#idSucursal').val() === "0" ? "null" : $('#idSucursal').val()) );
			  $('#cbSucursalesFiltro').trigger('change');
		}
		});
	}
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

function ObtenerHorasDisponibles(idDia)
{
  $("#cbHoras").html('');
  $.ajax({
    type: "POST",
    url: "php/DAO/citasDAO.php",
    data: "accion=obtenerHorasDisponibles&idSucursal="+$('#cbSucursales').val()+"&idDia="+idDia+"&fecha="+$('#diaCita').val()+"&idDpto="+$("#cbDptos").val(),
    async: false,
    dataType: "json",
    success: function(datos) {
			if(datos != null)
		   {
				 var data ='';
				 data +='<optgroup label="Horario Disponible">';
					$.each(datos, function(i, item) {
						  data+='<option value='+item.horas+'>'+item.horas+'</option>';
					  });
				  data+='</optgroup>';

			  $("#cbHoras").html(data);
		   }else
			   Notificacion('info','la sucursal tiene la agenda llena para ese dia','Mensaje');
    }
    });  
}

function guardarCliente()
{
  if($("#formCliente").valid())
  {
    $.ajax({
        type: "POST",
        url: "php/DAO/clienteDAO.php",
        data: "accion=guardarCliente&"+$("#formCliente").serialize(),
        async: false,
        dataType: "json",
        success: function(datos) {
                      if(datos.msj=='success')
                      {
                         ObetnerAllClientes();
                         Notificacion('success','Cliente guardado exitosamente','Mensaje');
                      }
                     else
                        Notificacion('error','error al guardar el Cliente','Mensaje');
                      
                      $('#addCliente').modal('hide');
         }
    });
  }  
}

function ObtenerUsuarioXSucursal(idSucursal)
{
    $.ajax({
    type: "POST",
    url: "php/DAO/usuarioDAO.php",
    data: "accion=obtenerUsuarios&activo="+1+"&idSucursal="+idSucursal+"&idRol="+$("#idRol").val(),
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
	if($("#idRol").val() == "2")
	{
		$.ajax({
		type: "POST",
		url: "php/DAO/usuarioDAO.php",
		data: "accion=obtenerUsuarios&activo="+1+"&idSucursal="+idSucursal+"&idRol="+$("#idRol").val(),
		async: false,
		dataType: "json",
		success: function(datos) {
				 var data ='';
				 data +='<optgroup label="Ejecutivos">';
				 data +='<option value="null">Todos las citas hasta el momento</option>';
				 //data +='<option value="-2">Supervisor</option>';				 
					$.each(datos, function(i, item) {
						  data+='<option value='+item.idUsuario+'>'+item.nombreCompleto+'</option>';
					  });
				  data+='</optgroup>';
			  $("#cbEjecutivosFiltro").html(data);
			  $('#cbEjecutivosFiltro').val("null");
			  $('#cbEjecutivosFiltro').trigger('change');
		}
		}); 
	}
}

function ObtenerCitasFiltro ()
{
	var filtro = {
	   fechaInicio: $('#fechaInicio').data('datepicker').getFormattedDate('yyyy-mm-dd'),
       fechaFin: $('#fechaFin').val(),
       idRol: $("#idRol").val(),
	   //CON EL LENGTH  > 0 SE VALIDA SI EXISTE EL ELEMENTO cbEjecutivosFiltro si existen 
	   //mandamos el id del ejecutivo seleccionado si no existe validamos si el rol es ejecutivo
	   //mandamos el id de lsa sesion si no es ejecutivo mandamos un null
	   //por que cuando es supervisor u superusuario no tiene un id de usuario valido  que hayan generado citas
       idUsuario: ($("#cbEjecutivosFiltro").length > 0 ? $("#cbEjecutivosFiltro").val() : ( $("#idRol").val() == "3" ? $("#idUsuario").val() : 'null') ),
	   idSucursal :$("#idSucursal").val(),

    };
	
	$.ajax({
    type: "POST",
    url: "php/DAO/citasDAO.php",
    data: "accion=obtenerCitas&filtro="+JSON.stringify(filtro),
    async: false,
    dataType: "json",
    success: function(datos) {
		if(datos != null)
		   {
             LimpiaTabla("tblCitas");
             var data ='';
               $.each(datos, function(i, item) {
                  data+='<tr>';
                  data+='<td>'+(i+1)+'</td>';
                  data+='<td>'+item.nombreCompleto+'</td>';
                  data+='<td>'+item.vehiculo+'</td>';
				  data+='<td>'+item.placas+'</td>';
                  data+='<td>'+item.fechaCita+'</td>';
                  data+='<td><div align="center">'+(item.origen=="1" ? "<div class='label label-success'>App</div>" : "<div class='label label-info'>Administrativo</div>")+'</div></td>';
                   data+='<td>'+item.nombreEje+'</td>';
				  data+='<td><div align="center">  ';
                  data+='&nbsp;&nbsp;&nbsp;<a href="javascript:Eliminar('+item.idCita+','+item.servicioTaxi+');"><i class="fa fa-trash-o right" style="font-size: 25px;"></i></a>';
                  data+='</div></td>';
                  data+='</tr>'
                });
               $("#bodyCitas").html(data);
               InicializaTabla("tblCitas");
		  }else
		  {
			  LimpiaTabla("tblCitas"); 
			InicializaTabla("tblCitas");
		  }
    }
    });
}

$( document ).ready(function() {

 initFormulario();
// $("#fechaCitasF").datepicker("setDate", new Date());

 $('#btnAddCita').click(function(e) {
	 
      Resetform("resetFrmCita");
	  $('#cbSucursales').val($('#idSucursal').val());
	  $('#cbSucursales').trigger('change');
	  $('#cbSucursales').attr('disabled','');
	  $('#cbDptos').val(1);
	  $('#cbDptos').trigger('change');
	  $('#cbDptos').attr('disabled','');
      $('#addCita').modal({  keyboard: false,})
      $('#addCita').modal('show', {backdrop: 'static', keyboard: false});

  });

 $('#btnAddCliente').click(function(e) {
      Resetform("resetFrmCliente");
      $('#addCliente').modal({  keyboard: false,})
      $('#addCliente').modal('show', {backdrop: 'static', keyboard: false});

  });
 
  $('#requiereServicio').on('switch-change', function (e, data) {
    Notificacion((data.value == true ? 'success' : 'warning'),'Cita '+(data.value == true ? 'con Servicio de taxi' : 'Sin Servicio de taxi'),'Mensaje');

  });

  $('#btnGuardarCita').click(function(e) {
      GuardarCita(false);
  });

  $('#btnGuardarCliente').click(function(e) {
      guardarCliente();
  });
  
  $('#btnFiltro').click(function(e) {
    //var drp = $('#fechaCitasF').data('daterangepicker');
	ObtenerCitasFiltro();
  });  
  
$('.select2').on('click', function (evt) {
 $(this).parent().find('.error').css('display','none');
});

$('#cbClientes').on('change', function (evt) {
    ObtenerVehiculos($('#cbClientes').val());
});

$('#cbSucursales').on('change', function (evt) {
    ObtenerDptosXSucursal($('#cbSucursales').val());
    ObtenerUsuarioXSucursal($('#cbSucursales').val());
});

$('#cbSucursalesFiltro').on('change', function (evt) {
    $("#idSucursal").val($('#cbSucursalesFiltro').val());

});

$('#diaCita').keypress(function(e) {
    if(e.which == 13) {
        if($(this).val() !== '')
        {

        }
    }
});

$('#diaCita').datepicker().on('changeDate', function (e) {
    $('#diaCita').datepicker('hide');
    Notificacion('info',"buscando horas disponibles ...","Mensaje");
    var f=new Date($(this).val());
    ObtenerHorasDisponibles(diasNumero[f.getDay()]);
});


$('#fechaInicio').datepicker().on('changeDate', function (e) {
	
	$("#fechaFin").val($("#fechaInicio").data('datepicker').getFormattedDate('yyyy-mm-dd'));

});

InicializaTabla("tblCitas");
//ObetnerAllCitas();
ObetnerAllClientes();
obtenerSucursales();
ObtenerUsuarioXSucursalFiltro($("#idSucursal").val())
obtenerSucursalesFiltro();


var f=new Date();
var fechaHoy=   f.getMonth()+1   + "/" + f.getDate() + "/" + f.getFullYear();
//alert(fechaHoy);
//alert(f);
$("#fechaCitasF").daterangepicker(
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
	$("#fechaInicio").datepicker("update", new Date());
	$("#fechaFin").val($("#fechaInicio").data('datepicker').getFormattedDate('yyyy-mm-dd'));
	ObtenerCitasFiltro();
	//var drp = $('#fechaCitasF').data('daterangepicker');
	//ObtenerCitasFiltro(drp.startDate.format('YYYY-MM-DD'),drp.endDate.format('YYYY-MM-DD'));
	//$("#fechaCitasF").val(drp.startDate.format('MM/DD/YYYY') + ' - ' + drp.endDate.format('MM/DD/YYYY'));
});

