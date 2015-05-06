<?php
session_start();

require_once("inc/valida_sessao.php");

require_once("../connections/flp_db_connection.php");
$db_connection= @connectTo();

//echo $_GET['pk_agenda_grupo']."<br>";
//echo $_GET['s_nome_agenda_grupo'];

if($_POST)
{

	$qr_update= "UPDATE tb_agenda_grupo
					SET s_grupo_nome = '".$_POST['s_nome_alterGroupName']."'
				  WHERE pk_agenda_grupo = ".$_POST['pk_agenda_grupo_alterGroupName']."
				";
	$data= @pg_query($db_connection, $qr_update);
	if($data)
	{
		?>
			<script>
				top.setLoad(false);
				parent.onlyEvalAjax('agenda_contatos_grupos_lista.php', 'top.setLoad(true)', 'top.setLoad(false); document.getElementById("agenda_contatos_grupos_lista").innerHTML= ajax');
				top.c.closeBlock('renomear_grupo_agenda_contato');
			</script>
		<?
	}else{
			?>
				<script>
					alert('Ocorreu um erro ao tentar alterar o nome do grupo de contatos !')
				</script>
			<?
		 }
	exit;
}

?>
<form name="formAlterGroupName"
	  id="formAlterGroupName"
	  target="hiddenFrameAlterGroupName"
	  action="renomear_grupo_agenda_contato.php"
	  method="POST">
	<table width="100%"
		   style="margin-top: 7px;">
		<tr>
			<td style="text-align: center;">
				<input type="text"
					   name="pk_agenda_grupo_alterGroupName"
					   id="pk_agenda_grupo_alterGroupName"
					   style="display: none;"
					   value="<? echo $_GET['pk_agenda_grupo']; ?>">
				<input type="text"
					   name="s_nome_alterGroupName"
					   id="s_nome_alterGroupName"
					   value="<? echo $_GET['s_nome_agenda_grupo']; ?>">
			</td>
		</tr>
		<tr>
			<td style="text-align: center;">
				<input type="button"
					   class="botao"
					   value="salvar"
					   onclick="if(document.getElementById('s_nome_alterGroupName').value==''){ alert('O campo nome do grupo não pode estar em branco') }else{ top.setLoad(true, 'Atualizando dados'); document.forms['formAlterGroupName'].submit(); }">
			</td>
		</tr>
	</table>
</form>
<iframe name="hiddenFrameAlterGroupName"
		id="hiddenFrameAlterGroupName"
		src="_quot"
		style="display: none;">
</iframe>