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
class Duplicate_Entry_List extends \WP_List_Table
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
            'file_src' => __('Picture', 'nas-academy'),
            'name' => __('Name', 'nas-academy'),
            'phone' => __('Phone', 'nas-academy'),
            'event_name' => __('Event', 'nas-academy'),
            'contact' => __('Contact', 'nas-academy'),
            'created_at' => __('Created at', 'nas-academy')
        ];
    }
   
    public function get_sortable_columns()
    {
        $sortable_columns = [
            'file_src' => ['file_src', true],
            'name' => ['name', true],
            'phone' => ['phone', true],
            'event_name' =>['event_name', true],
            'contact' =>['contact', true],
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

        // $actions['edit']   = sprintf( '<a href="%s" title="%s">%s</a>', admin_url( 'admin.php?page=nas-academy-categories&action=edit&id=' . $item->id ), $item->id, __( 'Edit', 'nas-academy' ), __( 'Edit', 'nas-academy' ) );
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" onclick="return confirm(\'Are you sure?\');" title="%s">%s</a>', wp_nonce_url( admin_url( 'admin-post.php?action=wd-delete-participator-duplicate&id=' . $item->id ), 'wd-delete-participator-duplicate' ), $item->id, __( 'Delete', 'nas-academy' ), __( 'Delete', 'nas-academy' ) );

        return sprintf(
            '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url('admin.php?page=nas-academy-categories&action=view&id'. $item->id), $item->name, $this->row_actions($actions)
        );
    }

    public function column_file_src($item){
        // $actions = [];

        // $actions['edit']   = sprintf( '<a href="%s" title="%s">%s</a>', admin_url( 'admin.php?page=nas-academy-categories&action=edit&id=' . $item->id ), $item->id, __( 'Edit', 'nas-academy' ), __( 'Edit', 'nas-academy' ) );
        // $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" onclick="return confirm(\'Are you sure?\');" title="%s">%s</a>', wp_nonce_url( admin_url( 'admin-post.php?action=wd-delete-category&id=' . $item->id ), 'wd-delete-category' ), $item->id, __( 'Delete', 'nas-academy' ), __( 'Delete', 'nas-academy' ) );

        return sprintf(
            // '<img width="160" src="%1$s"><a href="%2$s">test</a>', $item->file_src, $item->file_src
            '<img width="160" src="%1$s">', $item->file_src
        );
    }
    
    public function column_event_name($item){
        return sprintf(
            '<strong>Event-</strong><span>%1$s</span><br/><strong>Category-</strong></strong><span>%2$s</span>', $item->event_name, $item->category_name
        );
    }
    
    public function column_contact($item){
        return sprintf(
            '<strong>Guardian Name-</strong><span>%1$s</span><br/><strong>Email-</strong><span>%2$s</span><br/><strong>Phone-</strong></strong><span>%3$s</span><br/><strong>Address-</strong></strong><span>%4$s</span>', $item->guardian_name, $item->email, $item->phone, $item->address
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

        $this->items = wd_get_duplicate_entry($args);
        $this->set_pagination_args([
            'total_items' => wd_duplicate_entry_count(),
            'per_page'   => $per_page
        ]);
    }
}
