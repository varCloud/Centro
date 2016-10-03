<?php
include '../Conexion/Conexion.php';

switch ($_POST['accion']) {
	
		case 'obtenerServicios' :
		$filtro = json_decode($_POST["filtro"]);
			$sql = new MySQL();
		    $query="call SP_OBTENER_SERVICIOS(".$filtro->idUsuario.",".$filtro->idSucursal.",'".$filtro->fechaInicio."','".$filtro->fechaFin."')";
			$res = $sql->consulta($query);
		     $i=0;
		     while ($row = $sql->fetch_array($res)) {

				$data[$i]['idServicio']= $row['idServicio'];
				$data[$i]['nombreCompleto']= utf8_encode($row['nombreCompleto']);
				$data[$i]['vehiculoDescripcion']= utf8_encode($row['vehiculoDescripcion']);
				$data[$i]['latitud']= $row['latitud'];
				$data[$i]['longitud']= $row['longitud'];
				$data[$i]['placas']= $row['placas'];
				$data[$i]['origen']= $row['origenAlta'];
				$data[$i]['fechaCita']= $row['fechaCita'];
				$data[$i]['nombreEje']= $row['nombreEje'];
				
				$i++;
        	}
        	echo json_encode($data);
			
		break;

	
		case 'obtenerServiciosActivos' :
		$filtro = json_decode($_POST["filtro"]);
			$sql = new MySQL();
		    $query="call SP_OBTENER_SERVICIOS_ACTIVOS_Y_FINALIZADOS(".$filtro->idUsuario.",".$filtro->idSucursal.",'".$filtro->fechaInicio."','".$filtro->fechaFin."','null')";
			$res = $sql->consulta($query);
		     $i=0;
		     while ($row = $sql->fetch_array($res)) {

				$data[$i]['idServicio']= $row['idServicio'];
				$data[$i]['nombreCompleto']= utf8_encode($row['nombreCompleto']);
				$data[$i]['vehiculoDescripcion']= utf8_encode($row['vehiculoDescripcion']);
				$data[$i]['idChofer']= $row['idChofer'];
				$data[$i]['longitud']= $row['longitud'];
				$data[$i]['placas']= $row['placas'];
				$data[$i]['origen']= $row['origen'];
				$data[$i]['usuario']= $row['usuario'];
				$i++;
        	}
        	echo json_encode($data);
			
		break;
		
		case 'obtenerServiciosActivosDisntancias' :
		$filtro = json_decode($_POST["filtro"]);
			$sql = new MySQL();
		    $query="call SP_OBTENER_SERVICIOS_ACTIVOS_Y_FINALIZADOS(".$filtro->idUsuario.",".$filtro->idSucursal.",'".$filtro->fechaInicio."','".$filtro->fechaFin."','null')";
			$res = $sql->consulta($query);
		     $i=0;
		     while ($row = $sql->fetch_array($res)) {

				$data[$i]['idServicio']= $row['idServicio'];
				$data[$i]['nombreCompleto']= utf8_encode($row['nombreCompleto']);
				$data[$i]['vehiculoDescripcion']= utf8_encode($row['vehiculoDescripcion']);
				$data[$i]['idChofer']= $row['idChofer'];
				//$data[$i]['latitud']= $row['latitud'];
				//$data[$i]['longitud']= $row['longitud'];
				$data[$i]['placas']= $row['placas'];
				$data[$i]['origen']= $row['origen'];
				$data[$i]['usuario']= utf8_encode($row['usuario']);
				$data[$i]['distancia']=harvestine($row['latitudOr'],$row['longitudOr'],$row['latChofer'],$row['lngChofer'])." Km" ;
				$i++;
        	}
        	echo json_encode($data);
		break;
		
		
		case 'obtenerServiciosFinalizados' :
		$filtro = json_decode($_POST["filtro"]);
		$servicioFinalizado = 1;
			$sql = new MySQL();
		    $query="call SP_OBTENER_SERVICIOS_ACTIVOS_Y_FINALIZADOS(".$filtro->idUsuario.",".$filtro->idSucursal.",'".$filtro->fechaInicio."','".$filtro->fechaFin."',".$servicioFinalizado.")";
			$res = $sql->consulta($query);
		     $i=0;
		     while ($row = $sql->fetch_array($res)) {

				$data[$i]['idServicio']= $row['idServicio'];
				$data[$i]['nombreCompleto']= utf8_encode($row['nombreCompleto']);
				$data[$i]['vehiculoDescripcion']= utf8_encode($row['vehiculoDescripcion']);
				$data[$i]['idChofer']= $row['idChofer'];
				$data[$i]['latitud']= $row['latitud'];
				$data[$i]['longitud']= $row['longitud'];
				$data[$i]['placas']= $row['placas'];
				$data[$i]['origen']= utf8_encode($row['origen']);
				$data[$i]['origenAlta']= $row['origenAlta'];
				$data[$i]['destino']= utf8_encode($row['destino']);
				$data[$i]['distancia']= utf8_encode($row['distancia']);
				$data[$i]['usuario']= utf8_encode($row['usuario']);
				$i++;
        	}
        	echo json_encode($data);
			
		break;		
		
		case 'insertaServicio':
			$sql = new MySQL();
			$data['msj']='ERROR';
		    $query="call SP_INSERTA_SERVICIO(".$_POST['idChofer'].",'".$_POST['noOrden']."' ,".$_POST['idUsuario'].",".$_POST['idSucursal']." 
					,'".$_POST['nombreCompleto']."' ,'".$_POST['descripcionVehiculo']."' ,'".$_POST['distancia']."','".$_POST['latOr']."'	
					,'".$_POST['lnOr']."','".$_POST['latDest']."','".$_POST['lngDest']."','".utf8_decode($_POST['origen'])."'
					,'".utf8_decode($_POST['destino'])."',".$_POST['idServicio'].",'".$_POST['placas']."')";
			$sql->consulta($query);
     	    $data['msj']='success';
     	    
     	    
			 echo json_encode($data);
		break;
		
	case 'ObtenerUnServicio' :
			$sql = new MySQL();
		    $query="call SP_OBTENER_SERVICIO_POR_ID(".$_POST['idServicio'].",".$_POST['caso'].")";
		    $res = $sql->consulta($query);
		     $i=0;
		     while ($row = $sql->fetch_array($res)) {

				$data[$i]['idServicio']= $row['idServicio'];
				$data[$i]['nombreCompleto']= utf8_encode($row['nombreCompleto']);
				$data[$i]['vehiculoDescripcion']= utf8_encode($row['vehiculoDescripcion']);
				$data[$i]['latDest']= utf8_encode($row['latitudDest']);
				$data[$i]['lngDest']= utf8_encode($row['longitudDest']);
				$data[$i]['placas']= utf8_encode($row['placas']);
				$i++;
        	}
        	echo json_encode($data);	
	
	break;
	default:
		# code...
		break;
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