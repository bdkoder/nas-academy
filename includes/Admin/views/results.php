<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Results', 'nas-academy') ?></h1>

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

        $table = new \Nas\Academy\Admin\Result_List();
        $table->prepare_items();
        $table->display();
    
    ?>
    </form>


</div>
