<?php
//session_start();
require_once("inc/valida_sessao.php");

require_once("../connections/flp_db_connection.php");
$db_connection= @connectTo();
?>
<?
	$qr_delete= "DELETE from tb_agenda_contatos
				  WHERE pk_contato = ".$_GET['pk_contato']."
				";
	$data_delete= @pg_query($db_connection, $qr_delete);
	if($data_delete)
	{
		require_once('agenda_contatos_grupos_lista.php');
		echo " <flp_script>alert('Contato excluido com sucesso');";
	}else{
			echo " <flp_script>alert('Erro ao tentar excluir o contato');";
		 }
?>