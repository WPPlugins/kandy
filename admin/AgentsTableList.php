<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}
require_once (KANDY_PLUGIN_DIR . "/api/kandy-api-class.php");
class AgentsTableList extends WP_List_Table
{

    var $data = array();
    var $limit = 10;
    var $offset = 0;
    function __construct()
    {

        parent::__construct(
            array(
                'singular' => __('book', 'mylisttable'),
                //singular name of the listed records
                'plural'   => __('books', 'mylisttable'),
                //plural name of the listed records
                'ajax'     => false
                //does this table support ajax?
            )
        );
    }

    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
            case 'user_email':
            case 'user_nicename':
            case 'kandy_user':
            case 'average':
            case 'action':
                return $item[$column_name];
            default:
                return print_r(
                    $item,
                    true
                ); //Show the whole array for troubleshooting purposes
        }
    }

    function get_columns()
    {
        $columns = array(
            'id'            => __("ID", 'kandy'),
            'user_email'      => __('Email', 'kandy'),
            'user_nicename'      => __('Name', 'kandy'),
            'kandy_user' => __('Kandy Username', 'kandy'),
            'average' => __('Average', 'kandy'),
            'action'        => __('Action', 'kandy')
        );
        return $columns;
    }

    function get_data($limit = 10, $offset = 0)
    {
        $result = KandyApi::getListAgents($limit, $offset);
        return $result;
    }

    function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

        //pagination
        $per_page = 10;
        $current_page = $this->get_pagenum();
        $data = $this->get_data($per_page, ($current_page-1)*$per_page);
        $total_items = KandyApi::totalListAgents();

        $this->set_pagination_args(
            array(
                'total_items' => $total_items,
                //WE have to calculate the total number of items
                'per_page'    => $per_page
                //WE have to determine how many items to show on a page
            )
        );
        $this->items = $data;
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'average' => array('average', false),
        );
        return $sortable_columns;
    }

    function usort_reorder($a, $b)
    {
        // If no sort, default to title
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'booktitle';
        // If no order, default to asc
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';
        // Determine sort order
        $result = strcmp($a[$orderby], $b[$orderby]);
        // Send final sort direction to usort
        return ($order === 'asc') ? $result : -$result;
    }
}
