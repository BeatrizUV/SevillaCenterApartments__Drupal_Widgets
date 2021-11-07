<?php
    /**
     * Title: WIDGET PRECIO APARTAMENTO (DRUPAL Y WUBOOK) 
     * Description: Widget que muestra el precio mínimo del apartamento y el widget de disponibilidad de WuBook
     * Author: Beatriz Urbano Vega
     * Business: S&L Apartamentos SC
     * Creation Date: 16/10/2015
     */

    $lang = 'en';

    // Recogemos la URL
    $url = $_SERVER['REQUEST_URI'];

    // Chequeamos el idioma de la url
    if (preg_match('/\/es\//i', $url)) {
            $lang = 'es';		
    }

    // Seteamos el idioma del mensaje del widget
    $mensaje = array('Habitaci&oacute;n desde', 'por noche');
    if ($lang == 'en') {
        $mensaje = array('Room from', 'per night');
        $url = str_replace('-apartment', '', $url);
    }

    // Sacamos el nombre del apartamento cargado
    $tokensUrl = explode('-', $url);
    $apartamento = strtolower(array_pop($tokensUrl));

    // Cargamos la lista de calendarios de WuBook
    $calendarios = array(
            'b1' => 55,
            'b2' => 60,
            'b3' => 60,
            'b4' => 55,
            'b5' => 40,
            '1i' => 65,
            '1d' => 90,
            '2i' => 100,
            '2d' => 100,
            'ai' => 65,
            'ac' => 85,
            'ad' => 65
    );

    // Mostramos el precio mínimo para la habitación seleccionada

    echo '<div class="room-price-widget">
                    <p class="from">'.$mensaje[0].'</p>
                    <h3 class="price">'. round($calendarios[$apartamento] * 1.12).'&euro;</h3>
                    <p class="price-detail">'.$mensaje[1].'</p> 
              </div>';

    // Cargamos el widget de reserva de apartamentos
    $urlMotor = '/es/reservar-apartamentos-en-sevilla';
    if (preg_match('/\/en\//i', $_SERVER['REQUEST_URI'])) {
      $urlMotor = '/en/booking-apartments-seville';    
    }
?>

<form action="<?php echo $urlMotor; ?>" method="POST" class="rooms-booking-availability-search-form" id="rooms-booking-availability-search-form" accept-charset="UTF-8">
  <input type="hidden" name="group_size_adults" value="2" />
  <div>
      <div class="start-date">
          <div class="container-inline-date">
              <div class="form-item form-type-date-popup form-item-rooms-start-date">
                 <div id="edit-rooms-start-date" class="date-padding">
                     <div class="form-item form-type-textfield form-item-rooms-start-date-date">
                        <input autocomplete="off" name="rooms_start_date" type="text" onfocus="(this.type='date')" onblur="(if (this.value=""){this.type='text'})" class="wb-calendar hasDatepicker form-text" id="dfrom" size="22" maxlength="30" placeholder="Fecha de Entrada" required />
                     </div>
                 </div>
              </div>
          </div>              
      </div>
      <div class="end-date">
          <div class="container-inline-date">
              <div class="form-item form-type-date-popup form-item-rooms-end-date">
                  <div id="edit-rooms-end-date" class="date-padding">
                      <div class="form-item form-type-textfield form-item-rooms-end-date-date">
                          <input autocomplete="off" name="rooms_end_date" type="text" onfocus="(this.type='date')" onblur="(if (this.value=""){this.type='text'})" class="wb-calendar hasDatepicker form-text" id="dto" size="22" maxlength="30" placeholder="Fecha de Salida" required />                             
                      </div>                          
                  </div>
              </div>
          </div>              
      </div>
      <div class="form-actions form-wrapper" id="edit-actions">
          <input type="submit" id="check-button" name="op" value="Disponibilidad" class="wb-submit" />
      </div>
  </div>
</form>
<div style="display: block; clear: both; width: 100%;"></div>