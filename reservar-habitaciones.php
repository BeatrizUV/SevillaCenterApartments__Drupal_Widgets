<?php
    $codigo = '1443091911'; // Cambiar por el código de cliente asignado por Wubook
    $layout = 'autosole'; // Elegir en el Motor de reservas
    $error = true;

    if ((isset($_POST['op'])) && (!empty($_POST['op']))) {
        $llegada = $_POST['rooms_start_date'];
        $salida = $_POST['rooms_end_date'];
        $huespedes = $_POST['group_size_adults'];

        // validar campos del formulario...
        if (validar($llegada, $salida, $huespedes)) {    
            $fechaLlegada = checkToday(parseFecha($llegada));    
            $fechaSalida = checkToday(parseFecha($salida));    

            if (($fechaLlegada != false) && ($fechaSalida != false) && ($fechaSalida != 'today')) {
                $noches = fechaToNum($fechaSalida) - fechaToNum($fechaLlegada); // más o menos
?>    
      <iframe id="__wbiframe___wbord_" name="__wbiframe___wbord_" class="motor-reservas-iframe" src="https://wubook.net/wbkd/wbk/?lcode=<?=$codigo?>&amp;referrer=<?=$_SERVER['REQUEST_URI']?>&amp;layout=<?=$layout?>&amp;dfrom=<?=$fechaLlegada?>&amp;nights=<?=$noches?>&amp;occupancies=<?=$huespedes?>" frameborder="0" allowtransparency="true" style="height: 920px; width: 960px; display: block; margin: auto;"></iframe>    
<?php    
                $error = false;
            }
        }
    }
    else {
        // Si viene vacío es que se ha accedido directamente al motor de reservas, así que no se muestra ningún mensaje de error
        $error = false;
        
?>    
        <iframe id="__wbiframe___wbord_" name="__wbiframe___wbord_" class="motor-reservas-iframe" src="https://wubook.net/wbkd/wbk/?lcode=<?=$codigo?>&amp;referrer=<?=$_SERVER['REQUEST_URI']?>&amp;layout=<?=$layout?>&amp;" frameborder="0" allowtransparency="true" style="height: 920px; width: 960px; display: block; margin: auto;"></iframe>    
<?php
    }
      
    if ($error) {
          echo '<div class="messages messages--error">
                  <h4>Ha habido un error en su solicitud. Compruebe que los datos sean correctos y vuelva a intentarlo.</h4>
                  <hr />
                  <h4>There has been an error in your request. Verify that the data are correct and try again.</h4>
                  <!--<small>(ERROR DE VALIDACI&Oacute;N)</small>-->
                </div>';
?>    
        <iframe id="__wbiframe___wbord_" name="__wbiframe___wbord_" class="motor-reservas-iframe" src="https://wubook.net/wbkd/wbk/?lcode=<?=$codigo?>&amp;referrer=<?=$_SERVER['REQUEST_URI']?>&amp;layout=<?=$layout?>&amp;" frameborder="0" allowtransparency="true" style="height: 920px; width: 960px; display: block; margin: auto;"></iframe>    
<?php        
    }                   

    // Función que valida los datos del formulario y revisa que las fechas contengan / o -
    function validar($llegada, $salida, $huespedes) {
        $errores = 0;
        $flag = true;

        if ((trim($llegada) == null) || (trim($llegada) == '') || (trim($llegada) == ' ')) {
            $errores++;       
        }
        else {
            if (!parseFecha($llegada)) {
                $errores++;
            }
        }

        if ((trim($salida) == null) || (trim($salida) == '') || (trim($salida) == ' ')) {
            $errores++;
        }
        else {
            if (!parseFecha($salida)) {
                $errores++;
            }
        }

        if ((trim($huespedes) == null) || (trim($huespedes) == '') || (trim($huespedes) == ' ') || ($huespedes == 0)) {
            $errores++;
        }

        if ($errores > 0) {
            $flag = false;
        }

        return $flag;
    }

    // Función que sustituye la fecha correspondiente por un 'today' si la fecha es la fecha de hoy
    function checkToday($entrada) {
        if ($entrada != false) {
            $curdate = date('Ymd', time());   
            $date = fechaToNum($entrada);

            if ($date == $curdate) {
                $entrada = 'today';  
            }
        }

        return $entrada;
    }
    
    // Función que pasa fechas en formato dd/mm/yyyy a yyyymmdd
    function fechaToNum($fecha) {
        if ($fecha == 'today') {
            $fecha = date('d/m/Y', time());
        }
        
        $tokens = explode('/', $fecha);
        return $tokens[2] . $tokens[1] . $tokens[0];
    }
    
    // Función que parsea las fechas en formato dd-mm-yyyy, yyyy-mm-dd y yyyy/mm/dd a dd/mm/yyyy
    function parseFecha($fecha) {
        $fecha = str_replace('-', '/', $fecha);
        if (preg_match('/\//i', $fecha)) {
            if (strpos($fecha, '/') === 3) {
                $tokens = explode('/', $fecha);
                $fecha = $tokens[2] . '/' . $tokens[1] . '/' .  $tokens[0];
            }
        }
        else {
            $fecha = false;
        }
        
        return $fecha;
    }
?>