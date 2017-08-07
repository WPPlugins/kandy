<?php
require_once(dirname(__FILE__) . "/KandyPage.php");
require_once(dirname(__FILE__) . "/AssignmentTableList.php");
require_once(KANDY_PLUGIN_DIR . "/api/kandy-api-class.php");
class KandyCustomizationEditPage extends KandyPage
{
    public function render()
    {
        $this->render_page_start("Kandy");

        ?>
        <h3>
            <?php _e("Kandy Edit Customization", "kandy"); ?>
        </h3>
        <?php

        if (isset($_GET['action']) && isset($_GET['fileStyle']) && isset($_GET['fileName'])) {
            $action = $_GET['action'];
            if ($action == "edit") {
                //submit form
                if(isset($_POST['fileStyle']) && isset($_POST['fileName']) && isset($_POST['fileContent'])){

                    $fileStyle = $_POST['fileStyle'];
                    $fileName = $_POST['fileName'];
                    $fileContent= $_POST['fileContent'];
                    $filePath = KANDY_PLUGIN_DIR . "/". $fileStyle . "/shortcode/" . $fileName . '.' . $fileStyle;

                    if(file_exists($filePath)){
                        file_put_contents($filePath, $fileContent);
                        KandyApi::redirect(KandyApi::page_url(), __("Save successfully"), "updated");
                    } else {
                        echo "<div class='error'><p>". _e("Error. Please check again.", "kandy"). "</p></div>";
                    }

                } else {

                    $fileStyle = $_GET['fileStyle'];
                    $fileName = $_GET['fileName'];
                    $filePath = KANDY_PLUGIN_DIR . "/". $fileStyle . "/shortcode/" . $fileName . '.' . $fileStyle;

                    if(file_exists($filePath)){
                        $fileContent= file_get_contents($filePath);
                        ?>
                        <form id="kandy-user-assignment-form" method="post" action="">
                            <p class="submit">
                                <input type="submit" name="submit" id="submit"
                                       class="button-primary" value="Save Changes"/>
                                <a class='button' href='<?php echo KandyApi::page_url(); ?> '>  <?php _e('Cancel', 'kandy') ?></a>
                            </p>
                            <table class="form-table">
                                <tbody>

                                <tr valign="top" id="kandy_api_key_row">
                                    <th style="width:100px;" scope="row" id="kandy_api_key_label">
                                        <label for="kandy_api_key">
                                            <?php _e("File Name", "kandy") ?>
                                        </label>
                                    </th>
                                    <td id="kandy_api_key_field">
                                        <label><?php echo $fileName . '.' . $fileStyle; ?></label>
                                        <input type="hidden" name="fileStyle" value="<?php echo $fileStyle; ?>">
                                        <input type="hidden" name="fileName" value="<?php echo $fileName; ?>">
                                    </td>
                                </tr>

                                <tr valign="top" id="kandy_user_row">
                                    <th style="width:100px;" scope="row" id="kandy_user_id_label">
                                        <label for="kandy_user_id">
                                            <?php _e("Content", "kandy") ?>
                                        </label>
                                    </th>
                                    <td id="kandy_user_id_field">
                                       <textarea style="width: 100%" rows="25" name="fileContent" ><?php echo $fileContent; ?></textarea>
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
                            'File is not exist. Please contact with administrator to get more information',
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
