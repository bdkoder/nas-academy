<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Review', 'nas-academy')?></h1>

    <?php if (isset($_GET['rating-inserted'])): ?>
        <div class="notice notice-success">
            <p><?php _e('Rating has been inserted successfully!', 'nas-academy');?></p>
        </div>
    <?php endif;?>

    <?php if (!empty($item_for_review->id)): ?>

        <div id="col-container" class="wp-clearfix">

            <div id="col-left">
                <div class="col-wrap">
                    <div class="card">
                        <p><?php _e('<i>Note: Please provide your review. It\'s not possible to update/delete reviews. You can give review only one time on one item.</i>', 'nas-academy');?></p>
                        <form action="" method="post">
                            <table class="form-table">
                                <tr class="row">
                                    <th scope="row">
                                        <label><?php _e('Event', 'nas-academy')?></label>
                                    </th>
                                    <td>
                                        <?php echo esc_html($item_for_review->event_name); ?>
                                    </td>
                                </tr>
                                <tr class="row">
                                    <th scope="row">
                                        <label><?php _e('Category', 'nas-academy')?></label>
                                    </th>
                                    <td>
                                        <?php echo esc_html($item_for_review->category_name); ?>
                                    </td>
                                </tr>
                                <tr class="row">
                                    <th scope="row">
                                        <label for="rating"><?php _e('Your Rating', 'nas-academy')?></label>
                                    </th>
                                    <td>
                                        <input type="number" max="10" name="rating" id="rating" class="regular-text" value="" autofocus>
                                        <?php if ($this->has_error('rating')): ?>
                                            <p class="description error"><?php echo $this->get_error('rating'); ?></p>
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <tr class="row">
                                    <th scope="row">

                                    </th>
                                    <td>
                                        <input type="hidden" name="participatorId" value="<?php echo esc_attr($item_for_review->id); ?>">
                                        <?php wp_nonce_field('submit-rating');?>
                                        <?php submit_button(__('Submit Rating', 'nas-academy'), 'primary', 'submit_rating');?>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="card">
                        <form id="reject-form" method="post">
                            <table class="form-table">
                                <tr class="row">
                                    <th scope="row">
                                        <p class="description error">
                                            <?php _e('Click Reject button to reject this item.', 'nas-academy')?>
                                        </p>
                                    </th>
                                    <td>
                                        <textarea rows="5" cols="40" name="message" id="message">Sorry, Your Drawing Rejected! Because you didn't follow our contest rules. NAS Drawing Academy</textarea>
                                    </td>
                                </tr>
                                <tr class="row">
                                    <th scope="row"> </th>
                                    <td>
                                        <input type="hidden" name="to" id="phone" value="<?php echo esc_attr($item_for_review->phone); ?>">
                                        <input type="hidden" name="participatorId" value="<?php echo esc_attr($item_for_review->id); ?>">
                                        <button type="submit" id="nas-item-reject" class="button ">Reject</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="card">
                        <h3 class="wp-heading-inline">
                            <?php 
                            _e('Items Left for Review', 'nas-academy');
                            echo ' - <i>' . $items_left_for_review->total_items . '</i>';
                            ?>            
                        </h3> 
                        <h3 class="wp-heading-inline">
                            <?php 
                            _e('Totals Reviewed By You', 'nas-academy');
                            echo ' - <i>' . $items_reviewed->total_items . '</i>';
                            ?>            
                        </h3>
                    </div>
                </div>
            </div>

            <div id="col-right">
                <div class="col-wrap">
                    <div class="nas-review-img" style="background: #fff;padding: 2em; text-align:center;">
                        <table  class="form-table">
                            <tr class="row">
                                <td scope="row"> 
                                    <div class="nas-review-img-wrapper">
                                        <img src="<?php echo esc_url($item_for_review->file_src); ?>" style="width:100%;height:100%;object-fit: contain;">
                                    </div>
                                </td>
                            </tr> 
                            <tr class="row">
                                <td scope="row"> 
                                    <button type="button" class="button-primary nas-add-review-rotate-btn" data-deg="90">Rotate 90deg</button>       
                                    <button type="button" class="button-primary nas-add-review-rotate-btn" data-deg="180">Rotate 180deg</button>       
                                    <button type="button" class="button-primary nas-add-review-rotate-btn" data-deg="270">Rotate 270deg</button>       
                                    <button type="button" class="button-primary nas-add-review-rotate-btn" data-deg="360">Rotate 360deg</button>       
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>


    <?php else: ?>

       <div class="card">
            <h3 class="wp-heading-inline"><?php _e('No more item for Review', 'nas-academy')?></h3>
        </div>
        <div class="card">
            <h3 class="wp-heading-inline">
                <?php 
                _e('Items Left for Review', 'nas-academy');
                echo ' - <i>' . $items_left_for_review->total_items . '</i>';
                ?>            
            </h3> 
            <h3 class="wp-heading-inline">
                <?php 
                _e('Totals Reviewed By You', 'nas-academy');
                echo ' - <i>' . $items_reviewed->total_items . '</i>';
                ?>            
            </h3>
        </div>

<?php endif;?>

</div>