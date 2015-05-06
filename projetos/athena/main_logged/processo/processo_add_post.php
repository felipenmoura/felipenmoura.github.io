<?php
// PERMISSÃO
$acessoWeb = 1;

require_once("../inc/valida_sessao.php");
require_once("../inc/calendar_input.php");
require_once("../inc/styles.php");
require_once("../inc/query_control.php");
require_once("../inc/class_explorer.php");
require_once("../inc/funcoes.php");
include "../inc/get_sequence.php";
//if(!$db_connection= @connectTo())
	include("../../connections/flp_db_connection.php");
$db_connection= connectTo();
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
	/*
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	exit;
	*/
	$PREID= $_GET['PREID'];
	startQuery($db_connection);
	// $_POST['processoPasta']= explode(' - ', $_POST['processoPasta']);
	// $_POST['processoPasta']= $_POST['processoPasta'][0];
	
	//CLIENTE
	$counter = 0;
	$_POST[$PREID.'clienteAddProcesso'] = Array($_POST[$PREID.'clienteAddProcesso']);
	while(isset($_POST[$PREID.'clienteAddProcesso_'.$counter]))
	{
		$_POST[$PREID.'clienteAddProcesso'][] = $_POST[$PREID.'clienteAddProcesso_'.$counter];
		$counter++;
	}
	
	//PARTE CONTRARIA
	$counter = 0;
	$_POST[$PREID.'parteContraria'] = Array($_POST[$PREID.'parteContraria']);
	while(isset($_POST[$PREID.'parteContraria_'.$counter]))
	{
		$_POST[$PREID.'parteContraria'][] = $_POST[$PREID.'parteContraria_'.$counter];
		$counter++;
	}
	
	$pk_processo= getSequence('processo_seq');
	if(trim($_POST[$PREID.'dataDistribuicao_add']) != '')
		$dataDistribuicao= "to_date('".$_POST[$PREID.'dataDistribuicao_add']."','DD/MM/YYYY')";
	else
		$dataDistribuicao= "NULL";
	
	if(trim($_POST[$PREID.'dataEncerramento']) != '')
		$dataEncerramento= "to_date('".$_POST[$PREID.'dataEncerramento']."','DD/MM/YYYY')";
	else
		$dataEncerramento= "NULL";
	
	if(trim($_POST[$PREID.'dataProtocolo']) != '')
		$dataProtocolo= "to_date('".$_POST[$PREID.'dataProtocolo']."','DD/MM/YYYY')";
	else
		$dataProtocolo= "NULL";
	
	$qr_insert= "INSERT into tb_processo
(
	pk_processo,
	s_nome,
	s_numero_original,
	s_numero_atual,
	f_valor_causa,
	f_valor_envolvido,
	s_comentario,
	dt_data_distribuicao,
	dt_data_encerramento,
	dt_data_protocolo,
	fk_fase,
	fk_orgao_judicial,
	fk_criador,
	fk_status,
	fk_escritorio_associado,
	fk_instancia_processo,
	fk_natureza_acao,
	fk_rito,
	fk_probabilidade_exito,
	fk_pos_cliente
)
VALUES
(
	".$pk_processo.",
	'".$_POST['processoNomeInterno']."',
	'".$_POST['processoNumeroOriginal']."',
	'".$_POST['processoNumeroAtual']."',
	".$_POST['processoValorCausa'].",
	".$_POST['processoValorEnvolvido'].",
	'".$_POST['processoComentario']."',
	".$dataDistribuicao.",
	".$dataEncerramento.",
	".$dataProtocolo.",
	".toNull($_POST[$PREID.'fase_add']).",
	".toNull($_POST[$PREID.'orgao_judicial_add']).",
	".toNull($_SESSION['pk_usuario']).",
	".toNull($_POST[$PREID.'status_processo_add']).",
	".toNull($_POST[$PREID.'escritorio_associado_add']).",
	".toNull($_POST[$PREID.'instancia_processo_add']).",
	".toNull($_POST[$PREID.'natureza_acao_add']).",
	".toNull($_POST[$PREID.'rito_add']).",
	".toNull($_POST[$PREID.'prob_exito_add']).",
	".toNull($_POST[$PREID.'pos_cliente_add'])."
)
";
$data= pg_query($db_connection, $qr_insert);
if(!$data)
 {
	echo $insert."<hr>";
	echo"<script>alert('Falha na tentativa de Cadastro')</script>";
	cancelQuery($db_connection);
	//exit;
 }

 
 //CLIENTE
for($i=0;$i<sizeof($_POST[$PREID.'clienteAddProcesso']);$i++)
{
	$temp = explode('|+|',$_POST[$PREID.'clienteAddProcesso'][$i]);
	$qr_select= "SELECT pk_pasta,
							fk_usuario,
							s_nome,
							vfk_pasta_pai
					   FROM tb_pasta p,
							tb_usuario u,
							tb_dados_pessoais dp
					  WHERE dp.vfk_usuario = u.pk_usuario
						AND p.fk_usuario = u.pk_usuario
						AND dp.bl_status > 0 
						AND u.pk_usuario = ".$temp[0]. "
						limit 1
					";
			$datatemp= @pg_query($db_connection, $qr_select);
			$datatemp = pg_fetch_array($datatemp);
			
	$qr_insert_processo = "
							INSERT INTO tb_processo_pasta
							(
								fk_processo,
								fk_pasta
							)
							VALUES
							(
								".$pk_processo.",
								".$datatemp['pk_pasta']."
							)
	";		
	echo $qr_insert_processo."<br><br><br><br><br>";
	$data = pg_query($db_connection, $qr_insert_processo);
	if(!$data)
	 {
		echo $insert."<hr>";
		echo"<script>alert('Falha na tentativa de Cadastro')</script>";
		cancelQuery($db_connection);
		exit;
	 }
}

//PARTE CONTRARIA
for($i=0;$i<sizeof($_POST[$PREID.'parteContraria']);$i++)
{
	$temp = explode('|+|',$_POST[$PREID.'parteContraria'][$i]);
	$qr_insert_parte_contraria = "INSERT into tb_processo_parte_contraria
	 (	
		fk_processo,
		fk_parte_contraria
	 )
	 VALUES
	 (
		".$pk_processo.",
		".$temp[0]."
	 )";
	$data = pg_query($db_connection, $qr_insert_parte_contraria);
	if(!$data)
	 {
		echo $insert."<hr>";
		echo"<script>alert('Falha na tentativa de Cadastro')</script>";
		cancelQuery($db_connection);
		exit;
	 }
}
	

							 

	echo "<pre>";
	echo "<span style='color:red'>INSERT TB_PROCESSO</span><br>";
	echo $qr_insert;
	echo "</pre>";
	
	echo "<pre>";
	echo "<span style='color:red'>INSERT TB_PROCESSO_PARTE_CONTRARIA</span><br>";
	echo $qr_insert_parte_contraria;
	echo "</pre>";
	
	$broken = breakBy($_POST['list_clientes'],'|-|');
	/*
	foreach($broken as $value)
	{
		$brokenMore = breakBy($value,'|+|');
		$cont = 0;
		foreach($brokenMore as $valueMore)
		{
			if($cont % 3 == 0 && trim($valueMore)!='')
			{
				$qr_insert = "INSERT INTO tb_processo_pasta
								(
									fk_processo,
									fk_pasta
								)
								VALUES
								(
									".$pk_processo.",
									".$valueMore."
								)
							 ";
				$data= pg_query($db_connection, $qr_insert);
				
				 if(!$data)
				 {
					echo $insert."<hr>";
					echo"<script>alert('Falha na tentativa de Cadastro')</script>";
					cancelQuery($db_connection);
					exit;
				 }
				 $cont++;
				 echo $qr_insert."<br>";
			}
		}
	}
	*/
	echo"<br>-----------------------------------------------------<br>";
	showPost();
	commitQuery($db_connection);
}
?>
