<?php 
require_once("../inc/valida_sessao.php");
require_once("../inc/calendar_input.php");

include("../../connections/flp_db_connection.php");
$db_connection= @connectTo();
if(!$db_connection)
{
	?>
		<flp_script>
			alert("Ocorreu um problema ao tentar verificar o login !");
		<script>
			alert("Ocorreu um problema ao tentar verificar o login !");
		</script>
	<?php
	exit;
}
if($_POST)
{
	$insert= "INSERT INTO tb_orgao_judicial
						(
							s_nome,
							s_localidade,
							s_numero,
							s_vara
						)
				   VALUES
						(
							'".$_POST['nomeOrgaoJudicial']."',
							'".$_POST['localidadeOrgaoJudicial']."',
							'".$_POST['numeroOrgaoJudicial']."',
							'".$_POST['vara_turmaOrgaoJudicial']."'
						)
			 ";
	$data= @pg_query($db_connection, $insert);
	if(!$data)
	{
		echo"<script> top.setLoad(false); showAlert('erro', 'Falha ao tentar cadastrar novo Orgão Judicial'); </script>";
		exit;
	}else{
			echo "<script> top.setLoad(false); top.filho.atualizaComponents('orgaoJudicial'); top.c.closeBlock('novo_orgao_judicial_add');</script>";
		 }
		 exit;
}
?>
<form action="processo/orgao_judicial_add.php"
	  target="OrgaoJudicialAddIframe"
	  method="POST"
	  id="OrgaoJudicialAddForm">
<table>
	<tr>
		<td>
			  <fieldset style="padding:3px">
				<legend>Org&atilde;o Judicial:</legend>
					Nome:&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input class="discret_input"
						   type="text"
						   name="nomeOrgaoJudicial"
						   id="<?=$PREID?>nomeOrgaoJudicial"
						   required="true"
						   oldvalue=""><br>
						   
				   Localidade: &nbsp;&nbsp;&nbsp;
					<input class="discret_input"
						   type="text"
						   name="localidadeOrgaoJudicial"
						   id="<?=$PREID?>localidadeOrgaoJudicial"
						   required="true"
						   oldvalue=""><br>
						   
					N&uacute;mero: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input class="discret_input"
						   type="text"
						   name="numeroOrgaoJudicial"
						   id="<?=$PREID?>numeroOrgaoJudicial"
						   required="true"
						   oldvalue=""><br>
						   
					Vara/Turma: &nbsp;
					<input class="discret_input"
						   type="text"
						   name="vara_turmaOrgaoJudicial"
						   id="<?=$PREID?>vara_turmaOrgaoJudicial"
						   required="true"
						   oldvalue=""><br>
						   
			  </fieldset>
		</td>
	</tr>
	<tr>
		<td align="center">
			<input type="submit" value="Salvar" class="botao">
		</td>
	</tr>
</table>	
<iframe id="OrgaoJudicialAddIframe"
		name="OrgaoJudicialAddIframe"
		style="display: none;">
</iframe>