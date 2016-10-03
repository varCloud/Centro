<?php
include '../Conexion/Conexion.php';

switch ($_POST['accion']) {

	case 'guardar':

		    $sql = new MySQL();
		    $query="INSERT INTO dptosgenerales VALUES('','".$_POST['dpto']."','".$_POST['telefono']."',1)";
		    $sql->consulta($query);
		    $data['msj']='success';
		    echo json_encode($data);

		break;

	case 'obtenerUnDpto' :

			$sql = new MySQL();
		    $query="SELECT * from dptosgenerales where idDpto=".$_POST['idDpto'];
		     $res = $sql->consulta($query);
		     $i=0;
		     while ($row = $sql->fetch_array($res)) {
				$data['idDpto']= $row['idDpto'];
				$data['descripcion']= utf8_encode($row['descripcion']);
				$data['telefono']= $row['telefono'];
			 $i++;
				
        	}
        	echo json_encode($data);
	break;

	case 'obtenerDepartamentos' :
			$sql = new MySQL();
		    $query="SELECT  S.idSucursal, S.descripcion as desc_sucursal,D.* FROM dptosgenerales  
			D LEFT JOIN relsucursalesdptos RSC on D.idDpto = RSC.idDpto  LEFT JOIN sucursales S 
			on S.idSucursal = RSC.idSucursal where D.activo=1 ";
		     $res = $sql->consulta($query);
		     $i=0;
		     while ($row = $sql->fetch_array($res)) {
				$data[$i]['idDpto']= $row['idDpto'];
				$data[$i]['descripcion']= utf8_encode($row['descripcion']);
				$data[$i]['telefono']= $row['telefono'];
				$data[$i]['desc_sucursal']= $row['desc_sucursal'];
				$data[$i]['idSucursal']= $row['idSucursal'];
				 $i++;
        	}
        	echo json_encode($data);
		break;

	case 'obtenerDptosXsucursal' :
			$sql = new MySQL();
		    $query="CALL SP_OBTENER_DPTOS_X_SUCURSAL(".$_POST["idSucursal"].")";
		     $res = $sql->consulta($query);
		     $i=0;
		     while ($row = $sql->fetch_array($res)) 
			 {
				$data[$i]['idDpto']= $row['idDpto'];
				$data[$i]['descripcion']= utf8_encode($row['descripcion']);
				$data[$i]['activo']= utf8_decode($row['activo']);
				$i++;
        	}
        	echo json_encode($data);
		break;

	case 'actualizarDpto':
			$data['msj']='';
			$sql = new MySQL();
			$query="UPDATE dptosgenerales set descripcion='".$_POST['dpto']."',telefono='".$_POST['telefono']."' where idDpto=".$_POST['idDpto'];
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

	case 'bajaLogicaDpto' :
		$data['msj']='';
		$sql = new MySQL();
		$query="update dptosgenerales set activo =".$_POST['activo']." where idDpto=".$_POST['idDpto'];
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