<?php
include '../Conexion/Conexion.php';

switch ($_POST['accion']) {

	case 'guardar':

		    $array = json_decode($_POST['imgProyecto']);
		    $data['msj']='error';
			$folio=0;
			if(is_array($array))
			{

			    $sql = new MySQL();
			    $query=" CALL SP_GUARDAR_PROYECTOS ('".utf8_decode($_POST['titulo'])."','".utf8_decode($_POST['descripcion'])."','".utf8_decode($_POST['direccion'])."','".$_POST['urlImagen']."','".$_POST['lat']."','".$_POST['lng']."','".$_POST['face']."','".$_POST['google']."','".$_POST['tuiter']."','".$_POST['inst']."')";
			    $res=$sql->query($query);
				if($res->num_rows > 0) 
				{
					$idActual = 0;
					
					while ($row = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
						    $idActual= $row['idActual'];

					}  	
					$res->close();
                    //$sql->next_result();				
					$sql = new MySQL();
					foreach($array as $obj){
				     	 $query="call  SP_GUARDA_IMG_PROYECTOS(".$idActual.", '".$obj->url."','".$obj->name."','".$obj->size."','".$obj->thumbnailUrl."','".$obj->deleteUrl."','".$obj->deleteType."')";
				          $sql->query($query);
				          $data['msj']="ok";
				      }
				}else
				 	$resul['msj']='Error al ejecutar SP_GUARDAR_PROYECTOS';
				
			}else
			{
				$data['msj']='Error la variable no es arrary';
		
			}
			echo json_encode($data);
	break;

	case 'obtenerProyectos' :

			 $sql = new MySQL();

		     $query=" call SP_OBTENER_PROYECTOS(".$_POST['idProyecto'].")";
		     $res = $sql->query($query);
		     $i=0;
		     while ($row = mysqli_fetch_array($res)) {
				$data[$i]['idProyecto']= $row['idProyecto'];
				$data[$i]['titulo']=utf8_encode($row['titulo']);
				$data[$i]['descripcion']= utf8_encode($row['descripcion']);
				$data[$i]['urlImagenPrincipal']= $row['urlImagenPrincipal'];
				$data[$i]['lon']= $row['longitud'];
				$data[$i]['lati']= $row['latitud'];
				$data[$i]['urlFacebook']= $row['urlFacebook'];
				$data[$i]['urlGooglePlus']= $row['urlGooglePlus'];
				$data[$i]['urlInstagram']= $row['urlInstagram'];
				$data[$i]['urlTwitter']= $row['urlTwitter'];
				$data[$i]['direccion']= utf8_encode($row['direccion']);
				$dbImgs = new MySQL();
				$resImgs = $dbImgs->query("CALL SP_OBTENER_IMG_PROYECTOS(".$data[$i]['idProyecto'].")");
			    $iImgs=0;
				 while ($rowImg = mysqli_fetch_array($resImgs)) {

				 		$img[$iImgs]['name']=$rowImg['name'];
				 		$img[$iImgs]['size']=$rowImg['size'];
				 		$img[$iImgs]['url']=$rowImg['url'];
				 		$img[$iImgs]['thumbnailUrl']=$rowImg['thumbnailUrl'];
				 		$img[$iImgs]['deleteUrl']=$rowImg['deleteUrl'];
				 		$img[$iImgs]['deleteType']=$rowImg['deleteType'];
				 		$iImgs++;

				 }
				 
				 $age = array("files"=>$img);
				 $data[$i]['files']=$age;
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

	case 'eliminarProyecto' :
			$sql = new MySQL();
			$query="call SP_ELIMINAR_PROYECTO(".$_POST['idProyecto'].")";
		    $sql->query($query);
			$data['msj']="ok";
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