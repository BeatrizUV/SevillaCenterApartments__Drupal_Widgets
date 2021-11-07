<?php
    /**
     * Title: WIDGET DISPONIBILIDAD ICAL WUBOOK
     * Description: Widget que muestra la disponibilidad del apartamento mostrado para el mes vigente (iCal WuBook)
     * Author: Beatriz Urbano Vega
     * Business: S&L Apartamentos SC
     * Creation Date: 15/10/2015
     */

    $lang = 'es';

    // Obtenemos los datos del día de hoy
    $milisegundos = time();
    $diaHoy = date('d', $milisegundos);
    $mesHoy = date('m', $milisegundos);
    $anoHoy = date('Y', $milisegundos);	
    $diaSemanaHoy = date('D', $milisegundos);
    $diasMes = cal_days_in_month(CAL_GREGORIAN, $mesHoy, $anoHoy);
    $bisiesto = false;	

    // Comprobamos si el año es bisiesto o no
    if (date('L', $milisegundos) == 1) {
        $bisiesto = true;
    }

    // Recogemos la URL
    $url = $_SERVER['REQUEST_URI'];

    // Chequeamos el idioma de la url
    if (preg_match('/\/en\//i', $url)) {
       $lang = 'en';
       $url = str_replace('-apartment', '', $url);
    }

    // Sacamos el nombre del apartamento cargado
    $tokensUrl = explode('-', $url);
    $apartamento = strtolower(array_pop($tokensUrl));

    // Cargamos la lista de calendarios de WuBook
    $calendarios = cargarCalendariosWuBook();

    // Preparamos el array de los días de la semana
    $diasSemana = cargarDiasSemana();

    // Preparamos el array con los meses del año en español e inglés
    $mesesAno = cargarMesesAno();

    // Ahora preparamos los datos del iCal para poder consultarlos desde el bucle
    // Obtenemos los días bloqueados del mes
    $diasBloqueados = cargarDiasBloqueados($calendarios, $apartamento, $anoHoy, $mesHoy, $diasMes);

    // Seteamos el primer día del mes
    $primeroMes = $anoHoy.'-'.$mesHoy.'-01';
    // Miramos qué día de la semana es pasándolo a milisegundos previamente
    $diaSemanaPrimeroMes = date('D', strtotime($primeroMes));

    // Mostramos los títulos del widget	
    mostrarTitulosWidget($apartamento, $mesesAno, $mesHoy, $anoHoy, $diasSemana, $lang);

    // Y cargamos el bucle que imprime el calendario
    mostrarCalendario($diasSemana, $diaHoy, $diaSemanaPrimeroMes, $diasMes, $diasBloqueados);

    function cargarCalendariosWuBook() {
        $calendarios = array(
            'b1' => 'https://wubook.net/wbkd/ical/ics-19674-172f242c2bb21cc3bbb5e996ca96bbed.ics',
            'b2' => 'https://wubook.net/wbkd/ical/ics-19674-90a6a8944f1998c34b87de0de793300b.ics',
            'b3' => 'https://wubook.net/wbkd/ical/ics-19674-1592676763ba3b2202491440e1d8f040.ics',
            'b4' => 'https://wubook.net/wbkd/ical/ics-19674-b31c7c5ed859b280e47d5153d5e11fde.ics',
            'b5' => 'https://wubook.net/wbkd/ical/ics-19674-5988c8ead1027496d65937e141c87a8b.ics',
            '1i' => 'https://wubook.net/wbkd/ical/ics-19674-87fcb026c234e80778f254de05ec4c27.ics',
            '1d' => 'https://wubook.net/wbkd/ical/ics-19674-7961729dca5d477e73ed1c1016f4b5b9.ics',
            '2i' => 'https://wubook.net/wbkd/ical/ics-19674-1a7641b9ffe0c822e51c2d43e8375ce4.ics',
            '2d' => 'https://wubook.net/wbkd/ical/ics-19674-e1d6d8dff1ee51ad6262cb4cc1448a8b.ics',
            'ai' => 'https://wubook.net/wbkd/ical/ics-19674-f34a6a3e9dada539eacebdaab8b7ebeb.ics',
            'ac' => 'https://wubook.net/wbkd/ical/ics-19674-1db6c965a2b2481c38a8e10014c48d73.ics',
            'ad' => 'https://wubook.net/wbkd/ical/ics-19674-f0198513ea3ecccbef1155c4f5eeaa43.ics'
        );

        return $calendarios;
    }

    function cargarDiasSemana() {
        $diasSemana = array (
            0 => array('en' => 'Mon', 'es' => 'Lun'),
            1 => array('en' => 'Tue', 'es' => 'Mar'),
            2 => array('en' => 'Wed', 'es' => 'Mi&eacute;'),
            3 => array('en' => 'Thu', 'es' => 'Jue'),
            4 => array('en' => 'Fri', 'es' => 'Vie'),
            5 => array('en' => 'Sat', 'es' => 'S&aacute;b'),
            6 => array('en' => 'Sun', 'es' => 'Dom')
        );

        return $diasSemana;
    }

    function cargarMesesAno() {
        $mesesAno = array(
            '01' => array('es' => 'Enero', 'en' => 'January'),
            '02' => array('es' => 'Febrero', 'en' => 'February'),
            '03' => array('es' => 'Marzo', 'en' => 'March'),
            '04' => array('es' => 'Abril', 'en' => 'April'),
            '05' => array('es' => 'Mayo', 'en' => 'May'),
            '06' => array('es' => 'Junio', 'en' => 'June'),
            '07' => array('es' => 'Julio', 'en' => 'July'),
            '08' => array('es' => 'Agosto', 'en' => 'August'),
            '09' => array('es' => 'Septiembre', 'en' => 'September'),
            '10' => array('es' => 'Octubre', 'en' => 'October'),
            '11' => array('es' => 'Noviembre', 'en' => 'November'),
            '12' => array('es' => 'Diciembre', 'en' => 'December')
        );

        return $mesesAno;
    }

    function cargarTokensICal($calendarios, $apartamento) {
        // Seleccionamos el calendario iCal correspondiente y parseamos el calendario
        $iCal = @file_get_contents($calendarios[$apartamento]);
        $iCal = preg_replace('/[\n|\r|\n\r|\t|\0|\x0B]/', '', $iCal);
        $iCalCortado = substr($iCal, 71, strlen($iCal)); 
        $iCalCortado = str_replace('END:VEVENTBEGIN:VEVENT', ';', $iCalCortado);
        $iCalCortado = str_replace('BEGIN:VEVENT', '', $iCalCortado);
        $iCalCortado = str_replace('END:VEVENTEND:VCALENDAR', '', $iCalCortado);
        $tokensCalendario = explode(';', $iCalCortado);
        $tokensLimpios = array();
        $fechas = array();

        // hacemos arrays con cada línea del array
        /**
         * ### ICAL PATTERN ###
         * UID:20151016T100351Z-25313@ord4;20151016T000000;20151021T000000SUMMARY:RoomId: 128535 - Room not available
         */ 
        foreach($tokensCalendario as $token) {
            $token = str_replace('DTSTART:', ';', $token);
            $token = str_replace('DTEND:', ';', $token);
            $token = str_replace('SUMMARY:', ';', $token);			
            $tokens = explode(';', $token);
            $tokensLimpios[0] = $tokens[1];
            $tokensLimpios[1] = $tokens[2];
            $fechas[] = $tokensLimpios;
        }

        return $fechas;
    }

    function cargarDiasBloqueados($calendarios, $apartamento, $anoHoy, $mesHoy, $diasMes) {
        // Dividimos el array en varios más pequeños
        $iCals = cargarTokensICal($calendarios, $apartamento);
        $inicioReserva = '';
        $finReserva = ''; 
        $cont = 0;
        $diasBloqueados = array();

        /**
         * ### ICAL PATTERN ###
         * 2 => 20151015T000000
         * 3 => 20151022T000000
         */

        // Buscamos las reservas que tengan días bloqueados en el mes vigente
        foreach ($iCals as $i) {
            // Para las reservas que coincidan con el mes vigente		
            if ((preg_match('/'.$anoHoy.$mesHoy.'/i', $i[0])) || (preg_match('/'.$anoHoy.$mesHoy.'/i', $i[1]))) {
                // Miramos si empieza la reserva dentro del mes			
                if (preg_match('/'.$anoHoy.$mesHoy.'/i', $i[0])) {
                    $inicioReserva = str_replace($anoHoy.$mesHoy, '', $i[0]);
                    $inicioReserva = str_replace('T000000', '', $inicioReserva);				

                    // Y si también terminan dentro del mes				
                    if (preg_match('/'.$anoHoy.$mesHoy.'/i', $i[1])) {
                        // Seteamos la fecha de fin de bloqueo con las establecidas para la reserva
                        $finReserva = str_replace($anoHoy.$mesHoy, '', $i[1]);
                        $finReserva = str_replace('T000000', '', $finReserva);							
                    }
                    else {
                        // Si la fecha de cierre es posterior al mes vigente seteamos como fecha de cierre el último día del mes
                        $finReserva = $diasMes+1; // El script tiene un bug que carga un día menos en cada reserva que se sale del mes vigente, así que sumamos +1 en esta variable para que cargue el período completo para reservas que se salen del mes vigente.										 
                    }
                }
                else {
                    // Si la fecha de inicio no coincide con el mes vigente seteamos la fecha al primer día del mes
                    $inicioReserva = 1;	

                    // Si la fecha de cierre coincide con el mes vigente
                    if (preg_match('/'.$anoHoy.$mesHoy.'/i', $i[1])) {
                            // Seteamos la fecha de fin de bloqueo con las establecidas para la reserva
                            $finReserva = str_replace($anoHoy.$mesHoy, '', $i[1]);
                            $finReserva = str_replace('T000000', '', $finReserva);	
                    }
                    else {
                            // Si la fecha de cierre es posterior al mes vigente seteamos como fecha de cierre el último día del mes
                            $finReserva = $diasMes;										
                    }
                }

                // Y metemos cada día bloqueado en un array			
                for($cont = $inicioReserva; $cont < $finReserva; $cont++) {
                        $diasBloqueados[] = $cont;
                }	
            }
        }	

        return $diasBloqueados;
    }

    function mostrarTitulosWidget($apartamento, $mesesAno, $mesHoy, $anoHoy, $diasSemana, $lang) {
        $cont = 0;

        echo '<div class="rooms-availability-field-calendar">
                <div class="availability-title"><h2>Concordia '.strtoupper($apartamento).'</h2></div>
                <div class="cal cal-processed fc"> 
                    <span class="fc-header-title"><h2>'.$mesesAno[$mesHoy][$lang].' '.$anoHoy.'</h2></span>
                    <table class="fc-header fc-view fc-view-month fc-grid fc-border-separate" style="width:100%">
                       <tr>';

        for($cont = 0; $cont < 7; $cont++) {
                echo '<th>'.$diasSemana[$cont][$lang].'</th>';
        }

        echo '</tr>';
    }

    function mostrarCalendario($diasSemana, $diaHoy, $diaSemanaPrimeroMes, $diasMes, $diasBloqueados) {
        $cont = 0; // Máximo 6 y se resetea
        //$dia = 1;
        // Esto arregla el mostrar todos los días anteriores al día 1 con el class fc-today
        $dia = getPrimerDiaMes($diaSemanaPrimeroMes, $diasSemana);
        $start = false;
        $end = false;
        $last = false;
        $class = '';

        while (!$end) {
                if ($cont == 0) {
                        echo '<tr>';
                }

                if ($dia == $diaHoy) {
                        $class = 'fc-today';
                }
                else if ($dia < $diaHoy) {
                        $class = 'fc-widget-content';
                }
                else {
                        $class = '';
                }

                if (in_array($dia, $diasBloqueados)) {
                        $class .= ' locked';
                }

                echo '<td class="'.$class.'"><span>';
                if (!$start) {
                        if ($diasSemana[$cont]['en'] == $diaSemanaPrimeroMes) {
                                $start = true;
                                echo $dia;
                        }
                }
                else {
                        if ($dia <= $diasMes) {
                                echo $dia;
                        }
                        else {
                                $last = true;
                        }
                }
                echo '</span></td>';

                $cont++;

                if ($cont > 6) {
                        if (!$last) {
                                $cont = 0;
                                echo '</tr>';	
                        }
                        else {
                                $end = true;
                        }
                }
                
                // Contamos cada vez que pase por el bucle porque ahora empezamos con números negativos si el primer día del mes no cae en Lunes
                $dia++;	
        }
        echo '</table>
                </div>
        </div>';
    }
    
    function getPrimerDiaMes($diaSemanaPrimeroMes, $diasSemana) {
        return (array_search($diaSemanaPrimeroMes, $diasSemana) + 1 * -1);        
    }
?>

<style>
	.current { border: 1px solid #000; }
	.locked { background-color: #F00; }
	.disabled { background-color: #CCC; }
</style>