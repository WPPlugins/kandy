<?php
require_once (dirname(__FILE__) . "/KandyPage.php");
require_once (dirname(__FILE__) . "/AssignmentTableList.php");
require_once (KANDY_PLUGIN_DIR . "/api/kandy-api-class.php");
class KandyAssignmentPage extends KandyPage
{
    public function render()
    {
        $this->render_page_start("Kandy");
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            if ($action == "sync") {
                $result = KandyApi::syncUsers();
                if ($result) {
                    echo "<div class='updated'><p>" . __('Sync Kandy Users successfully', 'kandy') ."</div></p>";

                } else {
                    echo "<div  class='error'><p>". __('Sync Kandy Users fail', 'kandy') . "</p></div>";
                    echo "<p> Please check your configuration &nbsp<a href='". KandyApi::page_url(array('page' => 'kandy')) ."'>here</a>&nbsp, then try again. </p>";
                }

            } else if ($action == "autoassign") {
                $count = KandyApi::autoAssignmentUsers();
                echo "<div class='updated'><p>" . __('Auto Assign Kandy Users successfully, '.$count.' user(s)', 'kandy') ."</div></p>";

            }

        }
        ?>
        <h3>
            <?php _e("Kandy User Assignment", "kandy"); ?>
            <a href="<?php echo Kandyapi::page_url(array('action' =>'sync')); ?>" class="button-primary"><?php _e("Sync Kandy Users", "kandy"); ?></a>
            <a href="<?php echo Kandyapi::page_url(array('action' =>'autoassign')); ?>" class="button-primary"><?php _e("Auto Assign Kandy Users", "kandy"); ?></a>
        </h3>
        <?php

        $this->render_all_messages();
        if(KandyApi::isFristVisit())
        {
            $result = KandyApi::syncUsers();
            if ($result) {
                echo "<div class='updated'><p>" . __('Auto Sync Kandy Users successfully', 'kandy') ."</div></p>";

            } else {
                echo "<div  class='error'><p>". __('Auto Sync Kandy Users fail', 'kandy') . "</p></div>";
            }
            $usercount = count_users()['total_users'];
            if($usercount <= KANDY_USER_NUM_FIRST_VISIT)
            {
                $count = KandyApi::autoAssignmentUsers();
                echo "<div class='updated'><p>" . __('Auto Assign Kandy Users successfully, '.$count.' user(s)', 'kandy') ."</div></p>";
            }
        }
        $assignmentTableList = new AssignTableList();
        $assignmentTableList->prepare_items();
        $assignmentTableList->display();
        $this->render_page_end();

    }
}
?>
