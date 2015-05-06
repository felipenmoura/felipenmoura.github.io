<?php
	function makeCalendar($input_date_name, $input_date_value, $size='80px')
	{
		?>
		<nobr>
			<input type="text"
				   id="<? echo $input_date_name; ?>"
				   name="<? echo $input_date_name; ?>"
				   maxlength="10"
				   style="text-align: center;
						  width: <?php echo $size; ?>;"
				   value="<? echo  $input_date_value; ?>"
				   oldValue="<? echo  $input_date_value; ?>"
				   notReadonly
				   class="discret_input"
				   onkeyup="formataData(this, event);"
				   onfocus="//Calendar.setup({ inputField : '<? echo $input_date_name; ?>', ifFormat : '%d/%m/%Y', daFormat : '%d/%m/%Y', button : this.id });">
			<img src="img/calendar.gif"
				 style="cursor: pointer;vertical-align:top;"
				 id="<? echo $input_date_name; ?>_botao"
				 onmouseover="showtip(this, event, 'Calend&aacute;rio')"
				 onmousedown="Calendar.setup({ inputField : '<? echo $input_date_name; ?>', ifFormat : '%d/%m/%Y', daFormat : '%d/%m/%Y', button : '<? echo $input_date_name; ?>_botao'});">
			
			<img src="img/clear2.gif"
				 width="18"
				 height="16"
				style="cursor: pointer"
				onmouseover="showtip(this, event, 'Limpar')"
				onmousedown="document.getElementById('<? echo $input_date_name; ?>').value=''">

		<nobr>
		<?
	}
?>