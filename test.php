
<!--

<button type="button" onclick='pedir_chofer( "1", "10", "", "19.7207997", "-101.1908196", "20.694731", "-103.418082" )' id="boton">Buscar Chofer</button>

<div id="div_cargando" align="center" style="margin-top: 10px; display: none;" >
	<img src="assets/images/cargando.gif" height="32" width="32"></br></br>
		
</div>
-->
<script type="text/javascript">

	function pedir_chofer( banderaServicio, idServicio, nombreCliente, latitudOrigen, longitudOrigen, latitudDestino, longitudDestino )// banderaServicio = 0 sin cita y banderaServicio = 1 con cita
	{
		$( "#boton" ).prop( "disabled", true );
		MuestraLoader("Buscando chofer... Espere un momento porfavor...");
		$.ajax({
			 url: "test_acciones.php",
			 data: "banderaServicio="+banderaServicio+"&idServicio="+idServicio+"&nombreCliente="+nombreCliente+"&latitudOrigen="+latitudOrigen+"&longitudOrigen="+longitudOrigen+"&latitudDestino="+latitudDestino+"&longitudDestino="+longitudDestino+"&intento=1" , 
			 async: true,
			 type: "POST",
			 contentType: "application/x-www-form-urlencoded",
			 dataType: "json",
			 global: true,
			 ifModified: false,
			 processData: true,
			 success: function(data)
			 {
			 	if( data.respuesta == "buscando" )
			 	{
				   setTimeout( function() { pedir_chofer2( banderaServicio, idServicio , nombreCliente, latitudOrigen, longitudOrigen, latitudDestino, longitudDestino, data.idChofer ) }, 15000);
			 	}else
			 	{
				 	$( "#boton" ).prop( "disabled", false );
		 			//$("#div_cargando").hide();
					OcultarLoader();
		 			 alertify.alert("No existen choferes disponibles. Intente mas tarde");		 	
			 	}
			
			 },error: function () {
			 
				$( "#boton" ).prop( "disabled", false );
			 	OcultarLoader();//$("#div_cargando").hide();
	 			 alertify.alert("Ocurrio un problema. Intente mas tarde.");
			},
			 timeout: 6000	 
		});	
	}
	
	function pedir_chofer2( banderaServicio, idServicio, nombreCliente, latitudOrigen, longitudOrigen, latitudDestino, longitudDestino, idChofer )
	{		
		$.ajax({
			 url: "test_acciones.php",
			 data: "banderaServicio="+banderaServicio +"&idServicio="+idServicio+"&nombreCliente="+nombreCliente+"&latitudOrigen="+latitudOrigen+"&longitudOrigen="+longitudOrigen+"&latitudDestino="+latitudDestino+"&longitudDestino="+longitudDestino+"&intento=2&idChofer="+idChofer , 
			 async: true,
			 type: "POST",
			 contentType: "application/x-www-form-urlencoded",
			 dataType: "json",
			 global: true,
			 ifModified: false,
			 processData: true,
			 success: function(data)
			 {
			 	if( data.respuesta == "buscando" )
			 	{
				 	setTimeout( function() { pedir_chofer3( banderaServicio, idServicio, nombreCliente, latitudOrigen, longitudOrigen, latitudDestino, longitudDestino, data.idChofer ) } , 15000);
			 	}else
			 	{
			 		if( data.respuesta == "asignado" )
			 		{
				 		$( "#boton" ).prop( "disabled", false );
			 			OcultarLoader();//$("#div_cargando").hide();
			 			//alert("idChofer asignado: "+data.idChofer);
						$("#idChofer").val(data.idChofer);
						GuardarServicio();
			 		}else
			 		{
				 		$( "#boton" ).prop( "disabled", false );
			 			OcultarLoader();//$("#div_cargando").hide();
			 			 alertify.alert("No existen choferes disponibles. Intente mas tarde");
			 		}
			 	}
			
			 },error: function () {
			 
				$( "#boton" ).prop( "disabled", false );
			 	OcultarLoader();//$("#div_cargando").hide();
	 			 alertify.alert("Ocurrio un problema. Intente mas tarde.");
			},
			 timeout: 6000	 
		});	
	}
	
	function pedir_chofer3( banderaServicio, idServicio, nombreCliente, latitudOrigen, longitudOrigen, latitudDestino, longitudDestino, idChofer )
	{		
		$.ajax({
			 url: "test_acciones.php",
			 data: "banderaServicio="+banderaServicio +"&idServicio="+idServicio+"&nombreCliente="+nombreCliente+"&latitudOrigen="+latitudOrigen+"&longitudOrigen="+longitudOrigen+"&latitudDestino="+latitudDestino+"&longitudDestino="+longitudDestino+"&intento=3&idChofer="+idChofer , 
			 async: true,
			 type: "POST",
			 contentType: "application/x-www-form-urlencoded",
			 dataType: "json",
			 global: true,
			 ifModified: false,
			 processData: true,
			 success: function(data)
			 {

			 	if( data.respuesta == "buscando" )
			 	{
				 	setTimeout( function() { checar_servicio( banderaServicio, idServicio, data.idChofer ) } , 15000);
			 	}else
			 	{
			 		if( data.respuesta == "asignado" )
			 		{
				 		$( "#boton" ).prop( "disabled", false );
			 			OcultarLoader();//$("#div_cargando").hide();
			 			//alert("idChofer asignado: "+data.idChofer);
						$("#idChofer").val(data.idChofer);
						GuardarServicio();
			 		}else
			 		{
				 		$( "#boton" ).prop( "disabled", false );
			 			OcultarLoader();//$("#div_cargando").hide();
			 			 alertify.alert("No existen choferes disponibles. Intente mas tarde");
			 		}
			 	}
			 			
			 },error: function () {
			 
				$( "#boton" ).prop( "disabled", false );
			 	$("#div_cargando").hide();
	 			 alertify.alert("Ocurrió un problema. Intente mas tarde.");
			},
			 timeout: 6000	 
		});	
	}
	
	function checar_servicio( banderaServicio, idServicio, idChofer )
	{		
		$.ajax({
			 url: "test_acciones.php",
			 data: "banderaServicio="+banderaServicio +"&idServicio="+idServicio+"&intento=4"+"&idChofer="+idChofer , 
			 async: true,
			 type: "POST",
			 contentType: "application/x-www-form-urlencoded",
			 dataType: "json",
			 global: true,
			 ifModified: false,
			 processData: true,
			 success: function(data)
			 {
		 		if( data.respuesta == "asignado" )
		 		{
			 		$( "#boton" ).prop( "disabled", false );
		 			OcultarLoader();//$("#div_cargando").hide();
		 			//alert("idChofer asignado: "+data.idChofer);
					$("#idChofer").val(data.idChofer);
					GuardarServicio();
		 		}else
		 		{
			 		$( "#boton" ).prop( "disabled", false );
		 			OcultarLoader();//$("#div_cargando").hide();
		 			alertify.alert("No existen choferes disponibles. Intente mas tarde");
		 		} 	
			 			
			 },error: function () {
			 
				$( "#boton" ).prop( "disabled", false );
			 	$("#div_cargando").hide();
	 			 alertify.alert("Ocurrió un problema. Intente mas tarde.");
			},
			 timeout: 6000	 
		});	
	}
	
</script>

