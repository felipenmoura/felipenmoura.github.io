function liClick()
{
	listas= this.parentNode.getElementsByTagName('UL');
	if(selectedNode!= null)
		//selectedNode.style.fontWeight= 'normal';
		selectedNode.style.textDecoration= 'none';
	//this.style.fontWeight= 'bold';
	this.style.textDecoration= 'underline';
	selectedNode= this;
	try
	{
		this.aoClicar();
	}catch(error)
	{
	}
	if(this.getAttribute('noExpand'))
		return false;
	if(listas.length < 1)
		return false;
	if(listas[0].style.display == '')
		display= 'none';
	else
		display= '';
	if(this.getAttribute('tipo') != 'cliente' && this.getAttribute('tipo') != 'busca')
	{
		if(display== '')
			this.setAttribute('className', 'listaAberta');
		else
			this.setAttribute('className', 'listaFechada');
	}
	for(i=0; i< listas.length; i++)
	{
		if(listas[i].getAttribute('parentTreeNode').id == this.parentNode.id)
		{
			listas[i].style.display= display;
		}
	}
	/*
		pega o nome do cliente, dono da pasta
	*/
}

function mouseover()
{
	if(this.style.backgroundColor == '#dedede')
	{
		this.style.backgroundColor= '';
		this.style.color= '';
	}else{
			this.style.backgroundColor= '#dedede';
			this.style.color= '#000000';
		 }
}

tree = function(objTarget)
{
	this.gebi   			 = function (id){ return document.getElementById(id); }
	this.addNode			 = null;
	this.container 			 = this.gebi(objTarget); // objeto que conterá a arvore
	this.tree				 = document.createElement('UL');
	this.tree.setAttribute('className', 'listaFechada');
	this.treeLI				 = document.createElement('LI');
	this.treeLI.innerHTML    = this.container.innerHTML;
	this.container.innerHTML = '';
	this.tree.appendChild(this.treeLI);
	this.container.appendChild(this.tree);
	this.treeElement= document.createElement('UL');
	this.treeElement.setAttribute('className', 'listaFechada');
	this.tree.appendChild(this.treeElement);
	this.root= this.treeElement;
	this.addNode= function(id, label, parentElement, code, tipo, cliente, sexo, dbClickFunc, display, aoclick, noExpand)
	{
		//alert(id+' '+label+' '+parentElement+' '+code+' '+tipo);
		if(!parentElement)
		{
			this.parentNode= this.root;
		}else{
				this.parentNode= document.getElementById(parentElement);
				newUl= document.createElement('UL');
				newUl.setAttribute('style', '');
				newUl.setAttribute('parentTreeNode', this.parentNode);
				newUl.style.display= 'none';
				newUl.setAttribute('className', 'listaFechada');
				this.parentNode.appendChild(newUl);
				this.parentNode= newUl;
				if(display == true)
					newUl.style.display= '';
				//newUl.style.backgroundImage= 'url(img/back_body.gif)';
				//newUl.style.backgroundRepeat= 'reapeat-y';
			 }
		this.treeLi= document.createElement('LI');
		this.treeLi.setAttribute('id', id);
		//this.treeLi.innerHTML= label;
		span= document.createElement('span');
		span.innerHTML= label;
		span.setAttribute('text', label);
		span.setAttribute('style', '');
		span.style.paddingLeft= '2px';
		span.style.paddingRight= '5px';
		span.style.whiteSpace= 'nowrap';
		
		//span.style.backgroundImage= 'url(img/back_body.gif)';
		//span.style.backgroundRepeat= 'reapeat-y';
		
		if(code)
			span.setAttribute('code', code);
		if(tipo)
		{
			span.setAttribute('tipo', tipo);
			if(tipo == 'processo')
				this.treeLi.setAttribute('className', 'listaProc');
			else if(sexo)
				 {
					this.treeLi.setAttribute('className', 'pessoa_'+sexo);
				 }else if(tipo == 'cliente')
							this.treeLi.setAttribute('className', 'pessoa_j');
					   else if(tipo == 'busca')
								this.treeLi.setAttribute('className', 'busca');
							else if(tipo == 'contato')
									this.treeLi.setAttribute('className', 'pessoa_'+sexo);
								else if(tipo == 'filial')
									this.treeLi.setAttribute('className', 'filial');
		}
		if(cliente)
			span.setAttribute('cliente', cliente);
		if(sexo)
			span.setAttribute('sexo', sexo);
		if(noExpand)
		{
			span.setAttribute('noExpand', noExpand);
		}
		this.treeLi.appendChild(span);
		this.parentNode.appendChild(this.treeLi);
		span.onclick= liClick;
		if(dbClickFunc)
		{
			span.noDblClick= dbClickFunc;
			span.ondblclick= dbClickFunc;
		}
		if(aoclick)
		{
			span.aoClicar= aoclick;
		}
		span.onmouseover= mouseover;
		span.onmouseout= mouseover;
		return this;
	}
	return this;
}