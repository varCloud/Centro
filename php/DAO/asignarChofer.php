<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	$conn = mysqli_connect("localhost", "hydracsm_admin", "Admin2016","hydracsm_admin");
	$array_ids = array();
	$array_distancias = array();
	$array_distancias_aux = array();
	$accion="1";
	$idServicio = 'null';
	$banderaServicio= (isset($_POST["banderaServicio"]) ?  $_POST["banderaServicio"] : 'null');
	$idChofer =       (isset($_POST["idChofer"]) ? $_POST["idChofer"] : '42');
	$nombreCliente =  (isset($_POST['nombreCliente'])? $_POST['nombreCliente'] : 'VICTOR ADRIAN REYES');
	$latitudOrigen =  (isset($_POST["latitudOrigen"])   ? $_POST["latitudOrigen"]  :  '19.6973818' );
	$longitudOrigen = (isset( $_POST["longitudOrigen"]) ? $_POST["longitudOrigen"] : '-101.1624435');
	$latitudDestino = (isset($_POST["latitudDestino"])  ? $_POST["latitudDestino"] : '19.697399');
	$longitudDestino =(isset( $_POST["longitudDestino"])? $_POST["longitudDestino"]: '-101.158414'); 

	function Intento()
	{
		global 	$array_ids,$array_distancias ,	$array_distancias_aux ,$accion,$conn,	$idServicio ,
	    $banderaServicio,$idChofer ,$nombreCliente ,$latitudOrigen ,$longitudOrigen ,$latitudDestino ,$longitudDestino ;

		if( $accion == "1" )//primer intento
		{
			echo $accion;
			$query_choferes = mysqli_query($conn, " SELECT latitud, longitud, idChofer FROM choferes WHERE estatus = '1' AND aprobado = '1' AND conectado = '1' AND en_servicio = '0' ");
			if( mysqli_num_rows($query_choferes) == 0 ){
					$data["status"]="error";
					$data["idChofer"]= 'null';
					$data["msj"]="No existen choferes disponibles";
				
			}

			else
			{			
				$contador = 0;
				$numero_elementos = 1;
				while( $registros_choferes = mysqli_fetch_array($query_choferes) )
				{
					$resultado = 0;
					$resultado = harvestine('19.7106065', '-101.15297799999999', $registros_choferes["latitud"], $registros_choferes["longitud"]);
					echo "resultado".$resultado."<br/>";
				//	if( $resultado >= 0 && $resultado <= 100.00 && $numero_elementos <= 3 )
				//		{
						$array_ids[ ($numero_elementos -1) ]["idChofer"] = $registros_choferes["idChofer"];
						$array_ids[ ($numero_elementos -1) ]["distancia"]=$resultado;

						$numero_elementos++;
				//	}
				//	$contador++;
				}
				
				//CREAMOS ARRE AUXILIAR CON EL CAMPO QUE SE DESEA ORDENAR
				foreach ($array_ids as $key => $row) {
						$aux[$key] = $row['distancia'];
				}
				
				array_multisort($aux, SORT_ASC, $array_ids);
				
				foreach ($array_ids as $key => $row) {
					echo '<br / > '.$row['idChofer'].' '.$row['distancia'].'<br/>';
				}
				//SE ENVIA LA PUSH AL CHOFER MAS CERCANO

				$servicioAceptadoAux = 0;
				$intentos_chofer =0;//SE VA A INCREMENTAR YA SEA QUE NO  ACEPTAN LA SOLICITUD O POR QUE SE AGOTO EL TIEMPO O POR QUE LA RECHAZO EL CHOFER EN TURNO
				
				//MIENTRAS EL servicioAceptadoAux =0 ES DECIR QUE NADIE RESPONDA
				// Y QUE INTENTE CON 3 CHOFERES 
				// Y QUE LOS INTENTOS SEA MENOR IGUAL A LA LONTITUD DEL ARRAY DE LOS CHOFERES YA QUE 
				// SI LOS INTENTOS SON MAYORES AL ARRAY DE LOS CHOFERES PUES ME MARCARA UN NULL 				
				while( $servicioAceptadoAux == 0 && $intentos_chofer != 3 && $intentos_chofer <= (count($array_ids)-1) )
					{
						$idChoferAux=  $array_ids[$contador]["idChofer"];
						EnviarPush($idChoferAux);
						sleep(10);
						
						echo "<br />voy  a buscar que respondio el chofer con el id ->".$idChoferAux;
						$servicioAceptadoAux = servicioAceptado($idChoferAux);
						echo "<br/>el servicio por el  chofer con el id ".$idChoferAux." fue aceptado ? ".$servicioAceptadoAux;
						//ESTE IF ES SOLO PARA AUMEBTAR EL CONTADOR EN CASO DE LA FUNCION DE SERVICIO ACEPTADO
						// REGRESE CERO YA QUE SI NO REGRESA USARE EL CONTADOR PARA SACAR EL ID DEL CHOFER
						// DEL ARRAY_IDS DONDE ESTAB LOS CHOFERES 
						if($servicioAceptadoAux ==0)
						{
							$contador++;
							$intentos_chofer++;
						}
					}
				
				if($servicioAceptadoAux ==1)
				{
					$data["status"]="success";
					$data["idChofer"]= $array_ids[$contador];
					$data["msj"]="chofer asignado correctamente";
					
				}else if($intentos_chofer =3  || $intentos_chofer <=(count($array_ids)-1))
				{
					$data["status"]="error";
					$data["idChofer"]= 'null';
					$data["msj"]="Los choferes mas cercanos no respondieron al servicio";
				}
				echo "<br />".json_encode($data);
			}
		}
	}

	function servicioAceptado($idChofer)
	{
		global 	$array_ids,$array_distancias ,	$array_distancias_aux ,$accion,$conn,	$idServicio ,
	    $banderaServicio,$idChofer ,$nombreCliente ,$latitudOrigen ,$longitudOrigen ,$latitudDestino ,$longitudDestino ;
		$servicioAceptado =0;
		if( $banderaServicio == "1" )
			{
				$query_servicio_asignado = mysqli_query($conn, " SELECT idChofer, choferAsignado FROM serviciosconcita WHERE idServicio = '".$idServicio."' ");
				$registro_servicio = mysqli_fetch_array($query_servicio_asignado);
				if( $registro_servicio["choferAsignado"] == 1 )
					$servicioAceptado=1;
			}else
			{
				$query_servicio_asignado = mysqli_query($conn, " SELECT en_servicio FROM choferes WHERE idChofer = '".$idChofer."' ");
				$registro_servicio = mysqli_fetch_array($query_servicio_asignado);
				if( $registro_servicio["en_servicio"] == 1 )
					$servicioAceptado =1;
			}
		return $servicioAceptado;
	}
	

function EnviarPush($idChofer)
	{
		global 	$array_ids,$array_distancias ,	$array_distancias_aux ,$accion,$conn,	$idServicio ,
	    $banderaServicio ,$nombreCliente ,$latitudOrigen ,$longitudOrigen ,$latitudDestino ,$longitudDestino ;

		$query_chofer = mysqli_query($conn, " SELECT token, idChofer, usuario, conectado FROM choferes WHERE idChofer = '".$idChofer."' ");
			if( mysqli_num_rows( $query_chofer ) == 1 )
			{
				$registro = mysqli_fetch_array($query_chofer);
				
				$data = array();
				
				$data["mensaje"] = "Tienes una solicitud de servicio";
				
				$data["idChofer"] = $registro["idChofer"];
				$data["usuario"] = utf8_encode( $registro["usuario"] );
				
				$data["nombreCliente"] = utf8_encode( $nombreCliente );
				$data["idServicio"] = $idServicio;
				
				$data["banderaServicio"] = $banderaServicio;
				
				$data["latitudOrigen"] = $latitudOrigen;
				$data["longitudOrigen"] = $longitudOrigen;
				$data["latitudDestino"] = $latitudDestino;
				$data["longitudDestino"] = $longitudDestino;
				$mensaje = array( 'data' =>  json_encode($data));
				
				if( $registro['token'] == "" )
					$respuesta["respuesta"] = "error";
				else
				{
					enviar_mensaje( $registro['token'], $mensaje );
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
    
    //echo $result;	
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
Intento();
	
?>