<?
	function connectTo()
	{
		$conexao = "host=localhost  port=5432 dbname=athena  user='root' password='1234'";
		$connect = pg_connect($conexao);
		
		if(!$connect)
		{
			echo $connect;
			echo "<script> alert('Ocorreu um erro inesperado durante a tentativa de conexão com o banco de dados! \\n Tente novamente em alguns minutos, caso o problema persista, entre em contato com o suporte');</script>";
			exit();
			return false;
		}
		return $connect;
	}
?>