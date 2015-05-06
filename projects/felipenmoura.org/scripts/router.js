var Router= {
    defaultLanding: 'home',
    goTo: function(href){
        if(typeof href == 'string')
            history.pushState({}, href, href);
        else
            history.pushState({}, href.currentControler+", "+href.currentViewer, href.currentControler+"/"+href.currentViewer);
        this.loadFromStateChange();
    },
    parse: function(str){
        var o= {
            protocol: str.split('\:')[0] + "://"
        }
        str= str.replace(o.protocol, '');
        var pieces= str.split('/');
        o.domain= pieces.shift();
        o.currentPath= pieces.join('/');
        o.hash= o.currentPath.split('#')[1]||'';
        o.path= o.currentPath.replace("#"+o.hash, '').replace(o.protocol, '').split(/\/|\\/g);
        o.currentControler= o.path[1];
        o.currentViewer= o.path[2]||'';
        return o;
    },
    init: function(){
        this.location= location;
        this.pathName= location.pathname;
        this.protocol= this.location.toString().split('\:')[0] + "://";
        this.domain= this.location.host;
        this.currentHash= this.location.hash;
        this.currentPath= this.location.pathname.replace(/^\/|\\/, '');
        this.hash= this.location.hash;
        this.path= this.currentPath.replace(this.protocol, '').replace(this.hash, '').split(/\/|\\/g);
        this.currentControler= this.path[1]||null;
        this.currentViewer= this.path[2]||null;
        this.variables= (this.hash.split('?')[1]||'').split('&');
        
        this.fullPath= location.href;
        
        var i= this.variables.length, tmp, vrbls= {};
        while(i--)
        {
            tmp= this.variables[i].split('=');
            vrbls[tmp[0]]= tmp[1];
        };
        this.variables= vrbls;
        console.log(this)
        if(!this.currentControler)
        {
            this.goTo(this.defaultLanding);
        }
    },
    loadFromStateChange: function(event){
        Router.init();
        Universe.showViewers(Router.currentControler);
    }
};
/*
 *here, it was time for Firefox to drive me fucking crazy!
 *Firefox does not look to trigger this event!
window.addEventListener('popstate', function(event){
    Router.loadFromStateChange(event);
}, false);
 */
$(document).ready(function(){
    //Universe.showViewers('home');
    //Router.init();
});