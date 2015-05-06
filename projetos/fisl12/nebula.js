//////////////////////////////////////////////////////////////////////////////////
// A demonstration of a Canvas nebula effect
// (c) 2010 by R Cecco. <http://www.professorcloud.com>
// MIT License
//
// Please retain this copyright header in all versions of the software if
// using significant parts of it
//////////////////////////////////////////////////////////////////////////////////

var canvasW= 0;
var canvasH= 0;
var velox= 0.1;
var backgroundImage= null;
var loopStarted= false;

$(document).ready(function(){	
									
	canvasW= document.body.clientWidth;
	canvasH= document.body.clientHeight;
	
			// The canvas element we are drawing into.      
			var	$canvas = $('#canvas');
			var	$canvas2 = $('#canvas2');
			var	$canvas3 = $('#canvas3');
			
			$canvas3[0].width= canvasW;
			$canvas3[0].height= canvasH;
			
			$canvas2[0].width= canvasW;
			$canvas2[0].height= canvasH;
			
			$canvas[0].width= canvasW;
			$canvas[0].height= canvasH;
			
			var	ctx2 = $canvas2[0].getContext('2d');
			var	ctx = $canvas[0].getContext('2d');
			var	w = $canvas[0].width, h = $canvas[0].height;
			var	img = new Image();	
			
			// A puff.
			var	Puff = function(p) {				
				var	opacity,
					sy = (Math.random()*(canvasH/2))>>0,
					sx = (Math.random()*(canvasW/2))>>0;
				
				this.p = p;
						
				this.move = function(timeFac) {						
					p = this.p + velox * timeFac;
					//opacity = (Math.sin(p*0.05)*0.5);
					opacity= 1;
					if(opacity <0) {
						p = opacity = 0;
						sy = (Math.random()*(canvasH/2))>>0;
						sx = (Math.random()*(canvasW/2))>>0;
					}
					this.p = p;
					ctx.globalAlpha = opacity;
					try
					{
						ctx.drawImage($canvas3[0], sx+p, sy+p, (canvasW/2)-(p*2),(canvasH/2)-(p*2), 0,0, canvasW, canvasH);
					}catch(e){
						p = opacity = 0;
						sy = (Math.random()*(canvasH/2))>>0;
						sx = (Math.random()*(canvasW/2))>>0;
						this.p = p;
					}
				};
			};
			
			var	puffs = [];			
			var	sortPuff = function(p1,p2)
			{
				return p1.p-p2.p;
			};
			puffs.push( new Puff(0) );
			puffs.push( new Puff(20) );
			puffs.push( new Puff(40) );
			
			var	newTime, oldTime = 0, timeFac;
					
			var	loop = function()
			{								
				newTime = new Date().getTime();				
				if(oldTime === 0 ) {
					oldTime=newTime;
				}
				timeFac = (newTime-oldTime) * 0.1;
				if(timeFac>3) {timeFac=3;}
				oldTime = newTime;						
				puffs.sort(sortPuff);							
				
				for(var i=0;i<puffs.length;i++)
				{
					puffs[i].move(timeFac);	
				}					
				ctx2.drawImage( $canvas[0] ,0,0,canvasW,canvasH);
				//setTimeout(loop, 10 );				
			};
			// Turns out Chrome is much faster doing bitmap work if the bitmap is in an existing canvas rather
			// than an IMG, VIDEO etc. So draw the big nebula image into canvas3
			var	$canvas3 = $('#canvas3');
			var	ctx3 = $canvas3[0].getContext('2d');
			$(img).bind('load',null, function() { 
				ctx3.drawImage(img, 0,0, canvasW, canvasW);
				
				
				if(loopStarted)
					return false;
				loopStarted= true;
				loop();
				
				
				var curTitle= null;
				var stage= document.getElementById('slideContent');
				var tt= document.getElementById('Title');
				stage.style.position= 'absolute';
				stage.style.left= 0;
				stage.style.top= 0;
				stage.style.zIndex= 99;
				stage.style.display= '';
	
				tt.style.position= 'absolute';
				tt.style.top= '140px';
				$(tt).addClass('firstTitle');
				tt.style.left= document.body.clientWidth/2 - tt.offsetWidth/2;
	
				var footer= document.getElementById('footer');
				footer.style.position= 'absolute';
				footer.style.left= 0;
			//	footer.style.top= document.body.clientHeight - footer.offsetHeight;
				footer.style.top= '545px';
				
				tt.style.left= ((document.body.clientWidth / 2) - (tt.offsetWidth/2))+'px';
	/*
				TitleDrifter= {
						fixed: false,
						reset: function(){
							var pos= $(curTitle).data('originalPos');
							$(curTitle).data('originalPos', null);
							curTitle.style.left= pos[0];
							curTitle.style.top= pos[1];
						},
						init: function(tt){
							curTitle= tt;
							this.steps= this.steps|| (Math.ceil(Math.random()*6))
							var l= curTitle.offsetLeft;
							var t= curTitle.offsetTop;
							if($(curTitle).data('originalPos') == null)
							{
								if(!TitleDrifter.fixed)
								{
									//alert(document.body.clientWidth+'\n'+ curTitle.offsetWidth+'\n'+((document.body.clientWidth / 2) - (curTitle.offsetWidth/2)))
									curTitle.style.left= ((document.body.clientWidth / 2) - (curTitle.offsetWidth/2))+'px';
									l= curTitle.offsetLeft;
									t= curTitle.offsetTop;
									TitleDrifter.fixed= true;
								}
								$(curTitle).data('originalPos', [l, t]);
							}
							this.steps--;
							curTitle.style.top=  t+(Math.ceil(Math.random()*4)*(Math.ceil(Math.random()*10)%2==0? -1: 1));
							curTitle.style.left= l+(Math.ceil(Math.random()*4)*(Math.ceil(Math.random()*10)%3==0? 1: -1));
				
							time= this.steps>0? 40: 2000;
							if(time== 2000)
								TitleDrifter.reset();
					
							setTimeout(function(){
								TitleDrifter.init(tt);
							}, time);
					}
				};
				driftTitle= function(tt){
					TitleDrifter.init(tt);
				};
			//	driftTitle(document.getElementById('Title'));
				setTimeout(function(){driftTitle(document.getElementById('Title'));}, 1000);
				*/
				
			});
//			img.src = 'images/nebula.jpg';
//			img.src = 'images/nuvem2.jpg';
//			img.src = 'images/nuvem5.png';
					img.src = 'images/nuvem5.jpg';
//			img.src = 'images/circuit.gif';
//			img.src = 'images/web1.jpg';
//			setTimeout(function(){img.src= 'images/nuvem3.png';}, 4000);
//			img.src = 'images/nuvem.png';
			backgroundImage= img;
});

