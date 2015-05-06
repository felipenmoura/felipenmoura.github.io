<?php

// PERMISSÃO
$acessoWeb = 1;

require_once("../inc/valida_sessao.php");
require_once("../inc/calendar_input.php");
require_once("../inc/styles.php");
require_once("../inc/query_control.php");
require_once("../inc/class_explorer.php");
require_once("../inc/class_abas.php");

if(!$_GET['PREID'])
	$_GET['PREID'] = "processo_add";
$PREID = $_GET['PREID'];

//if(!$db_connection= @connectTo())
require_once("../../connections/flp_db_connection.php");
$db_connection= connectTo();
if(!$db_connection)
{
	?>
		<flp_script>
			alert("Ocorreu um problema ao tentar verificar o login !");
		<script>
			alert("Ocorreu um problema ao tentar verificar o login !");
		</script>
	<?
	exit;
}
?>
<form action="processo/processo_add_post.php?PREID=<?=$PREID?>"
	  method="POST"
	  id="<?=$PREID?>_processoAddForm"
	  target="procAddHiddenFrame_">
	  
	<table style="width: 100%;
				  height: 100%;">
				<tr>
					<td>
						<?php
							$funcGuias= new guias();
							$funcGuias->guiaAdd('Dados do Processo', 'dados_processo.php?a=1');
							if($PREID == 'processo_add_ger'){
								$funcGuias->guiaAdd('Movimenta&ccedil;&atilde;o Processual', 'mov_proc.php?a=1');
							}
							$funcGuias->guiaAdd('Coment&aacute;rios do Processo', 'comentarios_processo.php?a=1');
							$funcGuias->guiaAdd('Digitaliza&ccedil;&atilde;o dos Autos', 'digtalizacao_autos.php?a=1');
							$funcGuias->setSelected(($_GET['selectedLabel'])? $_GET['selectedLabel']: 0);
							$funcGuias->write();
						?>
					</td>
				</tr>
			<tr>
					<td style="text-align: center;
							   height: 20px;">
						<input type="submit"
							   value="Salvar"
							   class="botao">
					<input type="button"
						   value="Limpar"
						   class="botao"
						   onclick="top.filho.getBlock(this).reload();">
				</td>
			</tr>
	</table>
</form>
<iframe id="procAddHiddenFrame"
	    name="procAddHiddenFrame"
		style="display:none">
</iframe>

	
