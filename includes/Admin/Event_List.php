<?php

namespace Nas\Academy\Admin;

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List Table Class
 *
 * @author Shahidul Islam
 */
class Event_List extends \WP_List_Table
{
    function __construct()
    {
        parent::__construct([
            'singular' => 'event',
            'plural' => 'events',
            'ajax' => 'false'
        ]);
    }

    public function get_columns()
    {
        return [
            'cb' => '<input type="checkbox"/>',
            'name' => __('Name', 'nas-academy'),
            'date' => __('Date', 'nas-academy'),
            'created_at' => __('Created at', 'nas-academy')
        ];
    }
   
    public function get_sortable_columns()
    {
        $sortable_columns = [
            'name' => ['name', true],
            'date' =>['date', true],
            'created_at' => ['created_at', true],
        ];

        return $sortable_columns;
    }


    protected function column_default($item, $column_name)
    {
        switch($column_name){
           case 'value':
            break;
            default:
            return isset($item->$column_name) ? $item->$column_name : '';
        }
    }

    public function column_name($item){
        $actions = [];

        $actions['edit']   = sprintf( '<a href="%s" title="%s">%s</a>', admin_url( 'admin.php?page=nas-academy&action=edit&id=' . $item->id ), $item->id, __( 'Edit', 'nas-academy' ), __( 'Edit', 'nas-academy' ) );
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" onclick="return confirm(\'Are you sure?\');" title="%s">%s</a>', wp_nonce_url( admin_url( 'admin-post.php?action=wd-delete-event&id=' . $item->id ), 'wd-delete-event' ), $item->id, __( 'Delete', 'nas-academy' ), __( 'Delete', 'nas-academy' ) );

        return sprintf(
            '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url('admin.php?page=nas-academy&action=view&id'. $item->id), $item->name, $this->row_actions($actions)
        );
    }
    

    protected function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="event_id[]" value="%d"/>', $item->id
        );
    }

    public function prepare_items()
    {
        $column = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [ $column, $hidden, $sortable ];

        $per_page = 20;
        $current_page = $this->get_pagenum();
        $offset = ($current_page -1) * $per_page;

        $args = [
            'number' => $per_page,
            'offset' => $offset
        ];

        if( isset($_REQUEST['orderby']) && isset($_REQUEST['order'])){
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order'] = $_REQUEST['order'];
        }

        $this->items = wd_get_events($args);
        $this->set_pagination_args([
            'total_items' => wd_event_count(),
            'per_page'   => $per_page
        ]);
    }
}
