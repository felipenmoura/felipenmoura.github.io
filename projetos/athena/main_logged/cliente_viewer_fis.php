<?php
	$PREID= $_GET['PREID'];
?>
<form name="searchFis"
	  id="searchFis"
	  action="clientes_viewer.php"
	  method="POST"
	  target="<?php echo $PREID; ?>hiddenFrameClientViewer">
	<input type="hidden"
		   name="op"
		   value="fisica">
	<table id="<?php echo $PREID; ?>tbodyClienteFisica"
		   style="width:100%;
				  margin: 7px;">
		<tr>
			<td style="width:150px;">
				Nome
				<input type="text"
					   name="nome"
					   class="discret_input"
					   required="true"
					   label="Nome"><br>
			</td>
			<td>
				C.P.F<br>
				<input type="text"
					   name="clienteCPF"
					   maxlength="15"
					   class="discret_input"
					   onkeyup="mascaraCPF(this, event);"
					   label="CPF">
			</td>
			<td>
				R.G.<br>
				<input type="text"
					   name="clienteRG"
					   maxlength="10"
					   class="discret_input"
					   label="RG"
					   onkeyup="numOnly(this);">
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
					   onclick="document.getElementById('searchFis').reset()"> 
				<input type="reset"
					   class="botao"
					   value="Limpar">
			</td>
		</tr>
	</table>
	<div style="width:100% " 
		 id="clientes_viewer_list_fis">
	</div>
</form>