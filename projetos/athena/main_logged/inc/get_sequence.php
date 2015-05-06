<?php
	function getSequence($seq)
	{
		$db_connection = @connectTo();
		$select= "SELECT NEXTVAL('".$seq."')";
		$data= @pg_query($db_connection, $select);
		$retorno = @pg_fetch_array($data);
		echo "<hr>".$seq.": ".$retorno[nextval]."<hr>";
		return $retorno[nextval];
	}
?>