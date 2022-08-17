<?php

namespace Nas\Academy\Admin;

use Nas\Academy\Traits\Form_Error;

/**
 * Description of Events
 *
 * @author Shahidul Islam
 */
class Events
{

    use Form_Error;

    public function plugin_page()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        switch ($action) {
            case 'new':
                $template = __DIR__ . '/views/event-new.php';
                break;

            case 'edit':
                $address = wd_get_event($id);
                $template = __DIR__ . '/views/event-edit.php';
                break;
            case 'view':
                $template = __DIR__ . '/views/event-view.php';
                break;

            default:
                $template = __DIR__ . '/views/event-list.php';
                break;
        }

        if (file_exists($template)) {
            include $template;
        }
    }

    public function categories_page()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        switch ($action) {
            case 'new':
                $template = __DIR__ . '/views/categories-new.php';
                break;

            case 'edit':
                $category = wd_get_category($id);
                $template = __DIR__ . '/views/categories-edit.php';
                break;
            case 'view':
                $template = __DIR__ . '/views/event-view.php';
                break;

            default:
                $template = __DIR__ . '/views/categories-list.php';
                break;
        }

        if (file_exists($template)) {
            include $template;
        }
    }


    public function participators_page()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        switch ($action) {
            case 'edit':
                $category = wd_get_category($id);
                $template = __DIR__ . '/views/categories-edit.php';
                break;
            case 'view':
                $template = __DIR__ . '/views/event-view.php';
                break;

            default:
                $template = __DIR__ . '/views/participator-list.php';
                break;
        }

        if (file_exists($template)) {
            include $template;
        }
    }

    public function sms_page()
    {
        $template = __DIR__ . '/views/sms-sender.php';

        if (file_exists($template)) {
            include $template;
        }
    } 
 
    public function review_page()
    {
        $reviewer = get_current_user_id();
        $item_for_review = wd_get_item_for_review($reviewer);
        $items_left_for_review = wd_items_left_for_review($reviewer);
        $items_reviewed = wd_items_reviewed($reviewer);
        $template = __DIR__ . '/views/add-review.php';

        if (file_exists($template)) {
            include $template;
        }
    }    
    
    public function settings_page()
    {
        $template = __DIR__ . '/views/settings-view.php';

        if (file_exists($template)) {
            include $template;
        }
    }    
    
    public function results_page()
    {
        $template = __DIR__ . '/views/results.php';

        if (file_exists($template)) {
            include $template;
        }
    }    
    
    public function duplicate_entry()
    {
        $template = __DIR__ . '/views/duplicate-entry.php';

        if (file_exists($template)) {
            include $template;
        }
    }    

    public function rejected_list()
    {
        $template = __DIR__ . '/views/rejected-list.php';

        if (file_exists($template)) {
            include $template;
        }
    }

    /**
     * Handle the form
     * 
     * @retun void
     */
    public function form_handler()
    {
        if (!isset($_POST['submit_event'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['_wpnonce'], 'new-event')) {
            wp_die('Are you cheating?');
        }

        if (!current_user_can('manage_options')) {
            wp_die('Are you cheating?');
        }

        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';

        if (empty($name)) {
            $this->errors['name'] = __('Please provide a name', 'nas-academy');
        }

        if (empty($date)) {
            $this->errors['date'] = __('Please provide a date', 'nas-academy');
        }

        if (!empty($this->errors)) {
            return;
        }

        $args = [
            'name'    => $name,
            'date' => $date,
        ];

        if ($id) {
            $args['id'] = $id;
        }

        $insert_id = wd_event_insert_event($args);

        if (is_wp_error($insert_id)) {
            wp_die($insert_id->get_error_message());
        }


        // redirect

        if ($id) {
            $redirected_to = admin_url('admin.php?page=nas-academy&action=edit&event-updated=true&id=' . $id);
        } else {
            $redirected_to = admin_url('admin.php?page=nas-academy&event-inserted=true');
        }

        wp_redirect($redirected_to);
        exit();
    }

    public function delete_event()
    {
        if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'wd-delete-event')) {
            wp_die('Are you cheating?');
        }

        if (!current_user_can('manage_options')) {
            wp_die('Are you cheating?');
        }

        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

        if (wd_delete_event($id)) {
            $redirected_to = admin_url('admin.php?page=nas-academy&event-deleted=true');
        } else {
            $redirected_to = admin_url('admin.php?page=nas-academy&event-deleted=false');
        }

        wp_redirect($redirected_to);
        exit();
    }

    
    /**
     * Handle the form
     * 
     * @retun void
     */
    public function form_handler_category()
    {
        if (!isset($_POST['submit_category'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['_wpnonce'], 'new-category')) {
            wp_die('Are you cheating?');
        }

        if (!current_user_can('manage_options')) {
            wp_die('Are you cheating?');
        }

        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $event = isset($_POST['event']) ? sanitize_text_field($_POST['event']) : '';

        if (empty($name)) {
            $this->errors['name'] = __('Please provide a name', 'nas-academy');
        }

        if (empty($event)) {
            $this->errors['event'] = __('Please select a event', 'nas-academy');
        }

        if (!empty($this->errors)) {
            return;
        }

        $args = [
            'name'    => $name,
            'event' => $event,
        ];

        if ($id) {
            $args['id'] = $id;
        }

        $insert_id = wd_event_insert_category($args);

        if (is_wp_error($insert_id)) {
            wp_die($insert_id->get_error_message());
        }


        // redirect

        if ($id) {
            $redirected_to = admin_url('admin.php?page=nas-academy-categories&action=edit&category-updated=true&id=' . $id);
        } else {
            $redirected_to = admin_url('admin.php?page=nas-academy-categories&category-inserted=true');
        }

        wp_redirect($redirected_to);
        exit();
    }

    public function delete_category()
    {
        if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'wd-delete-category')) {
            wp_die('Are you cheating?');
        }

        if (!current_user_can('manage_options')) {
            wp_die('Are you cheating?');
        }

        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

        if (wd_delete_category($id)) {
            $redirected_to = admin_url('admin.php?page=nas-academy-categories&category-deleted=true');
        } else {
            $redirected_to = admin_url('admin.php?page=nas-academy-categories&category-deleted=false');
        }

        wp_redirect($redirected_to);
        exit();
    }
 
    public function delete_participator()
    {
        if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'wd-delete-participator')) {
            wp_die('Are you cheating?');
        }

        if (!current_user_can('manage_options')) {
            wp_die('Are you cheating?');
        }

        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

        if (wd_delete_participator($id)) {
            $redirected_to = admin_url('admin.php?page=nas-academy-participators&participator-deleted=true');
            // to do uploaded images
        } else {
            $redirected_to = admin_url('admin.php?page=nas-academy-participators&participator-deleted=false');
        }

        wp_redirect($redirected_to);
        exit();
    }

  public function delete_participator_duplicate()
    {
        if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'wd-delete-participator-duplicate')) {
            wp_die('Are you cheating?');
        }

        if (!current_user_can('manage_options')) {
            wp_die('Are you cheating?');
        }

        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

        if (wd_delete_participator($id)) {
            $redirected_to = admin_url('admin.php?page=nas-academy-duplicate-entry&participator-deleted=true');
            // to do uploaded images
        } else {
            $redirected_to = admin_url('admin.php?page=nas-academy-duplicate-entry&participator-deleted=false');
        }

        wp_redirect($redirected_to);
        exit();
    }


     /**
     * Handle the review rating 
     * 
     * @retun void
     */
    public function form_handler_rating()
    {
        if (!isset($_POST['submit_rating'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['_wpnonce'], 'submit-rating')) {
            wp_die('Are you cheating?');
        }

        // if (!current_user_can('manage_options')) {
        //     wp_die('Are you cheating?');
        // }
        
        if (!current_user_can('manage_options') && !current_user_can('nas_reviewer') ) {
            wp_die('Are you cheating?');
        }


        $participator_id = isset($_POST['participatorId']) ? intval($_POST['participatorId']) : NULL;
        $rating = isset($_POST['rating']) ? intval($_POST['rating']) : '';
   

        if (empty($participator_id)) {
            wp_die('Are you cheating?');
        }  
        
        if ( $rating > 10 ) {
            wp_die('Are you cheating?');
        }

        if (empty($rating)) {
            $this->errors['rating'] = __('Please provide a rating', 'nas-academy');
        }

        if (!empty($this->errors)) {
            return;
        }

        $args = [
            'participator_id'    => $participator_id,
            'rating'    => $rating
        ];
 
        $insert_id = wd_insert_rating($args);

        if (is_wp_error($insert_id)) {
            wp_die($insert_id->get_error_message());
        }

        // redirect

        $redirected_to = admin_url('admin.php?page=nas-academy-add-review&rating-inserted=true');

        wp_redirect($redirected_to);
        exit();
    }

}
