# Kandy Wordpress Plugin
KANDY is about making communications simple with the KANDY platform managing all the complexity and hard stuff, while you focus on the intent of your application. KANDY manages all the elements of your voice, video, presence and messaging requirements. Accessing the power of KANDY is simple using our provided developer tools.

Home page: http://www.kandy.io/
## User guide
Kandy Wordpress Plugin help you use kandy in your website easily by following steps: 

  - Install Kandy plugin and active it
  - Go **Kandy > Settings** to configure all required options.
  - Go **Kandy > User Assignment** to assign kandy users to your users. If you need refesh kandy users list please click sync.
  - Go **Kandy > Customization** to edit some script and style for your kandy components.
  - Go **Pages > Add New** to create a new page with kandy components by kandy shortcode.

####Kandy components and shortcode syntax:

**Kandy Video Button**: make a video call button component(video call) and it is integrated full screen, screen sharing feature.
```sh
[kandyVideoButton
        class = "myButtonStyle"
        id = "my-video-button"
        incomingLabel = "Incoming Call..."
        incomingButtonText = "Answer"
        callOutLabel = "User to call"
        callOutButtonText = "Call"
        callingLabel = "Calling..."
        callingButtonText = "End Call"
        onCallLabel = "You are connected!"
        onCallButtonText = "End Call"
        callto = "user_kandy@domain.com"
        anonymous = "true"]
```
*Note*:
Attribute "callto" and anonymous are optional

**Kandy Video**: make a video component (video call)
```sh
[kandyVideo 
    title = "You"
    id = "myVideo" 
    style = "width: 300px; height: 225px;background-color: darkslategray;"]
  ```
  
  **Kandy Voice Button**: make a voice call button component (voice call)
```sh
[kandyVoiceButton
        class = "myButtonStyle"
        id = "my-video-button"
        incomingLabel = "Incoming Call..."
        incomingButtonText = "Answer"
        callOutLabel = "User to call"
        callOutButtonText = "Call"
        callingLabel = "Calling..."
        callingButtonText = "End Call"
        onCallLabel = "You are connected!"
        onCallButtonText = "End Call"
        type = "PSTN"
        callto = "0123456789"
        anonymous = "true"]
```
*Note*:

If `type` is `PSTN`, `callto` is a phone number.
If `type` is not specified, `callto` is `kandy_user_name@domain.com`.

If `anonymous` is `true`, users don't need to login to call.
If `anonymous` is `false` (default), `callto` could be removed as the callee will be entered through GUI.

**Kandy Status**: make a kandy user status component (available, unavailable, awway, busy....). Kandy Status usually use with kandy address book component.
```sh
[kandyStatus
        class = "myStatusStyle"
        id = "myStatus"
        title = "My Status"]
  ```
**Kandy Address Book**: make an address book component which list all friend in your contact.
```sh
[kandyAddressBook
        class = "myAddressBookStyle"
        id = "myContact"
        title = "My Contact"
        userLabel = "User"
        addContactLabel = "Add Contact"
        searchResultLabel = "Directory Search Results"]
  ```
  
**Kandy Chat**: make a kandy chat component which help you send instant message to your friend in contact and it is integrated file sharing feature.
```sh
[kandyChat
        class = "myChatStyle"
        id = "my-chat"
        contactLabel = "Contacts"]
  ```
  **Kandy LiveChat**: Make a small widget to help you implement live chat, give your customers ability to chat with customer service agent.
```sh
[kandyLiveChat id="liveChat" class="liveChat"]
```
**Kandy Co-browsing**: Make a co-browsing component which help you share your browser screen with your friends.
```
[kandyCoBrowsing id="coBrowsing" class="coBrowsing"]
```
**Kandy SMS**: Make a SMS component which help you send SMS to someone's phone number
```
[kandySms id="kandySms" class="kandySms"]
```
  
### Quick Examples: 
**Kandy Voice Call**
```sh
[kandyVoiceButton class= "myButtonStyle" id ="my-voice-button"]
```
or
```sh
[kandyVoiceButton class= "myButtonStyle" id ="my-voice-button" callto="user_kandy@domain.com" anonymous="true"]
```

**Kandy Voice PSTN Call**
```sh
[kandyVoiceButton class= "myButtonStyle" type = "PSTN" id ="my-voice-button"]
```

**Kandy Voice PSTN Call With Number**
```sh
[kandyVoiceButton class= "myButtonStyle" type = "PSTN" callto = "0123456xxxx" id ="my-voice-button"]
```

**Kandy Video Call**: use a video call button and two video(**myVideo** and **theirVideo** id is required).
   ```sh
[kandyVideoButton class="myButtonStyle" callto="user_kandy@domain.com" anonymous="true"]
[kandyVideo title="You" id="myVideo" style = "width: 300px;height: 225px;"]
[kandyVideo title="Them" id="theirVideo" style = "width:300px;height: 225px;"]
```

*Note*: 
Two **kandyVideo** object should be inline because some editor will insert a break line automatically.

**Screen Sharing** feature:
 - Screen sharing can only be used over a secure connection (https).
 - Before testing it, please install this extension on chrome browser: 
   https://chrome.google.com/webstore/detail/kandyio-screen-sharing/daohbhpgnnlgkipndobecbmahalalhcp
 - This extension only works on localhost domain.
 - Finally, you test it on video call feature.

**Kandy Presence**: use a kandyStatus and kandy addressBook compobent
```sh
[kandyStatus class="myStatusStyle" id="myStatus"]
[kandyAddressBook class="myAddressBookStyle" id="myContact"]
```

**Kandy Chat**:
```sh
[kandyChat class="myChatStyle" id ="my-chat"]
```
####Kandy Administration:
**Settings**:

- **API Key:** Kandy API key which found in your kandy account.
- **Domain Secret Key:** Domain Kandy API key which found in your kandy account.
- **Domain Name:** Domain name of you kandy account.
- **Javascript Library Url**: Link to kandy javascript library.

**User assignment:**  help you synchronize kandy users from kandy server to your users system. Select your user and click edit button to assign(unassign) kandy user.

**Live chat configuration:**
Live chat feature needs some configurations before using:
- **Add Live Chat Agent**: From Kandy component menu, chose *Live chat agents management*. You can add a user from your user system to assign him as a Live Chat Agent


**Style customization**: help you edit kandy shortcode(video, voice, chat...) style. Select appropriate file(.css) then click edit them.

**Script customization** help you edit kandy shortcode(video, voice, chat...) script(add more behaviour). Select appropriate file(.js) then click edit them.

***All support script callback:***
```sh
window.login_success_callback = function () {
   //do something when you login successfully
}

window.login_failed_callback = function () {
    //do something when you login fail
}

window.call_incoming_callback = function (call, isAnonymous) {
    //do something when your are calling
}

window.on_call_callback = function (call) {
    //do something when you are oncall
}

window.call_answered_callback = function (call, isAnonymous) {
    //do something when someone answer your call
}

window.call_ended_callback = function () {
   //do something when someone end  your call
}

window.answer_voice_call_callback = function (stage) {
    //do something when you answer voice call
}

window.answer_video_call_callback = function (stage) {
    //do something when you answer video call
}

window.make_call_callback = function (stage) {
   //do something when you make call
}

window.end_call_callback = function (stage) {
   //do something when you click end call button
}

window.presence_notification_callback = function() {
    //do something with status notification
}
```

### Kandy API
You can use kandy plugin anywhere in your code by following code:

**Load Kandy Plugin**
```sh
require_once(KANDY_PLUGIN_DIR . "/api/kandy-api-class.php");
```
After load kandy plugin successfully you can use all support api:

**1. Get kandy user data for assignment table**
```sh
KandyApi::getUserData();
```
Return:  kandy user object **array**

**2. Get kandy domain access token**
```sh
KandyApi::getDomainAccessToken();
```
Return: **array**

```sh
$result = array("success" => true,
                "data" => "data",
                "message" => '')
OR
$result = array("success" => false,
                "data" => "data",
                "message" => "message")
```

**3. Get the kandy domain**
```sh
KandyApi::getDomain();
```
Get kandy domain from kandy settings or remote server

Return: **array**

```sh
$result = array("success" => true,
                "data" => "data",
                "message" => '');
OR
$result = array("success" => false,
                "data" => "data",
                "message" => "message");
```

**4. List Kandy User from database/remote**
```sh
KandyApi::listUsers($type = KANDY_USER_ALL, $remote = false);
```
Parameters:
```sh
$type(int) :
    KANDY_USER_ALL: all kandy users from database/remote
    KANDY_USER_ASSIGNED: all assigned kandy users from database/remote
    KANDY_USER_UNASSIGNED: all unassigned kandy users from database/remote
$remote(boolean) :
    If $remote = true, get kandy users from remote server(kandy server) instead of from database(local). Default is false.
```
Return: Kandy user object **array**

**5. Get assigned kandy user by current user id(main_user_id)**
```sh
KandyApi::getAssignUser($mainUserId);
```
Parameters:
```sh
$mainUserId(int): normal user id(1, 2, 3....)
```
Return kandy user object or null

**6 Get kandy user by kandy user id(kandyUserId)**
```sh
KandyApi::getUserByUserId($kandyUserId);
```
Parameters:
```sh
$kandyUserId(int): kandy user id without domain(user1, user2....)
```
Return kandy user object or null

**7. Assign a normal user to kandy user**
```sh
KandyApi::assignUser($kandyUserId, $mainUserId);
```
Parameters:
```sh
$kandyUserId(string) : kandy user id without domain(user1, user2....)
$mainUserId(int): normal user id(1, 2, 3....)
```
Return: true/false

**8. Unassign a kandy user**
```sh
KandyApi::unassignUser($mainUserId);
```
Parameters:
```sh
$mainUserId(int): normal user id(1, 2, 3....)
```
Return: true/false

**9. Kandy User synchronization**

Synchronize kandy user from remote server to local
```sh
KandyApi::syncUsers();
```

Return: array
```sh
$result = array(
                'success' => true,
                'message' => "Sync successfully"
            );
OR
$result = array(
                'success' => false,
                'message' => "Error Data"
            );

```

### Troubleshooting
- **Kandy ShortCode not working:** check your kandy api key, domain secret key, user assignment for your application at **Kandy > Settings**.
- **Internationalizing**: get the /languages/kandy.pot file and make your /languages/*.mo file to locale your language.
