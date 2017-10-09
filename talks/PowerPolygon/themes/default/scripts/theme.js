
if(!PPW.settings.themeParameters)
	PPW.settings.themeParameters= {};

//PPW.settings.themeParameters.transitionTime= 1000;

PPW.theme= {
	onload: function(){console.log('onload')},
	onstartloading: function(){console.log('onstartloading')},
	onnext: function(){console.log('onnext')},
	onprev: function(){console.log('onprev')},
	onbeforeslidechange: function(){console.log('onbeforeslidechange')},
	onslidechange: function(){console.log('onslidechange')}
}