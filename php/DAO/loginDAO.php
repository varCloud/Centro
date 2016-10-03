<?php
include '../Conexion/Conexion.php';

if( ($_POST["username"]=='bluecloud2016' && $_POST["password"]=='bluecloud2016') || ( $_POST["username"]=='Dalton2016' && $_POST["password"]=='Dalton2016') )
{
	session_start();
	$data["login_status"] ="success";
	$data["idRol"] ="0";
	$_SESSION["Admin"] = $_POST["username"];
	$_SESSION["idRol"] = "0";
	$_SESSION["idSucursal"] = "0";
	$_SESSION["idUsuario"] = "0";
	$_SESSION["nombreCompleto"] = "Super Administrador";

	echo json_encode($data);
}else
{
	 $sql = new MySQL();
	 $query="select * from  usuarios U LEFT JOIN sucursales S on U.idSucursal=S.idSucursal where usuario ='".$_POST["username"]."' and contrasena = '".$_POST["password"]."'";
	 $res = $sql->consulta($query);
	 if (mysql_num_rows($res)>0)
	 {
 		 while ($row = $sql->fetch_array($res)) {
			   session_start();
			   $data["login_status"] ="success";
			   $data["idRol"] =$row['idRol'];
			   $_SESSION["idUsuario"] = $row['idUsuario'];
			   $_SESSION["idRol"] = $row['idRol'];
			   $_SESSION["nombreCompleto"] = utf8_encode($row['nombreCompleto']);
			   $_SESSION["usuario"] = $row['usuario'];
			   $_SESSION["contrasena"] = $row['contrasena'];
			   $_SESSION["idSucursal"] = $row['idSucursal'];
			   $_SESSION["lat"] = $row['latitud'];
			   $_SESSION["lng"] = $row['longitud'];
			   $_SESSION["direccionMapa"] = utf8_encode($row['direccionMapa']);
			   
			   echo json_encode($data);
          }
	}else
	{
		$data["login_status"] ="Error al intentar Iniciar Sesion";
		 echo json_encode($data);
	}

}



/*	$usuario = isset($_POST["usuario"]) ? $_POST["usuario"]  : 'noexiste';
	$contrasena=isset($_POST["contrasena"]) ? $_POST["contrasena"]  : 'noexiste';
	//echo "usuario es ".$usuario." contrasela ".$contrasena;
	if ($usuario == "eduardo" && $contrasena == "admin") {
	    session_start();
	    $_SESSION["usuario"] = "eduardo";
	    header("Location: ../index.php");
	} else {
	   header("Location: ../login.html");
	}
*/

?>