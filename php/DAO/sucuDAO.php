<?php
include '../Conexion/Conexion.php';

switch ($_POST['accion']) {

	case 'guardar':


		    $array = json_decode($_POST['calendario']);
		    $data['msj']='error';
			$folio=0;
			if(is_array($array))
			{
				print_r($array);
			    $sql = new MySQL();
			    $query="INSERT INTO sucursales VALUES('','".$_POST['sucursal']."',".$folio.",".$_POST['tiempoEntreCitas'].",'".$_POST['telefono']."','','','".$_POST['lat']."','".$_POST['lng']."','".utf8_decode($_POST['direccion'])."')";
			    $sql->consulta($query);
			    $idSucursal= mysql_insert_id();
				foreach($array as $obj){
			     	  $query="INSERT INTO horarios VALUES('',". $obj->dia.",".$idSucursal.",".$obj->tipoHorario.",'".$obj->horaMin."','".$obj->horaMax."','".$obj->horaMinOfi."','".$obj->horaMaxOfi."')";
			          $sql->consulta($query);
			          $data['status']=1;

				}
				
			    $query="INSERT INTO dptosxsucursal VALUES('',".$idSucursal.",1,'Servicio',1)";
			    $sql->consulta($query);
				$data['msj']='success';
				
			}else
			{
				$data['msj']='Error';
		
			}
			echo json_encode($data);
	break;

	case 'obtenerUnaSucursal' :

			$sql = new MySQL();
		    $query="SELECT S.*, D.descripcion dia_desc,H.*,T.descripcion horario_desc FROM sucursales S
			inner join horarios H on S.idSucursal= H.idSucursal inner join dias D on D.idDia = H.idDia 
			inner join tipohorarios T on T.idTipoHorario = H.idTipoHorario
			where S.idSucursal=".$_POST['idSucursal']."  order  by H.idDia";
		     $res = $sql->consulta($query);
		     $i=0;
		     while ($row = $sql->fetch_array($res)) {
				$data[$i]['idSucursal']= $row['idSucursal'];
				$data[$i]['descripcion']= $row['descripcion'];
				$data[$i]['telefono']= $row['telefono'];
				$data[$i]['calle']= $row['calle'];
				$data[$i]['colonia']= $row['colonia'];
				$data[$i]['lon']= $row['longitud'];
				$data[$i]['lati']= $row['latitud'];
				$data[$i]['dia_desc']= $row['dia_desc'];
				$data[$i]['idHoraio']= $row['idHorario'];
				$data[$i]['idTipoHorario']= $row['idTipoHorario'];
				$data[$i]['horaMin']= $row['horaMin'];
				$data[$i]['horaMax']= $row['horaMax'];
				$data[$i]['horaMinOfi']= $row['horaMinOfi'];
				$data[$i]['horaMaxOfi']= $row['horaMaxOfi'];
				$data[$i]['horario_desc']= $row['horario_desc'];
				$data[$i]['tiempoEntreCitas']= $row['tiempoEntreCitas'];
				$data[$i]['direccion']= utf8_encode($row['direccionMapa']);
				 $i++;
				
        	}
        	echo json_encode($data);
	break;

	case 'obtenerSucursales' :
			$sql = new MySQL();
		    $query="SELECT  * FROM sucursales S  where idSucursal = COALESCE(".$_POST['idSucursal'].", S.idSucursal)";
		     $res = $sql->consulta($query);
		     $i=0;
		     while ($row = $sql->fetch_array($res)) {
				$data[$i]['idSucursal']= $row['idSucursal'];
				$data[$i]['descripcion']= $row['descripcion'];
				$data[$i]['folio']= $row['folio'];
				$data[$i]['tiempoEntreCitas']= $row['tiempoEntreCitas'];
				 $i++;
				
        	}
        	echo json_encode($data);
		break;

	case 'eliminarSucursal' :
			$data['msj']='Ocurrio un error al eliminar los horarios de trabajo de la sucursal';
			$sql = new MySQL();
			
			$query="call SP_ELIMINAR_SUCURSAL(".$_POST['idSucursal'].")";
		    $sql->consulta($query);
			$data['msj']='success';
        	echo json_encode($data);
		break;
	
	case 'actualizar':
			$array = json_decode($_POST['calendario']);
		    $data['msj']='error';
			if(is_array($array))
			{
			    $sql = new MySQL();
			    $query="UPDATE sucursales set descripcion='".$_POST['sucursal']."', direccionMapa='".utf8_decode($_POST['direccion'])."',tiempoEntreCitas=".$_POST['tiempoEntreCitas']." ,colonia='".$_POST['colonia']."' ,calle='".$_POST['calle']."' ,telefono='".$_POST['telefono']."' ,latitud='".$_POST['lat']."' ,longitud='".$_POST['lng']."' where idSucursal = ".$_POST["idSucursal"]."   ";
			    $row=$sql->consulta($query);
			    if($row)
			    {
			    	$query = "DELETE FROM horarios WHERE idSucursal = ".$_POST["idSucursal"];
			    	$row=$sql->consulta($query);
					foreach($array as $obj){
				     	  $query="INSERT INTO horarios VALUES('',". $obj->dia.",".$_POST["idSucursal"].",".$obj->tipoHorario.",'".$obj->horaMin."','".$obj->horaMax."','".$obj->horaMinOfi."','".$obj->horaMaxOfi."')";
				          $sql->consulta($query);
				          $data['status']=1;

					}
					/*foreach($array as $obj){
				     	  $query="UPDATE horarios set idTipoHorario=".$obj->tipoHorario.", horaMin='".$obj->horaMin."',horaMax='".$obj->horaMax."',horaMinOfi='".$obj->horaMinOfi."',horaMaxOfi='".$obj->horaMaxOfi."' where idDia = ". $obj->dia." and idSucursal = ".$_POST["idSucursal"]."";
				          $sql->consulta($query);
					} EL FOR EACH ES PARA EL CASO DE ACTUALIZAR PERO COMO PUEDEN AGREGAR O QUIETAR DIAS HAY QUE ELIMINAR EL HORARIO QUE YA TENIA ESTABLECIDO*/ 
				}else{
					$data['msj']='Error al actualizar la sucursal';
				}
				$data['msj']='success';
				echo json_encode($data);
			}
			else
			{
				$data['msj']='Error';
				echo json_encode($data);
			}

		break;

	case 'asignarDpto':
		$sql = new MySQL();
		if(is_array($_POST['dptos']))
		{
			$arr_length = count($_POST['dptos']);
			for($i=0;$i<$arr_length;$i++)
			{
					 $query="call SP_INSERTA_RELDPTOS(".$_POST['idSucursal'].", ".$_POST['dptos'][$i].", ".$_POST['valor'][$i].",'".$_POST['descDpto'][$i]."')";
					 $res = $sql->consulta($query);
			}
		}
		$data['msj']='success';
		echo json_encode($data);
	break;
	default:
		# code...
		break;
}

?>