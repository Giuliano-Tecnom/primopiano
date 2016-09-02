<?php
error_reporting(-1);
require_once("config.inc.php");

function fecha ($valor)
{
	$timer = explode(" ",$valor);
	$fecha = explode("-",$timer[0]);
	$fechex = $fecha[2]."/".$fecha[1]."/".$fecha[0];
	return $fechex;
}

function buscar_en_array($fecha,$array)
{
	$total_eventos=count($array);
	for($e=0;$e<$total_eventos;$e++)
	{
		if ($array[$e]["fecha"]==$fecha) return true;
	}
}
$nombreDiasSemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");

switch ($_GET["accion"])
{
	case "listar_evento":
	{
		$query=$db->query("select * from ".$tabla." where dia='".$_GET["fecha"]."' order by hora asc");
		if ($fila=$query->fetch_array())
		{
			
			echo'  <div class="container" style="width:50%">
					  <div class="panel-group" id="accordion" >';
			do{
				$cuantos=$db->query("select count(*) as cantidad  from claseusuario where idClase='".$fila["idClase"]."'");
				$cuantosResult=$cuantos->fetch_array();
				//quienes estan inscriptos por clase
					$inscriptos=$db->query("select nombreCompleto, apellido  from claseusuario inner join datosusuario on claseusuario.idUsuario= datosusuario.idUsuario where idClase='".$fila["idClase"]."'");
					$result=$inscriptos->fetch_array();
					echo'    <div class="panel panel-default">
								  <div class="panel-heading" >
									<h4 class="panel-title">
									  <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$fila["idClase"].'">Clase Funcional '.$fila["hora"].' Hs. Inscriptos al momento: '.$cuantosResult["cantidad"]. '</a>
									</h4>
								  </div>
								  <div id="collapse'.$fila["idClase"].'" class="panel-collapse collapse">
									<div class="panel-body">
									<ul class="list-group">';
					
					//$result = $inscriptos->fetch_array();
					if ($result)
					{
					do{
						echo '<li class="list-group-item">'.$result["nombreCompleto"].' '.$result["apellido"].'</li>';
					}
					while($result=$inscriptos->fetch_array());
					}
					echo'</ul>
									</div>
								  </div>
								</div>';
			
			}
			while($fila=$query->fetch_array());
			 echo'</div>
			    </div>';
		}
		break;
	}

	case "guardar_evento":
	{
		$fecha = new \DateTime('now', new \DateTimeZone('America/Argentina/Buenos_Aires'));	
		$fechaHora = date_format($fecha, 'H');
		$clase=$db->query("select * from clase where idClase='".$_GET["idClase"]."'");
		$resultadoClase=$clase->fetch_array();
		if(!(intval($fechaHora)<($resultadoClase["hora"]-1)) && $nombreDiasSemana[idate("w")]==$resultadoClase["dia"])
		{
			echo "<p class='error'>Se termino horario inscripcion.</p>";
		}
	    else{
		$query=$db->query("insert into claseusuario (idClase,idUsuario) values ('".$_GET["idClase"]."','".$_GET["idUsuario"]."')");
		if ($query) echo "<p class='ok'>Se ha inscripto correctamente.</p>";
		else echo "<p class='error'>Se ha producido un error guardando el evento.</p>";
		}
		break;
	}
	case "borrar_evento":
	{
		$query=$db->query("delete from claseusuario where idClase='".$_GET["id"]."' and idUsuario='".$_GET['idUsuario']."' limit 1");
		if ($query) echo "<p class='ok'>Se ha desinscripto correctamente.</p>";
		else echo "<p class='error'>Se ha producido un error eliminando el evento.</p>";
		break;
	}

	case "generar_calendario":
	{
		$fecha_calendario=array();
		if ($_GET["mes"]=="" || $_GET["anio"]=="") 
		{
			$fecha_calendario[1]=intval(date("m"));
			if ($fecha_calendario[1]<10) $fecha_calendario[1]="0".$fecha_calendario[1];
			$fecha_calendario[0]=date("Y");
		} 
		else 
		{
			$fecha_calendario[1]=intval($_GET["mes"]);
			if ($fecha_calendario[1]<10) $fecha_calendario[1]="0".$fecha_calendario[1];
			else $fecha_calendario[1]=$fecha_calendario[1];
			$fecha_calendario[0]=$_GET["anio"];
		}
		$fecha_calendario[2]="01";
		
		/* obtenemos el dia de la semana del 1 del mes actual */
		$primeromes=date("N",mktime(0,0,0,$fecha_calendario[1],1,$fecha_calendario[0]));
			
		/* comprobamos si el año es bisiesto y creamos array de días */
		if (($fecha_calendario[0] % 4 == 0) && (($fecha_calendario[0] % 100 != 0) || ($fecha_calendario[0] % 400 == 0))) $dias=array("","31","29","31","30","31","30","31","31","30","31","30","31");
		else $dias=array("","31","28","31","30","31","30","31","31","30","31","30","31");
		
		$eventos=array();
		$query=$db->query("select dia,count(idClase) as total from clase group by dia");
		if ($fila=$query->fetch_array())
		{
			do
			{
				$eventos[$fila["dia"]]=$fila["total"];
			}
			while($fila=$query->fetch_array());
		}
		
		$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		
		/* calculamos los días de la semana anterior al día 1 del mes en curso */
		$diasantes=$primeromes-1;
		
        
		
		/* los días totales de la tabla siempre serán máximo 42 (7 días x 6 filas máximo) */
		$diasdespues=42;
			
		/* calculamos las filas de la tabla */
		$tope=$dias[intval($fecha_calendario[1])]+$diasantes;
		if ($tope%7!=0) $totalfilas=intval(($tope/7)+1);
		else $totalfilas=intval(($tope/7));
			
 		$mesanterior=date("Y-m-d",mktime(0,0,0,$fecha_calendario[1]-1,01,$fecha_calendario[0]));
		$messiguiente=date("Y-m-d",mktime(0,0,0,$fecha_calendario[1]+1,01,$fecha_calendario[0]));
		/* empezamos a pintar la tabla */
		/*echo '<div class="cal1"><div class="clndr"><div class="clndr-controls">
							<div class="clndr-control-button">
								<p class="clndr-previous-button"><a href="#" rel="'.$mesanterior.'"></a></p>
							</div>
							<div class="month">'.$meses[intval($fecha_calendario[1])].' '.$fecha_calendario[0].'</div>
							<div class="clndr-control-button rightalign">
								<p class="clndr-next-button">next</p>
							</div>
						</div>
						</div>
						</div>';*/
		//echo "<div class='row'><h2>&laquo; <a href='#' rel='$mesanterior' class='anterior'>&#8592;</a></h2><h2>".$meses[intval($fecha_calendario[1])]." de ".$fecha_calendario[0]." <p><a href='#' class='siguiente' rel='$messiguiente'>&#8594;</a> &raquo;</p><abbr title='S&oacute;lo se pueden agregar eventos en d&iacute;as h&aacute;biles y en fechas futuras (o la fecha actual).'></abbr></h2></div>";
						echo "<div class='myheader'><h4>&laquo; <a href='#' rel='$mesanterior' class='anterior'>&#8592;</a>".$meses[intval($fecha_calendario[1])]." de ".$fecha_calendario[0]." <a href='#' class='siguiente' rel='$messiguiente'>&#8594;</a> &raquo;</h4></div>";
		if (isset($mostrar)) echo $mostrar;
			
		echo "<table class='calendario' cellspacing='0' cellpadding='0'>";
			echo "<tr  style='font-size: 1.4em;'><th>Lunes</th><th>Martes</th><th>Mi&eacute;rcoles</th><th>Jueves</th><th>Viernes</th><th>S&aacute;bado</th><th>Domingo</th></tr><tr>";
			
			/* inicializamos filas de la tabla */
			$tr=0;
			$dia=1;
			
			function es_finde($fecha)
			{
				$cortamos=explode("-",$fecha);
				$dia=$cortamos[2];
				$mes=$cortamos[1];
				$ano=$cortamos[0];
				$fue=date("w",mktime(0,0,0,$mes,$dia,$ano));
				if (intval($fue)==0) return true;
				else return false;
			}
			
			function puedo_inscribirme($fecha)
			{
				$cortamos=explode("-",$fecha);
				$dia=$cortamos[2];
				$mes=$cortamos[1];
				$ano=$cortamos[0];
				$numSemanaHoy = date("W") - date("W",strtotime(date("Y-m-d"))) + 1;
				$numSemanaDia = date("W") - date("W",strtotime($fecha)) + 1;
				//fue domingo
				$fue=date("w",mktime(0,0,0,$mes,$dia,$ano));
				if (intval($fue)!=0 && ($numSemanaHoy==$numSemanaDia)) return true;
				else return false;
			}
			$d=0;
			for ($i=1;$i<=$diasdespues;$i++)
			{
				if ($tr<$totalfilas)
				{
					if ($i>=$primeromes && $i<=$tope) 
					{
						echo "<td class='";
						/* creamos fecha completa */
						if ($dia<10) $dia_actual="0".$dia; else $dia_actual=$dia;
						$fecha_completa=$fecha_calendario[0]."-".$fecha_calendario[1]."-".$dia_actual;
						$j = strtotime($fecha_completa);
                        $diaInteger=jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$j),date("d",$j), date("Y",$j)) , 0 );
                        $nombre= $nombreDiasSemana[$diaInteger];
                       
						if (intval($eventos[$nombre])>0 && puedo_inscribirme($fecha_completa) && date("Y-m-d")<=$fecha_completa) 
						{
							echo "evento";
							$hayevento=$eventos[$nombre];
						}
						else $hayevento=0;
						
						
						/* si es hoy coloreamos la celda */
						if (date("Y-m-d")==$fecha_completa) echo " hoy";
						
						echo "'>";
						
						/* recorremos el array de eventos para mostrar los eventos del día de hoy */
						if ($hayevento>0 ) echo "<a href='#' data-evento='#evento".$dia_actual."' class='modali' rel='".$fecha_completa."' title='Hay ".$hayevento." clases'>".$dia."</a>";
						else echo "$dia";
						
						/* agregamos enlace a nuevo evento si la fecha no ha pasado */
						if (date("Y-m-d")<=$fecha_completa && es_finde($fecha_completa)==false && puedo_inscribirme($fecha_completa)) echo "<a href='#' data-evento='#nuevo_evento' title='Agregar un Evento el ".fecha($fecha_completa)."'rel='".$fecha_completa."'>&nbsp;</a>";
						
						echo "</td>";
						$dia+=1;
					}
					else 
					{
						if ($i>$tope)
						{echo "<td class='desactivada'>".$d+=1.;"</td>";}
						else
						{
							echo "<td class='desactivada'></td>";
						}
					}
					
					if ($i==7 || $i==14 || $i==21 || $i==28 || $i==35 || $i==42) {echo "<tr>";$tr+=1;}
				}
			}
			echo "</table>";
			
			//$mesanterior=date("Y-m-d",mktime(0,0,0,$fecha_calendario[1]-1,01,$fecha_calendario[0]));
			//$messiguiente=date("Y-m-d",mktime(0,0,0,$fecha_calendario[1]+1,01,$fecha_calendario[0]));
			//echo "<p>&laquo; <a href='#' rel='$mesanterior' class='anterior'>&#8592;</a> - <a href='#' class='siguiente' rel='$messiguiente'>&#8594;</a> &raquo;</p>";
		break;
	}
}
?>