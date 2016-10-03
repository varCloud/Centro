<?php


	 function nombreDia($dia)
	{
		if( $dia ==  "Mon" )
			$dia = "Lunes";
		if( $dia ==  "Tue" )
			$dia = "Martes";
		if( $dia ==  "Wed" )
			$dia = "Miércoles";
		if( $dia ==  "Thu" )
			$dia = "Jueves";
		if( $dia ==  "Fri" )
			$dia = "Viernes";
		if( $dia ==  "Sat" )
			$dia = "Sábado";
		if( $dia ==  "Sun" )
			$dia = "Domingo";
			
		return $dia;
	}
	
	 function nombreMes($mes)
	{
		if( $mes ==  "Jan" )
			$mes = "Enero";
		if( $mes ==  "Feb" )
			$mes = "Febrero";
		if( $mes ==  "Mar" )
			$mes = "Marzo";
		if( $mes ==  "Apr" )
			$mes = "Abril";
		if( $mes ==  "May" )
			$mes = "Mayo";
		if( $mes ==  "Jun" )
			$mes = "Junio";
		if( $mes ==  "Jul" )
			$mes = "Julio";
		if( $mes ==  "Aug" )
			$mes = "Agosto";
		if( $mes ==  "Sep" )
			$mes = "Septiembre";
		if( $mes ==  "Oct" )
			$mes = "Octubre";
		if( $mes ==  "Nov" )
			$mes = "Noviembre";
		if( $mes ==  "Dec" )
			$mes = "Diciembre";
			
		return $mes;
	}

?>