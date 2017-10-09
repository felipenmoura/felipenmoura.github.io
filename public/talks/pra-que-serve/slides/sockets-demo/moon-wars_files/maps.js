var MAP = new MAP_CLASS();

function MAP_CLASS(){
	this.maps_positions = [];
	
	//draw main map
	this.draw_map = function(map_only){
		if(map_only==false){
			//clear backround
			canvas_backround.clearRect(0, 0, WIDTH_APP, HEIGHT_APP);
			
			//fill gap
			if(WIDTH_MAP < WIDTH_APP){
				canvas_backround.fillStyle = "#bab7ae";
				canvas_backround.fillRect(WIDTH_MAP, 0, WIDTH_APP-WIDTH_MAP, HEIGHT_MAP);
				}
			
			//fill map with grey
			canvas_map.fillStyle = "#bab7ae";
			canvas_map.fillRect(0, 0, WIDTH_MAP, HEIGHT_MAP);
			status_x = 0;
			if(FS==true){
				status_x = round((WIDTH_APP-APP_SIZE_CACHE[0])/2);
				if(status_x<0) status_x=0;
				}
			status_y = HEIGHT_APP-INFO_HEIGHT-STATUS_HEIGHT;
			
			canvas_fog.fillStyle = "rgba(0, 0, 0, 0.5)";
			canvas_fog.fillRect(0, 0, WIDTH_MAP, HEIGHT_MAP);
			canvas_fog.globalCompositeOperation = 'destination-out';
			document.getElementById("canvas_fog").style.display = 'none';
			if(QUALITY == 3){
				document.getElementById("canvas_fog").style.display = 'block';
				}
			//init mini fog
			MINI_FOG = document.createElement("canvas");
			MINI_FOG.width = MINI_MAP_PLACE[2];
			MINI_FOG.height = MINI_MAP_PLACE[3];
			//fill
			MINI_FOG.getContext("2d").fillStyle = "rgba(0, 0, 0, 0.3)";
			MINI_FOG.getContext("2d").fillRect(0, 0, MINI_FOG.width, MINI_FOG.height);
			MINI_FOG.getContext("2d").globalCompositeOperation = 'destination-out';
			}
		
		//background
		backround_width = 400;
		backround_height = 400;
		for(var i=0; i<Math.ceil(MAPS[level-1].height/backround_height); i++){
			for(var j=0; j<Math.ceil(MAPS[level-1].width/backround_width); j++)
				canvas_map.drawImage(MAIN.IMAGE_MOON, 0+j*backround_width, 0+i*backround_height);
			}
			
		//roads
		for(var i in MAPS[level-1].roads){
			var road_group = MAPS[level-1].roads[i][1];
			var width = MAPS[level-1].roads[i][0];
			for(var j in road_group){
				var road = road_group[j];
				if(road[0] == 'line')
					MAP.add_road_line(canvas_map, width, road[1], road[2], road[3], road[4]);
				else if(road[0] == 'turn')
					MAP.add_road_turn(canvas_map, width, road[1], road[2], road[3], road[4], road[5], road[6]);
				else if(road[0] == 'curve')
					MAP.add_road_curve(canvas_map, width, road[1], road[2], road[3], road[4], road[5], road[6], road[7], road[8]);
				}
			}
		
		//elements
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
			
			var visible = true;
			if(MAPS[level-1].elements[e][0] == 'crystals'){
				if(game_mode == 'single_quick' || game_mode == 'multi_quick')
					visible = false;
				else{
					for(var t in MAP_CRYSTALS){
						if(MAP_CRYSTALS[t].x == x && MAP_CRYSTALS[t].y == y && MAP_CRYSTALS[t].power<1){
							visible = false;
							break;
							}
						}
					}
				}
			if(visible == true)
				DRAW.draw_image(canvas_map, element.name, x, y, max_w, max_h, undefined);
			}
			
		if(map_only==false){
			INFOBAR.draw_infobar(true);
			}
		};
	this.add_road_line = function(ctx, width, x1, y1, x2, y2){
		//light border
		ctx.lineWidth = width+5;
		ctx.strokeStyle = '#585953';
		ctx.beginPath();
		ctx.moveTo(x1, y1);
		ctx.lineTo(x2, y2);
		ctx.stroke();
		
		//main
		ctx.lineWidth = width;
		ctx.strokeStyle = '#3c3b36';
		ctx.beginPath();
		ctx.moveTo(x1, y1);
		ctx.lineTo(x2, y2);
		ctx.stroke();
		
		if(width >= 30 ){
			//double line
			ctx.lineWidth = 6;
			ctx.strokeStyle = '#53582f';
			ctx.beginPath();
			ctx.moveTo(x1, y1);
			ctx.lineTo(x2, y2);
			ctx.stroke();
			
			//double line gap in middle
			ctx.lineWidth = 3;
			ctx.strokeStyle = '#3c3b36';
			ctx.beginPath();
			ctx.moveTo(x1, y1);
			ctx.lineTo(x2, y2);
			ctx.stroke();
			}
		else{
			//center line
			ctx.lineWidth = 2;
			ctx.strokeStyle = '#53582f';
			ctx.beginPath();
			ctx.moveTo(x1, y1);
			ctx.lineTo(x2, y2);
			ctx.stroke();
			}
		};
	this.add_road_turn = function(ctx, width, x1, y1, x2, y2, x3, y3){
		//light border
		ctx.lineWidth = width+5;
		ctx.strokeStyle = '#585953';
		ctx.beginPath();
		ctx.moveTo(x1,y1);
		ctx.quadraticCurveTo(x2,y2,x3,y3);
		ctx.stroke();
		
		//main
		ctx.lineWidth = width;
		ctx.strokeStyle = '#3c3b36';
		ctx.beginPath();
		ctx.moveTo(x1,y1);
		ctx.quadraticCurveTo(x2,y2,x3,y3);
		ctx.stroke();
		
		if(width >= 30 ){
			//double line
			ctx.lineWidth = 6;
			ctx.strokeStyle = '#53582f';
			ctx.beginPath();
			ctx.moveTo(x1,y1);
			ctx.quadraticCurveTo(x2,y2,x3,y3);
			ctx.stroke();
			
				//double line gap in middle
			ctx.lineWidth = 3;
			ctx.strokeStyle = '#3c3b36';
			ctx.beginPath();
			ctx.moveTo(x1,y1);
			ctx.quadraticCurveTo(x2,y2,x3,y3);
			ctx.stroke();
			}
		else{
			//center line
			ctx.lineWidth = 2;
			ctx.strokeStyle = '#53582f';
			ctx.beginPath();
			ctx.moveTo(x1,y1);
			ctx.quadraticCurveTo(x2,y2,x3,y3);
			ctx.stroke();
			}
		};
	this.add_road_curve = function(ctx, width, x1, y1, x2, y2, x3, y3, x4, y4){
		//light border
		ctx.lineWidth = width+5;
		ctx.strokeStyle = '#585953';
		ctx.beginPath();
		ctx.moveTo(x1,y1);
		ctx.bezierCurveTo(x2,y2,x3,y3,x4,y4);
		ctx.stroke();
		
		//main
		ctx.lineWidth = width;
		ctx.strokeStyle = '#3c3b36';
		ctx.beginPath();
		ctx.moveTo(x1,y1);
		ctx.bezierCurveTo(x2,y2,x3,y3,x4,y4);
		ctx.stroke();
		
		if(width >= 30 ){
			//double line
			ctx.lineWidth = 6;
			ctx.strokeStyle = '#53582f';
			ctx.beginPath();
			ctx.moveTo(x1,y1);
			ctx.bezierCurveTo(x2,y2,x3,y3,x4,y4);
			ctx.stroke();
			
			//double line gap in middle
			ctx.lineWidth = 3;
			ctx.strokeStyle = '#3c3b36';
			ctx.beginPath();
			ctx.moveTo(x1,y1);
			ctx.bezierCurveTo(x2,y2,x3,y3,x4,y4);
			ctx.stroke();
			}
		else{
			//center line
			ctx.lineWidth = 2;
			ctx.strokeStyle = '#53582f';
			ctx.beginPath();
			ctx.moveTo(x1,y1);
			ctx.bezierCurveTo(x2,y2,x3,y3,x4,y4);
			ctx.stroke();
			}
		};
	/*
	1x speed if QUALITY = 1	- scout off, fog off
	2x slow  if QUALITY = 2 - scout on, fog off
	3x slow  if QUALITY = 3 - scout on, fog on
	*/
	this.add_scout_and_fog = function(tank){
		if(PLACE != 'game') return false;
		if(QUALITY == 1) return false;
		if(SCOUT_FOG_REUSE - Date.now() > 0) return false; //not so fast, wait a little
		
		if(QUALITY == 3){
			//reveal fog
			for(var i in TANKS){
				if(TANKS[i].team != MY_TANK.team) continue;
				if(TANKS[i].constructing != undefined) continue;
				if(TANKS[i].dead == 1) continue;
				//if(TANKS[i].skip_sight == 1) continue; //buildings do not move - already parsed
				
				var xx = round(TANKS[i].cx());
				var yy = round(TANKS[i].cy());
				canvas_fog.beginPath();
				var sight_range = TANKS[i].sight;
				canvas_fog.arc(xx, yy, sight_range, 0 , 2 * Math.PI, true);
				canvas_fog.fill();
				
				if(TANKS[i].data.type == 'building')
					TANKS[i].skip_sight = 1;
				}
			}
		//adds scout
		canvas_map_sight.clearRect(0, 0, WIDTH_SCROLL, HEIGHT_SCROLL);
		canvas_map_sight.fillStyle = "rgba(0, 0, 0, 0.4)";
		canvas_map_sight.fillRect(0, 0, WIDTH_SCROLL, HEIGHT_SCROLL);
		canvas_map_sight.save();
		if(QUALITY == 3) canvas_map_sight.fillStyle = "#ffffff";
		canvas_map_sight.globalCompositeOperation = 'destination-out';	// this does the trick
		for(var i in TANKS){
			if(TANKS[i].team != MY_TANK.team) continue;
			if(TANKS[i].constructing != undefined) continue;
			if(TANKS[i].dead == 1) continue;
				
			var xx = round(TANKS[i].cx() + map_offset[0]);
			var yy = round(TANKS[i].cy() + map_offset[1]);
			var sight_range = TANKS[i].sight;
			
			if(xx+sight_range < 0 || yy+sight_range < 0 || xx-sight_range > WIDTH_SCROLL || yy-sight_range > HEIGHT_SCROLL) continue; //not in visible area
			
			canvas_map_sight.beginPath();
			canvas_map_sight.arc(xx, yy, sight_range, 0 , 2 * Math.PI, true);
			canvas_map_sight.fill();
			}
		canvas_map_sight.restore();
		SCOUT_FOG_REUSE = Date.now() + 40; //next repaint in 40 ms - 25fps
		};
	//cancel manual map move controlls
	this.move_to_place_reset = function(){
		MAP_SCROLL_CONTROLL=false;
		MAP.auto_scoll_map();
		};
	//move map by tank position
	this.auto_scoll_map = function(){
		//calc
		map_offset[0] = -1 * MY_TANK.cx() + WIDTH_SCROLL/2;
		map_offset[1] = -1 * MY_TANK.cy() + HEIGHT_SCROLL/2;
		
		//check
		if(map_offset[0]>0)	map_offset[0]=0;
		if(map_offset[1]>0)	map_offset[1]=0;
		if(map_offset[0] < -1*(WIDTH_MAP - WIDTH_SCROLL))
			map_offset[0] = -1*(WIDTH_MAP - WIDTH_SCROLL);
		if(map_offset[1] < -1*(HEIGHT_MAP - HEIGHT_SCROLL))
			map_offset[1] = -1*(HEIGHT_MAP - HEIGHT_SCROLL);
				
		//scrolling using css - 2x speed gain
		document.getElementById("canvas_map").style.marginTop =  map_offset[1]+"px";
		document.getElementById("canvas_map").style.marginLeft = map_offset[0]+"px";
		if(QUALITY == 3){
			document.getElementById("canvas_fog").style.marginTop =  map_offset[1]+"px";
			document.getElementById("canvas_fog").style.marginLeft = map_offset[0]+"px";
			}
		};
	//scroll map in manual scroll mode
	this.scoll_map = function(xx, yy, step){
		if(MAP_SCROLL_MODE==1) return false;
		
		if(step == undefined)
			step = 50;
		
		//calc
		map_offset[0] = map_offset[0] + xx * step;
		map_offset[1] = map_offset[1] + yy * step;
		
		//check limits
		if(map_offset[0]>0)	map_offset[0]=0;
		if(map_offset[1]>0)	map_offset[1]=0;
		if(map_offset[0] < -1*(WIDTH_MAP - WIDTH_SCROLL))
			map_offset[0] = -1*(WIDTH_MAP - WIDTH_SCROLL);
		if(map_offset[1] < -1*(HEIGHT_MAP - HEIGHT_SCROLL))
			map_offset[1] = -1*(HEIGHT_MAP - HEIGHT_SCROLL);
				
		//scrolling using css - 2x speed gain
		document.getElementById("canvas_map").style.marginTop =  map_offset[1]+"px";
		document.getElementById("canvas_map").style.marginLeft = map_offset[0]+"px";
		if(QUALITY == 3){
			document.getElementById("canvas_fog").style.marginTop =  map_offset[1]+"px";
			document.getElementById("canvas_fog").style.marginLeft = map_offset[0]+"px";
			}
		};
	//redraw actions in selecting tank/map window
	this.show_maps_selection = function(canvas_this, top_height, can_select_map){
		if(game_mode == 'multi_quick' || game_mode == 'multi_craft') return false;
		var gap = 8;
		var button_width = 90;
		var button_height = 80;
		MAP.maps_positions = [];
		
		//clear name area
		canvas_backround.drawImage(MAIN.IMAGE_BACK, 0, top_height-5, WIDTH_APP, 110, 0, top_height-5, WIDTH_APP, 110);
		
		var j=0;
		for (i in MAPS){
			if(MAPS[i].mode != undefined && MAPS[i].mode != game_mode) continue;
			
			var padding_left = 15;
			if(PLACE == 'library')
				padding_left = 10;	
			//background
			if(level - 1==i)
				canvas_this.fillStyle = "#8fc74c";	//selected
			else
				canvas_this.fillStyle = "#cccccc";
			canvas_this.strokeStyle = "#196119";
			HELPER.roundRect(canvas_this, padding_left+j*(button_width+gap), top_height, button_width, button_height, 5, true);
			
			//calcuate mini-size
			mini_w = (button_width-2)/MAPS[i].width;
			mini_h = (button_height-2)/MAPS[i].height;
			var pos1 = padding_left+j*(button_width+gap);
			var pos2 = top_height;
			
			//paint towers
			msize = 3;
			for (ii in MAPS[i].towers){
				if((game_mode == 'single_craft' || game_mode == 'multi_craft') && MAPS[i].towers[ii][3] != 'Base') continue;
				var type_info;
				for(var t in TYPES){
					if(TYPES[t].name == MAPS[i].towers[ii][3]){
						type_info = TYPES[t];
						break;
						}
					}
				
				if(MAPS[i].towers[ii][0]=="B")
					canvas_this.fillStyle = "#0000aa";
				else
					canvas_this.fillStyle = "#b12525";
				var xx = MAPS[i].towers[ii][1];
				var yy = MAPS[i].towers[ii][2];
				if(xx == 'rand')
					xx = HELPER.getRandomInt(type_info.size[1], MAPS[i].width-type_info.size[1]);
				if(yy == 'rand')
					yy = HELPER.getRandomInt(type_info.size[2], MAPS[i].height-type_info.size[2]);
				tank_x = pos1 + round((xx) * button_width / round(MAPS[i].width));
				tank_y = pos2 + round((yy) * button_height /(MAPS[i].height));
				canvas_this.fillRect(tank_x, tank_y, msize, msize);
				}
			
			//elements
			for(var e in MAPS[i].elements){
				var element = MAP.get_element_by_name(MAPS[i].elements[e][0]);
				element.w = IMAGES_SETTINGS.elements[element.name].w;
				element.h = IMAGES_SETTINGS.elements[element.name].h;
				x = MAPS[i].elements[e][1];
				y = MAPS[i].elements[e][2];
				if(element.w<30)	x = x - round(element.w/2);
				if(element.h<30)	y = y - round(element.h/2);
				max_w = element.w;
				if(MAPS[i].elements[e][3]!=0)
					max_w = MAPS[i].elements[e][3];
				max_h = element.h;
				if(MAPS[i].elements[e][4]!=0)
					max_h = MAPS[i].elements[e][4];
				//minimize
				max_w = Math.ceil(max_w*button_width/MAPS[i].width);
				max_h = Math.ceil(max_h*button_height/MAPS[i].height);
				x = pos1 + Math.ceil(x*button_width/MAPS[i].width);
				y = pos2 + Math.ceil(y*button_height/MAPS[i].height);
				//draw
				if(element.alt_color != undefined){
					canvas_this.fillStyle = element.alt_color;
					canvas_this.fillRect(x, y, max_w, max_h);
					}
				}
				
			//name
			if(level - 1==i)
				canvas_this.fillStyle = "#c10000";
			else
				canvas_this.fillStyle = "#196119";
			canvas_this.font = "bold 14px Helvetica";
			var letters_width = canvas_this.measureText(MAPS[i].name).width;
			var text_padding_left = Math.round((button_width-letters_width)/2);
			if(text_padding_left<0) text_padding_left=0;
			canvas_this.fillText(MAPS[i].name, padding_left+j*(button_width+gap)+text_padding_left, top_height+1+button_height+gap+10);
			
			if(can_select_map==true){
				//save position
				var tmp = new Array();
				tmp['x'] = padding_left+j*(button_width+gap)+1;
				tmp['y'] = top_height+1;
				tmp['width'] = button_width;
				tmp['height'] = button_height;
				tmp['title'] = MAPS[i].name;
				tmp['index'] = i;
				tmp['top_height'] = top_height-18*2;
				MAP.maps_positions.push(tmp);
				
				MAIN.register_button(tmp['x'], tmp['y'], tmp['width'], tmp['height'], PLACE, function(mouseX, mouseY, index){	
					level = 1 + parseInt(index);
					MAP.show_maps_selection(canvas_backround, top_height, true);
					if(PLACE == 'library')
						LIBRARY.draw_library_maps();
					}, i);
				}
			j++;
			}
		};
	//return map element info by name
	this.get_element_by_name = function(name){
		for(var i in ELEMENTS){
			if(ELEMENTS[i].name == name){
				return ELEMENTS[i];
				}
			}
		return false;
		};
	this.change_quality = function(){
		QUALITY++;
		if(QUALITY==4)
			QUALITY = 1;
		HELPER.setCookie("quality", QUALITY, 30);
		
		if(PLACE == 'game'){
			canvas_map_sight.globalCompositeOperation = 'source-over';
			if(QUALITY == 1){
				canvas_map_sight.clearRect(0, 0, WIDTH_MAP, HEIGHT_MAP);
				document.getElementById("canvas_fog").style.display = 'none';
				}
			else if(QUALITY == 2)
				document.getElementById("canvas_fog").style.display = 'none';
			else if(QUALITY == 3){
				document.getElementById("canvas_fog").style.display = 'block';
				
				document.getElementById("canvas_fog").style.marginTop =  map_offset[1]+"px";
				document.getElementById("canvas_fog").style.marginLeft = map_offset[0]+"px";
				}
			}
		};
	}
