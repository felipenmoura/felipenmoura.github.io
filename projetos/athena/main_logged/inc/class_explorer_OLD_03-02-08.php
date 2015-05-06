<?
	class explorer
	{
		function makeExplorer($type, $root)
		{
		}
		
		function showExplorer()
		{
		}
		function clearExplorer()
		{
		}
	}
	
	function explorerAdd($id, $valor, $name, $tipo, $add)
	{
		if(!$name) $name= $id;
		?>
			<span style="white-space: no-wrap;">
				<img src="../img/new_cliente.png"
					 style="cursor:pointer"
					 onclick="creatBlock('<?php echo $add['nome'] ?>', '<?php echo $add['url'] ?>', '<?php echo $add['id'] ?>');"
					 onmouseover="showtip(this, event, 'Cadastrar Novo Cliente')">
				<img src="../img/list_clientes.png"
					 style="cursor:pointer;"
					 onclick="explorerReturn= window.open('inc/explorer_data.php?return=<? echo $tipo; ?>', 'explorer_retun', 'width=450,height=300,top='+((screen.height/2)-200)+',left='+((screen.width/2)-250)+',scrollbars=yes,resizable=yes,directories=no,location=no,menubar=no,status=no,titlebar=no,toolbar=no');
								top.lockUse(true, explorerReturn);
								explorerReturn.targetReturn= document.getElementById('<? echo $id; ?>');
								explorerReturn.targetCode= document.getElementById('<? echo $id; ?>_SUB');"
					   onmouseover="showtip(this, event, 'Listar todos Clientes')">&nbsp;&nbsp;
					<input type="button"
						   value="+"
						   onmouseover="showtip(this, event, 'Cadastrar mai um Cliente para este Processo')"
						   onclick="if(document.getElementById('processoPasta').value != '')
									{
										addLitisConsorcio();
										addToList('processoClienteList', 'processoPasta,processoPasta_SUB');
										document.getElementById('processoPasta').value='';
									}"
						   class="botao_caract">
				<br>
				<input id="<? echo $id; ?>"
					   name="<? echo $name; ?>_TOP"
					   type="text"
					   value="<? echo $valor; ?>"
					   readonly> 
				<img src="img/clear.gif"
					 style="cursor: pointer;"
					 onmouseover="showtip(this, event, 'Limpar')"
					 onclick="document.getElementById('<? echo $id; ?>').value= ''">
				<input id="<? echo $id; ?>_SUB"
					   name="<? echo $name; ?>"
					   type="hidden"
					   value="<? echo $valor; ?>">
			</span>
		<?
	}
	
	function filialAdd($id, $valor, $name, $tipo)
	{
		if(!$name) $name= $id;
		{
		?>
			<span style="white-space: no-wrap;">
				<input id="<? echo $id; ?>"
					   name="<? echo $name; ?>"
					   type="text"
					   value="<? echo $valor; ?>"
					   readonly
					   style="cursor: pointer;"
					   onclick="explorerReturn= window.open('inc/explorer_filial.php?return=<? echo $tipo; ?>', 'explorer_retun', 'width=450,height=300,top='+((screen.height/2)-200)+',left='+((screen.width/2)-250)+',scrollbars=yes,resizable=yes,directories=no,location=no,menubar=no,status=no,titlebar=no,toolbar=no');
								top.lockUse(true, explorerReturn);
								explorerReturn.targetReturn= this;"
					   onmouseover="showtip(this, event, 'Abre o Explorador para sele&ccedil;&atilde;o')"> 
				<img src="img/clear.gif"
					 style="cursor: pointer;"
					 onmouseover="showtip(this, event, 'Limpar')"
					 onclick="document.getElementById('<? echo $id; ?>').value= ''">
			</span>
			<img src="img/add.gif"
				 style="cursor: pointer;"
				 onclick="creatBlock('Nova filial', 'agenda_contato_filial.php', 'novo_filial_contatos');">
			<img src="img/help.gif"
				 style="cursor: pointer;"
				 onclick="showHelp('filiais')">
		<?
		}
	}
	
	function contatoAdd($id, $valor, $name, $tipo)
	{
		if(!$name) $name= $id;
		{
		?>
			<nobr>
				<span style="white-space: no-wrap;">
					<input id="<? echo $id; ?>"
						   name="<? echo $name; ?>"
						   type="text"
						   value="<? echo $valor; ?>"
						   label="Respons&aacute;vel"
						   readonly
						   style="cursor: pointer;"
						   onclick="explorerReturn= window.open('inc/explorer_contato_nao_juridico.php?return=<? echo $tipo; ?>', 'explorer_retun', 'width=450,height=300,top='+((screen.height/2)-200)+',left='+((screen.width/2)-250)+',scrollbars=yes,resizable=yes,directories=no,location=no,menubar=no,status=no,titlebar=no,toolbar=no');
									top.lockUse(true, explorerReturn);
									explorerReturn.targetReturn= this;"
						   onmouseover="showtip(this, event, 'Abre o Explorador para sele&ccedil;&atilde;o')"> 
					<img src="img/clear.gif"
						 style="cursor: pointer;"
						 onmouseover="showtip(this, event, 'Limpar')"
						 onclick="document.getElementById('<? echo $id; ?>').value= ''">
				</span>
				<img src="img/add.gif"
					 style="cursor: pointer;"
					 onclick="creatBlock('Novo contato', 'agenda_contato_empresa.php', 'agenda_contato_empresa');"
					 valign="middle">
				<img src="img/help.gif"
					 style="cursor: pointer;"
					 onclick="showHelp('contato')">
			</nobr>
		<?
		}
	}
	
	function contatoFuncionario($id, $valor, $name)
	{
		if(!$name) $name= $id;
		{
		?>
			<nobr>
				<span style="white-space: no-wrap;">
					<input id="<? echo $id; ?>"
						   name="<? echo $name; ?>"
						   type="text"
						   value="<? echo $valor; ?>"
						   required="true"
						   label="Respons&aacute;vel"
						   readonly
						   style="cursor: pointer;"
						   onclick="explorerReturn= window.open('inc/explorer_funcionario.php?return=cliente', 'explorer_retun', 'width=450,height=300,top='+((screen.height/2)-200)+',left='+((screen.width/2)-250)+',scrollbars=yes,resizable=yes,directories=no,location=no,menubar=no,status=no,titlebar=no,toolbar=no');
									top.lockUse(true, explorerReturn);
									explorerReturn.targetReturn= this;
									explorerReturn.targetCode= document.getElementById('<? echo $id; ?>_SUB')"
						   onmouseover="showtip(this, event, 'Abre o Explorador para sele&ccedil;&atilde;o')"> 
					<img src="img/clear.gif"
						 style="cursor: pointer;"
						 onmouseover="showtip(this, event, 'Limpar')"
						 onclick="document.getElementById('<? echo $id; ?>').value= ''">
				</span>
				<img src="img/add.gif"
					 style="cursor: pointer;"
					 onclick="creatBlock('Novo contato', 'agenda_contato_empresa.php', 'agenda_contato_empresa');"
					 valign="middle">
				<img src="img/help.gif"
					 style="cursor: pointer;"
					 onclick="showHelp('contato')">
				<input id="<? echo $id; ?>_SUB"
					   name="<? echo $name; ?>"
					   type="hidden"
					   value="<? echo $valor; ?>"
				>
			</nobr>
		<?
		}
	}
	
?>