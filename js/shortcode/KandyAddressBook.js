/**
 * you login successfully
 */
window.login_success_callback = function () {
    //do something here
};

/**
 * You login fail
 */
window.login_failed_callback = function () {
    //do something here
};

/**
 * Status Notification Callback
 * @param userId
 * @param state
 * @param description
 * @param activity
 */
window.presence_notification_callback = function(userId, state, description, activity){
    //do something
};
