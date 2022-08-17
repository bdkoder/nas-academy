<?php

/**
 * Insert a new Event
 *
 * @param array $args
 *
 * @return int|WP_Error
 */
function wd_event_insert_event($args = [])
{
    global $wpdb;

    if (empty($args['name'])) {
        return new \WP_Error('no-name', __('You must provide a name.', 'nas-academy'));
    }

    $defaults = [
        'name' => '',
        'date' => '',
        'created_by' => get_current_user_id(),
        'created_at' => current_time('mysql'),
    ];

    $data = wp_parse_args($args, $defaults);

    if (isset($data['id'])) {

        $id = $data['id'];
        unset($data['id']);

        $updated = $wpdb->update(
            $wpdb->prefix . 'nas_events',
            $data,
            ['id' => $id],
            [
                '%s',
                '%s',
                '%d',
                '%s',
            ],
            ['%d']
        );

        return $updated;

    } else {

        $inserted = $wpdb->insert(
            $wpdb->prefix . 'nas_events',
            $data,
            [
                '%s',
                '%s',
                '%d',
                '%s',
            ]
        );

        if (!$inserted) {
            return new \WP_Error('failed-to-insert', __('Failed to insert data', 'nas-academy'));
        }
    }

    return $wpdb->insert_id;
}

/**
 * Fetch Events
 *
 * @param $args
 *
 * @return array
 */

function wd_get_events($args = [])
{
    global $wpdb;

    $defaults = [
        'number' => 20,
        'offset' => 0,
        'orderby' => 'id',
        'order' => 'ASC',
    ];

    $args = wp_parse_args($args, $defaults);

    $items = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}nas_events
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'],
            $args['number']
        )
    );

    return $items;
}

/**
 * Get the count of total events
 *
 * @return int
 */
function wd_event_count()
{
    global $wpdb;
    return (int) $wpdb->get_var("SELECT count(id) FROM {$wpdb->prefix}nas_events");
}

/**
 * Fetch a single contact form the DB
 *
 * @param int $id
 *
 * @return object
 */
function wd_get_event($id)
{
    global $wpdb;
    return $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM {$wpdb->prefix}nas_events WHERE id = %d", $id)
    );
}

/**
 * Delete and Event
 *
 * @param int $id
 *
 * @return int|boolean
 */

function wd_delete_event($id)
{
    global $wpdb;
    return $wpdb->delete(
        $wpdb->prefix . 'nas_events',
        ['id' => $id],
        ['%d']
    );
}

/**
 * Insert a new category
 *
 * @param array $args
 *
 * @return int|WP_Error
 */
function wd_event_insert_category($args = [])
{
    global $wpdb;

    if (empty($args['name'])) {
        return new \WP_Error('no-name', __('You must provide a name.', 'nas-academy'));
    }

    $defaults = [
        'name' => '',
        'event' => '',
        'created_by' => get_current_user_id(),
        'created_at' => current_time('mysql'),
    ];

    $data = wp_parse_args($args, $defaults);

    if (isset($data['id'])) {

        $id = $data['id'];
        unset($data['id']);

        $updated = $wpdb->update(
            $wpdb->prefix . 'nas_categories',
            $data,
            ['id' => $id],
            [
                '%s',
                '%s',
                '%d',
                '%s',
            ],
            ['%d']
        );

        return $updated;

    } else {

        $inserted = $wpdb->insert(
            $wpdb->prefix . 'nas_categories',
            $data,
            [
                '%s',
                '%d',
                '%d',
                '%s',
            ]
        );

        if (!$inserted) {
            return new \WP_Error('failed-to-insert', __('Failed to insert data', 'nas-academy'));
        }
    }

    return $wpdb->insert_id;
}

/**
 * Fetch Categories
 *
 * @param $args
 *
 * @return array
 */

function wd_get_categories($args = [])
{
    global $wpdb;

    $defaults = [
        'number' => 20,
        'offset' => 0,
        'orderby' => 'id',
        'order' => 'ASC',
    ];

    $args = wp_parse_args($args, $defaults);

    $items = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT {$wpdb->prefix}nas_events.name AS event_name,
            {$wpdb->prefix}nas_categories.id,
            {$wpdb->prefix}nas_categories.name ,
            {$wpdb->prefix}nas_categories.created_at
            FROM {$wpdb->prefix}nas_categories
            INNER JOIN  {$wpdb->prefix}nas_events
            ON  {$wpdb->prefix}nas_categories.event = {$wpdb->prefix}nas_events.id
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'],
            $args['number'],
        )
    );

    return $items;
}

/**
 * Fetch a single contact form the DB
 *
 * @param int $id
 *
 * @return object
 */
function wd_get_category($id)
{
    global $wpdb;
    return $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM {$wpdb->prefix}nas_categories WHERE id = %d", $id)
    );
}

/**
 * Delete Category
 *
 * @param int $id
 *
 * @return int|boolean
 */

function wd_delete_category($id)
{
    global $wpdb;
    return $wpdb->delete(
        $wpdb->prefix . 'nas_categories',
        ['id' => $id],
        ['%d']
    );
}

/**
 * Get the count of total categories
 *
 * @return int
 */
function wd_categories_count()
{
    global $wpdb;
    return (int) $wpdb->get_var("SELECT count(id) FROM {$wpdb->prefix}nas_categories");
}

/**
 *  Submit Participator form
 * 
 * @return string
 */

function submit_participator()
{
    global $wpdb;
    $errors = false;
    $table_name = $wpdb->prefix . "nas_event_participators";

    parse_str($_REQUEST['formData'], $event_data);

    $guardian_name = sanitize_text_field($event_data['guardianName']);
    $email = sanitize_email($event_data['email']);
    $args = [
        'event' => sanitize_text_field($event_data['event']),
        'category' => sanitize_text_field($event_data['category']),
        'guardian_name' => (!empty($guardian_name)) ? $guardian_name : NULL,
        'email' => (!empty($email)) ? $email : NULL,
        'name' => sanitize_text_field($event_data['name']),
        'phone' => str_replace('-', '', sanitize_text_field($event_data['phone'])),
        'address' => sanitize_textarea_field($event_data['address']),
    ];

    // start photo validate

    // check_ajax_referer('uploadingFile', 'security');

    // removing white space
    $fileName = preg_replace('/\s+/', '-', $_FILES["file"]["name"]);

    // removing special character but keep . character because . seprate to extantion of file
    $fileName = preg_replace('/[^A-Za-z0-9.\-]/', '', $fileName);

    // rename file using time & phone
    $fileName = $event_data['phone'] . '-' . time() . '-' . $fileName;

    $arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/bmp', 'image/tiff');

    // end photo validate

    if (in_array($_FILES['file']['type'], $arr_img_ext)) {
        $upload = wp_upload_bits($fileName, null, file_get_contents($_FILES["file"]["tmp_name"]));
        //$upload['url'] will gives you uploaded file path
        if ($upload['url']) {

            $defaults = [
                'event' => '',
                'category' => '',
                'guardian_name' => '',
                'email' => '',
                'name' => '',
                'phone' => '',
                'address' => '',
                'file_src' => $upload['url'],
                'file_name' => $fileName,
                'created_at' => current_time('mysql'),
            ];

            $data = wp_parse_args($args, $defaults);

            $inserted = $wpdb->insert(
                $table_name,
                $data,
                [
                    '%d',
                    '%d',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                ]
            );

            if (!$inserted) {
                // return new \WP_Error('failed-to-insert', __('Failed to insert data', 'nas-academy'));
                $errors = 'failed';
            }

        } else {
            $errors = 'image-failed';
        }

    } else {
        $errors = 'not-image';
    }

    if ($errors != false) {
        echo $errors;
    } else {
        echo 'submitted';
    }

    wp_die();
}

/**
 * Fetch Event for Submit form
 *
 * @return array
 */

function wd_frontend_fetch_event()
{
    global $wpdb;
    $event_result = [];
    $event_result['empty'] = 'Select Event';
    // $events[0] = 'Select Event';
    $table_name = $wpdb->prefix . 'nas_events';
    $events = $wpdb->get_results("SELECT * FROM $table_name");

    if (!empty($events)) {
        foreach ($events as $row) {
            $event_result[$row->id] = $row->name;
        }
    }

    return $event_result;
}


/**
 * Fetch Participators
 *
 * @param $args
 *
 * @return array
 */


function wd_get_participators($args = [])
{
    global $wpdb;

    $defaults = [
        'number' => 20,
        'offset' => 0,
        'orderby' => 'id',
        'order' => 'ASC',
    ];

    $args = wp_parse_args($args, $defaults);
    
   $current_event  = !empty(get_option('nas_current_event_id')) ? get_option('nas_current_event_id') : false;
   
    if($current_event){
        $data = "WHERE {$wpdb->prefix}nas_event_participators.event = '$current_event'";
    } else{
        $data = "-- no option";
    }
    
    
    $items = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT {$wpdb->prefix}nas_events.name AS event_name,
                   {$wpdb->prefix}nas_categories.name AS category_name ,
                   {$wpdb->prefix}nas_event_participators.id,
                   {$wpdb->prefix}nas_event_participators.file_src,
                   {$wpdb->prefix}nas_event_participators.guardian_name,
                   {$wpdb->prefix}nas_event_participators.name,
                   {$wpdb->prefix}nas_event_participators.email,
                   {$wpdb->prefix}nas_event_participators.phone,
                   {$wpdb->prefix}nas_event_participators.address,
                   {$wpdb->prefix}nas_event_participators.created_at
                   FROM {$wpdb->prefix}nas_event_participators
                   INNER JOIN {$wpdb->prefix}nas_events
                   ON {$wpdb->prefix}nas_event_participators.`event` = {$wpdb->prefix}nas_events.id
                   INNER JOIN {$wpdb->prefix}nas_categories
                   ON {$wpdb->prefix}nas_event_participators.category = {$wpdb->prefix}nas_categories.id
            
            $data  
            
            ORDER BY {$args['orderby']} {$args['order']} 
            LIMIT %d, %d",
            $args['offset'],
            $args['number'],
        )
    );

    return $items;
}


/**
 * Get the count of total participators
 *
 * @return int
 */
function wd_participators_count()
{
    global $wpdb;

    $current_event  = !empty(get_option('nas_current_event_id')) ? get_option('nas_current_event_id') : false;
   
    if($current_event){
        $data = "WHERE {$wpdb->prefix}nas_event_participators.event = '$current_event'";
    } else{
        $data = "-- no option";
    }
    

    return (int) $wpdb->get_var("SELECT count(id) FROM {$wpdb->prefix}nas_event_participators $data");
}

/**
 * Delete Participator
 *
 * @param int $id
 *
 * @return int|boolean
 */

function wd_delete_participator($id)
{
    global $wpdb;
    return $wpdb->delete(
        $wpdb->prefix . 'nas_event_participators',
        ['id' => $id],
        ['%d']
    );
}

/**
 * Fetch Duplicate Entry
 *
 * @param $args
 *
 * @return array
 */

function wd_get_duplicate_entry($args = [])
{
    global $wpdb;

    $defaults = [
        'number' => 20,
        'offset' => 0,
        'orderby' => 'id',
        'order' => 'ASC',
    ];

    $args = wp_parse_args($args, $defaults);
    
    $current_event  = !empty(get_option('nas_current_event_id')) ? get_option('nas_current_event_id') : false;
   
    if($current_event){
        $data = "WHERE {$wpdb->prefix}nas_event_participators.event = '$current_event'";
    } else{
        $data = "-- no option";
    }

    $items = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT {$wpdb->prefix}nas_event_participators.*, 
                    {$wpdb->prefix}nas_events.name AS event_name, 
                    {$wpdb->prefix}nas_categories.name AS category_name
                    FROM {$wpdb->prefix}nas_event_participators
                    INNER JOIN {$wpdb->prefix}nas_events
                    ON {$wpdb->prefix}nas_event_participators.`event` = {$wpdb->prefix}nas_events.id
                    INNER JOIN {$wpdb->prefix}nas_categories
                    ON {$wpdb->prefix}nas_event_participators.category = {$wpdb->prefix}nas_categories.id
                    
                    WHERE 
                    ( {$wpdb->prefix}nas_event_participators.phone in
                    (SELECT {$wpdb->prefix}nas_event_participators.phone FROM {$wpdb->prefix}nas_event_participators
                    GROUP BY {$wpdb->prefix}nas_event_participators.phone 
                    HAVING COUNT(*)>1) AND 
                    {$wpdb->prefix}nas_event_participators.name in
                    (SELECT {$wpdb->prefix}nas_event_participators.name FROM {$wpdb->prefix}nas_event_participators
                    GROUP BY {$wpdb->prefix}nas_event_participators.name 
                    HAVING COUNT(*)>1) )  
                     
       
                    ORDER BY {$args['orderby']} {$args['order']}
                    LIMIT %d, %d",
                    $args['offset'],
                    $args['number'],
        )
    );

    return $items;
}

/**
 * Get the count of total duplicate entry
 *
 * @return int
 */
function wd_duplicate_entry_count()
{
    global $wpdb;
    return (int) $wpdb->get_var("SELECT  COUNT({$wpdb->prefix}nas_event_participators.id)
    FROM {$wpdb->prefix}nas_event_participators
    
    WHERE 
                    ( {$wpdb->prefix}nas_event_participators.phone in
                    (SELECT {$wpdb->prefix}nas_event_participators.phone FROM {$wpdb->prefix}nas_event_participators
                    GROUP BY {$wpdb->prefix}nas_event_participators.phone 
                    HAVING COUNT(*)>1) AND 
                    {$wpdb->prefix}nas_event_participators.name in
                    (SELECT {$wpdb->prefix}nas_event_participators.name FROM {$wpdb->prefix}nas_event_participators
                    GROUP BY {$wpdb->prefix}nas_event_participators.name 
                    HAVING COUNT(*)>1) )");
}


/**
 * Fetch Rejected Participators 
 *
 * @param $args
 *
 * @return array
 */

function wd_get_rejected_participators($args = [])
{
    global $wpdb;

    $defaults = [
        'number' => 20,
        'offset' => 0,
        'orderby' => 'id',
        'order' => 'ASC',
    ];

    $args = wp_parse_args($args, $defaults);
    
$current_event  = !empty(get_option('nas_current_event_id')) ? get_option('nas_current_event_id') : false;
   
    if($current_event){
        $data = "AND {$wpdb->prefix}nas_event_participators.event = '$current_event'";
    } else{
        $data = "-- no option";
    }
    
    $items = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT {$wpdb->prefix}nas_events.name AS event_name,
                   {$wpdb->prefix}nas_categories.name AS category_name ,
                   {$wpdb->prefix}nas_event_participators.id,
                   {$wpdb->prefix}nas_event_participators.file_src,
                   {$wpdb->prefix}nas_event_participators.guardian_name,
                   {$wpdb->prefix}nas_event_participators.name,
                   {$wpdb->prefix}nas_event_participators.email,
                   {$wpdb->prefix}nas_event_participators.phone,
                   {$wpdb->prefix}nas_event_participators.address,
                   {$wpdb->prefix}nas_event_participators.created_at,
                   {$wpdb->prefix}nas_event_participators.rejected,
                   {$wpdb->prefix}users.display_name as rejected_by
                   FROM {$wpdb->prefix}nas_event_participators
                   INNER JOIN {$wpdb->prefix}nas_events
                   ON {$wpdb->prefix}nas_event_participators.`event` = {$wpdb->prefix}nas_events.id
                   INNER JOIN {$wpdb->prefix}nas_categories
                   ON {$wpdb->prefix}nas_event_participators.category = {$wpdb->prefix}nas_categories.id

                   INNER JOIN {$wpdb->prefix}users
                   ON {$wpdb->prefix}nas_event_participators.rejected_by = {$wpdb->prefix}users.id

                   WHERE {$wpdb->prefix}nas_event_participators.rejected = 'yes'
                       
                   $data

            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'],
            $args['number'],
        )
    );

    return $items;
}

/**
 * Get the count of total rejected participators
 *
 * @return int
 */
function wd_rejected_participators_count()
{
    global $wpdb;

    $current_event  = !empty(get_option('nas_current_event_id')) ? get_option('nas_current_event_id') : false;
   
    if($current_event){
        $data = "AND {$wpdb->prefix}nas_event_participators.event = '$current_event'";
    } else{
        $data = "-- no option";
    }
    

    return (int) $wpdb->get_var("SELECT count(id) FROM {$wpdb->prefix}nas_event_participators 
                                    WHERE {$wpdb->prefix}nas_event_participators.rejected = 'yes' $data ");
}



/**
 * Send OTP to user
 * 
 *  
 * 
 * 
 */

function otp_sender()
{
    // echo 'ok'; wp_die();
    // print_r($_POST);

    $token = "86a55ae784ef5d145ddacb7af1998756";
  
    $to = isset($_POST['to']) ? $_POST['to'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    $to = str_replace('-', '', sanitize_text_field($to));

    $url = "http://api.greenweb.com.bd/api.php?json";

// Generate Random 5 digits otp

    // $code = substr(md5(mt_rand()), 0, 5);
//send otp to mobile via api

    // $to = preg_replace("|[^0-9 \+\/]|", '', $to);
//message text

    // $message = "Your otp is $code . Use it ASAP. Your Company Name";
    $message = $message;
    $url = "http://api.greenweb.com.bd/api.php";

    $data = array(

        'to' => "$to",

        'message' => "$message",

        'token' => "$token",

    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_ENCODING, '');

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $smsresult = curl_exec($ch);

    $result = mb_substr($smsresult, 0, 2);
 
    if ($result == 'Ok') {

        echo 'ok';

    }else{
        echo 'failed';
    }
    wp_die();
}


function wd_fetch_participator_by_event()
{
    
    $event_id = isset( $_POST['event'] ) ?  $_POST['event'] : 0; 
    global $wpdb;
    $table_name = $wpdb->prefix . 'nas_event_participators';
    $participator = $wpdb->get_results("SELECT * FROM $table_name WHERE event = '$event_id'");
        $to = '';
        foreach ($participator as $row) {
            $number = $row->phone;
	        $to = "$number, $to";
        }

    echo $to;
 
    wp_die();
}


/**
 * Fetch a single item for review
 *
 * @param int $id
 *
 * @return object
 */
function wd_get_item_for_review($id)
{
    global $wpdb;
    
    $current_event  = !empty(get_option('nas_current_event_id')) ? get_option('nas_current_event_id') : false;
   
    if($current_event){
        $data = "AND {$wpdb->prefix}nas_event_participators.event = '$current_event'";
    } else{
        $data = "-- no option";
    }
    
    
    return $wpdb->get_row(
         
        // - id and category in digit, but working well
        // $wpdb->prepare("SELECT * FROM {$wpdb->prefix}nas_event_participators 
        // WHERE id NOT IN (SELECT participator_id FROM {$wpdb->prefix}nas_ratings WHERE rating_by = %d) 
        // LIMIT 1;  ", $id)


        $wpdb->prepare("SELECT  {$wpdb->prefix}nas_events.name AS event_name,
        {$wpdb->prefix}nas_categories.name AS category_name ,
        {$wpdb->prefix}nas_event_participators.id,
        {$wpdb->prefix}nas_event_participators.file_src,
        {$wpdb->prefix}nas_event_participators.phone,
        {$wpdb->prefix}nas_event_participators.created_at,
        {$wpdb->prefix}nas_event_participators.rejected
        FROM {$wpdb->prefix}nas_event_participators
        INNER JOIN {$wpdb->prefix}nas_events
        ON {$wpdb->prefix}nas_event_participators.`event` = {$wpdb->prefix}nas_events.id
        INNER JOIN {$wpdb->prefix}nas_categories
        ON {$wpdb->prefix}nas_event_participators.category = {$wpdb->prefix}nas_categories.id 
        WHERE ({$wpdb->prefix}nas_event_participators.id 
        NOT IN (SELECT participator_id FROM {$wpdb->prefix}nas_ratings WHERE rating_by = %d)) 
        AND ({$wpdb->prefix}nas_event_participators.rejected IS NULL) 
        $data 
        ORDER BY RAND() LIMIT 1;  ", $id)
    );
}
 

/**
 * Fetch  left items for review
 *
 * @param int $id
 *
 * @return object
 */
function wd_items_left_for_review($id)
{
    global $wpdb;
    
    $current_event  = !empty(get_option('nas_current_event_id')) ? get_option('nas_current_event_id') : false;
   
    if($current_event){
        $data = "AND {$wpdb->prefix}nas_event_participators.event = '$current_event'";
    } else{
        $data = "-- no option";
    }
    
    return $wpdb->get_row(
         
        $wpdb->prepare("SELECT COUNT(*) as total_items FROM {$wpdb->prefix}nas_event_participators 
        WHERE id NOT IN (SELECT participator_id FROM {$wpdb->prefix}nas_ratings WHERE rating_by = %d) 
        AND {$wpdb->prefix}nas_event_participators.rejected IS NULL 
            $data
        ", $id)

    );
}

/**
 * Fetch total reviewed items by reviewer
 *
 * @param int $id
 *
 * @return object
 */
function wd_items_reviewed($id)
{
    global $wpdb;
    
    $current_event  = !empty(get_option('nas_current_event_id')) ? get_option('nas_current_event_id') : false;
   
    if($current_event){
        $data = "AND {$wpdb->prefix}nas_event_participators.event = '$current_event'";
    } else{
        $data = "-- no option";
    }
    
    return $wpdb->get_row(
         
        $wpdb->prepare("SELECT COUNT(*) as total_items FROM {$wpdb->prefix}nas_event_participators 
        WHERE id IN (SELECT participator_id FROM {$wpdb->prefix}nas_ratings WHERE rating_by = %d) 
        AND {$wpdb->prefix}nas_event_participators.rejected IS NULL 
            $data
        ", $id)

    );
}


/**
 * Insert a new rating
 *
 * @param array $args
 *
 * @return int|WP_Error
 */
function wd_insert_rating($args = [])
{
    
    global $wpdb;

    if (empty($args['participator_id'])) {
        return new \WP_Error('no-name', __('Are you cheating?', 'nas-academy'));
    } 
    if (empty($args['rating'])) {
        return new \WP_Error('no-rating', __('You must provide a rating.', 'nas-academy'));
    }

     

    $check_exists = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM {$wpdb->prefix}nas_ratings WHERE participator_id = %d AND rating_by = %d", $args['participator_id'], get_current_user_id())
    );


    if($check_exists){
        return new \WP_Error('no-name', __('Are you cheating?', 'nas-academy'));
    }

    $defaults = [
        'participator_id' => '',
        'rating' => '',
        'rating_by' => get_current_user_id(),
    ];

    $data = wp_parse_args($args, $defaults);

    $inserted = $wpdb->insert(
        $wpdb->prefix . 'nas_ratings',
        $data,
        [
            '%d',
            '%d',
            '%s',
        ]
    );

    if (!$inserted) {
        return new \WP_Error('failed-to-insert', __('Failed to insert rating', 'nas-academy'));
    }

    return $wpdb->insert_id;
}



/**
 * Fetch Results
 *
 * @param $args
 *
 * @return array
 */

function wd_get_results($args = [])
{
    global $wpdb;

    $defaults = [
        'number' => 20,
        'offset' => 0,
        'orderby' => 'rating_number',
        'order' => 'DESC',
    ];

    $args = wp_parse_args($args, $defaults);
    
    $current_event  = !empty(get_option('nas_current_event_id')) ? get_option('nas_current_event_id') : false;
    
     if($current_event){
        $data = "AND {$wpdb->prefix}nas_event_participators.event = '$current_event'";
    } else{
        $data = "-- no option";
    }

    $items = $wpdb->get_results(
        // below sql working well
        // $wpdb->prepare(
        //     "SELECT {$wpdb->prefix}nas_ratings.participator_id, SUM({$wpdb->prefix}nas_ratings.rating) AS rating_number, 
        //     {$wpdb->prefix}nas_event_participators.name, {$wpdb->prefix}nas_event_participators.phone, {$wpdb->prefix}nas_event_participators.file_src,  COUNT(*) AS total_review FROM {$wpdb->prefix}nas_ratings
        //     INNER JOIN {$wpdb->prefix}nas_event_participators on 
        //     {$wpdb->prefix}nas_ratings.participator_id = {$wpdb->prefix}nas_event_participators.id 
        //     GROUP BY {$wpdb->prefix}nas_ratings.participator_id
        //     ORDER BY {$args['orderby']} {$args['order']}
        //     LIMIT %d, %d",
        //     $args['offset'],
        //     $args['number'],
        // )  
        $wpdb->prepare(
            "SELECT {$wpdb->prefix}nas_ratings.participator_id, SUM({$wpdb->prefix}nas_ratings.rating) AS rating_number, 
            {$wpdb->prefix}nas_event_participators.name, 
            {$wpdb->prefix}nas_event_participators.guardian_name, 
            {$wpdb->prefix}nas_event_participators.email, 
            {$wpdb->prefix}nas_event_participators.file_src, 
            {$wpdb->prefix}nas_event_participators.address, 
            {$wpdb->prefix}nas_event_participators.event, {$wpdb->prefix}nas_event_participators.phone, {$wpdb->prefix}nas_events.name as event_name, {$wpdb->prefix}nas_categories.name as category_name,   COUNT(*) AS total_review FROM {$wpdb->prefix}nas_ratings
            
            INNER JOIN {$wpdb->prefix}nas_event_participators on {$wpdb->prefix}nas_ratings.participator_id = {$wpdb->prefix}nas_event_participators.id 
            
            
            INNER JOIN {$wpdb->prefix}nas_events
                    ON {$wpdb->prefix}nas_event_participators.`event` = {$wpdb->prefix}nas_events.id  
                    
            INNER JOIN {$wpdb->prefix}nas_categories
                    ON {$wpdb->prefix}nas_event_participators.`category` = {$wpdb->prefix}nas_categories.id  
            
            WHERE {$wpdb->prefix}nas_event_participators.rejected IS NULL
                
            $data

            GROUP BY {$wpdb->prefix}nas_ratings.participator_id
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'],
            $args['number'],
        )
    );

    return $items;
}

/**
 * Get the count of total Results
 *
 * @return int
 */
function wd_results_count()
{
    global $wpdb;
    // return (int) $wpdb->get_var("SELECT count(id) FROM {$wpdb->prefix}nas_events");
    // return (int) $wpdb->get_var(
    //     "SELECT COUNT(*) FROM (SELECT  participator_id  FROM {$wpdb->prefix}nas_ratings  GROUP BY participator_id) AS id "
    // ); 


      $current_event  = !empty(get_option('nas_current_event_id')) ? get_option('nas_current_event_id') : false;
   
    if($current_event){
        $data = " {$wpdb->prefix}nas_event_participators.event = '$current_event'";
    } else{
        $data = "-- no option";
    }
    

    return (int) $wpdb->get_var(
        "SELECT COUNT(*) FROM (SELECT  participator_id  FROM {$wpdb->prefix}nas_ratings INNER JOIN {$wpdb->prefix}nas_event_participators on 
        {$wpdb->prefix}nas_ratings.participator_id = {$wpdb->prefix}nas_event_participators.id 
		  WHERE $data AND {$wpdb->prefix}nas_event_participators.rejected is NULL GROUP BY participator_id )  AS id "
    );
}

 /**
 * Reject Participator
 *
 *
 * @return string
 */

function wd_reject_participator()
{
    parse_str($_REQUEST['formData'], $event_data);

    $id= intval($event_data['participatorId']);
    global $wpdb;
    // $deleted = $wpdb->delete(
    //     $wpdb->prefix . 'nas_event_participators',
    //     ['id' => $id],
    //     ['%d']
    // );

    $defaults = [
        'rejected' => 'yes',
        'rejected_by' => get_current_user_id()
    ];
    $args = [
        'rejected' => 'yes',
        'rejected_by' => get_current_user_id()
    ];
    $data = wp_parse_args($args, $defaults);

    $updated = $wpdb->update(
        $wpdb->prefix . 'nas_event_participators',
        $data,
        ['id' => $id],
        [
            '%s',
            '%d',
        ],
        ['%d']
    );


    if($updated){
        echo 'deleted';
    }else{
        echo 'failed';
    }
    wp_die();
}


 /**
 * Reject Participator
 *
 *
 * @return string
 */

function wd_reject_restore()
{

    $id= intval($_POST['participatorId']);
    global $wpdb;

    $defaults = [
        'rejected' => NULL,
        'rejected_by' => NULL,
    ];
    $args = [
        'rejected' => NULL,
        'rejected_by' => NULL,
    ];
    $data = wp_parse_args($args, $defaults);

    $updated = $wpdb->update(
        $wpdb->prefix . 'nas_event_participators',
        $data,
        ['id' => $id],
        [
            '%s',
            '%s',
        ],
        ['%d']
    );


    if($updated){
        echo 'restore';
    }else{
        echo 'failed';
    }
    wp_die();
}


/**
 * Fetch participator by event
 * 
 * @param int
 * 
 * @return array
 */
function wd_frontend_fetch_participator_by_event($event_id){
    global $wpdb;
    $items = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT {$wpdb->prefix}nas_events.name AS event_name,
            {$wpdb->prefix}nas_categories.name AS category_name ,
            {$wpdb->prefix}nas_event_participators.id,
            {$wpdb->prefix}nas_event_participators.name,
            {$wpdb->prefix}nas_event_participators.phone,
            {$wpdb->prefix}nas_event_participators.address
            FROM {$wpdb->prefix}nas_event_participators
            INNER JOIN {$wpdb->prefix}nas_events
            ON {$wpdb->prefix}nas_event_participators.`event` = {$wpdb->prefix}nas_events.id
            INNER JOIN {$wpdb->prefix}nas_categories
            ON {$wpdb->prefix}nas_event_participators.category = {$wpdb->prefix}nas_categories.id
            WHERE {$wpdb->prefix}nas_event_participators.event = '%s'
            ORDER BY  {$wpdb->prefix}nas_event_participators.id DESC",
                $event_id
        )
    );

    return $items;
}

/**
 * Phone Number masking
 * @param int|string
 * 
 * @return int|string
 */
 function stringToSecret(string $string = NULL){
    if (!$string) {
        return NULL;
    }
    $length = strlen($string);
    $visibleCount = (int) round($length / 4);
    $hiddenCount = $length - ($visibleCount * 2);
    return substr($string, 0, $visibleCount) . str_repeat('x', $hiddenCount) . substr($string, ($visibleCount * -1), $visibleCount);
}


