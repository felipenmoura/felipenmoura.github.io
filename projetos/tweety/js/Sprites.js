var Sprited= Array();
var Sprite= function(el, sprt){
	this.id= el.getAttribute('id')? el.id: Math.ceil(Math.random()*9999)+'_spritedElement';
	this.conf= sprt;
	this.el= el;
	this.currentScene= 0;
	this.currentStep= 0;
	this.spriteImage= document.createElement('img');
	this.spriteImage.src= this.conf.src;
	this.animating= false;
	this.stop= true;
	this.mode= true;
	this.resetOnSceneStart= true;
	
	this.stop= function(){
		this.stop= true;
	};
	this.loop= function(){
		if(this.stop)
			return false;
//		alert(this.currentScene)
		var cs= this.conf.scenes[this.currentScene].frames[this.currentStep];
		if(cs)
		{
			this.el.style.width= cs.width+'px';
			this.el.style.height= cs.height+'px';
			this.el.style.backgroundPosition= -1*(cs.left)+'px '+cs.top+'px';
			var t= cs.nextIn;
			if(this.mode)
				this.currentStep++;
			else
				this.currentStep--;
			if(this.currentStep<0) // strangely, it happens in some browsers! Some day I'll try to find why!
				this.currentStep= 0;
		
			if(!this.mode && this.currentStep == 0)
				this.mode= true;
			
			if(this.conf.scenes[this.currentScene].frames.length == this.currentStep)
			{
				// end of sprite animation
				if(this.conf.scenes[this.currentScene].loopType == 'linear')
				{
					this.currentStep= 0;
				}else{
						if(this.conf.scenes[this.currentScene].loopType == 'alternate')
						{
							this.mode= false;
							this.currentStep--;
						}else
							return;
					 }
			}
		}
		setTimeout("Sprited['"+this.id+"'].loop();", t);
	};
	
	this.goToScene= function(sc)
	{
		if(this.conf.scenes[sc-1])
		{
			if(this.resetOnSceneStart)
			this.currentStep= 0;
			this.currentScene= sc-1;
			this.set();
		}
	}
	
	this.set= function()
	{
//		this.el.style.background= "url("+this.conf.src+") "+this.conf.scenes[this.currentScene].frames[this.currentStep].left+"px "+this.conf.scenes[this.currentScene].frames[this.currentStep].top+"px";
		var cs= this.conf.scenes[this.currentScene].frames[this.currentStep];
		this.el.style.backgroundPosition= -1*(cs.left)+'px '+cs.top+'px';
		
		this.el.style.width= this.conf.scenes[this.currentScene].frames[this.currentStep].width+'px';
		this.el.style.height= this.conf.scenes[this.currentScene].frames[this.currentStep].height+'px';
	};
	this.init= function(){
		this.el.style.background= "url("+this.conf.src+")";
		this.stop= false;
		Sprited[this.id]= this;
		this.set();
		this.loop(this.id);
	};
	if(this.conf.autoStart)
		this.init();
};
