<?php
	$PREID= $_GET['PREID'];
?>
<form name="searchJur"
	  id="searchJur"
	  action="clientes_viewer.php"
	  method="POST"
	  target="<?php echo $PREID; ?>hiddenFrameClientViewer">
	<input type="hidden"
		   name="op"
		   value="juridica">
	<table width="100%" id="<?php echo $PREID; ?>tbodyClienteJuridico"
		   style="width:100%;
				  margin: 7px;">
		<tr>
			<td style="width:150px;">
				Raz&atilde;o Social
				<input type="text"
					   name="razao_social"
					   class="discret_input"
					   name="sad"
					   required="true"
					   label="Raz&atilde;o social"><br>
			</td>
			<td style="width:150px;">
				Nome Fantasia
				<input type="text"
					   name="nome_fantasia"
					   class="discret_input"
					   label="Nome fantasia">
			</td>
		</tr>
		<tr>
			<td style="width:150px;">
				CNPJ
				<input type="text"
					   name="cnpj"
					   class="discret_input"
					   onkeyup="numOnly(this);"
					   maxlength="18"
					   label="CNPJ">
			</td>
		</tr>
		<tr>
			<td colspan="4"
				style="text-align: center; height: 15px;">
				<input type="submit"
					   class="botao"
					   value="Pesquisar"
					   onclick=""> 
				<input type="submit"
					   class="botao"
					   value="Ver Todos"
					   onclick="document.getElementById('searchJur').reset()"> 
				<input type="reset"
					   class="botao"
					   value="Limpar">
			</td>
		</tr>
			<tr>
				<td colspan="3">
					<div id="return_viewer_jur">
						<br>
					</div>
				</td>
			</tr>
		</form>
	</table>
	<div id="clientes_viewer_list_jur">
	</div>
</form>