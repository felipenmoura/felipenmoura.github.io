var INFOBAR = new INFOBAR_CLASS();

function INFOBAR_CLASS(){	
	this.ABILITIES_POS = []; 
	this.ability_hover_id = '-1';
	this.ability_hover_text = '';
	var SKILL_BUTTON = 55;			//skill button width and height
	
	//draw infobar
	this.draw_infobar = function(first){
		//image
		if(first != undefined){
			//background background
			canvas_backround.fillStyle = "#233012";
			canvas_backround.fillRect(0, status_y, WIDTH_APP, INFO_HEIGHT);
		
			DRAW.draw_image(canvas_backround, 'statusbar', status_x, status_y );
			}
		else{
			padding_left = MINI_MAP_PLACE[0]+MINI_MAP_PLACE[2];
			w_tmp = IMAGES_SETTINGS.general.statusbar.w;
			h_tmp = IMAGES_SETTINGS.general.statusbar.h;
			DRAW.draw_image(canvas_backround, 'statusbar', status_x+padding_left, status_y, w_tmp-padding_left-220, h_tmp,
				padding_left, 0, w_tmp-padding_left-220, h_tmp);
			}
		
		var icon_x = status_x+140;
		var ns = UNITS.get_selected_count(MY_TANK.team);
		var only_factory = true;
		for(var i in TANKS){
			if(TANKS[i].team != MY_TANK.team) continue;
			if(TANKS[i].selected == undefined) continue;
			if(TANKS[i].data.name == "Factory") continue;
			only_factory = false;
			break;
			}
		if(ns == 1 || only_factory == true){
			//tank icon
			if(TYPES[MY_TANK.type].preview != false)
				DRAW.draw_image(canvas_backround, TYPES[MY_TANK.type].name, icon_x, status_y+40, 100, 100);
				
			//tank name
			canvas_backround.fillStyle = "#a3ad16";
			canvas_backround.font = "bold 10px Verdana";
			var value = TYPES[MY_TANK.type].name.replace("_"," ");
			canvas_backround.fillText(value, icon_x-5, status_y+25);
			
			INFOBAR.redraw_tank_stats(true);
			}
		else{
			//nation name
			canvas_backround.fillStyle = "#a3ad16";
			canvas_backround.font = "bold 10px Verdana";
			var value = ns+" units";
			canvas_backround.fillText(value, icon_x-5, status_y+25);
			
			INFOBAR.draw_units_gui();
			}
			
		//abilities skills
		INFOBAR.draw_tank_abilities();		
		
		if(first != undefined){		
			for(var i=0; i < INFOBAR.ABILITIES_POS.length; i++){
				//register skill button
				MAIN.register_button(
					INFOBAR.ABILITIES_POS[i].x,
					INFOBAR.ABILITIES_POS[i].y,
					INFOBAR.ABILITIES_POS[i].width, INFOBAR.ABILITIES_POS[i].height, PLACE, function(xx, yy, i){
					UNITS.do_abilities(INFOBAR.ABILITIES_POS[i].nr, MY_TANK);
					}, i);
				}	
			STATUS.draw_status_bar();
			}
		};
	//redrwar tanks stats in status bar
	this.redraw_tank_stats = function(){
		status_y = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT;
		var left_x = status_x+255;
		var left_x_values = status_x+305;
		var gap = 19;
		var top_y = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT+40;
		
		//check
		var ns = UNITS.get_selected_count(MY_TANK.team);
		var only_factory = true;
		for(var i in TANKS){
			if(TANKS[i].team != MY_TANK.team) continue;
			if(TANKS[i].selected == undefined) continue;
			if(TANKS[i].data.name == "Factory") continue;
			only_factory = false;
			break;
			}
		
		if(ns > 1 && only_factory == false) return false;
		
		//commander mode - Factory
		if((game_mode == 'single_craft' || game_mode == 'multi_craft') && MY_TANK.constructing == undefined){
			if(TYPES[MY_TANK.type].name == 'Factory'){
				INFOBAR.draw_factory_gui();
				return false;
				}
			else if(TYPES[MY_TANK.type].name == 'Mechanic'){
				INFOBAR.draw_mechanic_gui();
				return false;
				}
			}
		//clear
		DRAW.draw_image(canvas_backround, 'statusbar', status_x+245, top_y-40+10, 330, 83,
			245, 10, 330, 83);
		
		if((game_mode == 'single_craft' || game_mode == 'multi_craft') && MY_TANK.selected == undefined){
			DRAW.draw_image(canvas_backround, 'statusbar', status_x, status_y);
			return false;
			}
		
		if(game_mode == 'single_quick' || game_mode == 'multi_quick'){	
			//sublevel clear
			var max_width = 85;
			canvas_backround.lineWidth = 2;
			canvas_backround.beginPath();
			canvas_backround.moveTo(status_x+130, status_y+36);
			canvas_backround.lineTo(status_x+130+max_width, status_y+36);
			canvas_backround.strokeStyle = '#2a4214';
			canvas_backround.stroke();
			//sublevel draw
			canvas_backround.beginPath();
			canvas_backround.moveTo(status_x+130, status_y+36);
			canvas_backround.lineTo(status_x+130+round(MY_TANK.sublevel*max_width/100), status_y+36);
			canvas_backround.strokeStyle = '#4a7c0d';
			canvas_backround.stroke();
			}
		if((game_mode == 'single_quick' || game_mode == 'multi_quick') || MY_TANK.level > 1){
			//level
			canvas_backround.fillStyle = "#182605";
			canvas_backround.fillRect(status_x+195, status_y+15, 23, 15);
			//draw
			var text = Math.floor(MY_TANK.level);
			canvas_backround.fillStyle = "#c10000";
			canvas_backround.font = "normal 18px Verdana";
			if(text>99)
				canvas_backround.font = "normal 11px Verdana";
			if(text>999)
				canvas_backround.font = "normal 8px Verdana";
			var text_length = canvas_backround.measureText(text).width;
			canvas_backround.fillText(text, status_x+218-text_length, status_y+28);
			}
		
		if(TYPES[MY_TANK.type].damage[0] != '0'){
			//damage
			canvas_backround.fillStyle = "#7b8a69";
			canvas_backround.font = "normal 10px Verdana";
			canvas_backround.fillText("Damage", left_x, top_y);
			//value
			canvas_backround.fillStyle = "#a3ad16";
			canvas_backround.font = "bold 10px Verdana";
			var damage_string = MY_TANK.data.damage[0] + MY_TANK.data.damage[1]*(MY_TANK.level-1);
			damage_string = UNITS.apply_buff(MY_TANK, 'damage', damage_string);
			damage_string = damage_string * (100+COUNTRIES[MY_TANK.nation].bonus.weapon)/100;
			damage_string = Math.floor(damage_string);
			canvas_backround.fillText(damage_string, left_x_values, top_y);
	
			//armor
			canvas_backround.fillStyle = "#7b8a69";
			canvas_backround.font = "normal 10px Verdana";
			canvas_backround.fillText("Armor", left_x, top_y+28);
			//value
			canvas_backround.fillStyle = "#a3ad16";
			canvas_backround.font = "bold 10px Verdana";
			var armor_text = MY_TANK.data.armor[0] + MY_TANK.data.armor[1]*(MY_TANK.level-1);
			if(MY_TANK > MY_TANK.data.armor[2])
				armor_text = MY_TANK.data.armor[2];
			armor_text = armor_text + COUNTRIES[MY_TANK.nation].bonus.armor;
			armor_text = UNITS.apply_buff(MY_TANK, 'shield', armor_text);
			if(armor_text > 100) armor_text = 100;
			if(armor_text < 0) armor_text = 0;
			armor_text = Math.floor(armor_text);
			canvas_backround.fillText(armor_text+"%", left_x_values, top_y+28);
			}
		
		left_x = status_x+370;
		left_x_values = status_x+414;
		
		if(TYPES[MY_TANK.type].range != '0'){
			//range
			canvas_backround.fillStyle = "#7b8a69";
			canvas_backround.font = "normal 10px Verdana";
			canvas_backround.fillText("Range", left_x, top_y);
			//value
			canvas_backround.fillStyle = "#a3ad16";
			canvas_backround.font = "bold 10px Verdana";
			canvas_backround.fillText(TYPES[MY_TANK.type].range+" m.", left_x_values, top_y);
			}
		
		if(TYPES[MY_TANK.type].speed != '0'){
			//speed
			canvas_backround.fillStyle = "#7b8a69";
			canvas_backround.font = "normal 10px Verdana";
			canvas_backround.fillText("Speed", left_x, top_y+28);
			//value
			canvas_backround.fillStyle = "#a3ad16";
			canvas_backround.font = "bold 10px Verdana";
			var speed_text = MY_TANK.data.speed;
			speed_text = UNITS.apply_buff(MY_TANK, 'speed', speed_text);
			speed_text = Math.floor(speed_text)+" km/h";
			canvas_backround.fillText(speed_text, left_x_values, top_y+28);
			}
		
		left_x = status_x+492;
		left_x_values = status_x+535;
		
		if(TYPES[MY_TANK.type].damage[0] != '0'){
			//kills
			canvas_backround.fillStyle = "#7b8a69";
			canvas_backround.font = "normal 10px Verdana";
			canvas_backround.fillText("Kills", left_x, top_y);
			//value
			canvas_backround.fillStyle = "#a3ad16";
			canvas_backround.font = "bold 10px Verdana";
			var text;
			text = MY_TANK.kills;
			canvas_backround.fillText(text, left_x_values, top_y);
			
			if(game_mode == 'multi_quick' || game_mode == 'multi_craft')
				death_padding = 20;
			else
				death_padding = 28;
			
			//deaths
			canvas_backround.fillStyle = "#7b8a69";
			canvas_backround.font = "normal 10px Verdana";
			canvas_backround.fillText("Deaths", left_x, top_y+death_padding);
			//value
			canvas_backround.fillStyle = "#a3ad16";
			canvas_backround.font = "bold 10px Verdana";
			var text = MY_TANK.deaths;
			canvas_backround.fillText(text, left_x_values, top_y+death_padding);
			
			//players
			if(game_mode == 'multi_quick' || game_mode == 'multi_craft'){
				canvas_backround.fillStyle = "#7b8a69";
				canvas_backround.font = "normal 10px Verdana";
				canvas_backround.fillText("Players", left_x, top_y+40);
				//value
				canvas_backround.fillStyle = "#a3ad16";
				canvas_backround.font = "bold 10px Verdana";
				room = ROOM.get_room_by_id(opened_room_id);
				p_n = 0;
				timeout_interval = 20;	//in seconds
				for(var p in room.players){
					if(room.players[p].ping + timeout_interval*1000 > Date.now())
						p_n++;	
					}
				var text = p_n+"/"+room.players_max;
				canvas_backround.fillText(text, left_x_values, top_y+40);
				}
			}
		
		//logo
		DRAW.draw_image(canvas_backround, 'logo_small', status_x+490, HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT+95);
		
		//life
		life_x = status_x+315;
		life_y = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT+100;
		life_width = 150;
		life_height = 15;
		//reset hp bar
		canvas_backround.fillStyle = "#770f10";
		canvas_backround.fillRect(life_x, life_y, life_width, life_height);
		//fill
		var hp = round(MY_TANK.hp);
		var hp_max = UNITS.get_tank_max_hp(MY_TANK);
		if(round(life_width*hp/hp_max) > 0)
			DRAW.draw_image(canvas_backround, 'level', life_x, life_y, round(life_width*hp/hp_max), life_height);
			
		//text
		var text = hp+"/"+hp_max;
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.font = "normal 9px Verdana";
		var text_width = canvas_backround.measureText(text).width;
		canvas_backround.fillText(text, life_x+life_width-text_width-5, life_y+life_height-5);
	
		//show fps
		DRAW.update_fps();
		};
	this.check_abilities_visibility = function(){
		if(game_mode == 'single_craft' || game_mode == 'multi_craft'){
			selected_n = 0;
			types_unique = {};
			types_unique_n = 0;
			for(var i in TANKS){
				if(TANKS[i].team != MY_TANK.team) continue;
				if(TANKS[i].selected == undefined) continue;
				selected_n++;
				if (TANKS[i].type in types_unique)
					types_unique[TANKS[i].type]++;
				else{
					types_unique[TANKS[i].type]=1;
					types_unique_n++;
					}
				}
			if(types_unique_n == 1) return true;
			if(selected_n > 1) return false;
			}
		
		return true;
		};
	//redraw tank skills
	this.draw_tank_abilities = function(){
		var gap = 15;
		var status_x_tmp = status_x+590;
		var status_y = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT+gap;
		var ns = UNITS.get_selected_count(MY_TANK.team);
		
		//clear area
		for(j=0; j<3; j++){
			if(MY_TANK.abilities_reuse[j] <= 0)
				DRAW.draw_image(canvas_backround, 'skill_off', status_x_tmp+j*(SKILL_BUTTON+gap)-5, status_y-5);
			}
		
		//save abilities position
		for (var i=0; i<3; i++){	
			if(INFOBAR.ABILITIES_POS.length < 3){
				var tmp = new Array();
				tmp['x'] = status_x_tmp+i*70 - round((WIDTH_APP-APP_SIZE_CACHE[0])/2);
				tmp['y'] = status_y + APP_SIZE_CACHE[1] - HEIGHT_APP;
				tmp['width'] = SKILL_BUTTON;
				tmp['height'] = SKILL_BUTTON;
				tmp['nr'] = parseInt(i)+1;
				INFOBAR.ABILITIES_POS.push(tmp);
				}
			}
		
		if(INFOBAR.check_abilities_visibility() == false) return false;
		
		for (var i=0; i<TYPES[MY_TANK.type].abilities.length; i++){
			//check if abilites not in use
			if(MY_TANK.abilities_reuse[i] > Date.now() ) continue;
			if(game_mode == 'single_craft' || game_mode == 'multi_craft')
				if(ns > 1 && MY_TANK.data.abilities[i].broadcast == 2) continue;
			
			//button
			var back_image = 'skill_on';
			if(TYPES[MY_TANK.type].abilities[i].passive == true)	
				back_image = 'skill_off';
			var ability_function = TYPES[MY_TANK.type].abilities[i].name.replace(/ /g,'_');
			var ability_stats = SKILLS[ability_function](MY_TANK, undefined, true);
			if(ability_stats.active != undefined && ability_stats.active == false)
				back_image = 'skill_off';
			DRAW.draw_image(canvas_backround, back_image, status_x_tmp+i*(SKILL_BUTTON+gap)-5, status_y-5);
				
			//text
			ability_text = TYPES[MY_TANK.type].abilities[i].name;
			canvas_backround.fillStyle = "#1d2411";
			canvas_backround.font = "bold 10px Verdana";
			if(ability_text.length>6)
				canvas_backround.font = "bold 9px Verdana";	
			letter_padding = Math.floor((SKILL_BUTTON-canvas_backround.measureText(ability_text).width )/2);
			if(letter_padding<0) letter_padding = 0;
			canvas_backround.fillText(ability_text, status_x_tmp+i*(SKILL_BUTTON+gap)+letter_padding, status_y+SKILL_BUTTON/2+3);
			
			//level
			if(game_mode == 'single_quick' || game_mode == 'multi_quick' || ability_stats.level != undefined){
				var value = MY_TANK.abilities_lvl[i];
				if(ability_stats.level != undefined)
					value = ability_stats.level;
				canvas_backround.font = "normal 8px Verdana";
				canvas_backround.fillStyle = "#2f391c";
				canvas_backround.fillText(value, status_x_tmp+i*(SKILL_BUTTON+gap)+5, status_y+11);
				}
			
			//ability to upgrade
			if(game_mode == 'single_quick' || game_mode == 'multi_quick'){
				if(i==ABILITIES_MODE-1){
					canvas_backround.beginPath();
					canvas_backround.arc(status_x_tmp+i*(SKILL_BUTTON+gap)+SKILL_BUTTON-5, status_y+5, 3, 0, 2*Math.PI);	
					canvas_backround.fillStyle = "#1d2e0b";
					canvas_backround.fill();
					}
				if(ABILITIES_MODE == 0){
					canvas_backround.beginPath();
					canvas_backround.arc(status_x_tmp+i*(SKILL_BUTTON+gap)+SKILL_BUTTON-5, status_y+5, 2, 0, 2*Math.PI);	
					canvas_backround.fillStyle = "#1d2e0b";
					canvas_backround.fill();
					}
				}
			}
		};
	//draw tanks skill reuse animation
	this.draw_ability_reuse = function(){
		var gap = 15;
		var status_x_tmp = status_x+590;
		var status_y = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT+gap;
		var animation = true;
		var ns = UNITS.get_selected_count(MY_TANK.team);
		
		if(PLACE != 'game') return false;
		if(INFOBAR.check_abilities_visibility() == false) animation = false; //craft mode - not 1 type selected
		
		if(animation == false){
			//clean
			for(j=0; j<3; j++)
				DRAW.draw_image(canvas_backround, 'skill_off', status_x_tmp+j*(SKILL_BUTTON+gap)-5, status_y-5);
			return false;
			}
		
		for(var i=0; i<3; i++){
			if(TYPES[MY_TANK.type].abilities[i] == undefined) return false;
			var ability_reuse = MY_TANK.abilities_reuse[i] - Date.now();
			if(ability_reuse < 0) continue;
			
			//button
			var active = true;
			var back_image = 'skill_on';
			if(TYPES[MY_TANK.type].abilities[i].passive == true){
				back_image = 'skill_off';
				active = false;
				}
			var ability_function = TYPES[MY_TANK.type].abilities[i].name.replace(/ /g,'_');
			var ability_stats = SKILLS[ability_function](MY_TANK, undefined, true);
			if(ability_stats.active != undefined && ability_stats.active == false){
				back_image = 'skill_off';
				active = false;
				}
			DRAW.draw_image(canvas_backround, back_image, status_x_tmp+i*(SKILL_BUTTON+gap)-5, status_y-5);
			
			canvas_backround.fillStyle = "#1d2411";
			
			//if active
			var img_height=0;
			if(active == true){
				img_height = (SKILL_BUTTON) * ability_reuse / MY_TANK.abilities_reuse_max[i] + 5;
				if(img_height > 65)
					img_height = 65;	//error here
				if(img_height < 6){
					//available again
					DRAW.draw_image(canvas_backround, 'skill_on', status_x_tmp+i*(SKILL_BUTTON+gap)-5, status_y-5);
					}
				else{
					//reuse on
					DRAW.draw_image(canvas_backround, 'skill_off', 
						status_x_tmp+i*(SKILL_BUTTON+gap)-5, 
						status_y-5, 
						SKILL_BUTTON+10, 
						img_height,
						undefined, undefined, undefined, img_height);
					canvas_backround.fillStyle = "#4b6125";
					}
				}
		
			//text
			canvas_backround.font = "bold 10px Verdana";
			var ability_text = TYPES[MY_TANK.type].abilities[i].name;
			if(ability_text.length>6)
				canvas_backround.font = "bold 9px Verdana";
			letter_padding = Math.floor((SKILL_BUTTON-canvas_backround.measureText(ability_text).width )/2);
			if(letter_padding<0) letter_padding = 0;
			canvas_backround.fillText(ability_text, status_x_tmp+i*(SKILL_BUTTON+gap)+letter_padding, status_y+SKILL_BUTTON/2+3);
			
			//level
			if(game_mode == 'single_quick' || game_mode == 'multi_quick' || ability_stats.level != undefined){
				var value = MY_TANK.abilities_lvl[i];
				if(ability_stats.level != undefined)
					value = ability_stats.level;
				canvas_backround.font = "normal 8px Verdana";
				canvas_backround.fillStyle = "#2f391c";
				canvas_backround.fillText(value, status_x_tmp+i*(SKILL_BUTTON+gap)+5, status_y+11);
				}
			
			//ability to upgrade
			if(game_mode == 'single_quick' || game_mode == 'multi_quick'){
				if(i==ABILITIES_MODE-1){
					canvas_backround.beginPath();
					canvas_backround.arc(status_x_tmp+i*(SKILL_BUTTON+gap)+SKILL_BUTTON-5, status_y+5, 3, 0, 2*Math.PI);	
					canvas_backround.fillStyle = "#1d2e0b";
					canvas_backround.fill();
					}
				if(ABILITIES_MODE == 0){
					canvas_backround.beginPath();
					canvas_backround.arc(status_x_tmp+i*(SKILL_BUTTON+gap)+SKILL_BUTTON-5, status_y+5, 2, 0, 2*Math.PI);	
					canvas_backround.fillStyle = "#1d2e0b";
					canvas_backround.fill();
					}
				}
			
			//reuse left
			reuse = Math.ceil(ability_reuse / 1000);
			if(reuse>0){
				canvas_backround.font = "normal 10px Verdana";
				canvas_backround.fillStyle = "#1d2411";
				var value_width = canvas_backround.measureText(reuse).width;
				canvas_backround.fillText(reuse, status_x_tmp+i*(SKILL_BUTTON+gap)+SKILL_BUTTON-5-value_width, status_y+round(SKILL_BUTTON*9/10));
				}
			}
		};
	//show skills descriptino on mouse hover
	this.show_skill_description = function(){
		var gap = 10;
		var status_x_tmp = status_x+575+gap;
		var status_y = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT+5+78;
		
		//clean description
		canvas_backround.fillStyle = "#17200b";
		canvas_backround.fillRect(status_x_tmp, status_y, 205, 35);
		
		//prepare
		canvas_backround.font = "normal 10px Verdana";
		
		var limit = 193;
		var ability_hover_text_more = '';
		active_line = 1;
		var text = INFOBAR.ability_hover_text;
		if(text != ''){
			var words = text.split(" ");
			text = '';
			for(var i in words){
				var tmp = text.concat(' ').concat(words[i]);
				if(active_line == 1 && canvas_backround.measureText(tmp).width < limit)
					text = text+" "+words[i];
				else{ 
					ability_hover_text_more += " "+words[i];
					active_line=2;
					}
				}
			}
		//show description
		canvas_backround.fillStyle = "#8f947d";
		canvas_backround.font = "normal 10px Verdana";
		canvas_backround.fillText(text, status_x_tmp+5, status_y+13);
		
		canvas_backround.fillStyle = "#8f947d";
		canvas_backround.font = "normal 10px Verdana";
		canvas_backround.fillText(ability_hover_text_more, status_x_tmp+5, status_y+13+13);
		};
	//move map by user mouse coordinates on mini map
	this.move_to_place = function(mouse_x, mouse_y){
		//settings
		area_width = MINI_MAP_PLACE[2];
		area_height = MINI_MAP_PLACE[3];
		mouse_x = mouse_x - MINI_MAP_PLACE[0];
		mouse_y = mouse_y - (APP_SIZE_CACHE[1]-INFO_HEIGHT-STATUS_HEIGHT+MINI_MAP_PLACE[1]);
		
		visible_block_x_half = WIDTH_SCROLL*area_width/WIDTH_MAP/2;
		visible_block_y_half = HEIGHT_SCROLL*area_height/HEIGHT_MAP/2;
		
		//check
		if(mouse_x-visible_block_x_half<0)	mouse_x=visible_block_x_half;
		if(mouse_y-visible_block_y_half<0)	mouse_y=visible_block_y_half;
		if(mouse_x+visible_block_x_half>area_width)	mouse_x=area_width-visible_block_x_half;
		if(mouse_y+visible_block_y_half>area_height)	mouse_y=area_height-visible_block_y_half;
		
		//calc	
		mouse_x = mouse_x - visible_block_x_half;
		mouse_y = mouse_y - visible_block_y_half;
		pos_x_pecentage = mouse_x*100/area_width;
		pos_y_pecentage = mouse_y*100/area_height;
		tmp_x = round(WIDTH_MAP*pos_x_pecentage/100);
		tmp_y = round(HEIGHT_MAP*pos_y_pecentage/100);
	
		//scrolling using css - 2x speed gain
		map_offset[0] = -tmp_x;
		map_offset[1] = -tmp_y;
		document.getElementById("canvas_map").style.marginLeft = map_offset[0]+"px";
		document.getElementById("canvas_map").style.marginTop = map_offset[1]+"px";
		if(QUALITY == 3){
			document.getElementById("canvas_fog").style.marginTop =  map_offset[1]+"px";
			document.getElementById("canvas_fog").style.marginLeft = map_offset[0]+"px";
			}
		};
	//mini map in status bar
	this.redraw_mini_map = function(){
		//settings
		var button_width = MINI_MAP_PLACE[2];
		var button_height = MINI_MAP_PLACE[3];
		var pos1 = status_x+MINI_MAP_PLACE[0];
		var pos2 = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT+MINI_MAP_PLACE[1];
		var border = MINI_MAP_PLACE[4];
		
		//clear mini map - borders
		canvas_backround.fillStyle = "#162508";
		canvas_backround.fillRect(pos1-border, pos2-border, button_width+border*2, button_height+border*2);
		
		//white color
		canvas_backround.fillStyle = "#ffffff";
		canvas_backround.fillRect(pos1, pos2, button_width, button_height);
		
		//active zone
		var zheight = HEIGHT_SCROLL*button_height/HEIGHT_MAP;
		if(pos2-map_offset[1]*button_height/HEIGHT_MAP + zheight < HEIGHT_SCROLL+INFO_HEIGHT){
			canvas_backround.fillStyle = "#97998c";
			canvas_backround.fillRect(
				pos1-map_offset[0]*button_width/WIDTH_MAP, 
				pos2-map_offset[1]*button_height/HEIGHT_MAP, 
				WIDTH_SCROLL*button_width/WIDTH_MAP, 
				zheight
				);
			}
			
		//show mini-fog
		if(QUALITY == 3)
			canvas_backround.drawImage(MINI_FOG, pos1, pos2);
			
		//elements
		var mini_w = (button_width-2)/MAPS[level-1].width;
		var mini_h = (button_height-2)/MAPS[level-1].height;
		for(var e in MAPS[level-1].elements){
			var element = MAP.get_element_by_name(MAPS[level-1].elements[e][0]);
			element.w = IMAGES_SETTINGS.elements[element.name].w;
			element.h = IMAGES_SETTINGS.elements[element.name].h;
			x = MAPS[level-1].elements[e][1];
			y = MAPS[level-1].elements[e][2];
			if(element.w<30)	x = x - round(element.w/2);
			if(element.h<30)	y = y - round(element.h/2);
			max_w = element.w;
			if(MAPS[level-1].elements[e][3]!=0)
				max_w = MAPS[level-1].elements[e][3];
			max_h = element.h;
			if(MAPS[level-1].elements[e][4]!=0)
				max_h = MAPS[level-1].elements[e][4];
			//minimize
			max_w = Math.ceil(max_w*button_width/MAPS[level-1].width);
			max_h = Math.ceil(max_h*button_height/MAPS[level-1].height);
			x = pos1 + Math.ceil(x*button_width/MAPS[level-1].width);
			y = pos2 + Math.ceil(y*button_height/MAPS[level-1].height);
			//draw
			if(element.alt_color != undefined){
				canvas_backround.fillStyle = element.alt_color;
				canvas_backround.fillRect(x, y, max_w, max_h);
				}
			}
		
		//update mini-fog
		if(QUALITY == 3){
			if(SCOUT_FOG_REUSE - Date.now() > 0) return false; //not so fast, wait a little
			for(var i in TANKS){
				if(TANKS[i].team != MY_TANK.team) continue;
				if(TANKS[i].constructing != undefined) continue;
				if(TANKS[i].dead == 1) continue;
				
				var xx = round(TANKS[i].cx());
				var yy = round(TANKS[i].cy());
				
				xx = round(xx * button_width / MAPS[level-1].width);
				yy = round(yy * button_height /(MAPS[level-1].height));
				
				MINI_FOG.getContext("2d").beginPath();
				var sight_range = round(TANKS[i].sight * button_width / MAPS[level-1].width);
	
				MINI_FOG.getContext("2d").arc(xx, yy, sight_range, 0 , 2 * Math.PI, true);
				MINI_FOG.getContext("2d").fill();
				}
			}
		};
	//draw tank in mini-map
	this.update_radar = function(tank){
		if(TYPES[tank.type].type == 'building' ||( tank.dead != 1 && UNITS.check_enemy_visibility(tank)==true)){
			//settings
			var button_width = MINI_MAP_PLACE[2];
			var button_height = MINI_MAP_PLACE[3];
			var pos1 = status_x+MINI_MAP_PLACE[0];
			var pos2 = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT+MINI_MAP_PLACE[1];
			
			//draw
			if(tank.team == 'B')
				canvas_backround.fillStyle = "#0000aa";
			else
				canvas_backround.fillStyle = "#b12525";
			msize = 3;
			if(TYPES[tank.type].size[0] == 'S')
				msize = 2;
			else if(TYPES[tank.type].size[0] == 'L')
				msize = 4;	
			var tank_x = tank.x + tank.width()/2;
			var tank_y = tank.y + tank.height()/2;
			if(tank_x<0)	tank_x=0;
			if(tank_y<0)	tank_y=0;
			if(tank_x>MAPS[level-1].width)	tank_x=MAPS[level-1].width;
			if(tank_y>MAPS[level-1].height)	tank_y=MAPS[level-1].height;
			
			tank_x = pos1 + round(tank_x * button_width / round(MAPS[level-1].width));
			tank_y = pos2 + round(tank_y * button_height /(MAPS[level-1].height));
			canvas_backround.fillRect(tank_x, tank_y, msize, msize);
			}
		};
	this.draw_factory_gui = function(selected_tank, get_stats){
		var padding_left = 250;
		var padding_top = 15;
		var pos1 = status_x+padding_left;
		var pos2 = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT+padding_top;
		var top_y = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT+40;
		var max_width = 325;
		var max_height = 80;
		var gap = 3;
		var msize = 33;
		var first_time = false;
		if(get_stats != undefined)
			return {
				msize: msize, 
				pos1: pos1, 
				pos2: pos2, 
				gap: gap, 
				};
		
		if(selected_tank == undefined){
			selected_tank = MY_TANK.type;
			first_time = true;
			}
		
		//clear area
		DRAW.draw_image(canvas_backround, 'statusbar', status_x+padding_left, status_y+padding_top, max_width, max_height,
			status_x+padding_left, padding_top, max_width, max_height);
		
		//tanks
		var j=0;
		var row = 0;
		var nation = UNITS.get_nation_by_team(MY_TANK.team);
		for(var i in TYPES){
			if(TYPES[i].type == 'building') continue;
			if(UNITS.check_nation_tank(TYPES[i].name, nation)==false) continue;
			//reset background
			var back_color = '';
			if(selected_tank != undefined && selected_tank == i || i == MY_TANK.type)
				back_color = "#8fc74c"; //selected
			else{
				//default
				back_color = "#dbd9da";
				if(game_mode == 'single_craft' || game_mode == 'multi_craft'){
					var type_n = 0;
					for(var t in MY_TANK.training){
						if(MY_TANK.training[t].type != i) continue;
						back_color = "#8fc74c"; //selected
						type_n++;
						}
					}
				}
			canvas_backround.fillStyle = back_color;
			canvas_backround.strokeStyle = "#196119";
			HELPER.roundRect(canvas_backround, pos1+j*(msize+gap), pos2+row*(msize+gap), msize, msize, 3, true);
			
			//detect size
			var sizer = msize * 100 / (TYPES[i].size[1]+4) / 100;
			if(sizer>1) sizer = 1;
			var pad_tmp = 2;
			if(sizer == 1)
				pad_tmp = Math.floor((msize - TYPES[i].size[1])/2);
	
			//logo
			DRAW.draw_image(canvas_backround, TYPES[i].name, 
				pos1+j*(msize+gap)+pad_tmp, pos2+row*(msize+gap)+pad_tmp, TYPES[i].size[1]*sizer, TYPES[i].size[2]*sizer,
				100, undefined, TYPES[i].size[1], TYPES[i].size[2]);
			DRAW.draw_image(canvas_backround, TYPES[i].name, 
				pos1+j*(msize+gap)+pad_tmp, pos2+row*(msize+gap)+pad_tmp, TYPES[i].size[1]*sizer, TYPES[i].size[2]*sizer,
				150, undefined, TYPES[i].size[1], TYPES[i].size[2]);
			
			//show training count
			if(game_mode == 'single_craft' || game_mode == 'multi_craft'){
				for(var x=0; x<type_n; x++){
					canvas_backround.beginPath();
					canvas_backround.arc(pos1+j*(msize+gap)+msize-5, pos2+row*(msize+gap)+5+x*5, 2, 0, 2*Math.PI);	
					canvas_backround.fillStyle = "#1d2e0b";
					canvas_backround.fill();
					}
				}
			//register button
			MAIN.register_button(pos1+j*(msize+gap) - round((WIDTH_APP-APP_SIZE_CACHE[0])/2),
				pos2+row*(msize+gap)+ APP_SIZE_CACHE[1] - HEIGHT_APP,
				msize, msize, PLACE, function(mouseX, mouseY, index){
				INFOBAR.gui_action(index);
				}, j);
			j++;
			}
			
		//cancel button
		if(MY_TANK.training != undefined && MY_TANK.training.length > 0){
			width = 50;
			height = 23;
			var xx = status_x+padding_left+max_width-width-9;
			var yy = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT+padding_top+max_height-height-15;
			canvas_backround.strokeStyle = "#000000";
			canvas_backround.fillStyle = "#c50000";
			HELPER.roundRect(canvas_backround, xx, yy, width, height, 3, true);
			MAIN.register_button(xx - round((WIDTH_APP-APP_SIZE_CACHE[0])/2), yy + APP_SIZE_CACHE[1] - HEIGHT_APP, width, height, PLACE, function(xx, yy){
				if(MY_TANK.data.name != 'Factory'){
					INFOBAR.gui_action(-1);
					return true;
					}
				for(var x in TANKS){
					if(TANKS[x].team != MY_TANK.team) continue;
					if(TANKS[x].selected == undefined) continue;
					if(TANKS[x].data.name != 'Factory') continue;
					for(var i in TANKS[x].training){
						UNITS.player_data[my_nation].he3 += TANKS[x].training[i].cost;
						}
					TANKS[x].training = [];
					}
				INFOBAR.draw_factory_gui();
				});
			//text
			text = "Stop";
			canvas_backround.fillStyle = "#ffffff";
			canvas_backround.font = "Bold 11px Arial";
			var text_width = canvas_backround.measureText(text).width;
			canvas_backround.fillText(text, xx+(width-text_width)/2, yy+(height + HELPER.font_pixel_to_height(11))/2);
			}
		};
	this.draw_mechanic_gui = function(selected_tank, get_stats){
		var padding_left = 250;
		var padding_top = 15;
		var pos1 = status_x+padding_left;
		var pos2 = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT+padding_top;
		var top_y = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT+40;
		var max_width = 325;
		var max_height = 80;
		var gap = 3;
		var msize = 33;
		var first_time = false;
		if(get_stats != undefined)
			return {
				msize: msize, 
				pos1: pos1, 
				pos2: pos2, 
				gap: gap, 
				};
		
		if(selected_tank == undefined){
			selected_tank = MY_TANK.type;
			first_time = true;
			}
		
		//clear area
		DRAW.draw_image(canvas_backround, 'statusbar', status_x+padding_left, status_y+padding_top, max_width, max_height,
			status_x+padding_left, padding_top, max_width, max_height);
		
		//structures
		var j=0;
		var row = 0;
		var nation = UNITS.get_nation_by_team(MY_TANK.team);
		for(var i in TYPES){
			if(TYPES[i].type != 'building') continue;
			
			//reset background
			var back_color = '';
			if(selected_tank != undefined && selected_tank == i || i == MY_TANK.type)
				back_color = "#8fc74c"; //selected
			else
				back_color = "#dbd9da";
			canvas_backround.fillStyle = back_color;
			canvas_backround.strokeStyle = "#196119";
			HELPER.roundRect(canvas_backround, pos1+j*(msize+gap), pos2+row*(msize+gap), msize, msize, 3, true);
			
			//detect size
			var sizer = msize * 100 / TYPES[i].size[1] / 100;
			if(sizer>1) sizer = 1;
			var pad_tmp = 2;
			if(sizer == 1)
				pad_tmp = Math.floor((msize - TYPES[i].size[1])/2);
	
			//logo
			DRAW.draw_image(canvas_backround, TYPES[i].name, 
				pos1+j*(msize+gap)+pad_tmp, pos2+row*(msize+gap)+pad_tmp, TYPES[i].size[1]*sizer, TYPES[i].size[2]*sizer,
				100, undefined, TYPES[i].size[1], TYPES[i].size[2]);
			DRAW.draw_image(canvas_backround, TYPES[i].name, 
				pos1+j*(msize+gap)+pad_tmp, pos2+row*(msize+gap)+pad_tmp, TYPES[i].size[1]*sizer, TYPES[i].size[2]*sizer,
				150, undefined, TYPES[i].size[1], TYPES[i].size[2]);
			
			//register button
			MAIN.register_button(pos1+j*(msize+gap) - round((WIDTH_APP-APP_SIZE_CACHE[0])/2),
				pos2+row*(msize+gap)+ APP_SIZE_CACHE[1] - HEIGHT_APP,
				msize, msize, PLACE, function(mouseX, mouseY, index){
				INFOBAR.gui_action(index);
				}, j);
			j++;
			}
		};
	this.draw_units_gui = function(){
		var padding_left = 250;
		var padding_top = 15;
		var pos1 = status_x+padding_left;
		var pos2 = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT+padding_top;
		var top_y = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT+40;
		var max_width = 325;
		var max_height = 80;
		var gap = 3;
		var ns = UNITS.get_selected_count(MY_TANK.team);
		var msize = 33;
	
		//draw tanks
		var j=0;
		var row = 0;
		var k = 0;
		for(var i in TANKS){
			if(TANKS[i].team != MY_TANK.team) continue; //enemy
			if(TANKS[i].selected == undefined) continue; //not selected
			
			//check
			if(pos1+j*(msize+gap)+msize > pos1+max_width){
				j = -3;
				row++;
				}
			
			//reset background
			canvas_backround.fillStyle = "#dbd9da";
			canvas_backround.strokeStyle = "#196119";
			HELPER.roundRect(canvas_backround, pos1+j*(msize+gap), pos2+row*(msize+gap), msize, msize, 3, true);
			
			//detect size
			var sizer = msize * 100 / (TANKS[i].width()+10) / 100;
			if(sizer>1) sizer = 1;
			var pad_tmp = 2;
			if(sizer == 1)
				pad_tmp = Math.floor((msize - TANKS[i].width())/2);
				
			//logo
			DRAW.draw_image(canvas_backround, TANKS[i].data.name, 
				pos1+j*(msize+gap)+pad_tmp, pos2+row*(msize+gap)+pad_tmp, TANKS[i].width()*sizer, TANKS[i].height()*sizer,
				100, undefined, TANKS[i].width(), TANKS[i].height());
			DRAW.draw_image(canvas_backround, TANKS[i].data.name, 
				pos1+j*(msize+gap)+pad_tmp, pos2+row*(msize+gap)+pad_tmp, TANKS[i].width()*sizer, TANKS[i].height()*sizer,
				150, undefined, TANKS[i].width(), TANKS[i].height());
			
			//hp bar
			var hp = round(TANKS[i].hp);
			var hp_max = UNITS.get_tank_max_hp(TANKS[i]);
			if(hp < hp_max){
				var pad_line = 3;
				var life_width = msize - pad_line*2;
				var width = round(life_width*hp/hp_max);
				canvas_backround.beginPath();
				canvas_backround.rect(pos1+j*(msize+gap)+pad_line, pos2+row*(msize+gap)+msize-3, width, 2);
				if(hp < hp_max*2/3)
					canvas_backround.fillStyle = "#d02b21";
				else
					canvas_backround.fillStyle = "#19290a";
				canvas_backround.fill();
				}
			
			//register button
			MAIN.register_button(pos1+j*(msize+gap)+1*0 - round((WIDTH_APP-APP_SIZE_CACHE[0])/2),
				pos2+row*(msize+gap) + APP_SIZE_CACHE[1] - HEIGHT_APP, 
				msize, msize, PLACE, function(mouseX, mouseY, index){
				INFOBAR.gui_action(index);
				}, k);
			j++;
			k++;
			if(k>=33) return false;
			}
		};
	this.gui_action = function(index){
		var ns = UNITS.get_selected_count(MY_TANK.team);
		//units training
		if(MY_TANK.data.name == 'Factory'){
			//find type
			var k = 0;
			var found = false;
			for(var t in TYPES){
				if(TYPES[t].type == 'building') continue;
				if(UNITS.check_nation_tank(TYPES[t].name, MY_TANK.nation)==false) continue;
				k++;
				if(k-1 != index) continue;
				index = t;
				found = true;
				break;
				}
			if(found == true){
				//loop for each factories
				for(var i in TANKS){	
					if(TANKS[i].team != MY_TANK.team) continue;
					if(TANKS[i].data.name != "Factory") continue;
					if(TANKS[i].selected == undefined) continue;
					
					var unit_cost = TYPES[index].cost;
					unit_cost = UNITS.apply_buff(MY_TANK, 'cost', unit_cost);
					//check he3
					if(UNITS.player_data[my_nation].he3 < unit_cost){
						screen_message.text = "Not enough HE-3.";
						screen_message.time = Date.now() + 1000;
						return false;
						}
					//check unit limit
					var team_units = 0;
					for(var ii in TANKS){
						if(TANKS[ii].team != MY_TANK.team) continue;
						if(TANKS[ii].data.name == 'Base') continue;
						if(TANKS[ii].data.type == 'building'){
							if(TANKS[ii].data.name == "Factory" && TANKS[ii].training != undefined){
								team_units = team_units + TANKS[ii].training.length;
								}
							}
						if(TANKS[ii].data.damage[0] == 0) continue;
						team_units++;
						}
					if(TANKS[i].training != undefined && TANKS[i].training.length >= 5) return false;
					if(team_units >= MAX_TEAM_TANKS){
						screen_message.text = "Unit limit reached: "+MAX_TEAM_TANKS;
						screen_message.time = Date.now() + 1000;
						return false;
						}
					UNITS.player_data[my_nation].he3 -= unit_cost;
					//register
					var duration = 30*1000;
					if(TYPES[index].type == 'human')
						duration = 20*1000;
					if(DEBUG == true) duration = 1000;
					//check respawn buff
					for(var b in COUNTRIES[MY_TANK.nation].buffs){
						var buff = COUNTRIES[MY_TANK.nation].buffs[b];
						if(buff.name == "respawn"){
							if(buff.type == 'static')
								duration = duration + buff.power;
							else
								duration = duration * buff.power;
							}
						}
					if(duration < 1000) duration = 1000;
					
					if(TANKS[i].training == undefined)
						TANKS[i].training = new Array();
					TANKS[i].training.push({
						duration: duration,
						type: index,
						cost: unit_cost,
						});
					
					INFOBAR.draw_factory_gui();
					}
				return true;
				}
			}
		//structures build
		else if(MY_TANK.data.name == 'Mechanic' && ns == 1){
			var k = 0;
			for(var i in TYPES){  	//find type
				if(TYPES[i].type != 'building') continue;
				k++;
				if(k-1 != index) continue;
				index = i;
				
				var unit_cost = TYPES[index].cost; 
				if(UNITS.player_data[my_nation].he3 < unit_cost){
					screen_message.text = "Not enough HE-3.";
					screen_message.time = Date.now() + 1000;
					return false;
					}
				SKILLS.construct_prepare(MY_TANK, 0, TYPES[index].name, 2);
				return true;
				}
			}	
		//multiple selection
		if(ns > 1){
			var k = 0;
			for(var i in TANKS){
				if(TANKS[i].team != MY_TANK.team) continue; //enemy
				if(TANKS[i].selected == undefined) continue; //not selected
				k++;
				if(k-1 != index) continue;
				index = i;
				for(var j in TANKS) delete TANKS[j].selected; //unselect all
				
				if(ctrl_pressed==true){
					//select group
					for(var j in TANKS){
						if(MY_TANK.team != TANKS[j].team) continue;
						if(TANKS[i].type != TANKS[j].type) continue;
						if(TANKS[j].constructing != undefined) continue;
						TANKS[j].selected = 1;
						if(MY_TANK.selected == undefined)
							MY_TANK = TANKS[j];
						}
					}
				else{
					//select 1
					TANKS[i].selected = 1;
					MY_TANK = TANKS[i];
					}
				INFOBAR.draw_infobar();
				return true;
				}
			}
		};
	}
