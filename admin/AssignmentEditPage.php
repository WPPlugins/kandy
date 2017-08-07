<?php
require_once(dirname(__FILE__) . "/KandyPage.php");
require_once(dirname(__FILE__) . "/AssignmentTableList.php");
require_once(KANDY_PLUGIN_DIR . "/api/kandy-api-class.php");
class KandyAssignmentEditPage extends KandyPage
{
    public function render()
    {
        $this->render_page_start("Kandy");
        if(get_option("kandy_jquery_reload")){
            wp_enqueue_script("kandy-jquery", KANDY_JQUERY);
        }

        //load script and css
        wp_enqueue_script("select-2-script", KANDY_PLUGIN_URL . '/js/select2-3.5.2/select2.js');
        wp_enqueue_style("select-2-style", KANDY_PLUGIN_URL . '/js/select2-3.5.2/select2.css');
        $this->activeSelect2("kandy-user-select");
        ?>
        <h3><?php _e("Kandy User Assignment", "kandy"); ?>
            <a href="<?php echo KandyApi::page_url(array('action' => 'sync')); ?>"
               class="button-primary">
                <?php _e(
                    "Sync Kandy Users",
                    "kandy"
                ); ?>
            </a>
            <a href="<?php echo KandyApi::page_url(array('action' => 'autoassign')); ?>"
               class="button-primary">
                <?php _e(
                    "Auto Assign Kandy Users",
                    "kandy"
                ); ?>
            </a>
        </h3>
        <?php

        if (isset($_GET['action']) && isset($_GET['id'])) {
            $action = $_GET['action'];
            $id = $_GET['id'];
            if ($action == "edit") {
                //submit form
                if(isset($_POST['main_user_id']) && isset($_POST['kandy_user_id'])){

                    $main_user_id = $_POST['main_user_id'];
                    $kandy_user_id = $_POST['kandy_user_id'];

                    if($kandy_user_id){
                        $result = KandyApi::assignUser($kandy_user_id, $main_user_id);
                    } else{
                        $result = KandyApi::unassignUser($main_user_id);
                    }
                    if($result){
                        KandyApi::redirect(
                            KandyApi::page_url(),
                            __("Save Successfully", "kandy"),
                            "updated"
                        );
                        exit;

                    } else {
                        echo "<p>". _e("Error. Please check again.", "kandy"). "</p>";
                    }

                } else {
                    $user = get_userdata($id);

                    if($user){
                        ?>
                        <form id="kandy-user-assignment-form" method="post" action="">
                            <table class="form-table">
                                <tbody>

                                <tr valign="top" id="kandy_api_key_row">
                                    <th style="width:100px;" scope="row" id="kandy_api_key_label">
                                        <label for="kandy_api_key">
                                            <?php _e("Name", "kandy") ?>
                                        </label>
                                    </th>
                                    <td id="kandy_api_key_field">
                                        <label><?php echo $user->display_name; ?></label>
                                        <input type="hidden" name="main_user_id" value="<?php echo $user->ID; ?>">
                                    </td>
                                </tr>

                                <tr valign="top" id="kandy_user_row">
                                    <th style="width:150px;" scope="row" id="kandy_user_id_label">
                                        <label for="kandy_user_id">
                                            <?php _e("Kandy Username", "kandy") ?>
                                        </label>
                                    </th>
                                    <td id="kandy_user_id_field">
                                        <select name="kandy_user_id"
                                                id="kandy-user-select"
                                                class="kandy-user-select"
                                                style="width: 30%">
                                            <?php echo $this->getOptionData($user->ID); ?>
                                        </select>

                                        <p class="description">
                                            <?php _e(
                                                "Select kandy user name you want to assign. Set 'None' to unassign",
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
                                <a class='button' href='<?php echo KandyApi::page_url(); ?> '>  <?php _e('Cancel', 'kandy') ?></a>
                            </p>
                        </form><!--end form -->


                <?php
                    }//end user is not null
                    else {
                        _e(
                            'User not found. Please contact with administrator to get more information',
                            'kandy'
                        );
                        echo "<p><a class='button primary' href='" . KandyApi::page_url() . "'>" .
                            __('Back', 'kandy') ."</a></p>";
                    }
                }//else submit form
            }//end action edit
        } else {
            _e(
                'Invalid request. Please contact with administrator to get more information',
                'kandy'
            );
        }

        $this->render_page_end();
    }

    /**
     * Get option HTML for kandy user select
     * @param $userId
     * @return string
     */
    protected  function getOptionData($userId){
        $result = "<option value=''>None</option>";
        $currentKandyUser = KandyApi::getAssignUser($userId);
        if($currentKandyUser){
            $result .= "<option selected value ='" . $currentKandyUser->user_id."'>". $currentKandyUser->user_id . "</option>";
        }
        $kandyUsers = KandyApi::listUsers(KANDY_USER_UNASSIGNED);
        foreach($kandyUsers as $kandyUser){
            if($kandyUser->main_user_id == $userId){
                $result .= "<option selected value ='" . $kandyUser->user_id."'>". $kandyUser->user_id . "</option>";
            } else {
                $result .= "<option value ='" . $kandyUser->user_id."'>". $kandyUser->user_id . "</option>";
            }

        }
        return $result;

    }

    /**
     * Add script to active kandy user select 2
     * @param $elementId
     */
    protected function activeSelect2($elementId){
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                $("#<?php echo $elementId; ?>").select2();
            });
        </script>
<?php
    }
}
?>
