<?php
//session_start();
//$acessoWeb= 2;
require_once("inc/valida_sessao.php");
require_once("inc/styles.php");
require_once("inc/query_control.php");
require_once("inc/calendar_input.php");
require_once("inc/class_explorer.php");

if(!$db_connection)
{
	include("../connections/flp_db_connection.php");
	$db_connection = connectTo();
}

if ($_GET['pk_usuario'])
{
	$_GET['pk_cliente'] = $_GET['pk_usuario'];
	$_GET['pk_usuario'] = false;
	unset($_GET['pk_usuario']);
}



// SELECIONA DADOS PESSOAIS
$select_dados_pessoais = "select 
								  U.s_login,
							      U.s_senha,
								  U.bl_tipo_pessoa,
							      D.s_usuario,
								  U.pk_usuario,
							      D.c_sexo,
							      D.web_site as web_site,
							      D.txt_obs,
								  D.pk_dados_pessoais
						  from tb_usuario U
						  inner join tb_dados_pessoais D
						  on (D.vfk_usuario = U.pk_usuario)
						  where U.bl_cliente=1
						  and D.bl_status=1
						  and U.pk_usuario = ".$_GET['pk_cliente'];
		  
$r_dados_pessoais= pg_query($db_connection, $select_dados_pessoais);
$linha_dados_pessoais=pg_fetch_array($r_dados_pessoais);
$_GET['pk_dados_pessoais'] = $linha_dados_pessoais['pk_dados_pessoais'];

?>
	<table width="100%">
		<tr>
			<td class="gridTitle">
				<?php
					echo htmlentities($linha_dados_pessoais['s_usuario']);
				?>
			</td>
		</tr>
	</table>
<?php
	if ($linha_dados_pessoais['bl_tipo_pessoa'] == 'F')
	{
		include("ger_cliente_edit_pess_fisica.php");
	}else
		{
			echo "<div style='width: 100%;
							  height: 100%;
							  overflow: scrol-y;'>";
				include("ger_cliente_edit_pess_juridica.php");
			echo "</div>";
		}
?>