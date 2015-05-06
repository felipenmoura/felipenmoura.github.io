<?php
	//Funçao que quebra uma String pelo parametro passado
	function breakBy($string,$caracter)
	{
		$retorno = explode($caracter,$string);
		return $retorno;
	}
?>