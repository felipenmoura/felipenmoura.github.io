Slides= {
	current: null,
	slideNumber: 0,
	next: function(func){
		if(this.slides[this.slideNumber].action)
		{
			if(this.slides[this.slideNumber].action.length > 0)
			{
				this.slides[this.slideNumber].action[0]();
				this.slides[this.slideNumber].action.shift();
				return false;
			}
		}
		
		if(!this.slides[this.slideNumber+1])
			return false; // should go to the last slide
		
		
		var tt= document.getElementById('Title');
		Slides.slideNumber++;
		if(Slides.slideNumber == 1)
		{
			$(tt).animate({
				top: '6px',
				left: '10px',
				fontSize: '32px',
			}, function(){
				$(tt).fadeOut('fast', function(){
					tt.innerHTML= Slides.slides[Slides.slideNumber].title;
					$(tt).fadeIn('fast', function(){});
				});
				
			});
			if(func)
				func();
		}
		var tL= $('#titleLine');
		tL.css('width', '4px');
		tL.show();
		tL.animate({
			width: 475
		});
		$.ajax({
			url: 'slides/'+Slides.slides[Slides.slideNumber].id+'.php',
			data: {},
			success: function(ret){
				document.getElementById('Title').innerHTML= Slides.slides[Slides.slideNumber].title;
				$(document.getElementById('slideBody')).hide().html(ret).css({position:'absolute',left:0, top:0, width:'100%', height:'100%'}).fadeIn('slow');
			}
		});
		top.document.getElementById('goToSlide').value= Slides.slideNumber;
		top.location.href= top.location.href.replace(/\#.*/, '')+ '#'+Slides.slideNumber;
	},
	prev: function(){
		if(Slides.slideNumber == 0)
			return false;
		Slides.slideNumber--;
		$.ajax({
			url: 'slides/'+Slides.slides[Slides.slideNumber].id+'.php',
			data: {},
			success: function(ret){
				document.getElementById('Title').innerHTML= Slides.slides[Slides.slideNumber].title;
				$(document.getElementById('slideBody')).hide().html(ret).css({position:'absolute',left:0, top:0, width:'100%', height:'100%'}).fadeIn('slow');
			}
		});
	},
	reset: function(){
	},
	setBackgroundImage: function(imageSrc){
		backgroundImage.src= imageSrc;
	},
	goTo: function(s){
		this.slideNumber= s-1;
		this.slides[this.slideNumber].action= false;
		this.next();
	},
	slides: [
		{title: 'At&ecute; onde vai ', id:'ate'},
		{title: 'About me: ', id:'about'},
		{title: 'Alguns mitos', id:'myths'},
		{title: '"Js &eacute; s&oacute; pra validar formularios"', id:'jsvalidar'},
		{title: 'HTML5 == DHTML', id:'myths-2'},
		{title: "Web2.0 &eacute; cheia de drag'n'drop", id:'myths-3'},
		{title: "Antigas Novidades", id:'antigasnovidades'},
		{title: "Antigas Novidades", id:'cloud'},
//		{title: "Antigas Novidades", id:'json'},
		{title: 'Web sem&acirc;ntica', id:'semantica'},
		{title: "RIA!", id:'ria'},
		{title: "Batalha Naval", id:'browsers1'},
		{title: "Batalha Naval", id:'browsers2'},
		{title: "Mergulhando...", id:'mergulhando'},
		{title: "Canvas", id:'canvas'},
		{title: "SVG e WebGL", id:'wgl_svg'},
		{title: "CSS3 - Efeitos", id:'css1'},
		{title: "CSS3 - Seletores", id:'css2'},
		{title: "CSS3 - Quais s&atilde;o as suas fontes", id:'css3'},
		{title: "CSS3 - Transitions", id:'css4'},
		{title: "CSS3 - Cores e background", id:'css5'},
		{title: "CSS3 - Anima&ccedil;&otilde;es", id:'css6'},
		{title: "Sprites e base64", id:'sprites_uri'},
		{title: "3D*", id:'3d'},
//		{title: 'O Cliente tem sempre raz&atilde;o: ', id:'js1'},
		{title: "Don't be afraid: ", id:'js2'},
		{title: "Don't be afr... ", id:'js3'},
		{title: "JS - Seletores", id:'jsselectors'},
		{title: "At&eacute; validar formul&aacute;rios, JS valida!", id:'jsvalida'},
		{title: "JS - Client DataBase", id:'datastore'},
//		{title: "Estat&iacute;sticas", id:'browsers3'},
//		{title: "A verdade est&aacute; l&aacute; fora", id:'browsers4'},
//		{title: "O mundo na palma da m&atilde;o", id:'browsers5'},
		{title: "Transmita confian&ccedil;a", id:'mercado1'},
//		{title: "A guerra em que todos ganham", id:'mercado2'},
//		{title: "Perca preconceitos", id:'mercado3'},
		{title: "2012 est&aacute; pr&oacute;ximo", id:'mercado4'}
	]
};
function capture(event){
			if(event.target.tagName.toUpperCase() == 'INPUT' || event.target.tagName.toUpperCase() == 'TEXTAREA')
				return true;
			// <- 37
			// -> 39
			// backspace 8
			// [enter] 13
			// [space] 32
			// [esc] 27
			// 1, 2, 3, 0 => clicks
			switch(event.which)
			{
				case 37:
				case 8:
				case 2:
				case 3:
				{
					Slides.prev();
					break;
				}
				case 39:
				case 13:
				case 32:
				case 0:
				case 1:
				{
					Slides.next();
					break;
				}
				case 27:
				{
					Slides.reset();
					break;
				}
			}

}
parent.slides= self;

$(window).bind('keydown mousedown', capture);
