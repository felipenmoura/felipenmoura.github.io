<table>
	<tr>
		<td colspan="4"
			class="gridTitle">
			Telefone
		</td>
	</tr>
	<tbody id="<?php echo $PREID; ?>clienteFoneList">
		<tr>
			<td style="padding-right: 3px;"
				class="gridCell">
				<input type="text"
					   style="width: 25px;"
					   name="clienteFoneDDD"
					   maxlength="2"
					   onkeyup="numOnly(this);"
					   required="true"
					   label="DDD"
					   id="<?php echo $PREID; ?>clienteFoneDDD">
			</td>
			<td style="padding-right: 3px;"
				class="gridCell">
				<input type="text"
					   style="width: 90px;"
					   onkeyup="numOnly(this);"
					   maxlength="12"
					   required="true"
					   label="Telefone"
					   name="clienteFone"
					   id="<?php echo $PREID; ?>clienteFone"> 
			</td>
			<td style="padding-right: 3px;
					   text-align: left;"
				class="gridCell">
				<?php
					$_GET['component']= 'tipoFone';
					$_GET['componentId']= $PREID.'clienteFoneTipo';
					include('../components.php');
				?>
			</td>
			<td class="gridCell">
				<input type="button"
					   value="+"
					   onclick="addToList('<?php echo $PREID; ?>clienteFoneList', '<?php echo $PREID; ?>clienteFoneDDD, <?php echo $PREID; ?>clienteFone, <?php echo $PREID; ?>clienteFoneTipo,iptComponentFone<?php echo $_GET['componentId']; ?>');"
					   class="botao_caract">
			</td>
		</tr>
	</tbody>
</table>