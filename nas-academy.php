<?php

/**
 * Plugin Name: NAS Drawing Academy
 * Description: A simple description of our plguin
 * Plugin URI: https://nasdrawing.com/
 * Author: bdthemes.com
 * Author URI: https://nasdrawing.com/
 * Version: 1.0
 * License: GPL2
 * Text Domain: nas-academy
 */
/**
 * Copyright (c) 2014 Shahidul Islam (email: bdkoder@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */
// don't call the file directly
if (!defined('ABSPATH'))
    exit;

require_once __DIR__ . '/vendor/autoload.php';
if (did_action('elementor/loaded')) {
    require_once('plugin.php');
}


/**
 * The main plugins class
 */
final class Nas_Academy
{

    /**
     * Plugin version
     * @var string
     */
    const version = '1.0';

    /**
     * class constructor
     */
    private function __construct()
    {
        $this->define_constants();

        register_activation_hook(__FILE__, [$this, 'activate']);

        add_action('plugins_loaded', [$this, 'init_plugin']);

        

    }
  

    /**
     * Initializes a singleton instance
     * @staticvar boolean $instance
     * @return \Nas_Academy
     */
    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     * 
     * @return void
     */
    public function define_constants()
    {
        define('NAS_ACADEMY_VERSION', self::version);
        define('NAS_ACADEMY_FILE', __FILE__);
        define('NAS_ACADEMY_PATH', __DIR__);
        define('NAS_ACADEMY_URL', plugins_url('', NAS_ACADEMY_FILE));
        define('NAS_ACADEMY_ASSETS', NAS_ACADEMY_URL . '/assets');
    }

    /**
     * Initialize the plugin
     * 
     * @return void
     */
    public function init_plugin()
    {

        if (is_admin()) {
            new Nas\Academy\Admin();
        } else {
            // new for frontEnd
            new Nas\Academy\Frontend();
        }
        
    }

    /**
     * Do stuff upon plugin
     * 
     * @return void
     */
    public function activate()
    {
       $installer = new Nas\Academy\Installer();
       $installer->run();
    }
}

/**
 * 
 * @return \Nas_Academy
 */
function nas_academy()
{
    return Nas_Academy::init();
}

// kick-off the plugin
nas_academy();


 ?>
<?php

/**
 * Registers a setting.
 */
function wpdocs_register_my_setting() {
    register_setting( 'nas_options_group', 'nas_current_event_id' );
} 
add_action( 'admin_init', 'wpdocs_register_my_setting' );


 