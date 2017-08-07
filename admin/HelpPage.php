<?php
require_once (dirname(__FILE__) . "/KandyPage.php");
require_once (dirname(__FILE__) . "/AssignmentTableList.php");
require_once (KANDY_PLUGIN_DIR . "/api/kandy-api-class.php");
class KandyHelpPage extends KandyPage
{
    public function render()
    {
        $this->render_page_start("Kandy");
        ?>

        <h3>
            <?php _e("Kandy Help", "kandy"); ?>
        </h3>
        <p>
            <strong>Kandy Module</strong> is a full-service cloud platform that enables real-time communications for business applications.
        </p>

        <p>
            Home page: <a href="">http://www.kandy.io/</a>
        </p>

        <h4>
            ================================================================================
        </h4>

        <h2 style="box-sizing: border-box; margin-top: 1em; margin-bottom: 16px; line-height: 1.225; font-size: 1.75em; position: relative; font-weight: bold; padding-bottom: 0.3em; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: rgb(238, 238, 238); font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif;">
            User guide
        </h2>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Kandy Wordpress Plugin help you use kandy in your website easily by following steps:
        </p>

        <ul class="task-list" style="box-sizing: border-box; padding-right: 0px; padding-left: 2em; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <li style="box-sizing: border-box;">
                Install Kandy plugin and active it
            </li>
            <li style="box-sizing: border-box;">
                Goto Kandy &gt; Settings to configure all required options.
            </li>
            <li style="box-sizing: border-box;">
                Go Kandy &gt; User Assignment to assign kandy users to your users. If you need refesh kandy users list please click sync.
            </li>
            <li style="box-sizing: border-box;">
                Go Kandy &gt; Customization to edit some script and style for your kandy components.
            </li>
            <li style="box-sizing: border-box;">
                Go Pages &gt; Add New to create a new page with kandy components by kandy shortcode.
            </li>
        </ul>

        <h4 style="box-sizing: border-box; margin-top: 1em; margin-bottom: 16px; line-height: 1.4; font-size: 1.25em; position: relative; font-weight: bold; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif;">
            Kandy components and shortcode syntax:
        </h4>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Kandy Video Button</strong>: make a video call button component(video call)
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
        [kandyVideoButton
            class = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myButtonStype<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            id = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>my-video-button<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            incomingLabel = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>Incoming Call...<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            incomingButtonText = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>Answer<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            callOutLabel = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>User to call<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            callOutButtonText = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>Call<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            callingLabel = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>Calling...<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            callingButtonText = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>End Call<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            onCallLabel = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>You are connected!<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            onCallButtonText = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>End Call<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Kandy Video</strong>: make a video component (video call)
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
        [kandyVideo
        title = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>You<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
        id = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myVideo<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
        style = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>width: 300px; height: 225px;background-color: darkslategray;<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>

        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Kandy Voice Button</strong>: make a voice call button component (voice call)
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
        [kandyVoiceButton
            class = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myButtonStype<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            id = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>my-video-button<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            incomingLabel = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>Incoming Call...<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            incomingButtonText = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>Answer<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            callOutLabel = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>User to call<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            callOutButtonText = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>Call<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            callingLabel = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>Calling...<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            callingButtonText = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>End Call<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            onCallLabel = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>You are connected!<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            onCallButtonText = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>End Call<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            type = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>PSTN<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            callto = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>0123456789<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            anonymous = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>true<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>

            <p style="padding: 0 10px;">
                <span style="font-style: italic">Note:</span><br/>
            <p style="padding: 0 10px;">If <code>type</code> is <code>PSTN</code>, <code>callto</code> is a phone number.
                If <code>type</code> is not specified, <code>callto</code> is <code>kandy_user_name@domain.com</code>.</p>
            <p style="padding: 0 10px 10px 10px;">If <code>anonymous</code> is <code>true</code>, users don't need to login to call.
                If <code>anonymous</code> is <code>false</code> (default), <code>callto</code> could be removed as the callee will be entered through GUI.</p>
            </p>

        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Kandy Status</strong>: make a kandy user status component (available, unavailable, awway, busy....). Kandy Status usually use with kandy address book component.
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
        [kandyStatus
            class = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myStatusStyle<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            id = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myStatus<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            title = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>My Status<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Kandy Adress Book</strong>: make an address book component which list all friend in your contact.
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
    [kandyAddressBook
            class = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myAddressBookStyle<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            id = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myContact<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            title = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>My Contact<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            userLabel = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>User<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            searchLabel = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>Search<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            searchResultLabel = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>Directory Search Results<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Kandy Chat</strong>: make a kandy chat component which help you send instant message to your friend in contact.
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
    [kandyChat
            class = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myChatStyle<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            id = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>my-chat<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            contactLabel = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>Contacts<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Kandy LiveChat</strong>: Make a small widget to help you implement live chat, give your customers ability to chat with customer service agent.
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
    [kandyLiveChat
            class = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>liveChat<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            id = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>liveChat<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Kandy Co-browsing</strong>: Make a co-browsing component which help you share your browser screen with your friends.
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
    [kandyCoBrowsing
            class = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>coBrowsing<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            id = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>coBrowsing<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Kandy SMS</strong>: Make a SMS component which help you send SMS to someone's phone number.
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
    [kandySms
            class = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>kandySms<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            id = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>kandySms<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>
        </div>

        <h3 style="box-sizing: border-box; margin-top: 1em; margin-bottom: 16px; line-height: 1.43; font-size: 1.5em; position: relative; font-weight: bold; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif;">
            Quick Examples:
        </h3>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Kandy Voice Call</strong>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
    [kandyVoiceButton class= <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myButtonStyle<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> id =<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>my-voice-button<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <span>Or</span>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
    [kandyVoiceButton class= <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myButtonStyle<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> id =<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>my-voice-button<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> callto=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>kandy_user_name@domain.com<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> anonymous=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>true<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Kandy Voice PSTN Call</strong>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
    [kandyVoiceButton class= <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myButtonStyle<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> type= <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>PSTN<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> id =<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>my-voice-button<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Kandy Voice PSTN Call With Number</strong>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
    [kandyVoiceButton class= <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myButtonStyle<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> type= <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>PSTN<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> callto=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>0123456xxxx<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> id =<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>my-voice-button<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <span>Or</span>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
    [kandyVoiceButton class= <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myButtonStyle<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> type= <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>PSTN<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> callto=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>0123456xxxx<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> anonymous=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>true<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> id =<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>my-voice-button<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Kandy Video Call</strong>: use a video call button and two video(<strong style="box-sizing: border-box;">myVideo</strong>&nbsp;and&nbsp;<strong style="box-sizing: border-box;">theirVideo</strong>&nbsp;id is required).
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
        [kandyVideoButton class=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myButtonStype<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> callto=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>kandy_user_name@domain.com<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> anonymous=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>true<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        [kandyVideo title=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>You<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> id=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myVideo<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> style = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>width: 300px;height: 225px;<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        [kandyVideo title=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>Them<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> id=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>theirVideo<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> style = <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>width:300px;height: 225px;<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <em style="box-sizing: border-box;">Note</em>: Two&nbsp;<strong style="box-sizing: border-box;">kandyVideo</strong>&nbsp;object should be inline because some editor will insert a break line automatically.
        </p>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Screen Sharing</strong>:<br/>
        <ul style="padding-left: 30px;">
            <li style="list-style: disc; font-size: 15px; line-height: 28px;">Screen sharing can only be used over a secure connection (https).</li>
            <li style="list-style: disc; font-size: 15px; line-height: 28px;">Before testing it, please install this extension on chrome browser:<br/>
                <a href="https://chrome.google.com/webstore/detail/kandyio-screen-sharing/daohbhpgnnlgkipndobecbmahalalhcp">https://chrome.google.com/webstore/detail/kandyio-screen-sharing/daohbhpgnnlgkipndobecbmahalalhcp</a></li>
            <li style="list-style: disc; font-size: 15px; line-height: 28px;">This extension only works on localhost domain.</li>
            <li style="list-style: disc; font-size: 15px; line-height: 28px;">Finally, you test it on video call feature.</li>
        </ul>
        </p>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Kandy Presence</strong>: use a kandyStatus and kandy addressBook compobent
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
        [kandyStatus class=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myStatusStyle<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> id=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myStatus<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        [kandyAddressBook class=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myAddressBookStyle<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> id=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myContact<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Kandy Chat: </strong>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
        <pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px 16px 0; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
        [kandyChat class=<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>myChatStyle<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> id =<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>my-chat<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>]
        </pre>
        </div>

        <h4 style="box-sizing: border-box; margin-top: 1em; margin-bottom: 16px; line-height: 1.4; font-size: 1.25em; position: relative; font-weight: bold; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif;">
            Kandy Administration:
        </h4>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Settings: </strong>
        </p>

        <ul class="task-list" style="box-sizing: border-box; padding-right: 0px; padding-left: 2em; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <li style="box-sizing: border-box;">
                <strong style="box-sizing: border-box;">API Key:</strong>&nbsp;Kandy API key which found in your kandy account.
            </li>
            <li style="box-sizing: border-box;">
                <strong style="box-sizing: border-box;">Domain Secret Key:</strong>&nbsp;Domain Kandy API key which found in your kandy account.
            </li>
            <li style="box-sizing: border-box;">
                <strong style="box-sizing: border-box;">Domain Name:</strong>&nbsp;Domain name of you kandy account.
            </li>
            <li style="box-sizing: border-box;">
                <strong style="box-sizing: border-box;">Javascript Library Url</strong>: Link to kandy javascript library.
            </li>
        </ul>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">User assignment:</strong>&nbsp;help you synchronize kandy users from kandy server to your users system. Select your user and click edit button to assign(unassign) kandy user.
        </p>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Live chat configuration:</strong>&nbsp; Live chat feature needs some configurations before using:
        </p>

        <ul class="task-list" style="box-sizing: border-box; padding-right: 0px; padding-left: 2em; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <li style="box-sizing: border-box;">
                <strong style="box-sizing: border-box;">Configure "Excluded Kandy Users" in Kandy Settings page:</strong>&nbsp; these Kandy users will not be assigned to your users. They are reserved to live chat feature or some features in future. Each user separated by comma or whitespace.
            </li>
            <li style="box-sizing: border-box;">
                <strong style="box-sizing: border-box;">Add Excluded Kandy Users to live chat feature:</strong>&nbsp;From Kandy component menu, chose Live chat users management, this page display your excluded users in previous step. You can assign a user to live chat feature by chosing from select box and click Save.
            </li>
            <li style="box-sizing: border-box;">
                <strong style="box-sizing: border-box;">Add Live Chat Agent:</strong>&nbsp;From Kandy component menu, chose Live chat agents management . You can add a user from your user system to assign him as a Live Chat Agent.
            </li>
        </ul>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Style customization</strong>: help you edit kandy shortcode(video, voice, chat...) style. Select appropriate file(.css) then click edit them.
        </p>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Script customization</strong>&nbsp;help you edit kandy shortcode(video, voice, chat...) script(add more behaviour). Select appropriate file(.js) then click edit them.
        </p>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;"><em style="box-sizing: border-box;">All support script callback:</em></strong>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
        window.login_success_callback = <span class="pl-st" style="box-sizing: border-box; color: rgb(167, 29, 93);">function</span> <span class="pl-en" style="box-sizing: border-box; color: rgb(121, 93, 163);">()</span> {
           //<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">do</span> something when you login successfully
        }

        window.login_failed_callback = <span class="pl-st" style="box-sizing: border-box; color: rgb(167, 29, 93);">function</span> <span class="pl-en" style="box-sizing: border-box; color: rgb(121, 93, 163);">()</span> {
            //<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">do</span> something when you login fail
        }

        window.call_incoming_callback = <span class="pl-st" style="box-sizing: border-box; color: rgb(167, 29, 93);">function</span> <span class="pl-en" style="box-sizing: border-box; color: rgb(121, 93, 163);">(call,</span> isAnonymous) {
            //<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">do</span> something when your are calling
        }

        window.on_call_callback = <span class="pl-st" style="box-sizing: border-box; color: rgb(167, 29, 93);">function</span> <span class="pl-en" style="box-sizing: border-box; color: rgb(121, 93, 163);">(call)</span> {
            //<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">do</span> something when you are oncall
        }

        window.call_answered_callback = <span class="pl-st" style="box-sizing: border-box; color: rgb(167, 29, 93);">function</span> <span class="pl-en" style="box-sizing: border-box; color: rgb(121, 93, 163);">(call,</span> isAnonymous) {
            //<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">do</span> something when someone answer your call
        }

        window.call_ended_callback = <span class="pl-st" style="box-sizing: border-box; color: rgb(167, 29, 93);">function</span> <span class="pl-en" style="box-sizing: border-box; color: rgb(121, 93, 163);">()</span> {
           //<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">do</span> something when someone end  your call
        }

        window.answer_voice_call_callback = <span class="pl-st" style="box-sizing: border-box; color: rgb(167, 29, 93);">function</span> <span class="pl-en" style="box-sizing: border-box; color: rgb(121, 93, 163);">(stage)</span> {
            //<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">do</span> something when you answer voice call
        }

        window.answer_video_call_callback = <span class="pl-st" style="box-sizing: border-box; color: rgb(167, 29, 93);">function</span> <span class="pl-en" style="box-sizing: border-box; color: rgb(121, 93, 163);">(stage)</span> {
            //<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">do</span> something when you answer video call
        }

        window.make_call_callback = <span class="pl-st" style="box-sizing: border-box; color: rgb(167, 29, 93);">function</span> <span class="pl-en" style="box-sizing: border-box; color: rgb(121, 93, 163);">(stage)</span> {
           //<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">do</span> something when you make call
        }

        window.end_call_callback = <span class="pl-st" style="box-sizing: border-box; color: rgb(167, 29, 93);">function</span> <span class="pl-en" style="box-sizing: border-box; color: rgb(121, 93, 163);">(stage)</span> {
           //<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">do</span> something when you click end call button
        }

        window.remote_video_initialized_callback(videoTag){
           //<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">do</span> something with your remote video
        }

        window.local_video_initialized_callback = function(videoTag){
            //<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">do</span> some thing with your <span class="pl-s" style="box-sizing: border-box; color: rgb(167, 29, 93);">local</span> video
        }

        window.presence_notification_callback = <span class="pl-en" style="box-sizing: border-box; color: rgb(121, 93, 163);">function</span>() {
            //<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">do</span> something with status notification
        }</pre>
        </div>

        <h3 style="box-sizing: border-box; margin-top: 1em; margin-bottom: 16px; line-height: 1.43; font-size: 1.5em; position: relative; font-weight: bold; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif;">
            Kandy API
        </h3>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            You can use kandy plugin anywhere in your code by following code:
        </p>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">Load Kandy Plugin</strong>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
require_once(KANDY_PLUGIN_DIR <span class="pl-s3" style="box-sizing: border-box; color: rgb(0, 134, 179);">.</span> <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>/api/kandy-api-class.php<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>)<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">;</span></pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            After load kandy plugin successfully you can use all support api:
        </p>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">1. Get kandy user data for assignment table</strong>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
<span class="pl-en" style="box-sizing: border-box; color: rgb(121, 93, 163);">KandyApi::getUserData</span>();</pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Return: kandy user object&nbsp;<strong style="box-sizing: border-box;">array</strong>
        </p>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">2. Get kandy domain access token</strong>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
<span class="pl-en" style="box-sizing: border-box; color: rgb(121, 93, 163);">KandyApi::getDomainAccessToken</span>();</pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Return:&nbsp;<strong style="box-sizing: border-box;">array</strong>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
<span class="pl-vo" style="box-sizing: border-box;">$result</span> = array(<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>success<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> =<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">&gt;</span> <span class="pl-s3" style="box-sizing: border-box; color: rgb(0, 134, 179);">true</span>,
                <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>data<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> =<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">&gt;</span> <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>data<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>,
                <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>message<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> =<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">&gt;</span> <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&#39;</span><span class="pl-pds" style="box-sizing: border-box;">&#39;</span></span>)
OR
<span class="pl-vo" style="box-sizing: border-box;">$result</span> = array(<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>success<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> =<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">&gt;</span> <span class="pl-s3" style="box-sizing: border-box; color: rgb(0, 134, 179);">false</span>,
                <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>data<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> =<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">&gt;</span> <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>data<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>,
                <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>message<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> =<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">&gt;</span> <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>message<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>)</pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">3. Get the kandy domain</strong>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
<span class="pl-en" style="box-sizing: border-box; color: rgb(121, 93, 163);">KandyApi::getDomain</span>();</pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Get kandy domain from kandy settings or remote server
        </p>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Return: <strong style="box-sizing: border-box;">array </strong>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
<span class="pl-vo" style="box-sizing: border-box;">$result</span> = array(<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>success<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> =<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">&gt;</span> <span class="pl-s3" style="box-sizing: border-box; color: rgb(0, 134, 179);">true</span>,
                <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>data<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> =<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">&gt;</span> <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>data<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>,
                <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>message<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> =<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">&gt;</span> <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&#39;</span><span class="pl-pds" style="box-sizing: border-box;">&#39;</span></span>)<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">;</span>
OR
<span class="pl-vo" style="box-sizing: border-box;">$result</span> = array(<span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>success<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> =<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">&gt;</span> <span class="pl-s3" style="box-sizing: border-box; color: rgb(0, 134, 179);">false</span>,
                <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>data<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> =<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">&gt;</span> <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>data<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>,
                <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>message<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span> =<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">&gt;</span> <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>message<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>)<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">;</span></pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">4. List Kandy User from database/remote</strong>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
KandyApi::listUsers(<span class="pl-vo" style="box-sizing: border-box;">$type</span> = KANDY_USER_ALL, <span class="pl-vo" style="box-sizing: border-box;">$remote</span> = <span class="pl-s3" style="box-sizing: border-box; color: rgb(0, 134, 179);">false</span>)<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">;</span></pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Parameters:
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
<span class="pl-vo" style="box-sizing: border-box;">$type</span>(int) <span class="pl-s3" style="box-sizing: border-box; color: rgb(0, 134, 179);">:</span>
    KANDY_USER_ALL: all kandy users from database/remote
    KANDY_USER_ASSIGNED: all assigned kandy users from database/remote
    KANDY_USER_UNASSIGNED: all unassigned kandy users from database/remote
<span class="pl-vo" style="box-sizing: border-box;">$remote</span>(boolean) <span class="pl-s3" style="box-sizing: border-box; color: rgb(0, 134, 179);">:</span>
    If <span class="pl-vo" style="box-sizing: border-box;">$remote</span> = <span class="pl-s3" style="box-sizing: border-box; color: rgb(0, 134, 179);">true</span>, get kandy users from remote server(kandy server) instead of from database(<span class="pl-s" style="box-sizing: border-box; color: rgb(167, 29, 93);">local</span>). Default is <span class="pl-s3" style="box-sizing: border-box; color: rgb(0, 134, 179);">false</span>.</pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Return: Kandy user object&nbsp;<strong style="box-sizing: border-box;">array</strong>
        </p>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">5. Get assigned kandy user by current user id(main_user_id)</strong>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
KandyApi::getAssignUser(<span class="pl-vo" style="box-sizing: border-box;">$mainUserId</span>)<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">;</span></pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Parameters:
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
<span class="pl-vo" style="box-sizing: border-box;">$mainUserId</span>(int): normal user id(1, 2, 3....)</pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Return kandy user object or null
        </p>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">6 Get kandy user by kandy user id(kandyUserId)</strong>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
KandyApi::getUserByUserId(<span class="pl-vo" style="box-sizing: border-box;">$kandyUserId</span>)<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">;</span></pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Parameters:
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
<span class="pl-vo" style="box-sizing: border-box;">$kandyUserId</span>(int): kandy user id without domain(user1, user2....)</pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Return kandy user object or null
        </p>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">7. Assign a normal user to kandy user</strong>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
KandyApi::assignUser(<span class="pl-vo" style="box-sizing: border-box;">$kandyUserId</span>, <span class="pl-vo" style="box-sizing: border-box;">$mainUserId</span>)<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">;</span></pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Parameters:
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
<span class="pl-vo" style="box-sizing: border-box;">$kandyUserId</span>(string) <span class="pl-s3" style="box-sizing: border-box; color: rgb(0, 134, 179);">:</span> kandy user id without domain(user1, user2....)
<span class="pl-vo" style="box-sizing: border-box;">$mainuserId</span>(int): normal user id(1, 2, 3....)</pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Return: true/false
        </p>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">8. Unassign a kandy user</strong>
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
KandyApi::unassignUser(<span class="pl-vo" style="box-sizing: border-box;">$mainUserId</span>)<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">;</span></pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Parameters:
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
<span class="pl-vo" style="box-sizing: border-box;">$mainuserId</span>(int): normal user id(1, 2, 3....)</pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Return: true/false
        </p>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            <strong style="box-sizing: border-box;">9. Kandy User synchronization</strong>
        </p>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Synchronize kandy user from remote server to local
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
<span class="pl-en" style="box-sizing: border-box; color: rgb(121, 93, 163);">KandyApi::syncUsers</span>();</pre>
        </div>

        <p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
            Return: array
        </p>

        <div class="highlight highlight-sh" style="box-sizing: border-box; margin-bottom: 16px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px;">
	<pre style="box-sizing: border-box; overflow: auto; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace; font-size: 13px; margin-top: 0px; margin-bottom: 0px; font-stretch: normal; line-height: 1.45; padding: 16px; border-radius: 3px; word-wrap: normal; word-break: normal; background-color: rgb(247, 247, 247);">
<span class="pl-vo" style="box-sizing: border-box;">$result</span> = array(
                <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&#39;</span>success<span class="pl-pds" style="box-sizing: border-box;">&#39;</span></span> =<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">&gt;</span> <span class="pl-s3" style="box-sizing: border-box; color: rgb(0, 134, 179);">true</span>,
                <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&#39;</span>message<span class="pl-pds" style="box-sizing: border-box;">&#39;</span></span> =<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">&gt;</span> <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>Sync successfully<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            )<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">;</span>
OR
<span class="pl-vo" style="box-sizing: border-box;">$result</span> = array(
                <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&#39;</span>success<span class="pl-pds" style="box-sizing: border-box;">&#39;</span></span> =<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">&gt;</span> <span class="pl-s3" style="box-sizing: border-box; color: rgb(0, 134, 179);">false</span>,
                <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&#39;</span>message<span class="pl-pds" style="box-sizing: border-box;">&#39;</span></span> =<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">&gt;</span> <span class="pl-s1" style="box-sizing: border-box; color: rgb(223, 80, 0);"><span class="pl-pds" style="box-sizing: border-box;">&quot;</span>Error Data<span class="pl-pds" style="box-sizing: border-box;">&quot;</span></span>
            )<span class="pl-k" style="box-sizing: border-box; color: rgb(167, 29, 93);">;</span>
</pre>
        </div>

        <h3 style="box-sizing: border-box; margin-top: 1em; margin-bottom: 16px; line-height: 1.43; font-size: 1.5em; position: relative; font-weight: bold; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif;">
            Troubleshooting
        </h3>

        <ul class="task-list" style="box-sizing: border-box; padding-right: 0px; padding-left: 2em; margin-top: 0px; font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif; font-size: 16px; line-height: 28px; margin-bottom: 0px !important;">
            <li style="box-sizing: border-box;">
                <strong style="box-sizing: border-box;">Kandy ShortCode not working:</strong>&nbsp;check your kandy api key, domain secret key for your application at&nbsp;<strong style="box-sizing: border-box;">Kandy &gt; Settings</strong>
            </li>
            <li style="box-sizing: border-box;">
                <strong style="box-sizing: border-box;">Internationalizing</strong>: get the /languages/kandy.pot file and make your /languages/*.mo file to locale your language.
            </li>
        </ul>

        <?php

        $this->render_page_end();
    }
}
