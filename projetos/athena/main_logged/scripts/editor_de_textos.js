	function makeEditor(objId, content)
	{
		setTimeout("obj=document.frames; obj=obj['editor_de_textos_"+objId+"']; obj.document.body.innerHTML= '"+content+"'; obj.document.designMode = 'on';", 500);
		
	}

	function recortar(objId)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		obj.document.execCommand('cut', false, null);
	}

	function insertImage(objId)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		obj.document.execCommand("InsertImage", "", 'url_da_imagem');
	}
	
	function copiar(objId)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		obj.document.execCommand('copy', false, null);
	}
	
	function colar(objId)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		obj.document.execCommand('paste', false, null);
	}

	function desfazer(objId)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		obj.document.execCommand('undo', false, null);
	}

	function refazer(objId)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		obj.document.execCommand('redo', false, null);
	}

	function negrito(objId)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		obj.document.execCommand('bold', false, null);
	}

	function italico(objId)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		obj.document.execCommand('italic', false, null);
	}

	function sublinhado(objId)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		obj.document.execCommand('underline', false, null);
	}

	function alinharEsquerda(objId)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		obj.document.execCommand('justifyleft', false, null);
	}

	function centralizado(objId)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		obj.document.execCommand('justifycenter', false, null);
	}

	function alinharDireita(objId)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		obj.document.execCommand('justifyright', false, null);
	}

	function numeracao(objId)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		obj.document.execCommand('insertorderedlist', false, null);
	}

	function marcadores(objId)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		obj.document.execCommand('insertunorderedlist', false, null);
	}

	function formatFont(objId, valor)
	{
		try
		{
			obj=document.frames;
			obj=obj['editor_de_textos_'+objId];
			obj.document.execCommand('fontname', false, valor);
		}
		catch (error)
		{
		}
	}
	
	function formatFontSize(objId, size)
	{
		try
		{
			obj=document.frames;
			obj=obj['editor_de_textos_'+objId];
			obj.document.execCommand('fontsize', false, size);
		}
		catch (error)
		{
		}
	}
	
	function printTextEditor(objId)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		obj.document.execCommand('Print')
	}
	
	function saveAs(objId, titleDoc)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		obj.document.execCommand('SaveAs', 'Agiplan - '+titleDoc+'.doc');
	}
	
	function saveTextEditor(objId)
	{
		obj=document.frames;
		obj=obj['editor_de_textos_'+objId];
		document.getElementById('textEditorContent_'+objId).value= obj.document.body.innerHTML;
	}