(function() {
    tinymce.create('tinymce.plugins.kandyLiveChat', {
        init : function(ed, url) {
            ed.addButton('kandyLiveChat', {
                title : 'Kandy Live Chat',
                image : url+'/img/livechat.png',
                onclick : function() {
                    //var posts = prompt("Number of posts", "1");
                    //var text = prompt("List Heading", "This is the heading text");
                    ed.execCommand('mceInsertContent', false, '[kandyLiveChat class="myChatStyle" id ="my-chat"]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Kandy Live Chat",
                author : 'Kodeplus Dev',
                authorurl : 'http://kodeplus.net/',
                infourl : 'http://kodeplus.net/',
                version : "1.4"
            };
        }
    });
    tinymce.PluginManager.add('kandyLiveChat', tinymce.plugins.kandyLiveChat);
})();