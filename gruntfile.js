const cpy = require('cpy')

module.exports = function(grunt) {

    const fs = require('fs-extra')
    var NunJucks = require('nunjucks'),
        // fs = require('fs'),
        //nunEnv = new NunJucks.FileSystemLoader(['templates']),
        defaultLang = 'en',
        DOMAIN = 'http://felipenmoura.com/',
        OGIMAGE= 'resources/og/fb-home.png',
        DEFAULT_ART_IMG= 'resources/og/fb-articles.jpg',
        DEFAULT_ART_DESC = "Articles from Felipe, talking about web development, technology, important announcements, some news and ideas, besides some personal thoughts, as well!",
        months = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sept",
            "Oct",
            "Nov",
            "Dec"
        ],
        pageTitle = 'felipenmoura';

    function stripTags (str, count) {
        return str && str.replace? str.replace(/(<([^>]+)>)/ig, ''): str;
    }

    nunEnv = new NunJucks.Environment(new NunJucks.FileSystemLoader(''));
    //nunEnv = new NunJucks.FileSystemLoader(['templates']);
    nunEnv.addFilter('striptags', stripTags);

    function formatDate(date){
        var tmpDt = new Date(date);
        var day = tmpDt.getDate();
        switch(day % 10){
                case 1:
                    day+= "st";
                break;
                case 2:
                    day+= "nd";
                break;
                case 3:
                    day+= "rd";
                break;
                default:
                    day+= "th";
                break;
        }
        return months[tmpDt.getMonth()] + ' '+ day +', '+tmpDt.getFullYear();
    }

    function applyURL(val){
        return val.replace(/(https?:\/\/[^ \n\!\?\<]+)/ig, "<a href=\"$1\" target=\"_blank\">$1</a>")
    }

    require('./src/scripts/create.js')(grunt);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        sass: {
            dist: {
                options: {
                    style: 'expanded'
                },
                files:  [{
                    expand: true,
                    cwd: 'src/scss',
                    src: ['*.scss'],
                    dest: 'public/styles',
                    ext: '.css'
                }]
            }
        },

        uglify : {
            all: {
                files: {
                    'public/scripts/default.min.js': ['src/scripts/default.js']
                }
            },
            options: {}
        },

        cssmin: {
            target: {
                files: [{
                    expand: true,
                    cwd: 'public/styles/',
                    src: ['*.css', '!*.min.css'],
                    dest: 'public/styles/',
                    ext: '.min.css'
                }]
            }
        },

        scsslint: {
            allFiles: [
                'src/scss/**/*',
            ],
            options: {
                //bundleExec: true,
                config: 'scss-lint.yml',
                //reporterOutput: 'scss-lint-report.xml',
                colorizeOutput: true
            },
        },

        jslint: {
            all: ['gruntfile.js', 'src/scripts/**.js']
        },

        create: {
            all: {
                //
            }
        },

        compileTemplates: {
            en: {
                talks: JSON.parse(fs.readFileSync('_bindings/talks.json', 'utf8')),
                //videos: fs.readFileSync('_bindings/videos.json', 'utf8'),
                labs: JSON.parse(fs.readFileSync('_bindings/labs.json', 'utf8')),
                photos: JSON.parse(fs.readFileSync('_bindings/photos.json', 'utf8'))
            }//,
            //pt: "def"
        },

        compileArticles: {
            en: {},
            //pt: {}
        },

        watch: {
          files: ["_templates/**.html", "_bindings/**", "scss/**.scss", "scripts/**.js", "./articles/**/_content.html", "./articles/**/_meta.json"],
          tasks: ['build']
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-nunjucks');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    //grunt.loadNpmTasks('grunt-scss-lint');
    //grunt.loadNpmTasks('grunt-jslint');

    grunt.registerMultiTask('compileArticles', 'generates the articles files.', function() {
        var done = this.async();
        done();
    });

    grunt.registerMultiTask('compileTemplates', 'Saves the files to be statified.', function() {
        var idxFile = 'public/index.html';
        var data = this.data;
        var done = this.async();
        var videosList = "";
        data.lang= this.target;

        if(this.target != defaultLang){
            if(!fs.existsSync(this.target)){
                fs.mkdirSync(this.target);
            }
            idxFile = 'public/' + this.target + '/index.html';
        }

        //https://www.youtube.com/playlist?list=PL2LsDS820I8Qg8xXkgXTty5BGiqAOJcVB
        //https://gdata.youtube.com/feeds/api/users/userId/playlists?v=2
        //https://gdata.youtube.com/feeds/api/users/PL2LsDS820I8Qg8xXkgXTty5BGiqAOJcVB/playlists?v=2
        //https://gdata.youtube.com/feeds/api/playlists/PL2LsDS820I8Qg8xXkgXTty5BGiqAOJcVB?v=2&alt=json&callback=foo
        var options = {
            hostname: 'gdata.youtube.com',
            port: 80,
            path: '/feeds/api/playlists/PL2LsDS820I8Qg8xXkgXTty5BGiqAOJcVB?v=2&alt=json&callback=foo',
            method: 'GET',
            headers: { 'Content-Type': 'text/javascript' }
        };

        function applyURLsTo(data, target, prop){
            if(data[target]){
                data[target] = data[target].map(function(val){
                    val[prop] = applyURL(val[prop]);
                    return val;
                });
            }
        }

        function createIndexesForArticles(data, cb){
            var artPath = 'articles/',
                metaData,
                tplPath = '_templates/index.html',
                tplArtPath = '_templates/article.html',
                validArticles= [],
                renderedArticle,
                articlesList= [],
                tmpDt;

            fs.readdir('src/' + artPath, function(err, files){
                if(err){
                    console.error("Failed reading articles");
                }

                // get all the meta datas
                files.forEach(function(cur){
                    if(cur[0] == '.' || !fs.lstatSync('src/' + artPath + cur).isDirectory()){
                        return;
                    }

                    metaData = JSON.parse( fs.readFileSync('src/' + artPath + cur + '/_meta.json') );
                    metaData.name= cur;
                    metaData.oCreationDate = metaData.creationDate;
                    metaData.ISOCreationDate = (new Date(metaData.creationDate)).toISOString();
                    metaData.creationDate = formatDate(metaData.creationDate);
                    metaData.oTags = metaData.tags || [];
                    metaData.tags = metaData.tags? metaData.tags.join(', '): 'no tags';
                    if(metaData.status == 'published'){
                        validArticles.push(metaData);
                    }
                });

                // sort them out
                validArticles.sort(function(left, right){
                    //console.log(new Date(left.oCreationDate), new Date(right.oCreationDate), new Date(left.oCreationDate) >= new Date(right.oCreationDate));
                    return new Date(left.oCreationDate) - new Date(right.oCreationDate);
                });

                // set the previous and next links
                validArticles.forEach(function(cur, i){
                    console.log(cur.title, cur.oCreationDate);
                    articlesList.push({
                        title: cur.title,
                        tags: cur.tags,
                        name: cur.name
                    });

                    if(validArticles[i-1]){
                        validArticles[i].previous = validArticles[i-1];
                    }else{
                        validArticles[i].previous = false;
                    }
                    if(validArticles[i+1]){
                        validArticles[i].next = validArticles[i+1];
                    }else{
                        validArticles[i].next = false;
                    }

                    validArticles[i].url = '/'+artPath + cur.name;
                    validArticles[i].fullURL = DOMAIN + artPath + cur.name;

                });

                articlesList.reverse();

                data.articlesList = articlesList;

                // create the index files for each one
                validArticles.forEach(function(cur){
                    metaData = cur;

                    // create index-ajax for each article
                    metaData.content = fs.readFileSync( 'src/' + artPath + cur.name + '/_content.html', 'utf-8');
                    //metaData.content = metaData.content.replace(/\n/g, '<br/>\n');
                    metaData.content = metaData.content.replace(/\<pre class\="lang:javascript decode\:1 " >/ig, '<pre class="line-numbers"><code class="language-javascript">');
                    metaData.content = metaData.content.replace(/\<pre class\="lang:css decode\:1 " >/ig, '<pre class="line-numbers"><code class="language-css">');
                    metaData.content = metaData.content.replace(/\<pre class\="lang:html decode\:1 " >/ig, '<pre class="line-numbers"><code class="language-markup">');
                    metaData.content = metaData.content.replace(/\<pre (lang|sh)\=["']javascript["']\>/ig, '<pre class="line-numbers"><code class="language-javascript">');
                    metaData.content = metaData.content.replace(/\<pre (lang|sh)\=["']css["']\>/ig, '<pre class="line-numbers"><code class="language-css">');
                    metaData.content = metaData.content.replace(/\<pre (lang|sh)\=["']html["']\>/ig, '<pre class="line-numbers"><code class="language-markup">');
                    metaData.content = metaData.content.replace(/\<pre lang\=["']([0-9a-z_\-]+)["']\>/ig, '<pre class="line-numbers"><code class="language-$1">');
                    metaData.content = metaData.content.replace(/\<\/pre>/ig, '</code></pre>');
                    metaData.content = metaData.content.replace(/\<img s/ig, '<img itemprop="image" s');
                    //metaData.content = metaData.content.replace(/\<(h[2-6]) /i, '<$1  itemprop="alternativeHeadline" ');
                    metaData.colourId = Math.floor(Math.random() * 6 ) + 1;
                    data.pageType = metaData.pageType = 'articles';

                    data.ogImage = DOMAIN + (metaData.headerImg || DEFAULT_ART_IMG).replace(/^\//, '');

                    data.fullURL = DOMAIN + artPath + cur.name + '/';
                    data.pageTitle = 'felipenmoura ' + metaData.pageType + ': ' + stripTags(metaData.title);
                    data.socialDesc = addslashes(metaData.resume || 'Meet the Felipe N. Moura personal page with his works, projects, demos, talks and articles.');

                    renderedArticle = nunEnv.render(tplArtPath, metaData);
                    // the index for ajax requests
                    try {
                        fs.mkdirSync('public/' + artPath + cur.name)
                    } catch (error) {
                        // nothing, thanks
                    }
                    fs.writeFileSync('src/' + artPath + cur.name + '/index-ajax.html',
                                     renderedArticle,
                                     'utf-8');
                    // index inside the article itself
                    metaData.oContent = metaData.content;
                    metaData.content = fs.readFileSync( 'src/' + artPath + cur.name + '/index-ajax.html', 'utf-8');
                    metaData.currentArticle = data.currentArticle = metaData.content;
                    fs.writeFileSync('src/' + artPath + cur.name + '/index.html',
                                     nunEnv.render(tplPath, data),
                                     'utf8');
                    data.currentArticleMetaData = metaData;
                });

                // now we coppy the resources
                Promise.all([
                    copyDir('src/resources', 'public/resources'),
                    copyDir('./images', 'public/images'),
                    copyDir('./sh', 'public/sh'),
                    copyDir('./src/articles', 'public/articles'),
                    copyDir('./src/labs', 'public/labs'),
                    copyDir('./sitemap.xml', 'public/sitemap.xml'),
                    copyDir('./robots.txt', 'public/'),
                    copyDir('./safari-pinned-tab.svg', 'public/'),
                    copyDir('./mstile-150x150.png', 'public/'),
                    copyDir('./manifest.json', 'public/'),
                    copyDir('./felipenmoura-felipe-nascimento-moura-favico.png', 'public/'),
                    copyDir('./feed.xml', 'public/'),
                    copyDir('./favicon-16x16.png', 'public/'),
                    copyDir('./favicon-32x32.png', 'public/'),
                    copyDir('./favicon.ico', 'public/'),
                    copyDir('./BingSiteAuth.xml', 'public/'),
                    copyDir('./browserconfig.xml', 'public/'),
                    copyDir('./apple-touch-icon.png', 'public/'),
                    copyDir('./android-chrome-192x192.png', 'public/'),
                    copyDir('./android-chrome-256x256.png', 'public/'),
                    copyDir('./404.html', 'public/'),
                    copyDir('./talks', 'public/talks'),
                    copyDir('./CNAME', 'public/')
                ]).then(function () {
                    // return the last article
                    cb(data, validArticles);
                })
            });
        }

        function copyDir (from, to, cb) {
            return new Promise(function (resolve, reject) {
                if (to.substr(-1) === '/') {
                    to += from.split('/').pop()
                }
                fs.copy(from, to, function (err) {
                    if (err) {
                        return console.error('Failed coppying files!', err);
                    }
                    console.log('>>> copied ', from)
                    resolve()
                });
            })
        }

        function copyIndexTo (where, data) {
            if(!fs.existsSync('public/' + where)){
                fs.mkdirSync('public/' + where);
            }

            //var idxOrig = fs.readFileSync('./index.html', 'utf-8');
            //fs.writeFileSync(where + '/index.html', idxOrig, 'utf-8');
            fs.writeFileSync('public/' + where + '/index.html',
                             nunEnv.render('_templates/index.html', data), 'utf8');

            //fs.createReadStream('./index.html').pipe(fs.createWriteStream(where + '/index.html'));
        }

        function addslashes(str) {
            return str.replace(/"/g, '&quote;');
            return str.replace(/'/g, "&#39;");
//            return (str + '')
//                .replace(/[\\"']/g, '\\$&')
//                .replace(/\u0000/g, '\\0');
        }

        function render () {

            applyURLsTo(data, 'talks', 'description');
            applyURLsTo(data, 'labs', 'description');

            createIndexesForArticles(data, function then (data, list){

                data.ogImage = DOMAIN + OGIMAGE;

                data.socialDesc = addslashes(data.resume || 'Meet the Felipe N. Moura personal page with his works, projects, demos, talks and articles.');
                data.pageTitle = 'felipenmoura:page:home';
                data.fullURL = DOMAIN;
                data.pageType = "home";
                fs.writeFileSync(idxFile, nunEnv.render('_templates/index.html', data), 'utf8');
                copyIndexTo("home", data);

                data.pageTitle = 'felipenmoura:page:about';
                data.socialDesc = 'Know more about Felipe, his past, experiences and find his personal contacts and social connections.';
                data.fullURL = DOMAIN + 'about/';
                data.pageType = "about";
                data.ogImage = DOMAIN + 'resources/og/fb-about.jpg';
                copyIndexTo("about", data);

                data.pageTitle = 'felipenmoura:page:sobre';
                data.socialDesc = 'Saiba mais sobre Felipe, seu passado, experiências e encontre seus contatos pessoais e sociais.';
                copyIndexTo("sobre", data);

                data.pageTitle = 'felipenmoura:page:utils';
                data.socialDesc = 'Useful tools, talk materials, demos and lab experiments, videos and photos and articles from Felipe';
                data.fullURL = DOMAIN + 'utils/';
                data.pageType = "utils";
                data.ogImage = DOMAIN + 'resources/og/fb-utils.jpg';
                copyIndexTo("utils", data);

                data.socialDesc = 'Ferramentas úteis, materiais de palestras, demos e experimentos, videos, fotos e artigos de Felipe';
                copyIndexTo("uteis", data);

                data.pageTitle = 'felipenmoura:page:talks';
                data.socialDesc = "Check out some of Felipe's talks material, slides, links and videos.";
                data.fullURL = DOMAIN + 'utils/talks/';
                data.pageType = "utils";
                data.pageTypeDetail = "talks";
                data.ogImage = DOMAIN + 'resources/og/fb-utils-talks.jpg';
                copyIndexTo("utils/talks", data);

                data.pageTitle = 'felipenmoura:page:palestras/';
                data.socialDesc = "Tenha acesso ao material das palestras de Felipe, slides, links e videos.";
                copyIndexTo("uteis/palestras", data);

                data.pageTitle = 'felipenmoura:page:videos';
                data.socialDesc = "Watch some of Felipe's videos about technology, experiments, interviews, etc.";
                data.fullURL = DOMAIN + 'utils/videos/';
                data.ogImage = DOMAIN + 'resources/og/fb-utils-videos.jpg';
                data.pageType = "utils";
                data.pageTypeDetail = "videos";
                copyIndexTo("utils/videos", data);

                data.pageTitle = 'felipenmoura:page:labs';
                data.socialDesc = "Felipe's experimental lab, with demos, tests, examples and tools.";
                data.fullURL = DOMAIN + 'utils/labs/';
                data.ogImage = DOMAIN + 'resources/og/fb-utils-labs.jpg';
                data.pageType = "utils";
                data.pageTypeDetail = "labs";
                copyIndexTo("utils/labs", data);

                data.pageTitle = 'felipenmoura:page:photos';
                data.socialDesc = "Some of the prefered photos of Felipe";
                data.fullURL = DOMAIN + 'utils/photos/';
                data.ogImage = DOMAIN + 'resources/og/fb-utils-photos.jpg';
                data.pageType = "utils";
                data.pageTypeDetail = "photos";
                copyIndexTo("utils/photos", data);

                data.socialDesc = "Algumas das fotos preferidas de Felipe";
                copyIndexTo("utils/fotos", data);

                if(data.currentArticleMetaData.headerImg){
                    data.ogImage = DOMAIN + data.currentArticleMetaData.headerImg.replace(/^\//, '');
                }else{
                    data.ogImage = DOMAIN + DEFAULT_ART_IMG;
                }

                data.socialDesc = addslashes(data.currentArticleMetaData.resume || DEFAULT_ART_DESC);

                data.pageType = "articles";
                data.pageTypeDetail = data.currentArticleMetaData.name;
                data.pageTitle = 'felipenmoura:page:articles | ' + stripTags(data.currentArticleMetaData.title);
                data.fullURL = DOMAIN + 'articles/';
                copyIndexTo("articles", data);

                data.pageTitle = 'felipenmoura:page:artigos | ' + stripTags(data.currentArticleMetaData.title);
                //data.socialDesc = "Artigos escritos por Felipe, falando sobre desenvolvimento web, tecnologia, anúncios importantes, algumas notícias e eventualmente, pensamentos.";
                copyIndexTo("artigos", data);

                var dt = (new Date()).toISOString().split('T')[0],
                    renderedRSS = nunEnv.render('_templates/rss.html', {
                    updateDate: (new Date()).toString(),
                    list: list
                });
                fs.writeFileSync('./feed.xml', renderedRSS, 'utf-8');

                list.forEach(function(cur, idx){
                    cur.oCreationDate = dt;
                    list[idx] = cur;
                });

                var renderedSiteMap = nunEnv.render('_templates/sitemap.html', {
                        updateDate: dt,
                        list: list,
                        pages: [
                            { name: '', lastModified: dt },
                            { name: 'home/', lastModified: dt },
                            { name: 'about/', lastModified: dt },
                            { name: 'utils/', lastModified: dt },
                            { name: 'utils/videos/', lastModified: dt },
                            { name: 'utils/photos/', lastModified: dt },
                            { name: 'utils/talks/', lastModified: dt },
                            { name: 'utils/labs/', lastModified: dt },
                            { name: 'articles/', lastModified: dt }
                        ]
                    });
                fs.writeFileSync('./sitemap.xml', renderedSiteMap, 'utf-8');

                done();
            });
        }

        //console.log(videosList);

        if(!videosList){
            var http = require('http');
            var cachePath = 'src/resources/yt-feed-cache.json';
            var req = http.request(options, function(res) {
                var buffer= "";
                res.setEncoding('utf8');
                videosList = "";
                res.on('data', function (data) {
                    buffer+= data;
                });
                res.on('end', function () {
                    try{
                        videosList = buffer.replace(/^\/\/.*|^foo\(|\);$/gm, '');

                        videosList = JSON.parse(videosList);

                        data.videosList = videosList.feed.entry;

                        if(data.videosList && data.videosList.length){
                            data.videosList = data.videosList.map( function(val) {
                                val['media$group']
                                   ['media$description']
                                   ['$t'] = applyURL(val['media$group']['media$description']['$t']);
                                return val;
                            });
                        }

                        fs.writeFileSync(cachePath, JSON.stringify(data.videosList), 'utf-8');
                        render();
                    }catch(e){
                        treatVideoErrors(e);
                    }
                });
            });
            req.on('error', function(e) {
                treatVideoErrors(e);
            });
            req.end();

            function treatVideoErrors (e) {
                console.log('problem with request: ' + e.message);
                if(fs.existsSync(cachePath)){
                    console.log('using youtube feed from cache');
                    try{
                        data.videosList = JSON.parse(fs.readFileSync(cachePath, 'utf-8'));
                    }catch(e){
                        e.message = "Failed parsing JSON from cache file\n" + e.message;
                        console.error(e);
                    }
                }else{
                    console.warn('no cache found for youtube feed.\nThere will be no video rendered from the feed!');
                    data.videosList = {};
                }
                render();
            }
        }else{
            render();
        }
    });

    grunt.registerTask('build', ['sass', 'compileArticles', 'compileTemplates', 'uglify', 'cssmin']);

    grunt.registerTask('default', ['build']);

};

