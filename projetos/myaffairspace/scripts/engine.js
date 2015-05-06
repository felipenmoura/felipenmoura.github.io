	var isIe= (document.all)? true: false; // to fix some of the IE bugs
	var __OBJONFOCUS= false;
	var __CONTAINER= false;
	
	function gebi(id)
	{
		return document.getElementById(id);
	}
	function in_array(str, ar)
	{
		for(var x in ar)
		{
			if(ar[x] == str)
				return x;
		}
		return false;
	}
	/***************/
	function loadLink(ret, ajx)
	{
		ret= JSON.parse(ret);
		if(ret.info)
		{
			document.getElementById('info').innerHTML= ret.info;
			$('#info').fadeIn();
		}
		if(ret.mainContent)
		{
			document.getElementById('mainContent').innerHTML= ret.mainContent;
			$('#mainContent').fadeIn();
		}
		if(ret.contacts)
		{
			document.getElementById('contacts').innerHTML= ret.contacts;
			$('#contacts').fadeIn();
		}
		if(ret.groups)
		{
			document.getElementById('groups').innerHTML= ret.groups;
			$('#groups').fadeIn();
		}
		if(ret.historic)
		{
			document.getElementById('historic').innerHTML= ret.historic;
			$('#historic').fadeIn();
		}
	}
	function pageload(hash)
	{
		if(hash)
		{
			var container= __CONTAINER;
			var x = new Ajax();
			x.callBack= loadLink;
			x.url= 'mind.php';
			
			hash= hash.split('/');
			
			var requisition= new Object();
			requisition.type= 'link';
			requisition.post= new Object();
			requisition.post.mindcode= hash[1];
			
			if(container)
				container= container.replace(/ /g, '').split(',');
				
			requisition.post.url= new Object();
			if(!container || in_array('mainContent', container))
				requisition.post.url['mainContent']= hash[0];
			if(!container || in_array('info', container))
				requisition.post.url['info']= 'info';
			if(!container || in_array('contacts', container))
				requisition.post.url['contacts']= 'contacts';
			if(!container || in_array('groups', container))
				requisition.post.url['groups']= 'groups';
			if(!container || in_array('historic', container))
				requisition.post.url['historic']= 'historic';
			
			requisition= JSON.stringify(requisition);
			
			x.addPost('requisition', requisition);
			x.onError= function (status, ajaxObj)
			{
				alert('error');	// TRATAMENTO DE ERROS AQUI
				return false;
			}
			x.call();
			__CONTAINER= false;
		}else{
				//self.location.href= self.location.href;
			 }
	}
	$(document).ready(function()
	{
		$.historyInit(pageload);
		$("a[@rel='dinamicAnchor']").click(function()
		{
			var hash = this.href;
			hash+= '/'+ this.getAttribute('mindcode');
			__CONTAINER= this.getAttribute('container');
			hash = hash.replace(/^.*#/, '');
			$.historyLoad(hash);
			return false;
		});
		scroller.init;
	});
	/* balloonS FUNCTIONS */
	function getAbsolutePosition(obj)
	{
		var x= 0;
		var y= 0;
		while(obj.tagName != 'HTML' && obj.tagName != 'BODY' && obj.parentNode)
		{
			if(true)//obj.tagName != 'TR' && obj.tagName != 'TBODY' && obj.tagName != 'UL' && obj.tagName != 'OL' && obj.tagName != 'SPAN')
			{
				x+= obj.offsetLeft;// + parseInt(obj.style.paddingLeft) + parseInt(obj.style.marginLeft);
				y+= obj.offsetTop;// + parseInt(obj.style.paddingTop) + parseInt(obj.style.marginTop);
			}
			obj= obj.parentNode;
		}
		return [x, y];
	}
	function showballoon(event, obj, idx, l)
	{
		l= (l)? l: 1;
		var balloon= document.getElementById('balloon');
		balloon.style.display= 'none';
		obj.appendChild(balloon);
		obj.appendChild(document.getElementById('balloonArrow'));
		if(__OBJONFOCUS && __OBJONFOCUS != obj) // fixing one more of IE bugs
		{
			__OBJONFOCUS.className= 'contactItem';
		}
		__OBJONFOCUS= obj;
		document.getElementById('balloonAgeData').innerHTML= obj.getAttribute('age');
		document.getElementById('balloonOrientationData').innerHTML= obj.getAttribute('orientation');
		document.getElementById('balloonGenderData').innerHTML= obj.getAttribute('gender');
		balloon.style.display= '';
		balloon.style.left= document.body.clientWidth - ((4-idx) * 100);
		balloon.style.top= (l==1)? ((isIe)? -25: 10): (l==2)? ((isIe)? 75: 100): ((isIe)? 175: 200); // complex just because we have to fix some IE bugs
		if(balloon.offsetLeft + balloon.offsetWidth > document.body.clientWidth - 5)
			balloon.style.left= document.body.clientWidth - balloon.offsetWidth -15;
		if(balloon.offsetTop <= 0 && !isIe)
			balloon.style.top= 2;
		
		document.getElementById('balloonArrow').style.left= balloon.offsetLeft + 25;
		document.getElementById('balloonArrow').style.top= balloon.offsetTop + balloon.offsetHeight - 2;
		document.getElementById('balloonArrow').style.display= '';
	}
	function hiddeballoon()
	{
		document.getElementById('balloon').style.display= 'none';
		document.getElementById('balloonArrow').style.display= 'none';
	}
	function showDialog(msg, messageType, dialogType)
	{
		gebi('dialogButtonOk').style.display= (dialogType == 'alert' || dialogType == 'ok' || !dialogType)? '': 'none';
		gebi('dialogButtonAccept').style.display= (dialogType == 'accept' || dialogType == 2)? '': 'none';
		gebi('dialogButtonApprove').style.display= (dialogType == 'approve' || dialogType == 3)? '': 'none';
		gebi('dialogTitle').innerHTML= messageType;
		gebi('dialogMessage').innerHTML= (messageType == 'Error' || messageType == 'Alert' || messageType == 'Information' || messageType == 'Question')? "<center><img src='img/"+messageType+".gif'/></center>"+msg: msg;
		gebi('lockDiv').style.display= '';
	}
	function closeDialog()
	{
		gebi('lockDiv').style.display= 'none';
	}