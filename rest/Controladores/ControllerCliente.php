<?php

class ControllerCliente {
   protected $ci;
   //Constructor
   public function __construct() {
       //$this->ci = $ci;
   }
   
    public function registrarCliente($request, $response, $args) {
    
    
    	$post = $request->getParsedBody();

	    $nombre = trim(utf8_decode(str_replace("'","",$post['nombre'])));
	    $telefono = trim(utf8_decode(str_replace("'","",$post['telefono'])));
	    $vehiculo = trim(utf8_decode(str_replace("'","",$post['vehiculo'])));
	    $marca = trim(utf8_decode(str_replace("'","",$post['marca'])));
	    $anio = trim(utf8_decode(str_replace("'","",$post['anio'])));
	    $placas = trim(utf8_decode(str_replace("'","",$post['placas'])));
	    $correo = trim(utf8_decode(str_replace("'","",$post['correo'])));
	    $password = trim(utf8_decode(str_replace("'","",$post['password'])));
	    
	    $c = new FormularioCliente();
        $c->idCliente = "";
        $c->respuesta = "";
	    
        $sql = new MySQL();
        $query_registros_duplicados = " SELECT idCliente FROM clientes WHERE mail = '".$correo."' AND nombreCompleto = '".$nombre."' AND contrasenia = '".$password."' AND telefono = '".$telefono."' ";
        $res_registros_duplicados = $sql->consulta($query_registros_duplicados);
        if(mysql_num_rows($res_registros_duplicados) == 0)
        {
		    $query_correo_existente = " SELECT idCliente FROM clientes WHERE mail = '".$correo."' ";
	        $res_correo_existente = $sql->consulta($query_correo_existente);
	        if(mysql_num_rows($res_correo_existente) >= 1)
	        	$c->respuesta = "correo";
	        else
	        {
		        $query = " INSERT INTO clientes ( nombreCompleto, mail, contrasenia, fechaAlta, activo, telefono ) VALUES ( '".$nombre."', '".$correo."', '".$password."', NOW(), '1', '".$telefono."' ) ";
		        $res = $sql->consulta($query);
		        $ultimo = "";
		        $ultimo = mysql_insert_id();
		        $query_vehiculo = " INSERT INTO vehiculos ( marca, modelo, ano, placas, idCliente ) VALUES ( '".$marca."', '".$vehiculo."', '".$anio."', '".$placas."', '".$ultimo."' ) ";
		        $res_vehiculo = $sql->consulta($query_vehiculo);
				if($res == true && $res_vehiculo == true)
				{
			        $c->idCliente = $ultimo;
					$c->respuesta = "correcto";
				}
				else
					$c->respuesta = "error";
			}
        }
        return json_encode($c);
                
    }
    
    public function loginCliente($request, $response, $args) {
    
    
    	$post = $request->getParsedBody();

	    $correo = trim(utf8_decode(str_replace("'","",$post['correo'])));
	    $password = trim(utf8_decode(str_replace("'","",$post['password'])));
	    
        $c = new loginCliente();
        $c->idCliente = "";
        $c->respuesta = "";
        $c->nombre = "";
	    
	    $sql = new MySQL();
	    $query_correo_existente = " SELECT idCliente FROM clientes WHERE mail = '".$correo."' ";
        $res_correo_existente = $sql->consulta($query_correo_existente);
        if(mysql_num_rows($res_correo_existente) == 1)
        {
	        $query_password = " SELECT * FROM clientes WHERE mail = '".$correo."' AND contrasenia = '".$password."' AND activo = '1' ";
	        $res_password = $sql->consulta($query_password);
	        if(mysql_num_rows($res_password) == 1)
	        {
	        	$registro = mysql_fetch_array($res_password);
	        	
	        	$c->respuesta = "correcto";
	        	$c->idCliente = $registro["idCliente"];
	        	$c->nombre = utf8_encode($registro["nombreCompleto"]);
		        
	        }else
	        	$c->respuesta = "password";
        }
        else
			$c->respuesta = "correo";
		
		return json_encode($c);
        
    }
    
    public function ObtenerAgencias($request, $response, $args) {  

        $sql = new MySQL();
        $query = "SELECT * FROM sucursales ORDER BY idSucursal ASC ";
        $res = $sql->consulta($query);
        $indice=0;
        while ($row = $sql->fetch_array($res)) {
            $c = new Agencia();
            $c->idAgencia = $row['idSucursal'];
            $c->nombre = $row['descripcion'];
            $c->direccion = utf8_encode($row['calle'])." ".utf8_encode($row['colonia']);
            $c->telefono = $row['telefono'];
            $c->latitud = $row['latitud'];
            $c->longitud = $row['longitud'];
            $data[$indice]= $c;
            $indice++;
        }

        return json_encode($data);

    }
    
    public function cargarVehiculos($request, $response, $args){
    
    	$post = $request->getParsedBody();
    
    	$idCliente = trim(utf8_decode(str_replace("'","",$post['idCliente'])));
    
    	$sql = new MySQL();
        $query = "SELECT * FROM vehiculos WHERE idCliente = '".$idCliente."' ORDER BY idVehiculo ASC ";
        $res = $sql->consulta($query);
        $indice=0;
        while ($row = $sql->fetch_array($res)) {
            $c = new Vehiculo();
            $c->idVehiculo = $row['idVehiculo'];
            $c->vehiculo = utf8_encode($row['modelo']);
            $c->marca = utf8_encode($row['marca']);
            $c->anio = utf8_encode($row['ano']);
            $c->placas = utf8_encode($row['placas']);

            $data[$indice]= $c;
            $indice++;
        }

        return json_encode($data);
	    
    }
    
    public function cargarEjecutivos($request, $response, $args){
    
    	$post = $request->getParsedBody();
    	
    	$idSucursal = trim(utf8_decode(str_replace("'","",$post['idSucursal'])));
  
    	$sql = new MySQL();
        $query = " SELECT usuarios.idUsuario, usuarios.nombreCompleto FROM usuarios, roles WHERE usuarios.idRol = roles.idRol AND roles.descripcion = 'Ejecutivo' AND usuarios.activo = '1' AND usuarios.idSucursal = '".$idSucursal."' ORDER BY usuarios.idUsuario ASC ";
        $res = $sql->consulta($query);
        $indice=0;
        while ($row = mysql_fetch_array($res)) {
   
            $c = new Ejecutivo();
            $c->idUsuario = $row['idUsuario'];
            $c->nombre = utf8_encode($row['nombreCompleto']);

            $data[$indice]= $c;
            $indice++;
        }

        return json_encode($data);
	    
    }
    
    public function cargarDias($request, $response, $args){
    
    	$post = $request->getParsedBody();
    
    	$idSucursal = trim(utf8_decode(str_replace("'","",$post['idSucursal'])));
    	
    	$sql = new MySQL();
        $query = " SELECT horarios.idDia, dias.descripcion FROM horarios, dias WHERE horarios.idSucursal = '".$idSucursal."' AND horarios.idDia = dias.idDia ORDER BY dias.idDia ASC ";
    	$res = $sql->consulta($query);
    	
    	$indice=0;
    	for( $i = 0; $i <= 30; $i++ )
		{	
			mysql_data_seek($res, 0);
		    while ($row = mysql_fetch_array($res)) 
	    	{
	    		if( utf8_encode( $row["descripcion"] ) ==  nombreDia( date('D', strtotime('+'.$i.' day'))  ) )
	    		{
		    		$c = new Dia();
					$c->idHorario = $row["idDia"];
					$c->nombre =   nombreDia( date('D', strtotime('+'.$i.' day')) )." ".date('d', strtotime('+'.$i.' day'))." ".nombreMes( date('M', strtotime('+'.$i.' day')) );
					$c->fecha = date('Y-m-d', strtotime('+'.$i.' day'));
			        $data[$indice] = $c;		
		    		$indice++; 
		    	}   		
  			}	  
	    	
		}

        return json_encode($data);
	    
    }
    
     public function cargarHoras($request, $response, $args){
    
    	$post = $request->getParsedBody();
    
    	$idSucursal = trim(utf8_decode(str_replace("'","",$post['idSucursal'])));
    	$dia = trim(utf8_decode(str_replace("'","",$post['dia'])));
    	$fecha = trim(utf8_decode(str_replace("'","",$post['fecha'])));
    	

    	$sql = new MySQL();	
    	$query = " CALL SP_OBTENER_HORAS_DISPONIBLES ('".$idSucursal."','".$dia."','".$fecha."','1') ";
    	$res = $sql->consulta($query);
    	$indice=0;    	
    	
    	$conn = mysqli_connect("localhost", "hydracsm_admin", "Admin2016","hydracsm_admin");

    	while ($row = $sql->fetch_array($res)) 
    	{

    		$query_citas = mysqli_query($conn, " SELECT hora FROM citas WHERE idSucursal = '".$idSucursal."' AND hora = '".$row["horas"]."' AND fechaCita = '".$fecha."' ");
    		
    		//$registro_cita = $sql->fetch_array($res_citas);
    	
    		if( mysqli_num_rows($query_citas) == 0 )
    		{
	    		$c = new Hora();
	            $c->hora =  $row["horas"];  
	            $data[$indice] = $c;
	            $indice++;
    		}
    	}            
		
        return json_encode($data);
	    
    }
    
    public function agregarVehiculo($request, $response, $args) {
    
    	$post = $request->getParsedBody();

	    $idCliente = trim(utf8_decode(str_replace("'","",$post['idCliente'])));
	    $vehiculo = trim(utf8_decode(str_replace("'","",$post['vehiculo'])));
	    $marca = trim(utf8_decode(str_replace("'","",$post['marca'])));
	    $anio = trim(utf8_decode(str_replace("'","",$post['anio'])));
	    $placas = trim(utf8_decode(str_replace("'","",$post['placas'])));
	     
        $sql = new MySQL();
        $query_existente = " SELECT idVehiculo FROM vehiculos WHERE  modelo = '".$vehiculo."' AND marca = '".$marca."' AND ano = '".$anio."' AND placas = '".$placas."' AND idCliente = '".$idCliente."'  ";
        $res_existente = $sql->consulta($query_existente);
        $respuesta = "";
        if(mysql_num_rows($res_existente) == 0)
        {
            $query = " INSERT INTO vehiculos (modelo, marca, ano, placas, idCliente) VALUES ('".$vehiculo."', '".$marca."', '".$anio."', '".$placas."', '".$idCliente."') ";
	        $res = $sql->consulta($query);
			$respuesta = "";
			if($res == true )
				$respuesta = mysql_insert_id();
			else
				$respuesta = "error";
        }


        return json_encode($respuesta);
                
    }
    
    public function editarVehiculo($request, $response, $args) {
    
    
    	$post = $request->getParsedBody();

	    $idVehiculo = trim(utf8_decode(str_replace("'","",$post['idVehiculo'])));
	    $vehiculo = trim(utf8_decode(str_replace("'","",$post['vehiculo'])));
	    $marca = trim(utf8_decode(str_replace("'","",$post['marca'])));
	    $anio = trim(utf8_decode(str_replace("'","",$post['anio'])));
	    $placas = trim(utf8_decode(str_replace("'","",$post['placas'])));
	    
	    
        $sql = new MySQL();
        $query = " UPDATE vehiculos SET modelo = '".$vehiculo."', marca = '".$marca."', ano = '".$anio."', placas = '".$placas."' WHERE idVehiculo = '".$idVehiculo."' ";
        $res = $sql->consulta($query);
		$respuesta = "";
		if($res == true )
			$respuesta = "correcto";
		else
			$respuesta = "error";

        return json_encode($respuesta);
                
    }
    
    public function eliminarVehiculo($request, $response, $args) {
    
    
    	$post = $request->getParsedBody();

	    $idVehiculo = trim(utf8_decode(str_replace("'","",$post['idVehiculo'])));
	    
        $sql = new MySQL();
        $query = " DELETE FROM vehiculos WHERE idVehiculo = '".$idVehiculo."' ";
        $res = $sql->consulta($query);
		$respuesta = "";
		if($res == true )
			$respuesta = "correcto";
		else
			$respuesta = "error";

        return json_encode($respuesta);
                
    }
    
    public function registrarCita($request, $response, $args) { 
    
    	$post = $request->getParsedBody();
    	

    	
    	$idCliente = trim(utf8_decode(str_replace("'","",$post['idCliente'])));
    	$idSucursal = trim(utf8_decode(str_replace("'","",$post['idSucursal'])));
    	$idVehiculo = trim(utf8_decode(str_replace("'","",$post['idVehiculo'])));
    	$idEjecutivo = trim(utf8_decode(str_replace("'","",$post['idEjecutivo'])));
    	$fecha = trim(utf8_decode(str_replace("'","",$post['fecha'])));
    	$hora = trim(utf8_decode(str_replace("'","",$post['hora'])));
    	$servicioTaxi = trim(utf8_decode(str_replace("'","",$post['servicioTaxi'])));
    	$latitudDestino = trim(utf8_decode(str_replace("'","",$post['latitud'])));
    	$longitudDestino = trim(utf8_decode(str_replace("'","",$post['longitud'])));	
    	
    	$conn = mysqli_connect("localhost", "hydracsm_admin", "Admin2016","hydracsm_admin");
    	
        $res_citas = mysqli_query($conn, " SELECT idCita FROM citas WHERE idDpto = '1' AND hora = '".$hora."' AND fechaCita = '".$fecha."' AND idSucursal = '".$idSucursal."' ");

        $respuesta = "";
        if( mysqli_num_rows( $res_citas ) == 0 )
        {
        	if( $idEjecutivo == "" )
        	{  	 
		        $query_ejecutivos = mysqli_query($conn, " SELECT usuarios.idUsuario FROM usuarios, roles WHERE roles.descripcion = 'Ejecutivo' AND roles.idRol = usuarios.idRol AND usuarios.activo = '1' 
		        						 AND usuarios.idSucursal = '".$idSucursal."' ORDER BY usuarios.idUsuario ASC ");
		        if( mysqli_num_rows($query_ejecutivos) == 0 )
		        	$respuesta = "ejecutivo";
		        else
		        {
		        	$contador = 0;
		        	$array = array();
		        	while( $registros_ejecutivos = mysqli_fetch_array($query_ejecutivos) )
		        	{
			        	$array[$contador] = $registros_ejecutivos["idUsuario"];
			        	$contador++;
		        	}
		        	if( $contador == 0 )
		        		$idEjecutivo = $array[0];
		        	else
			        	$idEjecutivo = $array[ rand(0,$contador - 1) ];  
			        	
			    }	
			    
			    $idCita = "";
			    $query_insert = mysqli_query($conn, " INSERT INTO citas (fechaAlta, idUsuario, idCliente, idSucursal, idDpto, idVehiculo, hora, servicioTaxi, fechaCita, origen ) VALUES 
			    				( NOW(), '".$idEjecutivo."', '".$idCliente."', '".$idSucursal."', '1', '".$idVehiculo."', '".$hora."', '".$servicioTaxi."', '".$fecha."', '1' ) ");
			    $idCita = mysqli_insert_id($conn);				

				if($query_insert == true )
				{
					if( $servicioTaxi == 1 )
					{
						$query_folio = mysqli_query($conn, " SELECT serviciosconcita.folio FROM serviciosconcita, citas WHERE serviciosconcita.idCita = citas.idCita AND citas.idSucursal = '".$idSucursal."' ");
						mysqli_query($conn, " INSERT INTO serviciosconcita ( folio, idCita, fechaAlta, idUsuario, choferAsignado, servicioFinalizado, latitudDest, longitudDest ) 
												VALUES ( '". (mysqli_num_rows($query_folio) + 1) ."', '".$idCita."', NOW(), '".$idEjecutivo."', '0', '0', '".$latitudDestino."', '".$longitudDestino."'  )  ");
					}
					$respuesta = "correcto";
				}
					
				else
					$respuesta = "error";			    
			}else
			{
				$idCita = "";
			    $query_insert = mysqli_query($conn, " INSERT INTO citas (fechaAlta, idUsuario, idCliente, idSucursal, idDpto, idVehiculo,  hora, servicioTaxi, fechaCita, origen ) VALUES 
			    				( NOW(), '".$idEjecutivo."', '".$idCliente."', '".$idSucursal."', '1', '".$idVehiculo."', '".$hora."', '".$servicioTaxi."', '".$fecha."', '1' ) ");
			    $idCita = mysqli_insert_id($conn);
				if($query_insert == true )
				{
					if( $servicioTaxi == 1 )
					{
						
						$query_folio = mysqli_query($conn, " SELECT serviciosconcita.folio FROM serviciosconcita, citas WHERE serviciosconcita.idCita = citas.idCita AND citas.idSucursal = '".$idSucursal."' ");
						mysqli_query($conn, " INSERT INTO serviciosconcita ( folio, idCita, fechaAlta, idUsuario, choferAsignado, servicioFinalizado, latitudDest, longitudDest ) 
												VALUES ( '". (mysqli_num_rows($query_folio) + 1) ."', '".$idCita."', NOW(), '".$idEjecutivo."', '0', '0', '".$latitudDestino."', '".$longitudDestino."'  )  ");
					}
					$respuesta = "correcto";
				}
					
				else
					$respuesta = "error";	
			}
		        		           	        
        }else
        {
	        $respuesta = "agendado";
	    }
        
    	
    	return json_encode($respuesta);   
                
    }
    

   public function book ($request, $response) {
      $json = $request->getBody();
      $data = json_decode($json, true);
     $response->write("el resultado es".$data[0]["id"]);
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