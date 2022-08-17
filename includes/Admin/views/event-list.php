<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Events', 'nas-academy') ?></h1>
    <a href="<?php echo admin_url('admin.php?page=nas-academy&action=new'); ?>" class="page-title-action">Add New</a>

    <?php if( isset($_GET['event-inserted']) ): ?>
        <div class="notice notice-success">
        <p><?php _e('Event has been added successfully!', 'nas-academy'); ?></p>
        </div>
    <?php endif;?>
    
    <?php if( isset($_GET['event-deleted']) && $_GET['event-deleted'] == true ): ?>
        <div class="notice notice-success">
        <p><?php _e('Event has been deleted successfully!', 'nas-academy'); ?></p>
        </div>
    <?php endif;?>

    <form action="" method="post">
    <?php

        $table = new \Nas\Academy\Admin\Event_List();
        $table->prepare_items();
        $table->display();
    
    ?>
    </form>


</div>
