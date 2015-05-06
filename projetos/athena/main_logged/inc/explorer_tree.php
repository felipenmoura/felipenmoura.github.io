<?
require_once("valida_sessao.php");
require_once("calendar_input.php");
require_once("styles.php");
require_once("query_control.php");
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
	<?
	exit;
}
?>
<?
	$qr_select="SELECT pk_usuario,
					   s_usuario,
					   bl_cliente,
					   bl_status
				  FROM tb_usuario 
				 WHERE bl_cliente = 1";
	$data= @pg_query($db_connection, $qr_select);
?>
	<table style="margin-left: 7px;">
<?
	while($linha= @pg_fetch_array($data))
	{
		?>
			<tr>
				<tr style="cursor: pointer;"
					code="<? echo $linha['pk_usuario']; ?>"
					onclick="">
					<?
						echo $linha['s_usuario'];
					?>
				</td>
			</tr>
		<?
	}
?>
	</table>