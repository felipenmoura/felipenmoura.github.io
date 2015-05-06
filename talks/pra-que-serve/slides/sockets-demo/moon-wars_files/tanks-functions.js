var SKILLS = new SKILLS_CLASS();

function SKILLS_CLASS(){
	var mines_check_reuse;
	
	//====== Tiger ===========================================================
	
	this.Blitzkrieg = function(TANK, descrition_only, settings_only, ai){
		var reuse = 20000;
		var duration = 5000;
		var power_speed = 1.2;
		var power_damage = 1.2 + 0.02* (TANK.abilities_lvl[0]-1);
		var power_armor = -100;
		
		if(descrition_only != undefined)
			return 'Attack with '+round(power_damage*100)+'% damage and '+round(power_speed*100)+'% speed, but no armor.';
		if(settings_only != undefined) return {reuse: reuse};
		if(ai != undefined){
			var max_hp = UNITS.get_tank_max_hp(TANK);
			if(TANK.hp < max_hp/2) return false;
			}
		
		TANK.abilities_reuse[0] = Date.now() + reuse;
		TANK.abilities_reuse_max[0] = reuse;
		
		//speed buff
		TANK.buffs.push({
			name: 'speed',
			power: power_speed,
			lifetime: Date.now()+duration,
			});
		//damage buff
		TANK.buffs.push({
			name: 'damage',
			power: power_damage,
			lifetime: Date.now()+duration,
			icon: 'alert',
			});
		//armor debuff
		TANK.buffs.push({
			name: 'shield',
			type: 'static',
			power: power_armor,
			lifetime: Date.now()+duration,
			});
		
		return reuse;
		};
	this.Frenzy = function(TANK, descrition_only, settings_only, ai){
		var reuse = 20000;
		var duration = 5000;
		var power = 2.05 + 0.05* (TANK.abilities_lvl[1]-1);
		var hp_level = 30;	//%
		
		if(descrition_only != undefined)
			return 'Increase damage by '+round((power-1)*100)+'% if hp lower then '+hp_level+'%.';
		if(settings_only != undefined) return {reuse: reuse};
		
		//check
		var max_hp = UNITS.get_tank_max_hp(TANK);
		if(TANK.hp > max_hp*hp_level/100){ 
			TANK.abilities_reuse[1] = Date.now();
			TANK.abilities_reuse_max[1] = 0;
			return false;
			}						
	
		//do
		TANK.abilities_reuse[1] = Date.now() + reuse;
		TANK.abilities_reuse_max[1] = reuse;
		//damage buff
		TANK.buffs.push({
			name: 'damage',
			power: power,
			lifetime: Date.now()+duration,
			icon: 'danger',
			});
		
		return reuse;
		};
	this.AA_Bullets = function(TANK, descrition_only, settings_only, ai){
		var power = 6 + (TANK.abilities_lvl[2]-1);
		
		if(descrition_only != undefined)
			return 'Use armor piercing bullets that decrease enemy armor by '+power+'%.';
		
		TANK.pierce_armor = power;
		
		//passive
		return 0;
		};
	this.AA_Bullets_once = function(TANK, descrition_only, settings_only, ai){
		var power = 6 + (TANK.abilities_lvl[2]-1);
		
		TANK.pierce_armor = power;
		};
	
	//====== Heavy ===========================================================
	
	this.Rest = function(TANK, descrition_only, settings_only, ai){
		var reuse = 20000;
		var duration = 5000;
		var power = 10 + 1 * (TANK.abilities_lvl[0]-1);
		var power_slow = 0;
		var power_weak = 0.5;
		
		if(descrition_only != undefined)
			return 'Rest and repair yourself with '+(power*duration/1000)+' power. Damage is decreased.';
		if(settings_only != undefined) return {reuse: reuse};
		if(ai != undefined){
			var max_hp = UNITS.get_tank_max_hp(TANK);
			if(TANK.hp > max_hp/2) return false;
			}
		
		if(TYPES[TANK.type].name == "Heavy"){
			TANK.abilities_reuse[0] = Date.now() + reuse;
			TANK.abilities_reuse_max[0] = reuse;
			}
		else if(TYPES[TANK.type].name == "Bomber"){
			TANK.abilities_reuse[2] = Date.now() + reuse;
			TANK.abilities_reuse_max[2] = reuse;
			}
		
		//repair buff
		TANK.buffs.push({
			name: 'repair',
			power: power,
			lifetime: Date.now()+duration,
			icon: 'repair',
			});
		//speed debuff
		TANK.buffs.push({
			name: 'speed',
			power: power_slow,
			lifetime: Date.now()+duration,
			});
		//weak debuff
		TANK.buffs.push({
			name: 'damage',
			power: power_weak,
			lifetime: Date.now()+duration,
			});	
		return reuse;
		};
	this.Rage = function(TANK, descrition_only, settings_only, ai){
		var reuse = 20000;
		var duration = 7000;
		var power_damage = 1.30 + 0.02* (TANK.abilities_lvl[1]-1);
		var power_armor = -100;
		
		if(descrition_only != undefined)
			return 'Attack with increased damage by '+round((power_damage-1)*100)+'%, but disabled armor.';
		if(settings_only != undefined) return {reuse: reuse};
		if(ai != undefined) return false;
		
		TANK.abilities_reuse[1] = Date.now() + reuse;
		TANK.abilities_reuse_max[1] = reuse;
		
		//armor debuff
		TANK.buffs.push({
			name: 'shield',
			type: 'static',
			power: power_armor,
			lifetime: Date.now()+duration,
			});
		//damage buff
		TANK.buffs.push({
			name: 'damage',
			power: power_damage,
			lifetime: Date.now()+duration,
			icon: 'alert',
			});
		
		return reuse;
		};	
	this.Health = function(TANK, descrition_only, settings_only, ai){
		var power = 1.1 + 0.01 * (TANK.abilities_lvl[2]-1);
		
		if(descrition_only != undefined)
			return 'Increase total health by '+round((power-1)*100)+'%.';
		
		//update health buff
		for(var b in TANK.buffs){
			if(TANK.buffs[b].name == 'health' && TANK.buffs[b].id == 'health_once')
				TANK.buffs[b].power = power;
			}
			
		//passive
		return 0;
		};
	this.Health_once = function(TANK, descrition_only, settings_only, ai){
		var power = 1.1 + 0.01 *(TANK.abilities_lvl[2]-1);
		if(power > 130) power = 130;		power = 1.2;
		
		//health buff
		TANK.buffs.push({
			name: 'health',
			power: power,
			id: 'health_once',
			});
		};
	
	//====== Cruiser =========================================================
	
	this.Turbo = function(TANK, descrition_only, settings_only, ai){
		var reuse = 20000;
		var duration = 3000 + 100 * (TANK.abilities_lvl[0]-1);
		var power = 1.17;
	
		if(descrition_only != undefined)
			return 'Increase speed by '+round((power-1)*100)+'% for '+round(duration/100)/10+'s.';
		if(settings_only != undefined) return {reuse: reuse};
		
		TANK.abilities_reuse[0] = Date.now() + reuse;
		TANK.abilities_reuse_max[0] = reuse;
		//speed buff
		TANK.buffs.push({
			name: 'speed',
			power: power,
			icon: 'bolt',
			lifetime: Date.now()+duration,
			});
		
		return reuse;
		};
	this.Repair = function(TANK, descrition_only, settings_only, ai){
		var reuse = 20000;
		var duration = 5000;
		var power = 12 + 1 * (TANK.abilities_lvl[1]-1);
		var range = 80;
		
		if(descrition_only != undefined)
			return 'Slowly repair yourself and allies with '+(power*duration/1000)+' power.';
		if(settings_only != undefined) return {reuse: reuse};
		if(ai != undefined){
			//check allies
			var found = false;
			for (ii in TANKS){
				if(TYPES[TANKS[ii].type].type == 'building') continue; //building
				if(TANKS[ii].team != TANK.team) continue; //enemy
				if(TANKS[ii].dead == 1) continue; //dead
				distance = UNITS.get_distance_between_tanks(TANK, TANKS[ii]);
				if(distance > range) continue; //too far
				var max_hp = UNITS.get_tank_max_hp(TANKS[ii]);
				if(TANKS[ii].hp > max_hp*2/3) continue; //still has hp
				
				//check for unit already with heals
				var valid = true;
				for (b in TANKS[ii].buffs){
					if(TANKS[ii].buffs[b].name == 'repair'){
						if(TANKS[ii].hp > max_hp/3){
							valid = false;
							break;
							}
						}
					}
				if(valid==false) continue; //already have heal
				found = true;
				}
			if(found == false) return false;
			}
	
		TANK.abilities_reuse[1] = Date.now() + reuse;
		TANK.abilities_reuse_max[1] = reuse;
		for (ii in TANKS){
			if(TYPES[TANKS[ii].type].type == 'building')	continue; //building
			if(TANKS[ii].team != TANK.team)			continue; //enemy
			distance = UNITS.get_distance_between_tanks(TANK, TANKS[ii]);
			if(distance > range)		continue;	//too far
			
			var valid = true;
			if(TYPES[TANKS[i].type].name == 'Cruiser'){
				for (b in TANKS[i].buffs){
					if(TANKS[i].buffs[b].name == 'repair'){
						valid = false;
						break;
						}
					}
				}
			if(valid==false) continue;	//lets avoid exploits/immortality here		
			
			//add effect
			if(game_mode == 'single_quick' || game_mode == 'single_craft'){
				//repair buff
				TANKS[ii].buffs.push({
					name: 'repair',
					power: power,
					lifetime: Date.now()+duration,
					icon: 'repair',
					id: TANK.id,
					});
				}
			else{
				var params = [
					{key: 'buffs', 
						value: {
							name: 'repair',
							power: power,
							lifetime: Date.now()+duration,
							icon: 'repair',
							id: TANK.id,
							}
						},
					];
				MP.send_packet('tank_update', [TANKS[ii].id, params]);
				}			
			}
		
		return reuse;
		};
	this.Boost = function(TANK, descrition_only, settings_only, ai){
		var reuse = 20000;
		var duration = 6000;
		var power = 1.1 + 0.01* (TANK.abilities_lvl[2]-1);
		var range = 80;
		
		if(descrition_only != undefined)
			return 'Inrease nearby allies damage by '+round(power*100-100)+'%.';
		if(settings_only != undefined) return {reuse: reuse};
		
		TANK.abilities_reuse[2] = Date.now() + reuse; 
		TANK.abilities_reuse_max[2] = reuse;
		for (ii in TANKS){
			if(TYPES[TANKS[ii].type].type == 'building')	continue; //building
			if(TANKS[ii].team != TANK.team)			continue; //enemy
			distance = UNITS.get_distance_between_tanks(TANK, TANKS[ii]);
			if(distance > range)		continue;	//too far
			//add effect
			if(game_mode == 'single_quick' || game_mode == 'single_craft'){
				//damage buff
				TANKS[ii].buffs.push({
					name: 'damage',
					power: power,
					lifetime: Date.now()+duration,
					icon: 'bonus',
					});
				}
			else{
				var params = [
					{key: 'buffs', 
						value: {
							name: 'damage',
							power: power,
							lifetime: Date.now()+duration,
							icon: 'bonus',
							}
						},
					];
				MP.send_packet('tank_update', [TANKS[ii].id, params]);
				}			
			}
		
		return reuse;
		};		
	
	//====== Launcher ========================================================
	
	this.Missile = function(TANK, descrition_only, settings_only, ai){
		var reuse = 6000;
		var power = 50 + 4 * (TANK.abilities_lvl[0]-1);
		var range = 100;
		
		if(descrition_only != undefined)
			return 'Launch missile with damage of '+power+'.';
		if(settings_only != undefined) return {reuse: reuse};
		
		if(TANK.try_missile != undefined){
			delete TANK.try_missile;
			if(TANK.id == MY_TANK.id && ai == undefined){
				mouse_click_controll = false;		log('369');
				target_range=0;
				target_mode='';
				}
			return 0;
			}
		if(TANK.id == MY_TANK.id && ai == undefined){	
			mouse_click_controll = true;
			target_range = 0;
			target_mode = ['target'];
			}
		//init
		TANK.try_missile = {
			range: range,
			power: power,
			reuse: reuse,
			icon: 'missle',
			angle: true,
			ability_nr: 0,
			};
		
		//return reuse - later, on use
		return 0;
		};
	this.Mortar = function(TANK, descrition_only, settings_only, ai){
		var reuse = 20000;
		var power = 50 + 6 * (TANK.abilities_lvl[1]-1);
		var range = 130;
		var splash_range = 45 + 1.8 * (TANK.abilities_lvl[1]-1);
		
		if(descrition_only != undefined)
			return 'Launch missile with area damage of '+power+'.';
		if(settings_only != undefined) return {reuse: reuse};
			
		if(TANK.try_bomb != undefined){
			delete TANK.try_bomb;
			if(TANK.id == MY_TANK.id && ai == undefined){
		 		mouse_click_controll = false;		log('406');
		 		target_range=0;
				target_mode='';
		 		}
			return 0;
			}
		if(TANK.id == MY_TANK.id && ai == undefined){
			mouse_click_controll = true;
			target_range = splash_range;
			target_mode = ['target'];
			}
		//init
		TANK.try_bomb = {
			range: range,
			aoe: splash_range,
			power: power,
			reuse: reuse,
			pierce: 1,
			icon: 'bomb',
			ability_nr: 1,
			};
			
		//return reuse - later, on use
		return 0;
		};
	this.MM_Missile = function(TANK, descrition_only, settings_only, ai){
		var reuse = 25000;
		var power = 42 + 8 * (TANK.abilities_lvl[2]-1);
		var range = 100;
		
		if(descrition_only != undefined)
			return 'Launch plasma shot with damage of '+power+'.';
		if(settings_only != undefined) return {reuse: reuse};
		
		if(TANK.try_missile != undefined){
			delete TANK.try_missile;
			if(TANK.id == MY_TANK.id && ai == undefined){
				mouse_click_controll = false;		log('443');
				target_range=0;
				target_mode='';
				}
			return 0;
			}
		if(TANK.id == MY_TANK.id && ai == undefined){	
			mouse_click_controll = true;
			target_range = 0;
			target_mode = ['target'];
			}
		//init
		TANK.try_missile = {
			range: range,
			power: power,
			reuse: reuse,
			icon: 'plasma',
			angle: false,
			ability_nr: 2,
			};
		
		//return reuse - later, on use
		return 0;
		};
	this.Range = function(TANK, descrition_only, settings_only, ai){
		if(descrition_only != undefined)
			return 'Tank range is increased. Passive ability.';
		};
	
	//====== Sniper ==========================================================
	
	this.Strike = function(TANK, descrition_only, settings_only, ai){
		var reuse = 10000;
		var power = 50 + 7 * (TANK.abilities_lvl[0]-1);
		var range = 100;
		
		if(descrition_only != undefined)
			return 'Powerful shoot with damage of '+power+'. Ignore armor.';
		if(settings_only != undefined) return {reuse: reuse};
		
		if(TANK.try_missile != undefined){
			delete TANK.try_missile;
			if(TANK.id == MY_TANK.id && ai == undefined){
				mouse_click_controll = false;		log('486');
				target_range=0;
				target_mode='';
				}
			return 0;
			}
		if(TANK.id == MY_TANK.id && ai == undefined){
			mouse_click_controll = true;
			target_range = 0;
			target_mode = ['target'];
			}
		//init
		TANK.try_missile = {
			range: range,
			power: power,
			reuse: reuse,
			ability_nr: 0,
			};
		
		//return reuse - later, on use
		return 0;
		};
	this.Camouflage = function(TANK, descrition_only, settings_only, ai){
		var reuse = 4000;
		var duration = 5000;
		var power_speed = 0.5 + 0.01 * (TANK.abilities_lvl[1]-1);
		var power_weak = 0.5;
		if(power_speed > 1) power_speed = 1;
		var power_armor = -100;
		
		if(descrition_only != undefined){ 
			if(TANK.invisibility == undefined)
				return 'Camouflage youself. Damage reduced, speed reduced by '+round(100-power_speed*100)+'%.';
			else
				return 'Disable camouflage and restore full speed and damage.';	
			}
		if(settings_only != undefined) return {reuse: reuse};
		if(ai != undefined){
			if(TANK.invisibility == 1) return false;
			}
			
		TANK.abilities_reuse[1] = Date.now() + reuse;
		TANK.abilities_reuse_max[1] = reuse;
		
		//check ranges
		if(TANK.id == MY_TANK.id || ai != undefined){
			for(var i in TANKS){
				if(TANKS[i].team == TANK.team) continue; //same team
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
					return false;	//too close to enemy
					}
				}
			}
		
		//remove invisibility
		if(TANK.invisibility == 1){
			SKILLS.stop_camouflage(TANK);
			return reuse;
			}
		
		TANK.invisibility = 1;
		
		//speed buff
		TANK.buffs.push({
			name: 'speed',
			source: 'camouflage',
			power: power_speed,
			});		
		//weak debuff
		TANK.buffs.push({
			name: 'damage',
			source: 'camouflage',
			power: power_weak,
			});
		//armor debuff
		TANK.buffs.push({
			name: 'shield',
			type: 'static',
			source: 'camouflage',
			power: power_armor,
			});
			
		return reuse;
		};
	this.stop_camouflage = function(TANK){
		delete TANK.invisibility;
		
		//update buffs
		for(var b in TANK.buffs){
			if(TANK.buffs[b].name == 'speed' && TANK.buffs[b].source == 'camouflage'){
				TANK.buffs.splice(b, 1); b--;
				}
			}
		for(var b in TANK.buffs){
			if(TANK.buffs[b].name == 'damage' && TANK.buffs[b].source == 'camouflage'){
				TANK.buffs.splice(b, 1); b--;
				}
			}
		for(var b in TANK.buffs){
			if(TANK.buffs[b].name == 'shield' && TANK.buffs[b].source == 'camouflage'){
				TANK.buffs.splice(b, 1); b--;
				}
			}
		};
	
	//====== Miner ===========================================================
	
	this.Mine = function(TANK, descrition_only, settings_only, ai){
		var reuse = 10000;
		var power = 130 + 10 * (TANK.abilities_lvl[1]-1);	
		var splash_range = 45 + 0.8 * (TANK.abilities_lvl[1]-1);
		if(splash_range > 70) splash_range = 70; 
		
		if(descrition_only != undefined)
			return 'Put mine with '+power+' power on the ground.';
		if(settings_only != undefined) return {reuse: reuse};
		
		//add
		TANK.abilities_reuse[0] = Date.now() + reuse;
		TANK.abilities_reuse_max[0] = reuse;
		MINES.push({
			x: round(TANK.cx()),
			y: round(TANK.cy()),
			damage: power,
			splash_range: splash_range,
			team: TANK.team,
			tank_id: TANK.id,
			});
			
		return reuse;
		};
	this.Explode = function(TANK, descrition_only, settings_only, ai){
		var reuse = 5000;
		var range = 45 + 0.8 * (TANK.abilities_lvl[1]-1);
		
		if(descrition_only != undefined)
			return 'Detonate nearby mines in '+range+' range. Are you ready?';
		if(settings_only != undefined) return {reuse: reuse};
		if(ai != undefined) return false;
		
		TANK.abilities_reuse[1] = Date.now() + reuse;
		TANK.abilities_reuse_max[1] = reuse;
		var mine_size_half = 8;
		
		for(var m=0; m < MINES.length; m++){
			//get range
			dist_x = MINES[m].x + mine_size_half - TANK.cx();
			dist_y = MINES[m].y + mine_size_half - TANK.cy();
			distance = Math.sqrt((dist_x*dist_x)+(dist_y*dist_y));
			distance = distance - TANK.width();
			if(distance > range) continue; // mine too far
			
			//explode
			var tank = UNITS.get_tank_by_id(MINES[m].tank_id);
			var tmp = new Array();
			tmp['x'] = MINES[m].x;
			tmp['y'] = MINES[m].y;
			tmp['bullet_to_area'] = [MINES[m].x, MINES[m].y];
			tmp['bullet_from_target'] = tank;
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
		
		return reuse;
		};
	this.SAM = function(TANK, descrition_only, settings_only, ai){
		var reuse = 10000;
		var power = 50 + 6 * (TANK.abilities_lvl[2]-1);
		var range = 120;
		
		if(descrition_only != undefined)
			return 'Send SAM missile with '+power+' power to nearest flying enemy.';
		if(settings_only != undefined) return {reuse: reuse};
		
		TANK.abilities_reuse[2] = Date.now() + reuse;
		TANK.abilities_reuse_max[2] = reuse;
		//find nearest enemy
		var ENEMY_NEAR;
		for (i in TANKS){				
			if(TANKS[i].team == TANK.team)	continue;	//same team
			if(TANKS[i].dead == 1)			continue;	//target dead
			if(TANKS[i].invisibility==1)		continue;	//blur mode
			if(TYPES[TANKS[i].type].no_collisions == undefined)	continue;	//not flying unit
			
			//check
			distance = UNITS.get_distance_between_tanks(TANKS[i], TANK);
			if(distance > range)			continue;	//target too far
			
			//range ok
			if(ENEMY_NEAR==undefined)
				ENEMY_NEAR = [range, i];
			else if(distance < ENEMY_NEAR[0])
				ENEMY_NEAR = [range, i];
			}
		
		//start missile
		if(ENEMY_NEAR != undefined){
			var enemy = TANKS[ENEMY_NEAR[1]];
			//find angle
			dist_x = enemy.x - TANK.x;
			dist_y = enemy.y - TANK.y;
			var radiance = Math.atan2(dist_y, dist_x);
			var angle = (radiance*180.0)/Math.PI+90;
			angle = round(angle);
				
			//bullet	
			var tmp = new Array();
			tmp['x'] = TANK.cx();
			tmp['y'] = TANK.cy();
			tmp['bullet_to_target'] = enemy;
			tmp['bullet_from_target'] = TANK;
			tmp['damage'] = power;
			tmp['pierce_armor'] = 100;
			tmp['angle'] = angle;
			tmp['bullet_icon'] = 'missle';
			BULLETS.push(tmp);
			}
	
		return reuse;
		};
	this.Mine_once = function(TANK){
		if(TANK.Mine_loaded == 1) return false;
		if(TANK.abilities_lvl[0]==1)
			pre_draw_functions.push(['draw_mines', TANK.id]);
		if(TANK.abilities_lvl[0]==1)
			pre_draw_functions.push(['check_mines', TANK.id]);
		TANK.Mine_loaded = 1;
		};
	this.draw_mines = function(tank_id){
		var tank = UNITS.get_tank_by_id(tank_id);
		for(var i in MINES){
			if(MINES[i].team != MY_TANK.team) continue;	//enemy dont see it
			DRAW.draw_image(canvas_main, 'mine', MINES[i].x-7+map_offset[0], MINES[i].y-7+map_offset[1]);
			}
		};
	this.check_mines = function(tank_id){	
		var mine_size_half = 8;
		
		if(mines_check_reuse - Date.now() > 0) return false;	//wait for reuse
		mines_check_reuse = Date.now() + 500;	
		
		for(var m=0; m < MINES.length; m++){
			for(var i in TANKS){
				if(TYPES[TANKS[i].type].name=='Miner') continue;	//they ignore it
				if(TYPES[TANKS[i].type].type != 'tank') continue;	//must be tank
				if(TYPES[TANKS[i].type].no_collisions==1) continue;	//flying units dont care mines
				if(TANKS[i].dead == 1) continue;			//ghost
				if((game_mode == 'single_quick' || game_mode == 'single_craft') && MINES[m].team == TANKS[i].team) continue;	//fix for all team suicide
				var sizew = TANKS[i].width();
				var sizeh = TANKS[i].height();
				if(TANKS[i].x+sizew > MINES[m].x-mine_size_half && TANKS[i].x < MINES[m].x+mine_size_half){
					if(TANKS[i].y+sizeh > MINES[m].y-mine_size_half && TANKS[i].y < MINES[m].y+mine_size_half){
						//explode
						var tank = UNITS.get_tank_by_id(MINES[m].tank_id);
						var tmp = new Array();
						tmp['x'] = MINES[m].x;
						tmp['y'] = MINES[m].y;
						tmp['bullet_to_area'] = [MINES[m].x, MINES[m].y];
						tmp['bullet_from_target'] = tank;
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
			}
		};
	
	//====== Tech ============================================================
	
	this.Virus = function(TANK, descrition_only, settings_only, ai){
		var reuse = 20000;
		var power = 50 + 6 * (TANK.abilities_lvl[0]-1);	
		var duration = 2000 + 105 * (TANK.abilities_lvl[0]-1);	
		if(duration > 4000) duration = 4000;
		var range = 70;
	
		if(descrition_only != undefined)
			return 'Send virus to deactivate enemy and damage it with '+power+' power.';
		if(settings_only != undefined) return {reuse: reuse};
		
		if(TANK.try_missile != undefined){
			delete TANK.try_missile;
			if(TANK.id == MY_TANK.id && ai == undefined){
				mouse_click_controll = false;		log('795');
				target_range=0;
				target_mode='';
				}
			return 0;
			}
		if(TANK.id == MY_TANK.id && ai == undefined){
			mouse_click_controll = true;
			target_range = 0;
			target_mode = ['target'];
			}
		//init
		TANK.try_missile = {
			range: range,
			power: power,
			reuse: reuse,
			ability_nr: 0,
			more: ['stun_effect', duration],
			};
		
		//return reuse - later, on use
		return 0;
		};
	this.EMP_Bomb = function(TANK, descrition_only, settings_only, ai){
		var reuse = 25000;		
		var power = 0;	
		var duration = 2000 + 53 * (TANK.abilities_lvl[1]-1);	
		var range = 120;
		var splash_range = 45 + 1.8 * (TANK.abilities_lvl[1]-1);
	
		if(descrition_only != undefined)
			return 'An electromagnetic pulse that corrupts electronic equipments.';
		if(settings_only != undefined) return {reuse: reuse};
		
		if(TANK.try_bomb != undefined){
			delete TANK.try_bomb;
			if(TANK.id == MY_TANK.id && ai == undefined){
		 		mouse_click_controll = false;		log('832');
		 		target_range=0;
				target_mode='';
		 		}
			return 0;
			}
		if(TANK.id == MY_TANK.id && ai == undefined){
			mouse_click_controll = true;
			target_range = splash_range;
			target_mode = ['target'];
			}
		//init
		TANK.try_bomb = {
			range: range,
			aoe: splash_range,
			power: power,
			reuse: reuse,
			icon: 'plasma',
			ability_nr: 1,
			more: ['stun_effect', duration],
			};
			
		//return reuse - later, on use
		return 0;
		};	
	this.M7_Shield = function(TANK, descrition_only, settings_only, ai){
		var reuse = 20000;
		var duration = 2000 + 105*(TANK.abilities_lvl[2]-1);
		if(game_mode == 'single_craft' || game_mode == 'multi_craft')
			duration = 3000;
		var power = 5 + 0.5*(TANK.abilities_lvl[2]-1);
		var range = 80;
		
		if(descrition_only != undefined)
			return 'Increase shield by '+power+'% for allies for '+round(duration/100)/10+'s.';
		if(settings_only != undefined) return {reuse: reuse};
		
		TANK.abilities_reuse[2] = Date.now() + reuse;
		TANK.abilities_reuse_max[2] = reuse;
		for (ii in TANKS){
			if(TYPES[TANKS[ii].type].type == 'building')	continue; //building
			if(TANKS[ii].team != TANK.team)			continue; //enemy
			distance = UNITS.get_distance_between_tanks(TANK, TANKS[ii]);
			if(distance > range)		continue;	//too far
			//add effect
			if(game_mode == 'single_quick' || game_mode == 'single_craft'){
				//shield buff
				TANKS[ii].buffs.push({
					name: 'shield',
					type: 'static',
					power: power,
					lifetime: Date.now()+duration,
					icon: 'shield',
					});
				}
			else{
				var params = [
					{key: 'buffs', 
						value: {
							name: 'shield',
							type: 'static',
							power: power,
							lifetime: Date.now()+duration,
							icon: 'shield',
							}
						},
					];
				MP.send_packet('tank_update', [TANKS[ii].id, params]);
				}			
			}
		
		return reuse;
		};
	
	//====== Truck ===========================================================
	
	this.Fire_bomb = function(TANK, descrition_only, settings_only, ai){
		var reuse = 20000;
		var power = 50 + 7 * (TANK.abilities_lvl[0]-1);
		var range = 80;
		var splash_range = 45 + 1.8 * (TANK.abilities_lvl[1]-1);
		
		if(descrition_only != undefined)
			return 'Drop Fire bomb with damage of '+power+'.';
		if(settings_only != undefined) return {reuse: reuse};
			
		if(TANK.try_bomb != undefined){
			delete TANK.try_bomb;
			if(TANK.id == MY_TANK.id && ai == undefined){
		 		mouse_click_controll = false;		log('921');
		 		target_range=0;
				target_mode='';
		 		}
			return 0;
			}
		
		if(TANK.id == MY_TANK.id && ai == undefined){
			mouse_click_controll = true;
			target_range = splash_range;
			target_mode = ['target'];
			}
		//init
		TANK.try_bomb = {
			range: range,
			aoe: splash_range,
			power: power,
			reuse: reuse,
			icon: 'bomb',
			ability_nr: 0,
			};
			
		//return reuse - later, on use
		return 0;
		};
	this.Soldiers = function(TANK, descrition_only, settings_only, ai){
		var reuse = 35000 - 500 * (TANK.abilities_lvl[2]-1);
		var n = 2;
		
		if(descrition_only != undefined)
			return 'Send '+n+' elite soldiers to the battle once in '+round(reuse/1000)+'s.';
		if(settings_only != undefined) return {reuse: reuse};
		if(ai != undefined) return false;
			
		//prepare
		TANK.abilities_reuse[1] = Date.now() + reuse;
		TANK.abilities_reuse_max[1] = reuse;
		var type = '0';
		for(var t in TYPES){
			if(TYPES[t].name == 'Soldier')
				type = t;
			}
		var angle = 180;
		if(TANK.team != 'B')
			angle = 0;
		
		//add
		for(var i=0; i<n; i++){
			x = round(TANK.x)-30+i*30;
			y = round(TANK.y);
			rand = TANK.rand;
			if(rand==undefined)
				rand = HELPER.getRandomInt(1, 999999);
			id = TYPES[type].name+'-'+rand;
			UNITS.add_tank(TANK.level, id, TYPES[type].name, type, TANK.team, TANK.nation, x, y, angle, false, TANK);
			added_tank = UNITS.get_tank_by_id(id);
			added_tank.lifetime = Date.now() + reuse;	//will disappear later
			}
		
		return reuse;
		};
	this.Medicine = function(TANK, descrition_only, settings_only, ai){
		var reuse = 20000;
		var duration = 5000;
		var power = 10 + 1 * (TANK.abilities_lvl[2]-1);
		var range = 80;
		
		if(descrition_only != undefined)
			return 'Heal elite soldiers with '+(power*duration/1000)+' power.';
		if(settings_only != undefined) return {reuse: reuse};
		if(ai != undefined) return false;
		
		TANK.abilities_reuse[2] = Date.now() + reuse;
		TANK.abilities_reuse_max[2] = reuse;
		for (ii in TANKS){
			if(TANKS[ii].master == undefined) continue; //not selite soldier
			if(TANKS[ii].master.id != TANK.id) continue; //not mine
			
			distance = UNITS.get_distance_between_tanks(TANK, TANKS[ii]);
			if(distance > range)		continue;	//too far
			//add effect
			if(game_mode == 'single_quick' || game_mode == 'single_craft'){
				//repair buff
				TANKS[ii].buffs.push({
					name: 'repair',
					power: power,
					lifetime: Date.now()+duration,
					icon: 'repair',
					id: TANK.id,
					});
				}
			else{
				var params = [
					{key: 'buffs', 
						value: {
							name: 'repair',
							power: power,
							lifetime: Date.now()+duration,
							icon: 'repair',
							id: TANK.id,
							}
						},
					];
				MP.send_packet('tank_update', [TANKS[ii].id, params]);
				}			
			}
		
		return reuse;
		};
	
	//====== TRex ==========================================================
	
	this.Plasma = function(TANK, descrition_only, settings_only, ai){
		var reuse = 7000;
		var power = 60 + 7 * (TANK.abilities_lvl[0]-1);
		var duration_slow = 3000;
		var power_slow = 0.7 - 0.01 * (TANK.abilities_lvl[0]-1);
		var range = 40;
		
		if(descrition_only != undefined)
			return 'Powerful plasma shot with '+power+' power and '+round(100-power_slow*100)+'% slow effect.';
		if(settings_only != undefined) return {reuse: reuse};
		
		if(TANK.try_missile != undefined){
			delete TANK.try_missile;
			if(TANK.id == MY_TANK.id && ai == undefined){
				mouse_click_controll = false;		log('1047');
				target_range=0;
				target_mode='';
				}
			return 0;
			}
		if(TANK.id == MY_TANK.id && ai == undefined){
			mouse_click_controll = true;
			target_range = 0;
			target_mode = ['target'];
			}
		//init
		TANK.try_missile = {
			range: range,
			power: power,
			reuse: reuse,
			//pierce: 1,
			icon: 'plasma',
			angle: false,
			ability_nr: 0,
			more: ['slow_debuff', {name: 'speed', power: power_slow, duration: duration_slow}],
			};
		
		//return reuse - later, on use
		return 0;
		};
	this.Jump = function(TANK, descrition_only, settings_only, ai){
		var reuse = 10000;
		var range = 100 + 2.7 * (TANK.abilities_lvl[1]-1);
		if(game_mode == 'single_craft' || game_mode == 'multi_craft')
			range = 120;
		
		if(descrition_only != undefined)
			return 'Quick jump to free location with '+range+' range.';
		if(settings_only != undefined) return {reuse: reuse};
		if(ai != undefined) return false;
		
		if(TANK.try_jump != undefined){
			delete TANK.try_jump;
			if(TANK.id == MY_TANK.id && ai == undefined){
				mouse_click_controll = false;		log('1087');
				target_range=0;
				target_mode='';
				}
			return 0;
			}
		if(TANK.id == MY_TANK.id && ai == undefined){
			mouse_click_controll = true;
			target_range = 0;
			target_mode = ['target'];
			}
		//init
		TANK.try_jump = {
			range: range,
			reuse: reuse,
			ability_nr: 1,
			};
		
		//remove all bullets from it
		try{
			for (b = 0; b < BULLETS.length; b++){
				if(BULLETS[b].bullet_to_target != undefined && BULLETS[b].bullet_to_target.id == TANK.id){
					BULLETS.splice(b, 1); b--;
					}
				}
			}
		catch(err){console.log("Error: "+err.message);}
		
		//return reuse - later, on use
		return 0;
		};
	this.PL_Shield = function(TANK, descrition_only, settings_only, ai){
		var reuse = 15000;
		var duration = 3000 + 105*(TANK.abilities_lvl[2]-1);
		var power = 5 + 1*(TANK.abilities_lvl[2]-1);
		
		if(descrition_only != undefined)
			return 'Plasma shield that rises your armor by '+power+'% for '+round(duration/100)/10+'s.';
		if(settings_only != undefined) return {reuse: reuse};
		
		TANK.abilities_reuse[2] = Date.now() + reuse;
		TANK.abilities_reuse_max[2] = reuse;
		//shield buff
		TANK.buffs.push({
			name: 'shield',
			type: 'static',
			power: power,
			lifetime: Date.now()+duration,
			icon: 'shield',
			});
			
		return reuse;
		};
	this.do_jump = function(tank_id, skip_broadcast){
		TANK = UNITS.get_tank_by_id(tank_id);
		if(TANK.try_jump == undefined) return false;
		if((game_mode == 'single_quick' || game_mode == 'single_craft') && MAPS[level-1].ground_only != undefined) return false;
		if(TANK.id == MY_TANK.id){
			var mouseX = mouse_click_pos[0];
			var mouseY = mouse_click_pos[1];
			}
		else{
			var mouseX = TANK.jump_x;
			var mouseY = TANK.jump_y;
			}
		var tank_size_w = TANK.width()/2;		
		var tank_size_h = TANK.height()/2;
		
		dist_x = mouseX - TANK.cx();
		dist_y = mouseY - TANK.cy();
		distance = Math.sqrt((dist_x*dist_x)+(dist_y*dist_y));
		var radiance = Math.atan2(dist_y, dist_x);
		if(distance < TANK.try_jump.range){
			var move_x = mouseX;
			var move_y = mouseY;
			}
		else{
			move_x = TANK.cx() + Math.floor(Math.cos(radiance)*TANK.try_jump.range);
			move_y = TANK.cy() + Math.floor(Math.sin(radiance)*TANK.try_jump.range);
			}
		dist_x = move_x - (TANK.cx());
		dist_y = move_y - (TANK.cy());
		radiance = Math.atan2(dist_y, dist_x);
		var angle = (radiance*180.0)/Math.PI+90;
			
		if(UNITS.check_collisions(move_x, move_y, TANK)==true)
			return false;	//wrong place
		
		//broadcast
		if((game_mode == 'multi_quick' || game_mode == 'multi_craft') && skip_broadcast !== true){
			DATA = {
				function: 'do_jump',
				fparam: [tank_id, true],
				tank_params: [
					{key: 'try_jump', value: TANK.try_jump},
					{key: 'jump_x', value: mouse_click_pos[0]},
					{key: 'jump_y', value: mouse_click_pos[1]},
					],
				};
			MP.register_tank_action('skill_advanced', opened_room_id, TANK.id, DATA);
			delete TANK.try_jump;
			mouse_click_controll = false;		log('1188');
			target_range=0;
			target_mode='';
			return false;
			}
		
		//control
		nr = TANK.try_jump.ability_nr;
		if(TANK.abilities_reuse[nr] > Date.now() ) return false; //last check
		TANK.abilities_reuse[nr] = Date.now() + TANK.try_jump.reuse;	
		TANK.abilities_reuse_max[nr] = TANK.try_jump.reuse;
		
		//animation
		TANK.animations.push({
			name: 'jump',
			to_x: move_x - tank_size_w,
			to_y: move_y - tank_size_h,
			from_x: TANK.x,
			from_y: TANK.y,
			angle: angle,
			lifetime: Date.now() + 1000,
			duration: 1000,	
			});
		
		TANK.x = move_x - tank_size_w;
		TANK.y = move_y - tank_size_h;
		TANK.move = 0;
		TANK.angle = angle;
		TANK.fire_angle = angle;
		MAP.auto_scoll_map();
			
		delete TANK.try_jump;
		mouse_click_controll = false;		log('1220');
		target_range=0;
		target_mode='';
		};
	
	//====== Apache ==========================================================
	
	this.Airstrike = function(TANK, descrition_only, settings_only, ai){
		var reuse = 10000;
		var power = 60 + 7 * (TANK.abilities_lvl[0]-1);
		var range = 120;
		
		if(descrition_only != undefined)
			return 'Send 3 missiles with '+power+' power to the target.';
		if(settings_only != undefined) return {reuse: reuse};
		
		if(TANK.try_missile != undefined){
			delete TANK.try_missile;
			if(TANK.id == MY_TANK.id && ai == undefined){
				mouse_click_controll = false;		log('1239');
				target_range=0;
				target_mode='';
				}
			return 0;
			}
		if(TANK.id == MY_TANK.id && ai == undefined){
			mouse_click_controll = true;
			target_range = 0;
			target_mode = ['target'];
			}
		//init
		TANK.try_missile = {
			range: range,
			power: power,
			reuse: reuse,
			pierce: 1,
			icon: 'airstrike',
			angle: true,
			ability_nr: 0,
			};
		
		//return reuse - later, on use
		return 0;
		};
	this.Scout = function(TANK, descrition_only, settings_only, ai){	//multi
		var ability_nr = 1;
		if(TYPES[TANK.type].name == 'Stealth') ability_nr = 2;
		var reuse = 15000;
		var duration = 3000;
		var power = 50 + 2.7 * (TANK.abilities_lvl[ability_nr]-1);
		
		if(descrition_only != undefined)
			return 'Increase sight by '+power+' for '+(duration/1000)+'s.';
		if(settings_only != undefined) return {reuse: reuse};
		
		TANK.sight = TYPES[TANK.type].scout + round(TANK.width()/2) + power;
		
		TANK.abilities_reuse[ability_nr] = Date.now() + reuse;	
		TANK.abilities_reuse_max[ability_nr] = reuse;
			
		//check invisible enemies
		for(var i in TANKS){
			if(TANKS[i].invisibility != undefined && TANKS[i].team != TANK.team)
				UNITS.check_invisibility(TANKS[i], true);
			}
		
		//register stop function
		setTimeout(function(){
			TANK.sight = TYPES[TANK.type].scout + round(TANK.width()/2);
			}, duration);
		
		return reuse;
		};
	
	//====== Bomber ==========================================================
	
	this.Bomb = function(TANK, descrition_only, settings_only, ai){
		var reuse = 15000;
		var power = 60 + 7 * (TANK.abilities_lvl[0]-1);
		var range = 60;
		var splash_range = 45 + 1.8 * (TANK.abilities_lvl[0]-1);
	
		if(descrition_only != undefined)
			return 'Drop powerful bomb with area damage of '+power+'.';
		if(settings_only != undefined) return {reuse: reuse};
		
		if(TANK.try_bomb != undefined){
			delete TANK.try_bomb;
			if(TANK.id == MY_TANK.id && ai == undefined){
				mouse_click_controll = false;		log('1309');
				target_range=0;
				target_mode='';
				}
			return 0;
			}
		if(TANK.id == MY_TANK.id && ai == undefined){
			mouse_click_controll = true;
			target_range = splash_range;
			target_mode = ['target'];
			}
		//init
		TANK.try_bomb = {
			range: range,
			aoe: splash_range,
			power: power,
			reuse: reuse,
			icon: 'bomb',
			ability_nr: 0,
			};
			
		//return reuse - later, on use
		return 0;
		};
	this.AA_bomb = function(TANK, descrition_only, settings_only, ai){
		var reuse = 10000;
		var power = 50 + 6 * (TANK.abilities_lvl[1]-1);
		var range = 90;
	
		if(descrition_only != undefined)
			return 'Drop single target anti-armor bomb with damage of '+power+'.';
		if(settings_only != undefined) return {reuse: reuse};
		
		if(TANK.try_missile != undefined){
			delete TANK.try_missile;
			if(TANK.id == MY_TANK.id && ai == undefined){
				mouse_click_controll = false;		log('1345');
				target_range=0;
				target_mode='';
				}
			return 0;
			}
		if(TANK.id == MY_TANK.id && ai == undefined){	
			mouse_click_controll = true;
			target_range = 0;
			target_mode = ['target'];
			}
		//init
		TANK.try_missile = {
			range: range,
			power: power,
			reuse: reuse,
			pierce: 1,
			icon: 'bomb',
			ability_nr: 1,
			};
		
		//return reuse - later, on use
		return 0;
		};
	
	//====== Tower ===========================================================
	
	this.Freak_out = function(TANK, descrition_only, settings_only, ai){
		var cost = 50;	cost = UNITS.apply_buff(TANK, 'cost', cost);
		var power = 0.5;
		var reuse = 30000;
		var duration = 5000;
		
		if(descrition_only != undefined)
			return 'Increase tower attack speed by '+((1-power)*100)+'% for '+(duration/1000)+'s. Costs '+cost+' HE-3.';
		if(ai != undefined) return false;
		if(game_mode == 'single_quick' || game_mode == 'multi_quick') return false;
		if(settings_only != undefined) return {reuse: reuse};
		
		if(TANK.constructing != undefined) return false;
		if(TANK.team == MY_TANK.team && UNITS.player_data[TANK.nation].he3 < cost) return false;
		UNITS.player_data[TANK.nation].he3 -= cost;
		
		TANK.abilities_reuse[0] = Date.now() + reuse;	
		TANK.abilities_reuse_max[0] = reuse;
		
		//damage buff
		TANK.buffs.push({
			name: 'hit_reuse',
			power: power,
			lifetime: Date.now()+duration,
			icon: 'danger',
			});
			
		return reuse;
		};
	
	//====== Base ============================================================
	
	this.Mechanic = function(TANK, descrition_only, settings_only, ai){
		var reuse = 0;
		var duration = 20*1000;		if(DEBUG == true) duration = 2000;
		
		var type;
		for(var i in TYPES){
			if(TYPES[i].name == 'Mechanic')
				type = i;
			}
		var cost = TYPES[type].cost;
		if(descrition_only != undefined)
			return 'Train mechanic. Costs '+cost+' HE-3.';
		if(ai != undefined) return false;
		if(settings_only != undefined) return {reuse: reuse};
		
		cost = UNITS.apply_buff(TANK, 'cost', cost);
		//check he3
		if(UNITS.player_data[TANK.nation].he3 < cost){
			if(TANK.team == MY_TANK.team){
				screen_message.text = "Not enough HE-3.";
				screen_message.time = Date.now() + 1000;
				}
			return false;
			}
		//check unit limit
		var team_units = 0;
		for(var ii in TANKS){
			if(TANKS[ii].team != TANK.team) continue;
			if(TANKS[ii].data.name == 'Base') continue;
			if(TANKS[ii].data.type == 'building'){
				if(TANKS[ii].data.name == "Factory" && TANKS[ii].training != undefined)
					team_units = team_units + TANKS[ii].training.length;
				}
			if(TANKS[ii].data.damage[0] == 0) continue;
			team_units++;
			}
		if(TANK.training != undefined && TANK.training.length >= 5) return false;
		if(team_units >= MAX_TEAM_TANKS){
			if(TANK.team == MY_TANK.team){
				screen_message.text = "Unit limit reached: "+MAX_TEAM_TANKS;
				screen_message.time = Date.now() + 1000;
				}
			return false;
			}
		UNITS.player_data[TANK.nation].he3 -= cost;
		
		//check respawn buff
		for(var b in COUNTRIES[TANK.nation].buffs){
			var buff = COUNTRIES[TANK.nation].buffs[b];
			if(buff.name == "respawn"){
				if(buff.type == 'static')	duration = duration + buff.power;
				else				duration = duration * buff.power;
				}
			}
		if(duration < 1000) duration = 1000;
		
		if(TANK.training == undefined)	TANK.training = new Array();
		TANK.training.push({
			duration: duration,
			type: type,
			cost: cost,
			});
		
		return reuse;
		};

	//====== Factory =========================================================	
	
	this.War_units = function(TANK, descrition_only, settings_only, ai){
		if(descrition_only != undefined)
			return 'Construct land or air unit.';
		if(settings_only != undefined) return {};
		
		//passive
		return 0;
		};
	this.Towers = function(TANK, descrition_only, settings_only, ai){
		if(descrition_only != undefined)
			return 'Construct various towers.';
		if(settings_only != undefined) return {};
		
		//passive
		return 0;
		};
	
	//====== Research ========================================================
	
	this.Weapons = function(TANK, descrition_only, settings_only, ai){
		var power = 5; 	//%
		if(PLACE == 'game')
			var level = COUNTRIES[TANK.nation].bonus.weapon / power;
		else
			var level = 1;
		var cost = 100*(level+1);
		var reuse = 180*1000;			if(DEBUG == true) reuse = 2000;
		var levels = 3;
		var active = true;
		if(PLACE == 'game'){
			if(COUNTRIES[TANK.nation].bonus.weapon >= power * levels) 
				active = false;
			cost = UNITS.apply_buff(TANK, 'cost', cost);
			}
		
		if(descrition_only != undefined){
			if(level < levels)
				return 'Upgrade units weapons. Costs '+cost+' HE-3.';
			else
				return 'Upgrade units weapons. Max level.';
			}
		if(ai != undefined) return false;
		if(game_mode == 'single_quick' || game_mode == 'multi_quick') return false;
		if(settings_only != undefined) 
			return {
				reuse: reuse, 
				power: power, 
				active: active,
				level: level,
				};
		
		if(TANK.constructing != undefined) return false;
		if(COUNTRIES[TANK.nation].bonus.weapon >= power * levels) return false;
		if(UNITS.player_data[TANK.nation].he3 < cost){ 
			if(TANK.team == MY_TANK.team){
				screen_message.text = "Not enough HE-3.";
				screen_message.time = Date.now() + 1000;
				}
			return false;
			}
		UNITS.player_data[TANK.nation].he3 -= cost;
		
		//register effect
		setTimeout(function(){
			if(game_mode == 'single_craft')
				COUNTRIES[TANK.nation].bonus.weapon = COUNTRIES[TANK.nation].bonus.weapon + power;
			else
				MP.send_packet('do_research', [TANK.nation, 'weapon', power]);
			}, reuse);
		
		return reuse;
		};
	this.Armor = function(TANK, descrition_only, settings_only, ai){
		var power = 5; 	//static
		if(PLACE == 'game')
			var level = COUNTRIES[TANK.nation].bonus.armor / power;
		else
			var level = 1;
		var cost = 100*(level+1);
		var reuse = 180*1000;		if(DEBUG == true) reuse = 2000;
		var levels = 3;
		var active = true;
		if(PLACE == 'game'){
			if(COUNTRIES[TANK.nation].bonus.armor >= power * levels) 
				active = false;
			cost = UNITS.apply_buff(TANK, 'cost', cost);
			}
		
		if(descrition_only != undefined){
			if(level < levels)
				return 'Upgrade units armor. Costs '+cost+' HE-3.';
			else
				return 'Upgrade units weapons. Max level.';
			}
		if(ai != undefined) return false;
		if(game_mode == 'single_quick' || game_mode == 'multi_quick') return false;
		if(settings_only != undefined)
			return {
				reuse: reuse, 
				power: power, 
				active: active,
				level: level,
				};
		
		if(TANK.constructing != undefined) return false;
		if(COUNTRIES[TANK.nation].bonus.armor >= power * levels) return false;
		if(UNITS.player_data[TANK.nation].he3 < cost){
			if(TANK.team == MY_TANK.team){
				screen_message.text = "Not enough HE-3.";
				screen_message.time = Date.now() + 1000;
				}
			return false;
			}
		UNITS.player_data[TANK.nation].he3 -= cost;
		
		//register effect
		setTimeout(function(){
			if(game_mode == 'single_craft')
				COUNTRIES[TANK.nation].bonus.armor = COUNTRIES[TANK.nation].bonus.armor + power;
			else
				MP.send_packet('do_research', [TANK.nation, 'armor', power]);
			}, reuse);
		
		return reuse;
		};
	
	//====== Mechanic ======================================================
	
	this.Rebuild = function(TANK, descrition_only, settings_only, ai){
		var power = 30;	//hp points per s
		var cost = 3; //he3 per s
		
		if(descrition_only != undefined)
			return 'Rebuilds damaged structures '+power+' hp/s. Right click to repair.';
		if(settings_only != undefined) return {power: power, cost: cost};
		
		//passive
		return 0;
		};
	this.Occupy = function(TANK, descrition_only, settings_only, ai){
		var duration = 15*1000; if(DEBUG == true) duration = 3*1000;
		
		if(descrition_only != undefined)
			return 'Occupy enemy structure. Right click on enemy building to occupy.';
		if(settings_only != undefined) return {duration: duration};
			
		//passive
		return 0;
		};
	this.Construct = function(TANK, descrition_only, settings_only, ai){
		if(descrition_only != undefined)
			return 'Constructs buildings.';
			
		//passive
		return 0;
		};
	this.construct_prepare = function(TANK, reuse, tank_type, ability_nr){
		for(var i in TYPES){
			if(TYPES[i].name == tank_type) var tank_info = TYPES[i];
			}
		var cost = tank_info.cost;
		cost = UNITS.apply_buff(TANK, 'cost', cost);
		if(TANK.try_construct != undefined){
			delete TANK.try_construct;
			if(TANK.id == MY_TANK.id){
		 		mouse_click_controll = false;		log('1634');
		 		}
			return 0;
			}
		
		if(UNITS.player_data[TANK.nation].he3 < cost){
			//message
			if(TANK.team == MY_TANK.team){
				screen_message.text = "Not enough HE-3.";
				screen_message.time = Date.now() + 1000;
				}
			return false;
			}
		
		//get type
		var type = 0;
		for(var t in TYPES){
			if(TYPES[t].name == tank_type){
				type = t;
				break;
				}
			}
		if(TANK.id == MY_TANK.id){
			mouse_click_controll = true;
			target_range = 0;
			target_mode = '';
			//hover f-tion
			var found = false;
			for(var f in pre_draw_functions)
				if(pre_draw_functions[0] == 'construct_hover')
					found = true;
			if(found == false)
				pre_draw_functions.push(['construct_hover']);
			}
		//init
		TANK.try_construct = {
			cost: cost,
			reuse: reuse,
			tank_type: type,
			ability_nr: ability_nr,
			};
		};
	this.construct_hover = function(){
		if(MY_TANK.try_construct == undefined) return false;
		var type = MY_TANK.try_construct.tank_type;
		
		if(SKILLS.validate_construction(MY_TANK, mouse_pos[0]-map_offset[0], mouse_pos[1]-map_offset[1])==true)
			canvas_main.fillStyle = "#576b35";
		else
			canvas_main.fillStyle = "#b12525";
		canvas_main.fillRect(mouse_pos[0]-round(TYPES[type].size[1]/2), mouse_pos[1]-round(TYPES[type].size[2]/2), 
			TYPES[type].size[1], TYPES[type].size[2]);
		var x = mouse_pos[0] - round(TYPES[type].size[1]/2) - map_offset[0];
		var y = mouse_pos[1] - round(TYPES[type].size[2]/2) - map_offset[1];
		UNITS.draw_tank_clone(type, x, y, 0, 0.5, canvas_main);
		};
	this.validate_construction = function(TANK, xx, yy, show_errors){
		var type = TANK.try_construct.tank_type;
	
		if(TYPES[type].name == 'Silo'){
			//find nearest resourse
			var min_distance = 999;
			var cc;
			for(var c in MAP_CRYSTALS){
				var dist_x = MAP_CRYSTALS[c].cx - (mouse_pos[0] - map_offset[0]);
				var dist_y = MAP_CRYSTALS[c].cy - (mouse_pos[1] - map_offset[1]);
				var distance = Math.sqrt((dist_x*dist_x)+(dist_y*dist_y));
				if(distance < min_distance && MAP_CRYSTALS[c].power > 0){
					min_distance = distance;
					cc = c;
					}
				}
			//dashed line
			canvas_main.lineWidth = 2;
			canvas_main.strokeStyle = "#363737";
			HELPER.dashedLine(canvas_main, mouse_pos[0] , mouse_pos[1] , MAP_CRYSTALS[cc].cx+map_offset[0], MAP_CRYSTALS[cc].cy+map_offset[1]);
			
			//check range
			if(min_distance > CRYSTAL_RANGE){
				if(show_errors == true){
					screen_message.text = "No He-3 in this territory.";
					screen_message.time = Date.now() + 1000;
					}
				return false;
				}
			//check CRYSTAL_THREADS
			var n = 0;
			for (i in TANKS){
				if(TYPES[TANKS[i].type].name != 'Silo') continue;
				var dist_x = MAP_CRYSTALS[cc].cx - TANKS[i].cx();
				var dist_y = MAP_CRYSTALS[cc].cy - TANKS[i].cy();
				var distance = Math.sqrt((dist_x*dist_x)+(dist_y*dist_y));
				if(distance < CRYSTAL_RANGE)
					n++;
				}
			if(n >= CRYSTAL_THREADS){
				if(show_errors == true){
					screen_message.text = "Too many silos near this crystal.";
					screen_message.time = Date.now() + 1000;
					}
				return false;
				}
			}
			
		//check collisions
		var valid = true;
		if(UNITS.check_collisions(xx, yy, {type:type}, true)==true) valid = false;
		if(UNITS.check_collisions(xx - TYPES[type].size[1]/2, yy - TYPES[type].size[2]/2, {type:type}, true)==true) valid = false;
		if(UNITS.check_collisions(xx - TYPES[type].size[1]/2, yy + TYPES[type].size[2]/2, {type:type}, true)==true) valid = false;
		if(UNITS.check_collisions(xx + TYPES[type].size[1]/2, yy - TYPES[type].size[2]/2, {type:type}, true)==true) valid = false;
		if(UNITS.check_collisions(xx + TYPES[type].size[1]/2, yy + TYPES[type].size[2]/2, {type:type}, true)==true) valid = false;
		if(valid == false){
			if(show_errors == true){
				screen_message.text = "This territory already used.";
				screen_message.time = Date.now() + 1000;
				}
			return false;
			}
		
		return true;
		};
	this.register_build = function(tank_id, building_id, skip_broadcast){
		TANK = UNITS.get_tank_by_id(tank_id);
		BUILDING = UNITS.get_tank_by_id(building_id);
		
		//broadcast
		if(game_mode == 'multi_craft' && skip_broadcast !== true){
			DATA = {
				function: 'register_build',
				fparam: [tank_id, building_id, true],
				tank_params: [],
				};
			MP.register_tank_action('skill_advanced', opened_room_id, TANK.id, DATA);
			return false;
			}
			
		//send
		distance = UNITS.get_distance_between_tanks(TANK, BUILDING);
		if(distance > 10){
			TANK.target_move_lock = building_id;
			TANK.move = 1;
			TANK.move_to = [BUILDING.cx(), BUILDING.cy()];
			TANK.reach_tank_and_execute = [10, 'register_build', tank_id];
			return false;
			}
		
		//start
		TANK.do_construct = building_id;
		for(var b in TANK.buffs){
			if(TANK.buffs[b].source == 'do_construct'){
				TANK.buffs.splice(b, 1); b--;
				}
			}
		TANK.buffs.push({
			icon: 'build',
			source: 'do_construct',
			});	
		};
	this.cancel_build = function(TANK){
		delete TANK.do_construct;
		//remove buffs
		for(var b in TANK.buffs){
			if(TANK.buffs[b].source == 'do_construct'){
				TANK.buffs.splice(b, 1); b--;
				}
			}
		};
	this.register_repair = function(tank_id, building_id, skip_broadcast){
		TANK = UNITS.get_tank_by_id(tank_id);
		BUILDING = UNITS.get_tank_by_id(building_id);
		
		//broadcast
		if(game_mode == 'multi_craft' && skip_broadcast !== true){
			DATA = {
				function: 'register_repair',
				fparam: [tank_id, building_id, true],
				tank_params: [],
				};
			MP.register_tank_action('skill_advanced', opened_room_id, TANK.id, DATA);
			return false;
			}
		
		//send
		distance = UNITS.get_distance_between_tanks(TANK, BUILDING);
		if(distance > 10){
			TANK.target_move_lock = building_id;
			TANK.move = 1;
			TANK.move_to = [BUILDING.cx(), BUILDING.cy()];
			TANK.reach_tank_and_execute = [10, 'register_repair', tank_id];
			return false;
			}
		
		//start
		TANK.do_repair = building_id;
		for(var b in TANK.buffs){
			if(TANK.buffs[b].source == 'do_repair'){
				TANK.buffs.splice(b, 1); b--;
				}
			}
		TANK.buffs.push({
			icon: 'build',
			source: 'do_repair',
			});	
		};
	this.cancel_repair = function(TANK){
		delete TANK.do_repair;
		//remove buffs
		for(var b in TANK.buffs){
			if(TANK.buffs[b].source == 'do_repair'){
				TANK.buffs.splice(b, 1); b--;
				}
			}
		};
	this.register_occupy = function(tank_id, building_id, skip_broadcast){
		TANK = UNITS.get_tank_by_id(tank_id);
		BUILDING = UNITS.get_tank_by_id(building_id);
		var skill_stats = SKILLS.Occupy(undefined, undefined, true);
		
		//broadcast
		if(game_mode == 'multi_craft' && skip_broadcast !== true){
			DATA = {
				function: 'register_occupy',
				fparam: [tank_id, building_id, true],	//last parameter mean nothing,
				tank_params: [],
				};
			MP.register_tank_action('skill_advanced', opened_room_id, TANK.id, DATA);
			return false;
			}
			
		//send
		distance = UNITS.get_distance_between_tanks(TANK, BUILDING);
		if(distance > 10){
			TANK.target_move_lock = building_id;
			TANK.move = 1;
			TANK.move_to = [BUILDING.cx(), BUILDING.cy()];
			TANK.reach_tank_and_execute = [10, 'register_occupy', tank_id];
			return false;
			}
			
		//start
		TANK.do_occupy = building_id;
		TANK.occupy_progress = skill_stats.duration;
		for(var b in TANK.buffs){
			if(TANK.buffs[b].source == 'do_occupy'){
				TANK.buffs.splice(b, 1); b--;
				}
			}
		TANK.buffs.push({
			icon: 'key',
			source: 'do_occupy',
			});
		};
	this.cancel_occupy = function(TANK){
		delete TANK.do_occupy;
		delete TANK.occupy_progress;
		//remove buffs
		for(var b in TANK.buffs){
			if(TANK.buffs[b].source == 'do_occupy'){
				TANK.buffs.splice(b, 1); b--;
				}
			}
		};		
		
	//====== General =========================================================
	
	this.get_ability_index = function(type_name, ability_name){
		for(var i in TYPES){
			if(TYPES[i].name != type_name) continue;
			for(var j in TYPES[i].abilities){
				if(TYPES[i].abilitie[j].name == ability_name)
					return j;
				}
			}
		};
	this.do_missile = function(tank_id, enemy_id, skip_broadcast){
		TANK = UNITS.get_tank_by_id(tank_id);
		if(TANK.try_missile == undefined) return false;
		if(TANK.name == name || ((game_mode == 'single_craft' || game_mode == 'multi_craft') && TANK.team == MY_TANK.team)){
			var mouseX = mouse_click_pos[0];
			var mouseY = mouse_click_pos[1];
			}
		else{
			mouseX = TANK.missile_x;
			mouseY = TANK.missile_y;
			}
		var tank_size_w = TANK.width()/2;		
		var tank_size_h = TANK.height()/2;		
	
		//find target
		if(enemy_id==undefined){
			if(TANK.team=='R')
				enemy = UNITS.get_tank_by_coords(mouseX, mouseY, 'B', TANK);
			else
				enemy = UNITS.get_tank_by_coords(mouseX, mouseY, 'R', TANK);
			if(enemy==false) return false;
			if(enemy.dead == 1) return false;
			//if(enemy.invisibility == 1) return false;
			
			if(enemy.tmp_range > TANK.try_missile.range){
				//too far - move to target
				mouse_click_controll = false;		log('1934');
				target_range=0;
				target_mode='';
				if((game_mode == 'multi_quick' || game_mode == 'multi_craft') && skip_broadcast !== true){
					//broadcast
					DATA = {
						function: '',
						fparam: [tank_id, enemy_id, true],
						tank_params: [
							{key: 'target_move_lock', value: enemy.id},
							{key: 'move', value: 1},
							{key: 'move_to', value: [mouseX-tank_size_w, mouseY-tank_size_h]},
							{key: 'reach_tank_and_execute', value: [TANK.try_missile.range, 'do_missile', tank_id]},
							{key: 'try_missile', value: TANK.try_missile},
							{key: 'missile_x', value: mouse_click_pos[0]},
							{key: 'missile_y', value: mouse_click_pos[1]},
							],
						};
					MP.register_tank_action('skill_advanced', opened_room_id, TANK.id, DATA);
					delete TANK.try_missile;
					}
				else{
					delete TANK.target_move_lock;
					TANK.target_move_lock = enemy.id;
					TANK.move = 1;
					TANK.move_to = [mouseX-tank_size_w, mouseY-tank_size_h];
					TANK.reach_tank_and_execute = [TANK.try_missile.range, 'do_missile', tank_id];
					}
				return false;
				}
			}
		else{
			enemy = UNITS.get_tank_by_id(enemy_id);
			if(enemy===false) return false;
			}	
		
		if(TANK.try_missile.angle == true){
			//find angle
			dist_x = enemy.x - TANK.x;
			dist_y = enemy.y - TANK.y;
			var radiance = Math.atan2(dist_y, dist_x);
			var angle = (radiance*180.0)/Math.PI+90;
			angle = round(angle);
			}
			
		//broadcast
		if((game_mode == 'multi_quick' || game_mode == 'multi_craft') && skip_broadcast !== true){
			DATA = {
				function: 'do_missile',
				fparam: [tank_id, enemy_id, true],
				tank_params: [
					{key: 'try_missile', value: TANK.try_missile},
					{key: 'missile_x', value: mouse_click_pos[0]},
					{key: 'missile_y', value: mouse_click_pos[1]},
					],
				};
			MP.register_tank_action('skill_advanced', opened_room_id, TANK.id, DATA);
			delete TANK.try_missile;
			mouse_click_controll = false;		log('1992');
			target_range=0;
			target_mode='';
			return false;
			}
			
		//control
		nr = TANK.try_missile.ability_nr;
		if(TANK.abilities_reuse[nr] > Date.now() ) return false; //last check
		TANK.abilities_reuse[nr] = Date.now() + TANK.try_missile.reuse;
		TANK.abilities_reuse_max[nr] = TANK.try_missile.reuse;
			
		//bullet	
		var tmp = new Array();
		tmp['x'] = TANK.cx();
		tmp['y'] = TANK.cy();
		tmp['bullet_to_target'] = enemy;
		tmp['bullet_from_target'] = TANK;
		tmp['damage'] = TANK.try_missile.power;
		if(TANK.try_missile.pierce != undefined)	tmp['pierce_armor'] = 100;
		if(TANK.try_missile.angle == true)		tmp['angle'] = angle;
		if(TANK.try_missile.icon != undefined)	tmp['bullet_icon'] = TANK.try_missile.icon;
		if(TANK.try_missile.more != undefined)	tmp[TANK.try_missile.more[0]] = TANK.try_missile.more[1];
		BULLETS.push(tmp);
		
		delete TANK.try_missile;
		mouse_click_controll = false;		log('2018');
		target_range=0;
		target_mode='';
		};
	this.do_bomb = function(tank_id, distance_ok, skip_broadcast){	
		TANK = UNITS.get_tank_by_id(tank_id);
		if(TANK.try_bomb == undefined) return false;
		if(TANK.name == name || ( (game_mode == 'single_craft' || game_mode == 'multi_craft') && TANK.team == MY_TANK.team)){
			mouseX = mouse_click_pos[0];
			mouseY = mouse_click_pos[1];
			}
		else{
			mouseX = TANK.bomb_x;
			mouseY = TANK.bomb_y;
			}
		var tank_size_w = TANK.width()/2;		
		var tank_size_h = TANK.height()/2;
	
		if(distance_ok !== true){
			//get explosion position
			dist_x = mouseX - TANK.cx();
			dist_y = mouseY - TANK.cy();
			distance = Math.sqrt((dist_x*dist_x)+(dist_y*dist_y));
			distance = distance - tank_size_w;
			if(distance > TANK.try_bomb.range){
				//too far - move to target
				mouse_click_controll = false;		log('2044');
				target_range=0;
				target_mode='';
				if((game_mode == 'multi_quick' || game_mode == 'multi_craft') && skip_broadcast !== true){
					//broadcast
					DATA = {
						function: '',
						fparam: [tank_id, true, true],
						tank_params: [
							{key: 'move', value: 1},
							{key: 'move_to', value: [mouseX-tank_size_w, mouseY-tank_size_h]},
							{key: 'reach_pos_and_execute', value: [TANK.try_bomb.range, 'do_bomb', mouseX, mouseY, tank_id]},
							{key: 'try_bomb', value: TANK.try_bomb},
							{key: 'bomb_x', value: mouse_click_pos[0]},
							{key: 'bomb_y', value: mouse_click_pos[1]},
							],
						};
					MP.register_tank_action('skill_advanced', opened_room_id, TANK.id, DATA);
					delete TANK.try_bomb;
					}
				else{
					delete TANK.target_move_lock;
					TANK.move = 1;
					TANK['move_to'] = [mouseX-tank_size_w, mouseY-tank_size_h];
					TANK.reach_pos_and_execute = [TANK.try_bomb.range, 'do_bomb', mouseX, mouseY, tank_id];
					}
				return false;
				}
			}
		//broadcast
		if((game_mode == 'multi_quick' || game_mode == 'multi_craft') && skip_broadcast !== true){
			DATA = {
				function: 'do_bomb',
				fparam: [tank_id, true, true],
				tank_params: [
					{key: 'try_bomb', value: TANK.try_bomb},
					{key: 'bomb_x', value: mouse_click_pos[0]},
					{key: 'bomb_y', value: mouse_click_pos[1]},
					],
				};
			MP.register_tank_action('skill_advanced', opened_room_id, TANK.id, DATA);
			delete TANK.try_bomb;
			mouse_click_controll = false;		log('2086');
			target_range=0;
			target_mode='';
			return false;
			}
			
		//control
		nr = TANK.try_bomb.ability_nr;
		if(TANK.abilities_reuse[nr] > Date.now() ) return false; //last check
		TANK.abilities_reuse[nr] = Date.now() + TANK.try_bomb.reuse;
		TANK.abilities_reuse_max[nr] = TANK.try_bomb.reuse;
		
		//bullet	
		var tmp = new Array();
		tmp['x'] = TANK.cx();
		tmp['y'] = TANK.cy();
		tmp['bullet_to_area'] = [mouseX, mouseY];
		tmp['bullet_from_target'] = TANK;
		tmp['damage'] = TANK.try_bomb.power;
		if(TANK.try_bomb.pierce != undefined)	tmp['pierce_armor'] = 100;
		if(TANK.try_bomb.icon != undefined)	tmp['bullet_icon'] = TANK.try_bomb.icon;
		if(TANK.try_bomb.more != undefined)	tmp[TANK.try_bomb.more[0]] = TANK.try_bomb.more[1];
		if(TANK.try_bomb.aoe != undefined){
			tmp['aoe_effect'] = 1;
			tmp['aoe_splash_range'] = TANK.try_bomb.aoe;
			}
		BULLETS.push(tmp);

		delete TANK.try_bomb;
		mouse_click_controll = false;		log('2115');
		target_range=0;
		target_mode='';
		};
	this.do_construct = function(tank_id, skip_broadcast, tmp){
		TANK = UNITS.get_tank_by_id(tank_id);
		if(TANK.try_construct == undefined) return false;
		if(TANK.try_construct.auto_x != undefined && TANK.try_construct.auto_y != undefined){
			mouseX = TANK.try_construct.auto_x;
			mouseY = TANK.try_construct.auto_y;
			}
		else if(skip_broadcast == undefined){
			mouseX = mouse_click_pos[0];
			mouseY = mouse_click_pos[1];
			}
		else{
			mouseX = TANK.con_x;
			mouseY = TANK.con_y;
			}	
		var type = TANK.try_construct.tank_type;
		
		var tank_size_w = TANK.width()/2;		
		var tank_size_h = TANK.height()/2;
		
		//check only if me and if not validated yet
		if(TANK.team == MY_TANK.team && skip_broadcast == undefined){
			if(SKILLS.validate_construction(MY_TANK, mouseX, mouseY, true)==false)
				return false;
			}
		
		//control
		if(TANK.try_construct == undefined) return false;
		nr = TANK.try_construct.ability_nr;
		if(TANK.abilities_reuse[nr] > Date.now() ) return false; //last check
		
		TANK.try_construct.cost = UNITS.apply_buff(TANK, 'cost', TANK.try_construct.cost);
		if(TANK.team == MY_TANK.team && skip_broadcast == undefined)
			if(UNITS.player_data[TANK.nation].he3 < TANK.try_construct.cost) return false;
		
		TANK.abilities_reuse[nr] = Date.now() + TANK.try_construct.reuse;
		TANK.abilities_reuse_max[nr] = TANK.try_construct.reuse;
		
		var x = mouseX - round(TYPES[type].size[1]/2);
		var y = mouseY - round(TYPES[type].size[2]/2);
		var angle = 180;
		if(TANK.team != 'B')
			angle = 0;
		var nation = UNITS.get_nation_by_team(TANK.team);
		var unit_id = TYPES[type].name+'-'+TANK.team+mouseX+"."+mouseY;
		
		//broadcast
		if(game_mode == 'multi_craft' && skip_broadcast !== true){
			DATA = {
				function: 'do_construct',
				fparam: [tank_id, true, 0],	//last parameter mean nothing,
				tank_params: [
					{key: 'try_construct', value: TANK.try_construct},
					{key: 'con_x', value: mouse_click_pos[0]},
					{key: 'con_y', value: mouse_click_pos[1]},
					],
				};
			MP.register_tank_action('skill_advanced', opened_room_id, TANK.id, DATA);
			if(shift_pressed == false){
				delete TANK.try_construct;
				mouse_click_controll = false;		log('2180');
				}
			return false;
			}
		
		UNITS.player_data[TANK.nation].he3 -= TANK.try_construct.cost;
		//create unit
		var new_tank = UNITS.add_tank(1, unit_id, TYPES[type].name, type, TANK.team, nation, x, y, angle);
		
		//send mechanic?
		TANK.target_move_lock = new_tank.id;
		TANK.move = 1;
		TANK.move_to = [new_tank.cx(), new_tank.cy()];
		TANK.reach_tank_and_execute = [10, 'register_build', tank_id];
		
		var duration = 30*1000;
		if(DEBUG == true) duration = 3000;
		new_tank.constructing = {
			duration: duration,
			time: 0,
			};
		//register crystal?
		if(new_tank.data.name == 'Silo'){
			var min_distance = 999;
			for(var c in MAP_CRYSTALS){
				var dist_x = MAP_CRYSTALS[c].cx - new_tank.cx();
				var dist_y = MAP_CRYSTALS[c].cy - new_tank.cy();
				var distance = Math.sqrt((dist_x*dist_x)+(dist_y*dist_y));
				if(distance < CRYSTAL_RANGE && MAP_CRYSTALS[c].power > 0){
					new_tank.crystal = MAP_CRYSTALS[c];
					break;
					}
				}
			}	
		//add flag?
		if(new_tank.data.name == 'Factory' || new_tank.data.name == 'Base'){
			if(new_tank.team == 'B') //top
				new_tank.flag = { x: new_tank.x, y: new_tank.y+60};
			else //bottom
				new_tank.flag = { x: new_tank.x, y: new_tank.y-60};
			if(new_tank.flag.x < 100)		new_tank.flag.x = 100;
			if(new_tank.flag.x > WIDTH_MAP-100)	new_tank.flag.x = WIDTH_MAP-100;
			}
		if(shift_pressed == false){
			delete TANK.try_construct;
			if(TANK.id == MY_TANK.id){
				mouse_click_controll = false;		log('2025');
				}
			}
		};
	}
