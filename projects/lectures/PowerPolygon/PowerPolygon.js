/*
 * Author: Felipe Nascimento de Moura <felipenmoura@gmail.com>
 * onload
 * onstartloading
 * onnext
 * onprev
 * onbeforeslidechange
 * onslidechange
 */

if(!$ && !jQuery)
	throw "JQuery is the only requisition this framework has...please, include it before including the PowerPolygon source";
if(!$)
	window.$= jQuery;
if(window.PPW)
	throw "This library was already loaded or there is another variable with the name PPW in this page! Please, verify it!";
	
window.PPW= new (function(){
	this.PERM_LINK_TITLE= 'title';
	this.PERM_LINK_ID= 'id';
	this.PERM_LINK_SOURCE= 'source';
	
	this.consts={
		leftButton: 1
	}
	this.setting= {};
	this.setLoading= function(bool){
		if(bool)
		{
			$('#loading').fadeIn('fast');
			$('#PPWStageElement').fadeOut();
		}else{
			$('#loading').fadeOut('fast');
			setTimeout(function(){
				$('#PPWStageElement').fadeIn();
			}, 500)
		}
	};
	this.addAction= function(act, props){
		if(typeof act == 'function')
		{
			act.props= props||{};
			PPW.currentSlide.actions.push(act);
		}else{
				throw "Your action is not a function!";
			 }
	};
	this.loadSlide= function(slide){
		var slideNum= slide;
		if(this.currentSlideNum == slideNum)
			return;
		if(!(slide= this.settings.slides[slide]))
		{
			throw "Invalid slide numnber";
		}
		this.setLoading(true);
		this.currentSlide= slide;
		this.currentSlideNum= slideNum;
		this.currentSlide.actions= [];
		this.currentSlide.currentAction= 0;
		
		if(PPW.presentationTool)
		{
			try{
				presentationTool.updateSlides();
			}catch(e){}
		}
		
		$.get('slides/'+this.currentSlide.src+"/index.html", function(ret){
		
			PPW.stage= document.getElementById('PPWStageElement');
			PPW.stage.innerHTML= ret;
			var scripts= PPW.stage.getElementsByTagName('script')
			for(var i=0, j=scripts.length; i<j; i++)
			{
				try{
					(new Function(scripts[i].textContent))();
				}catch(e){
						console.log("Your script triggered an error!\n"+e.message+"\nline "+e.line, e);
				}
			}
			
			setTimeout(function(){
				var className= 'slide_'+(PPW.currentSlide.type||'default');
				if(PPW.currentSlide.id)
					className+= " slide-id-";
				/*if(PPW.currentSlide.id == 0)
					className+= " first";
				else if(PPW.currentSlide.id == PPW.slides.length-1)
					className+= " last";*/
				document.body.className= className;
				PPW.setLoading(false);
				if(PPW.currentSlide.useChromeVox)
				{
					setTimeout(function(){
						PPW.speakAndSyncToNode(PPW.stage);
					}, 2000);
				}
				
				if(PPW.theme.onslidechange && typeof PPW.theme.onslidechange == 'function')
					try{PPW.theme.onslidechange()}catch(e){console.log(e)};
				
			}, PPW.settings.themeParameters.transitionTime||500)
			if(PPW.theme.onload && typeof PPW.theme.onload == 'function')
				try{PPW.theme.onload()}catch(e){console.log(e)};
		});
	};
	
	var getSlideByTitle= function(slide){
		for(var i=0, j=PPW.settings.slides.length; i<j; i++){
			if(PPW.settings.slides[i].title.replace(/ /g, '-').replace(/'|"/g, '')==slide)
			{
				PPW.settings.slides[i].id= i;
				return PPW.settings.slides[i];
			}
		}
		return false;
	};
	var getSlideBySource= function(slide){
		for(var i=0, j=PPW.settings.slides.length; i<j; i++){
			if(PPW.settings.slides[i].src==slide)
			{
				PPW.settings.slides[i].id= i;
				return PPW.settings.slides[i];
			}
		}
		return false;
	};
	var getSlideByID= function(slide){
		PPW.settings.slides.id= slide;
		return PPW.settings.slides[slide];
	};
	
	this.getPermaLink= function(id){
		var permaLink;
		
		switch(PPW.settings.permalinkBy)
		{
			case PPW.PERM_LINK_TITLE:
				permaLink= id && isNaN(id)? getSlideByTitle(id).title: getSlideByID(id||0).title;
				permaLink= escape(permaLink.replace(/ /g, '-').replace(/'|"/g, ''));
				break;
			case PPW.PERM_LINK_SOURCE:
				permaLink= id && isNaN(id)? getSlideBySource(id).src: getSlideByID(id||0).src;
				break;
			default:
				permaLink= id? id: 0;
				break;
		}
		return permaLink;
	};
	this.getSlideID= function(id){
		var permaLink;
		switch(PPW.settings.permalinkBy)
		{
			case PPW.PERM_LINK_TITLE:
				permaLink= id? getSlideByTitle(id).id: getSlideByID(0).id;
				//permaLink= escape(permaLink.replace(/ /g, '-').replace(/'|"/g, ''));
				break;
			case PPW.PERM_LINK_SOURCE:
				permaLink= id? getSlideBySource(id).id: getSlideByID(0).id;
				break;
			default:
				permaLink= id? id: 0;
				break;
		}
		return permaLink;
	}
	
	this.initialize= function(){
	
		document.body.className= 'slide_transitioning';
		if(!this.settings.fwSrc)
			throw "You need to specify where is the framework";
		
		if(this.settings.stage)
			this.stage= document.getElementById(this.settings.stage);
		else{
			this.stage= document.createElement('div');
			this.stage.id= "PPWStageElement";
			document.body.appendChild(this.stage);
			this.stage= document.getElementById('PPWStageElement')
		}
		
		if(this.settings.presentationTool)
		{
			PPW.presentationTool= window.open(this.settings.fwSrc+"/presentationTool.html",
													 "presentationTool",
													 "status=0,toolbar=0,address=0,location=0,menubar=0,directories=0,resizable=0,scrollbars=0,width=600,height=450");
		}
		
		$("<link/>", {
		   rel: "stylesheet",
		   type: "text/css",
		   href: this.settings.fwSrc+"/PowerPolygon.css"
		}).appendTo("head");
		
		$("<link/>", {
		   rel: "stylesheet",
		   type: "text/css",
		   href: this.settings.fwSrc+"/vendors/animate.css"
		}).appendTo("head");
		
		$("<link/>", {
		   rel: "stylesheet",
		   type: "text/css",
		   href: this.settings.fwSrc+"themes/"+(PPW.settings.theme||'default')+'/styles/theme.css'
		}).appendTo("head");
		
		$.getScript(this.settings.fwSrc+"themes/"+(PPW.settings.theme||'default')+'/scripts/theme.js');
		
		$.get(this.settings.fwSrc+"themes/"+(PPW.settings.theme||'default')+'/template.html', function(ret){
			document.body.innerHTML+= ret;
			//document.getElementById('credits').innerHTML= PPW.settings.authors.toString();
		});
		
		if(!this.settings.slides || this.settings.slides.length == 0)
			throw "Please, defined the slides to be used";
		
		if(window.location.hash)
		{
			this.loadSlide(this.getSlideID(window.location.hash.replace(/#/, '').replace(/\?.*/, '')));
		}else{
			history.pushState({}, "", "#"+this.getPermaLink(0));
			this.loadSlide(0);
		}
		
		this.isClickable= function(t){
			if(
				!$(t).hasClass('clickable')
				&&
				t.tagName.toUpperCase()!='INPUT'
				&&
				t.tagName.toUpperCase()!='TEXTAREA'
				&&
				t.tagName.toUpperCase()!='BUTTON'
				&&
				t.tagName.toUpperCase()!='SUBMIT'
				&&
				t.tagName.toUpperCase()!='LABEL'
				&&
				t.tagName.toUpperCase()!='A'
			  )
			{
				return false;
			}
			return true;
		}
		
		window.onscroll= function(){
			window.scrollTo(0, 0);
		}
		
		$(document).bind('keyup', function(event){
			var t= event.target||event.srcElement;
			
			if(!PPW.isClickable(t))
			{
				switch(event.keyCode)
				{
					case 32:  // space
					case 39: // right
					case 34: // PgDown
					case 13: // enter
							if(PPW.nextSlide())
							{
								PPW.setLoading(true);
							}
							break;
					case 8:  // backspace
					case 37: // left
					case 33: // PgUp
							if(PPW.previousSlide())
							{
								PPW.setLoading(true);
							}
							break;
					case 27: // ESC
							break;
				}
			}
		});
		$(document.body).click(function(event){
			var bt= event.button||event.which;
			var t= event.target||event.srcElement;
			
			if(!PPW.isClickable(t))
			{
				if(bt == PPW.consts.leftButton)
				{
					if(PPW.nextSlide())
						PPW.setLoading(true);
				}else if(bt == PPW.consts.rightButton){
						if(PPW.previousSlide())
							PPW.setLoading(true);
					 }
			}
		});
		if(!PPW.theme)
			PPW.theme= {};
	};
	this.finishPresentation= function(){
		/*document.body.style.color= 'white';
		document.body.style.backgroundColor= 'black';
		document.body.innerHTML= "End of presentetion"*/
		document.getElementById('PPWStageElement').innerHTML= 'End of presentetion';
	};
	this.previousSlide= function(){
		this.setLoading(true);
		var t= this.settings.themeParameters.transitionTime||500;
		
		if(!this.settings.slides[parseInt(PPW.currentSlideNum)-1])
		{
			PPW.setLoading(false);
			return;
		}
		
		if(PPW.theme.onbeforeslidechange && typeof PPW.theme.onbeforeslidechange == 'function')
			try{PPW.theme.onbeforeslidechange()}catch(e){console.log(e)};
					
		$(document.body).addClass('slide_transitioning previous-transition');
		
		history.pushState({}, PPW.currentSlide.title, "#"+(PPW.getPermaLink(PPW.currentSlideNum-1)));
		
		if(PPW.theme.onprev && typeof PPW.theme.onprev == 'function')
			try{PPW.theme.onprev()}catch(e){console.log(e)};
		
		setTimeout(function(){
			PPW.loadSlide(parseInt(PPW.currentSlideNum)-1);
		}, t);
	};
	this.nextSlide= function(){
		var cur= PPW.currentSlide.currentAction+1;
		var htmlAnimEls= $('[class*="anim-step'+(parseInt(cur, 10)+1)+'"]').eq(0),
			transition= true;
		if(htmlAnimEls.length>0)
		{
			$('[class*="anim-step'+(cur)+'"]').eq(0).fadeOut((function(htmlAnimEls){
				return function(){
					htmlAnimEls.fadeIn()
				}
			})(htmlAnimEls)).removeClass('anim-step'+(cur));
			transition= false;
		}
		
		if(PPW.currentSlide.actions.length && PPW.currentSlide.currentAction < PPW.currentSlide.actions.length)
		{
			var curAct= PPW.currentSlide.actions[PPW.currentSlide.currentAction],
				goToNextNow= false,
				nextStep= true;
			if(typeof curAct == 'function')
			{
				curAct();
			
				if(curAct.props){
					if(curAct.props.step){
						//alert(PPW.currentSlide.currentAction)
						nextStep= false; // ??
					}
					if(curAct.props.goToNext)
					{
						if(!isNaN(curAct.props.goToNext)){
							setTimeout(PPW.nextSlide, curAct.props.goToNext);
						}else if(curAct.props.goToNext == 'now')
								goToNextNow= true;
					}
				}
			}
			if(goToNextNow)
				PPW.nextSlide();
			transition= false;
		}
		
		if(!transition){
			PPW.currentSlide.currentAction++;
			return false;
		}
		
		if(PPW.theme.onbeforeslidechange && typeof PPW.theme.onbeforeslidechange == 'function')
			try{PPW.theme.onbeforeslidechange()}catch(e){console.log(e)};
			
		$(document.body).addClass('slide_transitioning next-transition');
		
		if(PPW.theme.onnext && typeof PPW.theme.onnext == 'function')
			try{PPW.theme.onnext()}catch(e){console.log(e)};
			
		this.setLoading(true);
		var t= this.settings.themeParameters.transitionTime||500;
		
		if(!this.settings.slides[parseInt(PPW.currentSlideNum)+1])
		{
			this.finishPresentation();
			return false;
		}
		if(PPW.presentationTool && PPW.currentSlideNum === 0)
		{
			presentationTool.chronoStart();
		}
		history.pushState({}, PPW.currentSlide.title, "#"+(PPW.getPermaLink(parseInt(PPW.currentSlideNum)+1)));
		
		setTimeout(function(){
			if(PPW.theme.onstartloading && typeof PPW.theme.onstartloading == 'function')
				try{PPW.theme.onstartloading()}catch(e){console.log(e)};
			PPW.loadSlide(parseInt(PPW.currentSlideNum)+1);
		}, t);
		return true;
	};
	
	this.init= function(settings){
		this.settings= settings;
	}
	
	
	/**** FOR GOOGLE CHROME VOX FEATURES ****/
	this.isChromeVoxActive= function () {
	  if (typeof(cvox) == 'undefined') {
		return false;
	  } else {
		return true;
	  }
	};

	this.speakAndSyncToNode= function (node) {
	
	  if (!this.isChromeVoxActive()) {
		return;
	  }
	  cvox.ChromeVox.navigationManager.switchToStrategy(
		  cvox.ChromeVoxNavigationManager.STRATEGIES.LINEARDOM, 0, true);
	  cvox.ChromeVox.navigationManager.syncToNode(node);
	  cvox.ChromeVoxUserCommands.finishNavCommand('');
	  var target = node;
	  while (target.firstChild) {
		target = target.firstChild;
	  }
	  cvox.ChromeVox.navigationManager.syncToNode(target);
	};
	this.speak= function(el){
		this.speakAndSyncToNode(el);
	}
	
	/**** ANIMATIONS CONTROL ****/
	var anim= function(qSelector, animType, animSpeed, fn, caller){
		var el;
		if(typeof qSelector == 'string'){
			el= $(qSelector);
		}else{
			el= qSelector;
		}
		$(el).each(function(){
			var tmpClass= PPW.clearClasses(this.className, caller),
				spd= PPW.animSpeeds.indexOf(animSpeed),
				spdNum= 0;
			if(spd < 0)
				throw "Invalid speed "+animSpeed;
			
			tmpClass= tmpClass+" anim-speed-"+animSpeed+" "+animType;
			
			spdNum= PPW.getSpeedNum(spd);
			
			if(fn && typeof fn == 'function')
				setTimeout((function(fn, el, caller){
					return function(){
						if(caller == 'out')
							el.style.visibility= 'hidden';
						fn();
					};
				})(fn, this, caller), spdNum);
			this.className= tmpClass;
		});
	};
	
	this.animIn= function(qSelector, animType, animSpeed, fn){
		anim(qSelector, animType, animSpeed, fn, 'in');
	};
	this.animOut= function(qSelector, animType, animSpeed, fn){
		anim(qSelector, animType, animSpeed, fn, 'out');
	}
	this.animEmphasis= function(qSelector, animType, animSpeed, fn){
		anim(qSelector, animType, animSpeed, fn, 'emphasis');
	}
	
	this.help= function(){
		var help= "Hello.\n";
		help+= "You can see the speed options by accessing the public property window.PPW.animSpeeds\n";
		help+= "You can use anymations of type in(animIn), out(animOut) and emphasis(animEmphasis). To see their options, access the public property window.PPW.animations[in, out or emphasis]\n";
		help+= "You can add actions for your slides by using the window.PPW.addAction public method\n";
		help+= "Please, check the available CSS classes in the public property window.PPW.availableClasses\n";
		/* TODO: make a better help text :p */
		if(console && console.log)
			console.log(help);
		return help;
	}
	
})();
$(document).ready(function(){
	document.body.addEventListener('mousemove', function(){
		window.clearTimeout(PPW.mouseHidder);
		if(!PPW.mouseHiding) // a bug on google chrome!
			document.body.style.cursor= '';
		PPW.mouseHidder= window.setTimeout(function(){
			PPW.mouseHiding= true;
			document.body.style.cursor= 'none';
			setTimeout(function(){PPW.mouseHiding=false}, 500); // again, fixing the same bug for google chrome!
		}, 1500)
	}, false);
	PPW.initialize();
})
window.onpopstate= function(){
	if(window.location.hash)
	{
		PPW.loadSlide(PPW.getSlideID(window.location.hash.replace(/#/, '').replace(/\?.*/, '')));
	}else{
		PPW.loadSlide(0);
	}
}
//PPW;

window.onresize= function(){
}

window.PPW.animSpeeds= [
	'slowest',
	'slower',
	'slow',
	'normal',
	'fast',
	'faster',
	'fastest'
];
window.PPW.availableClasses= [
	'content',
	'anim-step0',
	'anim-step1',
	'anim-step2',
	'anim-step...'
	/* TODO: add the rest of the list of css classes here! */
];
window.PPW.animations= {
	'in': [
		'fadeIn',
		'fadeInUp',
		'fadeInDown',
		'fadeInLeft',
		'fadeInRight',
		'fadeInUpBig',
		'fadeInDownBig',
		'fadeInLeftBig',
		'fadeInRightBig',
		'bounceIn',
		'bounceInDown',
		'bounceInUp',
		'bounceInLeft',
		'bounceInRight',
		'rotateIn',
		'rotateInDownLeft',
		'rotateInDownRight',
		'rotateInUpLeft',
		'rollIn',
		'rotateInUpRigh'
	],
	out: [
		'fadeOut',
		'fadeOutUp',
		'fadeOutDown',
		'fadeOutLeft',
		'fadeOutRight',
		'fadeOutUpBig',
		'fadeOutDownBig',
		'fadeOutLeftBig',
		'fadeOutRightBig',
		'bounceOut',
		'bounceOutDown',
		'bounceOutUp',
		'bounceOutLeft',
		'bounceOutRight',
		'rotateOut',
		'rotateOutDownLeft',
		'rotateOutDownRight',
		'rotateOutUpLeft',
		'rollOut',
		'rotateOutUpRight'
	],
	emphasis: [
		'flash',
		'bounce',
		'shake',
		'tada',
		'swing',
		'wobble',
		'pulse',
		'hinge'
	]
};

window.PPW.getSpeedNum= function(spd){
	switch(spd){
		case 0:
			spdNum= 3000;
			break;
		case 1:
			spdNum= 2000;
			break;
		case 2:
			spdNum= 1500;
			break;
		case 3:
			spdNum= 1000;
			break;
		case 4:
			spdNum= 750;
			break;
		case 5:
			spdNum= 500;
			break;
		case 6:
			spdNum= 200;
			break;
	}
	return spdNum;
}

window.PPW.clearClasses= function(tmpClass, type){
	tmpClass= tmpClass.replace(new RegExp("anim-speed-"+PPW.animSpeeds.join('|anim-speed-'), 'ig'), '')
	if(!PPW.animations[type])
		throw "Invalid type "+type;
	tmpClass= tmpClass.replace(new RegExp(PPW.animations[type].join('|'), 'ig'), '')
	return tmpClass;
}
















