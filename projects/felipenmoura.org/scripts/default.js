var Universe= {
    baseDir: 'http://localhost/felipenmoura.org/',
    timeBetweenMoviments: 200,
    isAnimating: false,
    align: function(){
        var u= document.getElementById('universe');
        if(u.className != 'alignedUniverse')
        {
            this.aligned= true;
            u.className= 'alignedUniverse';
        }else{
            this.aligned= false;
            u.className= '';
        }
    },
    goToOlder: function(callback){
        if(Universe.isAnimating)
            return false;
        Universe.calback= callback||function(){};
        Universe.isAnimating= true;
        Universe.tempElement= $('.front').eq(0);
        Universe.tempElementDate= $('.articleDateFront').eq(0);
        Universe.tempElementDate.removeClass('articleDateFront')
                                .hide();
        Universe.tempElement.addClass('removingFirst');
        
        setTimeout(function(){
            Universe.tempElement.removeClass('removingFirst');
            Universe.tempElement.addClass('hiddenLayer');
            Universe.tempElement.removeClass('front');
            
            $('.middle').removeClass('middle').addClass('front');
            $('.articleDateMiddle').removeClass('articleDateMiddle').addClass('articleDateFront');
            
            setTimeout(function(){
                $('.behind').removeClass('behind').addClass('middle');
                $('.articleDateBehind').removeClass('articleDateBehind').addClass('articleDateMiddle');
                setTimeout(function(){
                    Universe.tempElement.addClass('behind').css('opacity', 1)
                                        .removeClass('hiddenLayer');
                    Universe.tempElementDate.addClass('articleDateBehind').fadeIn('slow', Universe.calback);
                    Universe.isAnimating= false;
                    Universe.tempElement= false;
                }, Universe.timeBetweenMoviments);
            }, Universe.timeBetweenMoviments)
        }, Universe.timeBetweenMoviments*2);
    },
    goToNewer: function(callback){
        if(Universe.isAnimating)
            return false;
        Universe.calback= callback||function(){};
        Universe.isAnimating= true;
        Universe.tempElement= $('.behind').eq(0);
        Universe.tempElementDate= $('.articleDateBehind').eq(0);
        Universe.tempElementDate.fadeOut('fast');
        
        $('.behind').addClass('hiddenLayer');
        setTimeout(function(){
            Universe.tempElement.removeClass('behind').addClass('removingFirst');
            Universe.tempElementDate.removeClass('articleDateBehind');
            
            $('.middle').addClass('behind').removeClass('middle');
            $('.articleDateMiddle').removeClass('articleDateMiddle').addClass('articleDateBehind');
            setTimeout(function(){
                $('.front').addClass('middle').removeClass('front');
                $('.articleDateFront').removeClass('articleDateFront').addClass('articleDateMiddle');
                
                setTimeout(function(){
                    Universe.tempElement.addClass('front').removeClass('hiddenLayer').removeClass('removingFirst');
                    Universe.tempElementDate.addClass('articleDateFront').fadeIn('fast');
                    Universe.isAnimating= false;
                }, Universe.timeBetweenMoviments*1.5);
                
            }, Universe.timeBetweenMoviments);
        }, Universe.timeBetweenMoviments);
    },
    focusOnSecond: function(){
        Universe.goToOlder();
        return false;
    },
    focusOnLast: function(){
        Universe.goToOlder(Universe.goToOlder);
    },
    showViewers: function(controler){
        var c= document.getElementById(controler);
        if(!c)
            return;
        if(Universe.currentControler)
        {
            Universe.currentControler.className= '';
            setTimeout((function(){return function(){
                Universe.currentControler.style.display= 'none';
                Universe.currentControler= false;
                Universe.showViewers(controler);
            }})(controler), 510);
            return;
        }
        Universe.currentControler= c;
        Universe.currentControler.style.display= '';
        setTimeout(function(){
            c.className= 'openedSubmenu';
        }, 100);
    }
}

$(document).ready(function(){
    var adjustLayout= function(){
        var d= document;
        d.getElementById('globalDiv')
         .style
         .height= (d.body.offsetHeight - d.getElementById('footer')
                                          .offsetHeight - 30)+"px";
    };
    window.onload= adjustLayout;
    window.onresize= adjustLayout;
    
    if(history.pushState)
    {
        $('.articleDate').click(function(){
            if($(this).hasClass("articleDateFront"))
            {
                Universe.align();
            }else if($(this).hasClass("articleDateBehind"))
                  {
                      Universe.focusOnLast()
                  }else{
                        Universe.focusOnSecond()
                       }
            return false;
        });
        $('a').each(function(){
            //var href= Router.parse(this.href);
            if(true || href.domain == Router.domain)
            {
                this.onclick= function(){
                    var href= this.getAttribute('href');
                    var url= Universe.baseDir+href;
                    //Router.goTo(url);
                    Universe.showViewers(href)
                    return false;
                }
            }
        })
    }
    $('#arrowOlderRightPannel, #arrowOlder').bind('mouseover', function(){
        $('#arrowOlderRightPannel, #arrowOlder').addClass('arrowOlderHovered');
    }).bind('mouseout', function(){
        $('#arrowOlderRightPannel, #arrowOlder').removeClass('arrowOlderHovered');
    }).bind('click', function(){
        Universe.goToOlder();
    });
    $('#arrowNewer').bind('click', function(){
        Universe.goToNewer();
    });
    if(!Universe.currentControler)
    {
        Universe.showViewers(Router.defaultLanding);
    }
    $('#alignUniverseButton').click(function(){
        Universe.align();
        if(Universe.aligned)
            this.innerHTML= 'Lean back';
        else
            this.innerHTML= 'Line up';
        $(this).toggleClass('applyEffectButton');
    })
})
var r= function(){
    self.location.href= Universe.baseDir;
};