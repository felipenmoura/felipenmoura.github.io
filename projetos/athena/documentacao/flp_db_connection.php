<?
	function connectTo()
	{
		$conexao = "host=pgsql-srv03.plugin.com.br  port=5432 dbname=f2jweb  user='f2jweb' password='xeke531'";
		$connect = pg_connect($conexao);
		
		if(!$connect)
		{
			echo $connect;
			echo "<script> alert('Ocorreu um erro inesperado durante a tentativa de conexão com o banco de dados! \\n Tente novamente em alguns minutos, caso o problema persista, entre em contato com o suporte'); top.close(); </script>";
			  echo "<!--<flp_script>alert('Ocorreu um erro inesperado durante a tentativa de conexão com o banco de dados! \\n Tente novamente em alguns minutos, caso o problema persista, entre em contato com o suporte'); top.close(); try{opener.location.href='sair.php'}catch(error){}";
			  exit();
			return false;
		}
		return $connect;
	}
?>