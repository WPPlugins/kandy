(function() {
    tinymce.create('tinymce.plugins.kandyVideo', {
        init : function(ed, url) {
            ed.addButton('kandyVideo', {
                title : 'Kandy Video Call',
                image : url+'/img/kandyVideo.png',
                onclick : function() {
                    //var posts = prompt("Number of posts", "1");
                    //var text = prompt("List Heading", "This is the heading text");
                    ed.execCommand('mceInsertContent', false, '[kandyVideoButton class="myButtonStyle"]\n[kandyVideo title="You" id="myVideo" style = "width: 300px;height: 225px;"][kandyVideo title="Them" id="theirVideo" style = "width:300px;height: 225px;"]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Kandy Chat",
                author : 'Kodeplus Dev',
                authorurl : 'http://kodeplus.net/',
                infourl : 'http://kodeplus.net/',
                version : "1.4"
            };
        }
    });
    tinymce.PluginManager.add('kandyVideo', tinymce.plugins.kandyVideo);
})();