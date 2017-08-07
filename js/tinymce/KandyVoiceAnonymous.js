(function() {
    tinymce.create('tinymce.plugins.kandyVoiceAnonymous', {
        init : function(ed, url) {
            ed.addButton('kandyVoiceAnonymous', {
                title : 'Kandy Anonymous Voice Call',
                image : url+'/img/kandyVoiceAnonymous.png',
                onclick : function() {
                    //var posts = prompt("Number of posts", "1");
                    //var text = prompt("List Heading", "This is the heading text");
                    ed.execCommand('mceInsertContent', false, '[kandyVoiceButton class= "myButtonStyle" id ="my-voice-button" callOutButtonText="Call Us" type="VoiceIP" callto="kandy_username@domain.com" anonymous="true"]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Kandy Anonymous Voice",
                author : 'Kodeplus Dev',
                authorurl : 'http://kodeplus.net/',
                infourl : 'http://kodeplus.net/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('kandyVoiceAnonymous', tinymce.plugins.kandyVoiceAnonymous);
})();