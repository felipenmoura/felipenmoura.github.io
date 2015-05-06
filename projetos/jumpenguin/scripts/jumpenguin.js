var JP= {
	scenary: null,
	details: null,
	elements:null,
	paused:false,
	el: {},
	init: function(){
		document.getElementById('cover').style.display= 'none';
		JP.scenary = document.getElementById('scenary').getContext('2d');
		JP.details = document.getElementById('details').getContext('2d');
		JP.elements= document.getElementById('elements').getContext('2d');
		JP.loadMap(1);
		JP.loadElements();
		JP.loadScenary();
		//JP.startGame();
		document.onkeydown= function(event){
			if(event.keyCode == 27)
			{
				JP.paused= !JP.paused;
				return false;
			}
			if(event.keyCode == 32 && !JP.el.character.jumping) // jumping [space]
			{
				JP.jump();
				return false;
			}
			if(!JP.paused)
			{
				if(event.keyCode == 37 && JP.el.character.position[1] > 0) // left
					JP.el.character.position[1]--;
				else if(event.keyCode == 39 && JP.el.character.position[1] < 9) // right
					JP.el.character.position[1]++;
			}
		};
	},
	loadMap: function(mapNumber){
		var scr= document.createElement('script');
		scr.setAttribute('src', 'scripts/map'+mapNumber+'.js');
		document.getElementsByTagName('head')[0].appendChild(scr);
	},
	loadElements: function(){
		JP.el.character= {
			jumping: 0,
			walking: 1,
			sprites: {
				walking: new Image(),
				jumping: new Image()
			},
			position: [0,
					   5] // of 9 possible
		};
		JP.el.fruits= {
			C: new Image(),
			B: new Image()
		}
		JP.el.rocks= new Image();
		JP.el.character.sprites.walking.src= 'images/penguin.png';
		JP.el.character.sprites.jumping.src= 'images/penguin-jumping.png';
		JP.el.fruits.C.src= 'images/cereja.png';
		JP.el.fruits.B.src= 'images/banana.png';
		JP.el.rocks.src= 'images/rocks.png';
	},
	loadScenary: function(){
		JP.el.background= new Image();
		JP.el.background.onload= function(){
			JP.scenary.drawImage(JP.el.background, 0, 0,
								 800,
							     400);
		};
		JP.el.background.src= 'images/background.png';
		var gradient1 = JP.scenary.createLinearGradient(0, 400, 0, 800);
		gradient1.addColorStop(0,     '#888');
		gradient1.addColorStop(0.2,   '#ddd');
		gradient1.addColorStop(0.4,   '#eee');
		//gradient1.addColorStop(0.6,   '#');
		gradient1.addColorStop(0.8,   '#000');
		JP.gradient1= gradient1;

		var gradient2 = JP.scenary.createLinearGradient(0, 400, 0, 800);
		gradient2.addColorStop(0,     '#ccc');
		gradient2.addColorStop(0.4,   '#fff');
		JP.gradient2= gradient2;

		JP.scenary.fillStyle = gradient1;
		JP.scenary.fillRect(0, 400, 800, 200);

		JP.scenary.fillStyle   = gradient2;
		JP.scenary.strokeStyle = '#888';
		JP.scenary.lineWidth   = 2;

		JP.scenary.beginPath();
		JP.scenary.moveTo(-200, 800);
		JP.scenary.lineTo(240, 400);
		JP.scenary.lineTo(600, 400);
		JP.scenary.lineTo(1000, 800);
		JP.scenary.fill();
		JP.scenary.stroke();
		JP.scenary.closePath();
	},
	run: function(){
		if(JP.paused)
		{
			document.getElementById('sign').
					 getElementsByTagName('SPAN')[2].
					 style.display= '';
			return true;
		}else{
			document.getElementById('sign').
					 getElementsByTagName('SPAN')[2].
					 style.display= 'none';
		}
		JP.elements.clearRect(0, 0, 800, 600);
		var p= JP.el.character.position;
		var x=0;

		for(var i=0; i<6; i++)
		{
			if(!Map.holes[x][p[0]+i])
			{
				JP.drawFinalLine(i);
				break;
			}else{
					for(x in Map.holes)
					{

						if(Map.holes[x][p[0]+i] && Map.holes[x][p[0]+i] != ' ')
							JP.drawHole(x, i, 1);
					}
					for(x in Map.stones)
					{
						if(Map.stones[x][p[0]+i] && Map.stones[x][p[0]+i] != ' ')
							JP.drawStone(x, i);
					}
					for(x in Map.fruits)
					{
						if(Map.fruits[x][p[0]+i] && Map.fruits[x][p[0]+i] != ' ')
							JP.drawFruits(x, i, Map.fruits[x][p[0]+i]);
					}
				 }
		}
		
		var posL= 60*(JP.el.character.position[1])+60;

		// drawing the shadow of the penguin
		JP.elements.fillEllipse(posL+10, 560, 65, 10);

		if(JP.el.character.jumping){
			switch(JP.el.character.jumping)
			{
				case 1:
					JP.elements.drawImage(JP.el.character.sprites.jumping,
									  0, 0, 170, 120, posL-10, 440, 120, 90);
					JP.el.character.jumping++;
					break;
				case 2:
					JP.elements.drawImage(JP.el.character.sprites.jumping,
									  0, 0, 170, 120, posL-10, 410, 120, 90);
					JP.el.character.jumping++;
					break;
				case 3:
					JP.elements.drawImage(JP.el.character.sprites.jumping,
									  0, 0, 170, 120, posL-10, 440, 120, 90);
					JP.el.character.jumping= 0;
					break;
			}
		}else{
			JP.el.character.walking= !JP.el.character.walking;
			if(JP.el.character.walking)
				JP.elements.drawImage(JP.el.character.sprites.walking,
									  0, 0, 100, 175, posL, 440, 90, 125);
			else
				JP.elements.drawImage(JP.el.character.sprites.walking,
									  103, 0, 100, 175, posL, 440, 90, 125);
		}

		JP.el.character.position[0]++;
		if(p[0]+1 > Map.holes[0].length)
			JP.win();
	},
	drawFinalLine: function(l)
	{
		var col, w, dist;
		switch(l)
		{
			case 0:
				dist= 510;
				col= 64;
				w= 695;
				break;
			case 1:
				dist= 490;
				col= 80;
				w= 580;
				break;
			case 2:
				dist= 470;
				col= 107;
				w= 610;
				break;
			case 3:
				dist= 450;
				col= 130;
				w= 570;
				break;
			case 4:
				dist= 420;
				col= 162;
				w= 508;
				break;
			case 5:
				dist= 390;
				col= 196;
				w= 444;
				break;
		}
		dist+= 50;
		if(true)
		{
			console.log('desenhando a linha');
			JP.elements.beginPath();
			JP.elements.strokeStyle= '#f00';
			JP.elements.moveTo(col, dist);
			JP.elements.lineTo(col+w, dist);
			JP.elements.closePath();
			JP.elements.stroke();
		}
	},
	drawStone: function (col, dist){
		JP.drawHole(col, dist, 2);
	},
	drawFruits: function (col, dist, f){
		f= f=='B'? 3: 4;
		JP.drawHole(col, dist, f);
	},
	drawHole: function(col, dist, obj){
		var oCol= col;
		switch(dist)
		{
			case 0:
				col= col==0? 70: col==1? 280: 483;
				var line= 510;
				var w= 200;
				var h= 50;
				break;
			case 1:
				col= col==0? 100: col==1? 290: 478;
				var line= 490;
				var w= 180;
				var h= 45;
				break;
			case 2:
				col= col==0? 130: col==1? 300: 470;
				var line= 470;
				var w= 160;
				var h= 35;
				break;
			case 3:
				col= col==0? 160: col==1? 310: 464;
				var line= 450;
				var w= 140;
				var h= 30;
				break;
			case 4:
				col= col==0? 195: col==1? 325: 456;
				var line= 420;
				var w= 110;
				var h= 25;
				break;
			case 5:
				col= col==0? 215: col==1? 336: 456;
				var line= 390;
				var w= 90;
				var h= 20;
				break;
		}
		col-= 10;

		JP.elements.beginPath();

		switch(obj)
		{
			case 1:
				var gradient3 = JP.scenary.createLinearGradient(0, line, 0, line+h);
				gradient3.addColorStop(0,     '#ccc');
				gradient3.addColorStop(0.4,   '#999');
				gradient3.addColorStop(0.7,   '#666');
				gradient3.addColorStop(0.9,   '#222');
				JP.elements.strokeStyle= '#000';

				JP.elements.fillStyle = gradient3;
				JP.elements.strokeFillEllipse(col+50, line, w, h);
				// look for arc() as alternative
				break;
			case 2:
				JP.elements.drawImage(JP.el.rocks, col+90, line,
									  JP.el.rocks.width,
									  JP.el.rocks.height);
				break;
				/* var gradient3 = JP.scenary.createLinearGradient(0, line, 0, line+h);
				gradient3.addColorStop(0,     '#fa6');
				gradient3.addColorStop(0.4,   '#fd9');
				gradient3.addColorStop(0.7,   '#da6');
				gradient3.addColorStop(0.9,   '#963');
				JP.elements.strokeStyle= '#000';

				JP.elements.fillStyle = gradient3;
				JP.elements.fillRect(col+70, line, w-50, h+20);*/
				break;
			case 3:
				JP.elements.drawImage(JP.el.fruits.B, col+90, line,
									  JP.el.fruits.B.width,
									  JP.el.fruits.B.height);
				break;
			case 4:
				JP.elements.drawImage(JP.el.fruits.C, col+90, line,
									  JP.el.fruits.C.width,
									  JP.el.fruits.C.height);
				break;
		}
		
		JP.elements.clearRect(0, 0, 800, 400);

		if(dist == 0 && !JP.el.character.jumping)
		{
			//console.log(JP.el.character.position[1]+' - '+oCol);
			var p= JP.el.character.position[1];
			if(p>3 && p<7)
				p= 1;
			else if(p<4)
					p=0;
				 else p= 2;
			if(p == oCol)
			{
				if(obj < 3)
					JP.loose();
				else
					if(obj == 3)
					{
						JP.addPts(3);
					}else
						JP.addPts(1);
			}
		}
	},
	addPts: function(qnt)
	{
		var el= document.getElementById('pts').
				 getElementsByTagName('DIV')[qnt==1? 1: 0].
				 getElementsByTagName('SPAN')[0];
		el.innerHTML= parseInt(el.innerHTML) + 1;
	},
	clearPts: function(){
		var el= document.getElementById('pts').
				 getElementsByTagName('DIV');
		el[0].getElementsByTagName('SPAN')[0].innerHTML= 0;
		el[1].getElementsByTagName('SPAN')[0].innerHTML= 0;
	},
	jump: function(){
		JP.el.character.jumping= 1;
	},
	win: function(){
		document.getElementById('sign').
				 getElementsByTagName('SPAN')[0].
				 style.display= '';
		document.getElementById('sign').
				 getElementsByTagName('SPAN')[1].
				 style.display= 'none';
		JP.endGame();
	},
	loose: function(){
		document.getElementById('sign').
				 getElementsByTagName('SPAN')[1].
				 style.display= '';
		document.getElementById('sign').
				 getElementsByTagName('SPAN')[0].
				 style.display= 'none';
		JP.endGame();
	},
	startGame: function(){
		JP.init();
		document.getElementById('startGameBtn').style.display= 'none';

		document.getElementById('sign').
				 getElementsByTagName('SPAN')[0].
				 style.display= 'none';
		document.getElementById('sign').
				 getElementsByTagName('SPAN')[1].
				 style.display= 'none';
		JP.clearPts();
		JP.frames= setInterval(JP.run, 150);
	},
	endGame: function(){
		JP.elements.clearRect(0, 0, 800, 600);
		JP.drawFinalLine(0);
		//console.log('acabou');
		clearInterval(JP.frames);
		document.getElementById('startGameBtn').style.display= '';
	}
};