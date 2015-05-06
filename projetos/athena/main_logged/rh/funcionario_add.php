<?php

// PERMISSÃO
$acessoWeb= 16;

require_once("../inc/valida_sessao.php");
require_once("../inc/styles.php");
require_once("../inc/query_control.php");
require_once("../inc/calendar_input.php");
require_once("../inc/class_explorer.php");
require_once("../inc/class_abas.php");
include("../../connections/flp_db_connection.php");
	$db_connection = connectTo();
$PREID= 'func_add_';
$_GET['$PREID'] = $PREID;

?>
<div style="width: 100%;
			height: 100%;
			overflow-y: auto;">
	<iframe id="func_add_hiddenFrame"
				name="func_add_hiddenFrame"
				style="display: none;">
	</iframe>
		<form name="func_add_form"  
			  id="func_add_form"
	 		  action="rh/funcionario_add_post.php"
			  onsubmit="return checkTypeImage();"
			  method="POST"
			  enctype="multipart/form-data"
			  target="func_add_hiddenFramee"
			  style="margin: 0px;
					 padding: 0px;">
			<table style="width: 100%;
						  height: 100%;">
				<tr>
					<td>
						<?php
							$funcGuias= new guias();
							$funcGuias->guiaAdd('Dados Pessoais', 'func_add_dados_pessoais.php');
							//$funcGuias->guiaAdd('Dados Banc&aacute;rios', 'func_add_dados_bancarios.php');
							$funcGuias->guiaAdd('Contatos', 'func_add_contatos.php');
							$funcGuias->guiaAdd('Dados Contratuais', 'func_add_dados_contratuais.php');
							$funcGuias->guiaAdd('Dependentes', 'func_dependentes.php');
							$funcGuias->guiaAdd('Sistema', 'func_add_sistema.php');
							$funcGuias->guiaAdd('Observa&ccedil;&otilde;es', 'func_add_obs.php');
							$funcGuias->setSelected(0);
							$funcGuias->write();
						?>
					</td>
				</tr>
				<tr>
					<td style="text-align: center;
							   height: 20px;">
						<input type="button"
							   value="Salvar"
							   class="botao"
							   onclick="if(gebi('<?php echo $PREID; ?>novoFuncNome').value.replace(/ /g, '') != '')
											top.filho.funcAdd('<?php echo $PREID; ?>');">
					<input type="button"
						   value="Limpar"
						   class="botao"
						   onclick="top.filho.getBlock(this).reload();">
				</td>
			</tr>
		</table>
<input type="text"
	   id="<?php echo $PREID; ?>func_endereco_values"
	   name="enderecos"
	   style="display:none">
<input type="text"
	   id="<?php echo $PREID; ?>func_email_values"
	   name="emails"
	   style="display:none">
<input type="text"
	   id="<?php echo $PREID; ?>func_telefone_values"
	   name="telefones"
	   style="display:none">
<input type="text"
	   id="<?php echo $PREID; ?>func_beneficio_values"
	   name="beneficios"
	   style="display:none">
<input type="text"
	   id="<?php echo $PREID; ?>func_dependente_values"
	   name="dependentes"
	   style="display:none">
</form>
</div>