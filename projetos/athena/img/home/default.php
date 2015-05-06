<script>
	if(document.all)
		browser= 'ie';
	else
		browser= 'DOM';
	function setOpacity(obj, opacityLevel)
	{
		if (browser == "ie")
		{
			document.getElementById(obj).style.filter="alpha(opacity="+opacityLevel+")";
		}else{
				var opacidade = parseFloat(opacityLevel/100);
				if (opacityLevel == 1)
				{
					opacidade = 1.0;
				}
				document.getElementById(obj).style.MozOpacity= opacidade;
			 }
	}
	function PNGTransparent()
	{
		var arVersion = navigator.appVersion.split("MSIE");
		var version = parseFloat(arVersion[1]);
		if ((version >= 5.5)) {
			if (!document.getElementsByTagName) return;
			var imgs = document.getElementsByTagName('img');
			for(var i=0; i < imgs.length; i++)
			{
			   var img = imgs[i];
			   var imgName = img.src.toUpperCase();
			   if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
			   {
					 var imgID = (img.id) ? "id='" + img.id + "' " : "";
					 var imgClass = (img.className) ? "class='" + img.className + "' " : "";
					 var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' ";
					 var imgStyle = "display:inline-block;" + img.style.cssText;
					 if (img.align == "left") imgStyle = "float:left;" + imgStyle;
					 if (img.align == "right") imgStyle = "float:right;" + imgStyle;
					 if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle;
					 var strNewHTML = "<span " + imgID + imgClass + imgTitle
					 + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
					 + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
					 + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>" 
					 img.outerHTML = strNewHTML;
					 i = i-1;
			  }
		   }
		}
		
		setOpacity('backBlue', 75);
		try
		{	//	lixo (IE)
			window.attachEvent('onresize', adjustDiv);
		}catch(error)
		{	// DOM
			window.addEventListener('resize', adjustDiv, true);
		}
		adjustDiv();
	}
	
	function adjustDiv(event)
	{
		try
		{
			document.getElementById('backBlue').style.height= document.body.clientHeight - 170;
		}catch(e){}
	}
</script>
<body style=""
	  leftmargin="0"
	  topmargin="0"
	  bottommargin="0"
	  rightmargin="0"
	  onload="PNGTransparent()">
	<?php
		include("menus.php");
	?>
	<div style="width: 78%;
				position: absolute;
				left: 20%;
				top: 110px;
				height: 100%;
				background-color: #bbbbff;"
		 id="backBlue">
		<br>
	</div>
	<div style="width: 100%;
				position: absolute;
				left: 0px;
				bottom: 10px;"
		 id="rodape">
		rodape
	</div>
	<div style="width: 78%;
				position: absolute;
				left: 20%;
				top: 110px;">