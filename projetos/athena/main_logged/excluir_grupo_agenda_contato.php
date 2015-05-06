<?php
	//session_start();
	require_once("inc/valida_sessao.php");

	require_once("../connections/flp_db_connection.php");
	$db_connection= @connectTo();
	
	if($_GET['pk_agenda_grupo_to_del'])
	{
		if($data)
		{
			?>
				Grupo excluido com sucesso
			
			<?
		}else{
				?>
					Erro ao tentar excluir o grupo de contatos
				<?
			 }
		exit;
	}
	
?>
<table width="100%">
	<tr>
		<td>
			Tem certeza que deseja excluir permanentemente o grupo <i><? echo $_POST['s_nome_agenda_grupo'] ?></i> ?
		</td>
	</tr>
	<tr>
		<td>
			<input type="button"
				   class="botao"
				   value=" SIM "
				   onclick="onlyEvalAjax('excluir_grupo_agenda_contato.php?pk_agenda_grupo_to_del=<? echo $_GET['pk_agenda_grupo']; ?>', 'top.setLoad(true)', 'top.setLoad(false); alert(ajax); top.c.closeBlock(\'excluir_grupo_agenda_contato\');');"> 
			<input type="button"
				   class="botao"
				   value=" N&Atilde;O ">
		</td>
	</tr>
</table>