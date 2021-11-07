<?php
  $urlMotor = '/es/reservar-apartamentos-en-sevilla';
  $mensajeSubmit = 'Disponibilidad';
  $mensajeHuespedes = 'Hu&eacute;spedes';
  $mensajeFechaEntrada = 'Fecha de Entrada';
  $mensajeFechaSalida = 'Fecha de Salida';
  
  if ($_SERVER['REQUEST_URI'] == '/en') {
    $urlMotor = '/en/booking-apartments-seville';    
    $mensajeSubmit = 'Availability';
    $mensajeHuespedes = 'Guests';
    $mensajeFechaEntrada = 'Start date';
    $mensajeFechaSalida = 'End date';
  }
?>
<style>
    #ui-datepicker-div {
        z-index: 100 !important;
    }
</style>
<form class="rooms-booking-availability-search-form" action="<?php echo $urlMotor; ?>" method="post" id="rooms-booking-availability-search-form" accept-charset="UTF-8" style="display: block !important;">
    <input type="text" id="rooms_start_date" name="rooms_start_date" value="" size="20" maxlength="30" class="form-text" placeholder="<?php echo $mensajeFechaEntrada; ?>" required />
    <input type="text" id="rooms_end_date" name="rooms_end_date" value="" size="20" maxlength="30" class="form-text" placeholder="<?php echo $mensajeFechaSalida; ?>" required />
    <select id="edit-group-size-adults1" name="group_size_adults" class="form-select" required>
        <option disabled><?php echo $mensajeHuespedes; ?></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
    </select>
    <input type="submit" id="edit-submit" name="op" value="<?php echo $mensajeSubmit; ?>" class="form-submit" />
</form>