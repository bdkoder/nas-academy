<?php

/**
 * Description of Menu
 *
 * @author Shahidul Islam
 */

namespace Nas\Academy\Admin;

class Menu
{
    public $events;

    public function __construct($events)
    {
        $this->events = $events;
        add_action('admin_menu', [$this, 'admin_menu']);
    }

    /**
     * Register admin menu
     * 
     * @return void
     */
    public function admin_menu()
    {
        $parent_slug = 'nas-academy';
        $capability = 'manage_options'; 
        add_menu_page(__('NAS Drawing Academy', 'nas-academy'), __('NAS Drawing Academy', 'nas-academy'), $capability, $parent_slug, [$this->events, 'form_handler'], 'dashicons-welcome-learn-more');
        add_submenu_page($parent_slug, __('Manage Events', 'nas-academy'), __('Manage Events', 'nas-academy'), $capability, $parent_slug, [$this->events, 'plugin_page']);
        add_submenu_page($parent_slug, __('Events Categories', 'nas-academy'), __('Events Categories', 'nas-academy'), $capability, 'nas-academy-categories', [$this->events, 'categories_page']);
        add_submenu_page($parent_slug, __('Participators', 'nas-academy'), __('Participators', 'nas-academy'), $capability, 'nas-academy-participators', [$this->events, 'participators_page']);
        add_submenu_page($parent_slug, __('Duplicate Entry', 'nas-academy'), __('Duplicate Entry', 'nas-academy'), $capability, 'nas-academy-duplicate-entry', [$this->events, 'duplicate_entry']);
        add_submenu_page($parent_slug, __('Rejected List', 'nas-academy'), __('Rejected List', 'nas-academy'), $capability, 'nas-academy-rejected-list', [$this->events, 'rejected_list']);
        
        
        if (current_user_can('nas_reviewer') ) {
            add_submenu_page($parent_slug, __('Add Reviews', 'nas-academy'), __('Add Reviews', 'nas-academy'), 'nas_reviewer', 'nas-academy-add-review', [$this->events, 'review_page']);
        }else{
            add_submenu_page($parent_slug, __('Add Reviews', 'nas-academy'), __('Add Reviews', 'nas-academy'), $capability, 'nas-academy-add-review', [$this->events, 'review_page']);
        }
        
        
        add_submenu_page($parent_slug, __('Results', 'nas-academy'), __('Results', 'nas-academy'), $capability, 'nas-academy-results', [$this->events, 'results_page']);
        add_submenu_page($parent_slug, __('SMS Sender', 'nas-academy'), __('SMS Sender', 'nas-academy'), $capability, 'nas-academy-sms-sender', [$this->events, 'sms_page']);
        add_submenu_page($parent_slug, __('Settings', 'nas-academy'), __('Settings', 'nas-academy'), $capability, 'nas-academy-settings', [$this->events, 'settings_page']);



        

    }

    /**
     * Handles the settings page
     * 
     * @return void
     */
    // settings_page
    // public function settings_page()
    // {
    //     echo 'Settings Book';
    // }

   
}
