<table>
	<tr>
		<td colspan="2"
			class="gridTitle">
			E-mail
		</td>
	</tr>
	<tbody id="<?php echo $PREID; ?>clienteEmailList">
		<tr>
			<td style="padding-right: 3px;"
				class="gridCell">
				<input type="text"
					   style=""
					   name="clienteEmail"
					   id="<?php echo $PREID; ?>clienteEmail"> 
			</td>
			<td class="gridCell">
				<input type="button"
					   value="+"
					   onclick="if(document.getElementById('<?php echo $PREID; ?>clienteEmail').value != ''
									&& validaEMail(document.getElementById('<?php echo $PREID; ?>clienteEmail')))
								{
									addToList('<?php echo $PREID; ?>clienteEmailList', '<?php echo $PREID; ?>clienteEmail');
									document.getElementById('<?php echo $PREID; ?>clienteEmail').value='';
								}"
					   class="botao_caract">
			</td>
		</tr>
	</tbody>
</table>