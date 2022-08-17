<?php

namespace Nas\Academy;

/**
 * The Installer class
 */
class Installer
{
    /**
     * Runt the installer
     * 
     * @return void
     */

    public function run()
    {
        $this->add_version();
        $this->create_tables();
    }

    public function add_version()
    {
        $installed = get_option('nas_academy_installed');

        if (!$installed) {
            update_option('nas_academy_installed', time());
        }

        update_option('nas_academy_version', NAS_ACADEMY_VERSION);
    }

    /**
     * Create nessary database tables
     * 
     * @return void
     */
    public function create_tables()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}nas_events` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NULL DEFAULT NULL,
            `date` DATETIME NULL DEFAULT NULL,
            `created_by` BIGINT(20) UNSIGNED NOT NULL,
            `created_at` DATETIME NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate";

        $schema2 = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}nas_categories` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `event` INT NOT NULL,
            `created_by` BIGINT(20) UNSIGNED NOT NULL,
            `created_at` DATETIME NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate";

        $schema3 = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}nas_event_participators` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `event` INT NOT NULL,
            `category` INT NOT NULL,
            `guardian_name` VARCHAR(255) NULL DEFAULT NULL,
            `email` VARCHAR(255) NULL DEFAULT NULL,
            `name` VARCHAR(255) NULL DEFAULT NULL,
            `phone` VARCHAR(255) NULL DEFAULT NULL,
            `address` MEDIUMTEXT NULL DEFAULT NULL,
            `file_src` MEDIUMTEXT NULL DEFAULT NULL,
            `file_name` MEDIUMTEXT NULL DEFAULT NULL,
            `created_at` DATETIME NOT NULL,
            `rejected` VARCHAR(20) NULL DEFAULT NULL,
            `rejected_by` BIGINT(20) NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate";


        $schema4 = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}nas_ratings` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `participator_id` INT NOT NULL,
            `rating` INT NOT NULL,
            `rating_by` BIGINT(20) NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate";

        if ( !function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta( $schema );
        dbDelta( $schema2 );
        dbDelta( $schema3 );
        dbDelta( $schema4 );
    }
}
 