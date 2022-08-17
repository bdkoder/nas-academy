<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Settings', 'nas-academy') ?></h1>

    <?php
    settings_errors();
    
//    $test = wd_get_events($args= []);
//    print_r($test);
    
    $table = new \Nas\Academy\Admin\Event_List();
    $table->prepare_items();
    $items = $table->items;
    
    ?>

    <form method="post" action="options.php">
        <?php settings_fields('nas_options_group'); ?>
        <?php do_settings_sections('nas_options_group'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Select Current Event</th>
                <td>
                    <select name="nas_current_event_id" id="nas_current_event_id">
                        <?php
                        $current_event = esc_attr(get_option('nas_current_event_id'));
                        echo '<option>Select Event</option>';
                        echo '<option value="">All</option>';
                        foreach ($items as  $item) {
                            if( !empty($current_event) && $current_event == $item->id){
                                echo '<option value="' . $item->id . '" selected>' . $item->name . '</option>';
                            }else{
                                echo '<option value="' . $item->id . '">' . $item->name . '</option>';
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
               
        </table>

        <?php submit_button(); ?>

    </form>
    <?php   ?>


</div>