
//========= game settings ======================================================
		
var VERSION = "2.0";			//app version
var DEBUG = false;			//show debug info
var SOCKET = ['tryunion.com', '80'];	//socket server //unionplatform.com - amazing service
var APP_URL = 'http://viliusle.github.io/vl-tanks/';	//homepage
var APP_EMAIL = 'www.viliusl@gmail.com';	//author email
var FPS = 25;				//frames per second
var START_GAME_COUNT = 20;		//second how much to count in multiplayer
var WIDTH_APP = 800;			//application width
var HEIGHT_APP = 525;			//application height
var MAX_SENT_PACKETS = 6000;		//max packets, that we can send to server per game
var INFO_HEIGHT = 130;			//height of information block
var STATUS_HEIGHT = 25;			//height of statusbar
var MINI_MAP_PLACE = [13,13,104,104,3];	//x, y, width, height, border width
var SCORES_INFO = [10,40,-20,50,100];	//level up, kill, death, per tower, win bonus
var SOUND_EXT = '.ogg';			//default sound files extension
var LEVEL_UP_TIME = 30;			//how much seconds must pass till level up
var SOLDIERS_INTERVAl = 30;		//pause between soldiers spawn, seconds
var MAX_ABILITY_LEVEL = 20;		//max ability level
var INVISIBILITY_SPOT_RANGE = 50;	//% of enemy range, if enemy comes close, invisibility wanishes.
var ABILITIES_MODE = 0;			//0=all, 1=first, 2=second, 3 = third
var MAX_TEAM_TANKS = 20;		//max tanks for 1 team in commander mode
var CRYSTAL_POWER = 3000;		//how much he3 1 crystal has
var CRYSTAL_THREADS = 10;		//max silos for 1 crystal
var CRYSTAL_RANGE = 100;		//crystal/silo range
var HE3_BEGIN = 260;			//he-3 at begin, recommended 260
var SILO_POWER = 2;			//how much he3 silo generates per 1s
var QUALITY = 3;			//1=low, 2=mid, 3=high
var MAX_BULLET_RANGE = 160;		//for units position sync, if exeeds - unit position is synced

//========= global variables ===================================================

var TANKS = new Array();		//tanks array
var MY_TANK;				//my tank
var MAP_CRYSTALS = new Array();		//crystals array for map
var MINES = [];				//mines
var BUTTONS = new Array();		//buttons array
var CHAT_LINES = new Array();		//chat array lines
var ROOMS = new Array();		//rooms array
var PLAYERS = new Array();		//players list
var opened_room_id = -1;		//active room id
var WIDTH_MAP;				//map width, if big, offset start to work (works as scroll)
var HEIGHT_MAP;				//map height, if big, offset start to work (works as scroll)
var WIDTH_SCROLL;			//visible map part width, similar to WIDTH_APP
var HEIGHT_SCROLL;			//visible map part height, = HEIGHT_APP - status bar height
var APP_SIZE_CACHE = [WIDTH_APP, HEIGHT_APP]; //original app dimensions cache
var MUTE_FX = false;			//if effects muted
var MUTE_MUSIC = false;			//if backgrond music muted
var MUSIC_VOLUME = 1;			//music volume, 0 - 1
var FX_VOLUME = 1;			//sound effects volume, 0 - 1
var level = 1;				//map index
var name = '';				//user name
var my_tank_nr = -1;			//my tank type: [0,1...n]
var audio_main;				//main audio track controller
var map_offset = [0, 0];		//map offest [x ,y], < 0, this is for map scrolling, if map bigger then canvas size
var mouse_click_controll = false;	//if external funtion takes mouse clicks controll
var target_mode = '';			//target mode: target, rectangle
var target_range = 0;			//targer circle range for aoe skills
var mouse_pos = [0,0];			//current mouse position for external functions
var mouse_click_pos = [0,0];		//last mouse click position for external functions
var pre_draw_functions = [];		//extra functions executed before main draw loop
var game_mode;				//single_quick, single_craft, multi_quick, multi_craft
var PLACE = '';				//init, intro, settings, library, select, game, score, rooms, room, create_room
var preloaded = false;			//if all images preloaded
var preload_total = 0;			//total images for preload
var preload_left = 0;			//total images left for preload
var FS = false;				//fullscreen off/on
var tab_scores = false;			//show live scroes on TAB
var status_x = 0;			//info bar x coordinates
var status_y = 0;			//info bar y coordinates
var TO_RADIANS = Math.PI/180; 		//for rotating
var MAP_SCROLL_CONTROLL = false;	//active if user scrolling map with mouse on mini map
var MAP_SCROLL_MODE = 1;		//if 1, auto scroll, if 2, no auto scroll
var room_id_to_join = -1;		//id of room, requested to join
var render_mode = 'requestAnimationFrame';	//render mode
var packets_used = 0;			//sent packets count in 1 game, there is limit...
var packets_all = 0;			//received packets count in 1 game
var chat_shifted = false;		//if chat was activated with shift
var intro_page = 0;			//intro page
var time_gap;				//time difference between frames
var screen_message = {};		//message to show on screen
var mouse_last_move = Date.now();	//if mouse moving
var SCOUT_FOG_REUSE = 0;		//pause between fog and scout repaint
var my_nation;				//my nation

//========= repeative functions handlers =======================================

var draw_interval_id;			//controller for main draw loop, rate: 35/s
var level_interval_id;			//controller for level handling function, rate: 1/s
var level_hp_regen_id;			//controller for hp regen handling function, rate: 1/s
var timed_functions_id;			//controller for timed functions, rate: 10/s
var start_game_timer_id;		//controller for timer in select window, rate: 1/s
var chat_interval_id;			//controller for chat, rate: 2/s
var bots_interval_id;			//controller for adding new bots function, rate: once per 30s

//========= canvas layers ======================================================

var canvas_map = document.getElementById("canvas_map").getContext("2d");		//map
var canvas_fog = document.getElementById("canvas_fog").getContext("2d");		//fog
var canvas_map_sight = document.getElementById("canvas_map_sight").getContext("2d");	//sight
var canvas_backround = document.getElementById("canvas_backround").getContext("2d");	//backgrounds
var canvas_base = document.getElementById("canvas_main");
var canvas_main = canvas_base.getContext("2d");						//objects
var MINI_FOG;										//fog inside mini map

//========= events handlers ====================================================

//on exit
window.onbeforeunload = MP.disconnect_game;

//mouse move handlers
canvas_base.addEventListener('mousemove', on_mousemove, false);
document.getElementById("canvas_backround").addEventListener('mousemove', on_mousemove_background, false);
canvas_base.addEventListener("mousewheel", MouseWheelHandler, false);
canvas_base.addEventListener("DOMMouseScroll", MouseWheelHandler, false);
parent.document.addEventListener('mousemove', on_mousemove_parent, false);

//mouse click handlers
document.getElementById("canvas_backround").addEventListener('mousedown', on_mousedown_back, false);
canvas_base.addEventListener('mouseup', on_mouseup, false);
document.getElementById("canvas_backround").addEventListener('mouseup', on_mouseup_back, false);
canvas_base.addEventListener('mousedown', on_mousedown, false);
document.oncontextmenu = function(e) {return on_mouse_right_click(e); };

//keyboard handlers
document.onkeydown = function(e) {return on_keyboard_action(e); };
document.onkeyup = function(e) {return on_keyboardup_action(e); };

//full screen handlers
document.addEventListener("fullscreenchange", full_screenchange_handler, false);
document.addEventListener("mozfullscreenchange", full_screenchange_handler, false);
document.addEventListener("webkitfullscreenchange", full_screenchange_handler, false);

//========= images settings ====================================================

var IMAGES_SETTINGS = {
	general: {
		target:	{ x:0,	y:0,	w:30,	h:30 },
		repair:	{ x:50,	y:0,	w:16,	h:16 },
		lock:		{ x:100,	y:0,	w:14,	h:20 },
		fire:		{ x:150,	y:0,	w:24,	h:32 },
		button:	{ x:200,	y:0,	w:48,	h:20 },
		explosion:	{ x:250,	y:0,	w:50,	h:50 },
		us:		{ x:300,	y:0,	w:15,	h:9 },
		ru:		{ x:350,	y:0,	w:15,	h:9 },
		ch:		{ x:400,	y:0,	w:15,	h:9 },
		level:	{ x:0,	y:50,	w:150, h:15 },
		logo_small:	{ x:0,	y:100, w:76,	h:25 },
		skill_off:	{ x:0,	y:150, w:65,	h:65 },
		skill_on:	{ x:0,	y:250, w:65,	h:65 },
		statusbar:	{ x:0,	y:350, w:800, h:128 },
		he3:	{ x:100,	y:150,w:18, h:20 },
		danger:	{ x:150,	y:50, w:16, h:16 },
		shield:	{ x:200,	y:50, w:16, h:16 },
		alert:	{ x:300,	y:50, w:16, h:16 },
		bonus:	{ x:350,	y:50, w:16, h:15 },
		bolt:	{ x:250,	y:50, w:14, h:20 },
		error:	{ x:400,	y:50, w:16, h:16 },	
		flag: 	{ x:100,	y:100, w:16, h:16 },
		build: 	{ x:150,	y:100, w:20, h:20 },
		key: 	{ x:200,	y:100, w:20, h:19 },
		},
	tanks: {
		Heavy:	{ x:0,	y:0,		w:90,	h:80 },
		Tiger:	{ x:0,	y:100,	w:90,	h:80 },
		Cruiser:	{ x:0,	y:200,	w:90,	h:80 },
		Launcher:	{ x:0,	y:300,	w:90,	h:80 },
		Stealth:	{ x:0,	y:400,	w:90,	h:80 },
		Miner:	{ x:0,	y:500,	w:90,	h:80 },
		Tech:		{ x:0,	y:600,	w:90,	h:80 },
		Truck:	{ x:0,	y:700,	w:90,	h:80 },
		Mechanic:	{ x:0,	y:700,	w:90,	h:80 },
		Apache:	{ x:0,	y:800,	w:90,	h:80 },
		Bomber:	{ x:0,	y:900,	w:90,	h:80 },
		Soldier:	{ x:0,	y:1000,	w:20,	h:22 },
		TRex:		{ x:0,	y:1300,	w:90,	h:80 },
		Tower:		{ x:0,	y:1100,	w:90,	h:80 },
		Scout_Tower:	{ x:0,	y:1150,	w:22,	h:20 },
		SAM_Tower:	{ x:0,	y:1550,	w:90,	h:80 },
		Base:		{ x:0,	y:1200,	w:90,	h:80 },
		Factory:	{ x:0,	y:1400,	w:68,	h:56 },
		Research:	{ x:0,	y:1500,	w:50,	h:40 },
		Silo:		{ x:0,	y:1600,	w:46,	h:46 },
		},
	bullets: {
		bullet:	{ x:0,	y:0,		w:6,	h:6 }, 
		small_bullet:	{ x:0,	y:250,	w:4,	h:4 },
		missle:	{ x:0,	y:50,		w:8,	h:23 }, 
		airstrike:	{ x:0,	y:100,	w:38,	h:15 }, 
		bomb: 	{ x:0,	y:150,	w:12,	h:12 },
		plasma: { x:0,	y:200,	w:15,	h:15 },
		},
	elements: {
		fence:	{ x:0,	y:0,		w:100,h:26 }, 
		vfence:	{ x:0,	y:100,	w:26,	h:100 }, 
		mine:		{ x:0,	y:200,	w:15,	h:15 }, 
		block:	{ x:0,	y:300,	w:21,	h:21 },
		hill:	{ x:100,y:0,	w:136,	h:118 },
		rocks1:	{ x:250,y:0,	w:184,	h:108 },
		rocks2:	{ x:50,	y:150,	w:184,	h:108 },
		bones:	{ x:250,y:150,	w:136,	h:86 },
		crystals:{ x:0,y:50,	w:52,	h:44 },
		},
	};
