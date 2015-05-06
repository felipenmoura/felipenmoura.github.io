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
<link href="../styles/estilos.css" rel="stylesheet" type="text/css">
<script src="../scripts/flp_tree.js"></script>
<script src="../scripts/tooltip.js"></script>

<body leftmargin="0"
	  topmargin="0"
	  bottommargin="0"
	  rightmargin="0"
	  oncontextmenu="return false">
	<table style="width: 100%;
				  height: 100%;">
		<tr>
			<td style="">
				<div id="div_tree"
					 style="width: 100%;
							height: 100%;
							overflow: auto;
							background-color:#f5f5f5;
							border :1px solid Silver;">
					Explorar
				</div>
			</td>
		</tr>
		<tr>
			<td style="height: 30px;
					   text-align: center;">
				<div style="width: 100%;
							height: 100%;
							overflow: auto;
							background-color:#f5f5f5;
							border :1px solid Silver;
							text-aqlign: center;">
				<?php
					if($_GET['return'])
					{
						?>
							<input type="button"
								   class="botao"
								   value="Ok"
								   onclick="retornaSelecao('<? echo $_GET['return']; ?>')">
						<?php
					}
				?>
					<input type="button"
						   class="botao"
						   value="Cancelar"
						   onclick="unloadding();">
				</div>
			</td>
		</tr>
	</table>
</body>
<script>

	function retornaSelecao(tipo)
	{
		// (id, label, parentElement, code, tipo, cliente)
		ar_tiposPermitidos= tipo.split('/');
		retorna= false;
		if(!selectedNode)
			return false;
		for(i=0; i<ar_tiposPermitidos.length; i++)
		{
			if(ar_tiposPermitidos[i] == selectedNode.getAttribute('tipo'))
				retorna= true;
		}
		if(retorna!= true)
			return false;
		targetReturn.value= selectedNode.getAttribute('code')+' - '+selectedNode.innerHTML;
		targetReturn.setAttribute('code', selectedNode.getAttribute('code'));
		targetReturn.setAttribute('tipo', selectedNode.getAttribute('tipo'));
		targetReturn.setAttribute('cliente', selectedNode.getAttribute('cliente'));
		//alert(selectedNode.getAttribute('clinte'));
		unloadding();
	}

	// recebe o objeto de retorno na variavel targetReturn;

	function keyPressing()
	{
		kCode= event.keyCode;
		if(kCode == 27)
		{
			top.close();
			opener.focus();
			opener.top.lockUse(false);
		}
	}
	
	function unloadding()
	{
		opener.focus();
		opener.top.lockUse(false);
		try
		{
			window.close();
		}catch(e){}
	}
	
	document.onkeydown= keyPressing;
	window.onunload= unloadding;
</script>
<script>
	arv= new tree('div_tree');
	<?
		$qr_selectCliente= "   SELECT pk_dados_pessoais,
										  s_usuario
									 FROM tb_dados_pessoais,
										  tb_pess_juridica j
									WHERE vfk_usuario isnull
									  AND j.fk_dados_pessoais = pk_dados_pessoais
									  AND bl_status = 1
									ORDER BY s_usuario";
		$dataCli= pg_query($db_connection, $qr_selectCliente);
		while($linhaCli= @pg_fetch_array($dataCli))
		{
			echo "arv.addNode('".$linhaCli['pk_dados_pessoais'].'_filial_contato'."',
							  '".$linhaCli['s_usuario']."',
							  false,
							  '".$linhaCli['pk_dados_pessoais']."',
							  'cliente',
							  '".$linhaCli['pk_dados_pessoais']."',
							  '".$linhaCli['c_sexo']."'
							  );";
		}
	?>
	/*
	arv.addNode('2', 'testando 2');
	arv.addNode('3', 'testando 3');
	/*arv.addNode('4', 'testando 4');
	arv.addNode('5', 'testando 5', '2');
	arv.addNode('6', 'testando 6', '2');
	arv.addNode('7', 'testando 7', '1');
	arv.addNode('8', 'testando 8', '1');
	arv.addNode('9', 'testando 9', '1');
	arv.addNode('10', 'testando 10', '4');
	arv.addNode('11', 'testando 11', '7');
	arv.addNode('12', 'testando 12', '11');
	*/
</script>



