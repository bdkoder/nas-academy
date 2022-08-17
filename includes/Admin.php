<?php

namespace Nas\Academy;

/**
 * The admin class
 */
class Admin
{
    public function __construct()
    {
        $events = new Admin\Events();
        $this->dispatch_actions($events);
        
        new Admin\Menu($events);
    }

    public function dispatch_actions($events)
    {
        add_role(
            'nas_reviewer',
            __( 'NAS Reviewer' ),
            array(
            'read'         => true,  // true allows this capability
            'edit_posts'   => false,
            )
            );
        add_action('admin_init', [$events, 'form_handler']);
        add_action('admin_post_wd-delete-event', [$events, 'delete_event']);
        add_action('admin_post_wd-delete-category', [$events, 'delete_category']);
        add_action('admin_post_wd-delete-participator', [$events, 'delete_participator']);
        add_action('admin_post_wd-delete-participator-duplicate', [$events, 'delete_participator_duplicate']);

        add_action('admin_init', [$events, 'form_handler_category']);

        add_action('admin_init', [$events, 'form_handler_rating']);


        add_action('wp_ajax_nas_submit_participator', 'submit_participator');
        add_action('wp_ajax_nopriv_nas_submit_participator', 'submit_participator');

        // used on submit participator for
        add_action('wp_ajax_nas_send_token', 'otp_sender');
        add_action('wp_ajax_nopriv_nas_send_token', 'otp_sender');

        // used on sms sender
        add_action('wp_ajax_nas_sms_phone_number_loader', 'wd_fetch_participator_by_event');
        add_action('wp_ajax_nopriv_nas_sms_phone_number_loader', 'wd_fetch_participator_by_event');   
        
        // used on reject item on review
        add_action('wp_ajax_nas_item_reject', 'wd_reject_participator');
        add_action('wp_ajax_nopriv_nas_item_reject', 'wd_reject_participator');
        
        // used on restore reject item
        add_action('wp_ajax_nas_reject_restore', 'wd_reject_restore');
        add_action('wp_ajax_nopriv_nas_reject_restore', 'wd_reject_restore');

           
    }
    
}
