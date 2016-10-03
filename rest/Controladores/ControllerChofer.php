<?php

class ControllerChofer {
   protected $ci;

   public function __construct() {
       //$this->ci = $ci;
   }
   
   public function ObtenerChoferes($request, $response, $args) {  

        $sql = new MySQL();
        $query = "SELECT * FROM choferes";
        $res = $sql->consulta($query);
        $indice=0;
        while ($row = $sql->fetch_array($res)) {
            $c = new Chofer;
            $c->idCliente=$row['idChofer'];
            $c->nombre=$row['usuario'];
            $data[$indice]= $c;
            $indice++;
        }

        return json_encode($data);

    }
    
    public function registrarChofer($request, $response, $args) {
    
    
    	$post = $request->getParsedBody();

	    $nombre = trim(utf8_decode(str_replace("'","",str_replace("\"","",$post['nombre']))));
	    $telefono = trim(utf8_decode(str_replace("'","",str_replace("\"","",$post['telefono']))));
	    $vehiculo = trim(utf8_decode(str_replace("'","",str_replace("\"","",$post['vehiculo']))));
	    $placas = trim(utf8_decode(str_replace("'","",str_replace("\"","",$post['placas']))));
	    $correo = trim(utf8_decode(str_replace("'","",str_replace("\"","",$post['correo']))));
	    $password = trim(utf8_decode(str_replace("'","",str_replace("\"","",$post['password']))));
	    
	    $c = new FormularioChofer();
        $c->idChofer = "";
        $c->respuesta = "error";
	    
        $sql = new MySQL();  
        
        $query_registros_duplicados = " SELECT idChofer FROM choferes WHERE correo = '".$correo."' AND usuario = '".$nombre."' AND contrasenia = '".$password."' AND telefono = '".$telefono."' ";
        $res_registros_duplicados = $sql->consulta($query_registros_duplicados);
        if(mysql_num_rows($res_registros_duplicados) == 0)
        {
        	$query_correo_existente = " SELECT idChofer FROM choferes WHERE correo = '".$correo."' ";
	        $res_correo_existente = $sql->consulta($query_correo_existente);
	        if(mysql_num_rows($res_correo_existente) >= 1)
	        	$c->respuesta = "correo";
	        else
	        {
				$ultimo = "";
	            $query = " INSERT INTO choferes ( usuario, contrasenia, telefono, correo, vehiculo, placas, estatus, aprobado ) VALUES ( '".$nombre."', '".$password."', '".$telefono."', '".$correo."', '".$vehiculo."', '".$placas."', '1', '0' ) ";
		        $res = $sql->consulta($query);
				if($res == true)
				{	
					$fecha = date("Y-m-d-h:i:s");
					$ultimo = mysql_insert_id();
					$chofer = 'uploads/chofer/foto_chofer'.$fecha.'.jpg';
					$vehiculo = 'uploads/vehiculo/foto_vehiculo'.$fecha.'.jpg';
					$licencia = 'uploads/licencia/foto_licencia'.$fecha.'.jpg';
					$poliza = 'uploads/poliza/foto_poliza'.$fecha.'.jpg';
					if (move_uploaded_file($_FILES['imageChofer']['tmp_name'], $chofer) && move_uploaded_file($_FILES['imageVehiculo']['tmp_name'], $vehiculo) && move_uploaded_file($_FILES['imageLicencia']['tmp_name'], $licencia) && move_uploaded_file($_FILES['imagePoliza']['tmp_name'], $poliza) ) 
					{
						$urlChofer = "uploads/chofer/".$ultimo.".jpg";
						$urlVehiculo = "uploads/vehiculo/".$ultimo.".jpg";
						$urlLicencia = "uploads/licencia/".$ultimo.".jpg";
						$urlPoliza = "uploads/poliza/".$ultimo.".jpg";
						
						rename($chofer, $urlChofer);
						rename($vehiculo, $urlVehiculo);
						rename($licencia, $urlLicencia);
						rename($poliza, $urlPoliza);
					    $query_edicion = " UPDATE choferes SET urlFotoUsuario = 'rest/".$urlChofer."', urlFotoAuto = 'rest/".$urlVehiculo."', urlFotoLicencia = 'rest/".$urlLicencia."', urlFotoPoliza = 'rest/".$urlPoliza."'  WHERE idChofer = '".$ultimo."' ";
		                $sql->consulta($query_edicion);
					    $c->respuesta = "correcto";
					    $c->idChofer = $ultimo;
					}
					  
				}		
				else
					$c->respuesta = "error";
			}
        }
        return json_encode($c);

    }
    
    public function loginChofer($request, $response, $args) {
     
    	$post = $request->getParsedBody();

	    $correo = trim(utf8_decode(str_replace("'","",str_replace("\"","",$post['correo']))));
	    $password = trim(utf8_decode(str_replace("'","",str_replace("\"","",$post['password']))));
	    
        $c = new loginChofer();
        $c->idChofer = "";
        $c->respuesta = "";
        $c->nombre = "";
	    
	    $sql = new MySQL();
	    $query_correo_existente = " SELECT idChofer FROM choferes WHERE correo = '".$correo."' ";
        $res_correo_existente = $sql->consulta($query_correo_existente);
        if(mysql_num_rows($res_correo_existente) == 1)
        {
	        $query_password = " SELECT * FROM choferes WHERE correo = '".$correo."' AND contrasenia = '".$password."' AND estatus = '1' ";
	        $res_password = $sql->consulta($query_password);
	        if(mysql_num_rows($res_password) == 1)
	        {
	        	$registro = mysql_fetch_array($res_password);
	        	if( $registro["aprobado"] == 1 )
	        	{
			        $query_conectado = " UPDATE choferes SET activo = '1' WHERE idChofer = '".$registro["idChofer"]."' ";
					$sql->consulta($query_conectado);
		        	$c->respuesta = "correcto";
		        	$c->idChofer = $registro["idChofer"];
		        	$c->nombre = utf8_encode($registro["usuario"]);
	        	}else
	        		$c->respuesta = "desactivado";
		        
	        }else
	        	$c->respuesta = "password";
        }
        else
			$c->respuesta = "correo";
		
		return json_encode($c);
        
    }
    
    public function actualizarUbicacion($request, $response, $args)
    {
	    $post = $request->getParsedBody();

	    $idChofer = trim(utf8_decode(str_replace("'","",str_replace("\"","",$post['idChofer']))));
	    $latitud = trim(utf8_decode(str_replace("'","",str_replace("\"","",$post['latitud']))));
	    $longitud = trim(utf8_decode(str_replace("'","",str_replace("\"","",$post['longitud']))));
	    
	    $sql = new MySQL();
	    $query = " UPDATE choferes SET latitud = '".$latitud."', longitud = '".$longitud."', conectado = '1' WHERE idChofer = '".$idChofer."'  ";
        $sql->consulta($query);
        
        return json_encode("");

    }
    
    public function actualizarConexion($request, $response, $args)
    {
	    $post = $request->getParsedBody();

	    $idChofer = trim(utf8_decode(str_replace("'","",str_replace("\"","",$post['idChofer']))));
	    $bandera = trim(utf8_decode(str_replace("'","",str_replace("\"","",$post['bandera']))));
	    
	    $sql = new MySQL();
	    $query = " UPDATE choferes SET conectado = '".$bandera."' WHERE idChofer = '".$idChofer."'  ";
        $sql->consulta($query);
        
        return json_encode("");

    }
    
    
    
    public function registrarToken($request, $response, $args)
    {
	    $post = $request->getParsedBody();

	    $idChofer = trim(utf8_decode(str_replace("'","",str_replace("\"","",$post['idChofer']))));
	    $token = $post['token'];
	    
	    $sql = new MySQL();
	    $query = " UPDATE choferes SET token = '".$token."' WHERE idChofer = '".$idChofer."'  ";
        $sql->consulta($query);
        
        return json_encode("");

    }
    
    public function actualizarEnServicio($request, $response, $args)
    {
	    $post = $request->getParsedBody();

	    $idChofer = trim(utf8_decode(str_replace("'","",str_replace("\"","",$post['idChofer']))));
	    $bandera = trim(utf8_decode(str_replace("'","",str_replace("\"","",$post['bandera']))));
	    
	    
	    $sql = new MySQL();
	    $query = " UPDATE choferes SET en_servicio = '".$bandera."' WHERE idChofer = '".$idChofer."'  ";
        $sql->consulta($query);
        
        return json_encode("");

    }
    
    public function aceptarServicio($request, $response, $args)
    {
	    $post = $request->getParsedBody();

	    $idChofer = trim(utf8_decode(str_replace("'","",$post['idChofer'])));
	    $idServicio = trim(utf8_decode(str_replace("'","",$post['idServicio'])));
	    $banderaServicio = trim(utf8_decode(str_replace("'","",$post['banderaServicio'])));
	    $latitudOrigen = trim(utf8_decode(str_replace("'","",$post['latitudOrigen'])));
    	$longitudOrigen = trim(utf8_decode(str_replace("'","",$post['longitudOrigen'])));
	    $latitudDestino = trim(utf8_decode(str_replace("'","",$post['latitudDestino'])));
    	$longitudDestino = trim(utf8_decode(str_replace("'","",$post['longitudDestino'])));  
	    $sql = new MySQL();
		$respuesta = "";
		if( $banderaServicio == "0" )//Servicio sin cita
		{ 
		
		
			$query_agendado = " SELECT id_servicio_temp FROM servicio_temp WHERE latitudOr = '".$latitudOrigen."' AND longitudOr = '".$longitudOrigen."' AND latitudDest = '".$latitudDestino."'
									AND longitudDest = '".$longitudDestino."' AND date(fechaAlta) = DATE(NOW()) ";
									
									
			$res_agendado = $sql->consulta($query_agendado);
			if(mysql_num_rows($res_agendado) == 0)
			{
			    $query = " UPDATE choferes SET en_servicio = '1' WHERE idChofer = '".$idChofer."' ";
		        $res = $sql->consulta($query);
		        
		        $query_insert = " INSERT INTO servicio_temp (latitudOr, longitudOr, latitudDest, longitudDest, fechaAlta ) VALUES ( '".$latitudOrigen."', '".$longitudOrigen."', '".$latitudDestino."', '".$longitudDestino."', NOW() ) ";
		        $res_insert = $sql->consulta($query_insert);
		        
		        
		        
		        if( $res == true && $res_insert == true )
		        	$respuesta = "correcto";
		        else
		        {
		        	$respuesta = "error";
				    $query = " UPDATE choferes SET en_servicio = '0' WHERE idChofer = '".$idChofer."' ";
					$sql->consulta($query);
					
					$query_delete = " DELETE FROM servicio_temp WHERE latitudOr = '".$latitudOrigen."' AND longitudOr = '".$longitudOrigen."' AND latitudDest = '".$latitudDestino."'
									AND longitudDest = '".$longitudDestino."' AND date(fechaAlta) = DATE(NOW()) ";
					$sql->consulta($query_delete);
		        }
	        }else
	        	$respuesta = "asignado";
        }else//Servicio con cita
        {
	       	$query_agendado = " SELECT choferAsignado FROM serviciosconcita WHERE idServicio = '".$idServicio."' ";
			$res_agendado = $sql->consulta($query_agendado);
			$reg = mysql_fetch_array($res_agendado);
			if( $reg["choferAsignado"] == 0 )
			{
				$query = " UPDATE serviciosconcita SET choferAsignado = '1', idChofer = '".$idChofer."' WHERE idServicio = '".$idServicio."' ";
		        $res = $sql->consulta($query);
		        if( $res == true )
		        	$respuesta = "correcto";
		        else
		        	$respuesta = "error";
			}else
				$respuesta = "asignado";
        }
		
		return json_encode($respuesta);
    }
    
    public function terminarViaje($request, $response, $args)
    {
	    $post = $request->getParsedBody();

	    $idChofer = trim(utf8_decode(str_replace("'","",$post['idChofer'])));
	    $idServicio = trim(utf8_decode(str_replace("'","",$post['idServicio'])));
	    
	    $sql = new MySQL();
	    if( $idServicio == "" || $idServicio == null || $idServicio == "null" )//Servicio sin cita
	    {
	    
	    
	    	$query_servicio = " SELECT * FROM serviciossincita WHERE idChofer = '".$idChofer."' AND servicioFinalizado = '0' ";
			$res_servicio = $sql->consulta($query_servicio);
			$reg = mysql_fetch_array($res_servicio);
			
			$query_delete = " DELETE FROM servicio_temp WHERE latitudOr = '".$reg['latitudOr']."' AND longitudOr = '".$reg['longitudOr']."' AND latitudDest = '".$reg['latitudDest']."'
									AND longitudDest = '".$reg['longitudDest']."' AND date(fechaAlta) = DATE(NOW()) ";
			$sql->consulta($query_delete);
	    
	    
		    $query = " UPDATE serviciossincita SET servicioFinalizado = '1' WHERE idChofer = '".$idChofer."'  ";
	        $sql->consulta($query);
	        
	        
        }else//Servicio con cita
        {
	        $query = " UPDATE serviciosconcita SET servicioFinalizado = '1' WHERE idChofer = '".$idChofer."'  ";
	        $sql->consulta($query);
        }
        $query_chofer = " UPDATE choferes SET en_servicio = '0' WHERE idChofer = '".$idChofer."'  ";
        $sql->consulta($query_chofer);
        
        return json_encode("");

    }
    

   public function book ($request, $response) {
      $json = $request->getBody();
      $data = json_decode($json, true);
     
   }

   public function method2($request, $response, $args) {
        //your code
        //to access items in the container... $this->ci->get('');
   }
      
   public function method3($request, $response, $args) {
        //your code
        //to access items in the container... $this->ci->get('');
   }
}

?>