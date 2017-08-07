<?php
require_once(dirname(__FILE__) . "/KandyPage.php");
class KandySettingsPage extends KandyPage
{
    public function render()
    {
        if(isset($_POST["kandy_settings"])){
            $settingAttributes = $_POST["kandy_settings"];
            $oldApiKey = get_option('kandy_api_key', KANDY_API_KEY);
            $oldSecretKey = get_option('kandy_domain_secret_key', KANDY_DOMAIN_SECRET_KEY);

            foreach($settingAttributes as $key => $value){
                update_option($key, $value);
            }

            $newApiKey = get_option('kandy_api_key', KANDY_API_KEY);
            $newSecretKey = get_option('kandy_domain_secret_key', KANDY_DOMAIN_SECRET_KEY);

            if(array_key_exists ('kandy_api_key', $settingAttributes) && array_key_exists ('kandy_domain_secret_key', $settingAttributes)) {
                if($oldApiKey != $newApiKey || $oldSecretKey != $newSecretKey) {
                    global $wpdb;
                    // Delete all old kandy users, and their assignment.
                    $wpdb->query("TRUNCATE TABLE ".$wpdb->prefix."kandy_users");
                    KandyApi::syncUsers();
                }
            }
        }
        $this->render_page_start('Kandy Settings');
        $this->render_all_messages();
        ?>
        <form method="post" action="">
            <p>
                Kandy is a full-service cloud platform that enables real-time communications for business applications.
            </p>
            <p>Please fill some required configuration below if you have already kandy account.</p>
            <p>Otherwise, please visit &nbsp<a href="http://www.kandy.io/">Kandy home page</a> &nbsp to create a new account and get more information.</p>

            <div class="divider"></div>
            <table class="form-table">
                <tbody>

                <tr valign="top" id="kandy_api_key_row">
                    <th scope="row" id="kandy_api_key_label">
                        <label for="kandy_api_key">
                            <?php _e("API Key", "kandy") ?>
                        </label>
                    </th>
                    <td id="kandy_api_key_field">
                        <input name="kandy_settings[kandy_api_key]" type="text"
                               id="kandy_api_key"
                               placeholder="" class="" value="<?php echo get_option('kandy_api_key', KANDY_API_KEY); ?>"
                               style="width:60%">

                        <p class="description">
                            <?php _e(
                                "A api key is required for the Kandy API",
                                "kandy"
                            ); ?>
                        </p>
                    </td>
                </tr>

                <tr valign="top" id="kandy_domain_secret_key_row">
                    <th scope="row" id="kandy_domain_secret_key_label">
                        <label for="kandy_domain_secret_key">
                            <?php _e("Domain Secret Key", "kandy") ?>
                        </label>
                    </th>
                    <td id="kandy_domain_secret_key_field">
                        <input name="kandy_settings[kandy_domain_secret_key]" type="text"
                               id="kandy_domain_secret_key"
                               placeholder="" class="" value="<?php echo get_option('kandy_domain_secret_key', KANDY_DOMAIN_SECRET_KEY); ?>"
                               style="width:60%">

                        <p class="description">
                            <?php _e(
                                "A domain secret key is required for Kandy API",
                                "kandy"
                            ); ?>
                        </p>
                    </td>
                </tr>

                <tr valign="top" id="kandy_domain_name_row">
                    <th scope="row" id="kandy_domain_name_label">
                        <label for="kandy_domain_name">
                            <?php _e("Domain Name", "kandy") ?>
                        </label>
                    </th>
                    <td id="kandy_domain_name_field">
                        <input name="kandy_settings[kandy_domain_name]" type="text"
                               id="kandy_domain_name"
                               placeholder="" class="" value="<?php echo get_option('kandy_domain_name', KANDY_DOMAIN_NAME); ?>"
                               style="width:60%">

                        <p class="description">
                            <?php _e(
                                "A domain name is required for Kandy API",
                                "kandy"
                            ); ?>
                        </p>
                    </td>
                </tr>

                <tr valign="top" id="kandy_js_url_row" class="hidden">
                    <th scope="row" id="kandy_js_url_label">
                        <label for="kandy_js_url_key">
                            <?php _e("Javascript Library Url", "kandy") ?>
                        </label>
                    </th>
                    <td id="kandy_js_url_field">
                        <input name="kandy_settings[kandy_js_url]" type="text"
                               id="kandy_js_url"
                               placeholder="" class="" value="<?php echo get_option('kandy_js_url', KANDY_JS_URL) == '' ? KANDY_JS_URL : get_option('kandy_js_url', KANDY_JS_URL); ?>"
                               style="width:60%"
                               disabled
                            >

                        <p class="description">
                            <?php _e(
                                "A kandy javascript library url required for the Kandy API.",
                                "kandy"
                            ); ?>
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>

            <p class="submit">
                <input type="submit" name="submit" id="submit"
                       class="button-primary" value="Save Changes"/>
            </p>
        </form>
        <?php
        $this->render_page_end();
    }
}
?>
