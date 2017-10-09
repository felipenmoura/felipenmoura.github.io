var UNITS = new UNITS_CLASS();

function UNITS_CLASS(){
	this.flag_width = 15;
	this.flag_height = 9;
	this.player_data = {};	//player data in full mode
	
	//adds new tank
	this.add_tank = function(level, id, name, type, team, nation, x, y, angle, AI, master_tank, begin_time){ 
		if(PLACE != 'game') return false;
		if(type==undefined) type = 0;
		
		//angle
		if(angle==undefined)
			angle = 0;
		var hp = (TYPES[type].life[0]+TYPES[type].life[1]*(level-1));
		for(var b in COUNTRIES[nation].buffs){
			var buff = COUNTRIES[nation].buffs[b];
			if(buff.name == "health"){
				if(buff.type == 'static')
					hp = hp + buff.power;
				else
					hp = hp * buff.power;
				}
			}
		hp = round(hp);
		
		//create
		TANK_tmp = {
			id: id,			//unique id
			name: name,		//name
			type: type,		//type index
			team: team,		//team
			nation: nation,		//nation
			x: x,			//x position
			y: y,			//y position
			angle: angle,		//body angle
			fire_angle: angle,	//turret angle
			move: 0,		//moving or not, 0 or 1
			level: level,		//level, 1-999
			sublevel: 0,		//progres till level-up
			hp: hp,			//current health
			abilities_lvl: [1, 1, 1],					//skills initial levels
			abilities_reuse: [0, 0, 0],					//skills reuse time left
			abilities_reuse_max: [0, 0, 0],					//skills max reuse time
			sight: TYPES[type].scout + round(TYPES[type].size[1]/2),	//sight 
			pierce_armor: 0,	//pierce enemy in %, 0-100
			animations: [],		//array of animations, DRAW.completely draw them
			visible: {state: false, time: Date.now()-10000},	//if visible, used only for grapchics effects
			begin_time: Date.now(),	//time unit was created
			death_time: 0,		//how much second tank was dead
			bullets: 0,		//how much second tank was in battle
			damage_received: 0,	//total damage received
			damage_done: 0,		//total damage done
			score: 0,		//total score
			kills: 0,		//total kills
			deaths: 0,		//total deaths
			cache_tank: [],		//cache for draw operations
			buffs: [],		//buffs array
			last_bullet_time: Date.now()-5000, //last bullet time, for checking if unit in battle
			data: TYPES[type],	//unit type general info
			};
		if(AI != undefined)
			TANK_tmp.use_AI = AI;		//bots has auto-controlls in AI class (ai.js)
		if(master_tank != undefined)
			TANK_tmp.master = master_tank;	//if unit slave, like Truck soldiers 
		if(begin_time != undefined)
			TANK_tmp.begin_time = begin_time;
		TANK_tmp.cx = function(){ 	return this.x + round(TYPES[this.type].size[1]/2);	}; //center x coordinates
		TANK_tmp.cy = function(){	return this.y + round(TYPES[this.type].size[2]/2);	}; //center y coordinates
		TANK_tmp.width = function(){	return TYPES[this.type].size[1];		};	//unit width
		TANK_tmp.height = function(){	return TYPES[this.type].size[2];		};	//unit height
		if(TANK_tmp.x == undefined || TANK_tmp.y == undefined)
			UNITS.set_spawn_coordinates(TANK_tmp);
		
		//racial stats
		for(var b in COUNTRIES[TANK_tmp.nation].buffs){
			var buff = COUNTRIES[TANK_tmp.nation].buffs[b];
			TANK_tmp.buffs.push({
				name: buff.name,
				power: buff.power,
				type: buff.type,
				});
			}
		
		//auto add 1 lvl upgrade
		for(jj in TYPES[TANK_tmp.type].abilities){ 
			var nr = 1+parseInt(jj);
			var ability_function = TYPES[TANK_tmp.type].abilities[jj].name.replace(/ /g,'_')+"_once";
			if(ability_function != undefined){
				try{
					SKILLS[ability_function](TANK_tmp);
					}
				catch(err){	}
				}
			}
		if((game_mode == 'single_craft' || game_mode == 'multi_craft') && TANK_tmp.data.type == 'building')
			TANK_tmp.scouted = false;
		
		TANKS.push(TANK_tmp);
		
		//return last tank
		return TANKS[TANKS.length-1];
		};
	//draw single tank
	this.draw_tank = function(tank){
		if(tank == undefined) return false;
		if(tank.invisibility != undefined && tank.team != MY_TANK.team) return false; //enemy in hide mode
		var tank_size_w =  tank.width();
		var tank_size_h =  tank.height();
		var visibility = 0;
		var alpha = 1;
		var padding = 20;
		var fade_duration = 300;
		
		if((game_mode == 'single_craft' || game_mode == 'multi_craft') && tank.team != MY_TANK.team && tank.data.type == 'building' && tank.scouted == false)
			return false; //not scouted yet
		
		//draw flag
		if(tank.selected == true && tank.flag != undefined && tank.constructing == undefined){
			DRAW.draw_image(canvas_main, 'flag', tank.flag.x+map_offset[0], tank.flag.y+map_offset[1]);
			//dashed line
			canvas_main.lineWidth = 2;
			canvas_main.strokeStyle = "#363737";
			var image_stats = IMAGES_SETTINGS.general.flag;
			HELPER.dashedLine(canvas_main, tank.cx()+map_offset[0], tank.cy()+map_offset[1], tank.flag.x+map_offset[0]+image_stats.w/2, tank.flag.y+map_offset[1]+image_stats.h/2);
			}
		
		if(FS==false && (tank.y > -1*map_offset[1] + HEIGHT_SCROLL || tank.y+tank_size_h < -1*map_offset[1] || tank.x > -1*map_offset[0] + WIDTH_SCROLL || tank.x+tank_size_w < -1*map_offset[0])){
			//not in screen zone
			if(tank.visible.state == true){
				tank.visible.state = false;
				tank.visible.time = Date.now();
				}
			}
		else{
			visibility = 1;
			if(UNITS.check_enemy_visibility(tank)==false){
				if(tank.visible.state == true){
					tank.visible.state = false;
					tank.visible.time = Date.now();
					}
				//fade out effect
				if(TYPES[tank.type].type != "building" && tank.visible.time + fade_duration > Date.now()){
					alpha = (Date.now()-tank.visible.time) / fade_duration;
					alpha = round(alpha*100)/100;
					alpha = 1 - alpha;	//reverse fade
					//draw clone
					UNITS.draw_tank_clone(tank.type, tank.x, tank.y, tank.angle, alpha);
					}
				return false; //out of sight
				}
			if(tank.visible.state == false){
				tank.visible.state = true;
				tank.visible.time = Date.now();
				}
			
			//set transparency
			if(QUALITY > 1){
				//death
				if(tank.dead == 1)
					alpha = 0.5;	
				//invisibility
				else if(tank.invisibility == 1)	
					alpha = 0.6;	
				//fade in effect
				if(TYPES[tank.type].type != "building" && tank.visible.time + fade_duration > Date.now()){
					alpha = (Date.now()-tank.visible.time) / fade_duration;
					alpha = round(alpha*100)/100;
					}
				if(tank.constructing != undefined){
					alpha = 1 * tank.constructing.time / tank.constructing.duration;
					if(alpha < 0.2)
						alpha = 0.2;
					}
				}
					
			//generate unique cache id
			var cache_id = "";
			cache_id += "T:"+tank.type+',';
			cache_id += "NA:"+tank.nation+',';
			cache_id += "A:"+tank.angle+',';
			cache_id += "FA:"+tank.fire_angle+',';
			cache_id += "Si:"+tank_size_w+'x'+tank_size_h+',';
			cache_id += "AL:"+alpha+',';
			for (i in tank.buffs)
				cache_id += "E:"+tank.buffs[i].name+',';
			if(tank.dead == 1)
				cache_id += 'DD,';
			if(tank.invisibility != undefined)
				cache_id += 'NV,';
			if(tank.clicked_on != undefined){
				cache_id += 'EC,';
				tank.clicked_on = tank.clicked_on - 1;
				if(tank.clicked_on == 0)
					delete tank.clicked_on;
				}
			if(tank.selected != undefined)
				cache_id += 'SE,';
			if(TYPES[tank.type].icon_top[0] != undefined)
				cache_id += "SA:"+tank.fire_angle+',';
			
			if(tank.cache_tank != undefined && tank.cache_tank.unique == cache_id && tank.cache_tank.time - Date.now() > 0){
				//read from cache
				canvas_main.drawImage(tank.cache_tank.object, round(tank.x+map_offset[0])-padding, round(tank.y+map_offset[1])-padding);
				}
			else{
				//create tmp
				var tmp_canvas = document.createElement('canvas');
				tmp_canvas.width = 110;
				tmp_canvas.height = 110;
				var tmp_object = tmp_canvas.getContext("2d");
				var radius_extra = 0;
				
				//start adding data
				tmp_object.save();
				
				//set transparent
				if(alpha != 1 && QUALITY > 1)
					tmp_object.globalAlpha = alpha;
			
				//draw tank base
				if(TYPES[tank.type].no_base_rotate === true){
					//draw without rotation
					DRAW.draw_image(tmp_object, TYPES[tank.type].name,
						padding, padding, undefined, undefined,	
						100, 0, TYPES[tank.type].size[1], TYPES[tank.type].size[2]);
					tmp_object.translate(round(tank_size_w/2)+padding, round(tank_size_h/2)+padding);
					tmp_object.rotate(tank.angle * TO_RADIANS);
					}
				else{
					tmp_object.translate(round(tank_size_w/2)+padding, round(tank_size_h/2)+padding);
					tmp_object.rotate(tank.angle * TO_RADIANS);
					DRAW.draw_image(tmp_object, TYPES[tank.type].name,
						-1*round(tank_size_w/2), -1*round(tank_size_h/2), tank_size_w, tank_size_h,
						100, 0, TYPES[tank.type].size[1], TYPES[tank.type].size[2]);
					}
				tmp_object.restore();
				
				//draw top
				if(TYPES[tank.type].icon_top != false){
					tmp_object.save();
					if(alpha != 1 && QUALITY > 1)
						tmp_object.globalAlpha = alpha;
					tmp_object.translate(round(tank_size_w/2)+padding, round(tank_size_h/2)+padding);
					tmp_object.rotate(tank.fire_angle * TO_RADIANS);
					DRAW.draw_image(tmp_object, TYPES[tank.type].name,
						-(tank_size_w/2), -(tank_size_h/2), tank_size_w, tank_size_h, 
						150, 0, TYPES[tank.type].size[1], TYPES[tank.type].size[2]);
					tmp_object.restore();
					}
	
				//draw extra layer
				icons_n = 0;
				for (i in tank.buffs){
					if(tank.buffs[i].icon != undefined)
						icons_n++;
					}
				var icon_i = 0;
				for (i in tank.buffs){
					if(tank.buffs[i].icon != undefined){
						icon_i++;
						var icon_w = IMAGES_SETTINGS.general[tank.buffs[i].icon].w;
						var icon_h = IMAGES_SETTINGS.general[tank.buffs[i].icon].h;
						var left = padding + tank_size_w/2 - icon_w/2;
						var top = padding + tank_size_h/2 - icon_h/2;	//if 1 buff
						if(icons_n == 2)
							top = padding + tank_size_h/3*icon_i - icon_h/2; //2 buffs
						else if(icons_n > 2)
							top = padding + tank_size_h/4*icon_i - icon_h/2; //3+ buffs
						//draw
						DRAW.draw_image(tmp_object, tank.buffs[i].icon, left, top);
						//do not show more then 3 - looks ugly
						if(icon_i >= 3) break;
						}
					}
				
				//enemy checked
				if(tank.clicked_on != undefined){
					tmp_object.beginPath();
					radius = tank_size_w/2 + radius_extra;
					tmp_object.arc(tank_size_w/2+padding, tank_size_h/2+padding, radius, 0 , 2 * Math.PI, false);	
					tmp_object.lineWidth = 2;
					tmp_object.strokeStyle = "#700c10";
					tmp_object.stroke();
					radius_extra = radius_extra + 5;
					}
					
				//selected ally
				if(tank.selected != undefined){
					tmp_object.beginPath();
					radius = tank_size_w/2 + radius_extra;
					tmp_object.arc(tank_size_w/2+padding, tank_size_h/2+padding, radius, 0 , 2 * Math.PI, false);	
					tmp_object.lineWidth = 1;
					tmp_object.strokeStyle = "#1c2e0d";
					tmp_object.stroke();
					radius_extra = radius_extra + 5;
					}
				
				//flag
				if(TYPES[tank.type].type == 'building' || TYPES[tank.type].name == 'Base'){
					DRAW.draw_image(tmp_object, COUNTRIES[tank.nation].file, 8, padding - 15 + round(tank.height()*7/100));
					}
				
				//save to cache
				tank.cache_tank = [];
				tank.cache_tank.object = tmp_canvas;
				tank.cache_tank.unique = cache_id;
				tank.cache_tank.time = Date.now()+3000;
				
				//show
				canvas_main.drawImage(tmp_canvas, round(tank.x+map_offset[0])-padding, round(tank.y+map_offset[1])-padding);
				}
			//draw clicked position
			if(tank.clicked != undefined){
				canvas_main.beginPath();
				canvas_main.arc(round(map_offset[0]+tank.clicked[0]), round(map_offset[1]+tank.clicked[1]), round(tank.clicked[2]), 0 , 2 * Math.PI, false);	
				canvas_main.lineWidth = 2;
				canvas_main.strokeStyle = "#ffffff";
				canvas_main.stroke();
				tank.clicked[2] = tank.clicked[2]-1;
				if(tank.clicked[2] == 1)
					delete tank.clicked;
				}
			if(tank.dead != 1 && tank.death_respan == undefined){
				UNITS.add_player_name(tank);
				UNITS.add_hp_bar(tank);
				}
			}	
		INFOBAR.update_radar(tank);
		};
	//draw selected tank on selected place
	this.draw_tank_clone = function(type, x, y, angle, alpha, canvas){
		x = x + map_offset[0];
		y = y + map_offset[1];
		var W = TYPES[type].size[1];
		var H = TYPES[type].size[2];
		if(alpha == undefined) alpha = 1;
		if(canvas == undefined) canvas = canvas_main;
	
		//draw tank base
		canvas.save();
		canvas.globalAlpha = alpha;
		if(TYPES[type].no_base_rotate === true || angle == 0){
			//without rotation
			DRAW.draw_image(canvas, TYPES[type].name,
				x, y, W, H,	
				100, 0, W, H);
			}
		else{
			canvas.translate(round(W/2)+x, round(H/2)+y);
			canvas.rotate(angle * TO_RADIANS);
			DRAW.draw_image(canvas, TYPES[type].name,
				-1*round(W/2), -1*round(H/2), W, H,
				100, 0, W, H);
			}
		canvas.restore();
		
		//draw top
		if(TYPES[type].icon_top != false){
			canvas.save();
			canvas.globalAlpha = alpha;
			canvas.translate(round(W/2)+x, round(H/2)+y);
			canvas.rotate(angle * TO_RADIANS);
			DRAW.draw_image(canvas, TYPES[type].name,
				-(W/2), -(H/2), W, H, 
				150, 0, W, H);
			canvas.restore();
			}
		};
	//tank hp bar above
	this.add_hp_bar = function(tank){
		xx = round(tank.x+map_offset[0]);
		yy = round(tank.y+map_offset[1]);
		var max_life = UNITS.get_tank_max_hp(tank);
		life = tank.hp * 100 / max_life;
		canvas_main.fillStyle = "#c10000";
		hp_width = round(tank.width()*80/100);	//%80
		padding_left = round((tank.width() - hp_width)/2);
		padding_top = round(tank.height()*7/100);
		yy = yy - 13;
		hp_height = 5;
		if(TYPES[tank.type].type == 'human')
			hp_height = '3';
		
		canvas_main.fillStyle = "#196119";	//green
		canvas_main.fillRect(xx+padding_left, yy+padding_top, hp_width, hp_height);
		canvas_main.fillStyle = "#c10000";	//red
		red_bar_length = Math.floor((100-life)*hp_width/100);	
		red_bar_x = xx + hp_width - red_bar_length;
		canvas_main.fillRect(red_bar_x+padding_left, yy+padding_top, red_bar_length, hp_height);
		
		if(tank.constructing != undefined){
			var length = hp_width * tank.constructing.time / tank.constructing.duration;
			length = round(length);
			if(length >= hp_width)
				length = hp_width;
			canvas_main.fillStyle = "#d9ce00";
			canvas_main.fillRect(xx+padding_left, yy+padding_top-3-hp_height, length, hp_height);
			}
		};
	this.train_process = function(tank){
		xx = round(tank.x+map_offset[0]);
		yy = round(tank.y+map_offset[1]);
		padding_left = round((tank.width() - hp_width)/2);
		padding_top = round(tank.height()*7/100);
		
		if(tank.training == undefined) return false;
		for(var t=0; t < tank.training.length; t++){
			var type = tank.training[t].type;
			if(tank.training[t].start == undefined)
				tank.training[t].start = Date.now();
			var length = (Date.now() - tank.training[t].start) * hp_width / tank.training[t].duration;
			length = round(length);
			if(length >= hp_width){
				//find tank spawn point and path to flag
				var dist_x = tank.flag.x - tank.cx();
				var dist_y = tank.flag.y - tank.cy();
				var distance = Math.sqrt((dist_x*dist_x)+(dist_y*dist_y));
				var radiance = Math.atan2(dist_y, dist_x);
				var x = tank.cx() + Math.floor(Math.cos(radiance)*70) - round(TYPES[type].size[1]/2);
				var y = tank.cy() + Math.floor(Math.sin(radiance)*70) - round(TYPES[type].size[2]/2);
				if(x < 0) x = 0;
				if(y < 0) y = 0;
				if(x > WIDTH_MAP) x = WIDTH_MAP;
				if(y > HEIGHT_MAP) y = HEIGHT_MAP;
				
				var angle = 180;
				if(tank.team != 'B')
					angle = 0;
					
				var new_id = TYPES[type].name+'-'+HELPER.getRandomInt(0, 999999);
				var new_name = HELPER.generatePassword(6);
				var gap_rand = tank.width();
				var move_x = tank.flag.x + HELPER.getRandomInt(-gap_rand, gap_rand);
				var move_y = tank.flag.y + HELPER.getRandomInt(-gap_rand, gap_rand);
				
				if(game_mode == 'single_craft'){
					//create tank
					var new_tank = UNITS.add_tank(1, new_id, new_name, type, tank.team, tank.nation, x, y, angle);
					UNITS.player_data[new_tank.nation].units++;
					new_tank.move = 1;
					if(tank.use_AI == true)
						new_tank.use_AI = true;
					//randomize spawn position
					new_tank.move_to = [
						move_x, 
						move_y,
						];
					}
				else{
					var unit_data = {
						mode: 'craft',
						type: type,
						team: tank.team,
						nation: tank.nation,
						x: Math.round(x),
						y: Math.round(y),
						id: new_id,
						name: new_name,
						move_x: move_x,
						move_y: move_y,
						angle: tank.angle,
						flag_x: tank.flag.x,
						flag_y: tank.flag.y,
						};
					MP.send_packet('new_unit', unit_data);
					}
				
				//unregister
				tank.training.splice(t, 1); t--;
				break;
				}
			//draw
			if(tank.team == MY_TANK.team){
				canvas_main.fillStyle = "#d9ce00";
				hp_height = 3;
				var gap = 3*(t+1);
				canvas_main.fillRect(xx+padding_left, yy+padding_top-gap-hp_height, length, hp_height);
				}
			break;
			}
		};
	//tank name above
	this.add_player_name = function(tank){
		if(TYPES[tank.type].type != 'tank') return false;
		var xx = round(tank.x+map_offset[0]);
		var yy = round(tank.y+map_offset[1]);
		var name_padding = 20;
		var flag_gap = 0;
		var show_flag = true;
		var player_name = tank.name.substring(0, 10);	
		
		if(game_mode == 'single_quick' || game_mode == 'multi_quick')
			player_name = player_name+" "+tank.level;
		
		
		if(tank.cache_name != undefined && tank.cache_name.value == player_name && 1 == 2){
			//read from cache
			canvas_main.drawImage(tank.cache_name.object, xx-name_padding, yy-25);	
			}
		else{	
			//create tmp
			var tmp_canvas = document.createElement('canvas');
			tmp_canvas.width = 100;
			tmp_canvas.height = 100;
			var tmp_object = tmp_canvas.getContext("2d");
			var name_pos_x = round(TYPES[tank.type].size[1]/2) + name_padding;
			
			//flag
			if(show_flag == true){
				flag_gap = 4;
				var total_width = UNITS.flag_width + flag_gap + tmp_object.measureText(player_name).width;
				var name_pos_x = name_pos_x - round(total_width/2);
				if(name_pos_x < 0) name_pos_x = 0;		
				DRAW.draw_image(tmp_object, COUNTRIES[tank.nation].file, name_pos_x, 4);
				var name_pos_x = name_pos_x + UNITS.flag_width + flag_gap;
				}
			
			//name
			tmp_object.fillStyle = "#000000";
			tmp_object.font = "normal 9px Verdana";
			tmp_object.fillText(player_name, name_pos_x, 12);
			
			//save to cache
			tank.cache_name = [];
			tank.cache_name.object = tmp_canvas;
			tank.cache_name.value = player_name;
			
			//show
			canvas_main.drawImage(tmp_canvas, xx-name_padding, yy-25);
			}
		};
	//controlls bullet
	this.draw_bullets = function(TANK, time_gap){
		for (b = 0; b < BULLETS.length; b++){
			if(BULLETS[b].bullet_from_target.id != TANK.id) continue; // bullet from another tank
			
			TANK.last_bullet_time = Date.now();
			//follows tank
			if(BULLETS[b].bullet_to_target != undefined){
				var bullet_to_target_tank_size_to_w = TYPES[BULLETS[b].bullet_to_target.type].size[1];
				var bullet_to_target_tank_size_to_h = TYPES[BULLETS[b].bullet_to_target.type].size[2];
				b_dist_x = (BULLETS[b].bullet_to_target.x+(bullet_to_target_tank_size_to_w/2)) - BULLETS[b].x;
	  			b_dist_y = (BULLETS[b].bullet_to_target.y+(bullet_to_target_tank_size_to_h/2)) - BULLETS[b].y; 
	  			}
	  		else if(BULLETS[b].bullet_to_area != undefined){
	  			//bullet with coordinates instead of target
				b_dist_x = BULLETS[b].bullet_to_area[0] - BULLETS[b].x;
	  			b_dist_y = BULLETS[b].bullet_to_area[1] - BULLETS[b].y; 
	  			}
	  		else{
	  			console.log('Error: bullet without target');
	  			continue;
	  			}										
			//bullet details
			b_distance = Math.sqrt((b_dist_x*b_dist_x)+(b_dist_y*b_dist_y));
			b_radiance = Math.atan2(b_dist_y, b_dist_x); 
			var bullet = UNITS.get_bullet(TYPES[TANK.type].bullet);	//default tank type
			if(BULLETS[b].bullet_icon != undefined)
				var bullet = UNITS.get_bullet(BULLETS[b].bullet_icon);	//custom bullet
			if(bullet !== false)
				bullet_speed_tmp = MAIN.speed2pixels(bullet.speed, time_gap);
			else{
				if(TYPES[TANK.type].aoe != undefined)
					bullet_speed_tmp = 1000;	//aoe - instant
				else{
					console.log("Error: missing bullet stats for "+TANK.id+" in DRAW.draw_main()");	//error
					}
				}
			if(BULLETS[b].instant_bullet == 1)
				bullet_speed_tmp = 1000;	//force
			BULLETS[b].x += Math.cos(b_radiance)*bullet_speed_tmp;
			BULLETS[b].y += Math.sin(b_radiance)*bullet_speed_tmp;	
			if(b_distance < bullet_speed_tmp || bullet_speed_tmp=='0'){
				//do damage
				if(BULLETS[b].bullet_to_target != undefined){
					//find target
					var bullet_target = UNITS.get_tank_by_id(BULLETS[b].bullet_to_target.id);
					//calc damage
					if(bullet_target !== false){
						UNITS.do_damage(TANK, bullet_target, BULLETS[b]);
								
						//extra effects for non tower
						if(bullet_target.team != TANK.team && TYPES[bullet_target.type].type!='building'){
							//stun
							if(BULLETS[b].stun_effect != undefined){
								bullet_target.stun = Date.now() + BULLETS[b].stun_effect;
								bullet_target.buffs.push({
									lifetime: Date.now() + BULLETS[b].stun_effect,
									icon: 'error',
									});
								}
							//slow
							if(BULLETS[b].slow_debuff != undefined){
								bullet_target.buffs.push({
									name: BULLETS[b].slow_debuff.name,
									power: BULLETS[b].slow_debuff.power,
									lifetime: Date.now()+BULLETS[b].slow_debuff.duration,
									});
								}
							}
						}
					}								
				//aoe hit
				if(BULLETS[b].aoe_effect != undefined){
					//check tanks
					for (var ii=0; ii < TANKS.length; ii++){
						if(TANKS[ii].team == TANK.team && BULLETS[b].damage_all_teams == undefined)
							continue; //friend
						if(BULLETS[b].ignore_planes != undefined && TYPES[TANKS[ii].type].no_collisions != undefined)
							continue;	//flying units
						
						//check range
						var enemy_x = BULLETS[b].bullet_to_area[0];
						var enemy_y = BULLETS[b].bullet_to_area[1];
						dist_x_b = TANKS[ii].cx() - enemy_x;
						dist_y_b = TANKS[ii].cy() - enemy_y;
						var distance_b = Math.sqrt((dist_x_b*dist_x_b)+(dist_y_b*dist_y_b));
						distance_b = distance_b - TANKS[ii].width()/2;
								
						if(distance_b > BULLETS[b].aoe_splash_range)	continue;	//too far
						
						//stun
						if(BULLETS[b].stun_effect != undefined && TYPES[TANKS[ii].type].type!='building'){
							TANKS[ii].stun = Date.now() + BULLETS[b].stun_effect;
							TANKS[ii].buffs.push({
								lifetime: Date.now() + BULLETS[b].stun_effect,
								icon: 'error',
								});
							}
						
						//do damage
						if(game_mode == 'single_quick' || game_mode == 'single_craft'){
							var response = UNITS.do_damage(TANK, TANKS[ii], BULLETS[b]);	
							if(response === true)
								ii--;	//tank dead and removed from array, must repeat	}
							}
						else if(UNITS.check_if_broadcast(TANK)==true){	//angle, damage, instant_bullet, pierce_armor]
							var bpierce = BULLETS[b].pierce_armor;
							if(bpierce == undefined) bpierce = false;
							MP.send_packet('bullet', [TANKS[ii].id, TANK.id, 0, BULLETS[b].damage, true, bpierce, TANK.x, TANK.y]);
							}
						}
					
					//check mines
					var mine_size_half = 8;
					for(var m=0; m < MINES.length; m++){
						var size = BULLETS[b].aoe_splash_range;
						if(BULLETS[b].x + size > MINES[m].x-mine_size_half && BULLETS[b].x - size < MINES[m].x+mine_size_half){
							if(BULLETS[b].y + size > MINES[m].y-mine_size_half && BULLETS[b].y - size < MINES[m].y+mine_size_half){
								//explode
								var tank = UNITS.get_tank_by_id(TANK.id);
								var tmp = new Array();
								tmp['x'] = MINES[m].x;
								tmp['y'] = MINES[m].y;
								tmp['bullet_to_area'] = [MINES[m].x, MINES[m].y];
								tmp['bullet_from_target'] = TANK;
								tmp['aoe_effect'] = 1;
								tmp['damage_all_teams'] = 1;
								tmp['ignore_planes'] = 1;
								tmp['aoe_splash_range'] = MINES[m].splash_range;
								tmp['damage'] =  MINES[m].damage;
								BULLETS.push(tmp);
					
								//delete mine
								MINES.splice(m, 1); m--;
								break;
								}
							}
						}
					
					//animation
					TANK.animations.push({
						name: 'explosion',
						x: BULLETS[b].x-25+map_offset[0],
						y: BULLETS[b].y-25+map_offset[1],
						lifetime: Date.now() + 500,
						duration: 500,	
						});
					}
				
				//remove bullet
				BULLETS.splice(b, 1); b--;	//must be done after splice
				}
			else{
				//draw bullet
				if(BULLETS[b].bullet_icon != undefined){	
					//custom bullet
					var bullet_img = BULLETS[b].bullet_icon;
					bullet_stats = UNITS.get_bullet(BULLETS[b].bullet_icon);
					}
				else{	
					//default bullet
					var bullet_img = TYPES[TANK.type].bullet;
					bullet_stats = UNITS.get_bullet(TYPES[TANK.type].bullet);
					}
				if(TYPES[TANK.type].bullet==undefined) continue;
				bullet_x = BULLETS[b].x - round(bullet_stats.size[0]/2) + Math.round(map_offset[0]);
				bullet_y = BULLETS[b].y - round(bullet_stats.size[1]/2) + Math.round(map_offset[1]);
				if((game_mode == 'multi_quick' || game_mode == 'multi_craft') && BULLETS[b].bullet_from_target.team != MY_TANK.team && BULLETS[b].bullet_from_target.invisibility == 1)
					continue; //invisibility for bullets also
				//draw bullet
				if(bullet_stats.rotate == true){
					//advanced - rotate
					var padding = 20;
					if(BULLETS[b].bullet_cache != undefined){
						//read from cache
						canvas_main.drawImage(BULLETS[b].bullet_cache, bullet_x-padding, bullet_y-padding);
						}
					else{
						//create tmp
						var tmp_canvas = document.createElement('canvas');
						tmp_canvas.width = bullet_stats.size[0]*2+padding;
						tmp_canvas.height = bullet_stats.size[1]*2+padding;
						var tmp_object = tmp_canvas.getContext("2d");
						tmp_object.save();
						
						//add data
						tmp_object.translate(round(bullet_stats.size[0]/2)+padding, round(bullet_stats.size[1]/2)+padding);
						tmp_object.rotate((BULLETS[b].angle) * TO_RADIANS);
						tmp_object.drawImage(MAIN.IMAGES_BULLETS, 
							IMAGES_SETTINGS.bullets[bullet_img].x, IMAGES_SETTINGS.bullets[bullet_img].y, 
							IMAGES_SETTINGS.bullets[bullet_img].w, IMAGES_SETTINGS.bullets[bullet_img].h,
							-(bullet_stats.size[0]/2), -(bullet_stats.size[1]/2), bullet_stats.size[0], bullet_stats.size[1]);
						
						//save to cache
						BULLETS[b].bullet_cache = tmp_canvas;
						
						//show
						canvas_main.drawImage(tmp_canvas, bullet_x, bullet_y);
						}
					}
				else{
					//simple - no rotate
					DRAW.draw_image(canvas_main, bullet_img, bullet_x, bullet_y);
					}
				}
			}
		};
	this.prepare_tank_move = function(tank){
		delete tank.try_missile;
		delete tank.try_bomb;
		delete tank.try_jump;
		delete tank.try_construct;
		delete tank.target_move_lock;
		};
	//tank move rgistration and graphics
	this.draw_tank_move = function(mouseX, mouseY){
		var ns = UNITS.get_selected_count(MY_TANK.team);
		//remove some handlers
		UNITS.prepare_tank_move(MY_TANK);
		if(game_mode == 'single_craft' || game_mode == 'multi_craft'){
			for(var s in TANKS){
				if(TANKS[s].team != MY_TANK.team) continue;
				if(TANKS[s].selected != 1) continue;
				UNITS.prepare_tank_move(TANKS[s]);
				}
			}
		
		if(MY_TANK.death_respan != undefined) return false;
			
		//check clicks
		var found_something = false;
		target_lock_id = 0;
		if(MY_TANK.respan_time == undefined || (game_mode == 'single_craft' || game_mode == 'multi_craft')){
			for(var i in TANKS){
				var tank_size_w =  0.9*TANKS[i].width();
				var tank_size_h =  0.9*TANKS[i].height();
				//click on enemies
				if(Math.abs(TANKS[i].cx() - mouseX) < tank_size_w/2 && Math.abs(TANKS[i].cy() - mouseY) < tank_size_h/2){
					//if clicked on enemy
					if(TANKS[i].team != MY_TANK.team){
						TANKS[i].clicked_on = 10;	//will draw circle on enemy
						
						//check occupy
						if(ns == 1 && MY_TANK.data.name == 'Mechanic' && TANKS[i].data.type == 'building' && TANKS[i].data.name != 'Base'){
							SKILLS.register_occupy(MY_TANK.id, TANKS[i].id, false);
							return false;
							}
						
						if(game_mode == 'single_quick' || game_mode == 'multi_quick'){
							MY_TANK.target_move_lock = TANKS[i].id;
							MY_TANK.target_shoot_lock = TANKS[i].id;
							}
						else{
							if(game_mode == 'single_craft'){
								for(var s in TANKS){
									if(TANKS[s].team != MY_TANK.team) continue;
									if(TANKS[s].dead == 1) continue;
									if(TANKS[s].selected == 1){
										TANKS[s].target_move_lock = TANKS[i].id;
										TANKS[s].target_shoot_lock = TANKS[i].id;
										}
									}
								}
							}
						target_lock_id = TANKS[i].id;
						found_something = true;
						break;
						}
					//if clicked on allies
					else{
						//check constructions
						if(ns == 1 && MY_TANK.data.name == 'Mechanic' && TANKS[i].constructing != undefined){
							TANKS[i].clicked_on = 10;
							SKILLS.register_build(MY_TANK.id, TANKS[i].id, false);
							return false;
							}
						//check repair
						var max_hp = UNITS.get_tank_max_hp(TANKS[i]);
						if(ns == 1 && MY_TANK.data.name == 'Mechanic' && TANKS[i].hp < max_hp){
							TANKS[i].clicked_on = 10;
							SKILLS.register_repair(MY_TANK.id, TANKS[i].id, false);
							return false;
							}
						}
					}
				}
			}
		//ok, lets show where was clicked
		if(found_something==false)
			MY_TANK.clicked = [mouseX,mouseY, 15];
	
		mouseX = mouseX-MY_TANK.width()/2;	
		mouseY = mouseY-MY_TANK.height()/2;
		mouseX = Math.floor(mouseX);
		mouseY = Math.floor(mouseY);
		
		//register
		if(game_mode == 'multi_quick' || game_mode == 'multi_craft'){
			if(found_something==true && game_mode != 'multi_craft'){
				var params = [
					{key: 'target_move_lock', value: target_lock_id	},
					{key: 'target_shoot_lock', value: target_lock_id },
					];
				MP.send_packet('tank_update', [MY_TANK.id, params]);
				}
			else{
				if(game_mode == 'multi_quick')
					MP.register_tank_action('move', opened_room_id, MY_TANK.id, [round(MY_TANK.x), round(MY_TANK.y), round(mouseX), round(mouseY)]);
				else{
					var selected_tanks = UNITS.get_selected_tanks(MY_TANK.team);
					if(selected_tanks.length > 0){
						if(found_something==true)
							MP.send_packet('tank_move', [opened_room_id, selected_tanks, [round(MY_TANK.x), round(MY_TANK.y), round(mouseX), round(mouseY), target_lock_id]]);
						else
							MP.send_packet('tank_move', [opened_room_id, selected_tanks, [round(MY_TANK.x), round(MY_TANK.y), round(mouseX), round(mouseY)]]);
						}
					}
				}
			return false;
			}
		else{
			if(found_something==false){
				if(game_mode == 'single_craft')
					UNITS.calc_new_position(MY_TANK.team, mouseX, mouseY);
				else{
					MY_TANK.move = 1;
					MY_TANK.move_to = [mouseX, mouseY];
					}
				}
			
			if(MUTE_FX==false){
				try{
					audio_finish = document.createElement('audio');
					audio_finish.setAttribute('src', '../sounds/click'+SOUND_EXT);
					audio_finish.volume = FX_VOLUME;
					audio_finish.play();
					}
				catch(error){}
				}
			}
		};
	//returns array of selected war units, only in craft mode
	this.get_selected_tanks = function(team){
		var data = [];
		for(var i in TANKS){
			if(TANKS[i].team != team) continue;
			if(TANKS[i].data.type == "building") continue;
			if(TANKS[i].selected == undefined) continue;
			data.push(TANKS[i].id);
			}
		return data;
		};
	//check collisions
	this.check_collisions = function(xx, yy, TANK, full_check, debug){
		if(full_check == undefined && TYPES[TANK.type].no_collisions != undefined) return false;
		if(TANK.automove != undefined && TANK.data.name == 'Soldier') return false;
		xx = Math.round(xx);
		yy = Math.round(yy);
	
		//borders
		if(xx < 0 || yy < 0) return true;
		if(xx > WIDTH_MAP || yy > HEIGHT_MAP) return true;
		
		//elements
		for(var e in MAPS[level-1].elements){
			if(game_mode == 'single_craft' && TANK.use_AI != undefined && TANK.data.name == 'Mechanic') continue; //ai mechanic can go through everything
			if(game_mode == 'single_craft' && TANK.use_AI != undefined && TANK.data.name == 'Soldier') continue; //ai soldiers can go through walls
			
			var element = MAP.get_element_by_name(MAPS[level-1].elements[e][0]);
			if(element.collission == false) continue;	
			var elem_width = IMAGES_SETTINGS.elements[element.name].w;
			var elem_height = IMAGES_SETTINGS.elements[element.name].h;
			var elem_x = MAPS[level-1].elements[e][1];
			var elem_y = MAPS[level-1].elements[e][2];
			if(elem_width<30)	elem_x = elem_x - round(elem_width/2);
			if(elem_height<30)	elem_y = elem_y - round(elem_height/2);
			if(MAPS[level-1].elements[e][3]!=0 && MAPS[level-1].elements[e][3] < elem_width)
				elem_width = MAPS[level-1].elements[e][3];
			if(MAPS[level-1].elements[e][4]!=0 && MAPS[level-1].elements[e][4] < elem_height)
				elem_height = MAPS[level-1].elements[e][4];
			//check
			if(yy >= elem_y && yy <= elem_y+elem_height){
				if(xx >= elem_x && xx <= elem_x+elem_width){
					return true;
					}
				}
			}
	
		//other tanks
		if(TYPES[TANK.type].types != 'building'){
			for (i in TANKS){
				if(TANKS[i].id == TANK.id) continue;			//same tank
				if((game_mode == 'single_craft' || game_mode == 'multi_craft') && full_check == undefined && TYPES[TANKS[i].type].type != 'building __disabled__') continue;
				if(full_check == undefined && TANK.use_AI == true && TANK.team == TANKS[i].team && TYPES[TANKS[i].type].type != 'building') continue;
				if(full_check == undefined && TYPES[TANKS[i].type].no_collisions != undefined) continue;	//flying units
				if(TYPES[TANK.type].type == 'tank' && TYPES[TANKS[i].type].type == 'human') continue;	//tanks can go over soldiers
				if(TYPES[TANK.type].type == 'human' && TYPES[TANKS[i].type].type == 'tank') continue;	//soldiers can go over tanks, why? see above
				if(TYPES[TANK.type].type == 'human' && TYPES[TANKS[i].type].type == 'human') continue;	//soldier can go over soldiers ...
				if(TYPES[TANK.type].name == 'Silo' && TYPES[TANKS[i].type].type != 'building') continue;	//Mechanic can craft over others
				if(TANK.use_AI != undefined && TANKS[i].data.name == 'Tower' && MAPS[level-1].name != 'Hell') continue; //ai can go through towers
				if(TANKS[i].dead == 1) continue;		//tank dead
				
				var size2_w = TANKS[i].width();
				var size2_h = TANKS[i].height();
				if(TYPES[TANKS[i].type].type == 'human'){	//soldiers small	
					size2_w = round(size2_w/2);	
					size2_h = round(size2_h/2);
					}
				if(xx > TANKS[i].x && xx < TANKS[i].x+size2_w){
					if(yy > TANKS[i].y && yy < TANKS[i].y+size2_h){
						return true;
						}
					}
				}
			}
		
		return false;
		};
	this.calc_new_position = function(team, xx, yy){
		var bsize = 40;
		var ns = UNITS.get_selected_count(team);
		
		//5x5 cube positions
		var dx = [0,-1, 1,  -1, 0, 1,-1, 0, 1,  -2,-2,-2, 2, 2, 2,  -2,-1, 0, 1, 2,  -2,-1, 0, 1, 2];
		var dy = [0, 0, 0,  -1,-1,-1, 1, 1, 1,  -1, 0, 1,-1, 0, 1,  -2,-2,-2,-2,-2,   2, 2, 2, 2, 2];
		
		var j = 0;
		for(var i in TANKS){
			if(TANKS[i].team != team) continue;
			if(TANKS[i].dead == 1) continue;
			if(TANKS[i].selected == undefined) continue;
			if(TANKS[i].data.speed == 0) continue;
			
			new_x = xx + bsize * dx[j];
			new_y = yy + bsize * dy[j];
			
			if(j >= dx.length){
				//no more positions? randomize
				new_x = xx + HELPER.getRandomInt(-bsize*2, bsize*2);
				new_y = yy + HELPER.getRandomInt(-bsize*2, bsize*2);
				}
			
			TANKS[i].move = 1;
			TANKS[i].move_to = [new_x, new_y];
			j++;
			
			//cancel some extra actions
			if(TANKS[i].do_construct != undefined)	SKILLS.cancel_build(TANKS[i]);
			if(TANKS[i].do_repair != undefined)	SKILLS.cancel_repair(TANKS[i]);
			if(TANKS[i].do_occupy != undefined)	SKILLS.cancel_occupy(TANKS[i]);
			}
		};
	//checks tanks levels
	this.tank_level_handler = function(){		//once per second
		if(game_mode == 'single_craft' || game_mode == 'multi_craft'){
			//update silo
			var valid = false;
			for(var i=0; i < TANKS.length; i++){
				var nation = UNITS.get_nation_by_team(TANKS[i].team);
				if(TYPES[TANKS[i].type].name != 'Silo') continue;
				if(TANKS[i].constructing != undefined) continue;
				if(TANKS[i].crystal == undefined) continue;
				//if not empty
				if(TANKS[i].crystal.power > 0){
					TANKS[i].crystal.power = TANKS[i].crystal.power - SILO_POWER;
					UNITS.player_data[nation].he3 += SILO_POWER;
					UNITS.player_data[nation].total_he3 += SILO_POWER;
					}
				else{
					//relink
					found = false;
					for(var c in MAP_CRYSTALS){
						var dist_x = MAP_CRYSTALS[c].cx - TANKS[i].cx();
						var dist_y = MAP_CRYSTALS[c].cy - TANKS[i].cy();
						var distance = Math.sqrt((dist_x*dist_x)+(dist_y*dist_y));
						if(distance < CRYSTAL_RANGE && MAP_CRYSTALS[c].power > 0){
							TANKS[i].crystal = MAP_CRYSTALS[c];
							found = true;
							break;
							}
						}
					if(found == false)
						delete TANKS[i].crystal;
					//redraw map
					MAP.draw_map(true);
					}
				}
			//constructions
			for(var i in TANKS){
				if(TANKS[i].data.name != 'Mechanic') continue;
				if(TANKS[i].do_construct == undefined) continue;
				TANK_to = UNITS.get_tank_by_id(TANKS[i].do_construct);
				if(TANK_to.constructing == undefined) continue;	
				TANK_to.constructing.time += 1000;	//like 1s
				if(TANK_to.constructing.time >= TANK_to.constructing.duration)
					SKILLS.cancel_build(TANKS[i]);
				}
			//repair
			for(var i in TANKS){
				if(TANKS[i].data.name != 'Mechanic') continue;
				if(TANKS[i].do_repair == undefined) continue;
				TANK_to = UNITS.get_tank_by_id(TANKS[i].do_repair);
				if(TANK_to.data.type != 'building') continue;
				
				TANK_to = UNITS.get_tank_by_id(TANKS[i].do_repair);
				var max_hp = UNITS.get_tank_max_hp(TANK_to);
				var skill_stats = SKILLS.Rebuild(undefined, undefined, true);
				
				//check he3
				var nation = UNITS.get_nation_by_team(TANKS[i].team);
				if(TANKS[i].team == MY_TANK.team && UNITS.player_data[nation].he3 < skill_stats.cost){
					SKILLS.cancel_repair(TANKS[i]);
					return false;
					}
				
				TANK_to.hp = TANK_to.hp + skill_stats.power;
				if(TANKS[i].team == MY_TANK.team)
					UNITS.player_data[nation].he3 -= skill_stats.cost;
	
				if(TANK_to.hp >= max_hp){
					TANK_to.hp = max_hp;
					SKILLS.cancel_repair(TANKS[i]);
					}
				}
			//occupy
			for(var i in TANKS){
				if(TANKS[i].data.name != 'Mechanic') continue;
				if(TANKS[i].do_occupy == undefined) continue;
				TANK_to = UNITS.get_tank_by_id(TANKS[i].do_occupy);
				if(TANK_to.data.type != 'building') continue;
				
				TANKS[i].occupy_progress -= 1000;
				
				if(TANKS[i].occupy_progress <= 0){
					TANK_to.team = TANKS[i].team;
					SKILLS.cancel_occupy(TANKS[i]);
					}
				}
			
			return false;
			}
		
		//check level-up
		for (i in TANKS){
			if(TYPES[TANKS[i].type].type == 'building') continue;
			if(TYPES[TANKS[i].type].type == 'human') continue;
			if((game_mode == 'multi_quick' || game_mode == 'multi_craft') && TANKS[i].id != MY_TANK.id)	continue;	//not our business
			if(TANKS[i].dead == 1)	continue; //dead
			
			last_level = TANKS[i].level;
			var tank_level_up_time = LEVEL_UP_TIME;
			tank_level_up_time = UNITS.apply_buff(TANKS[i], 'level_up', tank_level_up_time);
			
			//calc level
			time_diff = (Date.now() - TANKS[i].begin_time)/1000 - TANKS[i].death_time + TANKS[i].bullets * TYPES[TANKS[i].type].attack_delay;
			
			TANKS[i].level = Math.ceil(time_diff/tank_level_up_time);	
			TANKS[i].sublevel = round(time_diff/tank_level_up_time*100) - TANKS[i].level*100 + 100;	
			
			//do level changes	
			if(TANKS[i].level != last_level){				//lvl changed
				if(game_mode == 'single_quick' || game_mode == 'single_craft'){
					TANKS[i].score = TANKS[i].score + SCORES_INFO[0]*(TANKS[i].level-last_level);	// +25 for 1 lvl
					}
				INFOBAR.redraw_tank_stats();
				
				//ability level-up
				var ability_nr = UNITS.get_ability_to_ugrade(MY_TANK);
				if(game_mode == 'single_quick' || game_mode == 'single_craft'){
					TANKS[i].abilities_lvl[ability_nr]++;
					}
				else
					MP.register_tank_action('level_up', opened_room_id, TANKS[i].id, TANKS[i].level, ability_nr);
				if(TANKS[i].id == MY_TANK.id)
					INFOBAR.draw_tank_abilities();
					
				//update passive abilites
				for(a in TYPES[TANKS[i].type].abilities){ 
					if(game_mode == 'multi_quick' || game_mode == 'multi_craft') continue;
					if(TYPES[TANKS[i].type].abilities[a].passive == false) continue;
					var nr = 1+parseInt(a);
					var ability_function = TYPES[TANKS[i].type].abilities[a].name.replace(/ /g,'_');
					if(ability_function != undefined){
						try{
							SKILLS[ability_function](TANKS[i]);
							}
						catch(err){console.log("Error: "+err.message);}
						}
					}
				}
			}
		};
	//checks tanks hp regen
	this.level_hp_regen_handler = function(){		//once per 1 second - 2.2%/s
		for (i in TANKS){
			if(TANKS[i].dead == 1 || TANKS[i].data.type == 'building') continue;
			var max_hp = UNITS.get_tank_max_hp(TANKS[i]);
			//passive hp regain - 2.2%/s
			var extra_hp = round(max_hp * 2.2 / 100);
			if(TANKS[i].hp < max_hp){
				TANKS[i].hp = TANKS[i].hp + extra_hp;
				if(TANKS[i].hp > max_hp)
					TANKS[i].hp = max_hp;
				}
			//healing
			for (j in TANKS[i].buffs){
				if(TANKS[i].buffs[j].name == 'repair'){
					if(TANKS[i].hp+TANKS[i].buffs[j].power < max_hp)
						TANKS[i].hp = TANKS[i].hp + TANKS[i].buffs[j].power;
					else if(TANKS[i].hp+TANKS[i].buffs[j].power >= max_hp)
						TANKS[i].hp = max_hp;
					}
				}
			}
		INFOBAR.draw_infobar();
		};
	this.get_ability_to_ugrade = function(TANK){
		var nr = 0;
		if(TYPES[TANK.type].abilities.length == 0) return false; //if no abilities
		if(ABILITIES_MODE != 0)
			nr = ABILITIES_MODE-1;
		if(ABILITIES_MODE == 0 || TANK.abilities_lvl[nr]==MAX_ABILITY_LEVEL){
			//find lowest
			if(TANK.abilities_lvl[0] < TANK.abilities_lvl[nr])
				nr = 0;
			if(TANK.abilities_lvl[1] < TANK.abilities_lvl[nr])
				nr = 1;
			if(TANK.abilities_lvl[2] < TANK.abilities_lvl[nr])
				nr = 2;
			}
		if(TANK.abilities_lvl[nr]==MAX_ABILITY_LEVEL)
			return false;		
		else
			return nr;
		};
	//scout enemies buildings
	this.scout_enemies_buildings = function(TANK){		
		if(game_mode == 'single_quick' || game_mode == 'multi_quick') return false;	
		if(TANK.skip_scout != undefined) return false; //both dont move - already parsed
		
		for (i in TANKS){				
			if(TANKS[i].team == TANK.team)	continue;	//same team
			if(TANKS[i].data.type != 'building') continue;	//not building
			if(TANKS[i].scouted == true) continue;	//already scouted
	
			distance = UNITS.get_distance_between_tanks(TANKS[i], TANK);
			distance = distance + TANK.width()/2;
			if(distance > TANK.sight) continue; //too far
			
			//range ok
			TANKS[i].scouted = true;
			}
		if(TANK.data.type == 'building' && TANK.constructing == undefined)
			TANK.skip_scout = 1;
		};
	//actions on enemies
	this.check_enemies = function(TANK){
		if(TANK.dead == 1) return false; //dead
		if(TANK.constructing != undefined) return false; //still not ready
		if(TANK.do_construct != undefined) return false; //constructing
		if(TANK.do_repair != undefined) return false; //repairing
		if(TANK.do_occupy != undefined) return false; //on occupy
		if(TANK.stun != undefined) return false; //stuned
	
		if(TANK.hit_reuse == undefined){
			var hit_reuse = TANK.data.attack_delay*1000;
			hit_reuse = UNITS.apply_buff(TANK, 'hit_reuse', hit_reuse);
			TANK.hit_reuse = hit_reuse + Date.now();
			}		
		if(TANK.check_enemies_reuse == undefined) TANK.check_enemies_reuse = 0;
		if(TANK.check_enemies_reuse > Date.now())
			return false;				//enemies check reuse
		UNITS.scout_enemies_buildings(TANK);	
		if(TANK.data.damage[0] == 0) return false;	//not war unit, no more check
		if(TANK.hit_reuse - Date.now() > 0)
			return false;				//hit reuse, must wait 1s-2s
			
		if((game_mode == 'multi_quick' || game_mode == 'multi_craft') && UNITS.check_if_broadcast(TANK)==false) 
			return false; //not our business
			
		range = TYPES[TANK.type].range;
		var found = false;
		var tank_size_from_w = TANK.width()/2;
		var tank_size_from_h = TANK.height()/2;
		
		//check if target_lock
		var i_locked = false;
		if(TANK.target_shoot_lock != undefined){
			for(var t in TANKS){
				if(TANKS[t].id == TANK.target_shoot_lock)
					i_locked = t;
				} 
			if(i_locked===false)
				delete TANK.target_shoot_lock;
			}
		//target lock
		if(TYPES[TANK.type].aoe == undefined 
				&& i_locked !== false 
				&& TANKS[i_locked] != undefined
				&& TANKS[i_locked].dead != 1 
				&& TANKS[i_locked].invisibility != 1
				){
			i = i_locked;
			//exact range
			dist_x = TANKS[i].cx() - (TANK.cx());
			dist_y = TANKS[i].cy() - (TANK.cy());
			var radiance = Math.atan2(dist_y, dist_x);
			f_angle = (radiance*180.0)/Math.PI+90;
			
			distance = Math.sqrt((dist_x*dist_x)+(dist_y*dist_y));
			distance = distance - TANKS[i].width()/2 - tank_size_from_w;
			
			if(distance < range){
				UNITS.do_shoot(TANK, TANKS[i], f_angle);
				found = true;
				}
			}
			
		if(found==false){
			var ENEMY_NEAR;
			for (i in TANKS){				
				if(TANKS[i].team == TANK.team)	continue;	//same team
				if(TANKS[i].dead == 1)			continue;	//target dead
				if(TANK.target_shoot_lock != undefined && TANKS[i].id == TANK.target_shoot_lock){
					if(TYPES[TANK.type].aoe == undefined) continue;	//already checked above
					}
				if(TANKS[i].invisibility==1)		continue;	//blur mode
				
				//check
				distance = UNITS.get_distance_between_tanks(TANKS[i], TANK);
				if(distance > range)	continue;	//target too far
				
				//range ok
				if(ENEMY_NEAR==undefined)
					ENEMY_NEAR = [distance, i];
				else if(distance < ENEMY_NEAR[0])
					ENEMY_NEAR = [distance, i];
				}
			}	
		
		//single attack on closest enemy
		if(found==false && TYPES[TANK.type].aoe == undefined && ENEMY_NEAR != undefined){
			i = ENEMY_NEAR[1];
			
			//exact range
			dist_x = TANKS[i].cx() - (TANK.cx());
			dist_y = TANKS[i].cy() - (TANK.cy());
			var radiance = Math.atan2(dist_y, dist_x);
			f_angle = (radiance*180.0)/Math.PI+90;
			
			UNITS.do_shoot(TANK, TANKS[i], f_angle);
			found = true;
			}
		
		//aoe hits
		if(found==false && TYPES[TANK.type].aoe != undefined){
			var found_aoe_target = false;
			for (i in TANKS){	
				if(TANKS[i].team == TANK.team)
					continue;	//same team
				if(TANKS[i].dead == 1)
					continue;	//target dead
				if(TANK.target_shoot_lock != undefined && TANKS[i].id == TANK.target_shoot_lock){
					if(TYPES[TANK.type].aoe == undefined)
						continue;	//already checked above
					}
				
				//exact range
				dist_x = TANKS[i].cx() - (TANK.cx());
				dist_y = TANKS[i].cy() - (TANK.cy());
				distance = Math.sqrt((dist_x*dist_x)+(dist_y*dist_y));
				distance = distance - TANKS[i].width()/2 - tank_size_from_w;
				
				if(range < distance){	
					continue;	//target too far
					}
				
				//start shooting
				var radiance = Math.atan2(dist_y, dist_x);
				f_angle = (radiance*180.0)/Math.PI+90;
				
				UNITS.do_shoot(TANK, TANKS[i], f_angle, true);
				found = true;
				found_aoe_target = true;
				}
			if(found_aoe_target == true)
				UNITS.shoot_sound(TANK);
			}
		
		if(TANK.automove == 1){
			//soldiers stops for shooting
			if(found == true && TANK.move == 1)
				if(game_mode == 'single_quick' || game_mode == 'single_craft')
					TANK.move = 0;
				else{
					var room = ROOM.get_room_by_id(opened_room_id);
					if(room.host == name){
						var params = [
							{key: 'move', value: 0},
							];
						MP.send_packet('tank_update', [TANK.id, params]);
						}
					}
				
			//soldiers continue to move if no enemies
			if(found == false && TANK.move == 0)
				if(game_mode == 'single_quick' || game_mode == 'single_craft')
					TANK.move = 1;
				else{
					var room = ROOM.get_room_by_id(opened_room_id);
					if(room.host == name){
						var params = [
							{key: 'move', value: 1},
							];
						MP.send_packet('tank_update', [TANK.id, params]);
						}
					}
			}
			
		//if not found, do short pause till next search for enemies
		if(found == false){
			TANK.check_enemies_reuse = 1000/2 + Date.now();	//half second pause
			if(game_mode == 'single_quick' || game_mode == 'single_craft')
				delete TANK.attacking;
			else if(UNITS.check_if_broadcast(TANK)==true && TANK.attacking != undefined){
				var params = [
					{key: 'attacking', value: "delete"},
					];
				MP.send_packet('tank_update', [TANK.id, params]);
				}
			}
		};
	//bullet shoot
	this.do_shoot = function(TANK, TANK_TO, shoot_angle, aoe){
		if(game_mode == 'single_quick' || game_mode == 'single_craft')
			TANK.attacking = TANK_TO;
		if(game_mode == 'single_craft' || game_mode == 'multi_craft'){
			if(TYPES[TANK.type].attack_type == 'ground' && TYPES[TANK_TO.type].flying == true){
				//some units do not hit air units
				TANK.hit_reuse = Date.now() + 3600*1000;
				return false;
				}
			if(TYPES[TANK.type].attack_type == 'air' && TYPES[TANK_TO.type].flying == undefined){
				//some units do not hit ground units
				TANK.hit_reuse = Date.now() + 3600*1000;	
				return false;
				}
			}
		
		//check turret
		if(DRAW.body_rotation(TANK, "fire_angle", TANK.data.turn_speed, shoot_angle, time_gap)==false){
			if(game_mode == 'multi_quick' || game_mode == 'multi_craft'){
				if((TANK.attacking==undefined || TANK.attacking.id != TANK_TO.id) && UNITS.check_if_broadcast(TANK)==true && TANK.attacking_sig_wait == undefined){
					TANK.attacking_sig_wait = 1;
					var params = [
						{key: 'attacking', value: TANK_TO.id},
						];
					MP.send_packet('tank_update', [TANK.id, params]);
					}
				}
			return false;
			}
		//do
		if(game_mode == 'single_quick' || game_mode == 'single_craft'){
			var tmp = new Array();
			tmp['x'] = TANK.cx();
			tmp['y'] = TANK.cy();
			tmp['bullet_to_target'] = TANK_TO; 
			tmp['bullet_from_target'] = TANK;
			tmp['angle'] = round(shoot_angle);
			BULLETS.push(tmp);
			if(TYPES[TANK_TO.type].type != 'human') TANK.bullets++;
			
			if(aoe == undefined){
				UNITS.shoot_sound(TANK);
				UNITS.draw_fire(TANK, TANK_TO);
				}
			}
		else
			MP.send_packet('bullet', [TANK_TO.id, TANK.id, round(shoot_angle), false, false, false, TANK.x, TANK.y]);
		
		var hit_reuse = TANK.data.attack_delay * 1000;
		hit_reuse = UNITS.apply_buff(TANK, 'hit_reuse', hit_reuse);
		TANK.hit_reuse = hit_reuse + Date.now();	
		TANK.check_enemies_reuse = 0;
		};
	//draw tank shooting fire
	this.draw_fire = function(TANK, TANK_TO){
		if(TANK.invisibility==1) return false;
		
		//register animation
		var size = 5;
		if(TYPES[TANK.type].type == 'human')
			size = 3;
		//bullet animation
		TANK.animations.push({
			name: 'shoot',
			from_x: TANK.cx(),
			from_y: TANK.cy(),
			to_x: TANK_TO.cx(),
			to_y: TANK_TO.cy(),
			tank_from_size: TANK.width(),
			tank_to_size: TANK_TO.width(),
			lifetime: Date.now() + 200,
			duration: 200,
			size: size,
			});
		if(TYPES[TANK.type].type == 'human') return false;
		
		//register animation
		TANK.animations.push({
			name: 'fire',
			to_x: TANK_TO.cx(),
			to_y: TANK_TO.cy(),
			from_x: TANK.cx(),
			from_y: TANK.cy(),
			angle: TANK.fire_angle,
			lifetime: Date.now() + 150,
			duration: 150,
			});
		};
	//shooting
	this.shoot_sound = function(TANK){
		if(MUTE_FX==true) return false;
		if(TANK.id != MY_TANK.id) return false;
		if(TYPES[TANK.type].fire_sound == undefined) return false;
		try{
			var audio_fire = document.createElement('audio');
			audio_fire.setAttribute('src', '../sounds/'+TYPES[TANK.type].fire_sound+SOUND_EXT);
			audio_fire.volume = FX_VOLUME;
			audio_fire.play();
			}
		catch(error){}
		};
	//damage to other tank function
	this.do_damage = function(TANK, TANK_TO, BULLET){
		if(TANK_TO == undefined) return false;
		if(TANK_TO.dead == 1) return false;
		
		//sound	fire_sound - i was hit
		if(TANK_TO.id == MY_TANK.id && MUTE_FX==false){
			try{
				var audio_fire = document.createElement('audio');
				audio_fire.setAttribute('src', '../sounds/metal'+SOUND_EXT);
				audio_fire.volume = FX_VOLUME;
				audio_fire.play();
				}
			catch(error){}
			}	
		
		damage = TANK.data.damage[0] + TANK.data.damage[1]*(TANK.level-1);
		damage = UNITS.apply_buff(TANK, 'damage', damage);
		damage = damage * (100+COUNTRIES[TANK.nation].bonus.weapon)/100;
		if(BULLET.damage != undefined)
			damage = BULLET.damage;
			
		armor = TANK_TO.data.armor[0] + TANK_TO.data.armor[1]*(TANK_TO.level-1);
		if(armor > TYPES[TANK_TO.type].armor[2])
			armor = TYPES[TANK_TO.type].armor[2];
		armor = armor + COUNTRIES[TANK_TO.nation].bonus.armor;
		armor = UNITS.apply_buff(TANK_TO, 'shield', armor);
		if(armor > 100) armor = 100;
		if(armor < 0) armor = 0;
		
		//check armor_piercing
		armor = armor - TANK.pierce_armor;
		if(BULLET.pierce_armor != undefined)
			armor = armor - BULLET.pierce_armor;
		if(armor < 0) armor = 0;
		
		if(TYPES[TANK.type].ignore_armor != undefined)
			armor = 0;	//pierce armor
		
		damage = round( damage*(100-armor)/100 );
		
		if(TANK_TO.constructing != undefined)
			damage = damage*5;	//damage goes up if building still under construction
		
		//mines do less damage on ally building
		if(BULLET.damage_all_teams != undefined && TYPES[TANK_TO.type].type=="building" && BULLET.bullet_from_target.team == TANK_TO.team)
			damage = damage/2;
		
		//check invisibility
		if(TANK_TO.invisibility != undefined && BULLET.aoe_effect != undefined){
			if(game_mode == 'single_quick' || game_mode == 'single_craft')
				SKILLS.stop_camouflage(TANK_TO);
			else
				MP.send_packet('del_invisible', [TANK_TO.id]);
			}
	
		//stats
		if(TYPES[TANK_TO.type].name=="Tower" || TYPES[TANK_TO.type].name=="Base"){
			var max_hp_to = UNITS.get_tank_max_hp(TANK_TO);
			if(TANK.towers == undefined)
				TANK.towers = 0;
			var damage_at_tower = damage / max_hp_to;
			if(TANK_TO.hp < damage)
				damage_at_tower = TANK_TO.hp / max_hp_to;
			
			TANK.towers = TANK.towers + damage_at_tower;	
			TANK.score = TANK.score + SCORES_INFO[3] * (damage / max_hp_to);
			}
		TANK.damage_done = TANK.damage_done + damage;
		UNITS.player_data[TANK.nation].total_damage += damage;
		TANK_TO.damage_received = TANK_TO.damage_received + damage;
		TANK_TO.hit_stats = {
			id: TANK.id, 
			time: Date.now(),
			}
		
		life_total = TANK_TO.hp;
		if(life_total-damage>0){
			TANK_TO.hp = TANK_TO.hp - damage;
			if(TANK_TO.id == MY_TANK.id){
				INFOBAR.draw_infobar();
				}
			}
		//death	
		else{	
			//updates deaths
			if(game_mode == 'single_quick' || game_mode == 'single_craft'){
				TANK_TO.deaths = TANK_TO.deaths + 1;
				TANK_TO.score = TANK_TO.score + SCORES_INFO[2];
				}
			UNITS.check_game_end(TANK, TANK_TO);
			
			//find killer
			var killer = TANK;
			if(TANK.master != undefined){
				killer = TANK.master;
				}
			UNITS.player_data[TANK.nation].kills += 1;
			if(TYPES[TANK_TO.type].no_repawn != undefined  || game_mode == 'single_craft' || game_mode == 'multi_craft'){	//tanks without repawn
				if(TYPES[TANK_TO.type].name == "Tower" && (game_mode == 'single_quick' || game_mode == 'single_craft')){
					//tower dead - decreasing base armor
					for(var b in TANKS){
						if(TYPES[TANKS[b].type].name == "Base" && TANKS[b].team == TANK_TO.team){
							//armor debuff
							TANKS[b].buffs.push({
								name: 'shield',
								type: 'static',
								power: -10,
								});
							}
						}
					}
				if(game_mode == 'multi_quick' || game_mode == 'multi_craft'){
					if(UNITS.check_if_broadcast(TANK)==true)
						MP.register_tank_action('kill', opened_room_id, killer.id, TANK_TO.id);
					}
				else{
					UNITS.check_selection(TANK_TO);
					//remove tank
					var del_index = false;
					for(var j=0; j < TANKS.length; j++){
						if(TANKS[j].id == TANK_TO.id){
							TANKS.splice(j, 1); j--;
							return true;
							}
						}
					}
				}
			else{ //tank with respawn
				//if tank
				if(TYPES[TANK_TO.type].type == 'tank'){
					//update kills
					if(game_mode == 'single_quick' || game_mode == 'single_craft'){
						killer.kills = killer.kills + 1;
						//add score
						TANK.score = TANK.score + SCORES_INFO[1];
						}
					}
				if((game_mode == 'multi_quick' || game_mode == 'multi_craft') && TYPES[TANK_TO.type].type != 'human'){
					if(UNITS.check_if_broadcast(TANK)==true)
						MP.register_tank_action('kill', opened_room_id, killer.id, TANK_TO.id);
					}
			
				//player death			
				if(game_mode == 'single_quick' || game_mode == 'single_craft')
					UNITS.death(TANK_TO);	
				}
			}
		return false;
		};
	this.check_game_end = function(TANK, TANK_TO){
		if(TYPES[TANK_TO.type].name != "Base") return false; //not base was killed
		
		//some team lost base at this point - check if we have another base
		for(var i in TANKS){
			if(TANKS[i].team != TANK_TO.team) continue; //other team
			if(TANKS[i].data.name != 'Base') continue; //not base
			//if(TANKS[i].constructing != undefined) continue; //base still constructing
			if(TANKS[i].id == TANK_TO.id) continue;	//this unit is already registered as dead ...
			
			return false;	//we found another base - no need to finish game
			}
		
		//sorry - game ends here
		if(game_mode == 'single_quick' || game_mode == 'single_craft'){
			DRAW.draw_final_score(false, TANK.team);
			}
		else
			MP.register_tank_action('end_game', opened_room_id, false, TANK.team);
		};
	//find and select other tank
	this.check_selection = function(TANK_TO){
		if((game_mode == 'single_craft' || game_mode == 'multi_craft') && TANK_TO.id == MY_TANK.id && TANK_TO.team == MY_TANK.team){
			//next selected
			for(var x in TANKS){
				if(TANKS[x].team != MY_TANK.team) continue;
				if(TANKS[x].selected == undefined) continue;
				if(TANKS[x].id == TANK_TO.id) continue; //must select other
				MY_TANK = TANKS[x];
				INFOBAR.draw_infobar();
				return false;
				}
			//base
			for(var x in TANKS){
				if(TANKS[x].team != MY_TANK.team) continue;
				if(TANKS[x].data.name != 'Base') continue;
				MY_TANK = TANKS[x];
				TANKS[x].selected = 1;
				INFOBAR.draw_infobar();
				return false;
				}
			}
		};
	//check if broadcast other tank shooting, kill
	this.check_if_broadcast = function(KILLER){
		var room = ROOM.get_room_by_id(opened_room_id);
		
		//me
		if(KILLER.name == name) return true;	
		
		//my unit
		if(game_mode == 'multi_craft' && KILLER.team == MY_TANK.team) return true;
		
		//only host broadcast tower/autobots actions
		if(room.host == name && (KILLER.data.type == 'building' || KILLER.automove == 1) ) return true; 
		
		//my soldier - me broadcast
		if(KILLER.master != undefined && KILLER.master.id == MY_TANK.id) return true; 
		
		return false;
		};
	//tank death
	this.death = function(tank){
		tank.hp = 0;
		tank.move = 0;
		tank.death_respan = 2*1000+Date.now();
		tank.dead = 1;	
		
		tank.abilities_reuse = [0, 0, 0];
		tank.abilities_reuse_max = [0, 0, 0];
		delete tank.target_move_lock;
		delete tank.target_shoot_lock;
		mouse_click_controll = false;			log('1685...death');
		target_range=0;	
		//removing short buffs
		for(var i=0; i < tank.buffs.length; i++){
			if(tank.buffs[i].lifetime != undefined){
				tank.buffs.splice(i, 1); i--;
				}
			}
		
		var respan_time;
		if(tank.level < 3)
			respan_time = 3*1000;	//minimum
		else
			respan_time = tank.level*1000;
		respan_time = UNITS.apply_buff(tank, 'respawn', respan_time);
		if(respan_time < 3*1000)
			respan_time = 3*1000;
		respan_time = respan_time + Date.now();
		tank.respan_time = respan_time;
		};
	//add towers to map
	this.add_towers = function(team, nation){
		for (var i in MAPS[level-1].towers){
			if(MAPS[level-1]['towers'][i][0] != team) continue;
			if((game_mode == 'single_craft' || game_mode == 'multi_craft') && MAPS[level-1].towers[i][3] == 'Tower') continue;
			//get type
			var type = '';
			for(var t in TYPES){
				if(TYPES[t].name == MAPS[level-1].towers[i][3]){ 
					type = t;
					break;
					}
				}
			if(type=='') alert('Error: wrong type "'+MAPS[level-1]['towers'][i][3]+'" in maps definition.');
			var width_tmp = WIDTH_MAP - TYPES[type].size[1];
			var height_tmp = HEIGHT_MAP - TYPES[type].size[2];
			var x;
			var y;
			if(MAPS[level-1]['towers'][i][1] == 'rand'){
				x = HELPER.getRandomInt(TYPES[type].size[1], WIDTH_MAP-TYPES[type].size[1]);
				}
			else
				x = MAPS[level-1]['towers'][i][1] - TYPES[type].size[1]/2;
			if(MAPS[level-1]['towers'][i][2] == 'rand'){
				y = HELPER.getRandomInt(TYPES[type].size[2], HEIGHT_MAP-TYPES[type].size[2]);
				}
			else
				y = MAPS[level-1]['towers'][i][2] - TYPES[type].size[2]/2;
			var angle = 180;
			if(team != 'B')
				angle = 0;
			//add
			UNITS.add_tank(1, TYPES[type].name+'-'+team+"."+x+"."+y, HELPER.generatePassword(6), type, team, nation, x, y, angle);
			}
		};
	this.get_nation_by_team = function(team){
		if(game_mode == 'single_quick' || game_mode == 'single_craft'){
			for(var i in TANKS){
				if(TANKS[i].team == team)
					return TANKS[i].nation;
				}
			}
		else{
			room = ROOM.get_room_by_id(opened_room_id);
			for(var p in room.players){
				if(room.players[p].team == team){
					return room.players[p].nation;
					}
				}
			if(team == 'B')
				return room.nation1;
			else if(team == 'R')
				return room.nation2;
			}
		log('Error: can not find nation.');
		};
	//do ability an all selected tanks
	this.do_abilities = function(nr, TANK){
		if(INFOBAR.check_abilities_visibility() == false) return false;		//few different tanks selected
		if(game_mode == 'single_quick' || game_mode == 'multi_quick')
			UNITS.do_ability(nr, TANK);
		else{
			//find all selected tanks
			var selected_n = UNITS.get_selected_count(TANK.team);
			if(selected_n == 0)
				return false;
			else if(selected_n == 1)
				UNITS.do_ability(nr, TANK);
			else{
				var ids = [];
				for(var i in TANKS){
					if(TANKS[i].team != TANK.team) continue;
					if(TANKS[i].selected == undefined) continue;
					if(TANKS[i].data.abilities[nr-1] == undefined) return false;
					if(TANKS[i].data.abilities[nr-1].passive == true) continue;
					if(TANKS[i].data.abilities[nr-1].broadcast == 2) continue;
					
					response = UNITS.do_ability(nr, TANKS[i], true); //here we have only 1 type of many tanks
					if(response === true)
						ids.push(TANKS[i].id);
					}
				if(ids.length > 0){
					MP.register_tank_action('skill_do', opened_room_id, ids, nr, HELPER.getRandomInt(1, 999999));
					}
				}
			}
		};
	//do ability on 1 tank	
	this.do_ability = function(nr, TANK, grouping){
		if(TANK.abilities_reuse[nr-1] > Date.now() ) return false;	//not ready yet
		if(TANK.dead == 1 || TANK.stun != undefined) return false; 	//dead or stuned
		if(TYPES[TANK.type].abilities[nr-1] == undefined) return false;	//no such ability
		if(TYPES[TANK.type].abilities[nr-1].passive == true) return false; //passive ability - nothing to execute
		
		var ability_function = TYPES[TANK.type].abilities[nr-1].name.replace(/ /g,'_');
		var broadcast_mode = TYPES[TANK.type].abilities[nr-1].broadcast;
		if(ability_function != undefined){
			if(game_mode == 'single_quick' || game_mode == 'single_craft'){
				//local ability
				var ability_reuse = SKILLS[ability_function](TANK); //exec here
				if(ability_reuse != undefined && ability_reuse != 0){
					TANK.abilities_reuse[nr-1] = Date.now() + ability_reuse;
					TANK.abilities_reuse_max[nr-1] = ability_reuse;
					}
				}
			else{ //broadcasting
				if(broadcast_mode==0){
					//local
					var ability_reuse = SKILLS[ability_function](TANK); //exec here
					if(ability_reuse != undefined && ability_reuse != 0){
						TANK.abilities_reuse[nr-1] = Date.now() + ability_reuse;
						TANK.abilities_reuse_max[nr-1] = ability_reuse;
						}
					}
				else if(broadcast_mode==1){
					var ability_reuse = SKILLS[ability_function](TANK, undefined, true);
					ability_reuse = ability_reuse.reuse;
					if(TANK.abilities_reuse[nr-1] > Date.now() ) return false; //last check
					TANK.abilities_reuse[nr-1] = Date.now() + ability_reuse;
					TANK.abilities_reuse_max[nr-1] = ability_reuse;
					
					//instant broadcast
					if(game_mode == 'multi_quick' || grouping == undefined)
						MP.register_tank_action('skill_do', opened_room_id, MY_TANK.id,  nr, HELPER.getRandomInt(1, 999999));
					else
						return true;	//just return to broadcast all together
					}
				else if(broadcast_mode==2){
					//no broadcast - do it later
					var ability_reuse = SKILLS[ability_function](TANK);
					}
				}
			}
		};
	//check if enemy visible
	this.check_enemy_visibility = function(tank){		
		if(TYPES[tank.type].type == 'building')
			return true;	//building
		if(tank.team==MY_TANK.team)
			return true;	//friend
		//wait for reuse
		if(tank.cache_scouted_reuse - Date.now() > 0)
			return tank.cache_scouted;	
		
		for (i in TANKS){
			if(TANKS[i].team == tank.team)	continue;	//same team
			if(TANKS[i].dead == 1)			continue;	//target dead
			if(TANKS[i].constructing != undefined) continue; //not ready
			
			//exact range
			distance = UNITS.get_distance_between_tanks(TANKS[i], tank);
			distance = distance + TANKS[i].width()/2;
			if(distance < TANKS[i].sight){
				tank.cache_scouted_reuse = 500+Date.now();
				tank.cache_scouted = true;
				return true;	//found by enemy
				}				
			}
		tank.cache_scouted_reuse = 500+Date.now();
		tank.cache_scouted = false;
		return false;
		};
	//returns tank by name
	this.get_tank_by_name = function(tank_name){
		for(var i in TANKS){
			if(TANKS[i].name == tank_name) return TANKS[i];
			}
		return false;
		};
	//returns tank by id
	this.get_tank_by_id = function(tank_id){
		for(var i in TANKS){
			if(TANKS[i].id == tank_id)	return TANKS[i];
			}
		return false;
		};
	this.get_unit_index = function(name){
		for(var i in TYPES){
			if(TYPES[i].name == name) return i;
			}
		};
	this.check_nation_tank = function(tank_name, nation){
		for(var x in COUNTRIES[nation].tanks_lock){
			if(COUNTRIES[nation].tanks_lock[x] == tank_name){
				return false;
				}
			}
		if(game_mode == 'single_craft' || game_mode == 'multi_craft'){
			for(var i in TYPES){
				if(TYPES[i].name == tank_name && TYPES[i].mode == 'quick')
					return false;	
				}
			}
		else{
			for(var i in TYPES){
				if(TYPES[i].name == tank_name && TYPES[i].mode == 'craft')
					return false;	
				}
			}
			
		return true;
		};
	//choose tanks on mirror/random
	this.choose_and_register_tanks = function(room){
		//get possible types
		var possible_types_ally = [];
		var possible_types_enemy = [];
		first_team = room.players[0].team;
		
		//first team possible types
		var nation = UNITS.get_nation_by_team(first_team);
		for(var t in TYPES){
			if(TYPES[t].type != 'tank') continue;
			if(UNITS.check_nation_tank(TYPES[t].name, nation)==false) continue;
			possible_types_ally.push(t);
			}
		
		//second team possible types
		nation = '';
		for(var p in room.players){
			if(room.players[p].team == first_team) continue;
			nation = UNITS.get_nation_by_team(room.players[p].team);
			break;
			}
		if(nation != ''){
			for(var t in TYPES){
				if(TYPES[t].type != 'tank') continue;
				if(UNITS.check_nation_tank(TYPES[t].name, nation)==false) continue;
				possible_types_enemy.push(t);
				}
			}
		
		//choose types
		if(room.settings[0]=='random'){
			first_team = room.players[0].team;
			//first team
			for(var p in room.players){
				if(room.players[p].team != first_team) continue;
				random_type = possible_types_ally[HELPER.getRandomInt(0, possible_types_ally.length-1)];//randomize
				//register
				MP.register_tank_action('change_tank', room.id, room.players[p].name, random_type, false);
				}
			//second team	
			for(var p in room.players){
				if(room.players[p].team == first_team) continue;
				random_type = possible_types_enemy[HELPER.getRandomInt(0, possible_types_enemy.length-1)];//randomize
				//register
				MP.register_tank_action('change_tank', room.id, room.players[p].name, random_type, false);
				}
			}
		else if(room.settings[0]=='mirror'){
			first_team = room.players[0].team;	
			selected_types = [];
			//first team
			for(var p in room.players){
				if(room.players[p].team != first_team) continue;
				random_type = possible_types_ally[HELPER.getRandomInt(0, possible_types_ally.length-1)];//randomize
				selected_types.push(random_type);
				//register
				MP.register_tank_action('change_tank', room.id, room.players[p].name, random_type, false);
				}
			//second team
			for(var p in room.players){
				if(room.players[p].team == first_team) continue;
				//get index
				random_type_i = HELPER.getRandomInt(0, selected_types.length-1);
				
				//register
				MP.register_tank_action('change_tank', room.id, room.players[p].name, selected_types[random_type_i], false);
	
				//remove selected type
				selected_types.splice(random_type_i, 1);  i--;
				}
			}
		};
	//returns bullet by filename
	this.get_bullet = function(filename){
		for(var i in BULLETS_TYPES){
			if(BULLETS_TYPES[i].file == filename){
				return BULLETS_TYPES[i];
				}
			}
		return false;
		};
	//returns tank by coordinates
	this.get_tank_by_coords = function(mouseX, mouseY, team, tank_from){
		for(var i in TANKS){
			var size_to_half_w = round(TANKS[i].width()/2);
			var size_to_half_h = round(TANKS[i].height()/2);
			if(team != undefined && TANKS[i].team != team) continue;
			if(Math.abs(TANKS[i].cx() - mouseX) < size_to_half_w && Math.abs(TANKS[i].cy() - mouseY) < size_to_half_h){
				distance = UNITS.get_distance_between_tanks(TANKS[i], tank_from);
				TANKS[i].tmp_range = distance;
				return TANKS[i];
				}
			}
		return false;
		};
	//returns distance bewteen 2 tanks - provide 2 tanks objects or ids
	//second object can be false, but then cx2, cy2 must be provided
	this.get_distance_between_tanks = function(id1, id2, cx2, cy2){	
		if(typeof id1 == 'object')
			tank1 = id1;
		else
			tank1 = UNITS.get_tank_by_id(id1);
		if(typeof id2 == 'object')
			tank2 = id2;
		else
			tank2 = UNITS.get_tank_by_id(id2);
		if(tank1===false) return 100000;
		if(tank2===false && id2 !== false && cx2 == undefined && cy2 == undefined) return 100000;
		if(id2 !== false && tank1.id == tank2.id) return 0;
		
		if(id2 === false){
			dist_x = tank1.cx() - cx2;
			dist_y = tank1.cy() - cy2;
			}
		else{
			dist_x = tank1.cx() - (tank2.cx());
			dist_y = tank1.cy() - (tank2.cy());
			}
		
		distance = Math.sqrt((dist_x*dist_x)+(dist_y*dist_y)); 		
		distance = distance - tank1.width()/2;
		if(id2 !== false)
			distance = distance - tank2.width()/2;
		distance = round(distance);
		if(distance<0) distance = 0;
		return distance;
		};
	//sync movement in network, if distance too far - fix it, else, ignore
	this.sync_movement = function(TANK, xx, yy, MAX_DIFFERENCE){
		if(TANK===false) return false;
		if(TYPES[TANK.type].type == 'building') return false;
		if(TANK.id != MY_TANK.id){
			//get distance
			dist_x = TANK.cx() - (xx + TANK.width()/2);
			dist_y = TANK.cy() - (yy + TANK.height()/2);
			distance = Math.sqrt((dist_x*dist_x)+(dist_y*dist_y));
			if(distance > MAX_DIFFERENCE){
				TANK.x = xx;
				TANK.y = yy;
				}
			}
		};
	this.get_tank_max_hp = function(TANK){
		var max_hp = TYPES[TANK.type].life[0] + TYPES[TANK.type].life[1] * (TANK.level-1);
		max_hp = UNITS.apply_buff(TANK, 'health', max_hp);
		max_hp = round(max_hp);
		return max_hp;
		};
	//add auto bots to map		['B',	30,	1,	[[5, 15],[20,41],[20,50],[20,59],[5,85], [45,99]]	],
	this.add_bots = function(random_id){
		if(PLACE != 'game') return false;
		var type_name = 'Soldier';	//unit name
		var n = 2;	//group size
		var gap = 15;	//gap beween units in group
	
		//prepare
		if(DEBUG == true && (game_mode == 'multi_quick' || game_mode == 'multi_craft')) return false;	//no need here
		if(game_mode == 'single_quick' || game_mode == 'single_craft')
			var random_id = Math.floor(Math.random()*9999999);
		if((game_mode == 'multi_quick' || game_mode == 'multi_craft') && random_id == undefined){
			room = ROOM.get_room_by_id(opened_room_id);
			if(room.host != MY_TANK.name)	return false;	//not me host
			//broadcast
			var random_id = Math.floor(Math.random()*9999999);
			MP.send_packet('summon_bots', [opened_room_id, random_id]);
			return false;
			}
		var type = 0;
		for(var t in TYPES){
			if(TYPES[t].name == type_name)
				type = t;
			}
		var width_tmp = WIDTH_MAP - TYPES[type].size[1];
		var height_tmp = HEIGHT_MAP - TYPES[type].size[2];
		
		var bot_nr = 0;
		for (i in MAPS[level-1].bots){
			team = MAPS[level-1].bots[i][0];
			var nation = UNITS.get_nation_by_team(team);
			angle = 0;
			if(team == 'B')
				angle = 180;
			//group
			for(var g = -1; g < n; g=g+2){
				id = TYPES[type].name+'-'+random_id+"-"+bot_nr;
				xx = Math.floor(MAPS[level-1].bots[i][1]*width_tmp/100) + g*gap;
				yy = Math.floor(MAPS[level-1].bots[i][2]*height_tmp/100);
				//add
				UNITS.add_tank(1, id, TYPES[type].name, type, team, nation, xx, yy, angle);
				//change
				TANK_added = UNITS.get_tank_by_id(id);
				TANK_added.automove = 1;	//will stop near enemies, and continue to move
				TANK_added.move = 1;
				TANK_added.move_to = [];
				for (j in MAPS[level-1].bots[i][3]){
					var move_to_tmp = new Array();
					move_to_tmp[0] = Math.floor(MAPS[level-1].bots[i][3][j][0]*width_tmp/100) + g*gap;
					move_to_tmp[1] = Math.floor(MAPS[level-1].bots[i][3][j][1]*height_tmp/100);
					TANK_added.move_to.push(move_to_tmp);
					}
				bot_nr++;
				}
			}
		};
	//check if invisible tank still invisible
	this.check_invisibility = function(TANK, force_check){
		for(var i in TANKS){
			if(TANKS[i].team == TANK.team) continue; //same team
			if(TANK.move == 0 && TANKS[i].move == 0 && force_check == undefined) continue; //no changes here
			var distance = UNITS.get_distance_between_tanks(TANKS[i], TANK);
			distance = distance + TANKS[i].width()/2;
			var min_range = TANKS[i].sight;
			
			//ranges
			if(TANKS[i].data.flying != undefined || TANKS[i].data.name == "Tower" 
				|| TANKS[i].data.name == "SAM_Tower" || TANKS[i].data.name == "Scout_Tower" || TANKS[i].data.name == "Base")
				{}	//has radar
			else
				min_range = INVISIBILITY_SPOT_RANGE * min_range / 100; //no radar - less range
			
			if(distance < min_range){	
				if(game_mode == 'multi_quick' || game_mode == 'multi_craft')
					MP.send_packet('del_invisible', [TANK.id]);
				else
					SKILLS.stop_camouflage(TANK);
				}
			}
		};
	this.apply_buff = function(TANK, buff_name, original_value){
		for(var b in TANK.buffs){
			if(TANK.buffs[b].name == undefined) continue;
			if(TANK.buffs[b].name == buff_name){
				if(TANK.buffs[b].type == 'static'){
					original_value = original_value + TANK.buffs[b].power;
					}
				else{
					original_value = original_value * TANK.buffs[b].power;
					original_value = round(original_value*100)/100;
					}
				}
			}
		if(original_value < 0) original_value = 0;
		return original_value;
		};
	this.set_spawn_coordinates = function(tank){
		var space = 35;
		var xx;
		var yy;
		var angle;
		if(tank.team=='B'){	//blue top
			yy = 20;
			angle = 180;
			}
		else{		//red bottom 
			yy = HEIGHT_MAP - 20 - tank.height();
			angle = 0;
			}
		
		center_x = round(WIDTH_MAP/2);
		var found = false;
		for(var i=1; i<20; i++){
			var min = center_x - 150 - i*10;
			var max = center_x + 150 + i*10;
			if(min < 50) min = 50;
			if(max > WIDTH_MAP-50) max = WIDTH_MAP-50;
			
			var x = HELPER.getRandomInt(min, max);	//random line
			if(UNITS.check_collisions(x, yy+tank.width()/2, tank, true)==true) continue;
			if(UNITS.check_collisions(x+tank.width(), yy+tank.height()/2, tank, true)==true) continue;
			
			xx = x - round(tank.width()/2);
			found = true;
			break;
			}
		if(found == false)
			xx = 100;
			
		tank.x = xx;
		tank.y = yy;
		tank.angle = angle;
		
		//if multi - only hosts set random coordinates
		if((game_mode == 'multi_quick' || game_mode == 'multi_craft') && MAIN.player_sync_done == true){
			room = ROOM.get_room_by_id(opened_room_id);
			if(room.host != name) return false;	//not host
			var params = [
				{key: 'x', value: xx},
				{key: 'y', value: yy},
				{key: 'angle', value: angle},
				];
			MP.send_packet('tank_update', [tank.id, params]);
			}
		};
	this.get_selected_count = function(team){
		if(game_mode == 'single_quick' || game_mode == 'multi_quick') return 1;
		var selected_n = 0;
		for(var i in TANKS){
			if(TANKS[i].team != team) continue;
			if(TANKS[i].selected == undefined) continue;
			selected_n++;
			}
		return selected_n;
		};
	this.init_stats = function(){
		UNITS.player_data = {};
		for(var i in COUNTRIES){
			var nation = COUNTRIES[i].file;
			UNITS.player_data[nation] = {
				he3: HE3_BEGIN,
				total_he3: HE3_BEGIN,
				kills: 0,
				units: 4,
				total_damage: 0,
				};
			}
		};
	this.get_type_index = function(type_name){
		for(var i in TYPES){
			if(TYPES[i].name == type_name)
				return i;
			}
		};
	}
