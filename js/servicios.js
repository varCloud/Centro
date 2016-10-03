var directionsService = new google.maps.DirectionsService();
var idUsuarioFiltro=0;
var map;
var beachMarker= null;

 function ObtenerDireccion(lat,lng) {
            var latlng = new google.maps.LatLng(lat, lng);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
						
                          $("#destino").val(results[1].formatted_address);
                    }
                }
            });
 }

function obtenerCoordenadasChofer(idChofer)
{

	  $.ajax({
		type: "POST",
		url: "php/DAO/choferesDAO.php",
		data: "accion=obtenerChoferAprobado&idChofer="+idChofer,
		async: false,
		dataType: "json",
		success: function(datos) {
			if(datos != null)
			{
				initMap(datos.latitud , datos.longitud,"mapaUbicacionChofer");
				$('#modalMapaUbicacionChofer').modal({  keyboard: false,})
		        $('#modalMapaUbicacionChofer').modal('show', {backdrop: 'static', keyboard: false});

			}else
				Notificacion("error","Error al obtener la ubicacion actual del chofer espere un momento y vuelva a intentarlo","Mensaje");
		}
		});
}

function Editar(idServicio)
{
    Resetform("restAddCita");
	$("#origen").val($("#direccionMapa").val());
	$("#idServicio").val('null');
	$("#mapAddService").html('');
    $.ajax({
    type: "POST",
    url: "php/DAO/serviciosDAO.php",
    data: "accion=ObtenerUnServicio&idServicio="+idServicio+"&caso=1",
    async: false,
    dataType: "json",
    success: function(datos) {
            $.each(datos, function(i, item) {
                   $('#nombreCompleto').val(item.nombreCompleto);
                   $('#descripcionVehiculo').val(item.vehiculoDescripcion);
				   $('#placas').val(item.placas);
				   if(item.latDest != '' && item.lngDest != '' )
				   {
					   ObtenerDireccion(item.latDest,item.lngDest);
				   }
						$("#latDest").val(item.latDest);
						$("#lngDest").val(item.lngDest);
                });      
		
		  $('#btnActualizar').css('display','inline');
		  $('#btnAsignarChoferSinCita').css('display','none');
          $('#addServicio').modal({  keyboard: false,})
          $('#addServicio').modal('show', {backdrop: 'static', keyboard: false});
		  $("#idServicio").val(idServicio);
    }
    });
}

function muestraDestino(results, status)
{
		if (status == google.maps.GeocoderStatus.OK) {
			if (results[0]) {
				$("#destino").val(results[0].formatted_address);
				 $("#latOr").val(results[1].geometry.location.lat());
				 $("#lnOr").val(results[1].geometry.location.lng());
				google.maps.event.addDomListener(window, 'load', initMap(results[1].geometry.location.lat(),results[1].geometry.location.lng(),"mapAddService"));
				
				$('#addServicio').modal({  keyboard: false,})
				$('#addServicio').modal('show', {backdrop: 'static', keyboard: false});
			}
			else
				Notificacion("error","Ocurrion un error al buscar la direccion,espere un momento y vuelva a intentarlo","Mensaje");
		}else
			Notificacion("error","Ocurrion un error en la red,espere un momento y vuelva a intentarlo","Mensaje");
}

function GuardarServicio()
{
	
	if($("#formAddServicio").valid())
	{
	  //	pedir_chofer(bandera,);
	  //	alert("algoritmo de busqueda para que asigne chofer  agrego registro a la tabla de serviciosincita"+esActualizacion);
	  // 	buscamos idChofer  Vasco de Quiroga, Morelia, México
	  //


	  if($("#idChofer").val() > 0)
	  { 
  	  $("#descripcionVehiculo").val().length === 0 ? ($("#descripcionVehiculo").val("N/A")) : $("#descripcionVehiculo").val();
	  $("#placas").val().length === 0?  ($("#placas").val("N/A")) : $("#placas").val();
		//  alertify.alert($("#idChofer").val());
		$.ajax({
				type: "POST",
				url: "php/DAO/serviciosDAO.php",
				data: "accion=insertaServicio&"+$("#formAddServicio").serialize()+"&idUsuario="+$("#idUsuario").val()+"&idSucursal="+$("#idSucursal").val(),
				async: false,
				dataType: "json",
				success: function(datos) {
							  if(datos.msj=='success')
							  {
								 ObtenerServiciosFiltro();
								 Notificacion('success','Servicio agregado exitosamente','Mensaje');
							  }
							 else
								Notificacion('error','error guardar el servicio','Mensaje');
					$('#addServicio').modal('hide');
							  
				}
		  });
		  
	  }else
	  {
		  alertify.alert("Ocurrio un error al intentar asignar chofer espere un momento y vuelva a intentarlo");
	  }
	 
	}
}

function asignarChofer()
{
	//MuestraLoader("Buscando chofer... Espere un momento...");
	
	if($("#formAddServicio").valid())
	{
		var latitudeOr;
		var longitudeOR;
		var latitudeDest;
		var longitudeDest;
		geocoder.geocode({ 'address': origen }, function (results, status) {

			if (status == google.maps.GeocoderStatus.OK) {
				 latitudeOr= results[0].geometry.location.lat();
				 longitudeOR = results[0].geometry.location.lng();
				 $("#latOr").val(latitudeOr);
				 $("#lnOr").val(longitudeOR);
				 /*
				 alert("Origen "+origen);
				 alert("Latorigen"+$("#latOr").val());
				 alert("Lngorigen"+$("#lnOr").val());
				 */
					geocoder.geocode({ 'address': destino }, function (results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						 latitudeDest= results[0].geometry.location.lat();
						 longitudeDest = results[0].geometry.location.lng();
						 $("#latDest").val(latitudeDest);
						 $("#lngDest").val(longitudeDest);
				/*		
				 alert("destino "+destino);
				 alert("LatDest"+$("#latDest").val());
				 alert("LngDest"+$("#lngDest").val());
				 */
						var bandera =  $("#idServicio").val() == 'null' ? 0 :1; 
						pedir_chofer(bandera,$("#idServicio").val(),$("#nombreCompleto").val(),$("#latOr").val(),$("#lnOr").val(),$("#latDest").val(),$("#lngDest").val());
		
					}
				});
			}
		});
	}
}

function ActualizarTabActual()
{
   	var a = $('.nav-tabs .active').find('a').attr('tipos');
   switch(a)
	   {
		   case '1':
		         ObtenerServiciosFiltro()
		   break;
		   case '2':
				ObtenerServiciosActivosFiltro();	
		   break;
		   	case '3':
				ObtenerServiciosFinalizadosFiltro();	
		   break;
	   }
}

function obtenerRuta()
{
	origen = $("#origen").val();
    destino = $("#destino").val();
    
   /* 
    geocoder.geocode({ 'address': origen }, function (results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						 latitudeDest= results[0].geometry.location.lat();
						 longitudeDest = results[0].geometry.location.lng();
						 $("#latDest").val(latitudeDest);
						 $("#lngDest").val(longitudeDest);
				 alert(results[1].geometry.location.lat());
				 alert(results[2].geometry.location.lng());		
				 alert("destino "+destino);
				 alert("LatDest"+$("#latDest").val());
				 alert("LngDest"+$("#lngDest").val());
				 
		
					}
				});
    
    
    
    alert("origen"+origen);
    alert("destino"+destino);
    */

	map = new google.maps.Map(document.getElementById('mapAddService'), OpcionesDelMapa(20.6737884,-103.3704326,13));
    directionsDisplay.setMap(map);
    var request = {
        origin: origen,
        destination: destino,
        travelMode: google.maps.TravelMode.DRIVING
    };
	
    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
               directionsDisplay.setDirections(response);
        }
    });
 
 
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix({
        origins: [origen],
        destinations: [destino],
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC,
        avoidHighways: false,
        avoidTolls: false
    }, function (response, status) {
        if (status == google.maps.DistanceMatrixStatus.OK) {
			if( typeof response.rows[0].elements[0].distance !== "undefined")
			{
				$("#distancia").val(response.rows[0].elements[0].distance.text);
				$("#duracion").val(duration = response.rows[0].elements[0].duration.text);
				
			}else
			{
				$("#destino").val('');
				$("#mapAddService").html('');
				Notificacion("error","Porfavor especifique una direccion valida","Mensaje");
			}
        } else {
             alertify.alert("Ocurrio un error con las direcciones pruebe con un sitio alternativo");
        }
    });
}

function initMap(lat,lng,mapa) {
			var myLatLng = new google.maps.LatLng(lat, lng);
            map = new google.maps.Map(document.getElementById(mapa), OpcionesDelMapa(lat,lng));
            var image = 'Imgs/markerChofer.png';
            beachMarker = new google.maps.Marker({
                position: myLatLng,
				icon:image
            });
			beachMarker.setMap(map);
}
	
function OpcionesDelMapa(lat,lng)
{
		    var myLatLng = new google.maps.LatLng(lat, lng);
            var mapOptions = {
                zoom: 15,
                center: myLatLng,

                // Extra options
                scrollwheel: false,
                mapTypeControl: false,
                panControl: false,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.SMALL,
                    position: google.maps.ControlPosition.LEFT_BOTTOM
                }
            };
			return mapOptions;
	}

function ObtenerServiciosActivosFiltro()
{
	var filtro = {
       fechaInicio: $('#fechaInicio').data('datepicker').getFormattedDate('yyyy-mm-dd'),
       fechaFin: $('#fechaFin').val(),
       idRol: $("#idRol").val(),
       idEjecutivo: ($("#cbEjecutivosFiltro").length > 0 ? $("#cbEjecutivosFiltro").val() : 'null'),
	   idSucursal : $("#idSucursal").val() == 0 ? 'null' : $("#idSucursal").val() ,
	   idUsuario :  idUsuarioFiltro == 0  ? 'null' : idUsuarioFiltro ,
    };
	var disabled = '';
	//SI SE QUIERE DESABILITAR EL BOTON  DE VER EL CHOFER  A LA VARIABLE DISABLED SE LE ASIGNA EL VALOR
		if($("#idRol").val() == '0' || $("#idRol").val() =='1')
			disabled ='';
	
	$.ajax({
    type: "POST",
    url: "php/DAO/serviciosDAO.php",
    data: "accion=obtenerServiciosActivos&filtro="+JSON.stringify(filtro),
    async: false,
    dataType: "json",
    success: function(datos) {
		if(datos != null)
		   {
             LimpiaTabla("tblServiciosActivos");
             var data ='';
               $.each(datos, function(i, item) {
                  data+='<tr>';
                  data+='<td>'+(i+1)+'</td>';
                  data+='<td>'+item.nombreCompleto+'</td>';
                  data+='<td>'+item.vehiculoDescripcion+'</td>';
				  data+='<td>'+item.placas+'</td>';
                  data+='<td><div align="center">'+(item.origenAlta=="1" ? "<div class='label label-success'>App</div>" : "<div class='label label-info'>Administrador</div>")+'</div></td>';
				  data+='<td>'+item.usuario+'</td>';
                  data+='<td><div align="center">';//<a href="javascript:Editar('+item.idServicio+');" '+disabled+'><i class="fa fa-edit right" style="font-size: 25px;"></i></a>';
				  data+='<button '+disabled+' class="btn btn-success '+disabled+' " onclick="obtenerCoordenadasChofer('+item.idChofer+')"  type="button" id="btnEditServicio">';
				  data+='  <i class="fa fa-map-marker "  style="font-size: 25px;"></i>';
				  data+='</button>'	;
                  data+='</div></td>';
                  data+='</tr>'
                });
               $("#bodyServiciosActivos").html(data);
               InicializaTabla("tblServiciosActivos");
		  }else
		  {
			   LimpiaTabla("tblServiciosActivos");
			   InicializaTabla("tblServiciosActivos");
		  }
    }
    });
}	
	
function ObtenerServiciosFinalizadosFiltro()
{
	var filtro = {
       fechaInicio: $('#fechaInicio').data('datepicker').getFormattedDate('yyyy-mm-dd'),
       fechaFin: $('#fechaFin').val(),
       idRol: $("#idRol").val(),
       idEjecutivo: ($("#cbEjecutivosFiltro").length > 0 ? $("#cbEjecutivosFiltro").val() : 'null'),
	   idSucursal : $("#idSucursal").val() == 0 ? 'null' : $("#idSucursal").val() ,
	   idUsuario :  idUsuarioFiltro == 0  ? 'null' : idUsuarioFiltro ,
    };
	var disabled = '';
		if($("#idRol").val() == '0' || $("#idRol").val() =='1')
			disabled ='disabled';
	
	$.ajax({
    type: "POST",
    url: "php/DAO/serviciosDAO.php",
    data: "accion=obtenerServiciosFinalizados&filtro="+JSON.stringify(filtro),
    async: false,
    dataType: "json",
    success: function(datos) {
		if(datos != null)
		   {
             LimpiaTabla("tblServiciosFinalizados");
             var data ='';
               $.each(datos, function(i, item) {
                  data+='<tr>';
                  data+='<td>'+(i+1)+'</td>';
                  data+='<td>'+item.nombreCompleto+'</td>';
                  data+='<td>'+item.vehiculoDescripcion+'</td>';
				  data+='<td>'+item.placas+'</td>';
                  data+='<td><div align="center">'+(item.origenAlta=="1" ? "<div class='label label-success'>App</div>" : "<div class='label label-info'>Administrador</div>")+'</div></td>';
				  data+='<td>'+item.origen+'</td>';
				  data+='<td>'+item.destino+'</td>';
				  data+='<td>'+item.distancia+'</td>';
				  data+='<td>'+item.usuario+'</td>';
                 // data+='<td><div align="center">';//<a href="javascript:Editar('+item.idServicio+');" '+disabled+'><i class="fa fa-edit right" style="font-size: 25px;"></i></a>';
				 // data+='<button '+disabled+' class="btn btn-success '+disabled+' " onclick="obtenerCoordenadasChofer('+item.idChofer+')"  type="button" id="btnEditServicio">';
				 // data+='  <i class="fa fa-map-marker "  style="font-size: 25px;"></i>';
				//  data+='</button>'	;
                //  data+='</div></td>';
                  data+='</td></tr>'
                });
               $("#bodyServiciosFinalizados").html(data);
               InicializaTabla("tblServiciosFinalizados");
		  }else
		  {
			   LimpiaTabla("tblServiciosFinalizados");
			   InicializaTabla("tblServiciosFinalizados");
		  }
    }
    });
}
	
function ObtenerServiciosFiltro()
{
	var filtro = {
       fechaInicio: $('#fechaInicio').data('datepicker').getFormattedDate('yyyy-mm-dd'),
       fechaFin: $('#fechaFin').val(),
       idRol: $("#idRol").val(),
	   idSucursal : $("#idSucursal").val() ,
	   idUsuario :  idUsuarioFiltro == 0  ? 'null' : idUsuarioFiltro ,
    };
	var disabled = '';
		if($("#idRol").val() == '0' || $("#idRol").val() =='1')
			disabled ='disabled';
	
	$.ajax({
    type: "POST",
    url: "php/DAO/serviciosDAO.php",
    data: "accion=obtenerServicios&filtro="+JSON.stringify(filtro),
    async: false,
    dataType: "json",
    success: function(datos) {
		if(datos != null)
		   {
             LimpiaTabla("tblServiciosConCita");
             var data ='';
               $.each(datos, function(i, item) {
                  data+='<tr>';
                  data+='<td>'+(i+1)+'</td>';
                  data+='<td>'+item.nombreCompleto+'</td>';
                  data+='<td>'+item.vehiculoDescripcion+'</td>';
				  data+='<td>'+item.placas+'</td>';
                  data+='<td><div align="center">'+(item.origen=="1" ? "<div class='label label-success'>App</div>" : "<div class='label label-info'>Administrador</div>")+'</div></td>';
				  //data+='<td>'+item.fechaCita+'</td>';
                  data+='<td>'+item.nombreEje+'</td>';
				  data+='<td><div align="center">';//<a href="javascript:Editar('+item.idServicio+');" '+disabled+'><i class="fa fa-edit right" style="font-size: 25px;"></i></a>';
				  data+='<button '+disabled+' class="btn btn-success '+disabled+' " onclick="Editar('+item.idServicio+')"  type="button" id="btnEditServicio">';
				  data+='<!-- <i class="fa fa-edit "  style="font-size: 25px;"></i>--> Asignar chofer';
				  data+='</button>'	;
                  data+='</div></td>';
                  data+='</tr>'
                });
               $("#bodyServiciosConCita").html(data);
               InicializaTabla("tblServiciosConCita");
		  }else
		  {
			   LimpiaTabla("tblServiciosConCita");
			   InicializaTabla("tblServiciosConCita");
		  }
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
				 //data +='<option value="">Supervisor</option>';				 
					$.each(datos, function(i, item) {
						  data+='<option value='+item.idUsuario+'>'+item.nombreCompleto+'</option>';
					  });
				  data+='</optgroup>';
			  $("#cbEjecutivosFiltro").html(data);
			  $('#cbEjecutivosFiltro').val('null');
			  $('#cbEjecutivosFiltro').trigger('change');
		}
		}); 
	}else if($("#idRol").val() == "3") // SI EL ROL ES  EJECUTIVO SE LE ASIGNA PARA QUE FILTRE POR ESE USUARIO
	{
		 idUsuarioFiltro = $('#idUsuario').val()
	}
}

function obtenerSucursalesFiltro()
{
	if($("#idRol").val() == "1" || $("#idRol").val() == "0")
	{
	  $.ajax({
		type: "POST",
		url: "php/DAO/sucuDAO.php",
		data: "accion=obtenerSucursales&idSucursal=null&acitvo="+1,
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
			  $('#cbSucursalesFiltro').val(($('#idSucursal').val() === "0" ? "null" : $('#idSucursal').val()));
			  $('#cbSucursalesFiltro').trigger('change');
		}
		});
	}
}

$( document ).ready(function() {
	google.maps.event.addDomListener(window, 'load', function () {
			 new google.maps.places.SearchBox(document.getElementById('origen'));
             new google.maps.places.SearchBox(document.getElementById('destino'));
			directionsDisplay = new google.maps.DirectionsRenderer({ 'draggable': true });
		});

	 $("#fechaInicio").prop('disabled', true); // SE DESABILITA EL DATEPICKER POR QUE SOLO SE PUEDEN
	 // VER SERVICIOS AL DIA 
	
	$('.nav-tabs a').click(function(){
	   switch($(this).attr('tipoS'))
	   {
		   case '1':
		    $("#fechaInicio").prop('disabled', false);
		   	$('#cbEjecutivosFiltro').val('null');
		    $('#cbEjecutivosFiltro').trigger('change');
		   ObtenerServiciosFiltro()
           $("#fechaFin").val($("#fechaInicio").data('datepicker').getFormattedDate('yyyy-mm-dd'));	
		   $("#fechaInicio").css('display','');
		  
		   break;
		   case '2':
	
				$("#fechaInicio").prop('disabled', true);
				$("#fechaInicio").datepicker("update", new Date());
				$("#fechaFin").val($("#fechaInicio").data('datepicker').getFormattedDate('yyyy-mm-dd'));	
				//$("#fechaInicio").css('display','none');
				ObtenerServiciosActivosFiltro();	
		   break;
		   case '3':
	
				$("#fechaInicio").prop('disabled', true);
				$("#fechaInicio").datepicker("update", new Date());
				$("#fechaFin").val($("#fechaInicio").data('datepicker').getFormattedDate('yyyy-mm-dd'));	
				//$("#fechaInicio").css('display','none');
				ObtenerServiciosFinalizadosFiltro();	
		   break;
		   
		   
		   
	   }
	});
	
	//ActualizarTabActual();

	$('#aprobado').on('switch-change', function (e, data) {     
		  Notificacion((data.value == true ? 'success' : 'warning'),'usuario '+(data.value == true ? 'Activado' : 'Descativado'),'Mensaje');
		   // alert(data.value);
		});

	$('#btnRuta').click(function(e) {
		  obtenerRuta();
	  });
	  
	$('#btnAsignarChoferSinCita').click(function(e) {
		
		  asignarChofer();
	  });
	  
	  $('#btnActualizar').click(function(e) {
		  asignarChofer();
	  });
	
	$('#cbEjecutivosFiltro').on('change', function (evt) {
       //AQUI ES PARA ASIGNAR EL EJECUTIVO QUE  SE DESEA CONSULTAR SOLO SIRVE
	   //PARA LA PARTE DE CUANDO EL SUPERVISOR QUIERE VER LOS SERVICIOS
	   //$("#idUsuario").val($('#cbEjecutivosFiltro').val());
	   //YA QUE COMO EL NO TRAE  ID  DE USUARIO VALIDO QUE HAYA GENERADO SERVICIOS
	   idUsuarioFiltro = $('#cbEjecutivosFiltro').val()
	});

	$('#cbSucursalesFiltro').on('change', function (evt) {
	   $('#idSucursal').val($('#cbSucursalesFiltro').val());
	});
	
	
	$('#btnAddServicio').click(function(e) {
		  Resetform("restAddCita");
		  $("#origen").val($("#direccionMapa").val());
		  $("#idServicio").val('null');
		  $('#btnActualizar').css('display','none');
		  $('#btnAsignarChoferSinCita').css('display','inline');
		  $('#addServicio').modal({  keyboard: false,})
		  $('#addServicio').modal('show', {backdrop: 'static', keyboard: false});

	  });
	 
	$('#addServicio').on('shown.bs.modal', function () {
				google.maps.event.trigger(map, "resize");
			
	});
	
	$('#modalMapaUbicacionChofer').on('shown.bs.modal', function () {
		google.maps.event.trigger(map, "resize");
		map.setCenter(beachMarker.getPosition());
			
	});
	
	
			
	$('#fechaInicio').datepicker().on('changeDate', function (e) {
        //$('#fechaFiltro').datepicker('hide');
		$('#fechaFin').val($(this).data('datepicker').getFormattedDate('yyyy-mm-dd'));
        //(this).data('datepicker').getFormattedDate('yyyy-mm-dd'));
		
	});
	
	$('#btnFiltro').click(function(e) {
		  //ObtenerServiciosFiltro();
		  ActualizarTabActual();
	  }); 
	  
	$("#fechaInicio").datepicker("update", new Date());
	$("#fechaFin").val($("#fechaInicio").data('datepicker').getFormattedDate('yyyy-mm-dd'));
	
	ObtenerUsuarioXSucursalFiltro($("#idSucursal").val())
	obtenerSucursalesFiltro();
	InicializaTabla("tblServiciosConCita");
	InicializaTabla("tblServicioTerminados");
	ObtenerServiciosFiltro();

});

