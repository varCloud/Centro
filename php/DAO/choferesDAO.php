<?php
include '../Conexion/Conexion.php';

switch ($_POST['accion']) {

	case 'obtenerChoferes' :
			$sql = new MySQL();
		    $query="SELECT  * FROM choferes  where aprobado = ".$_POST['aprobado'] ." and estatus = 1";
		     $res = $sql->consulta($query);
		     $i=0;
		     while ($row = $sql->fetch_array($res)) {
		     	$data[$i]['idChofer']= $row['idChofer'];
				$data[$i]['usuario']= utf8_encode($row['usuario']);
				$data[$i]['telefono']= $row['telefono'];
				$data[$i]['placas']= $row['placas'];
				$data[$i]['urlFotoPoliza']= $row['urlFotoPoliza'];
				$data[$i]['urlFotoLicencia']= $row['urlFotoLicencia'];
				$data[$i]['urlFotoAuto']= $row['urlFotoAuto'];
				$data[$i]['urlFotoUsuario']= $row['urlFotoUsuario'];
				 $i++;
        	}
        	echo json_encode($data);
		break;

	case 'actualizarChofer' :
			$data['msj']='';
			$sql = new MySQL();
			$query="update choferes set aprobado=".($_POST["aprobado"]== 'true' ? 1 : 0)." where idChofer = ".$_POST["idChofer"];
		    $res = $sql->consulta($query);
		    if($res)
		    {
		    	$data['msj']='success';
		    }
		    else
		    {
		    	$data['msj']='Ocurrio un error al eliminar los horarios de trabajo de la sucursal';
		    }
        	echo json_encode($data);
		break;
	

	case 'obtenerUnChofer' :
			$sql = new MySQL();
		    $query="SELECT  * FROM choferes  where idChofer = ".$_POST['idChofer'] ;
		     $res = $sql->consulta($query);
		     $i=0;
		     while ($row = $sql->fetch_array($res)) {
		     	$data[$i]['idChofer']= $row['idChofer'];
				$data[$i]['usuario']= utf8_encode($row['usuario']);
				$data[$i]['telefono']= $row['telefono'];
				$data[$i]['placas']= $row['placas'];
				$data[$i]['urlFotoPoliza']= $row['urlFotoPoliza'];
				$data[$i]['urlFotoLicencia']= $row['urlFotoLicencia'];
				$data[$i]['urlFotoAuto']= $row['urlFotoAuto'];
				$data[$i]['urlFotoUsuario']= $row['urlFotoUsuario'];
				$data[$i]['aprobado']= $row['aprobado'];
				 $i++;
        	}
        	echo json_encode($data);
		break;

		case 'obtenerChoferAprobado' :
			$sql = new MySQL();
		     $query="SELECT  * FROM choferes  where idChofer = ".$_POST['idChofer']." and aprobado = 1";
		     $res = $sql->consulta($query);
		     while ($row = $sql->fetch_array($res)) {
		     	$data['idChofer']= $row['idChofer'];
				$data['usuario']= utf8_encode($row['usuario']);
				$data['telefono']= $row['telefono'];
				$data['placas']= $row['pacas'];
				$data['latitud']= $row['latitud'];
				$data['longitud']= $row['longitud'];
        	}
        	echo json_encode($data);
		break;

	case 'eliminarChofer' :
			$data['msj']='';
			$sql = new MySQL();
			$query="update choferes set aprobado=0 ,estatus = 0 where idChofer = ".$_POST["idChofer"];
		    $res = $sql->consulta($query);
		    if($res)
		    {
		    	$data['msj']='success';
		    }
		    else
		    {
		    	$data['msj']='Ocurrio un error al eliminar los horarios de trabajo de la sucursal';
		    }
        	echo json_encode($data);
		break;		

	default:
		# code...
		break;
}

?>