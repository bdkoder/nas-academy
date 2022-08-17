<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('SMS Sender', 'nas-academy')?></h1>

        <div class="notice notice-success" id="sms-result" style="display: none;">
        <p><?php _e('Message sent successfully!', 'nas-academy');?></p>
        </div>

    <?php

$table = new \Nas\Academy\Admin\Event_List();
$table->prepare_items();
$items = $table->items;

$category_table = new \Nas\Academy\Admin\Category_List();
$category_table->prepare_items();
$category_items = $category_table->items;

// echo wd_fetch_participator_by_event(1);

?>

<div id="col-container" class="wp-clearfix">
    <div id="col-left">
        <div class="col-wrap">
            <div class="form-wrap">
                <!-- <form action="http://api.greenweb.com.bd/api.php" method="post"> -->
                <form method="post" class="sms-sender-form">
                    <input type="hidden" name="token" placeholder="token" value="86a55ae784ef5d145ddacb7af1998756" />
                <table class="form-table">
                        <tr class="row">
                            <th scope="row">
                                <label for="event-id-sms"><?php _e('Event', 'nas-academy')?></label>
                            </th>
                            <td>
                                <select name="event" id="event-id-sms">
                                    <option>Select Event</option>
                                    <?php
                                        foreach ($items as $item) {
                                            echo '<option value="' . $item->id . '">' . $item->name . '</option>';
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr class="row">
                            <th scope="row">
                                <label for="phone-numbers"><?php _e('Phone Numbers', 'nas-academy')?></label>
                            </th>
                            <td>
                                <input type="text" name="to" id="phone-numbers" class="regular-text" placeholder="+8801xxxxxxxxx,+8801xxxxxxxxx" />
                            </td>
                        </tr>

                        <tr class="row">
                            <th scope="row">
                                <label for="message"><?php _e('Message', 'nas-academy')?></label>
                            </th>
                            <td>
                                <textarea name="message" id="message" class="regular-text"  rows="10"></textarea>
                            </td>
                        </tr>

                        <tr class="row">
                            <th scope="row">

                            </th>
                            <td>
                                <button class="button button-primary" id="sms-sender-submit" type="submit" name="submit">Send SMS</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <div id="col-right">
        <div class="col-wrap">
            <div class="form-wrap">
                    <!-- todo report of sms  -->
            </div>
        </div>
    </div>
</div>



</div>
