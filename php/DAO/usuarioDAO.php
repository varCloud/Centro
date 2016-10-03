<?php
include '../Conexion/Conexion.php';

switch ($_POST['accion']) {
	case 'obtenerRoles':
 
			    $sql = new MySQL();
			    $query="CALL SP_OBTENER_ROLES_POR_USUARIO(".$_POST['idUsuario'].")";
			    $res= $sql->consulta($query);
				$i=0;
				while ($row = $sql->fetch_array($res)) {
					$data[$i]['idRol']= $row['idRol'];
					$data[$i]['descripcion']= $row['descripcion'];
					$i++;
	        	}
			echo json_encode($data);
		break;

	case 'obtenerUsuarios' :
			$sql = new MySQL();
		    $query="CALL SP_OBTENER_USUARIOS(".$_POST['idSucursal'].",".$_POST['idRol'].")";
		     $res = $sql->consulta($query);
			 $i=0;
			     while ($row = $sql->fetch_array($res)) {
					$data[$i]['idUsuario']= $row['idUsuario'];
					$data[$i]['nombreCompleto']= utf8_encode($row['nombreCompleto']);
					$data[$i]['usuario']= $row['usuario'];
					$data[$i]['sucursal']= $row['descripcion'];
					$data[$i]['rol']= $row['rol'];
					$i++;
	             }
	      echo json_encode($data);
	break;
	
	case 'obtenerUnUsuario' :
			$sql = new MySQL();
		    $query="CALL SP_OBTENER_USUARIO_POR_ID(".$_POST['idUsuario'].")";
		     $res = $sql->consulta($query);
			 while ($row = $sql->fetch_array($res)) {
				$data['idUsuario']= $row['idUsuario'];
				$data['nombreCompleto']= utf8_encode($row['nombreCompleto']);
				$data['usuario']= $row['usuario'];
				$data['contrasena']= $row['contrasena'];
				$data['idSucursal']= $row['idSucursal'];
				$data['idRol']= $row['idRol'];
			 }
	      echo json_encode($data);
	break;
	
	case 'obtenerSucursales' :
			$sql = new MySQL();
		    $query="CALL SP_OBTENER_SUCURSALES ()";
		     $res = $sql->consulta($query);
			 $i=0;
			     while ($row = $sql->fetch_array($res)) {
					$data[$i]['idSucursal']= $row['idSucursal'];
					$data[$i]['descripcion']= $row['descripcion'];
					$i++;
	             }
	      echo json_encode($data);
	break;

	case 'guardarUsuario' :
			$sql = new MySQL();
		    $query="CALL SP_INSERTA_USUARIO (".$_POST['cbRoles'].",'".utf8_decode($_POST['nombre'])."','".utf8_decode($_POST['usuario'])."',  
			'".$_POST['contra']."',".$_POST['cbSucursal'].",".$_POST['idUsuarioEditar'].")";
		     $res = $sql->consulta($query);
			 if($res)
			 	$data['msj']= 'success';
			else
				$data['msj']='error';
		
	      echo json_encode($data);
	break;
	
	case 'EliminarUsuario':
			$sql = new MySQL();
		    $query="CALL SP_ELIMINAR_USUARIO_POR_ID (".$_POST['idUsuario'].")";
		     $res = $sql->consulta($query);
			 if($res)
			 	$data['msj']= 'success';
			else
				$data['msj']='error';
			
	      echo json_encode($data);
	break;

	
				

	default:
		# code...
		break;
}

?>