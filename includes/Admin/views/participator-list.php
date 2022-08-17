<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Participators', 'nas-academy') ?></h1>

    <?php if( isset($_GET['participator-deleted']) && $_GET['participator-deleted'] == true ): ?>
        <div class="notice notice-success">
        <p><?php _e('Participator has been deleted successfully!', 'nas-academy'); ?></p>
        </div>
    <?php endif;?>

    <form action="" method="post">
    <?php

        $table = new \Nas\Academy\Admin\Participator_List();
        $table->prepare_items();
        $table->display();
    
    ?>
    </form>


</div>
