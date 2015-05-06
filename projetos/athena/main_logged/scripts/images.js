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
}
function checkTypeImage() 
{
  var imgType = document.getElementById('func_add_form').funcionarioFoto.value;
  imgType = imgType.substring(imgType.length-3,imgType.length);
  imgType = imgType.toLowerCase();
  if(imgType != 'jpg')
  {
     top.showAlert('alerta', 'A foto selecionada é um arquivo do tipo '+imgType+' - Favor selecionar um arquivo com a extensão JPG,GIF ou PNG !');
     return false; 
  }else{
		 return true; 
	   }
} 

function loadFoto()
{
	document.getElementById('foto_func').src = document.getElementById('funcionarioFoto').value;
}