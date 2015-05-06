 // here, this method should receive the key to be used as "cut here", and how many peaces it should be cut in
String.prototype.explode= function(what, howMany)
{
	var ar= Array();
	var ret= this.split(what);
	if(howMany)
	{
		for(var i=0, j=howMany-1; i<j; i++)
		{
			ar.push(ret.shift());
		}
		ar.push(ret.join(what));
		ret= ar;
	}
	return ret;
}

function setMozCupLogoAt(where, what){
	if(!what && !where.what)
		return false;
	if(typeof where == 'object')
	{
		var o= where;
		where= false;
	}else{
			var o ={};
		 }
	var coord= [o.left||196, o.top||190]; // the left and top position
	var c= document.createElement('canvas');
	where= where||o.where;
	what= what||o.what;
	if(typeof where== 'string')
		where = document.getElementById(where);
	c.width= o.width||'399';
	c.height= o.height||'489';
	
	var ctx = c.getContext("2d");
	var fontSize= (o.fontSize||56);
	ctx.textAlign= 'center';
	ctx.fillStyle = "white";
	ctx.shadowOffsetX = 0;
	ctx.shadowOffsetY = 0;
	ctx.shadowBlur    = 8;
	ctx.shadowColor   = 'rgba(100, 100, 255, 0.5)';
	
	what= what.toUpperCase();
	
	if(what.length > 6)
	{
		if(what.length < 9)
			fontSize= o.fontSize? o.fontSize/1.5: 40;
		else if(what.length < 12)
				fontSize= o.fontSize? o.fontSize/2.5: 30;
			else
			{
				fontSize= o.fontSize? o.fontSize/2.5: 30;
				if(what.indexOf(' ') >=0)
				{
					what= what.explode(' ', 2); // we want only 2 lines dived by " "
					ctx.font= "bold "+fontSize+"px sans-serif";
					ctx.fillText(what[0].substring(0,16), coord[0], coord[1]-(fontSize-6));
					coord[1]= coord[1] + 6;
					what= what[1].substring(0,16);
					//ctx.fillText(what[1], coord[0], coord[1] + 10);
				}else{
						what= what.substring(0, 12);// here, unfortunately, there is no much to do with it!
					 }
			}
	}
	ctx.font= "bold "+fontSize+"px sans-serif";
	ctx.fillText(what, coord[0], coord[1]);
	
	
	/*if(what.length < 6)
	{
		ctx.fillText(what, coord[0], coord[1]);
	}else{
			if(what.length < 13)
			{
				fontSize
			}
			if(what.indexOf(' ') >=0)
			{
				what= what.explode(' ', 2); // we want only 2 lines dived by " "
			}else{
					if(o.fontSize)
						ctx.font= "bold "+(o.fontSize/2)+"px sans-serif";
					else
						ctx.font= "bold 30px sans-serif";
					ctx.fillText(what.substring(0,9), coord[0], coord[1]);
				 }
		 }
	*/
	c.style.backgroundImage= "url("+(o.imagesDir||'')+"logo.png)";
	c.innerHTML= "<img src='"+(o.imagesDir||'')+"logo-ie.png' />";
	where.innerHTML= '';
	where.appendChild(c);
}
