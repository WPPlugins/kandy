<?php
require_once(dirname(__FILE__) . "/KandyPage.php");
require_once(dirname(__FILE__) . "/AssignmentTableList.php");
require_once(KANDY_PLUGIN_DIR . "/api/kandy-api-class.php");
class KandyAssignmentSyncPage extends KandyPage
{
    public function render()
    {
        $this->render_page_start("Kandy");

        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            if ($action == "sync") {
                echo "<h3>" . __("Kandy user synchronization", "kandy"). "</h3>";
                $result = KandyApi::syncUsers();
                //$result = false;
                if ($result) {
                    echo "<div class='updated'><p>" . __('Sync successfully', 'kandy') ."</div></p>";
                    echo "<p><a class='button primary' href='" . KandyApi::page_url() . "'>" .
                        __('Back', 'kandy') ."</a></p>";

                } else {
                    echo "<div  class='error'><p>". __('Sync fail', 'kandy') . "</p></div>";
                    echo "<p> Please check your configuration &nbsp<a href='". KandyApi::page_url(array('page' => 'kandy')) ."'>here</a>&nbsp, then try again. </p>";
                    echo "<p><a class='button primary' href='" . KandyApi::page_url() . "'>" .
                        __('Back', 'kandy') ."</a>&nbsp<a class='button primary' href='" . KandyApi::page_url(array('action' => 'sync')) . "'>" .
                        __('Try again', 'kandy') ."</a>
                        </p>";
                }
                $this->render_page_end();
            } else {
                echo "sync error page";
                $this->render_page_end();
            }

        } else {
            _e(
                'Invalid request. Please contact with administrator to get more information',
                'kandy'
            );
            $this->render_page_end();
        }
    }
}
