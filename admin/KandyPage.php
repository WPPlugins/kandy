<?php
class KandyPage
{
    // Holds the vars that can be posted
    protected $form_fields = array();

    // Holds the fields that do not validate
    protected $form_error_fields = array();

    // Messages to be displayed on top of the page
    protected $messages = array();

    // The baseurl of the Wordpress admin page
    protected $base_url = "admin.php";

    /**
     * Render page start event.
     *
     * @param $title
     */
    protected function render_page_start($title)
    {
        ?>
        <div id="wpbody-content" class="kandy-page">
        <div class="wrap">
        <div id="icon-kandy-main" class="icon32"></div>
        <h2><?php echo $title; ?></h2>
    <?php
    }

    /**
     * Render all message in page.
     */
    protected function render_all_messages()
    {
        // Check for post error messages
        if (count($this->form_error_fields)) {
            $msg = 'Watch out you gave invalid input for <em>"';
            $errors = array();
            foreach ($this->form_error_fields as $field) {
                $errors[] = $field->label;
            }
            $msg .= implode('"</em>, <em>"', $errors);
            $msg .= '"</em>. Please correct the input and resubmit to save your input.';
            $this->add_message($msg, 'error');
        }
        if (count($this->messages)) {
            foreach ($this->messages as $msg) {
                $this->render_message($msg['message'], $msg['type']);
            }
        } else {
            echo "<div class='divider'></div>";
        }
    }

    /**
     * Render message in page.
     *
     * @param $msg
     * @param string $type
     */
    protected function render_message($msg, $type = 'updated')
    {
        $type = ('error' == $type) ? 'error' : 'updated fade';
        echo "<div class='$type'><p>";
        if ('error' == $type) {
            echo '<strong>ERROR:</strong> ';
        }
        echo $msg;
        echo '</p></div>';
    }

    /**
     * Render page end.
     */
    protected function render_page_end()
    {
        ?>
        </div>
        <div class="clear"></div>
        </div><!-- wpbody-content -->
        <div class="clear"></div>
    <?php
    }
} 