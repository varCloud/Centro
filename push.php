<?php

		include 'php/Conexion/Conexion.php';
		
		
		//ALGORITMO PARA DETERMINAR CHOFER Y PROCESO DE ASIGNACIÓN DE SERVICIOS DE TAXI
		

		$sql = new MySQL();
	    $query=" SELECT token, idChofer, usuario, conectado FROM choferes WHERE idChofer = '36'  ";
	    $res = $sql->consulta($query);
	    $registro = $sql->fetch_array($res);
	    
	    
    	$data = array();
		$data["mensaje"] = "Tienes una solicitud de servicio";
		$data["idChofer"] = $registro["idChofer"];
		$data["usuario"] = utf8_encode( $registro["usuario"] );
		$data["nombreCliente"] = "Alberto Pérez";
		$data["idServicio"] = "Id -> 1";
		//$data["latitudOrigen"] = "20.679545";, -101.201769
		
		$data["latitudOrigen"] = "19.728771";
		$data["longitudOrigen"] = "-103.422425";
		$data["latitudDestino"] = "20.694731";
		$data["longitudDestino"] = "-103.418082";
		$mensaje = array( 'data' =>  json_encode($data));

		//echo json_encode($data)."</br>";
		
		if( $registro["conectado"] == 1 )		
			enviar_mensaje( $registro['token'], $mensaje );

	
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
	 
	        $result = curl_exec($ch);
	        curl_close($ch);	
	        
	        echo $result;	
        }

        
?>