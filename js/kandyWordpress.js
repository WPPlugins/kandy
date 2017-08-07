/**
 * @file
 * KANDY SETUP AND LISTENER CALLBACK.
 */


var activeContainerId;
var sessionNames = {};
// Create audio objects to play incoming calls and outgoing calls sound
var $audioRingIn = jQuery('<audio>', { loop: 'loop', id: 'ring-in' });
var $audioRingOut = jQuery('<audio>', { loop: 'loop', id: 'ring-out' });
var kandyPresence = {};
var last_seen_interval;
// Keep track of the callId.
var callId;
// Keep track of screen sharing status.
var isSharing = false;

// Load audio source to DOM to indicate call events
var audioSource = {
    ringIn: [
        { src: 'https://kandy-portal.s3.amazonaws.com/public/sounds/ringin.mp3', type: 'audio/mp3' },
        { src: 'https://kandy-portal.s3.amazonaws.com/public/sounds/ringin.ogg', type: 'audio/ogg' }
    ],
    ringOut: [
        { src: 'https://kandy-portal.s3.amazonaws.com/public/sounds/ringout.mp3', type: 'audio/mp3' },
        { src: 'https://kandy-portal.s3.amazonaws.com/public/sounds/ringout.ogg', type: 'audio/ogg' }
    ]
};

audioSource.ringIn.forEach(function (entry) {
    var $source = jQuery('<source>').attr('src', entry.src);
    $audioRingIn.append($source);
});

audioSource.ringOut.forEach(function (entry) {
    var $source = jQuery('<source>').attr('src', entry.src);
    $audioRingOut.append($source);
});

setup = function () {
    // Initialize KandyAPI.Phone, passing a config JSON object that contains listeners (event callbacks).
    kandy.setup({
        kandyApiUrl: 'https://api.kandy.io/v1.2',
        remoteVideoContainer: jQuery('#theirVideo')[0],
        localVideoContainer: jQuery('#myVideo')[0],

        // Respond to Kandy events.
        listeners: {
            callincoming: kandyIncomingCallCallback,
            oncall: kandyOnCallCallback,
            callanswered: kandyCallAnsweredCallback,
            callended: kandyCallEndedCallback,
            callendedfailed: kandyOnCallEndedFailed,
            callinitiated: kandyOnCallInitiate,
            callinitiatefailed: kandyOnCallInitiateFail,
            callrejected: kandyOnCallRejected,

            // Media Event
            media: onMediaError,
            // Screensharing Event
            callscreenstopped: onStopSuccess
        },
        // Reference the default Chrome extension.
        chromeExtensionId: {
            chromeExtensionId: 'daohbhpgnnlgkipndobecbmahalalhcp'
        }
    });

    if(jQuery(".kandyChat").length){
        kandy.setup({
            listeners: {
                message: kandy_onMessage,
                chatGroupMessage: kandy_onGroupMessage,
                chatGroupInvite: kandy_onGroupInvite,
                chatGroupBoot: kandy_onRemovedFromGroup,
                chatGroupLeave: kandy_onLeaveGroup,
                chatGroupUpdate: '',
                chatGroupDelete: kandy_onTerminateGroup
            }
        })
    }

};

/**
 * Login Success Callback.
 */
kandyLoginSuccessCallback = function () {
    console.log('login success');
    jQuery('#callBtn').removeAttr('disabled');
    // Have kandy Address Book widget.
    if (jQuery(".kandyAddressBook").length) {
        kandyLoadContactsAddressBook();
    }
    // Have kandy Chat widget.
    if (jQuery(".kandyChat").length) {
        kandy_load_contacts_chat();
        kandy_loadGroups();
        setTimeout(updateUserGroupStatus,3000);
    }
    if(jQuery("#coBrowsing").length){
        kandy_getOpenSessionsByType("cobrowsing",loadSessionList);
    }
    // Call user callback.
    if (typeof login_success_callback == 'function') {
        login_success_callback();
    }

    // Call user logout if exists.
    if (typeof kandy_logout == 'function') {
        kandy_logout();
    }
};

/**
 * Login Fail Callback.
 */
kandyLoginFailedCallback = function () {
    if (typeof login_failed_callback == 'function') {
        login_failed_callback();
    }
};

/**
 * Status Notification Callback.
 *
 * @param userId
 * @param state
 * @param description
 * @param activity
 */
kandyPresenceNotificationCallback = function (userId, state, description, activity) {
    // HTML id can't contain @ and jquery doesn't like periods (in id).
    var id_attrib = '.kandyAddressBook .kandyAddressContactList #presence_' + userId.replace(/[.@]/g, '_');
    jQuery(id_attrib).text(description);
    if (typeof presence_notification_callback == 'function') {
        presence_notification_callback(userId, state, description, activity);
    }

    // Update chat status.
    if (jQuery('.kandyChat').length > 0) {
        var liUser = jQuery('.kandyChat .cd-tabs-navigation li#' + userId.replace(/[.@]/g, '_'));
        var statusItem = liUser.find('i.status');
        statusItem.text(description);

        liUser.removeClass().addClass('kandy-chat-status-' + description.replace(/ /g, '-').toLowerCase());
        liUser.attr('title', description);
    }
    usersStatus[userId] = description;
    updateUserGroupStatus();
};

/**
 * Event handler for callinitiate
 * @param call
 */
function kandyOnCallInitiate(call, calleeName) {
    console.log('Making call to ' + calleeName);
    // Store the callId.
    callId = call.getId();
    jQuery("#" + activeContainerId).attr("data-call-id", callId);
    $audioRingIn[0].pause();
    $audioRingOut[0].play();
}

/**
 * Event handler for callinitiatefail event.
 */
function kandyOnCallInitiateFail() {
    callId = null;
    $audioRingOut[0].pause();

}

/**
 * Event handler for callrejected event
 */
function kandyOnCallRejected() {
    callId = null;
    $audioRingIn[0].pause();
    UIState.callrejected();
}

/*-------------Screen Sharing--------------*/

// Called when the media event is triggered.
function onMediaError(error) {
    switch(error.type)
    {
        case kandy.call.MediaErrors.NOT_FOUND:
            console.log("No WebRTC support was found.");
            break;
        case kandy.call.MediaErrors.NO_SCREENSHARING_WARNING:
            console.log("WebRTC supported, but no screensharing support was found.");
            break;
        default:
            console.log('Other error or warning encountered.');
            break;
    }
}

// Executed when the user clicks on the 'Toggle Screensharing' button.
toggle_screen_sharing = function () {
    // Check if we should start or stop sharing.
    if(callId && isSharing) {
        // Stop screensharing.
        kandy.call.stopScreenSharing(callId, onStopSuccess, onStopFailure);
    } else {
        // Start screensharing.
        kandy.call.startScreenSharing(callId, onStartSuccess, onStartFailure);
    }
};

// What to do on a successful screenshare start.
function onStartSuccess() {
    console.log('Screensharing started.');
    jQuery('.btnScreenSharing').val('Stop Screen Sharing');
    isSharing = true;
}

// What to do on a failed screenshare start.
function onStartFailure() {
    console.log('Failed to start screensharing.');
}

// What to do on a successful screenshare stop.
function onStopSuccess() {
    console.log('Screensharing stopped.');
    jQuery('.btnScreenSharing').val('Screen Sharing');
    isSharing = false;
}

// What to do on a failed screenshare stop.
function onStopFailure() {
    console.log('Failed to stop screensharing.');
}
/*------------------End screen sharing------------------*/
/**
 * OnCall Callback.
 *
 * @param call
 */
kandyOnCallCallback = function (call) {
    if (typeof on_call_callback == 'function') {
        on_call_callback(call);
    }
    $audioRingOut[0].pause();

    var target = jQuery('.kandyVideoButtonCalling:visible').get(0).closest('.kandyButton');
    changeAnswerButtonState("ON_CALL", target);
};

/**
 * Incoming Callback.
 *
 * @param call
 * @param isAnonymous
 */
kandyIncomingCallCallback = function (call, isAnonymous) {
    if (typeof call_incoming_callback == 'function') {
        call_incoming_callback(call, isAnonymous);
    }

    $audioRingIn[0].play();

    var target = jQuery('.kandyVideoButtonCallOut:visible').get(0).closest('.kandyButton');
    // Store the callId.
    callId = call.getId();
    jQuery(target).attr("data-call-id", callId);
    changeAnswerButtonState('BEING_CALLED',target);
};

/**
 * Kandy call answered callback.
 *
 * @param call
 * @param isAnonymous
 */
kandyCallAnsweredCallback = function (call, isAnonymous) {
    if (typeof call_answered_callback == 'function') {
        call_answered_callback(call, isAnonymous);
    }

    $audioRingOut[0].pause();
    $audioRingIn[0].pause();

    var target = jQuery('.kandyVideoButtonSomeonesCalling:visible').get(0).closest('.kandyButton');
    changeAnswerButtonState("ON_CALL", target);
};

/**
 * Kandy call ended callback.
 */
kandyCallEndedCallback = function (call) {

    $audioRingOut[0].play();
    $audioRingIn[0].pause();

    if (typeof call_ended_callback == 'function') {
        call_ended_callback();
    }

    var target = jQuery('.kandyButton[data-call-id="'+ call.getId() +'"]');
    changeAnswerButtonState("READY_FOR_CALLING", target);

    // Update screensharing status.
    isSharing = false;
};

/**
 * Event handler for callendedfailed event
 */
function kandyOnCallEndedFailed() {

}

/**
 * Change AnswerButtonState with KandyButton Widget.
 * @param target
 * @param state
 */
changeAnswerButtonState = function (state, target) {
    var kandyButton = (typeof target !== 'undefined')?jQuery(target):jQuery('.kandyButton');
    switch (state) {
        case 'READY_FOR_CALLING':
            if (jQuery('#labelConnecting').length > 0) {
                jQuery('#labelConnecting').text('');
            }
            $audioRingIn[0].pause();
            $audioRingOut[0].pause();
            kandyButton.find('.kandyVideoButtonSomeonesCalling').hide();
            kandyButton.find('.kandyVideoButtonCallOut').show();
            kandyButton.find('.kandyVideoButtonCalling').hide();
            kandyButton.find('.kandyVideoButtonOnCall').hide();
            break;

        case 'BEING_CALLED':
            if (jQuery('#labelConnecting').length > 0) {
                jQuery('#labelConnecting').text('');
            }
            kandyButton.find('.kandyVideoButtonSomeonesCalling').show();
            kandyButton.find('.kandyVideoButtonCallOut').hide();
            kandyButton.find('.kandyVideoButtonCalling').hide();
            kandyButton.find('.kandyVideoButtonOnCall').hide();
            break;

        case 'CALLING':
            if (jQuery('#labelConnecting').length > 0) {
                jQuery('#labelConnecting').text('');
            }
            kandyButton.find('.kandyVideoButtonSomeonesCalling').hide();
            kandyButton.find('.kandyVideoButtonCallOut').hide();
            kandyButton.find('.kandyVideoButtonCalling').show();
            kandyButton.find('.kandyVideoButtonOnCall').hide();
            break;
        case 'HOLD_CALL':

            kandyButton.find('.kandyVideoButtonOnCall .btnHoldCall').hide();
            kandyButton.find('.kandyVideoButtonOnCall .btnResumeCall').show();
            break;

        case 'RESUME_CALL':

            kandyButton.find('.kandyVideoButtonOnCall .btnResumeCall').hide();
            kandyButton.find('.kandyVideoButtonOnCall .btnHoldCall').show();
            break;

        case 'ON_CALL':
            if (jQuery('#labelConnecting').length > 0) {
                jQuery('#labelConnecting').text('');
            }
            kandyButton.find('.kandyVideoButtonSomeonesCalling').hide();
            kandyButton.find('.kandyVideoButtonCallOut').hide();
            kandyButton.find('.kandyVideoButtonCalling').hide();
            kandyButton.find('.kandyVideoButtonOnCall').show();
            kandyButton.find('.kandyVideoButtonOnCall .btnResumeCall').hide();
            break;
    }
};

/**
 * Event when answer a call.
 *
 * @param target
 */
kandy_answer_video_call = function (target) {
    var kandyButtonId = jQuery(target).data('container');
    var currentCallId = jQuery("div#" + kandyButtonId).attr("data-call-id");
    callId = currentCallId;

    activeContainerId = kandyButtonId;
    kandy.call.answerCall(currentCallId, true);
    changeAnswerButtonState("ANSWERING_CALL", '#'+kandyButtonId);
    if (typeof answer_video_call_callback == 'function') {
        answer_video_call_callback("ANSWERING_CALL");
    }
}

/**
 * Event when answer a call.
 *
 * @param target
 */
kandy_reject_video_call = function (target) {

    var kandyButtonId = jQuery(target).data('container');
    var currentCallId = jQuery("div#" + kandyButtonId).attr("data-call-id");
    callId = currentCallId;
    kandy.call.rejectCall(currentCallId);

    target = jQuery(target).closest('.kandyButton');
    changeAnswerButtonState("READY_FOR_CALLING", target);
    if (typeof reject_video_call_callback == 'function') {
        reject_video_call_callback("READY_FOR_CALLING");
    }
};

/**
 * Event when click call button PSTN.
 *
 * @param target
 */
kandy_make_pstn_call = function (target) {

    var kandyButtonId = jQuery(target).data('container');
    activeContainerId = kandyButtonId;
    var number = jQuery('#'+kandyButtonId+ ' .kandyVideoButtonCallOut #'+kandyButtonId+'-callOutUserId').val();
    var userName = jQuery('#'+kandyButtonId+ ' .kandyVideoButtonCallOut #'+kandyButtonId+'-callOutUserId').val()

    kandy.call.makePSTNCall(number, userName);

    target = jQuery(target).closest('.kandyButton');
    changeAnswerButtonState("CALLING", target);
};

/**
 * Event when click call button.
 *
 * @param target
 */
kandy_make_video_call = function (target) {

    if (callId) {
        // Tell Kandy to end the call.
        kandy.call.endCall(callId);
        callId = null;
    } else {
        var kandyButtonId = jQuery(target).data('container');
        activeContainerId = kandyButtonId;
        var userName = jQuery('#'+kandyButtonId+ ' .kandyVideoButtonCallOut #'+kandyButtonId+'-callOutUserId').val();

        kandy.call.makeCall(userName, true);
        changeAnswerButtonState("CALLING", '#'+kandyButtonId);
    }
};

/**
 * Event when click call button for anonymous user.
 *
 * @param target
 */
kandy_make_video_call_sso = function (target) {
    jQuery('#labelConnecting').text('Connecting...');
    var kandyButtonId = jQuery(target).data('container');
    activeContainerId = kandyButtonId;
    var userName = jQuery('#'+kandyButtonId+ ' .kandyVideoButtonCallOut #'+kandyButtonId+'-callOutUserId').val();

    kandy.call.makeCall(userName, true);
    changeAnswerButtonState("CALLING", '#'+kandyButtonId);
};

/**
 * Event when answer a voice call.
 *
 * @param target
 */
kandy_answerVoiceCall = function (target) {

    var kandyButtonId = jQuery(target).data('container');
    var currentCallId = jQuery("div#" + kandyButtonId).attr("data-call-id");
    activeContainerId = kandyButtonId;
    kandy.call.answerCall(currentCallId, false);
    changeAnswerButtonState("ANSWERING_CALL", '#'+kandyButtonId);

    if (typeof answer_voice_call_callback == 'function') {
        answer_voice_call_callback("ANSWERING_CALL");
    }

};

/**
 * Event when click call button.
 *
 * @param target
 */
kandy_makeVoiceCall = function (target) {
    var kandyButtonId = jQuery(target).data('container');
    activeContainerId = kandyButtonId;
    var userName = jQuery('#'+kandyButtonId+ ' .kandyVideoButtonCallOut #'+kandyButtonId+'-callOutUserId').val();

    kandy.call.makeCall(userName, false);
    changeAnswerButtonState("CALLING",'#'+kandyButtonId);
};

/**
 * Event when click call button SSO
 */
kandy_makeVoiceCallSSO = function (target) {
    jQuery('#labelConnecting').text('Connecting...');
    // Make a video call to support
    var kandyButtonId = jQuery(target).data('container');
    activeContainerId = kandyButtonId;
    var userName = jQuery('#'+kandyButtonId+ ' .kandyVideoButtonCallOut #'+kandyButtonId+'-callOutUserId').val();

    kandy.call.makeCall(userName, false);
    changeAnswerButtonState("CALLING",'#'+kandyButtonId);
};

/**
 * Result success when login SSO
 */
onLoginSuccess = function () {
    console.log('login SSO is successful....');
    jQuery('#callBtn').removeAttr('disabled');
};

/**
 * Result error when login SSO
 */
onLoginFailure = function () {
    console.log('Error! Login SSO ....');
};
/**
 * Event when click end call button.
 */
kandy_end_call = function (target) {
    var kandyButtonId = jQuery(target).data('container');

    var currentCallId = jQuery("div#" + kandyButtonId).attr("data-call-id");
    kandy.call.endCall(currentCallId);
    if (callId) {
        callId = null;
    }
    activeContainerId = kandyButtonId;
    if (typeof end_call_callback == 'function') {
        end_call_callback('READY_FOR_CALLING');
    }
    changeAnswerButtonState("READY_FOR_CALLING", '#'+kandyButtonId);
};

/**
 * Event when click hold call button.
 */
kandy_hold_call = function (target) {
    var kandyButtonId = jQuery(target).data('container');
    var currentCallId = jQuery("#" + kandyButtonId).attr("data-call-id");
    callId = currentCallId;
    kandy.call.holdCall(currentCallId);

    activeContainerId = kandyButtonId;
    if (typeof hold_callback == 'function') {
        hold_call_callback('HOLD_CALL');
    }

    changeAnswerButtonState("HOLD_CALL", '#'+kandyButtonId);
};

/**
 * Event when click resume call button.
 */
kandy_resume_call = function (target) {
    var kandyButtonId = jQuery(target).data('container');
    var currentCallId = jQuery("#" + kandyButtonId).attr("data-call-id");
    callId = currentCallId;
    kandy.call.unHoldCall(currentCallId);

    activeContainerId = kandyButtonId;
    if (typeof hold_callback == 'function') {
        hold_call_callback('RESUME_CALL');
    }

    changeAnswerButtonState("RESUME_CALL", '#'+kandyButtonId);
};

/**
 * Add AddressBook widget.
 */
kandyLoadContactsAddressBook = function () {
    var contactListForPresence = [];
    var i = 0;
    var deleteContact = [];
    kandy.addressbook.retrievePersonalAddressBook(
        function (results) {
            var get_name_for_contact_url = jQuery(".kandyAddressBook #get_name_for_contact_url").val();
            results = get_display_name_for_contact(results, get_name_for_contact_url);

            // Clear out the current address book list.
            jQuery(".kandyAddressBook .kandyAddressContactList div:not(:first)").remove();
            var div = null;
            if (results.length == 0) {
                div = "<div class='kandyAddressBookNoResult'>-- No Contacts --</div>";
                jQuery('.kandyAddressBook .kandyAddressContactList').append(div);
                get_last_seen_interval();
            }
            else {
                jQuery('.kandyAddressBook .kandyAddressContactList').append("<div class='kandy-contact-heading'><span class='displayname'><b>Username</b></span><span class='userId'><b>Contact</b></span><span class='presence'><b>Status</b></span></div>");
                for (i = 0; i < results.length; i++) {
                    if (results[i].display_name != "kandy-un-assign-user") {
                        contactListForPresence.push(results[i].contact_user_name);

                        var id_attr = results[i].contact_user_name.replace(/[.@]/g, '_');
                        jQuery('.kandyAddressBook .kandyAddressContactList').append(
                            // HTML id can't contain @ and jquery doesn't like periods (in id).
                            "<div class='kandyContactItem' id='uid_" + id_attr + "'>" +
                                "<span class='displayname'>" + results[i].display_name + "</span>" +
                                "<span class='userId'>" + results[i].contact_user_name + "</span>" +
                                "<span id='presence_" + id_attr + "' class='presence'></span>" +
                                "<input class='removeBtn' type='button' value='Remove' " +
                                " onclick='kandy_removeFromContacts(\"" + results[i].contact_id + "\")'>" +
                                "</div>"
                        );
                    }
                    else {
                        deleteContact.push({id_attr: id_attr, contact_id: results[i].contact_id});
                    }
                }
                get_last_seen_interval(contactListForPresence);

                // Delete empty contact id.
                for (i = 0; i < deleteContact.length; i++) {
                    var contact_id = deleteContact[i].contact_id;
                    kandy_removeFromContacts(contact_id);
                }
            }
        },
        function () {
            console.log("Error kandyLoadContactsAddressBook");
        }
    );
};

/**
 * Get display name for contacts.
 *
 * @param data
 * Data.
 *
 * @returns {*}
 */
var get_display_name_for_contact = function (data, url) {
    if (data.length) {
        jQuery.ajax({
            url: ajax_object.ajax_url,
            type: "POST",
            data: {data: data, 'action': 'kandy_get_name_for_contact'},
            async: false
        }).done(function (response) {
                data = JSON.parse(response);
            }).fail(function (e) {
            });
    }
    return data;

};

/**
 * Get display name for chat content.
 *
 * @param data
 * Data.
 *
 * @returns {*}
 */
var getDisplayNameForChatContent = function (msg) {
    if (msg) {
        if(displayNames.hasOwnProperty(msg.sender.full_user_id)){
            msg.sender.display_name = displayNames[msg.sender.full_user_id];
            msg.sender.contact_user_name = msg.sender.full_user_id;
        } else {
            jQuery.ajax({
                url: ajax_object.ajax_url,
                type: "POST",
                data: {data: msg, action: 'kandy_get_name_for_chat_content'},
                async: false
            }).done(function (response) {
                msg = JSON.parse(response);
            }).fail(function (e) {
            });
        }

    }
    return msg;

};
/**
 * Add contact.
 */
var addContacts = function () {
    var contactId = jQuery(".kandyAddressBook #kandySearchUserName").val();
    kandy_addToContacts(contactId);
    jQuery(".kandyAddressBook #kandySearchUserName").select2('val', '');

};

/**
 * Change current user status with kandyAddressBook.
 *
 * @param status
 */
kandy_myStatusChanged = function (status) {
  jQuery.ajax({
    url: ajax_object.ajax_url,
    data: {'presence_status': status, 'action': 'kandy_set_presence'},
    dataType: 'json'
  }).done(function(){

  })

};

var userIdToAddToContacts = null;

/**
 * Add a user to contact list with kandyAddressBook.
 *
 * @param userId
 */
kandy_addToContacts = function (userId) {
    userIdToAddToContacts = userId;
    var contact;
    // HTML id can't contain @ and jquery doesn't like periods (in id).
    if (jQuery('#uid_' + userId.replace(/[.@]/g, '_')).length > 0) {
        alert("This person is already in your contact list.")
    }
    else {
        // Get and AddressBook.Entry object for this contact.
        kandy.addressbook.searchDirectoryByUserName(
            userId,
            function (results) {
                for (var i = 0; i < results.length; ++i) {
                    if (results[i].full_user_id === userIdToAddToContacts) {
                        // User name and nickname are required.
                        contact = {
                            contact_user_name: results[i].full_user_id,
                            contact_nickname: results[i].full_user_id
                        };
                        if (results[i].firstName) {
                            contact['contact_first_name'] = results[i].firstName;
                        }
                        if (results[i].lastName) {
                            contact['contact_last_name'] = results[i].lastName;
                        }
                        if (results[i].homePhone) {
                            contact['contact_home_phone'] = results[i].homePhone;
                        }
                        if (results[i].mobilePhone) {
                            contact['contact_mobile_number'] = results[i].mobilePhone;
                        }
                        if (results[i].workPhone) {
                            contact['contact_business_number'] = results[i].workPhone;
                        }
                        if (results[i].fax) {
                            contact['contact_fax'] = results[i].fax;
                        }
                        if (results[i].email) {
                            contact['contact_email'] = results[i].email;
                        }

                        kandy.addressbook.addToPersonalAddressBook(
                            contact,
                            kandyLoadContactsAddressBook,
                            function (message) {
                                alert("Error: " + message);
                            }
                        );
                        break;
                    }
                }
            },
            function (statusCode) {
                console.log("Error getting contact details: " + statusCode)
            }
        );
    }
};

/**
 * Remove a user from Contact List with kandyAddressBook.
 *
 * @param nickname
 */
kandy_removeFromContacts = function (nickname) {
    kandy.addressbook.removeFromPersonalAddressBook(nickname,
        kandyLoadContactsAddressBook,
        function () {
            console.log('Error kandy_removeFromContacts ');
        }
    );
};

/**
 * Search contact list by username with kandyAddressBook.
 */
kandy_searchDirectoryByUserName = function () {
    var userName = jQuery('.kandyAddressBook .kandyDirectorySearch #kandySearchUserName').val();
    var get_name_for_contact_url = ajax_object.ajax_url;
    jQuery.ajax({
        url: get_name_for_contact_url,
        data: {q:userName, action: 'kandy_get_user_for_search'}
    }).done(function (results) {
            results = JSON.parse(results);
            jQuery(".kandyAddressBook .kandyDirSearchResults div:not(:first)").remove();
            var div = null;
            if (results.length == 0) {
                div = "<div class='kandyAddressBookNoResult'>-- No Matches Found --</div>";
                jQuery('.kandyAddressBook .kandyDirSearchResults').append(div);
            }
            else {
                for (var i = 0; i < results.length; i++) {
                    jQuery('.kandyDirSearchResults').append(
                        "<div class='kandySearchItem'><span class='userId'>" + results[i].main_username + "</span><input type='button' value='Add Contact' onclick='kandy_addToContacts(\"" +
                            results[i].kandy_full_username + "\")' /></div>"
                    );
                }
            }
        }).fail(function () {
            jQuery(".kandyAddressBook .kandyDirSearchResults div:not(:first)").remove();
            var div = "<div class='kandyAddressBookNoResult'>There was an error with your request.</div>";
            jQuery('.kandyAddressBook .kandyDirSearchResults').append(div);
        });
};

/**
 * KANDY CHAT WIDGET FUNCTION.
 */

var wrapDivClass = "kandyChat";
var liTabWrapClass = "cd-tabs-navigation";
var liContentWrapClass = "cd-tabs-content";
var liTabWrapSelector = "." + wrapDivClass + " ." + liTabWrapClass;
var liContentWrapSelector = "." + wrapDivClass + " ." + liContentWrapClass;

var userHoldingAttribute = "data-content";
var activeClass = "selected";
var chatMessageTimeStamp = 0;
// group chat vars

var listUserClass = 'list-users';
var liTabGroupsWrap = liTabWrapSelector + '.groups';
var liTabContactWrap = liTabWrapSelector + '.contacts';
var groupSeparator = '.' + wrapDivClass + ' .separator.group';
var liTabLiveChatWrap = liTabWrapSelector + '.livechats';
var liveChatGroupSeparator = '.' + wrapDivClass + ' .separator.livechatgroup';

var displayNames = [];
var groupNames = [];
var usersStatus = {};
/**
 * Add an example chat box.
 */
var addExampleBox = function () {
    var tabId = "example";
    jQuery(liContentWrapSelector).append(getLiContent(tabId));
    jQuery(liContentWrapSelector).find('li[data-content="' + tabId + '"]').addClass('selected').find(".chat-input").attr('disabled', true);
};

/**
 * Get a contact template.
 *
 * @param user
 * User.
 * @param active
 * Active.
 *
 * @returns {string}
 */
var getLiContact = function (user, active) {
    var username = user.contact_user_name;
    var real_id = '';
    if(typeof user.user_email != 'undefined'){
        username = user.user_email;
        real_id = "data-real-id='" + user.contact_user_name + "' ";
    }
    var displayName = user.display_name;
    var id = username.replace(/[.@]/g, '_');
    var liClass = (typeof active !== 'undefined') ? active : "";
    return '<li id="' + id + '" class="' + liClass + '"><a ' + real_id + userHoldingAttribute + '="' + username + '" href="#">' + displayName + '</a><i class="status"></i></li>';
};

/**
 * Get contact content template.
 *
 * @param user
 * User.
 *
 * @returns {string}
 */
var getLiContent = function (user, real_id) {
    var uid= '';
    if(typeof real_id != "undefined"){
        uid = real_id;
    }
    var result =
        '<li ' + userHoldingAttribute + '="' + user + '">\
                <div class="kandyMessages" data-user="' + user + '">\
                </div>\
                <div >\
                    Messages:\
                </div>\
                <div>\
                            <form class="send-message" data-real-id="'+ uid + '" data-user="' + user + '">\
                        <div class="input-message">\
                            <input class="imMessageToSend chat-input" type="text" data-user="' + user + '">\
                            <div class="send-file">\
                                <label for="send-file">\
                                    <span class="icon-file"></span>\
                                </label>\
                                <input id="send-file" type="file" />\
                            </div>\
                        </div>\
                        <div class="button-send">\
                            <input class="btnSendMessage chat-input" type="submit" value="Send" data-user="' + user + '" >\
                        </div>\
                    </form>\
                </div>\
            </li>';
    return result;

};

/**
 * Kandy Contact Filter Change.
 *
 * @param val
 */
var kandy_contactFilterChanged = function (val) {
    var liUserchat = jQuery(".kandyChat .cd-tabs-navigation li");
    jQuery.each(liUserchat, function (index, target) {
        var liClass = jQuery(target).attr('class');
        var currentClass = "kandy-chat-status-" + val;
        var currentGroupClass = "kandy-chat-status-g-" +val;
        if (val == "all") {
            jQuery(target).show();
        }
        else if (currentClass == liClass || jQuery(target).hasClass(currentGroupClass)) {
            jQuery(target).show();
        }
        else {
            jQuery(target).hide();
        }
    });
};

var kandy_get_presence = function(lastSeen){
  lastSeen.action = 'kandy_get_presence';
  jQuery.ajax({
    url: ajax_object.ajax_url,
    data: lastSeen,
    method: 'POST',
    dataType: 'json'
  }).done(function(presences) {
    presences.forEach(function(user, index){
      kandyPresence[user.full_user_id] = user.presence_status;
    });
    jQuery('body').trigger('presenceChanged');
  })
};


var get_last_seen = function(contacts){
  contacts = contacts || [current_kandy_user];
  kandy.getLastSeen(contacts, function(result){
    kandy_get_presence(result);
  });
};

var get_last_seen_interval = function(contacts) {
    get_last_seen(contacts);
    //clear old interval
    if(last_seen_interval) {
        clearInterval(last_seen_interval);
    }
    last_seen_interval = setInterval(get_last_seen,10000, contacts);
};


/**
 * Load Contact for KandyChat.
 */
kandy_load_contacts_chat = function () {
    var contactListForPresence = [];
    kandy.addressbook.retrievePersonalAddressBook(
        function (results) {
            if(results.length) {
              var get_name_for_contact_url = jQuery(".kandyChat #get_name_for_contact_url").val();
              results = get_display_name_for_contact(results, get_name_for_contact_url);
              emptyContact();
              for (var i = 0; i < results.length; i++) {
                prependContact(results[i]);
                contactListForPresence.push(results[i].contact_user_name);
              }
              addExampleBox();
              get_last_seen_interval(contactListForPresence);
              jQuery('.cd-tabs-navigation > li:first-child > a').trigger('click');
            } else {
              get_last_seen_interval();
            }

        },
        function () {
            console.log("Error");
            addExampleBox();
        }
    );
};

/**
 * Send a message with kandyChat.
 *
 * @param username
 */
kandy_send_message = function (username, dataHolder) {
    var displayName = jQuery('.kandyChat .kandy_current_username').val();
    var dataHolder = (typeof dataHolder!= 'undefined')? dataHolder : username;
    var inputMessage = jQuery('.kandyChat .imMessageToSend[data-user="' + dataHolder + '"]');
    var message = inputMessage.val();
    inputMessage.val('');
    if (message.trim() != '') {
        kandy.messaging.sendIm(username, message, function () {
                var newMessage = '<div class="my-message">\
                    <b><span class="imUsername">' + displayName + ':</span></b>\
                    <span class="imMessage">' + message + '</span>\
                </div>';
                var messageDiv = jQuery('.kandyChat .kandyMessages[data-user="' + dataHolder + '"]');
                messageDiv.append(newMessage);
                messageDiv.scrollTop(messageDiv[0].scrollHeight);
            },
            function () {
                alert("IM send failed");
            }
        );
    }
};

/**
 * on Message event listener callback
 * @param msg
 */
var kandy_onMessage = function(msg) {
    if(msg){
        msg = getDisplayNameForChatContent(msg);
    }
    if(msg.messageType == 'chat'){
        // Get user info
        var username = msg.sender.full_user_id;
        if(typeof msg.sender.user_email != "undefined" ){
            username = msg.sender.user_email;
        }
        var displayName = msg.sender.display_name;
        // Process tabs
        if (!jQuery(liTabWrapSelector + " li a[" + userHoldingAttribute + "='" + username + "']").length) {
            prependContact(msg.sender);
        }
        if (!jQuery('input.imMessageToSend').is(':focus')) {
            move_contact_to_top_and_set_active(msg.sender);
        } else {
            move_contact_to_top(msg.sender);
        }
        // Process message
        if ((msg.hasOwnProperty('message'))) {
            var message = msg.message.text;
            var newMessage = '<div class="their-message"><span class="imUsername">' + displayName + ':</span>';

            if (msg.contentType === 'text' && msg.message.mimeType == 'text/plain') {
                newMessage += '<span class="imMessage" style="margin-left: 5px">' + message.replace(/\\'/g, "'").replace(/\\"/g, '"') + '</span>';
            } else {
                var fileUrl = kandy.messaging.buildFileUrl(msg.message.content_uuid);
                var html = '';
                if (msg.contentType == 'image') {
                    html = '<div class="wrapper-img"><img src="' + fileUrl + '"></div>';
                }
                html += '<a class="icon-download" href="' + fileUrl + '" target="_blank">' + msg.message.content_name + '</a>';
                newMessage += '<span class="imMessage">' + html + '</span>';
            }

            newMessage += '</div>';

            var messageDiv = jQuery('.kandyChat .kandyMessages[data-user="' + username + '"]');
            messageDiv.append(newMessage);
            messageDiv.scrollTop(messageDiv[0].scrollHeight);
        }
    }

};

// Gather the user input then send the image.
send_file = function () {
    // Gather user input.
    var recipient = jQuery(".livechats a.selected").data('real-id');
    if (typeof recipient == "undefined") {
        recipient = jQuery(".contacts a.selected").data('content');
        if (typeof recipient == "undefined") {
            recipient = jQuery(".cd-tabs-content form.send-message").data('real-id');
        }
    }

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
    var displayName = jQuery('.kandyChat .kandy_current_username').val();
    var dataHolder = jQuery('.cd-tabs-content > li.selected').data('content');
    var newMessage = '<div class="my-message">\
                    <b><span class="imUsername">' + displayName + ': </span></b>';


    var fileUrl = kandy.messaging.buildFileUrl(message.message.content_uuid);
    var html = '';
    if (message.contentType == 'image') {
        html = '<div class="wrapper-img"><img src="' + fileUrl + '"></div>';
    }
    html += '<a class="icon-download" href="' + fileUrl + '" target="_blank">' + message.message.content_name + '</a>';
    newMessage += '<span class="imMessage">' + html + '</span>';
    newMessage += '</div>';

    var messageDiv = jQuery('.kandyChat .kandyMessages[data-user="' + dataHolder + '"]');
    messageDiv.append(newMessage);
    messageDiv.scrollTop(messageDiv[0].scrollHeight);
}

// What to do on a file send failure.
function onFileSendFailure() {
    console.log("File send failure.");
}

/**
 * Empty all contacts.
 */
var emptyContact = function () {
    jQuery(liTabContactWrap).html("");
};

/**
 * Prepend a contact.
 *
 * @param user
 */
var prependContact = function (user) {
    var isLiveChat = false;
    var username = user.contact_user_name;
    if(typeof user.user_email != "undefined"){
        isLiveChat = true;
        username = user.user_email;
    }

    var liParent = jQuery(liTabContactWrap + " li a[" + userHoldingAttribute + "='" + username + "']").parent();
    var liContact = "";
    if(liParent.length){
        liContact =  liParent[0].outerHTML;
    } else {
        liContact = getLiContact(user);
    }
    if(!isLiveChat){
        jQuery(liTabContactWrap).prepend(liContact);
    }else {
        jQuery(liTabLiveChatWrap).prepend(liContact);
        if(jQuery(liveChatGroupSeparator).hasClass('hide')){
            jQuery(liveChatGroupSeparator).removeClass('hide');
        }
    }
    if (!jQuery(liContentWrapSelector + " li[" + userHoldingAttribute + "='" + username + "']").length) {
        var liContent = getLiContent(username, user.contact_user_name);
        jQuery(liContentWrapSelector).prepend(liContent);
    }
};

/**
 * Get current active user name.
 *
 * @returns {*|jQuery}
 */
var getActiveContact = function () {
    return jQuery(liTabWrapSelector + " li." + activeClass).attr(userHoldingAttribute);
};

/**
 * Set focus to a user.
 *
 * @param user
 */
var setFocusContact = function (user) {
    var username = user.contact_user_name;
    if(typeof user.user_email != "undefined"){
        username = user.user_email;
    }
    jQuery(liTabWrapSelector + " li a[" + userHoldingAttribute + "='" + username + "']").trigger("click");
};

/**
 * Move a contact user to top of the list.
 *
 * @param user
 */
var move_contact_to_top = function (user) {
    var username = user.contact_user_name;
    if(typeof user.user_email != "undefined"){
        username = user.user_email;
    }

    var contact = jQuery(liTabWrapSelector + " li a[" + userHoldingAttribute + "='" + username + "']").parent();
    var active = contact.hasClass(activeClass);

    // Add to top.
    prependContact(user, active);
    // Remove.
    contact.remove();
};

/**
 * Move a contact user to top of the list set set focus to it.
 *
 * @param user
 */
var move_contact_to_top_and_set_active = function (user) {
    move_contact_to_top(user);
    setFocusContact(user);
    jQuery(liTabWrapSelector).scrollTop(0);
};

/**
 * Load group details
 * @param sessionId
 */



/**
 * Build list of participants
 * @param sessionDetails
 */

var buildListParticipants = function(sessionId, participants, admin_id){
    var listUsersGroup = jQuery(liTabWrapSelector + ' li[data-group="'+sessionId+'"] ' + ' .'+ listUserClass);
    listUsersGroup.empty();
    var get_name_for_contact_url = jQuery(".kandyChat #get_name_for_contact_url").val();
    participants.push({full_user_id : admin_id});
    participants = get_display_name_for_contact(participants, get_name_for_contact_url);
    if(participants.length){
        for(var i in participants) {
            displayNames[participants[i].full_user_id] = participants[i].display_name;
            if(!jQuery(listUsersGroup).find('li[data-user="'+participants[i].full_user_id+'"]').length) {
                var status = '';
                var additionBtn = '';
                var displayName = displayNames[participants[i].full_user_id];
                if(admin_id == participants[i].full_user_id){
                    displayName += '<span> (owner)</span>';
                }
                jQuery(listUsersGroup).append(
                    '<li data-user="' + participants[i].full_user_id + '">' +
                    '<a>' + displayName +
                    '</a>' +
                    '<span class="actions">'+additionBtn +'</span>'+
                    '<div class="statusContainer"><i class="status"></i>'+ ((status) ? '<i class="group-status">(' + status + ')</i>' : '') + '</div>'+
                    '</li>'
                );
            }
        }
    }

};
/**
 * Load open group chat
 */
var kandy_loadGroups = function(){
    kandy.messaging.getGroups(
        function (result) {
            jQuery(liTabGroupsWrap).empty();
            if(result.hasOwnProperty('groups')){
                if(result.groups.length){
                    jQuery(groupSeparator).removeClass('hide');
                    for(var i in result.groups){
                        //build sessions list here
                        groupNames[result.groups[i].group_id] = result.groups[i].group_name;
                        if (!jQuery(liTabGroupsWrap + " li[data-group='" + result.groups[i].group_id + "']").length) {
                            jQuery(liTabGroupsWrap).append(
                                '<li data-group="' + result.groups[i].group_id + '" class="group">' +
                                '<i class="toggle fa fa-plus-square-o"></i>' +
                                '<a title="' + result.groups[i].session_status + '" onclick="kandy_loadGroupDetails(\'' + result.groups[i].group_id + '\')" data-content="' + result.groups[i].group_id + '" href="#">' +
                                result.groups[i].group_name +
                                '</a>' +
                                '<div class="groupAction"></div>' +
                                '<ul class="list-users"></ul>' +
                                '</li>'
                            );
                        }
                        if (!jQuery(liContentWrapSelector + " li[" + userHoldingAttribute + "='" + result.groups[i].group_id + "']").length) {
                            var liContent = getGroupContent(result.groups[i].group_id);
                            jQuery(liContentWrapSelector).prepend(liContent);

                        }
                        kandy_loadGroupDetails(result.groups[i].group_id);

                    }
                }else{
                    jQuery(groupSeparator).addClass('hide');
                }
            }
        },
        function (msg, code) {
            console.debug('load sessions fail. Code:'+ code +'. Message:'+msg);
        }
    );
};

/**
 *  Event handler for onData event
 */
var kandy_onGroupMessage = function(msg){
    if(typeof msg != 'undefined'){
        var msgType = msg.messageType;
        var sender = displayNames[msg.sender.full_user_id] || msg.sender.user_id;
        if(msgType == 'groupChat'){
            if(msg.contentType == 'text'){
                if (msg.message.text.trim() != '') {
                    var newMessage = '<div class="their-message">\
                            <b><span class="imUsername">' + sender + ':</span></b>\
                            <span class="imMessage">' + msg.message.text + '</span>\
                        </div>';

                    var messageDiv = jQuery('.kandyChat .kandyMessages[data-group="'+msg.group_id+'"]');
                    messageDiv.append(newMessage);
                    messageDiv.scrollTop(messageDiv[0].scrollHeight);
                }
            }

        }
    }

};

/**
 * Add member to a group
 * @param group_id
 * @param members
 */
var kandy_inviteUserToGroup = function(group_id, members){
    kandy.messaging.addGroupMembers(group_id, members,

        function(results) {
            kandy_loadGroupDetails(group_id);
        },
        function(msg, code) {
            alert('Error - something went wrong when we tried to addGroupMembers');
        }

    );
};

/**
 * on group invite user event
 */
var kandy_onGroupInvite = function() {
    kandy_loadGroups();
};

/**
 * user removed from group chat event
 * @param message
 */
var kandy_onRemovedFromGroup = function(message){
    if(message.messageType == 'chatGroupBoot') {
        var bootedUser = message.booted[0];
        var notify;
        if (bootedUser != current_kandy_user) {
            notify = (displayNames[bootedUser] || bootedUser.split('@')[0]) + ' is removed from this group';
            kandy_loadGroupDetails(message.group_id);
        } else {
            notify = 'You are removed from this group';
            kandy_loadGroups();
            changeGroupInputState(message.group_id, true);
        }
        var newMessage = '<div class="their-message">\
                    <span class="imMessage"><i>' + notify + '</i></span>\
                </div>';
        var messageDiv = jQuery('.kandyChat .kandyMessages[data-group="' + message.group_id + '"]');
        messageDiv.append(newMessage);
    }
};

var getGroupContent = function (groupId) {
    var result =
        '<li ' + userHoldingAttribute + '="' + groupId + '">\
                <div class="kandyMessages" data-group="' + groupId + '">\
                </div>\
                <div >\
                    Messages:\
                </div>\
                <div class="">\
                            <form class="send-message" data-group="' + groupId + '">\
                        <div class="input-message">\
                            <input class="imMessageToSend chat-input" type="text" data-group="' + groupId + '">\
                        </div>\
                        <div class="button-send">\
                            <input class="btnSendMessage chat-input" type="submit" value="Send"  data-group="' + groupId + '" >\
                        </div>\
                    </form>\
                </div>\
            </li>';
    return result;
};
var changeGroupInputState = function(groupId, state) {
    var messageInput = jQuery(liContentWrapSelector + ' li[data-content="'+groupId+'"] form .imMessageToSend');
    messageInput.prop('disabled',!!state);
};

var kandy_createGroup = function(groupName, successCallback, failCallback){
    /** create(sessionConfig, success, failure)
     Creates a new session. The creating user is the administrator.
     @params <object> sessionConfig, <function> success/failure
     */
    kandy.messaging.createGroup(groupName, "", successCallback, failCallback);
};
/**
 * Send group IM
 * @param groupId
 * @param msg
 */
var kandy_sendGroupIm = function(groupId,msg){
    if (typeof msg != 'undefined' && msg.trim() != '') {
        var username = jQuery("input.kandy_current_username").val();
        kandy.messaging.sendGroupIm(groupId, msg,
            function() {
                var newMessage = '<div class="my-message">\
                    <b><span class="imUsername">' + username + ':</span></b>\
                    <span class="imMessage">' + msg + '</span>\
                </div>';
                var messageDiv = jQuery('.kandyChat .kandyMessages[data-group="' + groupId + '"]');
                messageDiv.append(newMessage);
                messageDiv.scrollTop(messageDiv[0].scrollHeight);
            },
            function(msg, code) {
                console.log('Error sending Data (' + code + '): ' + msg);
            }
        );
    }
};
/**
 * on join request callback, currently use for co-browser
 * @param notification
 */
var kandy_onSessionJoinRequest = function(notification) {
    var message = 'User '+notification.full_user_id+' request to join session '+ sessionNames[notification.session_id];
    var confirm = window.confirm(message);
    if(confirm){
        kandy_ApproveJoinSession(notification.session_id, notification.full_user_id);
    }else{
        console.log("join request has been disapproved");
    }
};

/**
 * Approve join session request
 * @param sessionId
 * @param userId
 * @param successCallback
 */
var kandy_ApproveJoinSession = function(sessionId, userId, successCallback){
    KandyAPI.Session.acceptJoinRequest(sessionId, userId,
        function () {
            if(typeof successCallback == "function"){
                successCallback(sessionId);
            }
        },
        function (msg, code) {
            console.log('Error:'+code+': '+msg);
        }
    );
};


var kandy_onLeaveGroup = function(message){
    if(message.messageType == 'chatGroupLeave') {
        var leaverDisplayName = displayNames[message.leaver] || message.split('@')[0];
        var groupId = message.group_id;
        var notify = leaverDisplayName + ' is left';
        if (message.leaver != current_kandy_user) {
            kandy_loadGroupDetails(message.group_id);
        } else {
            kandy_loadGroups();
            changeGroupInputState(message.group_id, true);
        }
        var newMessage = '<div class="their-message">\
                    <span class="imMessage"><i>' + notify + '</i></span>\
                </div>';
        var messageDiv = jQuery('.kandyChat .kandyMessages[data-group="' + groupId + '"]');
        messageDiv.append(newMessage);
    }
};
/**
 * onJoinApprove event use for co-browsing session
 * @param notification
 */
var kandy_onSessionJoinApprove = function(notification){
    if(typeof sessionJoinApprovedCallback !== 'undefined'){
        sessionJoinApprovedCallback(notification.session_id);
    }
};
/**
 * Remove user from group
 * @param sessionId
 * @param userId
 */
var kandy_removeFromGroup = function(groupId, userId) {
    var members = [];
    members.push(userId);
    var displayName = displayNames[userId] || userId.split('@')[0];
    var confirm = window.confirm("Do you want to remove "+displayName +' from this group?');
    if(confirm){
        kandy.messaging.removeGroupMembers(groupId, members,
            function () {
                kandy_loadGroupDetails(groupId);
            },
            function (msg, code) {
                console.log(code + ': ' + msg);
            }
        );
    }

};

var activateSession = function(sessionId){
    KandyAPI.Session.activate(
        sessionId,
        function(){
            //success callback
            console.log('activate group successful');
        },function(){
            //fail callback
            console.log('Error activating group');
        }
    );

};

var kandy_leaveGroup= function(groupId, successCallback, failCallback){
    var confirm = window.confirm("Do you want to leave group "+groupNames[groupId] +"?");
    if(confirm){
        kandy.messaging.leaveGroup(groupId, successCallback, failCallback);
    }

};
/**
 * Terminate a session
 * @param sessionId
 */
var kandy_terminateGroup = function(groupId, successCallback, failCallback){
    var confirm = window.confirm("Do you want to remove group " + groupNames[groupId] +"?");
    if(confirm){
        kandy.messaging.deleteGroup(groupId, successCallback, failCallback);
    }
};

var kandy_createSession = function(config, successCallback, failCallback) {
    KandyAPI.Session.create(
        config,
        function(result){
            if(typeof successCallback == "function"){
                activateSession(result.session_id);
                successCallback(result);
            }
        },
        function(){
            if(typeof failCallback == "function"){
                failCallback();
            }
        }
    )
};

var kandy_joinSession = function (sessionId, successCallback){
    KandyAPI.Session.join(
        sessionId,
        {},
        function () {
            if(typeof successCallback == "function"){
                successCallback(sessionId);
            }
        },
        function (msg, code) {
            console.log(code + ": " + msg);
        }
    );
};

var kandy_LeaveSession= function(sessionId, successCallBack){
    KandyAPI.Session.leave(sessionId,
        '',
        function(){
            if(typeof successCallBack == 'function'){
                successCallBack(sessionId);
            }
        },
        function(){
            console.log('Leave group fail');
        }
    )
};


/**
 * session terminate event callback
 * @param notification
 */
var kandy_onTerminateGroup = function(notification){
    removeGroupContent(notification.group_id);
    kandy_loadGroups();
};
/**
 * session active event callback
 * @param notification
 */
var kandy_onActiveGroup = function(notification){
    kandy_loadGroups();
};
/**
 * Clean things up after remove group
 * @param sessionId
 */
var removeGroupContent = function(sessionId){
    var toBeRemove = jQuery(liContentWrapSelector + ' li[data-content="'+sessionId+'"]');
    if(toBeRemove.hasClass('selected')){
        toBeRemove.siblings('[data-content="example"]').addClass('selected');
    }
    toBeRemove.remove();
};

var updateUserGroupStatus = function (){
    if(usersStatus){
        if(jQuery(liTabGroupsWrap).length){
            for(var u in usersStatus){
                var liUserGroup = jQuery(liTabGroupsWrap + ' li[data-user="'+u+'"]');
                var status = usersStatus[u].replace(/ /g,'-').toLowerCase();
                liUserGroup.find('i.status').html(usersStatus[u]);
                liUserGroup.removeClass();
                liUserGroup.addClass('kandy-chat-status-' + status );
                liUserGroup.attr('title', usersStatus[u]);
                jQuery(liUserGroup).closest("li[data-group]").addClass('kandy-chat-status-g-'+status);
            }

        }
    }
};
var kandy_getSessionInfo = function(sessionId, successCallback, failCallback){
    KandyAPI.Session.getInfoById(sessionId,
        function(result){
            if(typeof successCallback == 'function'){
                successCallback(result);
            }
        },
        function (msg, code) {
            if(typeof failCallback == 'function' ){
                failCallback(msg,code);
            }
        }
    )
};
var kandy_loadGroupDetails = function(groupId){
    kandy.messaging.getGroupById(groupId,
        function (result) {
            var isOwner = false, notInGroup = true, groupActivity = '';
            var groupAction = jQuery(liTabWrapSelector +' li a[data-content="'+result.group_id+'"]').parent().find('.groupAction');
            var messageInput = jQuery(liContentWrapSelector + ' li[data-content="'+result.group_id+'"] form .imMessageToSend');
            buildListParticipants(groupId, result.members, result.owners[0].full_user_id);
            //if current user is owner of this group
            if(current_kandy_user === result.owners[0].full_user_id ){
                //add admin functionality
                isOwner = true;
                groupActivity = '<a class="" href="javascipt:;"><i title="Remove group" onclick="kandy_terminateGroup(\''+result.group_id+'\', kandy_loadGroups)" class="fa fa-remove"></i></a>';
                jQuery(liTabWrapSelector + ' li[data-group="'+result.group_id+'"] ' + ' .'+ listUserClass+' li[data-user!="'+result.owners[0].full_user_id+'"] .actions').append(
                    '<i title="Remove user" class="remove fa fa-remove"></i>'
                );
            }
            //check if user is not in group
            for(var j in result.members){
                if(result.members[j].full_user_id == current_kandy_user){
                    notInGroup = false;
                }
            }
            if(isOwner){
                groupActivity += '<a class="btnInviteUser" title="Add user" data-reveal-id="inviteModal"  href="javascript:;"><i class="fa fa-plus"></i></a>';
                //disable message input if user not belongs to a specific group
            }else {
                groupActivity = '<a class="leave" title="Leave group" onclick="kandy_leaveGroup(\''+result.group_id+'\',kandy_loadGroups)" href="javascript:;"><i class="fa fa-sign-out"></i></a>';
                if(messageInput.is(':disabled')){
                    messageInput.prop('disabled',false);
                }
            }
            groupAction.html(groupActivity);
            updateUserGroupStatus();
        },
        function (msg, code) {
            console.log('Error: '+ code + ' - ' + msg);
        }
    );

};

var kandy_getOpenSessionsByType = function(sessionType, successCallback){
    KandyAPI.Session.getOpenSessionsByType (
        sessionType,
        function(result){
            for(var i = 0; i < result.sessions.length; i++){
                if(result.sessions[i].session_type != sessionType){
                    result.sessions.splice(i,1);
                }
            }
            if(typeof successCallback == "function") {
                successCallback(result.sessions);
            }
        },
        function(msg, code){

        }
    );
};
var getCoBrowsingSessions = function() {
    kandy_getOpenSessionsByType('cobrowsing', loadSessionList);
};

var kandy_startCoBrowsing = function(sessionId) {
    kandy.coBrowsing.startBrowsingUser(sessionId);
};

var kandy_stopCoBrowsing = function() {
    kandy.coBrowsing.stopBrowsingUser();
};
var kandy_sendSms = function(receiver, sender, message, successCallback, errorCallback) {
    if(receiver && message) {
      kandy.messaging.sendSMS(
        receiver,
        sender,
        message,
        function() {
          if(typeof successCallback == 'function'){
            successCallback();
          }
        },
        function(message, status) {
          if(typeof errorCallback == 'function'){
            errorCallback(message, status);
          }
        }
      );
    }

};
/**
 * @param sessionId
 * @param holder - id of browsing holder
 */
var kandy_startCoBrowsingAgent = function(sessionId, holder) {
    kandy.coBrowsing.startBrowsingAgent(sessionId, holder);
};

var kandy_stopCoBrowsingAgent = function() {
    kandy.coBrowsing.stopBrowsingAgent();
};

var heartBeat = function(interval){
    return setInterval(function(){
        jQuery.get(ajax_object.ajax_url + '?action=kandy_still_alive');
    },parseInt(interval));
};

/**
 * Ready================================================================================================================
 */
jQuery(document).ready(function (jQuery) {

    if (jQuery(".kandyChat").length) {
        jQuery(document).on('change', "input[type=file]", function (e){
            var fileName = jQuery(this).val();
            if (fileName != '') {
                send_file();
            }
        });
    }

  jQuery('body').on('presenceChanged', function(){
    for(var userId in kandyPresence){
      kandyPresenceNotificationCallback(userId,kandyPresence[userId].toLowerCase(),kandyPresence[userId]);
    }
  });

  var sms = window.sms;
    if(sms){
        var btnSendSms = jQuery("."+sms.class +" #"+sms.btn_send_id);
    }

    // Register kandy widget event.
    if (typeof login == 'function') {
        setup();
        login();
        console.log('login....');
    } else if (typeof loginSSO == 'function') {
        setup();
        loginSSO();
    }

    // Active Select2.
    if (jQuery('.kandyButton').length) {
        var ajaxUrl = ajax_object.ajax_url;
        jQuery(".kandyButton .select2").select2({
            ajax: {
                quietMillis: 100,
                url: ajaxUrl,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {'q': params, 'action': 'kandy_get_user_for_search'};
                },
                results: function (data) {
                    return {results: data};
                }
            },
            minimumInputLength: 1
        });
    }

    if (jQuery('.kandyAddressBook').length) {
        var ajaxUrl = ajax_object.ajax_url;
        jQuery(".kandyAddressBook .select2").select2({
            ajax: {
                quietMillis: 100,
                url: ajaxUrl,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {'q': params, 'action': 'kandy_get_user_for_search'};
                },
                results: function (data) {
                    return {results: data};
                }
            },
            minimumInputLength: 1
        });
    }
    // Only work when kandyChat exists.
    if (jQuery('.kandyChat').length) {
        jQuery(".kandyChat form.send-message").live("submit", function (e) {
            var username = jQuery(this).attr('data-user');
            var realID = jQuery(this).data('real-id');
            if(realID == ''){
                realID = username;
            }
            if(jQuery(this).is('[data-user]')){
                kandy_send_message(realID, username);
            }else{
                kandy_sendGroupIm(jQuery(this).data('group'),jQuery(this).find('.imMessageToSend').val());
                jQuery(this).find('.imMessageToSend').val('');
            }
            e.preventDefault();
        });

        var ajaxUrl = ajax_object.ajax_url;
        jQuery("#kandy-chat-add-user-modal .select2").select2({
            ajax: {
                quietMillis: 100,
                url: ajaxUrl,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {'q': params, 'action': 'kandy_get_user_for_search'};
                },
                results: function (data) {
                    return {results: data};
                }
            },
            minimumInputLength: 1
        });

        jQuery("#kandy-chat-create-group-modal").dialog({
            autoOpen: false,
            height: 300,
            width: 600,
            modal: true,
            buttons: {
                "Save": function() {
                    var groupName = jQuery('#kandy-chat-create-session-name').val();
                    var errors = [];
                    var errorContainer = jQuery(".errors");
                    errorContainer.empty();
                    if(groupName == ''){
                        alert('Group must have a name.');
                        jQuery('#kandy-chat-create-session-name').focus();
                    } else {
                        kandy_createGroup(groupName, kandy_loadGroups);
                        jQuery('#kandy-chat-create-session-name').val('');
                        jQuery( this ).dialog( "close" );
                    }
                },
                Cancel: function() {
                    jQuery( this ).dialog( "close" );
                }
            }
        });

        jQuery("#kandy-chat-add-user-modal").dialog({
            autoOpen: false,
            height: 300,
            width: 600,
            modal: true,
            buttons: {
                "Save": function() {
                    var username = jQuery('#kandy-chat-invite-username').val();
                    var groupId = jQuery('#kandy-chat-add-user-modal').data('group');
                    var errors = [];
                    var errorContainer = jQuery(".errors");
                    errorContainer.empty();
                    if(username == ''){
                        alert('PLease provide a username to add to group');
                        jQuery('#kandy-chat-invite-username').focus();
                    } else {
                        kandy_inviteUserToGroup(groupId,[username]);
                        jQuery('#kandy-chat-invite-username').val('');
                        jQuery( this ).dialog( "close" );
                    }
                },
                Cancel: function() {
                    jQuery( this ).dialog( "close" );
                }
            }
        });

        jQuery(".kandyChat #btn-create-group-modal").click(function(){

            jQuery("#kandy-chat-create-group-modal").dialog('open');
            jQuery('#kandy-chat-create-session-name').focus();
        });

        jQuery(".kandyChat .btnInviteUser").live('click', function(){

            jQuery("#kandy-chat-add-user-modal").attr('data-group', jQuery(this).closest('li.group').data('group')).dialog('open');
            jQuery('#kandy-chat-invite-username').focus();
        });


        jQuery('.list-users li .remove').live('click', function(e){
            var userId = jQuery(this).closest('li').data('user');
            var groupId = jQuery(this).closest('[data-group]').data('group');
            kandy_removeFromGroup(groupId,userId);
        });

        var tabContentWrapper = jQuery(liContentWrapSelector);

        jQuery('.cd-tabs-navigation > li > a').live('click', function (event) {
            event.preventDefault();
            var selectedItem = jQuery(this);
            if (!selectedItem.hasClass('selected')) {
                var selectedTab = selectedItem.data('content'),
                    selectedContent = tabContentWrapper.find('li[data-content="' + selectedTab + '"]'),
                    selectedContentHeight = jQuery(".cd-tabs-navigation").parent('nav').height();

                jQuery('.cd-tabs-navigation a').removeClass('selected');
                selectedItem.addClass('selected');
                selectedContent.addClass('selected').siblings('li').removeClass('selected');

                // Set focus.
                selectedContent.find(".imMessageToSend").focus();

                var sendFile = jQuery(liContentWrapSelector + ' li[data-content="'+selectedTab+'"] form .icon-file');
                sendFile.css('display', 'block');

                // Set chat heading.
                jQuery(".chat-with-message").show();
                jQuery(".chat-friend-name").html(selectedItem.html());

                // Animate tabContentWrapper height when content changes.
                tabContentWrapper.animate({
                    'height': selectedContentHeight
                }, 200);
            }
        });

        // Hide the .cd-tabs::after element when tabbed navigation has scrolled to the end (mobile version).
        check_scrolling(jQuery('.cd-tabs nav'));

        jQuery(window).live('resize', function () {
            check_scrolling(jQuery('.cd-tabs nav'));
        });

        jQuery('.cd-tabs nav').live('scroll', function () {
            check_scrolling(jQuery(this));
        });

        function check_scrolling(tabs) {
            var totalTabWidth = parseInt(tabs.children('.cd-tabs-navigation').width()),
                tabsViewport = parseInt(tabs.width());
            if (tabs.scrollLeft() >= totalTabWidth - tabsViewport) {
                tabs.parent('.cd-tabs').addClass('is-ended');
            }
            else {
                tabs.parent('.cd-tabs').removeClass('is-ended');
            }
        }
        jQuery(".toggle").live('click',function(){
            jQuery(this).toggleClass('fa-plus-square-o').toggleClass('fa-minus-square-o');
            jQuery(this).siblings('.list-users').toggleClass('expanding');
        });


    }
    if(typeof sms != 'undefined'){
        btnSendSms.click(function(){
            try {
                kandy_sendSms(jQuery(".smsContainer #phoneNum").val(),'', jQuery("#msg").val(), function(){
                  jQuery('.smsContainer .smsStatus').html('Message sent!').css('color','green');
                }, function(){
                  jQuery('.smsContainer .smsStatus').html('There was an error. Please try again later.').css('color', 'red');
                });
            }catch(e){
                console.log('There was an error');console.dir(e);
            }
        })
    }
});
