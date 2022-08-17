<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Rejected List', 'nas-academy') ?></h1>

    <form action="" method="post">
    <?php

        $table = new \Nas\Academy\Admin\Rejected_List();
        $table->prepare_items();
        $table->display();
    
    ?>
    </form>


</div>
