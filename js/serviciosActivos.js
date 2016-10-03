var directionsService = new google.maps.DirectionsService();
var idUsuarioFiltro=0;
var map;




function ObtenerServiciosActivosFiltro()
{
	var filtro = {
       fechaInicio: $('#fechaInicio').data('datepicker').getFormattedDate('yyyy-mm-dd'),
       fechaFin: $('#fechaFin').val(),
       idRol: $("#idRol").val(),
       idEjecutivo: 'null',
	   idSucursal : $("#idSucursal").val() == 0 ? 'null' : $("#idSucursal").val() ,
	   idUsuario :  'null' ,
    };
	var disabled = '';
		if($("#idRol").val() == '0' || $("#idRol").val() =='1')
			disabled ='disabled';
	MuestraLoader("Cargando Servicios Activos espere por favor...");
	$.ajax({
    type: "POST",
    url: "php/DAO/serviciosDAO.php",
    data: "accion=obtenerServiciosActivosDisntancias&filtro="+JSON.stringify(filtro),
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
                  //data+='<td><div align="center">'+(item.origenAlta=="1" ? "<div class='label label-success'>App</div>" : "<div class='label label-info'>Administrador</div>")+'</div></td>';
				  data+='<td>'+item.usuario+'</td>';
				  data+='<td>'+item.distancia+'</td>';
                  //data+='<td><div align="center">';//<a href="javascript:Editar('+item.idServicio+');" '+disabled+'><i class="fa fa-edit right" style="font-size: 25px;"></i></a>';
				  //data+='<button '+disabled+' class="btn btn-success '+disabled+' " onclick="obtenerCoordenadasChofer('+item.idChofer+')"  type="button" id="btnEditServicio">';
				  //data+='  <i class="fa fa-map-marker "  style="font-size: 25px;"></i>';
				  //data+='</button>'	;
                  //data+='</div></td>';
                  data+='</tr>'
                });
               $("#bodyServiciosActivos").html(data);
               InicializaTabla("tblServiciosActivos");
		  }else
		  {
			   LimpiaTabla("tblServiciosActivos");
			   InicializaTabla("tblServiciosActivos");
		  }
		  OcultarLoader();
    }
    });
	OcultarLoader();
}	

function Update()
{
		setInterval(function(){
		ObtenerServiciosActivosFiltro();
	}, 5000 * 60);
}

$( document ).ready(function() {
	 
	 $("#fechaInicio").prop('disabled', true); // SE DESABILITA EL DATEPICKER POR QUE SOLO SE PUEDEN
	 // VER SERVICIOS AL DIA 
	$("#fechaInicio").datepicker("update", new Date());
	$("#fechaFin").val($("#fechaInicio").data('datepicker').getFormattedDate('yyyy-mm-dd'));
	InicializaTabla("tblServiciosActivos");
	ObtenerServiciosActivosFiltro();
	Update();
	


});

