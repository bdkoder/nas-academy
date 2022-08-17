<?php
/**
 * @package AlecadddPlugin
 */
namespace Inc\Base;

class BaseController{
	 
	 public $plugin_path;

	 public $plugin_url;
	 
	 public $plugin;

	 public $managers = array();

	 public function __construct(){

	 	$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );

	 	$this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
	 	
	 	$this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/alecaddd-plugin.php';

	 	$this->managers = array(
	 		// 'cpt_manager' => 'Activate CPT Manager', 
	 		// 'taxonomy_manager' => 'Activate Taxonomy Manager',
	 		// 'media_widget' => 'Activate Media Widget',
	 		// 'gallery_manager' => 'Activate Gallery Manager',
	 		// 'testimonial_manager' => 'Activate Testimonial Manager',
	 		// 'templates_manager' => 'Activate Templates Manager',
	 		// 'login_manager' => 'Activate Login Manager',
	 		// 'membership_manager' => 'Activate Membership Manager',
	 		// 'chat_manager' => 'Activate Chat Manager'

	 		// test for sky 

	 		'accordion' => [
                    'name'         => 'accordion',
                    // 'label'        => esc_html__('Accordion', 'bdthemes-element-pack'),
                    // 'type'         => 'checkbox',
                    'default'      => "off",
                    // 'widget_type'  => 'free',
                    // 'content_type' => 'custom',
                    // 'demo_url'     => 'https://elementpack.pro/demo/element/accordion/',
                    // 'video_url'    => 'https://youtu.be/DP3XNV1FEk0',

                ],

            'card' => [
                    'name'         => 'Card',
                    // 'label'        => esc_html__('Accordion', 'bdthemes-element-pack'),
                    // 'type'         => 'checkbox',
                    'default'      => "on",
                    // 'widget_type'  => 'free',
                    // 'content_type' => 'custom',
                    // 'demo_url'     => 'https://elementpack.pro/demo/element/accordion/',
                    // 'video_url'    => 'https://youtu.be/DP3XNV1FEk0',

                ],

	 	);

	 }

}

 
