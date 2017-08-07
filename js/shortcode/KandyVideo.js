/**
 * You login success
 */
window.login_success_callback = function () {
    //do something here
};

/**
 * you login fail
 */
window.login_failed_callback = function () {
//do something here
};

/**
 * Someone are calling you
 * @param call
 * @param isAnonymous
 */
window.call_incoming_callback = function (call, isAnonymous) {
    //do something here
};

/**
 * You are on call
 * @param call
 */
window.on_call_callback = function (call) {
    //do something here
};

/**
 * Some one answer your call
 * @param call
 * @param isAnonymous
 */
window.call_answered_callback = function (call, isAnonymous) {
    //do something here
};

/**
 * end call callback
 */
window.call_ended_callback = function () {
    //do something here
};

/**
 * Callback when click AnswerVideo Button
 * @param stage
 */
window.answer_video_call_callback = function (stage) {
    //do something here
};

/**
 * Callback when click AnswerVideo Button
 * @param stage
 */
window.answer_voice_call_callback = function (stage) {
    //do something here
};

/**
 * Callback when click Call Button
 * @param stage
 */
window.make_call_callback = function (stage) {
    //do something here
};

/**
 * Callback when click End call Button
 * @param stage
 */
window.end_call_callback = function (stage) {
    //do something here
};

/**
 * remote video callback
 * @param videoTag
 */
window.remote_video_initialized_callback = function(videoTag){
    //do something here
};

/**
 * Your local video callback
 * @param videoTag
 */
window.local_video_initialized_callback = function(videoTag){
    //do something here
};

jQuery("span.video").each(function (index, value) {
    jQuery(this).on("DOMSubtreeModified", appendFullScreen);
});

function appendFullScreen(event) {
    if (jQuery(event.target).find('video').length > 0 && jQuery(event.target).find('.icon-full-screen').length == 0) {
        jQuery(event.target).off( "DOMSubtreeModified" );
        jQuery(event.target).append('<span class="icon-full-screen"></span>');
        jQuery(event.target).on( "DOMSubtreeModified", appendFullScreen );
    }
}

jQuery(document).on('click', "span.icon-full-screen", function (e) {
    launchIntoFullscreen(jQuery(this).prev('video')[0]);
});

// Find the right method, call on correct element
function launchIntoFullscreen(element) {
    if(element.requestFullscreen) {
        element.requestFullscreen();
    } else if(element.mozRequestFullScreen) {
        element.mozRequestFullScreen();
    } else if(element.webkitRequestFullscreen) {
        element.webkitRequestFullscreen();
    } else if(element.msRequestFullscreen) {
        element.msRequestFullscreen();
    }
}