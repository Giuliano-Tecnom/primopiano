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
		//HORA ACTUAL 
		$fecha = new \DateTime('now', new \DateTimeZone('America/Argentina/Buenos_Aires'));	
		$fechaHora = date_format($fecha, 'H');	
		$query=$db->query("select * from ".$tabla." where dia='".$_GET["fecha"]."' order by hora asc");
		if ($fila=$query->fetch_array())
		{
			
			do{
				if(!(intval($fechaHora)<($fila["hora"]-1)) && $nombreDiasSemana[idate("w")]==$fila["dia"])
					{	
						//Se termino horario de inscripcion.
						echo "<p style='color:red'> Clase ".$fila["hora"]." hs- Entrenamiento Funcional-   Termino horario de inscripcion</p>";
					}
			    else
					{
					//cantidad de veces que el usuario esta inscripto
					$seInscribio=$db->query("select count(*) as inscripciones from claseusuario where idUsuario='".$_GET["idUsuario"]."'");
					$resultado = $seInscribio->fetch_array();
					//cantidad de inscriptos por clase
					$inscriptos=$db->query("select count(*) as cantidad from claseusuario where idClase='".$fila["idClase"]."'");
					$result = $inscriptos->fetch_array();
					//Verifico si el usuario esta inscripto.
					$esta_inscripto=$db->query("SELECT idUsuario as id from claseusuario where idClase='".$fila["idClase"]."' and idUsuario='".$_GET["idUsuario"]."'");
					$booleano= $esta_inscripto->fetch_array();
					if ($result["cantidad"] == $fila["cupo"]){
						if ($booleano['id']==null){	
						//Esta a tiempo, no esta inscripto y no hay cupo.
						echo "<p style='color:red'> Clase ".$fila["hora"]." hs- Entrenamiento Funcional-   Cupo lleno!</p>";
						}
						else
						{
							//Esta a tiempo, no hay cupo pero esta inscripto por lo que se puede desinscribir.
							echo "<p> Clase ".$fila["hora"]." hs- Entrenamiento Funcional<a href='#' class='eliminar_evento' rel='".$fila["idClase"]."' title='Desinscribirte ".fecha($_GET["fecha"])."'><img src='../../images/delete.png'></a></p>";
						}
					}
					else{
						if ($booleano['id']==null){
						   if($_GET["cantSemanal"]>$resultado["inscripciones"])
							 {
								 //Esta a tiempo, hay cupo, no esta inscripto y todavia puede inscribirse en esa semana.
								 echo "<div><p> Clase ".$fila["hora"]." hs- Entrenamiento Funcional<a href='#' id='confirmar' rel='".$fila["idClase"]."' title='Inscribirte ".fecha($_GET["fecha"])."'><img src='../../images/add.png'></a> (Inscriptos hasta el momento: ".$result["cantidad"].")</p></div>";
							 }		
							else{
								//Esta a tiempo, hay cupo, no esta inscripto pero ya supero sus inscripciones semanales.
								echo "<p style='color:red'> Clase ".$fila["hora"]." hs- Entrenamiento Funcional-   Superaste inscripciones semanales</p>";
							}				
						}
						else{
							//Esta a tiempo, hay cupo y ya esta inscripto.
							echo "<p> Clase ".$fila["hora"]." hs- Entrenamiento Funcional<a href='#' class='eliminar_evento' rel='".$fila["idClase"]."' title='Desinscribirte ".fecha($_GET["fecha"])."'><img src='../../images/delete.png'></a></p>";

						}
					}
				}
			}
			while($fila=$query->fetch_array());
		}
		break;
	}

	case "guardar_evento":
	{
		$query=$db->query("insert into claseusuario (idClase,idUsuario) values ('".$_GET["idClase"]."','".$_GET["idUsuario"]."')");
		if ($query) echo "<p class='ok'>Se ha inscripto correctamente.</p>";
		else echo "<p class='error'>Se ha producido un error guardando el evento.</p>";
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
			
		/* comprobamos si el a�o es bisiesto y creamos array de d�as */
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
		
		/* calculamos los d�as de la semana anterior al d�a 1 del mes en curso */
		$diasantes=$primeromes-1;
		
        
		
		/* los d�as totales de la tabla siempre ser�n m�ximo 42 (7 d�as x 6 filas m�ximo) */
		$diasdespues=42;
			
		/* calculamos las filas de la tabla */
		$tope=$dias[intval($fecha_calendario[1])]+$diasantes;
		if ($tope%7!=0) $totalfilas=intval(($tope/7)+1);
		else $totalfilas=intval(($tope/7));
			
		$mesanterior=date("Y-m-d",mktime(0,0,0,$fecha_calendario[1]-1,01,$fecha_calendario[0]));
		$messiguiente=date("Y-m-d",mktime(0,0,0,$fecha_calendario[1]+1,01,$fecha_calendario[0]));
		/* empezamos a pintar la tabla */
		echo "<div class='row'><h2><p>&laquo; <a href='#' rel='$mesanterior' class='anterior'>&#8592;</a></p>".$meses[intval($fecha_calendario[1])]." de ".$fecha_calendario[0]." <p><a href='#' class='siguiente' rel='$messiguiente'>&#8594;</a> &raquo;</p><abbr title='S&oacute;lo se pueden agregar eventos en d&iacute;as h&aacute;biles y en fechas futuras (o la fecha actual).'></abbr></h2></div>";
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
						
						/* recorremos el array de eventos para mostrar los eventos del d�a de hoy */
						if ($hayevento>0 ) echo "<a href='#' data-evento='#evento".$dia_actual."' class='modali' rel='".$fecha_completa."' title='Hay ".$hayevento." clases'>".$dia."</a>";
						else echo "$dia";
						
						/* agregamos enlace a nuevo evento si la fecha no ha pasado */
						if (date("Y-m-d")<=$fecha_completa && es_finde($fecha_completa)==false && puedo_inscribirme($fecha_completa)) echo "<a href='#' data-evento='#nuevo_evento' title='Agregar un Evento el ".fecha($fecha_completa)."' class='add agregar_evento' rel='".$fecha_completa."'>&nbsp;</a>";
						
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