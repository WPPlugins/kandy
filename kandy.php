<?php
/**
 * Plugin Name: Kandy
 * Plugin URI: https://github.com/Kandy-IO/kandy-wordpress
 * Description: Kandy Plugin is a full-service cloud platform that enables real-time communications for business applications.
 * Version: 2.5.0
 * Text Domain: kandy
 * Author: Kandy-IO
 * Author URI: https://github.com/Kandy-IO
 * License: GPL2
 */
$pluginURL = is_ssl() ? str_replace("http://", "https://", WP_PLUGIN_URL) : WP_PLUGIN_URL;
define("KANDY_PLUGIN_VERSION", "2.5.0");
define("KANDY_PLUGIN_PREFIX", "kandy");
define("KANDY_PLUGIN_URL", $pluginURL . "/" . plugin_basename(dirname(__FILE__)));
define('KANDY_PLUGIN_DIR', dirname(__FILE__));
define('KANDY_API_BASE_URL', 'https://api.kandy.io/v1.2/');
define('KANDY_JS_URL', 'https://kandy-portal.s3.amazonaws.com/public/javascript/kandy/2.5.0/kandy.js');

define('KANDY_JQUERY', "https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js");
define('KANDY_JQUERY_RELOAD', false);
define('KANDY_SSL_VERIFY', false);
define('KANDY_USER_TABLE', 'kandy_users');
define('KANDY_API_KEY', '');
define('KANDY_DOMAIN_SECRET_KEY', '');
define('KANDY_DOMAIN_NAME', '');

define('KANDY_VIDEO_WRAPPER_CLASS_DEFAULT', 'kandyVideoWrapper');
define('KANDY_VIDEO_STYLE_DEFAULT', 'width: 340px; height: 250px;background-color: darkslategray;');
define('KANDY_VIDEO_MY_TITLE_DEFAULT', 'me');
define('KANDY_VIDEO_THEIR_TITLE_DEFAULT', 'their');

define('KANDY_UN_ASSIGN_USER', 'kandy-un-assign-user');

define('KANDY_PSTN_TYPE', 'PSTN');
define('KANDY_COBROWSING_JS', 'https://kandy-portal.s3.amazonaws.com/public/javascript/cobrowse/1.0.1/kandy.cobrowse.min.js');

define('KANDY_USER_TYPE_AGENT', 1);
define('KANDY_USER_TYPE_NORMAL', 0);
define('KANDY_USER_TYPE_END_USER', 2);
define('KANDY_USER_STATUS_ONLINE', 1);
define('KANDY_USER_STATUS_OFFLINE', 0);

require_once dirname(__FILE__) . '/kandy-admin-class.php';
require_once dirname(__FILE__) . '/kandy-shortcode.php';
require_once dirname(__FILE__) . '/api/kandy-api-class.php';
if (is_admin()) {
    $kandy_admin = new KandyAdmin();

}
KandyShortcode::init();

add_action('init', function(){
    if(!session_id()){
        session_start();
    }
});

add_action('wp_login', 'onUserLogin',10,2);

add_action('clear_auth_cookie', 'onUserLogout');

function onUserLogout() {
    $user = wp_get_current_user();
    $kandyUser = KandyApi::getAssignUser($user->ID);
    if($kandyUser->type == KANDY_USER_TYPE_AGENT) {
        KandyApi::logKandyUserStatus($kandyUser->user_id,KANDY_USER_TYPE_AGENT, KANDY_USER_STATUS_OFFLINE);
    };

}

function onUserLogin($userLogin, $wpUser) {
    $kandyUser = KandyApi::getAssignUser($wpUser->ID);
    if($kandyUser->type == KANDY_USER_TYPE_AGENT) {
        KandyApi::logKandyUserStatus($kandyUser->user_id, KANDY_USER_TYPE_AGENT);
    }
    if (isset($_SESSION['userAccessToken'][$kandyUser->user_id])) {
        unset($_SESSION['userAccessToken'][$kandyUser->user_id]);
    }
}

//active plugin
register_activation_hook( __FILE__, 'kandy_install' );
//uninstall plugin
register_uninstall_hook( __FILE__, 'kandy_uninstall' );

/**
 * Kandy Install Hook.
 */
function kandy_install() {
    global $wpdb;
    $kandyDbVersion = KANDY_PLUGIN_VERSION;
    $table_name = $wpdb->prefix . 'kandy_users';
    $livechat_table = $wpdb->prefix . 'kandy_live_chat';
    $rate_table = $wpdb->prefix . 'kandy_live_chat_rate';
    $user_login_table = $wpdb->prefix . 'kandy_user_login';
    $installed_ver = get_option( "kandy_db_version" );
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    if ( $installed_ver != $kandyDbVersion ) {
        $sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
                  id int(10) unsigned NOT NULL AUTO_INCREMENT,
                  user_id varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  first_name varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  last_name varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  password varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  email varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  domain_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  api_key varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  api_secret varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  main_user_id varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  created_at timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
                  updated_at timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
                  type tinyint(4) DEFAULT 0,
                  presence_status varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                  PRIMARY KEY  (id)
                );";
        dbDelta($sql);
        $sql  = "CREATE TABLE IF NOT EXISTS ".$livechat_table." (
                  id int(10) unsigned NOT NULL AUTO_INCREMENT,
                  agent_user_id varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  customer_user_id varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  customer_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  customer_email varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  begin_at int(10) unsigned NOT NULL DEFAULT '0',
                  end_at int(10) unsigned NOT NULL DEFAULT '0',
                  PRIMARY KEY  (id),
                  KEY kandy_live_chat_customer_email_agent_user_id_index (customer_email,agent_user_id)
                );";
        dbDelta($sql);
        $sql  = "CREATE TABLE IF NOT EXISTS ".$rate_table." (
                  id int(10) unsigned NOT NULL AUTO_INCREMENT,
                  main_user_id varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  rated_by varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  rated_time int(11) NOT NULL DEFAULT '0',
                  point int(11) NOT NULL,
                  comment text COLLATE utf8_unicode_ci NOT NULL,
                  PRIMARY KEY  (id),
                  KEY kandy_live_chat_rate_main_user_id_index (main_user_id)
                );";
        dbDelta( $sql );
        $sql = "CREATE TABLE ". $user_login_table." (
                  id int(10) unsigned NOT NULL AUTO_INCREMENT,
                  kandy_user_id varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  type tinyint(4) NOT NULL,
                  status tinyint(4) NOT NULL,
                  browser_agent varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                  ip_address text COLLATE utf8_unicode_ci NOT NULL,
                  time int(11) DEFAULT NULL,
                  PRIMARY KEY (id),
                  KEY kandy_user_login_kandy_user_id_index (kandy_user_id)
                );";
        dbDelta($sql);
        delete_option( "kandy_js_url" );
        update_option( 'kandy_db_version', $kandyDbVersion );
    }
}

/**
 * Kandy Uninstall Hook.
 */
function kandy_uninstall(){

    //drop a custom db table
    global $wpdb;
    $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}kandy_users" );
    $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}kandy_live_chat" );
    $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}kandy_live_chat_rate" );
    $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}kandy_user_login" );

    delete_option( "kandy_db_version" );
    delete_option( "kandy_api_key" );
    delete_option( "kandy_domain_name" );
    delete_option( "kandy_domain_secret_key" );
    delete_option( "kandy_jquery_reload" );
    delete_option( "kandy_js_url" );
    delete_option( "kandy_excluded_users" );    // Remove later. Keep now for older install
    delete_option( "kandy_live_chat_users" );
}
