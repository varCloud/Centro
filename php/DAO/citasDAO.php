<?php
include '../Conexion/Conexion.php';

switch ($_POST['accion']) {


	case 'obtenerHorasDisponibles':
		$sql = new MySQL();
		$query="call SP_OBTENER_HORAS_DISPONIBLES(".$_POST["idSucursal"].",".$_POST['idDia'].",'".$_POST['fecha']."',".$_POST['idDpto'].")";
		$res=$sql->consulta($query);
		$i=0;
		while ($row = $sql->fetch_array($res)) {
				$data[$i]['horas']= $row['horas'];
				$i++;		
		}
		echo json_encode($data);
		break;

	case 'guardarCita':
		$sql = new MySQL();
		$query="call SP_INSERTA_CITA(".$_POST["cbEjecutivos"].",".$_POST['cbClientes'].",".$_POST['idSucursal'].",
		".$_POST['idDpto'].",".$_POST['cbVehiculos'].",'".$_POST['cbHoras']."','".$_POST['diaCita']."',
		".$_POST['requiereServicio'].",".$_POST['esActualizacion'].")";
		//echo $query;
		$sql->consulta($query);
		$data['msj']= 'success';
		echo json_encode($data);	
	break;

	case 'obtenerCitas':
		$sql = new MySQL();
		$filtro = json_decode($_POST["filtro"]);
		 
		//$query="call SP_OBTENER_CITAS_X_USUARIO(".$filtro->idUsuario.",'".$filtro->fechaInicio."','".$filtro->fechaFin."'
		//				,".$filtro->idSucursal.",".$filtro->idRol.", ".$filtro->idEjecutivo.")";
		//echo $query;
		$query = "call SP_OBTENER_CITAS (".$filtro->idUsuario.",'".$filtro->fechaInicio."','".$filtro->fechaFin."',".$filtro->idSucursal.")";
		$res=$sql->consulta($query);
		$i=0;
		while ($row = $sql->fetch_array($res)) {
			    $data[$i]['idCita']= $row['idCita'];
				$data[$i]['idCliente']= $row['idCliente'];
				$data[$i]['idVehiculo']= $row['idVehiculo'];
				$data[$i]['fechaCita']= $row['fechaCita'].' '.$row['hora'];
				$data[$i]['nombreCompleto']= utf8_encode($row['nombreCompleto']);
				$data[$i]['vehiculo']= utf8_encode($row['vehiculo']);
				$data[$i]['origen']= $row['origen'];
				$data[$i]['servicioTaxi']= $row['servicioTaxi'];
				$data[$i]['placas']= $row['placas'];
				$data[$i]['nombreEje']=utf8_encode($row['nombreEje']);
				$i++;		
		}
		echo json_encode($data);
	break;

	case 'eliminarCita' :
		$sql = new MySQL();
		$query="call SP_ELIMINAR_CITA(".$_POST["idCita"].")";
		$res=$sql->consulta($query);
		if($res)
			$data['msj'] = 'success';
		else
			$data['msj'] = 'error';
		echo json_encode($data);	
	break;
	
	
	case 'obtenerCitasXDia':
		$sql = new MySQL();
		$query="call SP_ESTADISTICOS_CITAS_X_DIA()";
		//echo $query;
		$res=$sql->consulta($query);
		$i=0;
		while ($row = $sql->fetch_array($res)) {
			    $data[$i]['idSucursal']= $row['idSucursal'];
				$data[$i]['descripcion']= $row['descripcion'];
				$data[$i]['total']= $row['total'];
				$i++;		
		}
		echo json_encode($data);
	break;

	default:
		# code...
		break;
}

?>