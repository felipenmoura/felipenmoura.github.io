<?php
	$PREID= 'func_add_';
	$_GET['$PREID'] = $PREID;
?>
<input type="text"
	   name="<?php echo $PREID; ?>dependenteList"
	   id="<?php echo $PREID; ?>dependenteList"
	   style="display: none;">
<table width="100%">
	<tr>
		<td class="gridTitle">
			Nome
		</td>
		<td class="gridTitle">
			Grau
		</td>
		<td class="gridTitle">
			<br>
		</td>
	</tr>
	<tbody id="<?php echo $PREID; ?>dependente">
		<tr>
			<td style="padding-right: 3px;
					   text-align: left;"
				class="gridCell">
				<input type="text"
					   style=""
					   name="nome"
					   id="<?php echo $PREID; ?>dependenteNome"> 
			</td>
			<td class="gridCell"
				style="text-align: left;">
			<?php
				$_GET['component']= 'dependencia';
				$_GET['componentId']= $PREID.'dependencia';
				include('../components.php');
			?>
			</td>
			<td class="gridCell">
				<input type="button"
					   value="+"
					   onclick="addToList('<?php echo $PREID; ?>dependente', '<?php echo $PREID; ?>dependenteNome, iptComponentDependencia<?php echo $PREID; ?>dependencia, <?php echo $PREID; ?>dependencia');"
					   class="botao_caract">
			</td>
		</tr>
	</tbody>
</table>