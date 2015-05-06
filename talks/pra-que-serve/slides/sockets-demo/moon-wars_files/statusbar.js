var STATUS = new STATUS_CLASS();

function STATUS_CLASS(){
	//draw statusbar
	this.draw_status_bar = function(){	
		//background
		canvas_backround.fillStyle = "#686868";
		canvas_backround.fillRect (0, HEIGHT_APP-27, WIDTH_APP, 27);
		
		//top border
		canvas_backround.beginPath();
		canvas_backround.strokeStyle='#292929';
		canvas_backround.moveTo(0, HEIGHT_APP-26.5);
		canvas_backround.lineTo(WIDTH_APP, HEIGHT_APP-26.5);
		canvas_backround.lineWidth = 1;
		canvas_backround.stroke();
		
		//bottom border
		canvas_backround.beginPath();
		canvas_backround.strokeStyle='#000000';
		canvas_backround.moveTo(0, HEIGHT_APP);
		canvas_backround.lineTo(WIDTH_APP, HEIGHT_APP);
		canvas_backround.stroke();
		
		//buttons
		this.draw_mute_music_button();
		this.draw_mute_fx_button();
		this.draw_quality_button(true);
		this.draw_quit_button();
		this.draw_fs_button();
		this.draw_version();
		};
	//show mute music button in statusbar
	this.draw_mute_music_button = function(){
		PADDING = 55;
		var width = 48;
		var height = 18;
	
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#414141";
		HELPER.roundRect(canvas_backround, WIDTH_APP-PADDING, HEIGHT_APP-23+1, width, height, 5, true);
		
		fs_text = "Music";
		if(MUTE_MUSIC == true)
			canvas_backround.fillStyle = "#686868";
		else
			canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "normal 11px Arial";
		var tmp = round((width - canvas_backround.measureText(fs_text).width)/2);
		canvas_backround.fillText(fs_text, WIDTH_APP-PADDING+tmp, HEIGHT_APP-18-5+14);
		
		//line
		if(MUTE_MUSIC == false){
			canvas_backround.beginPath();
			var min = WIDTH_APP-PADDING+5;
			var max = WIDTH_APP-PADDING+width-5;
			var length = MUSIC_VOLUME * (max-min) + min;
			canvas_backround.moveTo(min, HEIGHT_APP-7+0.5);
			canvas_backround.lineTo(length, HEIGHT_APP-7+0.5);
			canvas_backround.lineWidth = 1;
			canvas_backround.strokeStyle = "#ffffff";
			canvas_backround.stroke();
			}
		MAIN.register_button(WIDTH_APP-PADDING, HEIGHT_APP-23, 48, 20, '', STATUS.mute_unmute_music, WIDTH_APP-PADDING, 'nofix');
		};
	//draw mute effects button in statusbar
	this.draw_mute_fx_button = function(){
		PADDING = 108;
		var width = 48;
		var height = 18;
		
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#414141";
		HELPER.roundRect(canvas_backround, WIDTH_APP-PADDING, HEIGHT_APP-23+1, width, height, 5, true);
		fs_text = "Sound";
		if(MUTE_FX == true)
			canvas_backround.fillStyle = "#686868";
		else
			canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "normal 11px Arial";
		var tmp = round((width - canvas_backround.measureText(fs_text).width)/2);
		canvas_backround.fillText(fs_text, WIDTH_APP-PADDING+tmp, HEIGHT_APP-18-5+14);
		
		//line
		if(MUTE_FX == false){
			canvas_backround.beginPath();
			var min = WIDTH_APP-PADDING+5;
			var max = WIDTH_APP-PADDING+width-5;
			var length = FX_VOLUME * (max-min) + min;
			canvas_backround.moveTo(min, HEIGHT_APP-7+0.5);
			canvas_backround.lineTo(length, HEIGHT_APP-7+0.5);
			canvas_backround.lineWidth = 1;
			canvas_backround.strokeStyle = "#ffffff";
			canvas_backround.stroke();
			}
		
		MAIN.register_button(WIDTH_APP-PADDING, HEIGHT_APP-23, 48, 20, '', STATUS.mute_unmute_fx, WIDTH_APP-PADDING, 'nofix');
		};
	//show quality button in statusbar
	this.draw_quality_button = function(first_run){
		PADDING = 161;
		var width = 48;
		var height = 18;
		
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#414141";
		HELPER.roundRect(canvas_backround, WIDTH_APP-PADDING, HEIGHT_APP-23+1, width, height, 5, true);
		quality_cookie = HELPER.getCookie("quality");
		if(quality_cookie != '')
			QUALITY = quality_cookie;
		
		var q_text = 'E';
		if(QUALITY==1)
			q_text = "Low";
		else if(QUALITY==2)
			q_text = "Mid";
		else if(QUALITY==3)
			q_text = "High";
		
		if(PLACE=='game' && first_run==false)
			MAP.draw_map(true);
		
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "normal 11px Arial";
		var tmp = round((width - canvas_backround.measureText(q_text).width)/2);
		canvas_backround.fillText(q_text, WIDTH_APP-PADDING+tmp, HEIGHT_APP-18-5+14);
		
		MAIN.register_button(WIDTH_APP-PADDING, HEIGHT_APP-23, 48, 20, '', function(){
			MAP.change_quality();
			STATUS.draw_quality_button(false);
			}, false, 'nofix');
		};
	//quit button in statusbar
	this.draw_quit_button = function(){
		PADDING = 214;
		var width = 48;
		var height = 18;
		
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#414141";
		HELPER.roundRect(canvas_backround, WIDTH_APP-PADDING, HEIGHT_APP-23+1, width, height, 5, true);
		q_text = "Quit";
		canvas_backround.fillStyle = "#f3676f";
		canvas_backround.font = "Bold 11px Helvetica";
		var tmp = round((width - canvas_backround.measureText(q_text).width)/2);
		canvas_backround.fillText(q_text, WIDTH_APP-PADDING+tmp, HEIGHT_APP-18-5+14);
		
		MAIN.register_button(WIDTH_APP-PADDING, HEIGHT_APP-23, 48, 20, '', MAIN.quit_game, false, 'nofix');
		};
	//show fullscreen button in statusbar
	this.draw_fs_button = function(){
		if(PLACE != 'game' ) return false;
		PADDING = 267;
		var width = 48;
		var height = 18;
		
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#414141";
		HELPER.roundRect(canvas_backround, WIDTH_APP-PADDING, HEIGHT_APP-23+1, width, height, 5, true);
		fs_text = "Full Scr.";
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Normal 11px Arial";
		var tmp = round((width - canvas_backround.measureText(fs_text).width)/2);
		canvas_backround.fillText(fs_text, WIDTH_APP-PADDING+tmp, HEIGHT_APP-18-5+14);
		
		MAIN.register_button(WIDTH_APP-PADDING, HEIGHT_APP-23, 48, 20, PLACE, function(){
			fullscreen('canvas_area');
			}, false, 'nofix');
		};
	//show version instatus bar
	this.draw_version = function(){
		PADDING = 10;
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Normal 11px Helvetica";
		canvas_backround.fillText("v"+VERSION, PADDING, HEIGHT_APP-18-5+14);
		};
	//do mute or unmute music
	this.mute_unmute_music = function(mouse_x, mouse_y, left_margin){
		mode = 1;
		if(mouse_y - HEIGHT_APP + 23 > 15){
			mode = 2;
			var min = left_margin+5;
			var max = left_margin+48-5;
			var power = 100 * (mouse_x - min) / (max - min);
			if(power<0) power = 10;
			if(power>100) power = 100;
			power = round(power)/100;
			MUSIC_VOLUME = power;
			if(MUTE_MUSIC==true)
				MUTE_MUSIC = false;
			else{
				try{
					audio_main.volume = MUSIC_VOLUME;
					}
				catch(error){}
				}
			}
		if(mode==1){
			if(MUTE_MUSIC==false){
				//disable sound
				MUTE_MUSIC = true;
				if(audio_main != undefined)
					audio_main.pause();
				}
			else{
				//enable sound
				MUTE_MUSIC = false;
				try{
					if(PLACE == 'game'){
						audio_main = document.createElement('audio');
						audio_main.setAttribute('src', '../sounds/main'+SOUND_EXT);
						audio_main.setAttribute('loop', 'loop');
						audio_main.volume = MUSIC_VOLUME;
						audio_main.play();
						}
					}catch(error){}
				}
			}
		if(MUTE_MUSIC==true)	HELPER.setCookie("mute_music", "0", 30);
		else			HELPER.setCookie("mute_music", MUSIC_VOLUME, 30);
		STATUS.draw_mute_music_button();
		};
	//do mute or unmute effects
	this.mute_unmute_fx = function(mouse_x, mouse_y, left_margin){
		mode = 1;
		if(mouse_y - HEIGHT_APP + 23 > 15){
			mode = 2;
			var min = left_margin+5;
			var max = left_margin+48-5;
			var power = 100 * (mouse_x - min) / (max - min);
			if(power<0) power = 10;
			if(power>100) power = 100;
			power = round(power)/100;
			FX_VOLUME = power;
			if(MUTE_FX==true)
				MUTE_FX = false;
			}
		if(mode==1){
			if(MUTE_FX==false)	MUTE_FX = true;
			else			MUTE_FX = false;
			}
		if(MUTE_FX==true)	HELPER.setCookie("mute_fx", "0", 30);
		else			HELPER.setCookie("mute_fx", FX_VOLUME, 30);
		STATUS.draw_mute_fx_button();
		};
	}
