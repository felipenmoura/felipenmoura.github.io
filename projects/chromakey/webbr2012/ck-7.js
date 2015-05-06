// adicionando escolha de cores

window.ck= (function(_d){
    
    // PRIVATE
    var _video      = _d.getElementById('video'),
        _canvas     = _d.getElementById('canvas'),
        _ctx        = _canvas.getContext('2d'),
        _n          = navigator,
        _w          = window,
        _width      = 0,
        _height     = 0,
        _tmpCtx     = _d.createElement('canvas'),
        _range      = 150;
    
    var _colors= [0, 0, 200];
    
    _tmpCtx.width= _canvas.offsetWidth;
    _tmpCtx.height= _canvas.offsetHeight;
    
    _tmpCtx= _tmpCtx.getContext('2d');
    
    var _videoClick= function(event){
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
            
            //if(r>_range && g>_range && b>_range){
            if(Math.abs(r-_colors[0]) < 250-_range
                &&
               Math.abs(g-_colors[1]) < 250-_range
                &&
               Math.abs(b-_colors[2]) < 250-_range){
                frame.data[i*4+3]= 0;
            }
        }
        
        _ctx.putImageData(frame, 0, 0);
    };
    
    // CONSTRUCTOR
    var _constructor= function(){
        
        _w.URL = _w.URL || _w.webkitURL;
        _n.getUserMedia  = _n.getUserMedia || _n.webkitGetUserMedia ||
                           _n.mozGetUserMedia || _n.msGetUserMedia;

        if(_n.getUserMedia){
            _n.getUserMedia({video: true}, function(stream) {

              try{
                  stream= _w.URL.createObjectURL(stream);
              }catch(e){}

              _video.src = stream;
              _video.play();
              
              //_video.addEventListener('click', _videoClick);
              setInterval(_videoClick, 120);
              _video.style.visibility= 'hidden';
              
              _d.getElementById('range').addEventListener('change', function(){
                  _range= 255-this.value;
              }, false);
              
            }, function(){
                alert('Failed');
            });
            
        }else{
            alert('you browser does not support cammera access');
        }
    };
    _constructor();
    
    // PUBLIC
    return {
        
    };
    
})(document);