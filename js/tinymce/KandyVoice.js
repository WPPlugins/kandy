(function() {
    tinymce.create('tinymce.plugins.kandyVoice', {
        init : function(ed, url) {
            ed.addButton('kandyVoice', {
                title : 'Kandy Voice Call',
                image : url+'/img/kandyVoice.png',
                onclick : function() {
                    //var posts = prompt("Number of posts", "1");
                    //var text = prompt("List Heading", "This is the heading text");
                    ed.execCommand('mceInsertContent', false, '[kandyVoiceButton class= "myButtonStyle" id ="my-voice-button"]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "kandy Voice",
                author : 'Kodeplus Dev',
                authorurl : 'http://kodeplus.net/',
                infourl : 'http://kodeplus.net/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('kandyVoice', tinymce.plugins.kandyVoice);
})();