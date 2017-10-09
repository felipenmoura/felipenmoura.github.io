// 8532341980
window.mobileBrowser= document.body.className.indexOf('mobile') >= 0? true: false;
window.firstLoad= true;

function isMobile(){
    return window.mobileBrowser;
}

function getWidth(){
    return isMobile()? document.body.clientWidth: 860;
}

function showPrevProject(){

    var el= window.cachedElements.projectsTray,
        projects= window.cachedElements.projects,
        w= getWidth(),
        pageWidth= (isMobile()? w: w+60 ),
        tmp= 0,
        mLeft= (pageWidth * window.cachedElements.currentProject)*-1;

    mLeft+= pageWidth;
    tmp= --window.cachedElements.currentProject;
    if(tmp<0){
        tmp= projects.length-1;
        mLeft= -1*(tmp * pageWidth);
        window.cachedElements.currentProject= tmp;
    }

    el.css('marginLeft', mLeft+'px');
}
function showNextProject(){
    var el= window.cachedElements.projectsTray,
        projects= window.cachedElements.projects,
        w= getWidth(),
        pageWidth= (isMobile()? w: w+60 ),
        mLeft= (pageWidth * window.cachedElements.currentProject)*-1;

    mLeft-= pageWidth;
    window.cachedElements.currentProject++;
    if(window.cachedElements.currentProject >= projects.length){
        mLeft= 0;
        window.cachedElements.currentProject= 0;
    }

    el.css('marginLeft', mLeft+'px');
}

function focusOnMenu(){
    var el= document.getElementById('menu-home');

    if(el){
        el.focus();
    }
}


$(document).ready(function(){

    var _settings= {
            readingMode: false,
            curPage: 'home',
            curIdx: 0,
            pages: {indexes: []},
            cache: {},
            curFontSize: 2,
            readingMode: false
        },
        _pageTransitionTimeout= false,
        _resizeSchedule = false,
        _pageToHide= false;

    var _removeUselessClasses= function(){
        //$(PPW.getCurrentSlide().el.parent()).removeClass('ppw-anim-fadeInRightBig');
    }

    var setArticlesLoading= function(bool){
        if(bool){
            document.getElementById('articles-list').style.opacity= 0;
            document.getElementById('article-loading').style.opacity= 1;
        }else{
            document.getElementById('articles-list').style.opacity= 1;
            document.getElementById('article-loading').style.opacity= 0;
        }
    };

    var requestArticle= function(){
        setArticlesLoading(false);
    };
    
    var _getPage= function(p){
        if(!p)
            return window.contextData.page['page']
        
        if(isNaN(p)){
            p= _settings['pages']['indexes'][p];
        }
        return _settings['pages'][p];
    }
    
    var _setBGColor= function(){

        var CSSClass= '',
            el= document.getElementById('bg-coloured');

        switch(PPW.getCurrentSlide().id){
            case 'about':
                CSSClass= 'night';
                break;
            case 'projects':
                CSSClass= 'city';
                break;
            case 'articles':
                CSSClass= 'bright-blue';
                break;
        }
        el.className= CSSClass;
    }
    
    /*var _scrolling= function(evt){

        var e= evt.originalEvent,
            d= e.wheelDelta,
            t= $('#pages-container')[0],
            //t= document.body,
            //x= t.scrollLeft,
            y= t.scrollTop,
            //m= $(t).find('.menu'),
            el= $('#title-container');
        //el.css('top', -y+'px');
    };*/
                
    var _exitReadingMode= function(){
        $('#articles-list').appendTo('#articles-list-container').removeClass('readingMode');
        _settings.readingMode= false;
        $('#mobile-menu').show();
    };

    var _enterReadingMode= function(){
        $('#articles-list').appendTo(document.body).addClass('readingMode');
        _settings.readingMode= true;
        $('#mobile-menu').hide();
    };
    
    var _preparePages= function(){
        var pagesList= document.querySelectorAll('#pages-container .page-container'),
            el= null,
            l= pagesList.length,
            i= 0;
        
        _settings.cache.pagesList= $(pagesList);
        
        for(; i<l; i++){
            el= pagesList[i];
            _settings['pages'][i]= el;
            _settings['pages']['indexes'][el.id.replace('-container', '')]= i;
        }
    };
    
    var _hidePage= function(p){
        var idx= _settings.pages.indexes[p],
            page= $(_settings.pages[_settings.curIdx]),
            cName= page[0].className;
        
        cName= cName.replace(/LEFT|RIGHT/, '');
        
        if(_settings.curIdx < idx){
            // move left
            cName+= " LEFT";
        }else{
            // move right
            cName+= " RIGHT";
        }
        cName.replace(/  /g, ' ');
        page[0].className= cName;
        
        setTimeout(function(){
            page.removeClass('IN');
            _pageToHide= page
            /*setTimeout(function(){
                page.removeClass('LEFT RIGHT');
            }, 410);*/
        }, 60);
        //console.log('SAI', _settings.pages[_settings.curIdx], _settings.curIdx, idx);
    };
    
    var _showPage= function(p){
        _hidePage(p);
        var page= _getPage(p),
            idx= _settings.pages.indexes[p],
            cName= page.className.replace(/LEFT|RIGHT/, '');
        
        //console.log('ENTRA', page, _settings.curIdx, idx);
        page= $(page);
        if(_settings.curIdx < idx){
            // move left
            cName+= ' RIGHT';
        }else{
            // move right
            cName+= ' LEFT';
        }
        cName= cName.replace(/  /g, ' ');
        page[0].className= cName;
        setTimeout(function(){
            page.addClass('IN');
            _decorate(p);
        }, 60);
        
    };
    
    var _goToPage= function(p, noPushState){
        
        var el= null;
        
        if(_settings.curPage != p || noPushState){
            el= $('#'+p+'-container');
            if(!el.length){
                return _goToPage('not-found');
            }
            
            if(noPushState){
                //el.addClass('currentPage');
                el.addClass('IN LEFT');
                _decorate(p);
            }else{
                _showPage(p);
            }
            _settings.curIdx= _settings.pages.indexes[p];
            _settings.curPage= _settings.pages[_settings.curIdx];
        }
        return true;
    };
    
    var _decorate= function(p){
        if(_pageTransitionTimeout)
            window.clearTimeout(_pageTransitionTimeout);
        
        
        document.body.setAttribute('role', p);
        
        _pageTransitionTimeout= setTimeout(function(){
            if(_pageToHide){
                _pageToHide.removeClass('LEFT RIGHT');
                _pageToHide= false;
            }
            
            switch(p){
                case 'home':
                    
                    break;
                case 'about':
                    break;
                case 'articles':
                    break;
                case 'projects':
                    break;
                case 'trainings':
                    break;
                default:
                    break;
            }
            
            _pageTransitionTimeout= false;
        }, 410);
    }
    
    var _prepareLinks= function(container){
        container= container || document.body;
        
        $(container).find('a:NOT(.preparedLink)').bind('click', function(event){
            
            var regEx= new RegExp(window.contextData.path+'(.*)', 'i'),
                match= false,
                linkAddr= false,
                idx= false;
            
            this.className= this.className+' preparedLink';
            
            if(this.target)
                return true;
            
            if(match= this.href.match(regEx)){
                // internal page
                if(match[1]){
                    linkAddr= match[1].replace(/\?.*/, '').replace(/([^a-z0-9\-\_\.]*)/ig, '');
                }else{
                    linkAddr= 'home';
                }
                idx= _settings.pages.indexes[linkAddr];
                
                if(idx || idx === 0){
                    _goToPage(linkAddr);
                }else{
                    // internal, but not a current page
                    return true;
                }
            }else{
                // external link
                this.target= this.href;
                return true;
            }
            
            event.preventDefault();
            event.stopPropagation();
            event.cancelBubble= true;
            event.returnValue= false;
            return false;
        });
    }
    
    /*var _setSizes= function(force){

        var w= null,
            pageWidth= null,
            mLeft= null;

        if(force){
            w= getWidth();
            w= getWidth(),
            pageWidth= (isMobile()? w: w+60 ),
            mLeft= (pageWidth * window.cachedElements.currentProject)*-1;

            $('#projects-list-container').find('article')
                                            .css('width', w+'px');

            window.cachedElements.projectsTray.css('marginLeft',
                                                    mLeft);

            return;
        }

        if(!_resizeSchedule){
            _resizeSchedule= window.setTimeout(function(){
                _resizeSchedule= false;
                _setSizes(true);
            }, 600);
        }

    };*/
    
    var _prepareTools= function(){
    
        var fontSizes= [
            '12px',
            '14px',
            '18px',
            '22px',
            '26px'
        ];
    
        $('#smallerFont').click(function(){
            var articlesContainer= $('.article-content');
            _settings.curFontSize--;
            if(_settings.curFontSize<0)
                _settings.curFontSize= 0;
            articlesContainer.css('font-size', fontSizes[_settings.curFontSize]);
        });
        $('#biggerFont').click(function(){
            var articlesContainer= $('.article-content');
            _settings.curFontSize++;
            if(_settings.curFontSize >= fontSizes.length)
                _settings.curFontSize= fontSizes.length-1;
            articlesContainer.css('font-size', fontSizes[_settings.curFontSize]);
        });
        $('#readingMode').click(function(){
            if(_settings.readingMode){
                _exitReadingMode();
            }else{
                _enterReadingMode();
            }
        });
    
        $('#close-reading-mode-btn').click(_exitReadingMode);
        
        $('#scrollTop-trigger').click(function(e){
            //document.body.scrollTop= 0;
            $(document.body).animate({'scrollTop': 0});
            //document.getElementById('ppw-slide-container-articles').scrollTop= 0;
            e.preventDefault();
            e.stopPropagation();
            return false;
        });

        $('#scrollBottom-trigger').click(function(e){
            var el= document.body;
            //el= document.getElementById('ppw-slide-container-articles')
            $(el).animate({'scrollTop': el.scrollHeight});

            e.preventDefault();
            e.stopPropagation();
            return false;
        });
    }
    
    var _init= function(){
        // if javascript has loaded, sets the pages for the absolute position
        $(document.body).addClass('DOM-content-loaded');
        
        document.createElement('sarcasm');
        
        _preparePages();
        
        // gets the current page from the URL
        _goToPage(_getPage(), true);
        _prepareLinks();
        _prepareTools();
        //window.onresize= _setSizes;
        
        //window.onscroll= _scrolling;
       // $('#pages-container').scroll(_scrolling);
    }
    
    _init();
    
    
    
    
    
/*
    PPW.addListener('onstart', function(){

        var _slidesContainer= $(document.body),
            _resizeSchedule= false;

        var _setCurrentSlideToContainer= function(){
            var c= _slidesContainer[0].className;
            _slidesContainer[0].className= c.replace(/(^| )ppw\-current\-slide\-(.+)( |$)/g, '');
            _slidesContainer.addClass('ppw-current-slide-'+PPW.getCurrentSlide().id);
        }


        if(!isMobile()){
            //if(window.firstLoad){
              //  window.firstLoad= false;
                //window.clearTimeout(window.focusingEl);
                //window.focusingEl=  setTimeout(function(){
                  //  if(PPW.getCurrentSlide().id == 'home')
                    //    document.getElementById('menu-home').focus();
                    //$(slides.current.el).find('[tabindex]').eq(0)[0].focus();
                //}, 1000);
            //}else{
            //    document.querySelector('#accessibility-welcome').focus();
            //}
        }


        PPW.addListener('onslidechange', function(slides){

            var mMenu= $('#mobile-menu'),
                tabIndexedEl= null,
                noSet= false;

            if(_readingMode)
                _exitReadingMode();

            console.log(slides);
            if(slides.current.id == 'articles'){

                if(slides.previous.id == 'articles'){
                    noSet= true;
                    if(slides.current.path){
                        document.getElementById('ppw-slide-container-articles').scrollTop= 0;
                        setArticlesLoading(true);
                        requestArticle(slides.current.path);
                    }
                }else{
                    PPW.animate('#tags, #article-tools', 'fadeIn', {delay: '1s'});
                }

            }else if(slides.previous.id == 'articles'){
                PPW.animate('#tags, #article-tools', 'fadeOut', {delay: '0s'});
            }

            if(mMenu.length && mMenu.hasClass('mmenu-open')){
                mMenu.removeClass('mmenu-open');
            }

            window.clearTimeout(window.focusingEl);
            window.focusingEl=  setTimeout(function(){
                //if(PPW.getCurrentSlide().id == 'home')
                    //document.getElementById('menu-home').focus();
                    document.querySelector('#accessibility-welcome').focus();
                //$(slides.current.el).find('[tabindex]').eq(0)[0].focus();
            }, 1000);

            if(!noSet){
                $('#title-container').css('top', '0px');
                _setCurrentSlideToContainer();
                _setBGColor();
            }
        });


        

        

       

        var _setSizes= function(force){

            var w= null,
                pageWidth= null,
                mLeft= null;

            if(force){
                w= getWidth();
                w= getWidth(),
                pageWidth= (isMobile()? w: w+60 ),
                mLeft= (pageWidth * window.cachedElements.currentProject)*-1;

                $('#projects-list-container').find('article')
                                             .css('width', w+'px');

                window.cachedElements.projectsTray.css('marginLeft',
                                                       mLeft);

                return;
            }

            if(!_resizeSchedule){
                _resizeSchedule= window.setTimeout(function(){
                    _resizeSchedule= false;
                    _setSizes(true);
                }, 600);
            }

        };

        var _bindEvents= function(){

            var articlesContainer= false,
                curentFontSize= false,
                el= null,
                w= getWidth(),
                articles= null;
            //$(document.body).bind('DOMMouseScroll', _scrolling);
            $('.ppw-slide-container').scroll(_scrolling);
            window.onresize= _setSizes;

            //_setSizes();

            var el= $('.project-list .project').eq(0);
            //el.css('opacity', '1');

            articles= $('#projects-list-container').data('current', el[0])
                                                   .find('article');

            window.cachedElements.projectsTray.css('width', (w*articles.length*2) + 'px');
            articles.css('width', w+ 'px');

            $(document).ready(function(){

                var fontSizes= [
                        '12px',
                        '14px',
                        '18px',
                        '22px',
                        '26px'
                    ];
                $('#smallerFont').click(function(){
                    var currentSize= curentFontSize;
                    articlesContainer= $('.article-content');
                    currentSize= (currentSize||currentSize===0)? currentSize: 2;
                    currentSize--;
                    currentSize= currentSize<0? 0: currentSize;
                    curentFontSize= currentSize;
                    currentSize= fontSizes[currentSize];
                    articlesContainer.css('font-size', currentSize);
                });
                $('#biggerFont').click(function(){
                    var currentSize= curentFontSize;
                    articlesContainer= $('.article-content');
                    currentSize= (currentSize||currentSize===0)? currentSize: 2;
                    currentSize++;
                    currentSize= currentSize>4? 4: currentSize;
                    curentFontSize= currentSize;
                    currentSize= fontSizes[currentSize];
                    articlesContainer.css('font-size', currentSize);
                });

                $('#readingMode').click(function(){
                    if(_readingMode){
                        _exitReadingMode();
                    }else{
                        _enterReadingMode();
                    }
                });

                $('#scrollTop-trigger').click(function(e){
                    document.getElementById('ppw-slide-container-articles').scrollTop= 0;
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                });

                $('#scrollBottom-trigger').click(function(e){
                    var el= document.getElementById('ppw-slide-container-articles')

                    el.scrollTop= el.scrollHeight;

                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                });

                $('#close-reading-mode-btn').click(_exitReadingMode);

            });

        };

        var _addSocialButtons= function(){

            // FB
            (function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=281929191903584";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));

            // Twitter
            !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");

            // G+
            (function() {
                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                po.src = 'https://apis.google.com/js/plusone.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
            })();
        }

        _addSocialButtons();
        _setBGColor();
        _bindEvents();
        _setCurrentSlideToContainer();

      
    });

    /*if(location.hash.indexOf('contact')>=0){
        openLayer= true;
    }*/


    window.cachedElements= {
        projectsTray: $('#projects-tray'),
        projects: $('#projects-tray .project'),
        currentProject: 0
    };

});


/*function showContactPanel(){
    var el= $('#contact-panel-container');
    el.data('visible', true);
    PPW.pushState('contact');
    PPW.animate(el, 'fadeInUpBig');
    $('#contact-panel-container .contact-form-container').css('height', el[0].offsetHeight - 200 + 'px');
};

function hideContact(){
    var el= $('#contact-panel-container');
    if(el.data('visible')){
        el.data('visible', false);
        history.go(-1);
        PPW.animate(el, 'fadeOutDownBig');
    }
};
*/