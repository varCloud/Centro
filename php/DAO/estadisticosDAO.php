<?php
include '../Conexion/Conexion.php';
switch ($_POST['accion']) {
	
		case 'obtenerInformacion' :
		$filtro = json_decode($_POST["filtro"]);
			$sql = new MySQL();
		    $query="call SP_GENERA_ESTADISTICOS(".$filtro->tipoInformacion.",".$filtro->idSucursal.",".$filtro->idEjecutivo.",
			'".$filtro->fechaInicio."','".$filtro->fechaFin."',".$filtro->idChofer.",".$filtro->idEstadoServicio.",".$filtro->conCita.")";
			$res = $sql->consulta($query);
		     $i=0;
		     while ($row = $sql->fetch_array($res)) {
				//$data[$i]['idServicio']= $row['idServicio'];
				$data[$i]['nombreCompleto']= utf8_encode($row['nombreCompleto']);
				$data[$i]['vehiculoDescripcion']= utf8_encode($row['vehiculoDescripcion']);
				$data[$i]['placas']= $row['placas'];
				$data[$i]['usuarioNombre']= utf8_encode($row['usuarioNombre']); 
				if($filtro->tipoInformacion == '1')
				{
					$data[$i]['usuario']= utf8_encode($row['usuario']);
					$data[$i]['idChofer']= $row['idChofer'];
					$data[$i]['servicioFinalizado']= $row['servicioFinalizado'];
					$data[$i]['noOrden']= $row['noOrden'];
					$data[$i]['origen']= utf8_encode($row['origen']);
					$data[$i]['destino']= utf8_encode($row['destino']);
					$data[$i]['fecha']= $row['fechaServ'];
					$data[$i]['nombreEje']= utf8_encode($row['nombreEje']);
				}else{
						$data[$i]['origen']= $row['origen'];
						$data[$i]['fechaCita']= $row['fechaCita']." ".$row['hora'];
				}
				$i++;
        	}
        	echo json_encode($data);
			
		break;

	
		case 'obtenerServiciosActivos' :
		$filtro = json_decode($_POST["filtro"]);
			$sql = new MySQL();
		    $query="call SP_OBTENER_SERVICIOS_ACTIVOS(".$filtro->idUsuario.",".$filtro->idSucursal.",'".$filtro->fechaInicio."','".$filtro->fechaFin."')";
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
		
case 'insertaServicio':
			$sql = new MySQL();
			$data['msj']='ERROR';
		    $query="call SP_INSERTA_SERVICIO(".$_POST['idChofer'].",'".$_POST['noOrden']."' ,".$_POST['idUsuario'].",".$_POST['idSucursal']." 
					,'".$_POST['nombreCompleto']."' ,'".$_POST['descripcionVehiculo']."' ,'".$_POST['distancia']."','".$_POST['latOr']."'	
					,'".$_POST['lnOr']."','".$_POST['latDest']."','".$_POST['lngDest']."','".utf8_decode($_POST['origen'])."'
					,'".utf8_decode($_POST['destino'])."',".$_POST['idServicio'].")";
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
				$i++;
        	}
        	echo json_encode($data);	
	
	break;
	
	case 'ObtenerChoferes' :
			$sql = new MySQL();
		    $query="call SP_OBETENER_CHOFERES()";
		    $res = $sql->consulta($query);
		     $i=0;
		     while ($row = $sql->fetch_array($res)) {

				$data[$i]['idChofer']= $row['idChofer'];
				$data[$i]['usuario']= utf8_encode($row['usuario']);
				//$data[$i]['vehiculoDescripcion']= utf8_encode($row['vehiculoDescripcion']);
				$i++;
        	}
    echo json_encode($data);	
	
	break;
	
	

	default:
		# code...
		break;
}

?>