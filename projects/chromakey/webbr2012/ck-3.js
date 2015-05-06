// colocando a o quadro do video em um canvas

window.ck= (function(_d){
    
    // PRIVATE
    var _video      = _d.getElementById('video'),
        _canvas     = _d.getElementById('canvas'),
        _ctx        = _canvas.getContext('2d'),
        _n          = navigator,
        _w          = window,
        _width      = 0,
        _height     = 0;
    
    var _videoClick= function(event){
        var x= event.offsetX,
            y= event.offsetY;
        
        if(!_width){
            _width= _video.offsetWidth;
            _height= _video.offsetHeight;
        }
        
        _ctx.drawImage(_video, 0, 0, _width, _height);
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
              
              _video.addEventListener('click', _videoClick);
              
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