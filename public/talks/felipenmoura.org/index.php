<?php
    $env= 'desktop';
    $curLang= 'en';
    $pageConfig= false;
    
    //print_r($_SERVER['HTTP_USER_AGENT']);
    if( isset($_GET['IAmMobile']) || preg_match("/phone|mobile|android|symbian|fennec|gobrowser|iris|maemo|mib|minimo|netfront|symbos|opera\ mini|opera\ mob|semc|skyfire|teashark|teleca|uzardweb/i", $_SERVER['HTTP_USER_AGENT'], $matches)){
        $env= "mobile";
    }

    function isMobile(){
        return $GLOBALS['env'] == 'mobile'? true: false;
    }

    function addMenu(){
        if(!isMobile())
            include('menu.php');
    }

    function writeSection($sec, $noindent=false, $global=false){
        $file= "pages/$sec/$sec.php";

        if(!$noindent)
            echo "\t";

        if($global){
            echo "\n";
        }

        if(file_exists($file)){

            if(!$global)
                echo "<div id='$sec-container' class='page-container'><section id='$sec' class='page-element'>\n";

            //if( $sec == 'articles' ){
            include($file);
            /*}else{
                $content= file_get_contents($file);
                $lines= explode("\n", $content);

                for($i= 0, $l= count($lines); $i<$l; $i++){
                    echo "\t".($global? "": "    ").$lines[$i]."\n";
                }

                echo "\t";
            }*/

            if(!$global)
                echo "</section></div>\n\n";
            else
                echo "";
        }else{
            echo "<!-- could not find slide $sec -->\n\t<script>console.log('Failed loading slide $sec!')</script>\n\n";
        }
    }

    function echoIf($content, $alternative=""){
        if(isMobile()){
            echo $alternative;
        }else{
            echo $content;
        }
    }
    
    function root(){
        return str_replace('index.php', '', $_SERVER['PHP_SELF']);
    }
    function query(){
        $ret= Array();
        $output;
        if(isset($_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $output);
            $ret['query']= $output;
        }else
            $ret['query']= Array();
        if(isset($_SERVER['REDIRECT_QUERY_STRING'])){
            parse_str($_SERVER['REDIRECT_QUERY_STRING'], $output);
            $ret["redirect-query"]= $output;
        }else
            $ret["redirect-query"]= Array();
        
        return $ret;
    }
    function setLang($l){
        $l= strtolower($l);
        if($l == 'pt' || $l == 'pt-br'){
            $GLOBALS['curLang']= 'pt';
        }else{
            $GLOBALS['curLang']= 'en';
        }
    }
    function lang(){
        return isset($GLOBALS['curLang'])? $GLOBALS['curLang']: 'en';
    }
    function path(){
        return str_replace(root(), '', $_SERVER['REDIRECT_URL']);
    }
    function page(){
        
        if($GLOBALS['pageConfig'])
            return $GLOBALS['pageConfig'];
        
        $raw= str_replace(root(), '', path());
        $page= preg_replace('/\/.+/', '', $raw);
        
        if(stristr($raw, 'en')){
            setLang('en');
        }elseif(stristr($raw, 'pt')){
            setLang('pt');
        }
        $raw= preg_replace('/\/$/', '', str_replace('//', '/', preg_replace('/(en|pt)/i', '', $raw)));
        
        $ret= Array('page'=>'home', 'category'=>'', 'subcategory'=>'', 'file'=>'');
        
        $peaces= explode('/', $raw);
        $c= count($peaces);
        
        switch($c){
            case 0:
            case 1:
                $ret['page']= 'home';
                break;
            case 2:
                $ret['page']        = $peaces[0];
                $ret['file']        = $peaces[1];
                break;
            case 3:
                $ret['page']        = $peaces[0];
                $ret['category']    = $peaces[1];
                $ret['file']        = $peaces[2];
                break;
            case 4:
            default:
                $ret['page']        = $peaces[0];
                $ret['category']    = $peaces[1];
                $ret['subcategory'] = $peaces[2];
                $ret['file']        = $peaces[3];
                break;
        }
        $GLOBALS['pageConfig']= $ret;
        return $ret;
    }
    
    //echo "<pre>"; print_r(page()); exit;

?><!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Felipe N Moura - Web development and creation, demos, tutorials, talks and conferences, trainings and open source projects</title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
        <meta name="description" content="Web development and creation, demos, tutorials, talks and conferences, trainings and open source projects">
        <meta name="author" content="Felipe N. Moura">

        <meta property="og:image" content="TODO: add the image here!"/>
        <meta property="og:site_name" content="Felipe N. Moura . org"/>
        <meta property="og:type" content="blog"/>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script>
            if(!window.$){
                document.write('<'+'script src="<?php echo root(); ?>scripts/jquery-2.0.0.min.js"><'+'/script>');
            }
        </script>

        <?php echoIf('<link type="text/css" rel="stylesheet" href="'.root().'styles/context.css" />',
                     '<link type="text/css" rel="stylesheet" href="'.root().'styles/context-mob.css" />'); ?>

        <link type="text/css" rel="stylesheet" href="<?php echo root(); ?>styles/default.css" />

        <link rel="alternate" type="application/rss+xml" title="Felipe N. Moura RSS Feed" href="http://felipenmoura.org/feed/">
        <link rel="shortcut icon" type="image/x-icon" href="http://localhost/wordpress/wp-content/themes/web-cycle/imgs/felipenmoura-felipe-nascimento-moura-ico.png" />

    </head>
    <body class="<?php echo (isMobile()? 'mobile ': ''); ?>"
          data-root-path="<?php echo root(); ?>" >

        <?php
            echoIf("<!-- GLOBAL elements -->");
            writeSection('global-elements', true, true);
            echoIf("<!-- //GLOBAL elements -->\n\n\t");
        ?>
        <div id="pages-container">
            <div id="title-container">
            <div id="felipenmoura-title"></div>
        </div>
            <?php
                echoIf("<!-- Page sections -->\n\t");
                writeSection('home', true);
                writeSection('about');
                writeSection('projects');
                writeSection('trainings');
                /*writeSection('contact');*/
                writeSection('articles');
                writeSection('not-found');
            ?>
        </div>

        <?php
            if(!isMobile()){
        ?>

        <?php
            }
        ?>

        <script>
            window.contextData= {
                queryString: <?php echo json_encode(query()); ?>,
                path: "<?php echo root(); ?>",
                page: <?php echo json_encode(page()); ?>, 
                lang: "<?php echo lang(); ?>" 
            };
        </script>
        <script src="<?php echo root(); ?>scripts/context.js"></script>
        <?php
            // konami code
            if(!isMobile()){
                ?>

        <script>
            !function(){
                var kkeys = [], konami = "38,38,40,40,37,39,37,39,66,65";
                $(document).keydown(function(e) {
                  kkeys.push( e.keyCode );
                  if ( kkeys.toString().indexOf( konami ) >= 0 ){
                    $(document).unbind('keydown',arguments.callee);

                        $(document.body).append('<video id="konami-video">\
                            <source src="<?php echo root(); ?>videos/shadows.mp4" type="video/mp4">\
                            <source src="<?php echo root(); ?>videos/shadows.ogv" type="video/mp4">\
                        </video>\
                        <canvas id="konami-canvas"></canvas>');

                        window.ck= (function(_d){

                            var _video= _d.getElementById('konami-video'),
                                _canvas= _d.getElementById('konami-canvas'),
                                _ctx= _canvas.getContext('2d'),
                                _n= navigator,
                                _w= window,
                                _width= 0,
                                _height= 0,
                                _tmpCtx     = _d.createElement('canvas'),
                                _range      = 150,
                                _constructed= false,
                                _shadow     = 100;

                            _tmpCtx.width= _canvas.offsetWidth;
                            _tmpCtx.height= _canvas.offsetHeight;

                            _tmpCtx= _tmpCtx.getContext('2d');

                            var _videoPlaying= function(event){

                                var frame= '',
                                    data= null,
                                    i= 0,
                                    l,
                                    r, g, b;

                                if(!_width){
                                    _width= _video.offsetWidth;
                                    _height= _video.offsetHeight;
                                }

                                _tmpCtx.drawImage(_video, 0, 0, _width, _height);

                                frame= _tmpCtx.getImageData(0, 0, _width, _height);
                                data= frame.data;

                                l= data.length/4;
                                for(; i<l; i++){
                                    r= data[i*4];
                                    g= data[i*4+1];
                                    b= data[i*4+2];

                                    if(r > _range || g > _range || b > _range){
                                        frame.data[i*4+3]= 0;
                                    }else{
                                            frame.data[i*4+3]= 255-((r+g+b)/3);
                                    }
                                }

                                _ctx.putImageData(frame, 0, 0);
                            };


                            var _constructor= function(){

                                if(_constructed)
                                    return;

                                _constructed= true;

                                _video.addEventListener('ended', function(){
                                    _canvas.style.opacity= 0;
                                    $('#konami-video, #konami-canvas').remove();
                                });

                                var w= document.body.clientWidth,
                                    h= document.body.clientHeight;

                                _video.width= w;
                                _video.height= h;
                                _canvas.width= w;
                                _canvas.height= h;

                                _video.play();
                                _canvas.style.opacity= 1;
                                setInterval(_videoPlaying, 120);

                            }

                            return {
                                start: _constructor
                            };

                        })(document);

                        document.getElementById('konami-video').addEventListener('canplay', function(){
                            window.ck.start();
                        }, false);
                  }
                });
            }();


        </script>

                <?php
            }
        ?>

    </body>
</html>