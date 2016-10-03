<?php
	$conn = mysqli_connect("localhost", "hydracsm_admin", "Admin2016","hydracsm_admin");
	$array_ids = array();
	$array_distancias = array();
	$array_distancias_aux = array();

	if( $_POST["intento"] == "1" )//primer intento
	{

		
		$query_choferes = mysqli_query($conn, " SELECT latitud, longitud, idChofer FROM choferes WHERE estatus = '1' AND aprobado = '1' AND conectado = '1' AND en_servicio = '0' ");
	    if( mysqli_num_rows($query_choferes) == 0 )
	    	$respuesta["respuesta"] = "error";
	    else
	    {
	    	$contador = 0;
	    	$numero_elementos = 1;
	    	
	    	while( $registros_choferes = mysqli_fetch_array($query_choferes) )
	    	{
	    		$resultado = 0;
	    		$resultado = harvestine($_POST["latitudOrigen"], $_POST["longitudOrigen"], $registros_choferes["latitud"], $registros_choferes["longitud"]);
	    		
	    		if( $resultado >= 0 && $resultado <= 3.00 )
	    		{
	    			
	    			$array_ids[ ($numero_elementos -1) ] = $registros_choferes["idChofer"];
	        		$array_distancias[ ($numero_elementos -1) ] = $resultado;
	        		$array_distancias_aux[ ($numero_elementos -1) ] = $resultado;
	        		$numero_elementos++;
	        	}
	        	$contador++;
	        	
	    	}
	    	
	    	$posicionIdChofer = 0;
	    	
	    	sort($array_distancias);
	    	
	    	for( $i = 0; $i < count($array_distancias_aux); $i++ )
	    	{
		    	if( $array_distancias[0] == $array_distancias_aux[$i] )
		    		$posicionIdChofer = $i;
	    	}  	
	    		
	    	$nombreCliente = "";
	    		
	    	if( $_POST["nombreCliente"] == "" )
	    	{
		    	$query_cliente = mysqli_query($conn, " SELECT clientes.nombreCompleto FROM clientes, citas, serviciosconcita WHERE clientes.idCliente = citas.idCliente AND citas.idCita = serviciosconcita.idCita
		    											  AND serviciosconcita.idServicio = '".$_POST["idServicio"]."' ");
		    	$regitro_cliente = mysqli_fetch_array($query_cliente);
		    	$nombreCliente = utf8_encode($regitro_cliente["nombreCompleto"]);
	    	}else
	    		$nombreCliente = $_POST["nombreCliente"];
	    		
		    	 	
	    	if( $nombreCliente == "" )
	    		$respuesta["respuesta"] = "error";
	    	else
    		{
    			$sql_query_chofer = " SELECT token, idChofer, usuario, conectado FROM choferes WHERE idChofer = '".$array_ids[$posicionIdChofer]."' ";
    			
	    		$query_chofer = mysqli_query($conn, $sql_query_chofer);
	    		if( mysqli_num_rows( $query_chofer ) == 1 )
	    		{
			    	$registro = mysqli_fetch_array($query_chofer);
			    	
			    	$data = array();
			    	
					$data["mensaje"] = "Tienes una solicitud de servicio";
					
					$data["idChofer"] = $registro["idChofer"];
					$data["usuario"] = utf8_encode( $registro["usuario"] );
					
					$data["nombreCliente"] =  $nombreCliente ;
					$data["idServicio"] = $_POST["idServicio"];
					
					$data["banderaServicio"] = $_POST["banderaServicio"];
					
					$data["latitudOrigen"] = $_POST["latitudOrigen"];
					$data["longitudOrigen"] = $_POST["longitudOrigen"];
					$data["latitudDestino"] = $_POST["latitudDestino"];
					$data["longitudDestino"] = $_POST["longitudDestino"];
					$mensaje = array( 'data' =>  json_encode($data));
					
					if( $registro['token'] == "" )
						$respuesta["respuesta"] = "error";
					else
					{
						enviar_mensaje( $registro['token'], $mensaje );
					
						$respuesta["idChofer"] = $registro["idChofer"];
						$respuesta["respuesta"] = "buscando";
					}
					
				}else
					$respuesta["respuesta"] = "error";
    		}
	    		       	
	    }
	    echo json_encode($respuesta);

	}else
	{
		if( $_POST["intento"] == "2" )//segundo intento
		{
			$respuesta["idChofer"] = "";
			if( $_POST["banderaServicio"] == "1" )
			{
				$query_servicio_asignado = mysqli_query($conn, " SELECT idChofer, choferAsignado FROM serviciosconcita WHERE idServicio = '".$_POST["idServicio"]."' ");
				$registro_servicio = mysqli_fetch_array($query_servicio_asignado);
				if( $registro_servicio["choferAsignado"] == "1" )
					$respuesta["idChofer"] = $registro_servicio["idChofer"];
			}else
			{
				$query_servicio_asignado = mysqli_query($conn, " SELECT en_servicio FROM choferes WHERE idChofer = '".$_POST["idChofer"]."' ");
				$registro_servicio = mysqli_fetch_array($query_servicio_asignado);
				if( $registro_servicio["en_servicio"] == "1" )
					$respuesta["idChofer"] = $_POST["idChofer"];
			}
		
			if( $respuesta["idChofer"] == "" )
			{		
		
				$query_choferes = mysqli_query($conn, " SELECT latitud, longitud, idChofer FROM choferes WHERE estatus = '1' AND aprobado = '1' AND conectado = '1' AND en_servicio = '0' ");
			    if( mysqli_num_rows($query_choferes) == 0 )
			    	$respuesta["respuesta"] = "error";
			    else
			    {
			    	$contador = 0;
			    	$numero_elementos = 1;
			    	
			    	
			    	while( $registros_choferes = mysqli_fetch_array($query_choferes) )
			    	{
			    		$resultado = 0;
			    		$resultado = harvestine($_POST["latitudOrigen"], $_POST["longitudOrigen"], $registros_choferes["latitud"], $registros_choferes["longitud"]);
			    		if( $resultado >= 0 && $resultado <= 4.00  )
			    		{
			    			if( $_POST["idChofer"] != $registros_choferes["idChofer"]  )
			    			{
				    			$array_ids[ ($numero_elementos -1) ] = $registros_choferes["idChofer"];
				        		$array_distancias[ ($numero_elementos -1) ] = $resultado;
				        		$array_distancias_aux[ ($numero_elementos -1) ] = $resultado;
				        		$numero_elementos++;
			        		}
			        	}
			        	$contador++;
			        	
			    	}
			    	
			    	$posicionIdChofer = 0;
			    	
			    	sort($array_distancias);
			    	
			    	for( $i = 0; $i < count($array_distancias_aux); $i++ )
			    	{
				    	if( $array_distancias[0] == $array_distancias_aux[$i] )
				    		$posicionIdChofer = $i;
			    	}  	
			    		
			    	$nombreCliente = "";
			    		
			    	if( $_POST["nombreCliente"] == "" )
			    	{
				    	$query_cliente = mysqli_query($conn, " SELECT clientes.nombreCompleto FROM clientes, citas, serviciosconcita WHERE clientes.idCliente = citas.idCliente AND citas.idCita = serviciosconcita.idCita
				    											  AND serviciosconcita.idServicio = '".$_POST["idServicio"]."' ");
				    	$regitro_cliente = mysqli_fetch_array($query_cliente);
				    	$nombreCliente = utf8_encode($regitro_cliente["nombreCompleto"]);
			    	}else
			    		$nombreCliente = $_POST["nombreCliente"];
			    		
				    	 	
			    	if( $nombreCliente == "" )
			    		$respuesta["respuesta"] = "error";
			    	else
		    		{
		    			$sql_query_chofer = " SELECT token, idChofer, usuario, conectado FROM choferes WHERE idChofer = '".$array_ids[$posicionIdChofer]."' ";
			    		$query_chofer = mysqli_query($conn, $sql_query_chofer);
			    		
			    		if( mysqli_num_rows( $query_chofer ) == 1 )
			    		{
					    	$registro = mysqli_fetch_array($query_chofer);
					    	
					    	$data = array();
					    	
							$data["mensaje"] = "Tienes una solicitud de servicio";
							
							$data["idChofer"] = $registro["idChofer"];
							$data["usuario"] = utf8_encode( $registro["usuario"] );
							
							$data["nombreCliente"] = utf8_encode( $nombreCliente );
							$data["idServicio"] = $_POST["idServicio"];
							
							$data["banderaServicio"] = $_POST["banderaServicio"];
							
							$data["latitudOrigen"] = $_POST["latitudOrigen"];
							$data["longitudOrigen"] = $_POST["longitudOrigen"];
							$data["latitudDestino"] = $_POST["latitudDestino"];
							$data["longitudDestino"] = $_POST["longitudDestino"];
							$mensaje = array( 'data' =>  json_encode($data));
							
							if( $registro['token'] == "" )
								$respuesta["respuesta"] = "error";
							else
							{
								enviar_mensaje( $registro['token'], $mensaje );
							
								$respuesta["idChofer"] = $registro["idChofer"];
								$respuesta["respuesta"] = "buscando";
							}
							
						}else
							$respuesta["respuesta"] = "error";
		    		}
			    		       	
			    }
			}else
			{
				$respuesta["respuesta"] = "asignado";
				$respuesta["idChofer"] = $_POST["idChofer"];
				
			}
				
				
		    echo json_encode($respuesta);

		}else
		{
			if( $_POST["intento"] == "3" )//tercer intento
			{
				$respuesta["idChofer"] = "";
				if( $_POST["banderaServicio"] == "1" )
				{
					$query_servicio_asignado = mysqli_query($conn, " SELECT idChofer, choferAsignado FROM serviciosconcita WHERE idServicio = '".$_POST["idServicio"]."' ");
					$registro_servicio = mysqli_fetch_array($query_servicio_asignado);
					if( $registro_servicio["choferAsignado"] == "1" )
						$respuesta["idChofer"] = $registro_servicio["idChofer"];
				}else
				{
					$query_servicio_asignado = mysqli_query($conn, " SELECT en_servicio FROM choferes WHERE idChofer = '".$_POST["idChofer"]."' ");
					$registro_servicio = mysqli_fetch_array($query_servicio_asignado);
					if( $registro_servicio["en_servicio"] == "1" )
						$respuesta["idChofer"] = $_POST["idChofer"];
				}
			
				if( $respuesta["idChofer"] == "" )
				{		
			
					$query_choferes = mysqli_query($conn, " SELECT latitud, longitud, idChofer FROM choferes WHERE estatus = '1' AND aprobado = '1' AND conectado = '1' AND en_servicio = '0' ");
				    if( mysqli_num_rows($query_choferes) == 0 )
				    	$respuesta["respuesta"] = "error";
				    else
				    {
				    	$contador = 0;
				    	$numero_elementos = 1;
				    	
				    	while( $registros_choferes = mysqli_fetch_array($query_choferes) )
				    	{
				    		$resultado = 0;
				    		$resultado = harvestine($_POST["latitudOrigen"], $_POST["longitudOrigen"], $registros_choferes["latitud"], $registros_choferes["longitud"]);
				    		if( $resultado >= 0 && $resultado <= 5.00  )
				    		{
				    			if( $_POST["idChofer"] != $registros_choferes["idChofer"]  )
								{
					    			$array_ids[ ($numero_elementos -1) ] = $registros_choferes["idChofer"];
					        		$array_distancias[ ($numero_elementos -1) ] = $resultado;
					        		$array_distancias_aux[ ($numero_elementos -1) ] = $resultado;
					        		$numero_elementos++;
				        		}
				        	}
				        	$contador++;
				        	
				    	}
				    	
				    	$posicionIdChofer = 0;
				    	
				    	sort($array_distancias);
				    	
				    	for( $i = 0; $i < count($array_distancias_aux); $i++ )
				    	{
					    	if( $array_distancias[0] == $array_distancias_aux[$i] )
					    		$posicionIdChofer = $i;
				    	}  	
				    		
				    	$nombreCliente = "";
				    		
				    	if( $_POST["nombreCliente"] == "" )
				    	{
					    	$query_cliente = mysqli_query($conn, " SELECT clientes.nombreCompleto FROM clientes, citas, serviciosconcita WHERE clientes.idCliente = citas.idCliente AND citas.idCita = serviciosconcita.idCita
					    											  AND serviciosconcita.idServicio = '".$_POST["idServicio"]."' ");
					    	$regitro_cliente = mysqli_fetch_array($query_cliente);
					    	$nombreCliente = utf8_encode($regitro_cliente["nombreCompleto"]);
				    	}else
				    		$nombreCliente = $_POST["nombreCliente"];
				    		
					    	 	
				    	if( $nombreCliente == "" )
				    		$respuesta["respuesta"] = "error";
				    	else
			    		{
			    			
				    		$query_chofer = mysqli_query($conn, " SELECT token, idChofer, usuario, conectado FROM choferes WHERE idChofer = '".$array_ids[$posicionIdChofer]."' ");
				    		if( mysqli_num_rows( $query_chofer ) == 1 )
				    		{
						    	$registro = mysqli_fetch_array($query_chofer);
						    	
						    	$data = array();
						    	
								$data["mensaje"] = "Tienes una solicitud de servicio";
								
								$data["idChofer"] = $registro["idChofer"];
								$data["usuario"] = utf8_encode( $registro["usuario"] );
								
								$data["nombreCliente"] =  $nombreCliente ;
								$data["idServicio"] = $_POST["idServicio"];
								
								$data["banderaServicio"] = $_POST["banderaServicio"];
								
								$data["latitudOrigen"] = $_POST["latitudOrigen"];
								$data["longitudOrigen"] = $_POST["longitudOrigen"];
								$data["latitudDestino"] = $_POST["latitudDestino"];
								$data["longitudDestino"] = $_POST["longitudDestino"];
								$mensaje = array( 'data' =>  json_encode($data));
								
								if( $registro['token'] == "" )
									$respuesta["respuesta"] = "error";
								else
								{
									enviar_mensaje( $registro['token'], $mensaje );
								
									$respuesta["idChofer"] = $registro["idChofer"];
									$respuesta["respuesta"] = "buscando";
								}
								
							}else
								$respuesta["respuesta"] = "error";
			    		}
				    		       	
				    }
				}else
					$respuesta["respuesta"] = "asignado";
					
					
			    echo json_encode($respuesta);

			}else
			{
				if( $_POST["intento"] == "4" )//Cuarto intento
				{
					$respuesta["idChofer"] = "";
					if( $_POST["banderaServicio"] == "1" )
					{
						$query_servicio_asignado = mysqli_query($conn, " SELECT idChofer, choferAsignado FROM serviciosconcita WHERE idServicio = '".$_POST["idServicio"]."' ");
						$registro_servicio = mysqli_fetch_array($query_servicio_asignado);
						if( $registro_servicio["choferAsignado"] == "1" )
							$respuesta["idChofer"] = $registro_servicio["idChofer"];
					}else
					{
						$query_servicio_asignado = mysqli_query($conn, " SELECT en_servicio FROM choferes WHERE idChofer = '".$_POST["idChofer"]."' ");
						$registro_servicio = mysqli_fetch_array($query_servicio_asignado);
						if( $registro_servicio["en_servicio"] == "1" )
							$respuesta["idChofer"] = $_POST["idChofer"];
					}
				
					if( $respuesta["idChofer"] == "" )	
					    $respuesta["respuesta"] = "error";
					else
						$respuesta["respuesta"] = "asignado";
						
				    echo json_encode($respuesta);
				}
			}
		}
	}	


function enviar_mensaje( $destinatario, $data )
{
	$path_to_gmc_server = 'https://android.googleapis.com/gcm/send';
					 
    $fields = array(
        'to' => $destinatario,
        'time_to_live' => 0,
        'priority' => 'high',
        'data' =>  $data
    );

    $headers = array(
        'Authorization: key=AIzaSyBa8QfE0cYv1ePLl_xeWVkgFhDHHifK0FI',
        'Content-Type: application/json'
    );
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $path_to_gmc_server);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    curl_exec($ch);
    curl_close($ch);	
    
    echo $result;	
}



function harvestine($lat1, $long1, $lat2, $long2)
{ 
    //Distancia en kilometros en 1 grado distancia.
    //Distancia en millas nauticas en 1 grado distancia: $mn = 60.098;
    //Distancia en millas en 1 grado distancia: 69.174;
    //Solo aplicable a la tierra, es decir es una constante que cambiaria en la luna, marte... etc.
    $km = 111.302;
    
    //1 Grado = 0.01745329 Radianes    
    $degtorad = 0.01745329;
    
    //1 Radian = 57.29577951 Grados
    $radtodeg = 57.29577951; 

    $dlong = ($long1 - $long2); 
    $dvalue = (sin($lat1 * $degtorad) * sin($lat2 * $degtorad)) + (cos($lat1 * $degtorad) * cos($lat2 * $degtorad) * cos($dlong * $degtorad)); 
    $dd = acos($dvalue) * $radtodeg; 
    return round(($dd * $km), 2);
}		    
?>