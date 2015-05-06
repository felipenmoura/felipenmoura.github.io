var HELPER = new HELPER_CLASS();

function HELPER_CLASS(){
	this.replaceAt = function(index, char){
		return this.substr(0, index) + char + this.substr(index+char.length);
		};
	//get url param
	this.get_url_param = function(name){
		name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");  
		var regexS = "[\\?&]"+name+"=([^&#]*)";  
		var regex = new RegExp( regexS );  
		var results = regex.exec( window.location.href ); 
		if( results == null )    
			return "";  
		else    
			return results[1];
		};
	this.getCookie = function(NameOfCookie){
		if (document.cookie.length > 0){
			begin = document.cookie.indexOf(NameOfCookie+"=");
			if (begin != -1){
				begin += NameOfCookie.length+1;
				end = document.cookie.indexOf(";", begin);
				if (end == -1) end = document.cookie.length;
				return unescape(document.cookie.substring(begin, end));
				}
			}
		return '';
		};
	this.setCookie = function(NameOfCookie, value, expiredays){ 
		var ExpireDate = new Date ();
		ExpireDate.setTime(ExpireDate.getTime() + (expiredays * 24 * 3600 * 1000));
		document.cookie = NameOfCookie + "=" + escape(value) +
		((expiredays == null) ? "" : "; expires=" + ExpireDate.toGMTString());
		};
	this.delCookie = function(NameOfCookie){
		if(HELPER.getCookie(NameOfCookie))
			document.cookie = NameOfCookie + "="+"; expires=Thu, 01-Jan-70 00:00:01 GMT";
		};
	//ctx.strokeStyle = "#2d6";
	//ctx.fillStyle = "#abc";
	//roundRect(ctx, 100, 200, 200, 100, 50, true);
	this.roundRect = function(ctx, x, y, width, height, radius, fill, stroke) {
		if (typeof stroke == "undefined" )
			stroke = true;
		if (typeof radius === "undefined")
			radius = 5;
		ctx.beginPath();
		ctx.moveTo(x + radius, y);
		ctx.lineTo(x + width - radius, y);
		ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
		ctx.lineTo(x + width, y + height - radius);
		ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
		ctx.lineTo(x + radius, y + height);
		ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
		ctx.lineTo(x, y + radius);
		ctx.quadraticCurveTo(x, y, x + radius, y);
		ctx.closePath();
		ctx.lineWidth = 1;
		if (stroke)		ctx.stroke();	//borders
		if (fill)		ctx.fill();	//background
		};
	//this.to get random number from 1 to n
	this.getRandomInt = function(min, max){
		return Math.floor(Math.random() * (max - min + 1)) + min;
		};
	this.font_pixel_to_height = function(px){
		return Math.round(px*0.75);
		};
	this.ucfirst = function(string){
		return string.charAt(0).toUpperCase() + string.slice(1);
		};
	this.get_dimensions = function(){
		var theWidth, theHeight;
		if (window.innerWidth)
			theWidth=window.innerWidth;
		else if (document.documentElement && document.documentElement.clientWidth)
			theWidth=document.documentElement.clientWidth;
		else if (document.body)
			theWidth=document.body.clientWidth;
		if (window.innerHeight)
			theHeight=window.innerHeight;
		else if (document.documentElement && document.documentElement.clientHeight)
			theHeight=document.documentElement.clientHeight;
		else if (document.body)
			theHeight=document.body.clientHeight;
		return [theWidth, theHeight];
		};
	this.drawImage_rotated = function(canvas, file, x, y, width, height, angle){
		var TO_RADIANS = Math.PI/180;
		var img = new Image();	
		img.src = file;
		canvas.save();
		canvas.translate(x, y);
		canvas.rotate(angle * TO_RADIANS);
		canvas.drawImage(img, -(width/2), -(height/2));
		canvas.restore();
		};
	this.convertToSlug = function(Text){
		return Text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
		};
	this.isIE = function() {
		return !!navigator.userAgent.match(/MSIE 10/);
		};
	this.generatePassword = function(limit){
		array1 = "zsdcrfvtgbhnjmkp";
		array2 = "aeoui";
		n1 = array1.length;
		n2 = array2.length;
		string = "";
		for(var i=0; i<limit; i=i+2){
			string = string + array1[HELPER.getRandomInt(0, n1-1)];
			string = string + array2[HELPER.getRandomInt(0, n2-1)];
			}
		return string;
		};
	//IntegraXor Web SCADA - JavaScript Number Formatter, author: KPL, KHL
	this.format = function(b,a){
		if(!b||isNaN(+a))return a;
		var a=b.charAt(0)=="-"?-a:+a,j=a<0?a=-a:0,e=b.match(/[^\d\-\+#]/g),h=e&&e[e.length-1]||".",e=e&&e[1]&&e[0]||",",b=b.split(h),a=a.toFixed(b[1]&&b[1].length),a=+a+"",d=b[1]&&b[1].lastIndexOf("0"),c=a.split(".");
		if(!c[1]||c[1]&&c[1].length<=d)
			a=(+a).toFixed(d+1);
		d=b[0].split(e);
		b[0]=d.join("");
		var f=b[0]&&b[0].indexOf("0");
		if(f>-1)	for(;c[0].length<b[0].length-f;)c[0]="0"+c[0];
		else		+c[0]==0&&(c[0]="");
		a=a.split(".");a[0]=c[0];
		if(c=d[1]&&d[d.length-1].length)
			{for(var d=a[0],f="",k=d.length%c,g=0,i=d.length;g<i;g++)f+=d.charAt(g),!((g-k+1)%c)&&g<i-c&&(f+=e);a[0]=f;}
		a[1]=b[1]&&a[1]?h+a[1]:"";
		return(j?"-":"")+a[0]+a[1];
		};
	this.strpos = function(haystack, needle, offset) {
		var i = (haystack+'').indexOf(needle, (offset || 0));
		return i === -1 ? false : i;
		};
	//dashed objects
	this.dashedRect = function(canvas, x1, y1, x2, y2, dashLen, color) {
		HELPER.dashedLine(canvas, x1, y1, x2, y1, dashLen, color);
		HELPER.dashedLine(canvas, x2, y1, x2, y2, dashLen, color);
		HELPER.dashedLine(canvas, x2, y2, x1, y2, dashLen, color);
		HELPER.dashedLine(canvas, x1, y2, x1, y1, dashLen, color);
		};
	this.dashedLine = function(canvas, x1, y1, x2, y2, dashLen, color) {
		x1 = x1 + 0.5;
		y1 = y1 + 0.5;
		x2 = x2 + 0.5;
		y2 = y2 + 0.5;
		canvas.strokeStyle = color;
		if (dashLen == undefined) dashLen = 4;
		canvas.beginPath();
		canvas.moveTo(x1, y1);
		var dX = x2 - x1;
		var dY = y2 - y1;
		var dashes = Math.floor(Math.sqrt(dX * dX + dY * dY) / dashLen);
		var dashX = dX / dashes;
		var dashY = dY / dashes;
		var q = 0;
		while (q++ < dashes){
			x1 += dashX;
			y1 += dashY;
			canvas[q % 2 == 0 ? 'moveTo' : 'lineTo'](x1, y1);
			}
		canvas[q % 2 == 0 ? 'moveTo' : 'lineTo'](x2, y2);
		canvas.stroke();
		canvas.closePath();	
		};	
	this.size = function(obj){
		var size = 0, key;
		for (key in obj){
			if (obj.hasOwnProperty(key)) size++;
			}
		return size;
		};
	this.drawSoftLine = function(ctx, x1, y1, x2, y2, lineWidth, r, g, b, a){
		var lx = x2 - x1;
		var ly = y2 - y1;
		var lineLength = Math.sqrt(lx*lx + ly*ly);
		var wy = lx / lineLength * lineWidth;
		var wx = ly / lineLength * lineWidth;
		var gradient = ctx.createLinearGradient(x1-wx/2, y1+wy/2, x1+wx/2, y1-wy/2);
		// The gradient must be defined accross the line, 90° turned compared
		// to the line direction.
		gradient.addColorStop(0,    "rgba("+r+","+g+","+b+",0)");
		gradient.addColorStop(0.43, "rgba("+r+","+g+","+b+","+a+")");
		gradient.addColorStop(0.57, "rgba("+r+","+g+","+b+","+a+")");
		gradient.addColorStop(1,    "rgba("+r+","+g+","+b+",0)");
		ctx.save();
		ctx.beginPath();
		ctx.lineWidth = lineWidth;
		ctx.strokeStyle = gradient;
		ctx.moveTo(x1, y1);
		ctx.lineTo(x2, y2);
		ctx.stroke();
		ctx.restore(); 
		};
	}	
	
function log(object){
	console.log(object);
	//console.log([object, " - "+arguments.callee.caller.name+"()"]);
	}		
function round(number){
	return Math.round(number);
	}
