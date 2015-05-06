//  animação para FECHAR os blocos e janelas

function closeAnim(obj)
{
	obj= (obj.tagName)? obj: document.getElementById(obj);
	if(conf_closeAnim == true)
	{
		x= obj.offsetLeft;
		y= obj.offsetTop;
		h= obj.offsetHeight;
		w= obj.offsetWidth;
		tmpDiv= document.createElement('DIV');
		tmpDiv.setAttribute('style', '');
		tmpDiv.style.position = 'absolute';
		tmpDiv.style.left	  = x;
		tmpDiv.style.top	  = y;
		tmpDiv.style.height	  = h;
		tmpDiv.style.width	  = w;
		tmpDiv.style.border= 'solid 2px #dedede';
		tmpDiv.style.zIndex= zMax+10;
		//tmpDiv.style.overflow= 'none';
		//tmpDiv.style.backgroundColor= '#dedede';
		//tmpDiv.innerHTML= '<br>&nbsp;';
		document.body.appendChild(tmpDiv);
		tmpDiv.setAttribute('id', obj.id);
		document.body.removeChild(obj);
		delete obj;
		metadeX= w/2;
		metadeY= h/2;
		
		nextStep_x= x+(metadeX/8);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 100);
		nextStep_x= x+(metadeX/4);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 200);
		nextStep_x= x+(metadeX/2);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 300);
		nextStep_x= x+(metadeX/1.5);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 400);
		nextStep_x= x+ metadeX;
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 500);
		
		nextStep_y= y+(metadeY/8);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 100);
		nextStep_y= y+(metadeY/4);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 200);
		nextStep_y= y+(metadeY/2);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 300);
		nextStep_y= y+(metadeY/1.5);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 400);
		nextStep_y= y+ metadeY;
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 500);
		
		nextStep_w= w - (w/8)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 100);
		nextStep_h= h - (h/8)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 100);
		
		nextStep_w= w - (w/4)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 200);
		nextStep_h= h - (h/4)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 200);
		
		nextStep_w= w - (w/2)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 300);
		nextStep_h= h - (h/2)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 300);
		
		nextStep_w= w - (w/1.5)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 400);
		nextStep_h= h - (h/1.5)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 400);
		
		nextStep_w= w - w;
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 500);
		nextStep_h= h - h;
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 500);
		
		setTimeout("document.body.removeChild(document.getElementById('"+tmpDiv.id+"'))", 510);
	}else{
			document.body.removeChild(obj);
			delete obj;
		 }
	arBlocos= getBlocks();
	blockInFocus= null;
	top.blockInFocus= null;
	if(arBlocos.length > 0)
	{
		setBlur();
		//setFocus(arBlocos[arBlocos.length-1]);
		// blockInFocus= arBlocos[arBlocos.length-1];
		// top.blockInFocus= arBlocos[arBlocos.length-1];
	}
	//top.removeApp(obj.id);
}

//  animação para MINIMIZAR os blocos e janelas
function minimizeAnim(obj)
{
	obj= (obj.tagName)? obj: document.getElementById(obj);
	if(conf_minAnim == true)
	{
		x= obj.offsetLeft;
		y= obj.offsetTop;
		h= obj.offsetHeight;
		w= obj.offsetWidth;
		tmpDiv= document.createElement('DIV');
		tmpDiv.setAttribute('style', '');
		tmpDiv.style.position = 'absolute';
		tmpDiv.style.left	  = x;
		tmpDiv.style.top	  = y;
		tmpDiv.style.height	  = h;
		tmpDiv.style.width	  = w;
		tmpDiv.style.zIndex= zMax+1;
		tmpDiv.style.border= 'solid 2px #a6a6a6';
		tmpDiv.style.zIndex= zMax+10;
		//tmpDiv.style.backgroundColor= '#dedede';
		//tmpDiv.style.overflow= 'none';
		//tmpDiv.innerHTML= '<br>&nbsp;';
		document.body.appendChild(tmpDiv);
		tmpDiv.setAttribute('id', obj.id+'_anim');
		//metadeX= w/2;
		//metadeY= h/2;
		
		nextStep_x= x-(x/8);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 100);
		nextStep_x= x-(x/4);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 200);
		nextStep_x= x-(x/2);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 300);
		nextStep_x= x-(x/1.5);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 400);
		nextStep_x= (x- x)+10;
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 500);
		
		nextStep_y= y+((document.body.clientHeight-y)/8);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 100);
		nextStep_y= y+((document.body.clientHeight-y)/4);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 200);
		nextStep_y= y+((document.body.clientHeight-y)/2);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 300);
		nextStep_y= y+((document.body.clientHeight-y)/1.5);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 400);
		nextStep_y= y+ (document.body.clientHeight-y);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 500);
		
		nextStep_w= w - (w/8)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 100);
		nextStep_h= h - (h/8)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 100);
		
		nextStep_w= w - (w/4)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 200);
		nextStep_h= h - (h/4)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 200);
		
		nextStep_w= w - (w/2)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 300);
		nextStep_h= h - (h/2)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 300);
		
		nextStep_w= w - (w/1.5)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 400);
		nextStep_h= h - (h/1.5)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 400);
		
		nextStep_w= w - w;
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 500);
		nextStep_h= h - h;
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 500);
		
		//setTimeout('document.getElementById("'+tmpDiv.id+'").style.backgroundColor= ""; ', 300);
		
		setTimeout("document.body.removeChild(document.getElementById('"+tmpDiv.id+"'))", 510);
	}
}

//  animação a ser executada ao retornar do estado de minimizado
function minimizeReturnAnim(obj, barObj)
{
	obj= (obj.tagName)? obj: document.getElementById(obj);
	if(conf_minAnim == true)
	{
		x= parseInt(obj.style.left);
		y= parseInt(obj.style.top);
		h= parseInt(obj.style.height);
		w= parseInt(obj.style.width);
		tmpDiv= document.createElement('DIV');
		tmpDiv.setAttribute('style', '');
		tmpDiv.style.position = 'absolute';
		tmpDiv.style.left	  = 20;
		tmpDiv.style.top	  = document.body.clientHeight - 60;
		tmpDiv.style.height	  = 0;
		tmpDiv.style.width	  = 0;
		tmpDiv.style.zIndex= zMax+1;
		tmpDiv.style.border= 'solid 2px #a6a6a6';
		tmpDiv.style.zIndex= zMax+10;
		//tmpDiv.style.overflow= 'none';
		//tmpDiv.style.backgroundColor= '#dedede';
		//tmpDiv.innerHTML= '<br>&nbsp;';
		document.body.appendChild(tmpDiv);
		tmpDiv.setAttribute('id', obj.id+'_anim');
		//metadeX= w/2;
		//metadeY= h/2;
		
		nextStep_x= x-(x/8);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 500);
		nextStep_x= x-(x/4);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 400);
		nextStep_x= x-(x/2);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 300);
		nextStep_x= x-(x/1.5);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 200);
		nextStep_x= x- x;
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 100);
		
		nextStep_y= y+((document.body.clientHeight-y)/8);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 500);
		nextStep_y= y+((document.body.clientHeight-y)/4);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 400);
		nextStep_y= y+((document.body.clientHeight-y)/2);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 300);
		nextStep_y= y+((document.body.clientHeight-y)/1.5);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 200);
		nextStep_y= y+ (document.body.clientHeight-y);
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 100);
		
		nextStep_w= w - (w/8)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 500);
		nextStep_h= h - (h/8)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 500);
		
		nextStep_w= w - (w/4)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 400);
		nextStep_h= h - (h/4)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 400);
		
		nextStep_w= w - (w/2)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 300);
		nextStep_h= h - (h/2)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 300);
		
		nextStep_w= w - (w/1.5)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 200);
		nextStep_h= h - (h/1.5)
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 200);
		
		nextStep_w= w - w;
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 100);
		nextStep_h= h - h;
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 100);
		
		setTimeout('document.getElementById("'+tmpDiv.id+'").style.backgroundColor= "#dedede"; ', 300);
		
		obj.style.zIndex= zMax+1;
		zMax++;
		//setFocus(document.getElementById(obj.id));
		//document.getElementById(obj.id).style.display= '';
		setTimeout(" document.getElementById('"+obj.id+"').style.display= ''; setFocus(document.getElementById('"+obj.id+"')); document.body.removeChild(document.getElementById('"+tmpDiv.id+"')); ", 510);
	}else{
			obj.style.display= '';
			setFocus(obj);
		 }
	top.bar.removeChild(barObj);
}

// ao carregar o bloco

function openAnim(obj, barObj, event)
{
	obj= (obj.tagName)? obj: document.getElementById(obj);
	if(conf_minAnim == true && top.document.getElementById('div_abertura').style.display != '')
	{
		x= parseInt(obj.style.left);
		y= parseInt(obj.style.top);
		
		h= (parseInt(obj.style.height))? parseInt(obj.style.height): 50;
		w= (parseInt(obj.style.width))? parseInt(obj.style.width): 90;
		tmpDiv= document.createElement('DIV');
		tmpDiv.setAttribute('style', '');
		tmpDiv.style.position = 'absolute';
		tmpDiv.style.left	  = 20;
		tmpDiv.style.top	  = 50;
		tmpDiv.style.height	  = 0;
		tmpDiv.style.width	  = 0;
		tmpDiv.style.zIndex= zMax+1;
		tmpDiv.style.border= 'solid 2px #a6a6a6';
		tmpDiv.style.zIndex= zMax+10;
		
		try
		{
				// startY= event.srcElement.offsetTop + event.srcElement.offsetHeight;
				// startX= event.srcElement.offsetLeft + event.srcElement.offsetWidth;
				startY= 0;
				startX= 0;
				document.body.appendChild(tmpDiv);
				tmpDiv.setAttribute('id', obj.id+'_anim');
				
				nextStep_x= x-(x/8);
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 500);
				nextStep_x= x-(x/4);
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 400);
				nextStep_x= x-(x/2);
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 300);
				nextStep_x= x-(x/1.5);
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 200);
				nextStep_x= x- x;
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.left= "'+nextStep_x+'px"; ', 100);
				
				nextStep_y= startY+(y/8);
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 100);
				nextStep_y= startY+(y/4);
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 200);
				nextStep_y= startY+(y/2);
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 300);
				nextStep_y= startY+(y/1.5);
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 400);
				nextStep_y= startY+y;
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.top= "'+nextStep_y+'px"; ', 500);
				
				nextStep_w= w - (w/8)
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 500);
				nextStep_h= h - (h/8)
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 500);
				
				nextStep_w= w - (w/4)
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 400);
				nextStep_h= h - (h/4)
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 400);
				
				nextStep_w= w - (w/2)
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 300);
				nextStep_h= h - (h/2)
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 300);
				
				nextStep_w= w - (w/1.5)
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 200);
				nextStep_h= h - (h/1.5)
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 200);
				
				nextStep_w= w - w;
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.width= "'+nextStep_w+'px"; ', 100);
				nextStep_h= h - h;
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.height= "'+nextStep_h+'px"; ', 100);
				
				setTimeout('document.getElementById("'+tmpDiv.id+'").style.backgroundColor= "#dedede"; ', 300);
				
			obj.style.zIndex= zMax+1;
			zMax++;
			//setFocus(document.getElementById(obj.id));
			//document.getElementById(obj.id).style.display= '';
			setTimeout(" document.getElementById('"+obj.id+"').style.display= ''; setFocus(document.getElementById('"+obj.id+"')); document.body.removeChild(document.getElementById('"+tmpDiv.id+"')); ", 510);
		}catch(error){
						obj.style.display= '';
						setFocus(obj);
					 }
	}else{
			obj.style.display= '';
			setFocus(obj);
		 }
}





/********************/
//   ANIMAÇÕES	 LIB//
/*******************/

function cutOpen(obj)
{
/*
	obj= document.getElementById(obj);
	wAtual= parseInt(obj.style.width);
	hAtual= parseInt(obj.style.height);
	
	hFinal= obj.getAttribute('hFinal');
	
	obj.style.top= parseInt(obj.style.top)-10;
	obj.style.height= hAtual+20;
	
	if(hAtual < hFinal)
	{
		setTimeout("cutOpen('"+obj.id+"')", 20);
	}else{
			obj.style.height= hFinal;
			obj.style.overflow= 'auto';
		}
	*/
}

function fadeOut(objId)
{
	obj= document.getElementById(objId);
	objSelectLists= obj.getElementsByTagName('SELECT');
	for(i=0; i< objSelectLists.length; i++)
	{
		objSelectLists[i].style.display= 'none';
	}
	i=0;
	for(count=10; count>0; count--)
	{
		i= i+50;
		try
		{
			setTimeout("setOpacity('"+objId+"', "+(10*count)+");", i);
		}catch(error)
		{}
	}
	setTimeout("document.body.removeChild(document.getElementById('"+objId+"'));", 500);
}
