<?php
	$PREID= 'func_add_';
	$_GET['$PREID'] = $PREID;
?>
<table width="100%"
	   height="100%">
	<tr style="height: 40px;">
		<td>
			Data de Admiss&atilde;o <br>
			<?php
				makeCalendar($PREID.'dataAdmissao', '','80px');
			?>
		</td>
		<!-- 
		<td>
			Data de Demiss&atilde;o <br>
				<input  type="text"
						name="dataDemissao"
						class="discret_input">
		</td>
		-->
	</tr>
	<tr style="height: 40px;">
		<td>
			Tipo de contrato<br>
			<select name="contrato_tipo"
					id="funcAddcontrato_tipo"
					style="display: none;">
				<option value=""></option>
				<option value="CTPS">
					Carteira Profissional
				</option>
				<option value="estagio">
					Est&aacute;gio
				</option>
				<option value="servico">
					Tercerizado
				</option>
			</select>
			<input type="text"
				   id="iptfuncAddcontrato_tipo"
				   readonly
				   class="selectIpt"
				   style="width: 110px;"
				   onmouseover="this.style.backgroundImage= 'url(img/bt_select_over.gif)'"
				   onmouseout="this.style.backgroundImage= 'url(img/bt_select.gif)'"
				   onclick="showSelectOptions(this, 'funcAddcontrato_tipo')">
		</td>
		<td style="padding-left:0px;
				   padding-right:0px;">
			Departamento<br>
			<span>
				<?php
					$_GET['component']= 'departamento';
					$_GET['componentId']= $PREID.'departamento';
					include('../components.php');
				?>
			</span>
		</td>
		<td style="padding-left:0px;
				   padding-right:0px;"
			colspan="2">
			Cargo<br>
			<span>
				<?php
					$_GET['component']= 'cargo';
					$_GET['componentId']= $PREID.'cargo';
					include('../components.php');
				?>
			</span>
		</td>
	</tr>
	<tr>
		<td colspan="4"
			style="vertical-align: top;">
			<?php
				include('../components/beneficios.php');
			?>
		</td>
	</tr>
</table>














