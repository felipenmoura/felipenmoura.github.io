window.PPLX= new (function(){
    var lang= 'en',
        subtitles= [],
        _currentSlide= 0,
        _slides= [];

    $.ajax({
        url: 'subtitles/'+lang+".json",
        type: 'get',
        data: {lang: lang},
        async: false,
        error: function(xhr, data){
            console.error('Failed loading subtitles');
        },
        success: function(data){
            subtitles= data;
        }
    });

    var _nextSlide= function(){
    
        if(_currentSlide + 1  > _slides.length)
            return false;
        
        _currentSlide++;
        $(document.body).removeClass('slide-'+(_currentSlide-1)).addClass('slide-'+(_currentSlide-1)+'-gone');
        setTimeout(function(){
            $(document.body).addClass('slide-'+_currentSlide);
        }, 600);
        //self.location.href= self.location.href.replace(/\#.+/, '')+'#'+(_currentSlide+1);
    };

    var _prevSlide= function(){
        
    };

    var _fixSize= function(){
        $('.layer-1, .layer-2, .layer-3').css({
            width: document.getElementById('stage').offsetWidth + 200,
            left: document.getElementById('stage').offsetLeft - 100
        });
        //document.body.clientWidth;
    }

    var _init= function(){
        
        _fixSize()
        var l= location.href.indexOf('#');
        
        _currentSlide= parseInt(l>0? location.href.substring(l+1): 1);
        _slides= $('section');
        
        $(document.body).addClass('slide-'+_currentSlide);
        
        $(document.body).click(_nextSlide);
        $(document.body).bind('keyup', function(e){
            if(e.keyCode == 40 || e.keyCode == 39 || e.keyCode == 32 || e.keyCode == 13){
                _nextSlide();
            }else if(e.keyCode == 37 || e.keyCode == 38)
                    _prevSlide();
        });
    };

    return {
        init: _init
    };
})();

$(document).ready(function(){
    PPLX.init();
});