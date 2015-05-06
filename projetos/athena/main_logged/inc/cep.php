<?php   
	/* 
	 *  Função de busca de Endereço pelo CEP 
	 *  Utilizando WebService de CEP da republicavirtual.com.br 
	 */
	function busca_cep($cep)
	{  
		clearstatcache(); // limpa o cache, caso o servidor tenha mantido algo armasenado, entre arquivos
		// busca os dados do webservice em republicavirtual.com.br enviando como variavel cep, o parametro enviado para esta funcao
	    $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');
	    if(!$resultado)
		{
			$resultado = "false";
	    }
	    parse_str($resultado, $retorno);   
	    return $retorno;  
	}
	/* 
	 * Exemplo de utilização  
	 */
	$resultado_busca = busca_cep($_GET['cep']);  
	switch($resultado_busca['resultado'])
	{
	    case '2':
		{
	        $texto = "cepRetornado= Array();
		    cepRetornado['cidade']= '".$resultado_busca['cidade']."';
		    cepRetornado['UF']= '".$resultado_busca['uf']."';
	       ";
		}
	    break;
	    case '1':
		{
	        $texto = "cepRetornado= Array();
		    cepRetornado['tipoLogradouro']= '".urlencode($resultado_busca['tipo_logradouro'])."';
		    cepRetornado['logradouro']= '".urlencode($resultado_busca['logradouro'])."';
		    cepRetornado['bairro']= '".urlencode($resultado_busca['bairro'])."';
		    cepRetornado['cidade']= '".urlencode($resultado_busca['cidade'])."';
		    cepRetornado['UF']= '".$resultado_busca['uf']."';
		        ";
		}
	    break;
	    default:
	        $texto = "false";
	    break;
	}
	echo $texto;
?>  



