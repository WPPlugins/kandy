<p>
    <strong>Kandy Module</strong> is a full-service cloud platform that enables real-time communications for business applications.
</p>

<p>
    Home page: <a href="">http://www.kandy.io/</a>
</p>

<h4>
    ================================================================================
</h4>

<h4>
    <br />
    <strong>HOW TO INSTALL :</strong>
</h4>

<p>
    &nbsp; &nbsp; + Install and enable&nbsp;<strong>shortcode </strong>module https://www.drupal.org/project/shortcode<br />
    &nbsp; &nbsp; + Enable shortcode filter at <em><strong>Configuration &gt; Content Authoring &gt; Text Formats</strong></em><br />
    &nbsp; &nbsp; + Uncheck auto &quot;<em><strong>Convert line breaks into HTML</strong></em>&quot; . A good point when you&nbsp;&nbsp;add new text format <em style="line-height: 20px;"><strong>Configuration &gt; Content Authoring &gt; Text Formats &gt; Add text format </strong>(kandy)</em><br />
    &nbsp; &nbsp; + Configure kandy options at <strong><em>Configuration &gt; Content Authoring &gt; kandy</em></strong>
</p>

<h4>
    ================================================================================
</h4>

<h4>
    <br />
    <strong>HOW TO USE :</strong>
</h4>

<p>
    &nbsp; &nbsp; - Create new content (basic page, article). A good point if you&nbsp;add a new content types <em><strong>Structure &gt; Content types &gt; add new content type </strong>(kandy)</em>&nbsp;with kandy shortcode syntax:
</p>

<p>
    &nbsp; &nbsp; <strong>+ Kandy Video Call Button</strong><br />
    &nbsp; &nbsp; &nbsp; &nbsp; <span style="color:#696969;">[kandyVideoButton<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; class = &quot;myButtonStyle&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; id = &quot;my-video-button&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; incomingLabel = &#39;Incoming Call...&#39;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; incomingButtonText = &#39;Answer&#39;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; callOutLabel = &#39;User to call&#39;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; callOutButtonText = &#39;Call&#39;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; callingLabel = &#39;Calling...&#39;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; callingButtonText = &#39;End Call&#39;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; onCallLabel = &#39;You are connected!&#39;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; onCallButtonText = &#39;End Call&#39;]<br />
	&nbsp; &nbsp; &nbsp; &nbsp; [/kandyVideoButton]</span>
</p>

<p>
    &nbsp; &nbsp; <strong>+ Kandy Voice Call Button</strong><br />
    &nbsp; &nbsp; &nbsp; &nbsp; <span style="color:#696969;">[kandyVoiceButton<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; class = &quot;myButtonStyle&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; id = &quot;my-voice-button&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; incomingLabel = &#39;Incoming Call...&#39;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; incomingButtonText = &#39;Answer&#39;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; callOutLabel = &#39;User to call&#39;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; callOutButtonText = &#39;Call&#39;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; callingLabel = &#39;Calling...&#39;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; callingButtonText = &#39;End Call&#39;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; onCallLabel = &#39;You are connected!&#39;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; onCallButtonText = &#39;End Call&#39;]<br />
	&nbsp; &nbsp; &nbsp; &nbsp; [/kandyVoiceButton]</span>
</p>

<p>
    &nbsp; &nbsp; + <strong>Kandy Video</strong><br />
    &nbsp; &nbsp; &nbsp; &nbsp;<span style="color:#696969;"> [kandyVideo<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; title = &quot;You&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; id = &quot;myVideo&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; style = &quot;width: 300px; height: 225px;background-color: darkslategray;&quot;]<br />
	&nbsp; &nbsp; &nbsp; &nbsp; [/kandyVideo]</span>
</p>

<p>
    &nbsp; &nbsp; + <strong>Kandy Status</strong><br />
    &nbsp; &nbsp; &nbsp; &nbsp; <span style="color:#696969;">[kandyStatus<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; class = &quot;myStatusStyle&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; id = &quot;myStatus&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; title = &quot;My Status&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; style = &quot;...&quot;]<br />
	&nbsp; &nbsp; &nbsp; &nbsp; [/kandyStatus]</span>
</p>

<p>
    &nbsp; &nbsp; + <strong>Kandy Address Book</strong><br />
    &nbsp; &nbsp; &nbsp; &nbsp; <span style="color:#696969;">[kandyAddressBook<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; class = &quot;myAddressBookStyle&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; id = &quot;myContact&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; title = &quot;My Contact&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; userLabel = &quot;User&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; searchLabel = &quot;Search&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; searchResultLabel = &quot;Directory Search Results&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; style = &quot;...&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ]<br />
	&nbsp; &nbsp; &nbsp; &nbsp; [/kandyAddressBook]</span>
</p>

<p>
    &nbsp; &nbsp; + <strong>Kandy Chat</strong><br />
    &nbsp; &nbsp; &nbsp; &nbsp;<span style="color:#696969;"> [kandyChat<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; class = &quot;myChatStyle&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; id = &quot;my-chat&quot;<br />
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; contactLabel = &quot;Contacts&quot;]<br />
	&nbsp; &nbsp; &nbsp; &nbsp; [/kandyChat]</span>
</p>

<p>
    &nbsp;
</p>

<h4>
    &nbsp; &nbsp; - <strong>Example</strong>:
</h4>

<p>
    <strong>&nbsp; &nbsp; + Kandy Voice Call</strong><br />
    &nbsp; &nbsp; &nbsp; &nbsp;<span style="color:#696969;"> [kandyVoiceButton class= "myButtonStyle" id ="my-voice-button"][/kandyVoiceButton]</span>
</p>

<p>
    &nbsp;
</p>

<p>
    <strong>&nbsp; &nbsp; + Kandy Video Call</strong><br />
    &nbsp; &nbsp; &nbsp; &nbsp;<span style="color:#696969;">[kandyVideoButton class="myButtonStyle"][/kandyVideoButton]<br />
	&nbsp; &nbsp; &nbsp; &nbsp;[kandyVideo title="You" id="myVideo" style = "width: 300px; height: 225px;background-color: darkslategray;"] [/kandyVideo]<br />
	&nbsp; &nbsp; &nbsp; &nbsp;[kandyVideo title="Them" &nbsp;id="theirVideo" style = "width: 300px; height: 225px;background-color: darkslategray;"][/kandyVideo]</span>
</p>

<p>
    &nbsp;
</p>

<p>
    <strong>&nbsp; &nbsp; + Kandy Presence</strong><br />
    &nbsp; &nbsp; &nbsp; &nbsp; <span style="color:#696969;">[kandyStatus class="myStatusStyle" id="myStatus"][/kandyStatus]<br />
	&nbsp; &nbsp; &nbsp; &nbsp; [kandyAddressBook class="myAddressBookStyle" id="myContact"][/kandyAddressBook]</span>
</p>

<p>
    &nbsp;
</p>

<p>
    <strong>&nbsp; &nbsp; + Kandy Chat</strong><br />
    <span style="color:#808080;">&nbsp; &nbsp; &nbsp; &nbsp; </span><span style="color:#696969;">[kandyChat class="myChatStyle" id ="my-chat"][/kandyChat]</span>
</p>

<p>
    &nbsp;
</p>

<p>
    Note:
</p>

<ul>
    <li>
        Select proper text format which enable shortcode filter to show all shortcodes correctly.
    </li>
    <li>
        <font face="Lucida Grande, Lucida Sans Unicode, sans-serif"><span style="font-size: 12px; line-height: 20px;">Check provide menu link to make your content as a menu.</span></font>
    </li>
    <li>
        <font face="Lucida Grande, Lucida Sans Unicode, sans-serif"><span style="font-size: 12px; line-height: 20px;">Uncheck promoted to front end</span></font>
    </li>
    <li>
        <font face="Lucida Grande, Lucida Sans Unicode, sans-serif"><span style="font-size: 12px; line-height: 20px;">Uncheck&nbsp;</span></font><span style="font-family: 'Lucida Grande', 'Lucida Sans Unicode', sans-serif; font-size: 12px; line-height: 20px;">Display author and date information.</span>
    </li>
    <li>
        <span style="font-family: 'Lucida Grande', 'Lucida Sans Unicode', sans-serif; font-size: 12px; line-height: 20px;">Close comment settings</span>
    </li>
    <li>
        <span style="font-family: 'Lucida Grande', 'Lucida Sans Unicode', sans-serif; font-size: 12px; line-height: 20px;">Shortcode only work with inline format</span>
    </li>
    <li><strong>Screen Sharing</strong> feature:</li>
    <ul>
        <li>Screen sharing can only be used over a secure connection (https)</li>
        <li>Before testing it, please install this extension on chrome browser:<br/>
            <a href="https://chrome.google.com/webstore/detail/kandyio-screen-sharing/daohbhpgnnlgkipndobecbmahalalhcp" target="_blank">https://chrome.google.com/webstore/detail/kandyio-screen-sharing/daohbhpgnnlgkipndobecbmahalalhcp</a></li>
        <li>This extension only works on localhost domain.</li>
        <li>Finally, you test it on video call feature.</li>
    </ul>
</ul>

<p>
    ==========================================================================================
</p>

<h4>
    <strong>KANDY ADMINISTRATION</strong>
</h4>

<p>
    <strong>+ User assignment: &nbsp;</strong>
</p>

<ol style="margin-left: 40px;">
    <li>
        Click <em><strong>KANDY USER ASSIGNMENT&nbsp;</strong></em>to sync kandy user for your application
    </li>
    <li>
        Select user and click <em><strong>edit</strong></em> button to assign kandy user
    </li>
</ol>

<div>
    &nbsp;
</div>

<div>
    <strong>+ Style customization</strong>
</div>

<ol style="margin-left: 40px;">
    <li>
        Click <em><strong>KANDY STYLE CUSTOMIZATION</strong></em> to edit kandy shortcode(video, voice, chat...) style
    </li>
    <li>
        Select appropriate file then click edit
    </li>
</ol>

<div>
    &nbsp;
</div>

<p>
    <strong>+ Script customization</strong>
</p>

<ol style="line-height: 20px; margin-left: 40px;">
    <li>
        Click <em><strong>KANDY SCRIPT CUSTOMIZATION</strong></em> to edit kandy shortcode(video, voice, chat...) script
    </li>
    <li>
        Select&nbsp;appropriate file then click edit
    </li>
    <li>
        All support callback:&nbsp;
    </li>
</ol>

<div>
    <p style="margin-left: 80px;">
		<span style="color:#696969;">window.login_success_callback = function () {<br />
		&nbsp; &nbsp;<span style="line-height: 20px;">//do something when you login successfully</span><br />
		}<br />
		window.login_failed_callback = function () {<br />
		&nbsp; &nbsp; <span style="line-height: 20px;">//do something when you login fail</span><br />
		}<br />
		window.call_incoming_callback = function (call, isAnonymous) {<br />
		&nbsp; &nbsp; <span style="line-height: 20px;">//do something when your are&nbsp;calling</span><br />
		}<br />
		window.on_call_callback = function (call) {<br />
		&nbsp; &nbsp; <span style="line-height: 20px;">//do something when you are oncall</span><br />
		}<br />
		window.call_answered_callback = function (call, isAnonymous) {<br />
		&nbsp; &nbsp; <span style="line-height: 20px;">//do something when someone&nbsp;answer your call</span><br />
		}</span>
    </p>

    <p style="margin-left: 80px;">
		<span style="color:#696969;">window.call_ended_callback = function () {<br />
		&nbsp; &nbsp;<span style="line-height: 20px;">//do something when someone&nbsp;end &nbsp;your call</span><br />
		}</span>
    </p>

    <p style="margin-left: 80px;">
		<span style="color:#696969;"><span style="line-height: 20px;">window.answer_voice_call_callback = function (stage) {</span><br style="line-height: 20px;" />
		<br />
		<span style="line-height: 20px;">&nbsp; &nbsp;&nbsp;</span><span style="line-height: 20px;">//do something when you answer voice call</span><br style="line-height: 20px;" />
		<br />
		<span style="line-height: 20px;">}</span></span>
    </p>

    <p style="margin-left: 80px;">
		<span style="color:#696969;">window.answer_video_call_callback = function (stage) {<br />
		&nbsp;&nbsp; &nbsp;//do something when you answer video call<br />
		}<br />
		window.make_call_callback = function (stage) {<br />
		&nbsp; &nbsp;<span style="line-height: 20px;">//do something when you make call</span><br />
		}</span>
    </p>

    <p style="margin-left: 80px;">
        <br />
		<span style="color:#696969;">window.end_call_callback = function (stage) {<br />
		&nbsp; &nbsp;//do something when you click end call button<br />
		}</span>
    </p>

    <p style="margin-left: 80px;">
        <span style="color:#696969;">window.remote_video_initialized_callback(videoTag){</span>
    </p>

    <p style="margin-left: 80px;">
        <span style="color:#696969;">&nbsp; &nbsp;//do something with your remote video</span>
    </p>

    <p style="margin-left: 80px;">
        <span style="color:#696969;">}</span>
    </p>

    <p style="margin-left: 80px;">
		<span style="color:#696969;">window.local_video_initialized_callback = function(videoTag){<br />
		&nbsp; &nbsp; //do some thing with your local video<br />
		}</span>
    </p>

    <p style="margin-left: 80px;">
		<span style="color:#696969;">window.presence_notification_callback = function() {<br />
		&nbsp; &nbsp; //do something with status notification</span>
    </p>

    <p style="margin-left: 80px;">
        <span style="color:#696969;">}<em>&nbsp;</em></span>
    </p>
</div>
