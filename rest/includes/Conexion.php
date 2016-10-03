<?php
// si existe algun error hay que acivar las siguientes lineas en el php.ini del servidor  extension:dir= "C:\php\ext"
// y extension = php_mysql.dll
class MySQL {

    private $conexion;
    private $total_consultas;

    public function MySQL() {
        if (!isset($this->conexion)) {
             $this->conexion = (mysql_connect("localhost", "taddibri_Copias", "victor90"))
  //$this->conexion = (mysql_connect("localhost", "eespecom_jesus", "ApwA@S8kN9;C"))
//            $this->conexion = (mysql_connect("mysql2.000webhost.com", "a9832149_barcasa", "adrian1987"))
                    or die(mysql_error());
          //  mysql_select_db("eespecom_espe", $this->conexion) or die(mysql_error());
            mysql_select_db("taddibri_cc", $this->conexion);
//            mysql_select_db("a9832149_barcasa", $this->conexion) or die(mysql_error());
        }
    }

    public function consulta($consulta) {
        $this->total_consultas++;
        $resultado = mysql_query($consulta, $this->conexion);
        if (!$resultado) {
            echo 'MySQL Error: ' . mysql_error();
            //exit;
        }
        return $resultado;
    }


    public function fetch_array($consulta) {
        return mysql_fetch_array($consulta);
    }

    public function num_rows($consulta) {
        return mysql_num_rows($consulta);
    }

    public function getTotalConsultas() {
        return $this->total_consultas;
    }

}

?>