function loadXmlDocument(arqXml) {

	//Internet Explorer
	try {
			xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
		} catch(e) {
					   //Firefox, Mozilla, Opera, etc.
					   try {
								xmlDoc=document.implementation.createDocument("","",null);
						   }catch(e) {
										alert(e.message)
						   }
				   }
	try {
     		xmlDoc.async=false;
			xmlDoc.load(arqXml);
			return(xmlDoc);
		}catch(e) {
					alert(e.message)
		}
	return(null);
}

function workXml(fileXml)
{
	// Carrega o arquivo XML
	xmlDoc =loadXmlDocument(fileXml);
	//  Pega todos os Objetos do XML
	//windows = xmlDoc.getElementsByTagName("window");
}