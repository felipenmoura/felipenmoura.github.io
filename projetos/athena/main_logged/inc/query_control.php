<?
function startQuery($conexao)
{
	$data= pg_query($conexao, "BEGIN TRANSACTION");
	if(!$data)
	{
		?>
			<script>
				alert('Ocorreu um erro durante uma transação com o banco');
				top.setLoad(false);
			</script>
			<!--
				<flp_script>
					alert('Ocorreu um erro durante uma transação com o banco');
			-->
		<?
		exit;
	}else{
			?>
				<script>
					//alert('Ok');
					top.setLoad(false);
				</script>
			<?
			return true;
		 }
}

function cancelQuery($conexao)
{
	$data= pg_query($conexao, "ROLLBACK TRANSACTION");
	if(!$data)
	{
		?>
			<script>
				alert('Ocorreu um erro durante uma transação com o banco');
				top.setLoad(false);
			</script>
			<!--
				<flp_script>
					alert('Ocorreu um erro durante uma transação com o banco');
			-->
		<?
		exit;
	}else{
			?>
				<script>
					//alert('Ok');
					top.setLoad(false);
				</script>
			<?
			return true;
		 }
}

function commitQuery($conexao)
{
	$data= pg_query($conexao, "COMMIT TRANSACTION");
	if(!$data)
	{
		?>
			<script>
				alert('Ocorreu um erro durante uma transação com o banco');
				top.setLoad(false);
			</script>
			<!--
				<flp_script>
					alert('Ocorreu um erro durante uma transação com o banco');
			-->
		<?
		exit;
	}else{
			?>
				<script>
					//alert('Ok');
					top.setLoad(false);
				</script>
			<?
			return true;
		 }
}

function getId($conexao,$sequence_name)
{
	$query = "SELECT nextval('".$sequence_name."') as nxtVal;";
	$data= pg_query($conexao, $query);
	$linha = pg_fetch_row($data);
	return $linha[0];

}

function toNull($val)
{
	return ((trim($val) == '')? 'NULL' : $val);
}

?>