<?php
include '../Conexion/Conexion.php';

switch ($_POST['accion']) {


	case 'obtenerUnCliente' :

			$sql = new MySQL();
		    $query="SELECT * FROM clientes C inner join vehiculos V on C.idCliente = V.idCliente where C.idCliente=".$_POST['idCliente']." order by C.fechaAlta ";
		     $res = $sql->consulta($query);
		     $i=0;
		     if(mysql_num_rows($res)>0)
		     {
		     	$dataArre['estatus']=1;
			     $dataArre['Vehiculo'] = array();
			     while ($row = $sql->fetch_array($res)) {

					$data['idVehiculo']= $row['idVehiculo'];
					$data['marca']= $row['marca'];
					$data['modelo']= $row['modelo'];
					$data['ano']= $row['ano'];
					$data['placas']= $row['placas'];
					$dataArre['Vehiculo'][$i]= $data;
					$i++;
	        	}
	             
	        	 mysql_data_seek($res,0);
	        	 $row = $sql->fetch_array($res);
	        	 $dataArre['idVehiculo'] =  $row['idVehiculo'];
	        	 $dataArre['idCliente']= $row['idCliente'];
				 $dataArre['nombreCompleto']= utf8_encode($row['nombreCompleto']);
				 $dataArre['mail']= $row['mail'];
				 $dataArre['usuario']= $row['usuario'];
				 $dataArre['fechaAlta']= $row['fechaAlta'];
	        	 echo json_encode($dataArre);
	          }else
	           {
	              $dataArre['estatus']=0;
	           	  $dataArre['msj']='No existen  vehiculos registrados en este cliente';
	           	   echo json_encode($dataArre);
	           }
	break;

	case 'obtenerClientes' :
			$sql = new MySQL();
		    $query="SELECT  * FROM clientes where activo=".$_POST['acitvo'];
		    $res = $sql->consulta($query);
		     $i=0;
		     while ($row = $sql->fetch_array($res)) {

				$data[$i]['idCliente']= $row['idCliente'];
				$data[$i]['nombreCompleto']= utf8_encode($row['nombreCompleto']);
				$data[$i]['mail']= $row['mail'];
				$data[$i]['usuario']= $row['usuario'];
				$data[$i]['fechaAlta']= $row['fechaAlta'];
				$i++;
        	}
        	echo json_encode($data);
		break;

	case 'bajaLogicaCliente' :
			$data['msj']='';
			$sql = new MySQL();
			$query="update clientes set activo =".$_POST['activo']." where idCliente=".$_POST['idCliente'];
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
	
	case 'actualizarCliente':
		$sql = new MySQL();
		$query="UPDATE clientes set nombreCompleto='".utf8_decode($_POST['nombre'])."',mail='".$_POST['mail']."' where idCliente = ".$_POST["idCliente"]."";
		$row=$sql->consulta($query);
		if($row)
			$data['msj']='success';
		else

		$data['msj']='Error';
			echo json_encode($data);
		break;

	case 'guardarCliente':
		$sql = new MySQL();
		$query="call SP_INSERTA_CLIENTE('".utf8_decode($_POST["nombre"])."','".$_POST['telefono']."','".$_POST['modelo']."','".$_POST['marca']."','".$_POST['ano']."','".$_POST['placas']."','".$_POST['mail']."')";
		$res=$sql->consulta($query);	
		$data['msj']='success';
		echo json_encode($data);
	break;

	default:
		# code...
		break;
}

?>