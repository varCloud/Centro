<?php

		include 'php/Conexion/Conexion.php';
		
		
		//ALGORITMO PARA DETERMINAR CHOFER Y PROCESO DE ASIGNACIÓN DE SERVICIOS DE TAXI
		
		

		$sql = new MySQL();
	    $query="SELECT token, idChofer, usuario, conectado FROM choferes  ";
	    $res = $sql->consulta($query);
	    
	    
    	$data = array();
		$data["mensaje"] = "Tienes una solicitud de servicio";
		$data["idChofer"] =  $registro["idChofer"] ;
		$data["usuario"] = $registro["usuario"];
		$data["nombreCliente"] = "Alberto Pérez";
		$data["idServicio"] = "Id -> 1";
		$data["latitudOrigen"] = "20.679545";
		$data["longitudOrigen"] = "-103.422425";
		$data["latitudDestino"] = "20.694731";
		$data["longitudDestino"] = "-103.418082";
		$mensaje = array( 'data' =>  json_encode($data));
		
		while( $registro = $sql->fetch_array($res) )
		{
		if( $registro["conectado"] == 1 && $registro["token"] != "" )		
			enviar_mensaje( $registro['token'], $mensaje );
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
	 
	        $result = curl_exec($ch);
	        curl_close($ch);	
	        
	        echo $result;	
        }

        
?>