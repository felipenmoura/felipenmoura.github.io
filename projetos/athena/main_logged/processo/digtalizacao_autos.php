<table>
	<tr>
		<td style="padding-right:12px">
			Digitaliza&ccedil;&atilde;o dos Autos
		</td>
		<td>
			<fieldset style="padding:7px;">
				<table>
					<tbody id="<?php echo $PREID; ?>_tbodyDigitalizao">
						<tr id="<?php echo $PREID; ?>_trDigitalizao">
							<td>
								<input class="discret_input"
									   type="file"
									   name="autosDigitalizados"
									   id="<?=$PREID?>autosDigitalizados"
									   required="true"
									   oldvalue="">
							</td>
							<td>
								<input type="button"
									   value="+"
									   onclick="if(document.getElementById('<?php echo $PREID; ?>autosDigitalizados').value != '')
												{
													addLine('<?php echo $PREID; ?>_tbodyDigitalizao','<?php echo $PREID;?>_trDigitalizao',false);
												}"
									   class="botao_caract">
							</td>
						</tr>
					</tbody>
				</table>
			</fieldset>
		</td>
	</tr>
</table>