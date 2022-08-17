<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('New Category', 'nas-academy') ?></h1>

    <?php //var_dump($this->errors); 

    $table = new \Nas\Academy\Admin\Event_List();
    $table->prepare_items();
    $items = $table->items;
    ?>

    <form action="" method="post">
        <table class="form-table">
            <tr class="row<?php echo $this->has_error('name') ? ' form-invalid' : ''; ?>">
                <th scope="row">
                    <label for="name"><?php _e('Name', 'nas-academy') ?></label>
                </th>
                <td>
                    <input type="text" name="name" id="name" class="regular-text" value="">
                    <?php if ($this->has_error('name')) : ?>
                        <p class="description error"><?php echo $this->get_error('name'); ?></p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr class="row<?php echo $this->has_error('event') ? ' form-invalid' : ''; ?>">
                <th scope="row">
                    <label for="event"><?php _e('Event', 'nas-academy') ?></label>
                </th>
                <td>
                    <select name="event" id="event">
                        <?php
                        foreach ($items as  $item) {
                            echo '<option value="' . $item->id . '">' . $item->name . '</option>';
                        }
                        ?>

                    </select>
                </td>
            </tr>
        </table>

        <?php wp_nonce_field('new-category'); ?>
        <?php submit_button(__('Create Category', 'nas-academy'), 'primary', 'submit_category'); ?>

    </form>


</div>