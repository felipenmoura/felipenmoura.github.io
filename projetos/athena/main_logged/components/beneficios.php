<table style="border: solid 1px #000000;
			  height: 100%;
			  width: 100%;">
	<tr>
		<td style="vertical-align: top;">
			<table width="100%">
				<tr>
					<td class="gridTitle">
						Benef&iacute;cio
					</td>
					<td class="gridTitle">
						Valor
					</td>
					<td class="gridTitle">
						<br>
					</td>
				</tr>
				<tbody id="<?php echo $PREID; ?>beneficio">
					<tr id="<?php echo $PREID; ?>trbeneficio">
						<td class="gridCell"
							style="text-align: left;">
							<?php
								$_GET['component']= 'beneficio';
								$_GET['componentId']= $PREID.'_func_add_beneficio';
								include('../components.php');
							?>
						<td style="padding-right: 3px;
								   text-align: left;"
							class="gridCell">
							<input type="text"
								   style=""
								   name="valor"
								   id="<?php echo $PREID; ?>beneficioValor"> 
						</td>
						<td class="gridCell">
							<input type="button"
								   value="+"
								   Xonclick="addToList('<?php echo $PREID; ?>beneficio', '<?php echo $PREID; ?>_func_add_beneficio, iptBeneficio<?php echo $_GET['componentId']; ?>, <?php echo $PREID; ?>beneficioValor');"
								   onclick="addLine('<?php echo $PREID; ?>beneficio', '<?php echo $PREID; ?>trbeneficio')";
								   class="botao_caract">
						</td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
</table>