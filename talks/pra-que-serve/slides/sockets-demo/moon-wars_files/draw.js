var DRAW = new DRAW_CLASS();

function DRAW_CLASS(){
	this.frame_time;
	this.last_selected = -1;
	this.settings_positions = [];
	var frame_last_time;
	var red_line_y=0;
	var last_active_tab = -1;
	var logo_visible = 1;
	var score_button_pos = new Array();
	var lastLoop = new Date;	//tmp var for fps
	
	//main drawing
	this.draw_main = function(){
		if(PLACE != 'game') return false;
		frame_last_time = DRAW.frame_time;
		if(frame_last_time==undefined)
			frame_last_time = Date.now();
		DRAW.frame_time = Date.now();
		time_gap = Date.now() - frame_last_time;
		
		//clear main
		if(PLACE == 'game')
			canvas_main.clearRect(0, 0, WIDTH_SCROLL, HEIGHT_SCROLL);
			
		INFOBAR.redraw_mini_map();	// mini map actions
		
		//external drawings functions
		for (i in pre_draw_functions){
			SKILLS[pre_draw_functions[i][0]](pre_draw_functions[i][1]);
			}
	
		//tanks actions
		for(var i=0; i < TANKS.length; i++){
			var angle = undefined;
			try{
				//speed multiplier
				var speed_multiplier = 1;
				speed_multiplier = UNITS.apply_buff(TANKS[i], 'speed', speed_multiplier);
					
				//check buffs
				for(var x=0; x < TANKS[i].buffs.length; x++){
					if(TANKS[i].buffs[x].lifetime != undefined && TANKS[i].buffs[x].lifetime < Date.now()){
						TANKS[i].buffs.splice(x, 1); x--;
						}
					}	
				
				//lifetime
				if(TANKS[i].lifetime != undefined && TANKS[i].lifetime < Date.now()){
					TANKS.splice(i, 1); i--;
					continue;
					}
				
				//respawn
				if(TANKS[i].death_respan != undefined){
					if(TANKS[i].death_respan - Date.now() < 0){
						delete TANKS[i].death_respan;
						UNITS.set_spawn_coordinates(TANKS[i]);
						TANKS[i].hp = UNITS.get_tank_max_hp(TANKS[i]);
						if(TANKS[i].id==MY_TANK.id)
							MAP.auto_scoll_map();
						}
					}
				
				//ghost mode
				if(TANKS[i].respan_time != undefined){
					//message
					if(TANKS[i].id == MY_TANK.id){
						screen_message.text = "You will respawn in  "+Math.ceil((TANKS[i].respan_time-Date.now())/1000)+" seconds.";
						screen_message.time = TANKS[i].respan_time;
						}
					speed_multiplier = 0.5;
					if(TANKS[i].respan_time - Date.now() < 0){
						delete TANKS[i].respan_time;
						delete TANKS[i].dead;
						}
					}
				
				//construction finish
				if(TANKS[i].constructing != undefined && TANKS[i].constructing.time >= TANKS[i].constructing.duration){
					if(game_mode == 'single_craft')
						delete TANKS[i].constructing;
					else if(TANKS[i].team == MY_TANK.team){
						//send signal to finish building
						var params = [
							{key: 'constructing', value: 'delete'},
							];
						MP.send_packet('tank_update', [TANKS[i].id, params]);
						}
					}
				
				//check stun
				if(TANKS[i].stun - Date.now() < 0)
					delete TANKS[i].stun;
				
				//animations
				DRAW.do_animations(TANKS[i]);
					
				//move lock
				if(TANKS[i].target_move_lock != undefined){
					var i_locked = false;
					for(var t in TANKS){
						if(TANKS[t].id == TANKS[i].target_move_lock)
							i_locked = t;
						}
					if(TANKS[i_locked] == undefined || TANKS[i_locked].dead == 1){	//maybe target is already dead
						if(game_mode == 'single_quick' || game_mode == 'single_craft'){
							TANKS[i].move = 0;
							delete TANKS[i].target_move;
							delete TANKS[i].target_move_lock;
							}
						else{
							var params = [
								{key: 'move', value: 0 },
								{key: 'target_move', value: "delete" },
								{key: 'target_move_lock', value: "delete" },
								];
							MP.send_packet('tank_update', [TANKS[i].id, params]);
							}
						}
					else{
						tmp_distance = UNITS.get_distance_between_tanks(TANKS[i_locked], TANKS[i]);
						//executing custom function
						if(TANKS[i].reach_tank_and_execute != undefined && tmp_distance < TANKS[i].reach_tank_and_execute[0]){
							//executing custom function
							TANKS[i].move = 0;
							delete TANKS[i].target_move_lock;
							delete TANKS[i].move_to;
							if(typeof TANKS[i].reach_tank_and_execute[1] == 'string')
								SKILLS[TANKS[i].reach_tank_and_execute[1]](TANKS[i].reach_tank_and_execute[2], TANKS[i_locked].id, true);
							else
								TANKS[i].reach_tank_and_execute[1](TANKS[i].reach_tank_and_execute[2], TANKS[i_locked].id, true);
							delete TANKS[i].reach_tank_and_execute;
							}
						//reached targeted enemy for general attack
						if(TANKS[i].reach_tank_and_execute == undefined && TANKS[i].target_move_lock != undefined){
							if(tmp_distance < TYPES[TANKS[i].type].range-5){ 	
								TANKS[i].move = 0;
								}
							else{
								TANKS[i].move_to = [TANKS[i_locked].cx(), TANKS[i_locked].cy()];
								TANKS[i].move = 1;
								}
							}
						}
					}
					
				//defined range trigger
				if(TANKS[i].reach_pos_and_execute != undefined){
					var xx = TANKS[i].reach_pos_and_execute[2];
					var yy = TANKS[i].reach_pos_and_execute[3];
					//get distance
					tmp_dist_x = xx-TANKS[i].cx();
					tmp_dist_y = yy-TANKS[i].cy();
					tmp_distance = Math.sqrt((tmp_dist_x*tmp_dist_x)+(tmp_dist_y*tmp_dist_y));
					tmp_distance =  tmp_distance - TANKS[i].width()/2;
					
					//executing custom function
					if(tmp_distance < TANKS[i].reach_pos_and_execute[0]){
						//executing custom function
						TANKS[i].move = 0;
						delete TANKS[i].target_move_lock;
						delete TANKS[i].move_to;
						SKILLS[TANKS[i].reach_pos_and_execute[1]](TANKS[i].reach_pos_and_execute[4], true, true);
						delete TANKS[i].reach_pos_and_execute;
						}
					}
				//autopilot
				if(TANKS[i].use_AI == true)
					AI.check_path_AI(TANKS[i]);
				
				if(TANKS[i].invisibility == 1)
					UNITS.check_invisibility(TANKS[i]);
				
				//move tank
				if(TANKS[i].move == 1 && TANKS[i].stun == undefined && TANKS[i].move_to != undefined){
					if(TANKS[i].move_to[0].length == undefined){
						dist_x = TANKS[i].move_to[0] - TANKS[i].x;
						dist_y = TANKS[i].move_to[1] - TANKS[i].y;
						}
					else{
						dist_x = TANKS[i].move_to[0][0] - TANKS[i].x;
						dist_y = TANKS[i].move_to[0][1] - TANKS[i].y;
						}
					distance = Math.sqrt((dist_x*dist_x)+(dist_y*dist_y));
					radiance = Math.atan2(dist_y, dist_x);
					angle = (radiance*180.0)/Math.PI+90;
					angle = round(angle);
					if(DRAW.body_rotation(TANKS[i], "angle", TANKS[i].data.turn_speed, angle, time_gap)){
						if(distance < MAIN.speed2pixels(TANKS[i].data.speed * speed_multiplier, time_gap)){
							if(TANKS[i].move_to[0].length == undefined){
								TANKS[i].move = 0;
								}
							else{
								//we have second way defined
								if(TANKS[i].move_to[1] != undefined)
									TANKS[i].move_to.splice(0, 1);
								else{
									TANKS[i].move = 0;
									}	
								}
							}
						if(UNITS.check_collisions(TANKS[i].cx() + Math.cos(radiance)*TANKS[i].width()/2, TANKS[i].cy()+Math.sin(radiance)*TANKS[i].height()/2, TANKS[i])==true){
							if(game_mode == 'single_quick' || game_mode == 'multi_quick')
								TANKS[i].move = 0;
							}
						else{
							var last_x = TANKS[i].x;
							var last_y = TANKS[i].y;
							TANKS[i].x += Math.cos(radiance) * MAIN.speed2pixels(TANKS[i].data.speed * speed_multiplier, time_gap);
							TANKS[i].y += Math.sin(radiance) * MAIN.speed2pixels(TANKS[i].data.speed * speed_multiplier, time_gap);
							
							//border controll
							var border_error = false;
							if(TANKS[i].cx() < 0) border_error = true;
							if(TANKS[i].cy() < 0) border_error = true;
							if(TANKS[i].cx() > WIDTH_MAP) border_error = true;
							if(TANKS[i].cy() > HEIGHT_MAP) border_error = true;
							
							if(border_error == true){
								TANKS[i].x = last_x;
								TANKS[i].y = last_y;
								}
							}	
						}
					}
				//fire angle
				if(TANKS[i].stun == undefined){
					if(TANKS[i].attacking == undefined){
						//if peace
						if(angle != undefined)
							DRAW.body_rotation(TANKS[i], "fire_angle", TANKS[i].data.turn_speed, angle, time_gap);
						}
					else{
						//in battle
						var TANK_TO = TANKS[i].attacking; 
						if(typeof TANK_TO == 'object'){
							dist_x = TANK_TO.cx() - (TANKS[i].cx());
							dist_y = TANK_TO.cy() - (TANKS[i].cy());
							var radiance = Math.atan2(dist_y, dist_x);
							var enemy_angle = (radiance*180.0)/Math.PI+90;
							
							//rotate
							DRAW.body_rotation(TANKS[i], "fire_angle", TANKS[i].data.turn_speed, enemy_angle, time_gap);
							}
						else
							delete TANKS[i].attacking;
						}
					}
				
				//autoskills
				if((game_mode == 'single_craft' || game_mode == 'multi_craft') && TANKS[i].last_bullet_time + 1200 - Date.now() > 0){
					if(TANKS[i].ai_reuse - Date.now() < 0 || TANKS[i].ai_reuse == undefined){
						TANKS[i].ai_reuse = 1000/2+Date.now();	//half second pause
						AI.try_skills(TANKS[i]);
						}
					}
				
				//map scrolling
				if(TANKS[i].id==MY_TANK.id && TANKS[i].move == 1 && MAP_SCROLL_CONTROLL==false && MAP_SCROLL_MODE==1){
					MAP.auto_scoll_map();
					}
				
				//bullets controll
				UNITS.draw_bullets(TANKS[i], time_gap);
				
				//draw tank
				if(PLACE == 'game' && TANKS[i] != undefined){
					UNITS.check_enemies(TANKS[i]);
					UNITS.draw_tank(TANKS[i]);
					UNITS.train_process(TANKS[i]);
					}
				}
			catch(err){
				console.log("Error: "+err.message);
				}
			}
		
		//target	
		if(mouse_click_controll==true){
			if(target_mode[0] == 'target')
				DRAW.draw_image(canvas_main, 'target', mouse_pos[0]-15, mouse_pos[1]-15);
			
			if(target_range != 0){
				//circle
				canvas_main.beginPath();
				canvas_main.arc(mouse_pos[0], mouse_pos[1], target_range, 0 ,2*Math.PI, false);	
				canvas_main.lineWidth = 1;
				canvas_main.strokeStyle = "#c10000";
				canvas_main.stroke();
				}
			}
			
		MAP.add_scout_and_fog();
		if(screen_message.time > Date.now())
			DRAW.draw_message(canvas_main, screen_message.text);
			
		//show live scores?
		if(tab_scores==true)
			DRAW.draw_final_score(true);
		
		//selection
		if(selection.drag == true){
			//fill
			canvas_main.save();
			canvas_main.globalAlpha = 0.4;
			canvas_main.beginPath();
			canvas_main.rect(selection.x+0.5, selection.y+0.5, selection.x2-selection.x, selection.y2-selection.y);
			canvas_main.fillStyle = "#558a54";
			canvas_main.fill();
			canvas_main.restore();
			//border
			canvas_main.beginPath();
			canvas_main.rect(selection.x+0.5, selection.y+0.5, selection.x2-selection.x, selection.y2-selection.y);
			canvas_main.lineWidth = 1;
			canvas_main.strokeStyle = "#558a54";
			canvas_main.stroke();
			}
		
		//h3 status
		if(game_mode == 'single_craft' || game_mode == 'multi_craft')
			DRAW.draw_he3_info();
		
		DRAW.show_chat();
		
		//fps
		var thisLoop = new Date;
		FPS = 1000 / (thisLoop - lastLoop);
		lastLoop = thisLoop;
		
		//request next draw
		if(render_mode == 'requestAnimationFrame')
			requestAnimationFrame(DRAW.draw_main);
		};
	this.do_animations = function(TANK){
		if(QUALITY == 1) return false;
		for(var a=0; a < TANK.animations.length; a++){
			//lifetime
			if(TANK.animations[a].lifetime < Date.now() ){
				TANK.animations.splice(a, 1); a--;
				continue;
				}
			var animation = TANK.animations[a];
			//jump - with ghosts behind
			if(animation.name == 'jump'){
				var gap = 10;
				dist_x = animation.to_x - (animation.from_x);
				dist_y = animation.to_y - (animation.from_y);
				distance = Math.sqrt((dist_x*dist_x)+(dist_y*dist_y));
				var radiance = Math.atan2(dist_y, dist_x);
				if(distance<gap) return false;	
				for(var i = 0; gap*i < distance; i++){
					alpha = (animation.lifetime - Date.now()) / animation.duration;
					alpha = round(alpha*100)/100;
					x = animation.from_x + round(Math.cos(radiance)*(i*gap));
					y = animation.from_y + round(Math.sin(radiance)*(i*gap));
					UNITS.draw_tank_clone(TANK.type, x, y, animation.angle, alpha);
					}
				}
			//fire explosion - with slow disapearance
			else if(animation.name == 'fire'){
				alpha = (animation.lifetime - Date.now()) / animation.duration;
				alpha = round(alpha*100)/100;
				dist_x = animation.to_x - animation.from_x;
				dist_y = animation.to_y - animation.from_y;
				radiance = Math.atan2(dist_y, dist_x);
				explode_x = animation.from_x + Math.cos(radiance)*(TANK.width()/2+10);
				explode_y = animation.from_y + Math.sin(radiance)*(TANK.height()/2+10);
				canvas_main.save();
				canvas_main.globalAlpha = alpha;
				canvas_main.translate(explode_x+map_offset[0], explode_y+map_offset[1]);
				canvas_main.rotate(animation.angle * TO_RADIANS);
				DRAW.draw_image(canvas_main, "fire", -(24/2), -(32/2));
				canvas_main.restore();
				}
			//explosion - with slow disapearance
			else if(animation.name == 'explosion'){
				alpha = (animation.lifetime - Date.now()) / animation.duration;
				alpha = round(alpha*100)/100;
				canvas_main.save();
				canvas_main.globalAlpha = alpha;
				DRAW.draw_image(canvas_main, 'explosion', animation.x, animation.y);
				canvas_main.restore();
				}	
			//shoot - with blurred sides and moving animation from source to target
			else if(animation.name == 'shoot'){
				alpha = (animation.lifetime - Date.now()) / animation.duration;
				alpha = round(alpha*100)/100;
				bullet_length = 0.7;	//1 = all length
				
				dist_x = animation.to_x - animation.from_x;
				dist_y = animation.to_y - animation.from_y;
				distance = Math.sqrt((dist_x*dist_x)+(dist_y*dist_y));
				radiance = Math.atan2(dist_y, dist_x);

				//adjust corners to begin from turrer and end near enemy border
				var from_x = animation.from_x + Math.cos(radiance) * animation.tank_from_size/2;
				var from_y = animation.from_y + Math.sin(radiance) * animation.tank_from_size/2;
				var to_x = animation.to_x - Math.cos(radiance) * animation.tank_to_size/3;
				var to_y = animation.to_y - Math.sin(radiance) * animation.tank_to_size/3;
				//moving bullet effect
				var bullet_start = distance * (1-bullet_length) * (1-alpha);	//0 -> n
				var bullet_end = distance * (1-bullet_length) * alpha;		//n -> 0
				from_x += Math.cos(radiance) * bullet_start;
				from_y += Math.sin(radiance) * bullet_start;
				to_x -= Math.cos(radiance) * bullet_end;
				to_y -= Math.sin(radiance) * bullet_end;
				
				HELPER.drawSoftLine(canvas_main, from_x+map_offset[0], from_y+map_offset[1], to_x+map_offset[0], to_y+map_offset[1], 
					animation.size, 255, 255, 255, alpha);
				}
			}
		};
	this.draw_he3_info = function(){
		if(PLACE != 'game') return false;
		var left = WIDTH_APP-100;
		var top = 8;
		var value = round(UNITS.player_data[my_nation].he3);
		
		value = HELPER.format("#,##0.####", value);
		if(DEBUG == true)
			value = value+" / "+round(UNITS.player_data[MAIN.enemy_nation].he3);
		
		DRAW.draw_image(canvas_main, 'he3', left, top);
		canvas_main.fillStyle = "#ffffff";
		canvas_main.font = "Bold 10px Verdana";
		canvas_main.fillText(value, left+10+12, top+12);
		};
	this.add_first_screen_elements = function(){
		//logo background color
		canvas_backround.fillStyle = "#676767";
		canvas_backround.fillRect(0, 0, WIDTH_APP, HEIGHT_APP-27);
			
		//back image
		backround_width = 400;
		backround_height = 400;
		for(var i=0; i<Math.ceil((HEIGHT_APP-27)/backround_height); i++){ 
			for(var j=0; j<Math.ceil(WIDTH_APP/backround_width); j++){
				var xx = j*backround_width;
				var yy = i*backround_height;
				var bwidth = backround_width;
				var bheight = backround_height;
				if(xx+bwidth > WIDTH_APP)
					bwidth = WIDTH_APP-xx;
				if(yy+bheight > HEIGHT_APP-27)
					bheight = HEIGHT_APP-27-yy;
				canvas_backround.drawImage(MAIN.IMAGE_MOON, 0, 0, backround_width, backround_height, xx, yy, bwidth, bheight);
				}
			}
		
		//text
		if(logo_visible==1){
			var text = "Moon wars".split("").join(" ");
			canvas_backround.font = "Bold 70px Arial";
			canvas_backround.strokeStyle = '#ffffff';
			canvas_backround.strokeText(text, 160, 340);
			}
		else
			DRAW.draw_logo_tanks(160, 340-52, false);
		
		//on click event
		MAIN.register_button(160, 340-48, 477, 52, 'init', function(){ DRAW.draw_logo_tanks(160, 340-52); });
		
		DRAW.draw_right_buttons();
		STATUS.draw_status_bar();	
		DRAW.add_settings_buttons(canvas_backround, ["Single player"]);
	
		if(name == ''){
			name_tmp = HELPER.getCookie("name");
			if(name_tmp != ''){
				name = name_tmp;
				if(DEBUG==true)
					name = name_tmp + HELPER.getRandomInt(10, 99);
				}
			if(name != ''){
				name = name.toLowerCase().replace(/[^\w]+/g,'').replace(/ +/g,'-');
				name = name[0].toUpperCase() + name.slice(1);
				name = name.substring(0, 10);
				}
			else{
				var popup_settings=[];
				popup_settings.push({
					name: "name",
					title: "Enter your name:",
					value: name,
					});
				popup('Player name', 'update_name', popup_settings, false);
				}
			}
		
		if(MUTE_MUSIC==false && audio_main != undefined)
			audio_main.pause();
		
		PLACE == 'init';
		
		for (i in DRAW.settings_positions){
			//register menu buttons
			MAIN.register_button(DRAW.settings_positions[i].x, DRAW.settings_positions[i].y, DRAW.settings_positions[i].width, DRAW.settings_positions[i].height, 'init', function(xx, yy, extra){
				if(extra==0){
					// single player
					game_mode = 'single_quick';
					DRAW.draw_tank_select_screen();
					}
				else if(extra==1){
					room_id_to_join = -1;
					//multi player
					if(MP.socket_live==false)
						MP.connect_server();
					game_mode = 'multi_quick';
					ROOM.draw_rooms_list();
					}
				}, i);
			}
		canvas_backround.drawImage(MAIN.IMAGE_LOGO, (WIDTH_APP-598)/2, 15);
		};
	//draws logo and main buttons on logo screen
	this.add_settings_buttons = function(canvas_this, text_array, active_i){
		var button_width = 300;
		var button_height = 35;
		var buttons_gap = 7;
		var top_margin = 375;
		var button_i=0;
		var letter_height = 9;
		var padding = 5;
		
		if(active_i==undefined)
			active_i = -1;
		if(last_active_tab == active_i && last_active_tab > -1)
			return false;
			
		last_active_tab = active_i;
		DRAW.settings_positions = [];
		
		for (i in text_array){
			//background
			canvas_this.strokeStyle = "#000000";
			if(i != active_i)
				canvas_this.fillStyle = "rgba(32, 123, 32, 1)";
			else
				canvas_this.fillStyle = "rgba(25, 97, 25, 1)";
			HELPER.roundRect(canvas_this, Math.round((WIDTH_APP-button_width)/2), top_margin+(button_height+buttons_gap)*button_i, button_width, button_height, 5, true);
		
			//text
			canvas_backround.fillStyle = "#ffffff";
			canvas_backround.font = "bold 18px Helvetica";	
			var letters_width = canvas_backround.measureText(text_array[i]).width;
			canvas_backround.fillText(text_array[i], Math.round((WIDTH_APP-button_width)/2+(button_width-letters_width)/2), top_margin+(button_height+buttons_gap)*button_i+Math.round((button_height+letter_height)/2));
			
			//save position
			var tmp = new Array();
			tmp['x'] = Math.round((WIDTH_APP-button_width)/2);
			tmp['y'] = top_margin+(button_height+buttons_gap)*button_i;
			tmp['width'] = button_width;
			tmp['height'] = button_height;
			tmp['title'] = text_array[i];
			DRAW.settings_positions.push(tmp);
			
			button_i++;
			}
		};
	this.draw_right_buttons = function(clean){
		var minibutton_width = 48;
		var minibutton_height = 20;
		var padding = 5;
		var mi = 0;
		var button_color = '#b7b7b7';
		var button_border_c = '#292929'; 
		
		//background
		if(clean != undefined)
			canvas_backround.drawImage(MAIN.IMAGE_BACK, 0, 0, 700, 500, 0, 0, WIDTH_APP, HEIGHT_APP-27);
		
		//intro button
		var mini_x = WIDTH_APP-minibutton_width-padding;
		var mini_y = mi*(minibutton_height+padding)+padding;
		canvas_backround.strokeStyle = button_border_c;
		canvas_backround.fillStyle = button_color;
		HELPER.roundRect(canvas_backround, mini_x, mini_y, minibutton_width, minibutton_height, 5, true);
		
		canvas_backround.fillStyle = "#0c2c0c";
		canvas_backround.font = "Bold 10px Arial";
		text = "Intro";
		text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, mini_x+(minibutton_width-text_width)/2, mini_y+14);
		MAIN.register_button(mini_x, mini_y, minibutton_width, minibutton_height, PLACE, function(){ 
			intro_page=0;
			PLACE = 'intro';
			DRAW.intro(true);
			});
		mi++;
		
		//library
		var mini_x = WIDTH_APP-minibutton_width-padding;
		var mini_y = mi*(minibutton_height+padding)+padding;
		canvas_backround.strokeStyle = button_border_c;
		canvas_backround.fillStyle = button_color;
		HELPER.roundRect(canvas_backround, mini_x, mini_y, minibutton_width, minibutton_height, 5, true);
		
		canvas_backround.fillStyle = "#0c2c0c";
		canvas_backround.font = "Bold 10px Arial";
		text = "Library";
		text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, mini_x+(minibutton_width-text_width)/2, mini_y+14);
		MAIN.register_button(mini_x, mini_y, minibutton_width, minibutton_height, PLACE, function(){ 
			LIBRARY.draw_library_list();
			});
		mi++;
		
		//Controls
		var mini_x = WIDTH_APP-minibutton_width-padding;
		var mini_y = mi*(minibutton_height+padding)+padding;
		canvas_backround.strokeStyle = button_border_c;
		canvas_backround.fillStyle = button_color;
		HELPER.roundRect(canvas_backround, mini_x, mini_y, minibutton_width, minibutton_height, 5, true);
		
		canvas_backround.fillStyle = "#0c2c0c";
		canvas_backround.font = "Bold 10px Arial";
		text = "Controls";
		text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, mini_x+(minibutton_width-text_width)/2, mini_y+14);
		MAIN.register_button(mini_x, mini_y, minibutton_width, minibutton_height, PLACE, function(){ 
			PLACE = 'library';
			MAIN.unregister_buttons(PLACE);
			var padding = 20;
			//background
			canvas_backround.drawImage(MAIN.IMAGE_BACK, 0, 0, 700, 500, 0, 0, WIDTH_APP, HEIGHT_APP-27);
			canvas_backround.fillStyle = "#ffffff";
			canvas_backround.strokeStyle = "#196119";
			HELPER.roundRect(canvas_backround, padding, padding, WIDTH_APP-padding-70, 270, 5, true);
			
			var height_space = 16;
			var st=0;
			LIBRARY.lib_show_stats("move and target", "Mouse", padding+20+90, padding+20+st*height_space, -90); st++;
			LIBRARY.lib_show_stats("additional movements", "Right click", padding+20+90, padding+20+st*height_space, -90); st++;
			LIBRARY.lib_show_stats("skills", "1, 2, 3", padding+20+90, padding+20+st*height_space, -90); st++;
			LIBRARY.lib_show_stats("live scores", "TAB", padding+20+90, padding+20+st*height_space, -90); st++;
			LIBRARY.lib_show_stats("chat", "Enter", padding+20+90, padding+20+st*height_space, -90); st++;
			LIBRARY.lib_show_stats("global chat or team chat in game", "Shift+Enter", padding+20+90, padding+20+st*height_space, -90); st++;
			LIBRARY.lib_show_stats("Destroy unit", "Delete", padding+20+90, padding+20+st*height_space, -90); st++;
			LIBRARY.lib_show_stats("change scroll mode", "S", padding+20+90, padding+20+st*height_space, -90); st++;
			LIBRARY.lib_show_stats("scroll map in manual Sroll mode", "Arrow keys", padding+20+90, padding+20+st*height_space, -90); st++;
			LIBRARY.lib_show_stats("scroll map up/down", "Mouse scroll", padding+20+90, padding+20+st*height_space, -90); st++;
			LIBRARY.lib_show_stats("stop and move map to your tank", "Esc", padding+20+90, padding+20+st*height_space, -90); st++;
			LIBRARY.lib_show_stats("change abilities upgrade mode", "U", padding+20+90, padding+20+st*height_space, -90); st++;
			
			//back button
			offset_top = padding+20+st*height_space+20;
			canvas_backround.strokeStyle = "#000000";
			canvas_backround.fillStyle = "#c50000";
			HELPER.roundRect(canvas_backround, 20+padding, offset_top, 105, 30, 2, true);
			//text
			canvas_backround.fillStyle = "#ffffff";
			canvas_backround.font = "Bold 13px Arial";
			text = "Back";
			canvas_backround.fillText(text, 20+padding+35, offset_top+20);
			//action
			MAIN.register_button(20+padding, offset_top, 105, 30, PLACE, MAIN.quit_game);
			
			DRAW.draw_right_buttons();
			});
		mi++;
		
		//settings
		var mini_x = WIDTH_APP-minibutton_width-padding;
		var mini_y = mi*(minibutton_height+padding)+padding;
		canvas_backround.strokeStyle = button_border_c;
		canvas_backround.fillStyle = button_color;
		HELPER.roundRect(canvas_backround, mini_x, mini_y, minibutton_width, minibutton_height, 5, true);
		
		canvas_backround.fillStyle = "#0c2c0c";
		canvas_backround.font = "Bold 10px Arial";
		text = "Settings";
		text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, mini_x+(minibutton_width-text_width)/2, mini_y+14);
		MAIN.register_button(mini_x, mini_y, minibutton_width, minibutton_height, PLACE, DRAW.draw_settings);
		mi++;
		
		//About
		var mini_x = WIDTH_APP-minibutton_width-padding;
		var mini_y = mi*(minibutton_height+padding)+padding;
		canvas_backround.strokeStyle = button_border_c;
		canvas_backround.fillStyle = button_color;
		HELPER.roundRect(canvas_backround, mini_x, mini_y, minibutton_width, minibutton_height, 5, true);
		
		canvas_backround.fillStyle = "#0c2c0c";
		canvas_backround.font = "Bold 10px Arial";
		text = "About";
		text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, mini_x+(minibutton_width-text_width)/2, mini_y+14);
		MAIN.register_button(mini_x, mini_y, minibutton_width, minibutton_height, PLACE, function(){ 
			PLACE = 'library';
			MAIN.unregister_buttons(PLACE);
			var padding = 20;
			//background
			canvas_backround.drawImage(MAIN.IMAGE_BACK, 0, 0, 700, 500, 0, 0, WIDTH_APP, HEIGHT_APP-27);
			canvas_backround.fillStyle = "#ffffff";
			canvas_backround.strokeStyle = "#196119";
			HELPER.roundRect(canvas_backround, padding, padding, WIDTH_APP-padding-70, 190, 5, true);
			
			var height_space = 16;
			var st=0;
			LIBRARY.lib_show_stats("Moon wars", "Name", padding+20+90, padding+20+st*height_space, -90); st++;
			LIBRARY.lib_show_stats("ViliusL", "Author", padding+20+90, padding+20+st*height_space, -90); st++;
			LIBRARY.lib_show_stats(APP_EMAIL, "Email", padding+20+90, padding+20+st*height_space, -90); st++;
			LIBRARY.lib_show_stats("", "Website", padding+20+90, padding+20+st*height_space, -90); st++;
			//link
			canvas_backround.font = "Bold 10px Verdana";
			canvas_backround.fillStyle = "#69a126";
			var text = APP_URL;
			var text_length = canvas_backround.measureText(text).width;
			canvas_backround.fillText(text, padding+20+90, padding+20+(st-1)*height_space);
			MAIN.register_button(padding+20+90, padding+20+(st-1)*height_space-10, text_length, 10, PLACE, function(){
				var win=window.open(APP_URL, '_blank');
				win.focus();
				});
			
			canvas_backround.font = "normal 11px Verdana";
			canvas_backround.fillStyle = "#196119";
			canvas_backround.fillText("Moon wars is free online HTML5 based tank game. Main features: 9 tanks and 2 air units, 5 maps, single player, ", padding+20, padding+20+(st+1)*height_space);
			canvas_backround.fillText("multiplayer with 4 modes, full screen support, HTML5 only, no flash.", padding+20, padding+20+(st+2)*height_space);
			
			//back button
			offset_top = padding+20+(st+2)*height_space+20;
			canvas_backround.strokeStyle = "#000000";
			canvas_backround.fillStyle = "#c50000";
			HELPER.roundRect(canvas_backround, 20+padding, offset_top, 105, 30, 2, true);
			//text
			canvas_backround.fillStyle = "#ffffff";
			canvas_backround.font = "Bold 13px Arial";
			text = "Back";
			canvas_backround.fillText(text, 20+padding+35, offset_top+20);
			//action
			MAIN.register_button(20+padding, offset_top, 105, 30, PLACE, MAIN.quit_game);
			
			DRAW.draw_right_buttons();
			});
		mi++;
		};
	this.draw_settings = function(){
		PLACE = 'library';
		MAIN.unregister_buttons(PLACE);
		var padding = 20;
		var offset_top = padding+20;
		var value_padding_left = 140;
		//background
		canvas_backround.drawImage(MAIN.IMAGE_BACK, 0, 0, 700, 500, 0, 0, WIDTH_APP, HEIGHT_APP-27);
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.strokeStyle = "#196119";
		HELPER.roundRect(canvas_backround, padding, padding, WIDTH_APP-padding-70, 190, 5, true);
		
		
		//name - name
		canvas_backround.fillStyle = "#3f3b30";
		canvas_backround.font = "Bold 13px Arial";
		canvas_backround.fillText("Name:", padding+25, offset_top+15);
		//text box
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#e2f4cd";
		HELPER.roundRect(canvas_backround, padding+20+value_padding_left, offset_top, 200, 20, 0, true);
		MAIN.register_button(padding+20+value_padding_left, offset_top, 200, 20, PLACE, function(){
			var popup_settings=[];
			popup_settings.push({
				name: "name",
				title: "Enter your name:",
				value: name,
				});
			popup('Player name', 'update_name', popup_settings);
			});
		//text
		canvas_backround.fillStyle = "#000000";
		canvas_backround.font = "Normal 12px Arial";
		canvas_backround.fillText(name, padding+25+value_padding_left, offset_top+15);
		offset_top = offset_top + 40;
		
		
		//back button
		offset_top = offset_top + 20;
		canvas_backround.strokeStyle = "#000000";
		canvas_backround.fillStyle = "#c50000";
		HELPER.roundRect(canvas_backround, padding+25, offset_top, 105, 30, 2, true);
		//text
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Bold 13px Arial";
		text = "Back";
		canvas_backround.fillText(text, padding+25+35, offset_top+20);
		//action
		MAIN.register_button(padding+25, offset_top, 105, 30, PLACE, MAIN.quit_game);
		
		DRAW.draw_right_buttons();
		};
	this.draw_logo_tanks = function(left, top, change_logo){
		var max_size = 60;
		var block_width = 600;
		var block_height = 62;
		//clear
		var backround_width = 400;
		var backround_height = 400;
		var btop = top-7;
		canvas_backround.drawImage(MAIN.IMAGE_MOON, 0, btop, backround_width, block_height, 0, btop, backround_width, block_height);
		if(left+block_width>backround_width)
			canvas_backround.drawImage(MAIN.IMAGE_MOON, 0, btop, backround_width, block_height, backround_width, btop, backround_width, block_height);
	
		if(change_logo==undefined){
			if(logo_visible==0){
				logo_visible=1;
				var text = "Moon wars".split("").join(" ");
				canvas_backround.font = "Bold 70px Arial";
				canvas_backround.strokeStyle = '#ffffff';
				canvas_backround.strokeText(text, left, top+52);
	 	  		return false;
				}
			else{
				logo_visible=0;
				}
			}
		var n = 0;
		for(var t in TYPES){
			if(TYPES[t].type != 'tank') continue;
			if(TYPES[t].mode != undefined && TYPES[t].mode == 'quick') continue;
			n++;
			}
		var k = 0;
		for(var t in TYPES){
			if(TYPES[t].type != 'tank') continue;
			if(TYPES[t].mode != undefined && TYPES[t].mode == 'quick') continue;
			var pos_left = left+k*round(477/n)+(50-TYPES[t].size[1])/2;
			var pos_top = top+52-TYPES[t].size[2];
			UNITS.draw_tank_clone(t, pos_left, pos_top, 0, 1, canvas_backround);
			k++;
			}
		};
	//final scores after game ended
	this.draw_final_score = function(live, win_team){
		var button_width = WIDTH_SCROLL-40;
		var button_height = 15;
		var buttons_gap = 5;
		var top_margin = 60;
		var letter_height = 9;
		var text_y = 70;
		var flag_space = (button_height - UNITS.flag_height)/2;
		
		if(live==false) tab_scores=false;
		canvas = canvas_main;
			
		//find tanks count
		var tanks_n = 0;
		for (var i in TANKS){
			if(TYPES[TANKS[i].type].type == 'tank')
				tanks_n++;
			}
		if(live==true && tanks_n > 13 && tanks_n < 17 ){
			button_height = 12;
			buttons_gap = 4;
			}
		else if(live==true && tanks_n > 16){
			button_height = 10;
			buttons_gap = 3;
			}
		if(game_mode == 'single_craft' || game_mode == 'multi_craft'){
			button_height = 26;
			buttons_gap = 7;
			flag_space = (button_height - UNITS.flag_height)/2;
			}
		if(live==false){				//final scores
			//add some score to winning team
			if(win_team != false){
				for (var i in TANKS){
					if(TANKS[i].team == win_team)
						TANKS[i].score = TANKS[i].score + SCORES_INFO[4];
					}
				}
		
			PLACE = 'score';
			clearInterval(draw_interval_id);
			clearInterval(level_interval_id);
			clearInterval(level_hp_regen_id);
			clearInterval(timed_functions_id);
			//chat_interval_id
			
			if(audio_main != undefined)
				audio_main.pause();
				
			//background
			canvas_main.clearRect(0, 0, WIDTH_SCROLL, HEIGHT_SCROLL);
			canvas.strokeStyle = "#000000";
			canvas.fillStyle = "rgba(255, 255, 255, 0.7)";
			HELPER.roundRect(canvas, 10, 10, WIDTH_SCROLL-20, HEIGHT_SCROLL-20, 0, true);
			
			//quit button
			canvas.strokeStyle = "#000000";
			canvas.fillStyle = "#69A126";
			HELPER.roundRect(canvas, Math.round((WIDTH_APP-button_width)/2), 25, 70, 30, 2, true);
			MAIN.register_button(Math.round((WIDTH_APP-button_width)/2), 25, 70, 30, PLACE, function(){
				if(FS==true)
					fullscreen('canvas_area');
				MAIN.quit_game();
				});
				
			canvas.fillStyle = "#ffffff";
			canvas.font = "Bold 13px Helvetica";
			canvas.fillText("Quit", Math.round((WIDTH_APP-button_width)/2)+20, 45);
			
			//save button position
			score_button_pos['x'] = Math.round((WIDTH_APP-button_width)/2);
			score_button_pos['y'] = 25;
			score_button_pos['width'] = 70;
			score_button_pos['height'] = 30;
			
			//title
			nation_winner = UNITS.get_nation_by_team(win_team);
			
			if(win_team === false){
				canvas.fillStyle = "#0669ff";
				var text = "Tie - both commanders left the battle...";
				}
			else if(win_team == MY_TANK.team){
				canvas.fillStyle = "#056705";
				var text = "You won the game !!!";
				}
			else if(win_team != MY_TANK.team){
				canvas.fillStyle = "#b12525";
				var text = COUNTRIES[nation_winner].name + " won the game, you lost";
				}
			canvas.font = "bold 20px Helvetica";
			canvas.fillText(text, 110, 45);
			}
		else{							//scores in game
			//background in live stats
			canvas.strokeStyle = "#000000";
			canvas.fillStyle = "rgba(255, 255, 255, 0.7)";
			HELPER.roundRect(canvas, 10, 10, WIDTH_SCROLL-20, HEIGHT_SCROLL-20, 0, true);
			}
		
		canvas.font = "bold 12px Helvetica";
		
		//show headers
		if(game_mode == 'single_quick' || game_mode == 'multi_quick'){
			canvas.fillStyle = "#056705";
			canvas.fillText("Type", Math.round((WIDTH_APP-button_width)/2)+200, text_y);
			
			canvas.fillStyle = "#056705";
			canvas.fillText("Kills", Math.round((WIDTH_APP-button_width)/2)+300, text_y);
			
			canvas.fillStyle = "#9c0309";
			canvas.fillText("Deaths", Math.round((WIDTH_APP-button_width)/2)+350, text_y);
			
			canvas.fillStyle = "#056705";
			canvas.fillText("Towers", Math.round((WIDTH_APP-button_width)/2)+400, text_y);
			
			canvas.fillStyle = "#056705";
			canvas.fillText("Damage", Math.round((WIDTH_APP-button_width)/2)+450, text_y-15);
			canvas.fillText("done", Math.round((WIDTH_APP-button_width)/2)+450, text_y);
			
			canvas.fillStyle = "#b12525";
			canvas.fillText("Damage", Math.round((WIDTH_APP-button_width)/2)+500, text_y-15);
			canvas.fillText("received", Math.round((WIDTH_APP-button_width)/2)+500, text_y);
			
			canvas.fillStyle = "#d06a07";
			canvas.fillText("Level", Math.round((WIDTH_APP-button_width)/2)+600, text_y);
			
			canvas.fillStyle = "#ff3405";
			canvas.fillText("Score", Math.round((WIDTH_APP-button_width)/2)+650, text_y);
			}
		else{
			canvas.fillStyle = "#056705";
			canvas.fillText("Nation", Math.round((WIDTH_APP-button_width)/2)+150, text_y);
			
			canvas.fillStyle = "#056705";
			canvas.fillText("HE-3", Math.round((WIDTH_APP-button_width)/2)+300, text_y);
			
			canvas.fillStyle = "#056705";
			canvas.fillText("Units", Math.round((WIDTH_APP-button_width)/2)+400, text_y);
			
			canvas.fillStyle = "#056705";
			canvas.fillText("Kills", Math.round((WIDTH_APP-button_width)/2)+500, text_y);
			
			canvas.fillStyle = "#056705";
			canvas.fillText("Damage", Math.round((WIDTH_APP-button_width)/2)+600, text_y-15);
			canvas.fillText("done", Math.round((WIDTH_APP-button_width)/2)+600, text_y);
			}
		
		//sort
		if(live==false)
			TANKS.sort(function(a,b) { return parseFloat(b.score) - parseFloat(a.score); } );
		
		//show values
		if(game_mode == 'single_quick' || game_mode == 'multi_quick'){
			var j=1;
			for (var i in TANKS){
				if(TYPES[TANKS[i].type].type == 'tank' || (DEBUG == true && TANKS[i].data.type != 'building')){
					//background
					canvas.strokeStyle = "#000000";
					if(TANKS[i].team == 'R')
						canvas.fillStyle = "#ffaaaa";
					else
						canvas.fillStyle = "#b9b9ff";
					HELPER.roundRect(canvas, Math.round((WIDTH_SCROLL-button_width)/2), top_margin+(button_height+buttons_gap)*j, button_width, button_height, 0, true);
					
					var text_y = top_margin + (button_height+buttons_gap)*j + Math.round((button_height+letter_height)/2);
					if(TANKS[i].name == name)
						canvas.font = "bold 12px Helvetica";
					else
						canvas.font = "normal 12px Helvetica";
					
					//#
					canvas.fillStyle = "#6b6b6e";
					canvas.fillText(j, Math.round((WIDTH_APP-button_width)/2)+10, text_y);
					
					//flag
					DRAW.draw_image(canvas, COUNTRIES[TANKS[i].nation].file, 
						Math.round((WIDTH_SCROLL-button_width)/2)+30, 
						top_margin+(button_height+buttons_gap)*j+flag_space);
			
					//name
					canvas.fillStyle = "#000000";
					var name_tmp = TANKS[i].name;
					if(name_tmp != undefined && name_tmp.length>33)
						name_tmp = name_tmp.substr(0,33)
					if(game_mode == 'multi_quick' || game_mode == 'multi_craft'){
						room = ROOM.get_room_by_id(opened_room_id);
						if(room.host == TANKS[i].name)
							name_tmp = name_tmp+"*";
						}
					canvas.fillText(name_tmp, Math.round((WIDTH_APP-button_width)/2)+50, text_y);
					
					//id
					if(DEBUG == true){
						canvas.fillStyle = "#555555";
						canvas.font = "Normal 11px Helvetica";
						var value = TANKS[i].id;
						canvas.fillText(value, Math.round((WIDTH_APP-button_width)/2)+110, text_y);
						}
					
					//type
					canvas.fillStyle = "#000000";
					canvas.font = "bold 12px Helvetica";
					canvas.fillText(TYPES[TANKS[i].type].name, Math.round((WIDTH_APP-button_width)/2)+200, text_y);
					
					//kills
					canvas.font = "bold 12px Helvetica";
					canvas.fillStyle = "#056705";
					var kills = TANKS[i].kills;
					canvas.fillText(kills, Math.round((WIDTH_APP-button_width)/2)+300, text_y);
					
					//deaths
					canvas.fillStyle = "#9c0309";
					var deaths = TANKS[i].deaths;
					canvas.fillText(deaths, Math.round((WIDTH_APP-button_width)/2)+350, text_y);
					
					//towers
					canvas.fillStyle = "#056705";
					var towers = 0;
					if(TANKS[i].towers != undefined)
						towers = TANKS[i].towers;
					else
						towers = 0;
					towers = Math.round(towers*10)/10;
					canvas.fillText(towers, Math.round((WIDTH_APP-button_width)/2)+400, text_y);
					
					//damage done
					canvas.fillStyle = "#056705";
					var value = TANKS[i].damage_done;
					if(value>1000) value = Math.floor(value/100)/10+"k";
					canvas.fillText(value, Math.round((WIDTH_APP-button_width)/2)+450, text_y);	
					
					//damage received
					canvas.fillStyle = "#b12525";
					var value = TANKS[i].damage_received;
					if(value>1000) value = Math.floor(value/100)/10+"k";
					canvas.fillText(value, Math.round((WIDTH_APP-button_width)/2)+500, text_y);
					
					//level
					canvas.fillStyle = "#d06a07";
					canvas.fillText(TANKS[i].level, Math.round((WIDTH_APP-button_width)/2)+600, text_y);
					
					//score
					canvas.fillStyle = "#ff3405";
					var score = TANKS[i].score;
					canvas.fillText(Math.round(score), Math.round((WIDTH_APP-button_width)/2)+650, text_y);
					
					j++;
					}
				}
			}
		else{
			var j = 1;
			top_margin = 50;
			flag_space = 10;
			if(game_mode == 'multi_craft')
				var room = ROOM.get_room_by_id(opened_room_id);
			for (var i in COUNTRIES){
				var nation = COUNTRIES[i].file;
				
				//validate
				var found = false;
				for(var t in TANKS){
					if(TANKS[t].nation == nation) 
					found = true;
					}
				if(found == false) continue;
				
				//background
				canvas.strokeStyle = "#000000";
				canvas.fillStyle = "#8FC74C";
				HELPER.roundRect(canvas, Math.round((WIDTH_SCROLL-button_width)/2), top_margin+(button_height+buttons_gap)*j, button_width, button_height, 0, true);
				var text_y = top_margin + (button_height+buttons_gap)*j + Math.round((button_height+letter_height)/2);
				if(MY_TANK.nation == COUNTRIES[i].file)
					canvas.font = "bold 12px Helvetica";
				else
					canvas.font = "normal 12px Helvetica";
				
				//#
				canvas.fillStyle = "#6b6b6e";
				canvas.fillText(j, Math.round((WIDTH_APP-button_width)/2)+10, text_y);
				
				//flag
				DRAW.draw_image(canvas, COUNTRIES[i].file, 
					Math.round((WIDTH_SCROLL-button_width)/2)+30, 
					top_margin+(button_height+buttons_gap)*j+flag_space);
				
				//name
				canvas.fillStyle = "#000000";
				var value = '-';
				if(nation == MY_TANK.nation)
					value = name;
				else if(game_mode == 'multi_craft'){
					for(var p in room.players){
						if(room.players[p].nation == nation){	//if not me
							value = room.players[p].name;
							break;
							}
						}
					}
				
				canvas.fillText(value, Math.round((WIDTH_APP-button_width)/2)+50, text_y);
				
				//nation
				canvas.fillStyle = "#000000";
				canvas.font = "normal 12px Helvetica";
				canvas.fillText(COUNTRIES[i].name, Math.round((WIDTH_APP-button_width)/2)+150, text_y);
				
				//he-3
				canvas.fillStyle = "#000000";
				canvas.font = "bold 12px Helvetica";
				var value = UNITS.player_data[nation].total_he3;
				if(live==true && MY_TANK.nation != nation && game_mode == 'multi_craft')
					value = '?';
				canvas.fillText(value, Math.round((WIDTH_APP-button_width)/2)+300, text_y);
				
				//units
				canvas.fillStyle = "#000000";
				var value = UNITS.player_data[nation].units;
				if(live==true && MY_TANK.nation != nation)
					value = '?';
				canvas.fillText(value, Math.round((WIDTH_APP-button_width)/2)+400, text_y);
				
				//kills
				canvas.fillStyle = "#000000";
				canvas.fillText(UNITS.player_data[nation].kills, Math.round((WIDTH_APP-button_width)/2)+500, text_y);
				
				//damage done
				canvas.fillStyle = "#000000";
				var value = UNITS.player_data[nation].total_damage;
				if(value>1000) value = Math.floor(value/100)/10+"k";
				canvas.fillText(value, Math.round((WIDTH_APP-button_width)/2)+600, text_y);
				j++;
				}
			}
		
		if(live==false)
			pre_draw_functions = [];
		};
	//message on screen in game
	this.draw_message = function(this_convas, message){
		this_convas.save();
		this_convas.shadowOffsetX = 0;
		this_convas.shadowOffsetY = 0;
		this_convas.shadowBlur = 4;
		this_convas.shadowColor = "#ffffff";
		this_convas.fillStyle = "#b12525";
		this_convas.font = "bold 18px Helvetica";
		this_convas.fillText(message, Math.round(WIDTH_APP/2)+50, HEIGHT_SCROLL-20);
		this_convas.restore();
		};
	//show FPS
	this.update_fps = function(){
		try{
			var fps_string = Math.round(FPS*10)/10;
			parent.document.getElementById("fps").innerHTML = fps_string;	
			}catch(error){}
		};
	this.draw_mode_selection = function(y, type, params){
		padding = 15;
		height = 50;
		width = round((WIDTH_APP - padding*3)/2);
		x = padding;
		small_line_height = 10;
		
		//craft mode
		active = false;
		if(game_mode == 'single_craft' || game_mode == 'multi_craft')
			active = true;
		canvas_backround.strokeStyle = "#196119";
		canvas_backround.fillStyle = "#dbd9da";		
		if(active == true)
			canvas_backround.fillStyle = '#69a126';	//selected
		HELPER.roundRect(canvas_backround, x, y, width, height, 5, true);
		MAIN.register_button(x, y, width, height, PLACE, function(xx, yy){
			if(type == 'single'){
				game_mode = 'single_craft';
				DRAW.draw_tank_select_screen();
				}
			else if(type == 'multi'){
				game_mode = 'multi_craft';
				ROOM.draw_create_room(params[0], params[1], params[2], params[3], params[4], params[5]);
				}
			});
		canvas_backround.fillStyle = "#337333";
		if(active == true)
			canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Bold 14px Helvetica";
		text = "Full mode";
		text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, x+(width-text_width)/2, y+(height + HELPER.font_pixel_to_height(13))/2);
		var descriptions = ['Battle of resources', 'Full version', 'Challenge', 'Slow'];
		canvas_backround.font = "Normal 10px Helvetica";
	
		for(var i in descriptions){
			text_width = canvas_backround.measureText(descriptions[i]).width;
			canvas_backround.fillText(descriptions[i], x+width-padding-text_width, y + HELPER.font_pixel_to_height(11)+5+i*small_line_height);
			}
		x = x + width + padding;
		
		//quick mode
		active = false;
		if(game_mode == 'single_quick' || game_mode == 'multi_quick')
			active = true;
		canvas_backround.strokeStyle = "#196119";
		canvas_backround.fillStyle = "#dbd9da";		
		if(active == true)
			canvas_backround.fillStyle = '#69a126';	//selected
		HELPER.roundRect(canvas_backround, x, y, width, height, 5, true);
		MAIN.register_button(x, y, width, height, PLACE, function(xx, yy){
			if(type == 'single'){
				game_mode = 'single_quick';
				DRAW.draw_tank_select_screen();
				}
			else if(type == 'multi'){
				game_mode = 'multi_quick';
				ROOM.draw_create_room(params[0], params[1], params[2], params[3], params[4], params[5]);
				}
			});
		canvas_backround.fillStyle = "#337333";
		if(active == true)
			canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Bold 14px Helvetica";
		text = "Quick mode";
		text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, x+(width-text_width)/2, y+(height + HELPER.font_pixel_to_height(13))/2);
		var descriptions = ['Single tank control', 'Limited edition', 'Quick', 'Easy'];
		canvas_backround.font = "Normal 10px Helvetica";
		for(var i in descriptions){
			text_width = canvas_backround.measureText(descriptions[i]).width;
			canvas_backround.fillText(descriptions[i], x+width-padding-text_width, y + HELPER.font_pixel_to_height(11)+5+i*small_line_height);
			}
		
		return y + height + 5;
		};
	//selecting tank window
	this.draw_tank_select_screen = function(selected_tank, selected_nation){
		PLACE = 'select';
		MAIN.unregister_buttons(PLACE);
		MAIN.dynamic_title();
		canvas_map.clearRect(0, 0, WIDTH_MAP, HEIGHT_MAP); 
		canvas_fog.clearRect(0, 0, WIDTH_MAP, HEIGHT_MAP);
		canvas_map_sight.clearRect(0, 0, WIDTH_SCROLL, HEIGHT_SCROLL);
		document.getElementById("chat_box").style.display = 'none';
		MP.room_controller();
		
		if(game_mode == 'multi_craft') return true;
		
		var y = 10;
		var gap = 8;
		var info_block_height = 100;
		
		if(selected_tank == undefined){
			if(game_mode == 'single_quick' || game_mode == 'single_craft'){
				selected_tank = 0;
				my_tank_nr = selected_tank;
				}
			else{
				//find me
				room = ROOM.get_room_by_id(opened_room_id);
				selected_tank = 0;
				for(var p in room.players){
					if(room.players[p].name == name && room.players[p].tank != undefined){
						selected_tank = room.players[p].tank;
						break;
						}
					}
				}
			}
		if(game_mode == 'multi_quick' || game_mode == 'multi_craft'){
			room = ROOM.get_room_by_id(opened_room_id);
			var my_team;
			for(var t in room.players){
				if(room.players[t].name == name)
					my_team=room.players[t].team;
				}
			my_nation = UNITS.get_nation_by_team(my_team);
			}
		else{
			if(selected_nation != undefined)
				my_nation = selected_nation;
			if(my_nation == undefined)
				my_nation = 'us';
			}
		
		//background
		canvas_backround.drawImage(MAIN.IMAGE_BACK, 0, 0, 700, 500, 0, 0, WIDTH_APP, HEIGHT_APP-27);
		
		if(game_mode == 'single_quick' || game_mode == 'single_craft'){	
			y = y + DRAW.draw_mode_selection(y, 'single');	//game mode
			}
			
		//mini maps
		if(game_mode == 'single_quick' || game_mode == 'single_craft'){
			MAP.show_maps_selection(canvas_backround, y, true);
			y = y + 81+30;
			}
			
		//nations	
		if(game_mode == 'single_quick' || game_mode == 'single_craft'){
			preview_x = 50;
			preview_y = 40;
			x = WIDTH_APP - 15 - HELPER.size(COUNTRIES) * (preview_x+gap) + gap;
			j=0;
			for(var i in COUNTRIES){
				//reset background
				var back_color = '';
				if(my_nation == i)
					back_color = "#8fc74c"; //selected
				else
					back_color = "#dbd9da";
				canvas_backround.fillStyle = back_color;
				canvas_backround.strokeStyle = "#196119";
				HELPER.roundRect(canvas_backround, x+j*(preview_x+gap), y, preview_x, preview_y, 5, true);
				
				//logo
				var flag_size = IMAGES_SETTINGS.general[COUNTRIES[i].file];
				var pos1 = x+j*(preview_x+gap) + round((preview_x-flag_size.w)/2);
				var pos2 = y + round((preview_y-flag_size.h)/2);
				DRAW.draw_image(canvas_backround, COUNTRIES[i].file, pos1, pos2);
				
				//register button
				MAIN.register_button(x+j*(preview_x+gap)+1, y+1, preview_x, preview_y, PLACE, function(mouseX, mouseY, index){
					DRAW.draw_tank_select_screen(index[0], index[1]);
					}, [selected_tank, COUNTRIES[i].file]);
				j++;
				}
			y = y + preview_y+15;
			}
		
		//show all possible tanks
		var info_left = 7;
		if(game_mode == 'single_quick' || game_mode == 'multi_quick'){
			j = 0;
		 	preview_x = 90;
			preview_y = 80;
			for(var i in TYPES){
				if(TYPES[i].type != 'tank') continue;
				if(my_nation == undefined)
					my_nation = 'us';
				var locked = false;
				if(UNITS.check_nation_tank(TYPES[i].name, my_nation)==false){
					if(selected_tank == i){
						my_tank_nr = 0;
						DRAW.draw_tank_select_screen(my_tank_nr);
						return false;
						}
					//locked = true;		
					continue;
					}
				
				if(locked==true && selected_tank == i){
					selected_tank++;
					my_tank_nr = selected_tank;
					if(TYPES[selected_tank].type != 'tank'){
						selected_tank = 0;
						my_tank_nr = selected_tank;
						DRAW.draw_tank_select_screen(selected_tank);
						return false;
						}
					}
				
				if(15+j*(preview_x+gap)+ preview_x > WIDTH_APP){
					y = y + preview_y+gap;
					j = 0;
					}
		
				//reset background
				var back_color = '';
				if(selected_tank != undefined && selected_tank == i)
					back_color = "#8fc74c"; //selected
				else
					back_color = "#dbd9da";
				canvas_backround.fillStyle = back_color;
				canvas_backround.strokeStyle = "#196119";
				HELPER.roundRect(canvas_backround, 15+j*(preview_x+gap), y, preview_x, preview_y, 5, true);
				
				//logo
				var pos1 = 15+j*(preview_x+gap);
				var pos2 = y;
				var pos_left = pos1 + (preview_x-TYPES[i].size[1])/2;
				var pos_top = pos2 + (preview_y-TYPES[i].size[2])/2;
				if(locked==false)
					UNITS.draw_tank_clone(i, pos_left, pos_top, 0, 1, canvas_backround);
				else
					DRAW.draw_image(canvas_backround, 'lock', pos1+preview_x-14-5, pos2+preview_y-20-5);
			
				//if bonus
				room = ROOM.get_room_by_id(opened_room_id);
				if((game_mode == 'multi_quick' || game_mode == 'multi_craft') && room.settings[0]=='normal' && TYPES[i].bonus != undefined)
					DRAW.draw_image(canvas_backround, 'lock', pos1+preview_x-14-5, pos2+preview_y-20-5);
		
				//register button
				if(locked==false){
					MAIN.register_button(15+j*(preview_x+gap)+1, y+1, preview_x, preview_y, PLACE, function(mouseX, mouseY, index){
						if(game_mode == 'multi_quick' || game_mode == 'multi_craft'){
							room = ROOM.get_room_by_id(opened_room_id);
							if(room.settings[0]=='normal'){
								if(TYPES[index].bonus != undefined){
									return false;
									}
								else{
									MP.register_tank_action('change_tank', opened_room_id, name, index, false);
									return false;
									}
								}
							else
								return false;
							}
						my_tank_nr = index;
						DRAW.draw_tank_select_screen(index);
						}, i);
					}
				j++;
				}
			DRAW.last_selected = selected_tank;
			y = y + preview_y+10;
		
			//tank info block
			info_left = 15;
			canvas_backround.fillStyle = "#ffffff";
			canvas_backround.strokeStyle = "#196119";
			HELPER.roundRect(canvas_backround, info_left, y, 585, info_block_height, 5, true);
			if(selected_tank != undefined){
				var pos1 = info_left+10;
				var pos2 = y+((info_block_height-preview_y)/2);
				DRAW.draw_image(canvas_backround, TYPES[selected_tank].name, pos1, pos2);
				
				canvas_backround.font = "bold 18px Verdana";
				canvas_backround.fillStyle = "#196119";
				canvas_backround.fillText(TYPES[selected_tank].name, info_left+preview_x+40, y+25);
				
				//description
				var height_space = 13;
				for(var d in TYPES[selected_tank].description){
					canvas_backround.font = "bold 11px Verdana";
					canvas_backround.fillStyle = "#69a126";
					canvas_backround.fillText(TYPES[selected_tank].description[d], info_left+preview_x+40, y+50+d*height_space);
					}
				info_left = info_left + 585 + 5;
				}
			y = y + info_block_height+10;
			}
		
		//teams
		if(game_mode == 'multi_quick' || game_mode == 'multi_craft'){
			room = ROOM.get_room_by_id(opened_room_id);
			players_n = room.players.length;	
			var ICON_WIDTH = 55;
			//find my team
			var my_team;
			for(var t in room.players){
				if(room.players[t].name == name)
					my_team = room.players[t].team;
				}
			//list
			var teams = ['B', 'R'];
			for(var t in teams){
				j = 0;
				canvas_backround.strokeStyle = "#000000";
				if(teams[t]==my_team)
					canvas_backround.fillStyle = "#8fc74c";
				else
					canvas_backround.fillStyle = "#ffffff";
				HELPER.roundRect(canvas_backround, 15+1, y+1, 120, ICON_WIDTH, 2, true);
				
				//flag
				nation_tmp = UNITS.get_nation_by_team(teams[t]);
				DRAW.draw_image(canvas_backround, nation_tmp, 15+10, y+1+round((ICON_WIDTH-9)/2));
				
				//text
				if(teams[t]==my_team)
					text = "Your team";	
				else
					text = "Your enemies";
				canvas_backround.fillStyle = "#000000";
				canvas_backround.font = "Bold 12px Arial";
				canvas_backround.fillText(text, 20+15+10, y+1+round((ICON_WIDTH)/2)+4);
				
				//players
				for(var p in room.players){
					if(room.players[p].team == teams[t]){
						//background
						canvas_backround.strokeStyle = "#000000";
						var back_color;
						if(room.players[p].name==name)
							back_color = "#8fc74c";	//me
						else
							back_color = "#bebebe";
						canvas_backround.fillStyle = back_color;
						HELPER.roundRect(canvas_backround, 122+gap+15+j*(ICON_WIDTH+2+gap)+1, y+1, ICON_WIDTH, ICON_WIDTH, 2, true);
						
						if(room.players[p].tank == undefined){
							//room.settings[0] = normal, mirror, random
							room.players[p].tank = 0;
							}
						if(room.players[p].name==name && selected_tank != undefined)
							room.players[p].tank = selected_tank;
						
						//icon	
						tank_i = room.players[p].tank;
						src = '../img/tanks/'+TYPES[tank_i].name+'/'+TYPES[tank_i].preview;
						var pos1 = 122+gap+15+j*(ICON_WIDTH+2+gap);
						var pos2 = y;
						DRAW.draw_image(canvas_backround, TYPES[tank_i].name, 
							pos1, pos2, ICON_WIDTH, ICON_WIDTH,
							0, 0, 90, 90);
						j++;
						}
					}
				y = y + ICON_WIDTH+2+5;
				}
			}
			
		//time left line
		if(game_mode == 'multi_quick' || game_mode == 'multi_craft'){
			red_line_y = y+10;
			if(MAIN.starting_timer==-1)
				MAIN.starting_timer = START_GAME_COUNT;
			DRAW.draw_timer_graph();
			}
		else{
			//start button
			width = 150;
			height = 40;
			canvas_backround.strokeStyle = "#000000";
			canvas_backround.fillStyle = "#69a126";
			HELPER.roundRect(canvas_backround, 15, y, width, height, 5, true);
			MAIN.register_button(15, y, width, height, PLACE, function(xx, yy){
				MAIN.start_game(level, 'R');
				});
			canvas_backround.fillStyle = "#ffffff";
			canvas_backround.font = "Bold 17px Helvetica";
			text = "Start";
			text_width = canvas_backround.measureText(text).width;
			canvas_backround.fillText(text, 15+(width-text_width)/2, y+(height + HELPER.font_pixel_to_height(13))/2);
			}	
		};
	this.draw_timer_graph = function(){
		graph_width=WIDTH_APP-30;
		graph_height=40;
		
		//background
		canvas_backround.drawImage(MAIN.IMAGE_BACK, 15-2, red_line_y-2, graph_width+4, graph_height+4, 15-2, red_line_y-2, graph_width+4, graph_height+4);
		
		//red block
		canvas_backround.strokeStyle = "#c10000";
		canvas_backround.fillStyle = "#c10000";
		var max_s = START_GAME_COUNT;
		top_x = 15+graph_width*(max_s - MAIN.starting_timer)/max_s;
		width = graph_width-graph_width*(max_s - MAIN.starting_timer)/max_s;
		HELPER.roundRect(canvas_backround, 15, red_line_y, width, graph_height, 0, true);
		
		//text
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Bold 40px Arial";
		text = MAIN.starting_timer;
		if(text>9)
			canvas_backround.fillText(text, 25, red_line_y+graph_height-5);
		else
			canvas_backround.fillText(text, 25, red_line_y+graph_height-5);
		};
	//show preload progress line
	this.update_preload = function(images_loaded){
		if(preloaded==true) return false;
		preload_left = preload_left - images_loaded;
		
		//reset
		canvas_backround.strokeStyle = "#dbd9da";
		canvas_backround.fillStyle = "#dbd9da";
		HELPER.roundRect(canvas_backround, 0, HEIGHT_APP-24, WIDTH_APP, 23, 0, true);
		
		if(preload_left==0){
			preloaded=true;
			DRAW.intro();
			return false;
			}
		
		//fill
		canvas_backround.strokeStyle = "#0c6934";
		canvas_backround.fillStyle = "#ff0000";
		var line_width = round((WIDTH_APP-2)*(preload_total-preload_left)/preload_total);
		HELPER.roundRect(canvas_backround, 1, HEIGHT_APP-24, line_width, 23, 0, true);
		
		//add text
		text = "Loading: "+Math.floor((preload_total-preload_left)*100/preload_total)+"%";
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "Normal 12px Arial";
		canvas_backround.fillText(text, 10, HEIGHT_APP-8);
		};
	//shows chat lines
	this.show_chat = function(){
		if(PLACE == 'room' || PLACE == 'rooms') return false;
		var gap = 20;
		var bottom = HEIGHT_APP - INFO_HEIGHT - STATUS_HEIGHT - 10;
	
		canvas = canvas_main;
		
		canvas.font = "bold 13px Helvetica";
		for(var i = CHAT_LINES.length - 1; i >= 0; i--){
			var text;
			if(CHAT_LINES[i].author===false)
				text = CHAT_LINES[i].text;
			else
				text = CHAT_LINES[i].author+": "+CHAT_LINES[i].text;
			var text_limit = 100;
			if(text.length > text_limit)
				text = text.substring(0, text_limit);
			if(CHAT_LINES[i].shift==1 && PLACE == 'game' && CHAT_LINES[i].team == MY_TANK.team && CHAT_LINES[i].author !== false)
				text = "[Team] "+text;
				
			//text color
			if(CHAT_LINES[i].author===false)		canvas.fillStyle = "#222222";	//system chat
			else if(CHAT_LINES[i].team == 'R')		canvas.fillStyle = "#8f0c12";	//team red
			else if(CHAT_LINES[i].team == 'B')		canvas.fillStyle = "#0000ff";	//team blue
			else						canvas.fillStyle = "#222222";	//default color
			
			//shift
			if(CHAT_LINES[i].shift==1 && PLACE != 'game'){
				canvas.font = "bold 13px Helvetica";
				canvas.fillStyle = "#ff0000";
				}
			
			//show it
			canvas.save();
			canvas.shadowOffsetX = 0;
			canvas.shadowOffsetY = 0;
			canvas.shadowBlur = 4;
			canvas.shadowColor = "#ffffff";
			canvas.fillText(text, 10,bottom-i*gap);
			canvas.restore();
			}
		};
	//show chat in room - this is textbox with scroll ability
	this.update_scrolling_chat = function(CHAT){
		var chat_container = document.getElementById("chat_box");
	
		var new_content = document.createElement("div");
		if(CHAT.shift==1)
			new_content.innerHTML = "<span style=\"font-weight:bold;color:#0000ff;\">"+CHAT.author+"</span>: "+CHAT.text;
		else
			new_content.innerHTML = "<b>"+CHAT.author+"</b>: "+CHAT.text;
		chat_container.appendChild(new_content);
		
		//scroll
		chat_container.scrollTop = chat_container.scrollHeight;
		};
	//calculate body and turret rotation
	this.body_rotation = function(obj, str, speed, rot, time_diff){
		if(obj.stun != undefined)	return false; //stun
		if(obj.data.speed == 0 && TYPES[obj.type].type == 'tank')	return false; //0 speed
		speed = speed * 100 * time_diff/1000;	
		
		if (obj[str] > 360) obj[str] = obj[str] - 360;
		if (obj[str] < 0) obj[str] = obj[str] + 360;
		
		if (obj[str] - 180 > rot) rot += 360;
		if (obj[str] + 180 < rot) rot -= 360;
		if (obj[str] - rot > speed)
			obj[str] -= speed;
		else if(obj[str] - rot < -speed)
			obj[str] += speed;
		else{
			obj[str] = rot;
			return true;
			}
		return false;
		};
	this.draw_image = function(canvas, name, x, y, max_w, max_h, offset_x, offset_y, clip_w, clip_h){
		x = round(x);
		y = round(y);
		if(offset_x == undefined) offset_x = 0;
		if(offset_y == undefined) offset_y = 0;	
			
		//check general images
		if(IMAGES_SETTINGS.general[name] != undefined){
			if(max_w == undefined)	max_w = IMAGES_SETTINGS.general[name].w;
			if(max_h == undefined)	max_h = IMAGES_SETTINGS.general[name].h;
			if(clip_w == undefined)	clip_w = max_w;
			if(clip_h == undefined)	clip_h = max_h;
			canvas.drawImage(MAIN.IMAGES_GENERAL,
				IMAGES_SETTINGS.general[name].x+offset_x, IMAGES_SETTINGS.general[name].y+offset_y, clip_w, clip_h, 
				x, y, max_w, max_h); 
			return true;
			}
		
		//chec bullets
		if(IMAGES_SETTINGS.bullets[name] != undefined){
			if(max_w == undefined)	max_w = IMAGES_SETTINGS.bullets[name].w;
			if(max_h == undefined)	max_h = IMAGES_SETTINGS.bullets[name].h;
			if(clip_w == undefined)	clip_w = max_w;
			if(clip_h == undefined)	clip_h = max_h;
			canvas.drawImage(MAIN.IMAGES_BULLETS, 
				IMAGES_SETTINGS.bullets[name].x+offset_x, IMAGES_SETTINGS.bullets[name].y+offset_y, clip_w, clip_h, 
				x, y, max_w, max_h); 
			return true;	
			}
		
		//check elements
		if(IMAGES_SETTINGS.elements[name] != undefined){
			if(max_w == undefined)	max_w = IMAGES_SETTINGS.elements[name].w;
			if(max_h == undefined)	max_h = IMAGES_SETTINGS.elements[name].h;
			if(clip_w == undefined)	clip_w = max_w;
			if(clip_h == undefined)	clip_h = max_h;
			var element = MAP.get_element_by_name(name);
			var alpha = element.alpha;
			if(PLACE == 'library') alpha = 1;
			if(alpha != 1){
				canvas.save();
				if(alpha < canvas.globalAlpha)
					canvas.globalAlpha = alpha;
				}
			canvas.drawImage(MAIN.IMAGES_ELEMENTS, 
				IMAGES_SETTINGS.elements[name].x+offset_x, IMAGES_SETTINGS.elements[name].y+offset_y, clip_w, clip_h, 
				x, y, max_w, max_h); 
			if(alpha != 1)
				canvas.restore();
			return true;
			}
			
		//check tanks
		if(IMAGES_SETTINGS.tanks[name] != undefined){
			if(max_w == undefined)	max_w = IMAGES_SETTINGS.tanks[name].w;
			if(max_h == undefined)	max_h = IMAGES_SETTINGS.tanks[name].h;
			if(clip_w == undefined)	clip_w = max_w;
			if(clip_h == undefined)	clip_h = max_h;
			canvas.drawImage(MAIN.IMAGES_TANKS, 
				IMAGES_SETTINGS.tanks[name].x+offset_x, IMAGES_SETTINGS.tanks[name].y+offset_y, clip_w, clip_h, 
				x, y, max_w, max_h); 
			return true;
			}
		log('Error: can not find image "'+name+'".');
		};
	this.update_counter = function(user_response){
		START_GAME_COUNT_SINGLE = parseInt(user_response.number);
		if(START_GAME_COUNT_SINGLE < 1 || isNaN(START_GAME_COUNT_SINGLE)==true)		START_GAME_COUNT_SINGLE = 1;
		if(START_GAME_COUNT_SINGLE > 30)		START_GAME_COUNT_SINGLE = 30;
		DRAW.add_settings_buttons(canvas_backround, ["Player name: "+name, "Start game counter: "+START_GAME_COUNT_SINGLE, "Back"]);
		HELPER.setCookie("start_count", START_GAME_COUNT_SINGLE, 30);
		DRAW.draw_settings();
		};
	//show intro
	this.intro = function(force){
		PLACE = 'intro';
		var intro_w = 800;
		var intro_h = 500;
		DATA = [
			{image: '1.jpg', text: ["No more oil left on Earth..."],},
			{image: '2.jpg', text: ["But but researchers found huge amount of non-radioactive isotope",  "helium on the moon..."],},
			{image: '3.jpg', text: ["Helium-3 gives a chance to build ZPM", "which means unlimited energy..."],},
			{image: '4.jpg', text: ["Protect your base, push enemies away and save your country.", "Moon needs you!"],},
			];
		var text_gap = 20;
		
		if(intro_page+1 > DATA.length || (MAIN.intro_enabled == 0 && force == undefined)){
			PLACE = 'init';
			DRAW.add_first_screen_elements();
			return false;
			}
		
		//draw
		MAIN.IMAGES_INRO = new Image();	//chrome requires new image for using onload...
		MAIN.IMAGES_INRO.onload = function(){
			canvas_backround.drawImage(MAIN.IMAGES_INRO, 0, intro_h*intro_page, intro_w, intro_h, 0, 0, intro_w, intro_h);
			//draw text
			var text = DATA[intro_page].text[0];
			canvas_backround.font = "Bold 21px Arial";
			canvas_backround.fillStyle = '#ffffff';
			canvas_backround.fillText(text, 30, HEIGHT_APP-STATUS_HEIGHT-40);
			//more text
			if(DATA[intro_page].text[1] != undefined){
				var text = DATA[intro_page].text[1];
				canvas_backround.font = "Bold 21px Arial";
				canvas_backround.strokeStyle = '#ffffff';
				canvas_backround.fillText(text, 30, HEIGHT_APP-STATUS_HEIGHT-40+text_gap);
				}
			//draw skip
			canvas_backround.font = "Bold 22px Arial";
			canvas_backround.strokeStyle = '#ffffff';
			canvas_backround.fillText("Skip", WIDTH_APP-60, HEIGHT_APP-STATUS_HEIGHT-15);
			};
		MAIN.IMAGES_INRO.src = '../img/intro.jpg?'+VERSION;
		
		if(intro_page==0){
			//register skip button
			MAIN.register_button(WIDTH_APP-70, HEIGHT_APP-STATUS_HEIGHT-45, 70, 45, PLACE, function(){
				HELPER.setCookie("nointro", 1, 30);
				intro_page=0;
				PLACE = 'init';
				DRAW.add_first_screen_elements();
				});
			//register next slide
			MAIN.register_button(0, 0, WIDTH_APP, HEIGHT_APP-STATUS_HEIGHT, PLACE, function(){
				intro_page++;
				DRAW.intro(force);
				});
			}
		};
	}
