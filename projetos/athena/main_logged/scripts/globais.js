function gebi(id)
{
	return document.getElementById(id);
}
var browser						= (navigator.appName == "Microsoft Internet Explorer")? 'ie' : 'ff';
var ar_dd_obj					= Array();
var ob_block_to_resize			= null;
var s_block_to_resize_direction	= null;
var ar_images_preload			= Array();
var start_position_l			= null;
var start_position_r			= null;
var start_position_t			= null;
var start_position_b			= null;
var start_size_h				= null;
var start_size_w				= null;
var blockInFocus				= null;
var blockShadow					= true;
var funcionarios_filiais_content= false;
var flp_script_var				= '<flp_script>';
var dados_agenda_contato;
var maxiPadding					= 22;
var dragOpacity					= false;

var image_back_title			= new Image();
	image_back_title.src		= 'img/top_blue_focus.gif';
var image_back_bottom			= new Image();
	image_back_bottom.src		= 'img/bottom.gif';

var image_back_left				= new Image();
	image_back_left.src			= 'img/left.gif';
var image_back_right			= new Image();
	image_back_right.src		= 'img/right.gif';
	
var image_min					= new Image();
	image_min.src				= 'img/min_block_over.gif';
var image_max					= new Image();
	image_max.src				= 'img/max_block_over.gif';
var image_close					= new Image();
	image_close.src				= 'img/close_block_over.gif';

var image_load					= new Image();
	image_load.src				= 'img/loader2.gif';

var zMax						= 99999;
var objIcoSelected				= null;
var enderecoCount				= 0;
var settedGrupoGerUsuarioGrupo	= false;
var refresh						= false;
var selectedNode				= null;
var window_open					= false;

var flp_dd_dragable_list		= Array();
var flp_dd_GLOBAL_objToDrag		= false;
var flp_dd_GLOBAL_left			= 0;
var flp_dd_GLOBAL_top			= 0;
//var zMax= 999;

var loadStatus					= "";
var srcPageLoaded				= "";
var targetElement				= "";
var stayLoading					= false;
//var arAjax= Array();
var loading						= false;

var f2j_selectedOptions			= null;

var toResize					= null;
var toResize					= Array();

var themonths					= ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho', 'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
var todaydate					= new Date()
var curmonth					= todaydate.getMonth()+1 //get current month (1-12)
var curyear						= todaydate.getFullYear() //get current year

var conf_closeAnim				= true;
var conf_minAnim				= true;