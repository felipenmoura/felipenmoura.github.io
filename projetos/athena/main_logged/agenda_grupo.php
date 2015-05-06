<?php
//session_start();

require_once("inc/valida_sessao.php");

include("../connections/flp_db_connection.php");
$db_connection= @connectTo();
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

if($_POST['novo_grupo_nome'])
{
	$qr_insert= "INSERT into tb_agenda_grupo
					(
						s_grupo_nome,
						s_descricao,
						vfk_usuario
					)
				 VALUES
					(
						'".$_POST['novo_grupo_nome']."',
						'".$_POST['novo_grupo_desc']."',
						 ".$_SESSION['pk_usuario']."
					)
				";
	$data= pg_query($db_connection, $qr_insert);
	if($data)
	{
		?>
			<script>
				top.setLoad(false);
				top.filho.atualizaComponents('agenda_grupo');
				//top.filho.onlyEvalAjax('agenda_contatos_grupos_lista.php', '', 'top.setLoad(false); top.filho.atualizaComponents("");');
				top.filho.closeBlock('novo_grupo_contatos');
			</script>
		<?
	}else{
			echo pg_last_error($data);
			?>
				<script>
					top.setLoad(false);
					top.showAlert('erro', "Erro ao tentar salvar no banco\n");
					//top.c.closeBlock('novo_grupo_contatos');
				</script>
			<?
		 }
}else{
		?>
			<br>
			<form method="POST"
				  action="agenda_grupo.php"
				  target="hiddenFrame"
				  id="agenda_grupo_new_form"
				  style="padding: 0px;
						 margin: 0px;">
				<table width="100%">
					<tr>
						<td>
							Nome
						</td>
						<td>
							<input type="text"
								   name="novo_grupo_nome"
								   id="novo_grupo_nome"
								   maxlength="50">
						</td>
					</tr>
					<tr>
						<td>
							Descricao
						</td>
						<td>
							<input type="text"
								   name="novo_grupo_desc"
								   id="novo_grupo_desc"
								   maxlength="800">
						</td>
					</tr>
					<tr>
						<td colspan="2"
							style="text-align: center;
								   padding: 10px;">
							<input type="button"
								   class="botao"
								   value="Adicionar"
								   onclick="if(document.getElementById('novo_grupo_nome').value.length >= 4){ document.getElementById('agenda_grupo_new_form').submit(); top.setLoad(true);}else alert('Ser&aacute; necess&aacute;rio um nome com ao menos 4 caracteres ')">
						</td>
					</tr>
				</table>
			</form>
		<?
	}
?>