/**
 * Created by Khanh on 28/5/2015.
 */
var message;
var LiveChatUI = {};
var checkAvailable;
LiveChatUI.changeState = function(state){
    switch (state){
        case 'WAITING':
            jQuery('.liveChat #waiting').show();
            jQuery(".liveChat #registerForm").hide();
            jQuery(".liveChat .customerService ,.liveChat #messageBox, .liveChat .formChat").hide();
            jQuery("div.send-file span.icon-file").css("display", "none");
            break;
        case 'READY':
            jQuery(".liveChat #registerForm").hide();
            jQuery('.liveChat #waiting').hide();
            jQuery(".liveChat .customerService, .liveChat #messageBox, .liveChat .formChat").show();
            jQuery('.liveChat .agentName').html(agent.username);
            jQuery('.liveChat .agentName').attr("data-full_user_id", agent.full_user_id);
            if (!agent.full_user_id) {
                jQuery(".liveChat .icon-file").hide();
            } else {
                jQuery("div.send-file span.icon-file").css("display", "block");
            }
            jQuery(".liveChat ul > li.their-message:first-child span.username").html(agent.username);
            jQuery(".liveChat .handle.closeChat").show();
            jQuery("#messageToSend").focus();
            break;
        case "UNAVAILABLE":
            jQuery(".liveChat #waiting p").html('There is something wrong, please try again later.');
            jQuery(".liveChat #loading").hide();
            break;
        case "RECONNECTING":
            if (message != null) {
                jQuery(".liveChat #waiting p").html(message);
            } else {
                jQuery(".liveChat #waiting p").html('Chat agents not available, please wait...');
            }
            jQuery(".liveChat #loading").show();
            break;
        case "RATING":
            jQuery(".liveChat #ratingForm").show();
            jQuery(".liveChat .customerService, .liveChat #messageBox, .liveChat .formChat").hide();
            jQuery("div.send-file span.icon-file").css("display", "none");
            break;
        case "ENDING_CHAT":
            jQuery(".liveChat #ratingForm form").hide();
            jQuery(".liveChat #ratingForm .formTitle").hide();
            jQuery(".liveChat #ratingForm .message").show();
            break;
        default :
            jQuery('.liveChat #registerForm').show();
            jQuery(".liveChat .customerService, .liveChat #messageBox, .liveChat .formChat").hide();
            jQuery("div.send-file span.icon-file").css("display", "none");
            break;
    }
};

var login = function(domainApiKey, userName, password, success_callback) {
    kandy.login(domainApiKey, userName, password, success_callback);
};

var loginSSO = function(userAccessToken, success_callback, failure, password) {
    console.log('login SSO ...');
    kandy.loginSSO(userAccessToken, success_callback, failure, password);
};

var logout = function(){
    kandy.logout();
};
var login_success_callback = function (){
    console.log('login successful');
    LiveChatUI.changeState("READY");
};
var login_fail_callback = function (){
    console.log('login failed');
    LiveChatUI.changeState("UNAVAILABLE");
};

var heartBeat = function(interval){
    return setInterval(function(){
        jQuery.get(ajax_object.ajax_url + '?action=kandy_still_alive');
    },parseInt(interval));
};
var setup = function(){
    kandy.setup({
        listeners: {
            message: onMessage
        }
    })
};

var getKandyUsers = function(){
    LiveChatUI.changeState('WAITING');
    jQuery.ajax({
        url: ajax_object.ajax_url + '?action=kandy_get_free_user',
        type: 'GET',
        dataType: 'json',
        success: function(res){
            if(!checkAvailable){
                LiveChatUI.changeState('WAITING');
            } else {
                LiveChatUI.changeState('RECONNECTING');
            }
            if(res.status == 'success'){
                message = null;
                if(checkAvailable){
                    clearInterval(checkAvailable);
                }
                var username = res.user.full_user_id.split('@')[0];
                if(username.indexOf("anonymous") >= 0) {
                    var user_access_token = res.user.user_access_token;
                    loginSSO(user_access_token, login_success_callback, login_fail_callback, res.user.password);
                } else {
                    login(res.apiKey, username, res.user.password, login_success_callback, login_fail_callback);
                }
                setup();
                agent = res.agent;
                if (typeof agent.main_user_id == "undefined") {
                    getKandyUsers();
                }
                rateData.agent_id = agent.main_user_id;
                heartBeat(60000);
            }else{
                if (res.message) {
                    console.log('Error! ' + res.message);
                    message = res.message;
                }
                if(!checkAvailable){
                    checkAvailable = setInterval(getKandyUsers, 5000);
                } else {
                    LiveChatUI.changeState('RECONNECTING');
                }
            }
        },
        error: function(){
            LiveChatUI.changeState("UNAVAILABLE");
        }
    })
};

var endChatSession = function(){
    logout();
    jQuery.ajax({
        url: ajax_object.ajax_url + '?action=kandy_end_chat_session',
        type: 'GET',
        async: false,
        success: function(){
            window.onbeforeunload = null;
        }
    });
};

var sendIM = function(username, message){
    if (message != '') {
        kandy.messaging.sendIm(username, message, function () {
                var messageBox = jQuery("#messageBox");
                messageBox.find("ul").append("<li class='my-message'><span class='username'>You:</span><span class='imMessage'>"+jQuery("#messageToSend").val()+"</span></li>");
                jQuery("#formChat")[0].reset();
                messageBox.scrollTop(messageBox[0].scrollHeight);
            },
            function () {
                alert("IM send failed");
            }
        );
    }
};

var onMessage = function(msg){
    if(msg){
        if(msg.messageType == 'chat') {
            var sender = agent.username;
            var message = msg.message.text;
            var messageBox = jQuery("#messageBox");
            var newMessage = "<li class='their-message'><span class='username'>" + sender + ": </span>";

            if (msg.contentType === 'text' && msg.message.mimeType == 'text/plain') {
                newMessage += '<span class="imMessage">' + message + '</span>';
            } else {
                var fileUrl = kandy.messaging.buildFileUrl(msg.message.content_uuid);
                var html = '';
                if (msg.contentType == 'image') {
                    html = '<div class="wrapper-img"><img src="' + fileUrl + '"></div>';
                }
                html += '<a class="icon-download" href="' + fileUrl + '" target="_blank">' + msg.message.content_name + '</a>';
                newMessage += '<span class="imMessage">' + html + '</span>';
            }

            newMessage += '</li>';

            messageBox.find("ul").append(newMessage);
            messageBox.scrollTop(messageBox[0].scrollHeight);
        }
    }

};

// Gather the user input then send the image.
send_file = function () {
    // Gather user input.
    var recipient = jQuery('.liveChat .agentName').data("full_user_id");
    var file = jQuery("#send-file")[0].files[0];

    if (file.type.indexOf('image') >=0) {
        kandy.messaging.sendImWithImage(recipient, file, onFileSendSuccess, onFileSendFailure);
    } else if (file.type.indexOf('audio') >=0) {
        kandy.messaging.sendImWithAudio(recipient, file, onFileSendSuccess, onFileSendFailure);
    } else if (file.type.indexOf('video') >=0) {
        kandy.messaging.sendImWithVideo(recipient, file, onFileSendSuccess, onFileSendFailure);
    } else if (file.type.indexOf('vcard') >=0) {
        kandy.messaging.sendImWithContact(recipient, file, onFileSendSuccess, onFileSendFailure);
    } else {
        kandy.messaging.sendImWithFile(recipient, file, onFileSendSuccess, onFileSendFailure);
    }
};

// What to do on a file send success.
function onFileSendSuccess(message) {
    console.log(message.message.content_name + " sent successfully.");
    var messageBox = jQuery("#messageBox");
    var newMessage = "<li class='my-message'><span class='username'>You: </span>";
    var fileUrl = kandy.messaging.buildFileUrl(message.message.content_uuid);
    var html = '';
    if (message.contentType == 'image') {
        html = '<div class="wrapper-img"><img src="' + fileUrl + '"></div>';
    }
    html += '<a class="icon-download" href="' + fileUrl + '" target="_blank">' + message.message.content_name + '</a>';
    newMessage += '<span class="imMessage">' + html + '</span>';
    newMessage += '</li>';

    messageBox.find("ul").append(newMessage);
    messageBox.scrollTop(messageBox[0].scrollHeight);
}

// What to do on a file send failure.
function onFileSendFailure() {
    console.log("File send failure.");
}

jQuery(function(){
    if (jQuery(".liveChat").length) {
        jQuery(document).on('change', "input[type=file]", function (e){
            var fileName = jQuery(this).val();
            if (fileName != '') {
                send_file();
            }
        });
    }

    //hide vs restore box chat
    jQuery(".handle.minimize, #restoreBtn").click(function(){
        jQuery(".liveChat").toggleClass('kandy_hidden');
        if (!jQuery(".liveChat").hasClass('kandy_hidden')) {
            jQuery("#customerName").focus();
        }
    });

    jQuery(".handle.closeChat").click(function(){
        LiveChatUI.changeState('RATING');
    });

    jQuery("#customerInfo").on('submit', function(e){
        var form = jQuery(this);
        e.preventDefault();
        jQuery.ajax({
            url: ajax_object.ajax_url + '?action=kandy_register_guest',
            data: form.serialize(),
            type: 'POST',
            beforeSend: function (xhr) {
                LiveChatUI.changeState('WAITING');
            },
            success: function(res){
                res = jQuery.parseJSON(res);
                if(res.hasOwnProperty('errors')){
                    form.find("span.error").empty().hide();
                    for(var e in res.errors){
                        form.find('span[data-input="'+e+'"]').html(res.errors[e]).show();
                    }
                }else{
                    getKandyUsers();
                }
            }
        })
    });

    //form chat submit handle
    jQuery("#formChat").on('submit', function(e){
        e.preventDefault();
        var message = jQuery("#messageToSend").val().trim();
        if (message != '') {
            sendIM(agent.full_user_id, message);
        }
    });
    //end chat session if user close browser or tab
    window.onbeforeunload = function() {
        endChatSession();
    };
    /** Rating for agents JS code **/
    jQuery(".liveChat #ratingForm #btnEndSession").click(function(e){
        e.preventDefault();
        LiveChatUI.changeState('ENDING_CHAT');
        setTimeout(endChatSession, 3000);
        window.location.reload();
    });
    jQuery('.liveChat #ratingForm #btnSendRate').click(function(e){
        e.preventDefault();
        rateData = rateData || {};
        var rateComment = jQuery(".liveChat #rateComment").val();
        if(rateComment){
            rateData.comment = rateComment
        }
        jQuery.ajax({
            url: ajax_object.ajax_url + "?action=kandy_rate_agent",
            data: rateData,
            type: 'POST',
            dataType: 'json',
            success: function (res){
                if(res.success){
                    LiveChatUI.changeState("ENDING_CHAT");
                    setTimeout(endChatSession, 3000);
                    window.location.reload();
                }
            }
        })
    })
});
