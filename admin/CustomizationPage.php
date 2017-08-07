<?php
require_once (dirname(__FILE__) . "/KandyPage.php");
require_once (dirname(__FILE__) . "/AssignmentTableList.php");
require_once (KANDY_PLUGIN_DIR . "/api/kandy-api-class.php");
class KandyCustomizationPage extends KandyPage
{
    public function render()
    {
        $this->render_page_start("Kandy");
        ?>
        <h3>
            <?php _e("Kandy Style/Script Customization", "kandy"); ?>
        </h3>

        <p> <?php _e("Kandy Style Customization", "kandy"); ?></p>

        <?php
        $cssDir = KANDY_PLUGIN_DIR . "/css/shortcode/*.css";
        $cssFiles = glob($cssDir);
        echo "<ul>";
        foreach($cssFiles as $cssFile){
            $fileInfo = pathinfo($cssFile);
            $fileName = $fileInfo['filename'];
            $baseName = $fileInfo['basename'];
            $url = KandyApi::page_url(
                array('action' => 'edit', 'fileStyle' => 'css', 'fileName' => $fileName)
            );
            echo "<li><a href='". $url. "'>". $baseName."</a></li>";
        }
        echo "</ul>";

        $jsDir = KANDY_PLUGIN_DIR . "/js/shortcode/*.js";
        $jsFiles = $cssFiles = glob($jsDir);

        ?>
        <p> <?php _e("Kandy Script Customization", "kandy"); ?></p>

        <?php
        echo "<ul>";
        foreach($jsFiles as $jsFile){
            $fileInfo = pathinfo($jsFile);
            $fileName = $fileInfo['filename'];
            $baseName = $fileInfo['basename'];
            $url = KandyApi::page_url(
                array('action' => 'edit', 'fileStyle' => 'js', 'fileName' => $fileName)
            );
            echo "<li><a href='". $url. "'>". $baseName."</a></li>";
        }
        echo "</ul>";
        $this->render_page_end();
    }
}
?>
