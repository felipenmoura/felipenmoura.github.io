<?php
/*
	cole este exemplo no arquivo php de destino, chamado pelo exemplo em javascript

	EXEMPLO: 
	<?php
		include("f2j_elo.php");
		$receivedIco= f2j_elo($_POST['icone']);
		print_r($receivedIco);
	?>
*/
	function f2j_elo($imp)
	{
		$imp= explode('| f2j_elo_style |', $imp);
		$style= $imp[1];
		$imp= $imp[0];
		$imp= explode('| |', $imp);
		$retorno= Array();
		foreach($imp as $a)
		{
			$v= explode('==', $a);
			if(trim($v[0]) != '' && trim($a) !== '')
			{
				$retorno[$v[0]]= $v[1];
			}
		}
		if(trim($style) != '')
		{
			$style= explode('| |', $style);
			$retorno['style']= Array();
			foreach($style as $b)
			{
				$v= explode('=', $b);
				if(trim($v[0]) != '' && trim($b) !== '')
				{
					$retorno['style'][$v[0]]= $v[1];
				}
			}
		}
		return $retorno;
	}

/*
	cole este exemplo em um arquivo
	
	EXEMPLO: 
	<script src="f2j_elo.php"></script>
	<div id="exemplo" style="width: 100%; height: 100%; border: solid 1px black;">Conteudo do div teste</div>
	<script language="javascript">
		icoToSend= new f2j_elo('exemplo', 'icone');
		icoToSend.sendNode('save_ico.php', callBackFunc);
		function callBackFunc(retorno)
		{
			alert(retorno);
		}
	</script>
*/
if(!$_POST)
{
	?>
	function f2j_elo(obj, nomeObj)
	{
		obj= obj.tagName? obj: document.getElementById(obj);
		
		this.ajaxObj= function ()
		{
			var ajaxObj;
			try
			{
				ajaxObj= new XMLHttpRequest();		//	Para brawser que nao sejam o IE
				ajaxObj.overrideMimeType("index.html");		//	Nome do documento a ser carregado
			}
			catch (eee)
			{
				try
				{
					ajaxObj= new ActiveXObject("Msxm12.XMLHTTP");		//	Para Ie
				}
				catch (ee)
				{
					try
					{
						ajaxObj=new ActiveXObject("Microsoft.XMLHTTP");	//	Para Ie de outra versão
					}
					catch (e)
					{
						ajaxObj=false;
					}
				}
			}
			return ajaxObj;
		}
		
		this.obj= obj;
		this.dados = nomeObj+'=';
		for(var x in this.obj)
		{
			if(this.obj[x] != null && this.obj[x]!= '' && x!='style')
				this.dados+= '|+|'+x+'=='+escape(this.obj[x]);
		}
		this.dados+= "|+f2j_elo_style+|";
		for(var y in this.obj.style)
		{
			if(this.obj.style[y] != null && this.obj.style[y]!= '')
				this.dados+= '|+|'+y+'='+this.obj.style[y];
		}
		this.sendNode= function (url, eloCallBackFunc)
		{
			ajax= new this.ajaxObj();	//	Inicia o Ajax
			ajax.open("POST", url, true);	//	abre o Ajax 
			ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.onreadystatechange =  function ()
											{
												if(ajax.readyState == 4)
												{
													if(eloCallBackFunc)
														eval(eloCallBackFunc(ajax.responseText));
												}
											}
			ajax.send(this.dados);
		}
		
		return this;
	}
<?php
}
?>