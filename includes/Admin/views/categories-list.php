<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Categories', 'nas-academy') ?></h1>
    <a href="<?php echo admin_url('admin.php?page=nas-academy-categories&action=new'); ?>" class="page-title-action">Add New</a>

    <?php if( isset($_GET['category-inserted']) ): ?>
        <div class="notice notice-success">
        <p><?php _e('Category has been added successfully!', 'nas-academy'); ?></p>
        </div>
    <?php endif;?>
    
    <?php if( isset($_GET['category-deleted']) && $_GET['category-deleted'] == true ): ?>
        <div class="notice notice-success">
        <p><?php _e('Event has been deleted successfully!', 'nas-academy'); ?></p>
        </div>
    <?php endif;?>

    <form action="" method="post">
    <?php

        $table = new \Nas\Academy\Admin\Category_List();
        $table->prepare_items();
        $table->display();
    
    ?>
    </form>


</div>
